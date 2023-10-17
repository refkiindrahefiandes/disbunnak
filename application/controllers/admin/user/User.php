<?php
class User extends Admin_controller
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
            $this->data['subview'] = 'admin/user/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'user_m',
            'sIndexColumn'        => 'user_id',
            'table_name'          => 'users',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => array(),
            'search_col_name'     => 'username ',
            'aColumns'            => array('user_id', 'username', 'email', 'user_group_id', 'user_id')
        );

        $query = $this->datatable->index($config);

        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $value[2],
                    '3' => $this->get_group_name($value[3]),
                    '4' => $value[4]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
		// Get user grups
		$this->data['user_groups'] = $this->user_permission_m->get();

		// Get languages from database
		$langs_data = $this->language_m->get_active();

		// Get languages from language dir
		$langs_dir = glob(APPPATH . 'language/*', GLOB_ONLYDIR);

		// Filter array $langs_data based on array $langs_dir
		foreach ($langs_dir as $key => $dir) {
			$filterBy = basename($dir);
			$results[] = array_filter($langs_data, function ($var) use ($filterBy) {
			    return ($var['language_code'] == $filterBy);
			});
		}

		// Store results to languages property
		$this->data['languages'] = array();
		foreach ($results as $key => $value) {
			if (!empty($value)) {
				foreach ($value as $v) {
					$this->data['languages'][$key] = $v;
				}
			}
		}

		// Fetch a user or set a new one
		if ($id) {
			$where = array(
				'user_id' => $id
			);
			$result = $this->user_m->get_by($where, TRUE);
			if ($result) {
				$setting = $this->setting_m->get_setting($result['username']);
				$this->data['user']                = $result;
				$this->data['user']['description'] = isset($setting['description']) ? $setting['description'] : NULL;
				$this->data['user']['social']      = isset($setting['social']) ? $setting['social'] : array();

			} else {
				$this->data['user'] = $this->user_m->get_new_user();
			}
		}
		else {
			$this->data['user'] = $this->user_m->get_new_user();
		}

		// Set up the form
		$rules = $this->user_m->rules_admin;

		if ($id) {
			$this->form_validation->set_rules("password", 'Password', 'trim|matches[password_confirm]');
			$this->form_validation->set_rules("password_confirm", 'Komfirmasi Password', 'trim|matches[password]');
		} else {
			$this->form_validation->set_rules("password", 'Password', 'trim|required|matches[password_confirm]');
			$this->form_validation->set_rules("password_confirm", 'Komfirmasi Password', 'trim|matches[password]');
		}
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE && $this->validate_user_permission($id)) {
			$data = array(
				'user_id'       => $this->input->post('user_id'),
				'email'         => $this->input->post('email'),
				'firstname'     => $this->input->post('firstname'),
				'lastname'      => $this->input->post('lastname'),
				'ip_address'    => $_SERVER['REMOTE_ADDR'],
				'status'        => $this->input->post('status'),
				'date_added'    => date('Y-m-d'),
				'language_code' => $this->input->post('language_code')
			);

			if ($this->input->post('user_group_id') != '') {
				$data['user_group_id'] = $this->input->post('user_group_id');
			}

			if (! $id) {
				$data['username'] = $this->input->post('username');
			}

			if ($this->input->post('password') != '') {
				$data['password'] = $this->user_m->hash($this->input->post('password'));
			}

			if ($this->input->post('usermeta')) {
				$setting[$this->input->post('username')] = $this->input->post('usermeta');
				$this->setting_m->save_setting($setting);
			}

			if ($this->user_m->save($data, $id)) {
				$this->session->set_flashdata('success', lang('success_update_data'));

				if ($id) {
					redirect('admin/user/user/edit/' . $id);
				} else {
					redirect('admin/user/user');
				}
			}
		}

		// Load the view
        if ($this->validate_user_permission($id)) {
            $this->data['subview'] = 'admin/user/edit';
        } else {
            // $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

		$this->load->view('admin/_layout_main', $this->data);
    }

	public function _unique_email($str)
	{
		// Do NOT validate if email already exists
		// UNLESS it's the email for the current user
		$id = $this->uri->segment(5);
		$this->db->where('email', $this->input->post('email'));
		!$id || $this->db->where('user_id !=', $id);
		$user = $this->user_m->get();

		if (count($user)) {
			$this->form_validation->set_message('_unique_email', '%s sudah terdaftar!');
			return FALSE;
		}

		return TRUE;
	}

	public function login()
	{
		// Redirect a user if he's already logged in
		$cookie = get_cookie('pesonacms');
		// Check if have cokie
		if ($cookie <> '') {
            $user = $this->user_m->get_by_cookie($cookie);
            if ($user) {
                $this->user_m->register_session($user);
            }
		}

		// Check if have session
		if (! $this->user_m->loggedin() == FALSE) {
			redirect('admin/dashboard');
		}

		// Set form
		$rules = $this->user_m->rules;
		$this->form_validation->set_rules($rules);

		// Process form
		if ($this->form_validation->run() == TRUE) {
			// We can login and redirect
			if ($this->user_m->login() == TRUE) {
				redirect($dashboard);
			}
			else {
				$this->session->set_flashdata('error', 'That username/password combination does not exist');
				redirect('admin/user/user/login', 'refresh');
			}
		}

		// Load view
		$this->load->view('admin/user/login', $this->data);
	}

	public function logout()
	{
		$this->user_m->logout();
		redirect('admin/user/user/login');
	}

    public function delete($id = NULL)
    {
		if ($this->session->userdata['user_privilege'] == (int) 1) {
			if ($id) {
				if ($id !== $this->session->userdata['user_id']) {
					$this->user_m->delete_user($id);
			    	$this->session->set_flashdata('success', lang('success_single_delete'));
					redirect('admin/user/user');
				} else {
			    	$this->session->set_flashdata('error', lang('error_self_account_delete'));
					redirect('admin/user/user');
				}
			}
			else {
				if ($this->input->post('selected')) {
					foreach ($this->input->post('selected') as $id) {
						if ($id !== $this->session->userdata['user_id']) {
							$this->user_m->delete_user($id);
					    	$this->session->set_flashdata('success', lang('success_multiple_delete'));
							redirect('admin/user/user');
						} else {
					    	$this->session->set_flashdata('error', lang('error_self_account_delete'));
							redirect('admin/user/user');
						}
					}
				} else {
			    	$this->session->set_flashdata('error', lang('error_delete'));
			    	redirect('admin/user/user');
				}
			}
		} else {
	    	$this->session->set_flashdata('error', lang('error_permission'));
	    	redirect('admin/user/user');
		}
    }

    public function get_group_name($user_group_id=NULL)
    {
    	$result = $this->user_permission_m->get($user_group_id, TRUE);
    	if ($result) {
    		return $result['name'];
    	} else {
    		return NULL;
    	}
    }

    // Validate
    protected function validate_user_permission($user_id = NULL) {
		$user_session_data   = $this->session->userdata['user_id'] === $user_id;
		$user_privilege_data = $this->session->userdata['user_privilege'] == (int) 1;

        if ($user_session_data === TRUE OR $user_privilege_data === TRUE) {
            return TRUE;
        }

        return FALSE;
    }
}