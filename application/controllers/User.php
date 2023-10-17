<?php
class User extends Frontend_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('frontend_user_m');
        $this->load->library('mail');
    }

    public function index($offset = 0) 
    {
        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'login';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

	public function login()
	{
		// Redirect a user if he's already logged in
		$cookie = get_cookie('frontend_dpmptsptk');

		// Check if have cokie
		if ($cookie <> '') {
            $user = $this->frontend_user_m->get_by_cookie($cookie);
            if ($user) {
                $this->frontend_user_m->register_session($user);
            } 
		}
		
		// Check if have session
		if (! $this->frontend_user_m->loggedin() == FALSE) {
				redirect('home');
		}

		// Set form
		$rules = $this->frontend_user_m->rules;
		$this->form_validation->set_rules($rules);

		// Process form
		if ($this->form_validation->run() == TRUE) {
			// We can login and redirect
			if ($this->frontend_user_m->login() == TRUE) {
				redirect('home');
			}
			else {
				$this->session->set_flashdata('error', 'That username/password combination does not exist');
				redirect('user/login');
			}
		}

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'login';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
	}

    public function register() 
    {
		if ($this->frontend_user_m->loggedin() == TRUE) {
			redirect('data');
		}

        $this->data['jenis_kelamin'] = array(
			'Laki-laki' => 'Laki-laki',
			'Perempuan' => 'Perempuan'
        );

		// Set form
		$register_rules = $this->frontend_user_m->register_rules;
		$this->form_validation->set_rules($register_rules);
		
        // Process form
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'username'      => $this->input->post('username'),
				'password'      => $this->frontend_user_m->hash($this->input->post('password')),
				'name'          => $this->input->post('name'),
				'email'         => $this->input->post('email'),
				'phone_number'  => $this->input->post('phone_number'),
				'alamat'        => $this->input->post('alamat'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'image' 		=> $this->input->post('image'),
				'status'        => 1,
				'is_active'     => 0
			);

            if ($this->register_send_email($data)) {
                $this->frontend_user_m->register($data);

                $register_message  = '<p>Pendaftaran berhasil! <br> Sebuah email telah kami kirimkan ke alamat '. $this->input->post('email') .'. Langkah pendaftaran berikutnya terdapat pada email tersebut.</p>';
                $register_message .= '<p>Kadang-kadang email tersebut masuk ke folder spam.</p>';
                $register_message .= '<p>Terima kasih</p>';

                $this->session->set_flashdata('success', $register_message);
                redirect('user/login');
            } else {
                $this->session->set_flashdata('error', 'Pendaftaran tidak berhasil, silahkan coba lagi.');
                redirect('user/login');
            }
		}
        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'register';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

	public function forgoten()
    {
        if ($this->frontend_user_m->loggedin() == true) {
            redirect('home');
        }

        // Set form
        $forgoten_rules = $this->frontend_user_m->forgoten_rules;
        $this->form_validation->set_rules($forgoten_rules);

        // Process form
        if ($this->form_validation->run() == true) {
            $data_user = $this->frontend_user_m->get_by(array('email' => $this->input->post('email')), true);
            if (count($data_user)) {
                $forgotten_password_code = substr(sha1(rand()), 0, 30);
                if ($this->frontend_user_m->forgoten($data_user['frontend_user_id'], $forgotten_password_code) === true) {
                    $message = 'Dear ' . $data_user['name'] . ', <br>';
                    $message .= '<h1>Petunjuk Ubah Kata Sandi</h1>';
                    $message .= '<p>Klik link di bawah ini untuk mengubah kata sandi akun:</p>';
                    $message .= '<p>' . base_url('verification/forgoten/') . $forgotten_password_code . '</p>';
                    $message .= '<p>Bapak/Ibu mendapatkan email ini karena baru saja meminta penggantian kata sandi akun. Apabila Bapak/Ibu tidak melakukannya, silahkan hubungi kami segera.</p>';
                    $message .= '<p>Hormat kami <br>Helpdesk DPMPTSPTK Kab. Kuantan Singingi</p>';

			        // Send email verification
			        $params =array(
			            'to'      => $this->input->post('email'),
			            'subject' => 'Petunjuk Ubah Kata Sandi',
			            'message' => $message
			        );
			        $this->mail->send_mail($params);

                    $forgoten_message  = '<h1>Kata Sandi Anda akan Diubah</h1>';
                    $forgoten_message .= '<p>Petunjuk untuk mengubah kata sandi telah dikirimkan ke ' . $this->input->post('email') . '.</p>';

                    $this->session->set_flashdata('success', $forgoten_message);
                    redirect('user/forgoten');
                }
            } else {
                $this->session->set_flashdata('error', 'Email tidak terdaftar!');
                redirect('user/forgoten');
            }
        }

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'forgoten';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function logout()
	{
		$this->frontend_user_m->logout();
		redirect('home');
	}

    public function reset_password()
    {
		if ($this->frontend_user_m->loggedin() == TRUE) {
			redirect('home');
		}

		if (isset($this->session->userdata['token'])) {
			$token     = $this->session->userdata['token'];
			$user_info = $this->frontend_user_m->is_token_valid($this->session->userdata['token']);

			if ($user_info) {
				$this->data['frontend_user_id'] = md5($user_info['frontend_user_id']);

				// Set Rules Validation
				$reset_rules = $this->frontend_user_m->reset_rules;
				$this->form_validation->set_rules($reset_rules);

				if ($this->form_validation->run() == TRUE) {
					$data = array(
						'forgotten_password_code' => '',
						'forgotten_password_time' => '0000-00-00',
						'password'                => $this->frontend_user_m->hash($this->input->post('password'))
					);

	                if ($this->frontend_user_m->reset_password($data, $this->input->post('frontend_user_id')) ) {
	                    // $this->session->sess_destroy();

	                    $this->session->set_flashdata('success', 'Kata sandi telah diubah, silahkan login menggunakan sandi yang baru.');
	                    redirect('user/login');
	                }
				}

		        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'reset';
		    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
			} else {
				redirect('user/login');
			}
		} else {
			redirect('user/login');
		}
    }

    protected function register_send_email($data = null)
    {
        $message  = 'Bapak/Ibu ' . $data['name'] . ', <br>';
		$message .= '<p>Terima kasih telah membuat akun untuk sistem Sistem Layanan Pengaduan dan Konsultasi - DPMPTSPTK  Kab. Kuantan Singingi .</p>';
        $message .= '<p>Silahkan klik link berikut untuk melakukan verifikasi email dan menyelesaikan proses pendaftaran:</p>';
        $message .= '<p>'. base_url('verification/email/') . md5($data['email']) .'</p>';
        $message .= '<p>Bapak/Ibu mendapatkan email ini karena baru saja membuat akun atau melakukan perubahan alamat email. Apabila Bapak/Ibu tidak melakukannya, silahkan hubungi kami segera.</p>';
        $message .= '<p>Hormat kami <br>Helpdesk DPMPTSPTK Kab. Kuantan Singingi</p>';

        // Send email verification
        $params =array(
            'to'      => $data['email'],
            'subject' => 'Verifikasi Email Akun PENGADUAN & KONSULTASI',
            'message' => $message
        );

        return $this->mail->send_mail($params);
    }

    // Callback Unique Email Form
    public function _unique_email($str)
    {
        // Do NOT validate if email already exists
        // UNLESS it's the email for the current user
        $id = $this->uri->segment(3);
        $this->db->where('email', $this->input->post('email'));
        !$id || $this->db->where('md5(frontend_user_id) !=', $id);
        $user = $this->frontend_user_m->get();

        if (count($user)) {
            $this->form_validation->set_message('_unique_email', '%s sudah terdaftar!');
            return FALSE;
        }

        return TRUE;
    }

    // Callback Unique username Form
    public function _unique_username($str)
    {
        // Do NOT validate if username already exists
        // UNLESS it's the username for the current user
        $id = $this->uri->segment(3);
        $this->db->where('username', $this->input->post('username'));
        !$id || $this->db->where('md5(frontend_user_id) !=', $id);
        $user = $this->frontend_user_m->get();

        if (count($user)) {
            $this->form_validation->set_message('_unique_username', '%s sudah terdaftar!');
            return FALSE;
        }

        return TRUE;
    }

	public function edit()
    {

		$this->data['jenis_kelamin'] = array(
			'Laki-laki' => 'Laki-laki',
			'Perempuan' => 'Perempuan'
        );
        if ($this->session->userdata['frontend_user_id']) {
            $user_data = $this->frontend_user_m->get($this->session->userdata['frontend_user_id'], true);

            if ($user_data) {
                $this->data['user_data'] = $user_data;


                // Set form
                $edit_rules = $this->frontend_user_m->edit_rules;

                if ($this->session->userdata['frontend_user_id']) {
                    $this->form_validation->set_rules("password", 'Password', 'trim|matches[password_confirm]');
                    $this->form_validation->set_rules("password_confirm", 'Komfirmasi Password', 'trim|matches[password]');
                } else {
                    $this->form_validation->set_rules("password", 'Password', 'trim|required|matches[password_confirm]');
                    $this->form_validation->set_rules("password_confirm", 'Komfirmasi Password', 'trim|matches[password]');
                }

                $this->form_validation->set_rules($edit_rules);
                // Process form
                if ($this->form_validation->run() == true) {
					
                    $data = array(
						'phone_number' => $this->input->post('phone_number'),
                        'name' => $this->input->post('name'),
						'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                        'alamat' => $this->input->post('alamat'),
                        // 'email' => $this->input->post('email'),
                    );

                    if ($this->input->post('password') != '') {
                        $data['password'] = $this->frontend_user_m->hash($this->input->post('password'));
                    }

                    if ($this->frontend_user_m->save($data, $this->session->userdata['frontend_user_id']) == true) {
                        $this->session->set_flashdata('success', '<strong>Sukses! </strong>Perubahan telah disimpan.');
                        redirect('user/edit');
                    }
                }

                // Load view
                $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'edit_user';
                $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
            }
        } else {
            redirect('home');
        }
    }
}