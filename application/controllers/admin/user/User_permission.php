<?php
class User_permission extends Admin_controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/user_permission_m');
		$this->load->helper(array('Cookie', 'String'));
        $this->load->helper('directory');
        $this->load->helper('file');
	}

    public function index()
    {
		// Load view
        if ($this->session->userdata['user_privilege'] == (int) 1) {
            $this->data['subview'] = 'admin/user_permission/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'user_permission_m',
            'sIndexColumn'        => 'user_group_id',
            'table_name'          => 'user_group',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => array(),
            'search_col_name'     => 'name',
            'aColumns'            => array('user_group_id', 'name', 'user_group_id')
        );
        $query = $this->datatable->index($config);
        $this->output->set_output(json_encode($query));
    }

    public function edit($id = NULL)
    {
		// Fetch a user_group or set a new one
		if ($id) {
			$where = array(
				'user_group_id' => $id
			);
			$result = $this->user_permission_m->get_by($where, TRUE);

			if ($result) {
				$result['permission'] = is_array(unserialize($result['permission'])) ? unserialize($result['permission']) : array('access' => array(), 'modify' => array(), 'publish' => array());
				$this->data['user_group'] = $result;
			} else {
				$this->data['user_group'] = $this->user_permission_m->get_new_user_group();
			}
		}
		else {
			$this->data['user_group'] = $this->user_permission_m->get_new_user_group();
		}

		// BEGIN GET CONTROLLER FILE LIST
		// Set ignore
		$ignore = array(
			'Dashboard',
			'user/User',
			'user/User_permission'
		);

		// Declarate var files
		$files = array();

		// Make path into an array
		$path = array(APPPATH . 'controllers/admin/*');

		// While the path array is still populated keep looping through
		while (count($path) != 0) {
			$next = array_shift($path);

			foreach (glob($next) as $file) {
				// If directory add to path array
				if (is_dir($file)) {
					$path[] = $file . '/*';
				}

				// Add the file to the files to be deleted array
				if (is_file($file)) {
					$files[] = $file;
				}
			}
		}

		// Sort the file array
		sort($files);

		foreach ($files as $file) {
			$controller = substr($file, strlen(APPPATH . 'controllers/admin/'));

			$permission = substr($controller, 0, strrpos($controller, '.'));

			if (!in_array($permission, $ignore)) {
				$this->data['permissions'][] = $permission;
			}
		}

		// END GET CONTROLLER FILE LIST

		// Set up the rules
		$rules = $this->user_permission_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE && $this->session->userdata['user_privilege'] == (int) 1) {
			$permission = array(
				'access'  => $this->input->post('permission[access]') ? $this->input->post('permission[access]') : array(),
				'modify'  => $this->input->post('permission[modify]') ? $this->input->post('permission[modify]') : array(),
				'publish' => $this->input->post('permission[publish]') ? $this->input->post('permission[publish]') : array()
			);

			$data = array(
				'user_group_id' => $this->input->post('user_group_id'),
				'name'          => $this->input->post('name'),
				'slug'          => get_slug($this->input->post('name')),
				'status'        => $this->input->post('status'),
				'permission'    => serialize($permission)
			);

			$this->user_permission_m->save($data, $id);
			redirect('admin/user/user_permission');
		}

		// Load the view
        if ($this->session->userdata['user_privilege'] == (int) 1) {
           	$this->data['subview'] = 'admin/user_permission/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

		$this->load->view('admin/_layout_main', $this->data);
    }

    public function delete($id = NULL)
    {
		if ($this->session->userdata['user_privilege'] == (int) 1) {
			if ($id) {
				$this->user_permission_m->delete($id);
		    	$this->session->set_flashdata('success', lang('success_single_delete'));
				redirect('admin/user/user_permission');
			}
			else {
				if ($this->input->post('selected')) {
					foreach ($this->input->post('selected') as $id) {
						$this->user_permission_m->delete($id);
					}
			    	$this->session->set_flashdata('success', lang('success_multiple_delete'));
					redirect('admin/user/user_permission');
				} else {
			    	$this->session->set_flashdata('error', lang('error_delete'));
			    	redirect('admin/user/user_permission');
				}
			}
		} else {
	    	$this->session->set_flashdata('error', lang('error_permission'));
	    	redirect('admin/user/user_permission');
		}
    }
}