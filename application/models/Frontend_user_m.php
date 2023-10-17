<?php
class Frontend_user_M extends MY_Model
{
	protected $_table_name  = 'frontend_users';
	protected $_primary_key = 'frontend_user_id';
	protected $_order_by    = 'frontend_user_id';

	public $rules = array(
		'username' => array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'Kata Sandi',
			'rules' => 'trim|required'
		)
	);

	public $register_rules = array(
		'username' => array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required|min_length[5]|max_length[75]|alpha_numeric|callback__unique_username'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'Kata Sandi',
			'rules' => 'trim|required|matches[password_confirm]|min_length[5]|max_length[75]'
		),
		'password_confirm' => array(
			'field' => 'password_confirm',
			'label' => 'Komfirmasi Kata Sandi',
			'rules' => 'trim|matches[password]|min_length[5]|max_length[75]'
		),
		'email' => array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|callback__unique_email'
		),
		'phone_number' => array(
			'field' => 'phone_number',
			'label' => 'Nomor Handphone',
			'rules' => 'trim|required|max_length[75]'
		),
		'name' => array(
			'field' => 'name',
			'label' => 'Nama',
			'rules' => 'trim|required|max_length[100]'
		),
		'alamat' => array(
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'trim|max_length[255]'
		),
		'jenis_kelamin' => array(
			'field' => 'jenis_kelamin',
			'label' => 'Jenis Kelamin',
			'rules' => 'trim|max_length[100]'
		)
	);

	public $forgoten_rules = array(
		'email' => array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|max_length[75]'
		)
	);

	public $reset_rules = array(
		'password' => array(
			'field' => 'password',
			'label' => 'Kata Sandi',
			'rules' => 'trim|required|matches[password_confirm]|min_length[5]|max_length[75]'
		),
		'password_confirm' => array(
			'field' => 'password_confirm',
			'label' => 'Komfirmasi Kata Sandi',
			'rules' => 'trim|matches[password]|min_length[5]|max_length[75]'
		),
	);

	public $edit_rules = array(
		// 'email' => array(
		// 	'field' => 'email',
		// 	'label' => 'Email',
		// 	'rules' => 'trim|required|valid_email|max_length[75]|callback__unique_email'
		// ),
		'phone_number' => array(
			'field' => 'phone_number',
			'label' => 'Nomor Handphone',
			'rules' => 'trim|required|max_length[75]'
		),
		'name' => array(
			'field' => 'name',
			'label' => 'Nama',
			'rules' => 'trim|required|max_length[100]'
		),
		'alamat' => array(
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'trim|max_length[255]'
		),
		'jenis_kelamin' => array(
			'field' => 'jenis_kelamin',
			'label' => 'Jenis Kelamin',
			'rules' => 'trim|max_length[100]'
		)
	);

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_frontend_user()
	{
		$result = array(
			'frontend_user_id' => '',
			'username'         => '',
			'password'         => '',
			'name'             => '',
			'nik'              => '',
			'email'            => '',
			'phone_number'     => '',
			'alamat'           => '',
			'jenis_kelamin'    => '',
			'image'    		   => '',
			'status'           => 1,
			'is_active'        => 1,
		);

		return $result;
	}

    // ambil data berdasarkan cookie
    public function get_by_cookie($cookie)
    {
		$where = array(
			'cookie' => $cookie
		);

        return $this->get_by($where, TRUE);
    }

	public function login()
	{
		$frontend_user = $this->get_by(array(
			'username'  => $this->input->post('username'),
			'password'  => $this->hash($this->input->post('password')),
			'status'    => (int) 1,
			'is_active' => (int) 1,
		), TRUE);

		// echo json_encode($frontend_user['frontend_user_id']); die();

		if ($frontend_user) {
            if ($this->input->post('remember')) {
                $key = random_string('alnum', 64);
                set_cookie('frontend_dpmptsptk', $key, 3600*24*30); // set expired 30 hari kedepan

                // simpan key di database
                $update_key = array(
                	'last_login' => date('Y-m-d H:i:s'),
                    'cookie' => $key
                );

                $this->save($update_key, $frontend_user['frontend_user_id']);
			}

			$update_key = array(
            	'last_login' => short_date('Y-m-d H:i:s', $date="now"),
            );

            $this->save($update_key, $frontend_user['frontend_user_id']);

			$this->register_session($frontend_user);
		}
	}

	public function register($data)
	{
		if (count($data)) {
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			return $this->db->insert_id();
		}
	}

	public function forgoten($frontend_user_id=NULL, $forgotten_password_code=NULL)
	{
		if ($frontend_user_id) {
			$date = date('Y-m-d');
			$data = array(
				'forgotten_password_code' => md5($forgotten_password_code),
				'forgotten_password_time' => $date
			);

			$this->db->set($data);
			$this->db->where('frontend_user_id', $frontend_user_id);
			$this->db->update($this->_table_name);

			return TRUE;
		}
	}

	public function reset_password($data=NULL, $frontend_user_id=NULL)
	{
		if ($data) {
			$this->db->set($data);
			$this->db->where('md5(frontend_user_id)', $frontend_user_id);
			$this->db->update($this->_table_name);

			return TRUE;
		}

		return FALSE;
	}

	public function is_token_valid($hash=NULL)
	{
		$data = array(
			'forgotten_password_code' => md5($hash),
			'forgotten_password_time' => date('Y-m-d')
		);
		$result = $this->get_by($data, TRUE);

		if ($result) {
			return $result;
		}
		return FALSE;
	}

	public function register_session($frontend_user)
	{
		if (count($frontend_user)) {
			// Log in user
			$data_login = array(
				'frontend_user_id'    => $frontend_user['frontend_user_id'],
				'username'            => $frontend_user['username'],
				'name'                => $frontend_user['name'],
				'nik'                 => $frontend_user['nik'],
				'frontend_user_email' => $frontend_user['email'],
				'frontend_user_image' => $frontend_user['image'],
				'phone_number'        => $frontend_user['phone_number'],
				'frontend_loggedin'   => TRUE,
				'last_login'          => short_date('Y-m-d H:i:s', $date="now")
			);

			$this->session->set_userdata($data_login);
		}
	}

	public function logout()
	{
		delete_cookie('ppid_frontend');
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
		return (bool) $this->session->userdata('frontend_loggedin');
	}

	public function hash($string)
	{
		return hash('sha512', $string . config_item('encryption_key'));
	}

	public function verify_email($hash) {
		$this->db->set(array('is_active' => 1));
		$this->db->where('md5(email)', $hash);

		return $this->db->update($this->_table_name);
	}

	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where('frontend_user_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}
}