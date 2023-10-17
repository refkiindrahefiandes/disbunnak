<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Class Admin_Controller
* @author	Masriadi
*/
class Admin_controller extends MY_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_m');
		$this->load->model('setting/setting_m');
		$this->load->model('localisation/language_m');
		$this->load->library('session');
		$this->load->library('form_validation');
        $this->load->library('datatable');
        $this->load->helper('url');

		$this->data['meta_title'] = 'Admin - Dashboard';

		// Login check
		$exception_uris = array(
			'admin/user/user/login',
			'admin/user/user/logout'
		);

		if (in_array(uri_string(), $exception_uris) == FALSE) {
			if ($this->user_m->loggedin() == FALSE) {
				redirect('admin/user/user/login');
			}
		}

		// Load langguage
		$this->data['languages'] = $this->language_m->get_active();
		if (isset($this->session->userdata['language_code'])) {
			$language_name = $this->session->userdata['language_code'];
			$date_format   = get_language_date_format($this->session->userdata['language_code']);
			if ($language_name) {
				$this->lang->load('index_lang', $language_name);
				$this->data['language_code']    = $language_name;
				$this->data['date_format_lite'] = $date_format;
			} else {
				$this->lang->load('index_lang', $this->config->item('language_code'));
				$this->data['language_code']    = $this->config->item('language_code');
				$this->data['date_format_lite'] = $date_format;
			}
		}

        // Frontend theme check
        $active_theme = $this->setting_m->get_setting('active_theme');
        $this->data['theme_options'] = array();

        if ($active_theme) {
            $theme_functions = FCPATH . 'themes/frontend/' . $active_theme . '/functions.php';
            if (is_file($theme_functions)) {
                $this->data['theme_options'] = array(
                    array(
                        'themename'        => ucwords($active_theme) . ' ' . 'Theme Options',
                        'theme_option_url' => site_url('admin/theme/theme/option')
                    )
                );
            }
        }
	}

    // Validate
    public function validate_modify($controller = NULL) {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
        	return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        return FALSE;
    }

    public function validate_delete($controller = NULL) {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
        	return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}