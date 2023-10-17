<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* About us Plugin
* @author	Masriadi
*/
class Category_plugin {
    public $_plugin_name        = 'Category Plugin';
    public $_plugin_desc        = 'Plugin to add category widget';
    public $_plugin_dir         = 'category_plugin';
    public $_widget_name        = 'Category Plugin';
    public $_plugin_widget_name = 'category_plugin_widget';

    public function index()
	{
		$CI =& get_instance();

        // Check widget
        $this->widget_init();

        // Get data
        $this->get_data();

        // Process the form
        if ($CI->input->method(TRUE) == 'POST' && $CI->validate_modify('Plugin')) {
            foreach ($CI->input->post('category') as $key => $items) {
                $data[$this->_plugin_dir][$key] = elements(array('show_child', 'show_totals'), $items);
            }

            $CI->setting_m->save_setting($data);
            redirect($CI->data['redirect']);
        }
	}

    public function widget($widget_item_id = NULL, $language_code = NULL)
    {
        $CI =& get_instance();

        // Get data
        $this->get_data();
        $widget_data = $CI->widget_m->get_widget_item(array('widget_item_id' => $widget_item_id));
        $categories = $CI->frontend_m->get_terms(array('term_type' => 'category'));
        // printr($widget_data); die();
        $CI->data['category_data'] = array();
        foreach ($widget_data as $widget) {
            if (array_key_exists($widget['value']['widget_data'], $CI->data['categories'])) {
                if ($widget['value']['widget_title'][$language_code]) {
                    $CI->data['category_data']['widget_title'] = $widget['value']['widget_title'][$language_code];
                }

                if ($categories) {
                    $CI->data['category_data']['categories'] = $categories;
                }
            }
        }

        if ($CI->data['category_data']) {
            $CI->load->ext_view('plugins/category_plugin/category_plugin_widget', $CI->data['category_data']);
        }
    }

    public function get_data()
    {
        $CI =& get_instance();

        // Get data
        $category_data = $CI->setting_m->get_setting($this->_plugin_dir);

        if ($category_data) {
            $CI->data['categories'] = $category_data;
        } else {
            $CI->data['categories'][] = array(
                'show_child'  => '',
                'show_totals' => ''
            );
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