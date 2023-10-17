<?php
class Category extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog/blog_m');
        $this->load->model('blog/blog_category_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'blog/Blogs')) {
            $this->data['subview'] = 'admin/blog/category/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'blog_category_m',
            'sIndexColumn'        => 'term_id',
            'table_name'          => 'blog_term',
            'table_join_name'     => 'blog_term_description',
            'table_join_col_name' => 'name',
            'where_options'       => array('blog_term.term_type' => 'category', 'blog_term_description.language_code' => $this->data['language_code']),
            'search_col_name'     => 'name',
            'aColumns'            => array('term_id', 'name', 'sort_order', 'status', 'term_id')
        );

        $query = $this->datatable->index($config);
        $this->output->set_output(json_encode($query));
    }

    public function edit($id = NULL)
    {
		$this->data['categories']  = $this->blog_category_m->get_categories();

        // Button and publish permission
        if ($this->validate_publish_category('blog/Category')) {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_save');
            $this->data['publish_permission'] = TRUE;
        } else {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_send_to_editor');
            $this->data['publish_permission'] = FALSE;
        }

		// Fetch a category or set a new one
		if ($id) {
			$result = $this->blog_category_m->get_categories($id);
			if ($result) {
                foreach($this->data['languages'] as $key => $value){
                    if(isset($result['category_desc']) && isset($result['category_desc'][$value['language_code']]) ){
                        $result['category_desc'][$value['language_code']] = $result['category_desc'][$value['language_code']];
                    }else {
                        $result['category_desc'][$value['language_code']] = array(
                            'name'        => '',
                            'description' => ''
                        );
                    }
                }
				$this->data['category'] = $result;
			} else {
				$this->data['category'] = $this->blog_category_m->get_new_category();
			}
		}
		else {
			$this->data['category'] = $this->blog_category_m->get_new_category();
		}

        // printr($this->data['category']); die();

		// Set up the form
		foreach($this->data ['languages'] as $language) {
			$this->form_validation->set_rules("category_desc[$language[language_code]][name]", 'Name', 'trim|required|max_length[255]');
		}

		// Process the form
		if ($this->form_validation->run() == TRUE && $this->validate_modify('blog/Category')) {
			$data = $this->input->post();
			$data['category_data']['term_type'] = 'category';

            if ($this->validate_publish_category('blog/Category')) {
                $data['category_data']['status'] = $this->input->post('category_data[status]');
            } else {
                $data['category_data']['status'] = 0;
            }

			$this->blog_category_m->save_category($data, $id);
			redirect('admin/blog/category');
		}

        // Load the view
        if ($this->user_m->hasPermission('access', 'blog/Blogs')) {
            $this->data['subview'] = 'admin/blog/category/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

		$this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('publish', 'blog/Category')) {
            if ($status == 'true') {
                if ($this->blog_category_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->blog_category_m->update_status($id, 0)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            }
        }else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }

    public function delete($id = NULL)
    {
		if ($this->validate_delete_category('blog/Category')) {
            if ($id) {
                $this->blog_category_m->delete_category($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/blog/category');
            }
            else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->blog_category_m->delete_category($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/blog/category');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/blog/category');
                }
            }
        }
    }

    // Validate
    public function validate_modify_category($controller = NULL) {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_publish_category($controller = NULL) {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_delete_category($controller = NULL) {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}