<?php
class Language extends Admin_controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('file');
    }

    public function index() {
        if ($this->user_m->hasPermission('access', 'localisation/Language')) {
            $this->data['subview'] = 'admin/localisation/language/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }
    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'language_m',
            'sIndexColumn'        => 'language_id',
            'table_name'          => 'language',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => array(),
            'search_col_name'     => 'name',
            'aColumns'            => array('language_id', 'name', 'language_code', 'image', 'sort_order', 'status', 'language_id')
        );

        $query = $this->datatable->index($config);

        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $value[2],
                    '3' => '<img src="'. ADMIN_ASSETS_URL .'images/flags/'. $value[3] .'" alt="">',
                    '4' => $value[4],
                    '5' => $value[5],
                    '6' => $value[6]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));

    }

    public function edit($id = NULL)
    {
        // Get language image
        $flags_result = glob_recursive(VIEWPATH . 'admin/assets/images/flags/' . '*', GLOB_BRACE);
        $this->data['flags'] = array();
        foreach ($flags_result as $image) {
            if (is_file($image)) {
                $result = get_file_info($image);

                if ($result) {
                    $this->data['flags'][] = $result['name'];
                }
            }
        }

        // Fetch a language or set a new one
        $result_language = $this->language_m->get();
        if ($id) {
            $result_language = $this->language_m->get_language($id);

            if ($result_language) {
                $this->data['languages'] = $result_language;
            } else {
                $this->data['languages'] = $this->language_m->get_new_language();
            }
        }
        else {
            $this->data['languages'] = $this->language_m->get_new_language();
        }
        // Set up the form
        $rules = $this->language_m->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE && $this->validate_modify('localisation/Language')) {
            $this->language_m->save_language($this->input->post(), $id);
            redirect('admin/localisation/language');
        }

        // Load the view
        if ($this->user_m->hasPermission('access', 'localisation/Language')) {
            $this->data['subview'] = 'admin/localisation/language/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function _unique_code($str)
    {
        // Do NOT validate if language code already exists
        // UNLESS it's the code for the current user
        $id = $this->uri->segment(5);
        $this->db->where('language_code', $this->input->post('language_code'));
        !$id || $this->db->where('language_id !=', $id);
        $language = $this->language_m->get();

        if (count($language)) {
            $this->form_validation->set_message('_unique_code', '%s sudah terdaftar!');
            return FALSE;
        }

        return TRUE;
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('modify', 'localisation/Language')) {
            if ($this->setting_m->get_setting('language_id') != $id) {
                if ($status == 'true') {
                    if ($this->language_m->update_status($id, 1)) {
                        $json['success'] = lang('status_update_success');
                        $this->output->set_output(json_encode($json));
                    }

                } elseif ($status == 'false') {
                    if ($this->language_m->update_status($id, 0)) {
                        $json['success'] = lang('status_update_success');
                        $this->output->set_output(json_encode($json));
                    }
                }
            } else {
                $this->output->set_output('error');
            }
        } else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }

    public function delete($id = NULL)
    {
        if ($this->validate_delete('localisation/Language')) {
            if ($id) {
                $this->language_m->delete_language($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/localisation/language');
            }
            else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->language_m->delete_language($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/localisation/language');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/localisation/language');
                }
            }
        }
    }

}