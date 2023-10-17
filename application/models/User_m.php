<?php
class User_M extends MY_Model
{
	protected $_table_name  = 'users';
	protected $_primary_key = 'user_id';
	protected $_order_by    = 'user_id';
	public $rules = array(
		'username' => array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'trim|required'
		)
	);

	public $rules_admin = array(
		'username' => array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required'
		),
		'email' => array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|callback__unique_email'
		)
	);

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_user()
	{
		$result = array(
			'user_id'          => '',
			'user_group_id'    => '',
			'username'         => set_value('username'),
			'email'            => set_value('email'),
			'firstname'        => set_value('firstname'),
			'lastname'         => set_value('lastname'),
			'password'         => set_value('password'),
			'password_confirm' => set_value('password_confirm'),
			'status'           => set_value('status'),
			'date_added'       => set_value('date_added')
	    );

		$result['description'] = '';
		$result['social']      = array();

		return $result;
	}

	public function get_by_id($id = NULL)
	{
		$where = array(
			'user_id' => $id
		);

        return $this->get_by($where, TRUE);
	}

    // ambil data berdasarkan cookie
    public function get_by_cookie($cookie)
    {
		$where = array(
			'cookie' => $cookie
		);

        return $this->get_by($where, TRUE);
    }

	public function delete_user($id)
	{
		$this->db->where($this->_primary_key, $id);
		$this->db->delete($this->_table_name);
	}

	public function login()
	{
		$user = $this->get_by(array(
			'username' => $this->input->post('username'),
			'password' => $this->hash($this->input->post('password'))
		), TRUE);

		if ($user) {
            if ($this->input->post('remember')) {
                $key = random_string('alnum', 64);
                set_cookie('pesonacms', $key, 3600*24*30); // set expired 30 hari kedepan

                // simpan key di database
                $update_key = array(
                    'cookie' => $key
                );
                $this->save($update_key, $user['user_id']);
			}

			$this->register_session($user);
		}
	}

	public function register_session($user)
	{
		if (count($user)) {
			// Log in user
			$data_login = array(
				'user_id'        => $user['user_id'],
				'username'       => $user['username'],
				'firstname'      => $user['firstname'],
				'lastname'       => $user['lastname'],
				'email'          => $user['email'],
				'user_group_id'  => $user['user_group_id'],
				'user_privilege' => (int) $user['user_privilege'],
				'language_code'  => $user['language_code'],
				'loggedin'       => TRUE
			);

			$this->session->set_userdata($data_login);
		}
	}

	public function logout()
	{
		delete_cookie('pesonacms');
		$this->session->sess_destroy();
	}

	public function hasPermission($key = NULL, $controller = NULL)
	{
		$this->load->model('user/user_permission_m');
		$where = array(
			'user_group_id' => $this->session->userdata['user_group_id']
		);
		$result = $this->user_permission_m->get_by($where, TRUE);
		if (is_array(unserialize($result['permission']))) {
			$permissions = unserialize($result['permission']);
		}

		if (is_array($permissions[$key])) {
			// $this->session->set_flashdata('error', NULL);
			return in_array($controller, $permissions[$key]);
		}

		return FALSE;
	}

	public function loggedin()
	{
		return (bool) $this->session->userdata('loggedin');
	}

	public function hash($string)
	{
		return hash('sha512', $string . config_item('encryption_key'));
	}
}