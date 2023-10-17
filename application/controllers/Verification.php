<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verification extends MY_controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('frontend_user_m');
    }

    public function index($hash=NULL)
    {
    	redirect('user/login');
    }

    public function email($hash=NULL)
    {
    	if ($this->frontend_user_m->verify_email($hash)) {
    		$this->session->set_flashdata('success', 'Sukses! Email telah diverifikasi, silahkan login untuk melanjutkan.');
    		redirect('user/login');
    	} else {
    		$this->session->set_flashdata('error', 'Email gagal terverifikasi!');
    		redirect('user/register');
    	}
    }

    public function forgoten($hash=NULL)
    {
        $cleanToken = $this->security->xss_clean($hash);
        $user_info  = $this->frontend_user_m->is_token_valid($cleanToken);

        if ($user_info) {
            $this->session->set_userdata('token', $cleanToken);
            redirect('user/reset_password');
        } else {
            $this->session->set_flashdata('error', 'Kode Token tidak valid atau sudah kadaluarsa!');
            redirect('user/login');
        }
    }
}