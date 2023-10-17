<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Recentpost Plugin
* @author	Masriadi
*/
class Codesample_plugin {
    public $_plugin_name = 'Code Sample';
    public $_plugin_desc = 'Code Sample menambahkan fungsionalitas Syntax Hightlight pada Editor TinyMCE';
    public $_plugin_dir  = 'codesample_plugin';

    public function add_tmce_plugin()
    {
        $add['plugins'] = array('codesample');
        $add['toolbars'] = array('codesample');
        return $add;
    }

    public function add_enqueue_scripts()
    {
        $add_scripts = array(
            $this->_plugin_dir . '/assets/prism.js'
        );
        return $add_scripts;
    }

    public function add_enqueue_styles()
    {
        $add_styles = array(
            $this->_plugin_dir . '/assets/prism.css'
        );
        return $add_styles;
    }
}