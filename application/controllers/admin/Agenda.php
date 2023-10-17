<?php
class Agenda extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('agenda/agenda_m');
        $this->load->model('setting/language_m');
        $this->load->model('setting/setting_m');
    }

    public function index()
    {
        $this->data['title'] = 'Agenda';
        $this->data['const'] = 'agenda';
        if ($this->user_m->hasPermission('access', 'Agenda')) {
            $this->data['subview'] = 'admin/agenda/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'agenda_m',
            'sIndexColumn'        => 'agenda_id',
            'table_name'          => 'agenda',
            'table_join_name'     => 'agenda_description',
            'table_join_col_name' => NULL,
            'where_options'       => array('agenda_description.language_code' => $this->data['language_code']),
            'search_col_name'     => 'description',
            'aColumns'            => array('agenda_id', 'description', 'date_begin', 'time', 'status', 'agenda_id')
        );

        $query = $this->datatable->index($config);

        $rResult['aaData'] = array();
        if (!empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array(
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => long_date('D, j M Y', $value[2], $this->data['language_code']),
                    '3' => $value[3],
                    '4' => $value[4],
                    '5' => $value[5]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }


    public function edit($id = NULL)
    {
        $this->data['languages'] = $this->language_m->get_active();
        $this->data['agendas']   = $this->agenda_m->get_agendas();

        // Button and publish permission
        if ($this->validate_publish_agenda('Agenda')) {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_save');
            $this->data['publish_permission'] = TRUE;
        } else {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_send_to_editor');
            $this->data['publish_permission'] = FALSE;
        }

        // Fetch a agenda or set a new one
        if ($id) {
            $result = $this->agenda_m->get_agendas($id);
            if ($result) {
                $agenda_data = array();
                $agenda_data = $result;

                foreach ($this->data['languages'] as $key => $value) {
                    if (isset($agenda_data['agenda_desc']) && isset($agenda_data['agenda_desc'][$value['language_code']])) {
                        $agenda_data['agenda_desc'][$value['language_code']] = $agenda_data['agenda_desc'][$value['language_code']];
                    } else {
                        $agenda_data['agenda_desc'][$value['language_code']] = array(
                            'title'       => '',
                            'description' => ''
                        );
                    }
                }

                $this->data['agenda'] = $agenda_data;
            } else {
                $this->data['agenda'] = $this->agenda_m->get_new_agenda();
            }
        } else {
            $this->data['agenda'] = $this->agenda_m->get_new_agenda();
        }

        // Set up the form
        foreach ($this->data['languages'] as $language) {
            $this->form_validation->set_rules("agenda_desc[$language[language_code]][description]", 'Description', 'trim|required|max_length[255]');
        }

        // Process the form
        if ($this->form_validation->run() == TRUE && $this->validate_modify_agenda('Agenda')) {
            $data = $this->input->post();
            if ($this->validate_publish_agenda('Agenda')) {
                $data['agenda_data']['status'] = $this->input->post('agenda_data[status]');
            } else {
                $data['agenda_data']['status'] = 0;
            }

            $this->agenda_m->save_agenda($data, $id);
            redirect('admin/agenda');
        }

        // Load the view
        if ($this->user_m->hasPermission('access', 'Agenda')) {
            $this->data['subview'] = 'admin/agenda/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('publish', 'Agenda')) {
            if ($status == 'true') {
                if ($this->agenda_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->agenda_m->update_status($id, 0)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            }
        } else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }

    public function delete($id = NULL)
    {
        if ($this->validate_delete_agenda('Agenda')) {
            if ($id) {
                $this->agenda_m->delete_agenda($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/agenda');
            } else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->agenda_m->delete_agenda($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/agenda');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/agenda');
                }
            }
        }
    }

    // Validate
    public function validate_modify_agenda($controller = NULL)
    {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_publish_agenda($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_delete_agenda($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}
