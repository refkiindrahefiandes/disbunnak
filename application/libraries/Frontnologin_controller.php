<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Class Frontend_Controller
* @author   Masriadi
*/
class Frontnologin_controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
        $this->load->library('session');
		$this->load->model('setting/setting_m');
		$this->load->model('frontend_user_m');
        $this->load->model('frontend/frontend_m');
		$this->load->model('frontend/vcounter_m');
		$this->load->helper('url');
		$this->load->helper(array('Cookie', 'String'));

        // Login check
        $exception_uris = array(
            'user/login',
            'user/register',
            'user/forgoten',
            'user/reset_password',
            'user/logout'
        );

        if (in_array(uri_string(), $exception_uris) == FALSE) {
            if ($this->frontend_user_m->loggedin() == FALSE) {
                redirect('/user/login');
            }
        }

        // Set Frontend Theme
        if ($this->setting_m->get_setting('active_theme')) {
        	$this->data['active_theme'] = $this->setting_m->get_setting('active_theme');
		} else {
			$this->data['active_theme'] = 'dpmptsptk';
        }
        $this->data['theme_url']    = FRONTEND_URL . $this->data['active_theme'] . '/';

        $this->data['general']      = $this->setting_m->get_setting('general_setting');
        
        // Language Code
        $this->data['language_code']  = 'id';

        // Set meta info
        $this->data['header_meta']  = array(
            'meta_title'       => $this->data['general'][$this->data['language_code']]['website_name'] . ' | ' . $this->data['general'][$this->data['language_code']]['website_description'],
            'meta_description' => $this->data['general'][$this->data['language_code']]['website_description'],
            'meta_keyword'     => ''
        );
        $this->data['meta_generator'] = 'PesonaCMS 1.0';
        $this->data['meta_robot']     = 'index, follow';
        
        // Check theme functions
        $theme_functions = FCPATH . 'themes/frontend/' . $this->data['active_theme'] . '/functions.php';
 
		if (is_file($theme_functions)) {
			@include_once($theme_functions);
			$this->data['theme_option'] = $this->setting_m->get_setting('theme_options_' . $this->data['active_theme']);
		}

        // Load language
        $this->data['theme_path'] = FCPATH . 'themes/frontend/' . $this->data['active_theme'] . '/';
      
        $this->data['load_language'] = $this->lang->load('index_lang', $this->data['language_code'], FALSE, TRUE, $this->data['theme_path']);

        $this->data['offset'] = 0;
      
        // Visitor Counter
        $this->vcounter_m->addVisitor();
    }
}