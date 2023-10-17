<?php
class Pages extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('page/page_m');
        $this->load->model('setting/language_m');
        $this->load->model('setting/setting_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'page/Pages')) {
            $this->data['subview'] = 'admin/page/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'page_m',
            'sIndexColumn'        => 'page_id',
            'table_name'          => 'page',
            'table_join_name'     => 'page_description',
            'table_join_col_name' => 'title',
            'where_options'       => array('page_description.language_code' => $this->data['language_code']),
            'search_col_name'     => 'title',
            'aColumns'            => array('page_id', 'title', 'sort_order', 'status', 'page_id')
        );

        $query = $this->datatable->index($config);
        $this->output->set_output(json_encode($query));
    }

    public function edit($id = NULL)
    {
        $this->data['languages'] = $this->language_m->get_active();
        $this->data['pages']     = $this->page_m->get_pages();

        // Button and publish permission
        if ($this->validate_publish_page('page/Pages')) {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_save');
            $this->data['publish_permission'] = TRUE;
        } else {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_send_to_editor');
            $this->data['publish_permission'] = FALSE;
        }

        // Fetch a page or set a new one
        if ($id) {
            $result = $this->page_m->get_pages($id);
            if ($result) {
                if ($result['page_data']['image']) {
                    $image_path = base_url($result['page_data']['image']);
                } else {
                    $image_path = base_url('uploads/images/default/default-thumbnail.png');
                }

                $page_data = array();
                $page_data = $result;
                $page_data['page_data']['image_path'] = $image_path;

                foreach ($this->data['languages'] as $key => $value) {
                    if (isset($page_data['page_desc']) && isset($page_data['page_desc'][$value['language_code']])) {
                        $page_data['page_desc'][$value['language_code']] = $page_data['page_desc'][$value['language_code']];
                    } else {
                        $page_data['page_desc'][$value['language_code']] = array(
                            'title'       => '',
                            'description' => ''
                        );
                    }
                }

                // Galer gambar
                foreach ($result['page_image'] as $key => $gambar) {
                    if ($gambar['image'] === '' || $gambar['image'] === NULL) {
                        $galeri_gambar = base_url('uploads/images/default/default-thumbnail.png');
                    } else {
                        $galeri_gambar = base_url($gambar['image']);
                    }

                    $page_data['page_image'][$key] = $gambar;
                    $page_data['page_image'][$key]['image'] = $galeri_gambar;
                    $page_data['page_image'][$key]['image_path'] = $gambar['image'];
                }

                $this->data['page'] = $page_data;
            } else {
                $this->data['page'] = $this->page_m->get_new_page();
            }
        } else {
            $this->data['page'] = $this->page_m->get_new_page();
        }

        // Set up the form
        foreach ($this->data['languages'] as $language) {
            $this->form_validation->set_rules("page_desc[$language[language_code]][title]", 'Title', 'trim|required|max_length[255]');
        }

        // Process the form
        if ($this->form_validation->run() == TRUE && $this->validate_modify_page('page/Pages')) {
            $data = $this->input->post();
            if ($this->validate_publish_page('page/Pages')) {
                $data['page_data']['status'] = $this->input->post('page_data[status]');
            } else {
                $data['page_data']['status'] = 0;
            }

            $this->page_m->save_page($data, $id);
            redirect('admin/page/pages');
        }

        // Load the view
        if ($this->user_m->hasPermission('access', 'page/Pages')) {
            $this->data['subview'] = 'admin/page/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('publish', 'page/Pages')) {
            if ($status == 'true') {
                if ($this->page_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->page_m->update_status($id, 0)) {
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
        if ($this->validate_delete_page('page/Pages')) {
            if ($id) {
                $this->page_m->delete_page($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/page/pages');
            } else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->page_m->delete_page($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/page/pages');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/page/pages');
                }
            }
        }
    }

    // Validate
    public function validate_modify_page($controller = NULL)
    {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_publish_page($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_delete_page($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}
