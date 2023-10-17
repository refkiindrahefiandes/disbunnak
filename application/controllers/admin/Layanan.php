<?php
class Layanan extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('layanan/layanan_m');
    }

    public function index()
    {
        $this->data['title'] = 'Layanan';
        $this->data['const'] = 'layanan';
        if ($this->user_m->hasPermission('access', 'Layanan')) {
            $this->data['subview'] = 'admin/layanan/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'layanan_m',
            'sIndexColumn'        => 'layanan_id',
            'table_name'          => 'layanan',
            'table_join_name'     => Null,
            'table_join_col_name' => NuLL,
            'where_options'       => Null,
            'search_col_name'     => 'title',
            'aColumns'            => array('layanan_id', 'title', 'sort_order', 'status', 'layanan_id')
        );

        $query = $this->datatable->index($config);
        $this->output->set_output(json_encode($query));
    }

    public function edit($id = Null)
    {
        $this->data['languages'] = $this->language_m->get_active();
        $this->data['layanan']   = $this->layanan_m->get_layanan();

        // Button and publish permission
        if ($this->validate_publish_service('Layanan')) {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_save');
            $this->data['publish_permission'] = TRUE;
        } else {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_send_to_editor');
            $this->data['publish_permission'] = FALSE;
        }

        // Fetch a layanan or set a new one
        if ($id) {
            $result = $this->layanan_m->get_layanan($id);

            if (is_array($result['layanan_data'])) {
                $this->data['layanan'] = $result;
            } else {
                $this->data['layanan'] = $this->layanan_m->get_new_layanan();
            }
        } else {
            $this->data['layanan'] = $this->layanan_m->get_new_layanan();
        }

        // Set up the form
        $this->form_validation->set_rules("layanan_data[title]", 'Title', 'trim|required|max_length[255]');

        // Process the form
        if ($this->form_validation->run() == TRUE && $this->validate_modify_service('Layanan')) {
            $data = $this->input->post();
            if ($this->validate_publish_service('Layanan')) {
                $data['layanan_data']['status'] = $this->input->post('layanan_data[status]');
            } else {
                $data['layanan_data']['status'] = 0;
            }

            $this->layanan_m->save_layanan($data, $id);
            $this->session->set_flashdata('success', lang('success_update_data'));
            redirect('admin/layanan');
        }

        // Load the view
        if ($this->user_m->hasPermission('access', 'Layanan')) {
            $this->data['subview'] = 'admin/layanan/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('publish', 'Layanan')) {
            if ($status == 'true') {
                if ($this->layanan_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->layanan_m->update_status($id, 0)) {
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
        if ($this->validate_delete_service('Layanan')) {
            if ($id) {
                $this->layanan_m->delete_service($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/layanan');
            } else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->layanan_m->delete_service($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/layanan');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/layanan');
                }
            }
        }
    }

    // Validate
    public function validate_modify_service($controller = NULL)
    {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_publish_service($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_delete_service($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}
