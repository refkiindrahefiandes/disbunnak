<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Frontend_Controller
 * @author	Masriadi
 */
class Frontend_controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('frontend/frontend_m');
        $this->load->model('setting/setting_m');
        $this->load->model('blog/blog_category_m');
        $this->load->model('user_m');
        $this->load->model('theme/widget_m');
        $this->load->model('frontend/vcounter_m');
        $this->load->helper('psurl');
        $this->load->helper('url');
        $this->load->helper(array('Cookie', 'String'));

        $this->data['active_theme'] = $this->setting_m->get_setting('active_theme');
        $this->data['general']      = $this->setting_m->get_setting('general_setting');
        $this->data['theme_url']    = FRONTEND_URL . $this->data['active_theme'] . '/';

        // Set language
        $this->data['languages']    = $this->frontend_m->get_active_language();
        $this->data['switch_langs'] = array();

        $language = $this->frontend_m->get_language_by_code($this->uri->segment(1));
        $lang_cookie = get_cookie('pesonacms_lang_code');

        if (isset($language['language_code'])) {
            $this->data['language_code']    = $language['language_code'];
            $this->data['date_format_lite'] = $language['date_format_lite'];
            $this->data['date_format_full'] = $language['date_format_full'];

            if ($lang_cookie !== $language['language_code']) {
                set_cookie('pesonacms_lang_code', $language['language_code'], 3600 * 24 * 30);
            }
        } elseif ($lang_cookie <> '') {
            $language = $this->frontend_m->get_language_by_code($lang_cookie);
            $this->data['language_code']    = $language['language_code'];
            $this->data['date_format_lite'] = $language['date_format_lite'];
            $this->data['date_format_full'] = $language['date_format_full'];
        } else {
            $localisation = $this->setting_m->get_setting('localisation_setting');
            $language = $this->frontend_m->get_language_by_code($localisation['language_code']);
            $this->data['language_code']    = $language['language_code'];
            $this->data['date_format_lite'] = $language['date_format_lite'];
            $this->data['date_format_full'] = $language['date_format_full'];
        }

        // Set meta info
        $this->data['header_meta']  = array(
            'meta_title'       => $this->data['general'][$this->data['language_code']]['website_name'] . ' | ' . $this->data['general'][$this->data['language_code']]['website_description'],
            'meta_description' => $this->data['general'][$this->data['language_code']]['website_description'],
            'meta_keyword'     => ''
        );
        $this->data['meta_generator'] = 'PesonaCMS 1.0';
        $this->data['meta_robot']     = 'index, follow';

        $this->data['offset'] = 0;

        // Check theme functions
        $active_theme = $this->setting_m->get_setting('active_theme');
        $theme_functions = FCPATH . 'themes/frontend/' . $active_theme . '/functions.php';

        if (is_file($theme_functions)) {
            @include_once($theme_functions);
            $this->data['theme_option'] = $this->setting_m->get_setting('theme_options_' . $active_theme);
        }

        // Load language
        $theme_lang_path = FCPATH . 'themes/frontend/' . $active_theme . '/';
        $this->data['load_language'] = $this->lang->load('index_lang', $this->data['language_code'], FALSE, TRUE, $theme_lang_path);

        // Visitor Counter
        $this->vcounter_m->addVisitor();
    }
}
