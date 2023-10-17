<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Banner Plugin
* @author	Masriadi
*/
class Banner_plugin {
    public $_plugin_name        = 'Banner Plugin';
    public $_plugin_desc        = 'Plugin to add banner widget';
    public $_plugin_dir         = 'banner_plugin';
    public $_widget_name        = 'Banner Plugin';
    public $_plugin_widget_name = 'banner_plugin_widget';

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
            if ($CI->input->post('banner')) {
                foreach ($CI->input->post('banner') as $key => $items) {
                    if (count($items)) {
                        foreach ($items as $i) {
                            $results[$key][] = array(
                                'banner_image' => $i['banner_image'] ? $i['banner_image'] : 'uploads/images/default/default-thumbnail.png',
                                'banner_url'   => $i['banner_url'],
                                'jumlah_kolom' => $i['jumlah_kolom'],
                                'status'       => $i['status'] ? $i['status'] : '0'
                            );
                        }
                    }
                }

                $data[$this->_plugin_dir] = $results;
                $CI->setting_m->save_setting($data);
                redirect($CI->data['redirect']);
            } elseif ($CI->input->post('banner') == NULL) {
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
        $CI->data['banners_data'] = array();
        $widget_data = $CI->widget_m->get_widget_item(array('widget_item_id' => $widget_item_id));
        foreach ($widget_data as $widget) {
            if (array_key_exists($widget['value']['widget_data'], $CI->data['banners'])) {
                if (isset($widget['value']['widget_title'][$language_code])) {
                    $CI->data['banners_data']['widget_title'] = $widget['value']['widget_title'][$language_code];
                }

                $CI->data['banners_data']['banners'] = $CI->data['banners'][$widget['value']['widget_data']];
            }
        }

        // printr($CI->data['banners_data']); die();

        if ($CI->data['banners_data']) {
            $CI->load->ext_view('plugins/banner_plugin/banner_plugin_widget', $CI->data['banners_data']);
        }
    }

    public function get_data()
    {
        $CI =& get_instance();

        // Get data
        $CI->data['banners'][] = array();

        $banner_data = $CI->setting_m->get_setting($this->_plugin_dir);
        if ($banner_data) {
            $CI->data['banners'] = $banner_data;
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