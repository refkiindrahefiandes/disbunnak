<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Get Gravatar helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('get_gravatar')) {
    function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
    {
        $url = '//www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}

/**
 * Print_r helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('printr')) {
    function printr($var, $echo = TRUE)
    {
        $output = '<pre style="position:absolute; z-index: 10001;">' . print_r($var, TRUE) . '</pre>';
        echo $output;
        return;
    }
}

/**
 * Clean output helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('clean_output')) {
    function clean_output($str = NULL)
    {
        // return $str;
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Glob_recursive helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('glob_recursive')) {
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        $exclude = array(
            'uploads/images/cache',
            'uploads/images/default'
        );
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            if (!in_array($dir, $exclude)) {
                $files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
            }
        }
        return $files;
    }
}

/**
 * Search array helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('search_array')) {
    function search_array($names, $array, $key)
    {
        $store_all_name = array();
        foreach ($array as $name) {
            array_push($store_all_name, $name[$key]);
        }

        $results = preg_grep('/' . $names . '/i', $store_all_name);

        $files = array();
        foreach ($results as $key => $value) {
            $files[] = $array[$key];
        }

        return $files;
    }
}

/**
 * Sort array helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('sort_array')) {
    function sort_array($array, $col, $order = 'asc')
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $col) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case 'asc':
                    asort($sortable_array);
                    break;
                case 'desc':
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
}

/**
 * Image helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('image_thumb')) {
    function image_thumb($image_path, $size = 'medium')
    {
        // Get the CodeIgniter super object
        $CI = &get_instance();
        $CI->load->model('setting/setting_m');
        $media_setting = $CI->setting_m->get_setting('media_setting');

        if ($size === 'larger') {
            $width  = $media_setting['image_lg_width'];
            $height = $media_setting['image_lg_height'];
        } elseif ($size === 'medium') {
            $width  = $media_setting['image_md_width'];
            $height = $media_setting['image_md_height'];
        } elseif ($size === 'small') {
            $width  = $media_setting['image_sm_width'];
            $height = $media_setting['image_sm_height'];
        } else {
            $width  = $media_setting['image_lg_width'];
            $height = $media_setting['image_lg_height'];
        }

        // Path to image thumbnail
        $cache_path  = 'uploads/images/cache/'; //dirname( $image_path ) . '/cache/';
        $image_thumb =  $cache_path . $width . 'x' . $height . '_' . basename($image_path);

        if (!is_dir($cache_path)) {
            mkdir($cache_path, 0755, TRUE);
        }

        if (!file_exists($image_thumb)) {
            // LOAD LIBRARY
            $CI->load->library('image_lib');

            // CONFIGURE IMAGE LIBRARY
            $config['image_library']    = 'gd2';
            $config['source_image']     = $image_path;
            $config['new_image']        = $image_thumb;
            $config['maintain_ratio']   = FALSE;
            $config['height']           = $height;
            $config['width']            = $width;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
        }

        return base_url($image_thumb);
    }
}

/**
 * Video helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('video_thumb')) {
    function video_thumb($url = NULL)
    {
        $url_embed = NULL;
        $url = explode("=", $url);
        if (isset($url[1])) {
            $url_embed = '//www.youtube.com/embed/' . $url[1];
        }

        return $url_embed;
    }
}

if (!function_exists('video_thumb_image')) {
    function video_thumb_image($url = NULL)
    {
        $url_embed_image = NULL;
        $url = explode("=", $url);
        if (isset($url[1])) {
            $url_embed_image = '//img.youtube.com/vi/' . $url[1] . '/mqdefault.jpg';
        }

        return $url_embed_image;
    }
}

/**
 * Konversi Tanggal
 * @author Masriadi
 * @version 1.0
 * example : short_date('D, j M Y', 2016-12-13) result : Wed, 13 Dec 2016
 */
if (!function_exists('long_date')) {
    function long_date($format, $date = "now", $language_id = NULL)
    {
        $en = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        $lang = explode(',', lang('lang_date'));
        return str_replace($en, $lang, date($format, strtotime($date)));
    }
}

if (!function_exists('short_date')) {
    function short_date($format, $date = "now", $language_id = NULL)
    {
        $en = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        $lang = explode(',', lang('lang_date_short'));
        return str_replace($en, $lang, date($format, strtotime($date)));
    }
}

/**
 * Paginating helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('paginating')) {
    function paginating($base_url, $total_rows, $limit, $uri_segment)
    {
        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');
        $CI->load->library('pagination');

        $config['base_url']            = $base_url;
        $config['uri_segment']         = $uri_segment;
        // $config['use_page_numbers']    = TRUE;
        $config['total_rows']          = $total_rows;
        $config['per_page']            = $limit;

        // Atur bootstrap pagination
        $config['full_tag_open']       = '<ul class="pagination">';
        $config['full_tag_close']      = '</ul>';
        $config['num_tag_open']        = '<li>';
        $config['num_tag_close']       = '</li>';
        $config['cur_tag_open']        = '<li class="active"><a>';
        $config['cur_tag_close']       = '</a></li>';
        $config['next_tag_open']       = '<li>';
        $config['next_tagl_close']     = '</li>';
        $config['prev_tag_open']       = '<li>';
        $config['prev_tagl_close']     = '</li>';
        $config['first_tag_open']      = '<li>';
        $config['first_tagl_close']    = '</li>';
        $config['last_tag_open']       = '<li>';
        $config['last_tagl_close']     = '</li>';

        $CI->pagination->initialize($config);

        return $CI->pagination->create_links();
    }
}

/**
 * Is_plugin_active helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('is_plugin_active')) {
    function is_plugin_active($plugin_name = NULL)
    {
        $CI = &get_instance();
        $CI->load->model('plugin/plugin_m');

        $result = $CI->plugin_m->get_installed($plugin_name);
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/**
 * Widgets helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('get_widgets')) {
    function get_widgets($name = NULL)
    {
        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $widgets = $CI->frontend_m->get_front_widgets(trim($name));

        $results_item = get_widget_item($widgets);

        return $results_item;
    }
}

if (!function_exists('get_widget_item')) {
    function get_widget_item($widgets)
    {
        $CI = &get_instance();

        $CI->load->model('plugin/plugin_m');
        $CI->load->library('plugins');

        $plugin_data = '';
        foreach ($widgets as $widget) {
            $plugin_widget = $CI->frontend_m->get_plugin($widget['widget_type']);

            // Get plugin class from library
            if ($plugin_widget) {
                $CI->plugins->load($plugin_widget['name']);
                $query = new $plugin_widget['name']();
                $plugin_data = $query->widget($widget['widget_item_id'], $CI->data['language_code']);
            }
        }
        return $plugin_data;
    }
}

/**
 * Clean output helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('clean_output')) {
    function clean_output($str = NULL)
    {
        // return $str;
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Get language date format helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('get_language_date_format')) {
    function get_language_date_format($language_code = NULL)
    {
        $CI = &get_instance();
        $CI->load->model('localisation/language_m');

        $language = $CI->language_m->get_by(array('language_code' => $language_code), TRUE);

        if ($language) {
            return get_slug($language['date_format_lite']);
        }
    }
}

/**
 * Load script helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('load_script')) {
    function load_script($file_dir)
    {
        echo '<script src="' . $file_dir . '" type="text/javascript"></script>';
        return;
    }
}

/**
 * Load style helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('load_style')) {
    function load_style($file_dir)
    {
        echo '<link href="' . $file_dir . '" rel="stylesheet">';
        return;
    }
}

/**
 * Dynamic scripts admin from plugin helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('plugin_admin_enqueue_scripts')) {
    function plugin_admin_enqueue_scripts()
    {
        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $CI->load->library('plugins');
        $active_plugin = $CI->frontend_m->get_plugin();

        $plugin_enqueue_script = array();
        if ($active_plugin) {
            foreach ($active_plugin as $plugin) {
                $CI->plugins->load($plugin['name']);
                $load_plugin = new $plugin['name']();

                if (method_exists($load_plugin, 'add_admin_enqueue_scripts')) {
                    $plugin_enqueue_script[] = $load_plugin->add_admin_enqueue_scripts();
                }
            }
        }

        $results  = array();
        foreach ($plugin_enqueue_script as $key => $script) {
            if (count($script)) {
                foreach ($script as $key => $s) {
                    $results[] = $s;
                }
            }
        }

        $plugin_script = '';
        foreach ($results as $key => $script) {
            $plugin_script .= '<script src="' . base_url('plugins/' . $script) . '" type="text/javascript"></script>';
        }

        return $plugin_script;
    }
}

/**
 * Dynamic styles admin from plugin helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('plugin_admin_enqueue_styles')) {
    function plugin_admin_enqueue_styles()
    {
        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $CI->load->library('plugins');
        $active_plugin = $CI->frontend_m->get_plugin();

        $plugin_enqueue_style = array();
        foreach ($active_plugin as $plugin) {
            $CI->plugins->load($plugin['name']);
            $load_plugin = new $plugin['name']();

            if (method_exists($load_plugin, 'add_admin_enqueue_styles')) {
                $plugin_enqueue_styles[] = $load_plugin->add_admin_enqueue_styles();
            }
        }

        $results = array();
        foreach ($plugin_enqueue_styles as $key => $style) {
            if (count($style)) {
                foreach ($style as $key => $s) {
                    $results[] = $s;
                }
            }
        }

        $plugin_style = '';
        foreach ($results as $key => $style) {
            $plugin_style .= '<link href="' . base_url('plugins/' . $style) . '" rel="stylesheet">';
        }

        return $plugin_style;
    }
}

/**
 * Tiny MCE admin from plugin helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('tmce_init')) {
    function tmce_init($height = 400)
    {
        // Atur nilai defaul untuk plugin dan toolbar
        $default_tmce['plugin']  = array('image', 'link', 'table', 'fullscreen', 'paste', 'emoticons', 'code');
        $default_tmce['toolbar'] = array('insertfile', 'undo', 'redo', 'styleselect', 'bold', 'italic', 'underline', 'forecolor', 'alignleft', 'aligncenter', 'alignright', 'alignjustify', 'bullist', 'numlist', 'outdent', 'indent', '|', 'table', 'link', 'emoticons', 'fullscreen', 'code');

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $CI->load->library('plugins');
        $active_plugin = $CI->frontend_m->get_plugin();

        // Ambil nilai method add_tmce_plugin pada setiap plugin
        $result_plugins = array();
        foreach ($active_plugin as $plugin) {
            $CI->plugins->load($plugin['name']);
            $load_plugin = new $plugin['name']();

            if (method_exists($load_plugin, 'add_tmce_plugin')) {
                $result_plugins[] = $load_plugin->add_tmce_plugin();
            }
        }

        // Jadikan array plugin dari method semua plugin menjadi array satu tingkat
        $plugins  = array();
        foreach ($result_plugins as $key => $r) {
            if (isset($r['plugins'])) {
                foreach ($r['plugins'] as $key => $s) {
                    $plugins[] = $s;
                }
            }
        }

        // Jadikan array toolbars dari method semua plugin menjadi array satu tingkat
        $toolbars = array();
        foreach ($result_plugins as $key => $r) {
            if (isset($r['toolbars'])) {
                foreach ($r['toolbars'] as $key => $s) {
                    $toolbars[] = $s;
                }
            }
        }

        // Gabungkan array default dan array dari plugin
        $tmce['tmce_plugin'] = array_merge($default_tmce['plugin'], $plugins);
        $tmce['tmce_toolbar'] = array_merge($default_tmce['toolbar'], $toolbars);

        $txt  = '';
        $txt .= 'tinymce.init({';
        $txt .=     'selector: "textarea.textarea",';
        $txt .=     'theme: "modern",';
        $txt .=     'plugins: ' . json_encode($tmce['tmce_plugin']) . ',';
        $txt .=     'content_css: "' . ADMIN_ASSETS_URL . 'css/libs/tinymce.content.css",';
        $txt .=     'menubar: false,';
        $txt .=     'statusbar: false,';
        $txt .=     'relative_urls: false,';
        $txt .=     'remove_script_host: false,';
        $txt .=     'convert_urls: true,';
        $txt .=     'height : "' . $height . '",';
        $txt .=     'toolbar: "' . implode(' ', $tmce['tmce_toolbar']) . '"';
        $txt .= '});';

        echo $txt;
        return;
    }
}

/**
 * Dynamic scripts from plugin helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('plugin_enqueue_scripts')) {
    function plugin_enqueue_scripts()
    {
        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $CI->load->library('plugins');
        $active_plugin = $CI->frontend_m->get_plugin();

        $plugin_enqueue_script = array();
        foreach ($active_plugin as $plugin) {
            $CI->plugins->load($plugin['name']);
            $load_plugin = new $plugin['name']();

            if (method_exists($load_plugin, 'add_enqueue_scripts')) {
                $plugin_enqueue_script[] = $load_plugin->add_enqueue_scripts();
            }
        }

        $results = array();
        foreach ($plugin_enqueue_script as $key => $script) {
            if (count($script)) {
                foreach ($script as $key => $s) {
                    $results[] = $s;
                }
            }
        }

        $plugin_script = '';
        foreach ($results as $key => $script) {
            $plugin_script .= '<script src="' . base_url('plugins/' . $script) . '" type="text/javascript"></script>';
        }

        return $plugin_script;
    }
}

/**
 * Dynamic styles from plugin helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('plugin_enqueue_styles')) {
    function plugin_enqueue_styles()
    {
        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $CI->load->library('plugins');
        $active_plugin = $CI->frontend_m->get_plugin();

        $plugin_enqueue_styles = array();
        foreach ($active_plugin as $plugin) {
            $CI->plugins->load($plugin['name']);
            $load_plugin = new $plugin['name']();

            if (method_exists($load_plugin, 'add_enqueue_styles')) {
                $plugin_enqueue_styles[] = $load_plugin->add_enqueue_styles();
            }
        }

        $results = array();
        foreach ($plugin_enqueue_styles as $key => $style) {
            if (count($style)) {
                foreach ($style as $key => $s) {
                    $results[] = $s;
                }
            }
        }

        $plugin_style = '';
        foreach ($results as $key => $style) {
            $plugin_style .= '<link href="' . base_url('plugins/' . $style) . '" rel="stylesheet">';
        }

        return $plugin_style;
    }
}


/**
 * Get nilai berdasarkan skala likert helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('get_nilai_likert')) {
    function get_nilai_likert($val = NULL)
    {
        $CI = &get_instance();

        if ($val <= 20) {
            return $val . ' (Sangat Tidak Baik)';
        } elseif ($val <= 40) {
            return $val . ' (Tidak Baik)';
        } elseif ($val <= 60) {
            return $val . ' (Cukup Baik)';
        } elseif ($val <= 80) {
            return $val . ' (Baik)';
        } else {
            return $val . ' (Sangat Baik)';
        }
    }
}

if (!function_exists('alert')) {
    function alert($type = NULL, $message = NULL)
    {
        $str = '';
        switch ($type) {
            case 'success':
                $str  .= '<div class="alert alert-success alert-dismissable" role="alert">' . $message . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                break;

            case 'error':
                $str  .= '<div class="alert alert-warning alert-dismissable" role="alert">' . $message . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                break;

            default:
                $str  .= '<div class="alert alert-success alert-dismissable" role="alert">' . $message . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                break;
        }
        return $str;
    }
}
