<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Fullslider Plugin
* @author	Masriadi
*/
class Fullslider_plugin {
    public $_plugin_name        = 'Fullslider Plugin';
    public $_plugin_desc        = 'Plugin to add fullslider widget';
    public $_plugin_dir         = 'fullslider_plugin';
    public $_widget_name        = 'Fullslider Plugin';
    public $_plugin_widget_name = 'fullslider_plugin_widget';

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
            if ($CI->input->post('fullslider')) {
                foreach ($CI->input->post('fullslider') as $key => $items) {
                    if (count($items)) {
                        foreach ($items as $i) {
                            $results[$key][] = array(
                                'fullslider_image' => $i['fullslider_image'] ? $i['fullslider_image'] : 'uploads/images/default/default-thumbnail.png',
                                'fullslider_title' => $i['fullslider_title'],
                                'fullslider_desc'  => $i['fullslider_desc'],
                                'status'           => $i['status'] ? $i['status'] : '0'
                            );
                        }
                    }
                }

                $data[$this->_plugin_dir] = $results;
                $CI->setting_m->save_setting($data);
                redirect($CI->data['redirect']);
            } elseif ($CI->input->post('fullslider') == NULL) {
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
        $CI->data['fullsliders_data'] = array();
        $widget_data = $CI->widget_m->get_widget_item(array('widget_item_id' => $widget_item_id));
        foreach ($widget_data as $widget) {
            if (array_key_exists($widget['value']['widget_data'], $CI->data['fullsliders'])) {
                if (isset($widget['value']['widget_title'][$language_code])) {
                    $CI->data['fullsliders_data']['widget_title'] = $widget['value']['widget_title'][$language_code];
                }

                $CI->data['fullsliders_data']['fullsliders'] = $CI->data['fullsliders'][$widget['value']['widget_data']];
            }
        }

        if ($CI->data['fullsliders_data']) {
            $CI->load->ext_view('plugins/fullslider_plugin/fullslider_plugin_widget', $CI->data['fullsliders_data']);
        }
    }

    public function get_data()
    {
        $CI =& get_instance();

        // Get data
        $CI->data['fullsliders'][] = array();

        $fullslider_data = $CI->setting_m->get_setting($this->_plugin_dir);
        if ($fullslider_data) {
            $CI->data['fullsliders'] = $fullslider_data;
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