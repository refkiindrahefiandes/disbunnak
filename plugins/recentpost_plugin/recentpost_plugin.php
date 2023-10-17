<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Recentpost Plugin
* @author	Masriadi
*/
class Recentpost_plugin {
    public $_plugin_name        = 'Recent Post Plugin';
    public $_plugin_desc        = 'Plugin to add recent post widget';
    public $_plugin_dir         = 'recentpost_plugin';
    public $_widget_name        = 'Recent Post Plugin';
    public $_plugin_widget_name = 'recentpost_plugin_widget';

	public function index()
	{
		$CI =& get_instance();

        // check_widget widget
        $this->widget_init();

        // Get data
        $this->get_data();

        // Process the form
        if ($CI->input->method(TRUE) == 'POST' && $CI->validate_modify('Plugin')) {
            $data[$this->_plugin_dir] = $CI->input->post('recentpost');
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

        $CI->data['recentpost_data'] = array();
        $CI->data['recentpost_data']['posts_data'] = array();
        foreach ($widget_data as $widget) {
            if (array_key_exists($widget['value']['widget_data'], $CI->data['recentpost'])) {
                if (isset($widget['value']['widget_title'][$language_code])) {
                    $CI->data['recentpost_data']['widget_title'] = $widget['value']['widget_title'][$language_code];
                }
                $recentpost_data = query_posts_term(array('slug' => 'berita', 'slug_type' => 'category', 'limit' => $CI->data['recentpost'][$widget['value']['widget_data']]['limit']));
            }

            if ($recentpost_data) {
                $CI->data['recentpost_data']['posts_data'] = $recentpost_data;
            }
        }

        if ($CI->data['recentpost_data']) {
            $CI->load->ext_view('plugins/recentpost_plugin/recentpost_plugin_widget', $CI->data['recentpost_data']);
        }
    }

    public function get_data()
    {
        $CI =& get_instance();

        // Get data
        $recentpost_data = $CI->setting_m->get_setting($this->_plugin_dir);

        if ($recentpost_data) {
            $CI->data['recentpost'] = $recentpost_data;
        } else {
            $CI->data['recentpost'][] = array(
                'limit' => ''
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