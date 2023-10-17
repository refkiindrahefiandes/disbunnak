<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Slider Plugin
* @author	Masriadi
*/
class Slider_plugin {
    public $_plugin_name        = 'Slider Plugin';
    public $_plugin_desc        = 'Plugin to add post slider widget';
    public $_plugin_dir         = 'slider_plugin';
    public $_widget_name        = 'Slider Plugin';
    public $_plugin_widget_name = 'slider_plugin_widget';

	public function index()
	{
		$CI =& get_instance();

        // widget_init widget
        $this->widget_init();

        // Get data
        $this->get_data();

        // Process the form
        $data[$this->_plugin_dir] = array();
        if ($CI->input->method(TRUE) == 'POST' && $CI->validate_modify('Plugin')) {
            $data[$this->_plugin_dir] = $CI->input->post('post-select');
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
        $CI->data['posts'] = array();

        foreach ($widget_data as $widget) {
            if (array_key_exists($widget['value']['widget_data'], $CI->data['sliders'])) {
                if (isset($widget['value']['widget_title'][$language_code])) {
                    $CI->data['posts']['widget_title'] = $widget['value']['widget_title'][$language_code];
                }
                $slider_data = $CI->data['sliders'][$widget['value']['widget_data']];
            }
        }

        $results = array();
        if (isset($slider_data)) {
            foreach ($slider_data as $value) {
                $posts[] = query_posts(array('blog_id' => $value));
            }

            foreach ($posts as $key => $post) {
                if ($post) {
                    foreach ($post as $key => $p) {
                        $results[] = $p;
                    }
                }
            }

            $CI->data['posts']['posts_data'] = $results;
        }

        if ($CI->data['posts']) {
            $CI->load->ext_view('plugins/slider_plugin/slider_plugin_widget', $CI->data['posts']);
        }
    }

    public function get_data()
    {
        $CI =& get_instance();

        // Get data
        $CI->data['post_data'] = query_posts();

        $slider_data = $CI->setting_m->get_setting($this->_plugin_dir);
        if ($slider_data) {
            $CI->data['sliders'] = $slider_data;
        } else {
            $CI->data['sliders'] = array(
                'blog_id' => ''
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