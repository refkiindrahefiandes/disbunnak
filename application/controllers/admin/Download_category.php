<?php
class Download_category extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('download/download_category_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'Download_category')) {
            $this->data['subview'] = 'admin/download_category/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'download_category_m',
            'sIndexColumn'        => 'download_category_id',
            'table_name'          => 'download_category',
            'table_join_name'     => '',
            'table_join_col_name' => '',
            'where_options'       => '',
            'search_col_name'     => 'name',
            'aColumns'            => array('download_category_id', 'name', 'sort_order', 'status', 'download_category_id')
        );

        $query = $this->datatable->index($config);
        $this->output->set_output(json_encode($query));
    }

    public function edit($id = NULL)
    {
		$this->data['categories']  = $this->download_category_m->get();

        // Button and publish permission
        if ($this->validate_publish_download_category('Download_category')) {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_save');
            $this->data['publish_permission'] = TRUE;
        } else {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_send_to_editor');
            $this->data['publish_permission'] = FALSE;
        }

		// Fetch a download_category or set a new one
		if ($id) {
			$result = $this->download_category_m->get($id);

			if ($result) {
				$this->data['download_category'] = $result;
			} else {
				$this->data['download_category'] = $this->download_category_m->get_new_download_category();
			}
		}
		else {
			$this->data['download_category'] = $this->download_category_m->get_new_download_category();
		}

        // printr($this->data['download_category']); die();

        // Set up the rules validate
        $rules = array(
            'name' => array(
                'field' => 'name',
                'label' => 'Judul Download',
                'rules' => 'trim|required'
            )
        );

        $this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE && $this->validate_modify('Download_category')) {
			$data = $this->input->post();
			$data['slug'] = get_slug($this->input->post('name'));

			$this->download_category_m->save($data, $id);
			redirect('admin/download_category');
		}

        // Load the view
        if ($this->user_m->hasPermission('access', 'Download_category')) {
            $this->data['subview'] = 'admin/download_category/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

		$this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('publish', 'Download_category')) {
            if ($status == 'true') {
                if ($this->download_category_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->download_category_m->update_status($id, 0)) {
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
		if ($this->validate_delete_download_category('Download_category')) {
            if ($id) {
                $this->download_category_m->delete($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/download_category');
            }
            else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->download_category_m->delete($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/download_category');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/download_category');
                }
            }
        }
    }

    // Validate
    public function validate_modify_download_category($controller = NULL) {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_publish_download_category($controller = NULL) {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_delete_download_category($controller = NULL) {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}