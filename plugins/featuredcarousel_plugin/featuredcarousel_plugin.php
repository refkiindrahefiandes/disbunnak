<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Featured Carousel Plugin
* @author   Masriadi
*/
class Featuredcarousel_plugin {
    public $_plugin_name        = 'Featured Carousel Plugin';
    public $_plugin_desc        = 'Plugin to add banner carousel widget';
    public $_plugin_dir         = 'featuredcarousel_plugin';
    public $_widget_name        = 'Featured Carousel Plugin';
    public $_plugin_widget_name = 'featuredcarousel_plugin_widget';

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
            if ($CI->input->post('featuredcarousel')) {
                foreach ($CI->input->post('featuredcarousel') as $key => $items) {
                    if (count($items)) {
                        foreach ($items as $i) {
                            $results[$key][] = array(
                                'featuredcarousel_image' => $i['featuredcarousel_image'] ? $i['featuredcarousel_image'] : 'uploads/images/default/default-thumbnail.png',
                                'featuredcarousel_title' => $i['featuredcarousel_title'],
                                'featuredcarousel_link'  => $i['featuredcarousel_link'],
                                'status'                 => $i['status'] ? $i['status'] : '0'
                            );
                        }
                    }
                }

                $data[$this->_plugin_dir] = $results;
                $CI->setting_m->save_setting($data);
                redirect($CI->data['redirect']);
            } elseif ($CI->input->post('featuredcarousel') == NULL) {
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
        $CI->data['featuredcarousels_data'] = array();
        $widget_data = $CI->widget_m->get_widget_item(array('widget_item_id' => $widget_item_id));
        foreach ($widget_data as $widget) {
            if (array_key_exists($widget['value']['widget_data'], $CI->data['featuredcarousels'])) {
                if (isset($widget['value']['widget_title'][$language_code])) {
                    $CI->data['featuredcarousels_data']['widget_title'] = $widget['value']['widget_title'][$language_code];
                }

                $CI->data['featuredcarousels_data']['featuredcarousels'] = $CI->data['featuredcarousels'][$widget['value']['widget_data']];
            }
        }
        // printr($CI->data['featuredcarousels_data']); die();
        if ($CI->data['featuredcarousels_data']) {
            $CI->load->ext_view('plugins/featuredcarousel_plugin/featuredcarousel_plugin_widget', $CI->data['featuredcarousels_data']);
        }
    }

    public function get_data()
    {
        $CI =& get_instance();

        // Get data
        $CI->data['featuredcarousels'][] = array();

        // Get data
        $CI->data['pages'] = query_pages();

        // printr($CI->data['pages']); die();

        $featuredcarousel_data = $CI->setting_m->get_setting($this->_plugin_dir);
        if ($featuredcarousel_data) {
            $CI->data['featuredcarousels'] = $featuredcarousel_data;
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