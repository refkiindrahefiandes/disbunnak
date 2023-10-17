<?php
class Tag extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog/blog_m');
        $this->load->model('blog/blog_tag_m');
    }

    public function index($id = NULL)
    {
        if ($this->user_m->hasPermission('access', 'blog/Tag')) {
            $this->data['subview'] = 'admin/blog/tag/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'blog_tag_m',
            'sIndexColumn'        => 'term_id',
            'table_name'          => 'blog_term',
            'table_join_name'     => 'blog_term_description',
            'table_join_col_name' => 'name',
            'where_options'       => array('blog_term.term_type' => 'tag'),
            'search_col_name'     => 'name',
            'aColumns'            => array('term_id', 'name', 'language_code', 'status', 'term_id')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $value[2],
                    '3' => $value[3],
                    '4' => $value[4],
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
        // $this->data['languages'] = $this->language_m->get_active();
        $this->data['tags']      = $this->blog_tag_m->get_tags();

        // Button and publish permission
        if ($this->validate_publish_tag('blog/Tag')) {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_save');
            $this->data['publish_permission'] = TRUE;
        } else {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_send_to_editor');
            $this->data['publish_permission'] = FALSE;
        }

		// Fetch a tag or set a new one
		if ($id) {
			$result = $this->blog_tag_m->get_tags($id);
			if ($result !== false) {
				$this->data['tag'] = $result;
			} else {
				$this->data['tag'] = $this->blog_tag_m->get_new_tag();
			}
		}
		else {
			$this->data['tag'] = $this->blog_tag_m->get_new_tag();
		}

		// Set up the form
		$this->form_validation->set_rules("tag_desc[name]", 'Name', 'trim|required|max_length[255]');

		// Process the form
		if ($this->form_validation->run() == TRUE && $this->validate_modify('blog/Tag')) {
			$data = $this->input->post();
            $data['tag_data']['term_type'] = 'tag';

            if ($this->validate_publish_tag('blog/Tag')) {
                $data['tag_data']['status'] = $this->input->post('tag_data[status]');
            } else {
                $data['tag_data']['status'] = 0;
            }

            $this->blog_tag_m->save_tag($data, $id);
			redirect('admin/blog/tag');
		}

        // Load the view
        if ($this->user_m->hasPermission('access', 'blog/Tag')) {
            $this->data['subview'] = 'admin/blog/tag/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

		$this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('publish', 'blog/Tag')) {
            if ($status == 'true') {
                if ($this->blog_tag_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->blog_tag_m->update_status($id, 0)) {
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
		if ($this->validate_delete_tag('blog/Tag')) {
            if ($id) {
                $this->blog_tag_m->delete_tag($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/blog/tag');
            }
            else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->blog_tag_m->delete_tag($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/blog/tag');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/blog/tag');
                }
            }
        }
    }

    // Validate
    public function validate_modify_tag($controller = NULL) {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_publish_tag($controller = NULL) {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_delete_tag($controller = NULL) {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}