<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Override default site_url() helper
 * @author Based on https://github.com/devtime-share/codeigniter-kitlang
 * @version 1.0
 */
if ( ! function_exists('site_url'))
{
    function site_url($uri = '', $default = FALSE)
    {
        $CI =& get_instance();
        if (! $default)
        {
            $lang = $CI->data['language_code'];
            if (is_array($uri))
            {
                array_unshift($uri, $lang);
            }
            else
            {
                $uri = $lang . "/" . $uri;
            }
        }
        return $CI->config->site_url($uri);
    }
}