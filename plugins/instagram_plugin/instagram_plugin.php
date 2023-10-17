<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Recentpost Plugin
* @author	Masriadi
*/
class Instagram_plugin {
    public $_plugin_name        = 'Instagram Plugin';
    public $_plugin_desc        = 'Plugin to add instagram widget';
    public $_plugin_dir         = 'instagram_plugin';
    public $_widget_name        = 'Instagram Plugin';
    public $_plugin_widget_name = 'instagram_plugin_widget';

    public function index()
	{
		$CI =& get_instance();

        // check_widget widget
        $this->widget_init();

        // Get data
        $this->get_data();

        // Process the form
        if ($CI->input->method(TRUE) == 'POST' && $CI->validate_modify('Plugin')) {
            $data[$this->_plugin_dir] = $CI->input->post('instagram');
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

        $CI->data['instagram_data'] = array();
        foreach ($widget_data as $widget) {
            if (array_key_exists($widget['value']['widget_data'], $CI->data['instagram'])) {
                if (isset($widget['value']['widget_title'][$language_code])) {
                    $CI->data['instagram_data']['widget_title'] = $widget['value']['widget_title'][$language_code];
                }

                $instagram_data = $CI->data['instagram'][$widget['value']['widget_data']];
            }
        }

        if ($instagram_data) {
            $results_array = $this->scrape_insta($instagram_data['username']);
            $images = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];

            $instagram = array();
            if (count($images)) {
                foreach ( $images as $image ) {
                    $image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] );
                    $image['display_src'] = preg_replace( '/^https?\:/i', '', $image['display_src'] );

                    $instagram[] = array(
                        'code'      => $image['code'],
                        'link'      => '//instagram.com/p/' . $image['code'],
                        'thumbnail' => $image['thumbnail_src'],
                        'original'  => $image['display_src'],
                        'target'    => $instagram_data['target']
                    );
                }
            }

            $CI->data['instagram_data']['widget_data'] = array_splice($instagram, 0, $instagram_data['limit']);
        }

        if ($CI->data['instagram_data']) {
            $CI->load->ext_view('plugins/instagram_plugin/instagram_plugin_widget', $CI->data['instagram_data']);
        }
    }

    public function get_data()
    {
        $CI =& get_instance();

        // Get data
        $instagram_data = $CI->setting_m->get_setting($this->_plugin_dir);

        if ($instagram_data) {
            $CI->data['instagram'] = $instagram_data;
        } else {
            $CI->data['instagram'][] = array(
                'username' => '',
                'limit'    => '',
                'target'   => ''
            );
        }

        $CI->data['target'] = array(
            '_self'  => 'Current window (_self)',
            '_blank' => 'New window (_blank)',
        );
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

    // based on https://gist.github.com/cosmocatalano/4544576
    public function scrape_insta($username) {
        $insta_source = @file_get_contents('https://www.instagram.com/'.$username);
        printr($insta_source); die();
        if ($insta_source !== FALSE) {
            $shards = explode('window._sharedData = ', $insta_source);
            $insta_json = explode(';</script>', $shards[1]);
            $insta_array = json_decode($insta_json[0], TRUE);
            return $insta_array;
        }
    }

}