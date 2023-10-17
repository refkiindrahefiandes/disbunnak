<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Recentpost Plugin
* @author	Masriadi
*/
class Media_plugin {
    public $_plugin_name = 'Media Plugin';
    public $_plugin_desc = 'Media plugin menambahkan fungsionalitas Media Manager pada Editor TinyMCE';
    public $_plugin_dir  = 'media_plugin';

    public function add_tmce_plugin()
    {
        $add['plugins'] = array('mediamanager');
        $add['toolbars'] = array('mediamanager');
        return $add;
    }

    public function add_admin_enqueue_scripts()
    {
        $add_scripts = array(
            $this->_plugin_dir . '/assets/mediamanager_plugin.js'
        );
        return $add_scripts;
    }
}