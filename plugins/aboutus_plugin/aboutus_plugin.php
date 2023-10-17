<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* About us Plugin
* @author	Masriadi
*/
class Aboutus_plugin {
    public $_plugin_name        = 'About Us Plugin';
    public $_plugin_desc        = 'Plugin to add about us widget';
    public $_plugin_dir         = 'aboutus_plugin';
    public $_widget_name        = 'About Us Plugin';
    public $_plugin_widget_name = 'aboutus_plugin_widget';

	public function index()
	{
		$CI =& get_instance();

        // Widget init
        $this->widget_init();

        // Get data
        $this->get_data();

        // Process the form
        $data[$this->_plugin_dir] = array();
        if ($CI->input->method(TRUE) == 'POST' && $CI->validate_modify('Plugin')) {
            if ($CI->input->post('aboutus')) {
                $data[$this->_plugin_dir] = $CI->input->post('aboutus');
                $CI->setting_m->save_setting($data);
                redirect($CI->data['redirect']);
            } else {
                $CI->setting_m->save_setting($data);
                redirect($CI->data['redirect']);
            }
        }
	}

    public function widget($widget_item_id = NULL, $language_code = NULL)
    {
        $CI =& get_instance();

        // Get data
        $this->get_data();

        // Add data form widget
        $widget_data = $CI->widget_m->get_widget_item(array('widget_item_id' => $widget_item_id));
        $CI->data['aboutus'] = array();
        foreach ($widget_data as $widget) {
            if (array_key_exists($widget['value']['widget_data'], $CI->data['abouts'])) {
                if (isset($widget['value']['widget_title'][$language_code])) {
                    $CI->data['aboutus']['widget_title'] = $widget['value']['widget_title'][$language_code];
                }

                if (isset($CI->data['abouts'][$widget['value']['widget_data']]['user_desc'][$language_code])) {
                    $CI->data['aboutus']['user_desc'] = $CI->data['abouts'][$widget['value']['widget_data']]['user_desc'][$language_code];
                    $CI->data['aboutus']['user_image'] = $CI->data['abouts'][$widget['value']['widget_data']]['user_image'];
                }
            }
        }

        if ($CI->data['aboutus']) {
            $CI->load->ext_view('plugins/aboutus_plugin/aboutus_plugin_widget', $CI->data['aboutus']);
        }
    }

    public function get_data()
    {
        $CI =& get_instance();

        // Get data
        $aboutus_data = $CI->setting_m->get_setting($this->_plugin_dir);
        if ($aboutus_data) {
            foreach ($aboutus_data as $key => $aboutus) {
                foreach($CI->data['languages'] as $value){
                    if(isset($aboutus['user_desc']) && isset($aboutus['user_desc'][$value['language_code']]) ){
                        $aboutus_data[$key]['user_desc'][$value['language_code']] = $aboutus['user_desc'][$value['language_code']];
                    }else {
                        $aboutus_data[$key]['user_desc'][$value['language_code']] = array(
                            'user_name' => '',
                            'user_desc' => ''
                        );
                    }
                }
            }
            $CI->data['abouts'] = $aboutus_data;
        } else {
            foreach($CI->data['languages'] as $language)
            {
                $abouts['user_desc'][$language['language_code']] = array(
                    'user_name'  => set_value('title'),
                    'user_desc'  => set_value('user_desc')
                );

                $abouts['user_image'] = '';
            }

            $CI->data['abouts'][] = $abouts;
        }
    }

    public function widget_init()
    {
        $CI =& get_instance();

        // Check widget
        if (! count($CI->setting_m->get_setting($this->_plugin_widget_name)) && is_plugin_active($this->_plugin_dir)) {
            $add_widget = array(
                $this->_plugin_widget_name => array(
                    'widget_name' => $this->_widget_name,
                    'widget_data' => $this->_plugin_dir
                )
            );
            $CI->setting_m->save_setting($add_widget);
        }
    }
}