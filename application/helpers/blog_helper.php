<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Slug helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('get_slug')) {
    function get_slug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

/**
 * Menus helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('get_menus')) {
    function get_menus($name = NULL, $params)
    {
        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $menus = $CI->frontend_m->get_front_menus($name, $params);

        echo $menus;
    }
}

/**
 * Query posts helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('query_posts')) {
    function query_posts($params = array())
    {
        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');
        $default_params = array(
            'blog_id'       => NULL,
            'user_id'       => NULL,
            'slug'          => NULL,
            'language_code' => $CI->data['language_code'],
            'search_query'  => NULL,
            'offset'        => NULL,
            'limit'         => 0,
            'sort_order'    => 'desc'
        );

        $blogs = $CI->frontend_m->get_posts(array_merge($default_params, $params));

        if ($blogs) {
            foreach ($blogs as $blog) {
                $blogs_data[] = array(
                    'blog_id'        => $blog['blog_id'],
                    'user_info'      => $CI->frontend_m->get_user_info(md5($blog['user_id'])),
                    'category_info'  => $CI->frontend_m->get_terms_info(array('blog_id' => $blog['blog_id'], 'term_type' => 'category')),
                    'thumb'          => $blog['image'],
                    'video'          => $blog['video'],
                    'url'            => site_url('blog/' . $blog['slug']),
                    'title'          => $blog['title'],
                    'date_published' => short_date(trim($CI->data['date_format_lite']), $blog['date_published'], $blog['language_code']),
                    'content'        => $blog['content'],
                    'total_comments' => $CI->frontend_m->count_totals('blog_comment', array('blog_id' => $blog['blog_id'])),
                    'tags'           => $CI->frontend_m->get_terms_info(array('blog_id' => $blog['blog_id'], 'term_type' => 'tag')),
                    'galleries'      => $blog['galleries']
                );
            }
            return $blogs_data;
        }
    }
}

/**
 * Query posts by term helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('query_posts_term')) {
    function query_posts_term($params = array())
    {

        $default_params = array(
            'term_id'    => NULL,
            'slug'       => NULL,
            'slug_type'  => NULL,
            'offset'     => NULL,
            'limit'      => 0,
            'sort_order' => 'desc'
        );

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        return $CI->frontend_m->get_posts_byterm(array_merge($default_params, $params));
    }
}

/**
 * Query pages helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('query_pages')) {
    function query_pages($params = array())
    {

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $pages = $CI->frontend_m->get_pages($params);

        if ($pages) {
            foreach ($pages as $page) {
                $pages_data[] = array(
                    'page_id'        => $page['page_id'],
                    'url'            => base_url('page/single/' . $page['slug']),
                    'title'          => $page['title'],
                    'thumb'          => $page['image'],
                    'description'    => html_entity_decode($page['description']),
                    'galleries'      => $page['galleries']
                );
            }
            return $pages_data;
        }
    }
}

/**
 * Query agenda helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('query_agendas')) {
    function query_agendas($params = array())
    {

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $default_params = array(
            'agenda_id'  => NULL,
            'slug'       => NULL,
            'offset'     => NULL,
            'limit'      => 0,
            'sort_order' => 'desc'
        );

        $agendas = $CI->frontend_m->get_agendas(array_merge($default_params, $params));

        if ($agendas) {
            foreach ($agendas as $agenda) {
                $agendas_data[] = array(
                    'agenda_id'   => $agenda['agenda_id'],
                    'date_begin'  => $agenda['date_begin'],
                    'date_end'    => $agenda['date_end'],
                    'time'        => $agenda['time'],
                    'location'    => $agenda['location'],
                    'organizer'   => $agenda['organizer'],
                    'status'      => $agenda['status'],
                    'description' => html_entity_decode($agenda['description']),
                    'slug'        => $agenda['slug'],
                    'information' => html_entity_decode($agenda['information'])
                );
            }
            return $agendas_data;
        }
    }
}

/**
 * Get_id_byslug helper
 * @author Masriadi
 * @version 1.0
 */

if (!function_exists('query_services')) {
    function query_services($params = array())
    {

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $default_params = array(
            'layanan_id' => NULL,
            'slug'       => NULL,
            'offset'     => NULL,
            'limit'      => 0,
            'sort_order' => 'asc'
        );

        $services = $CI->frontend_m->get_services(array_merge($default_params, $params));

        if ($services) {
            foreach ($services as $service) {
                $services_data[]   = array(
                    'layanan_id'   => $service['layanan_id'],
                    'title'        => $service['title'],
                    'slug'         => $service['slug'],
                    'description'  => html_entity_decode($service['description']),
                    'status'       => $service['status']
                );
            }
            return $services_data;
        }
    }
}

/**
 * Get_id_byslug helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('get_id_byslug')) {
    function get_id_byslug($params = array())
    {

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $default_params = array(
            'table' => NULL,
            'slug'  => NULL
        );

        $result = $CI->frontend_m->get_id_byslug(array_merge($default_params, $params));
        return $result;
    }
}

/**
 * Query comments helper
 * @author Masriadi
 * @version 1.0
 */
if (!function_exists('get_list_comments')) {
    function get_list_comments($params = array())
    {
        $default_params = array(
            'style'       => 'div',
            'avatar_size' => 56,
            'blog_id'     => ''
        );

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        $comments = $CI->frontend_m->get_comments(array_merge($default_params, $params));

        if ($comments) {
            echo $comments;
        }
    }
}

/**
 * Get Excerpt helper
 * @author Based on http://www.phpsnaps.com/snaps/view/get-excerpt-from-string/
 * @version 1.0
 */
if (!function_exists('get_excerpt')) {
    function get_excerpt($str = NULL, $max_lenght)
    {
        if (strlen($str) > $max_lenght) {
            $excerpt    = substr($str, 0, $max_lenght - 3);
            $last_space = strrpos($excerpt, ' ');
            $excerpt    = substr($excerpt, 0, $last_space);
            $excerpt   .= '...';
        } else {
            $excerpt = $str;
        }

        return strip_tags($excerpt);
    }
}

if (!function_exists('check_is_ajax')) {
    function check_is_ajax($redirect = 'dashboard')
    {
        define('AJAX_REQUEST', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if (!AJAX_REQUEST) {
            redirect('admin/' . $redirect);
        }
        return false;
    }
}


if (!function_exists('query_pengaduan')) {
    function query_pengaduan($params = array())
    {

        $default_params = array(
            'offset'     => NULL,
            'limit'      => 0,
            'sort_order' => 'desc'
        );

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        return $CI->frontend_m->get_pengaduan(array_merge($default_params, $params));
    }
}


if (!function_exists('query_detail_layanan')) {
    function query_detail_layanan($params = array())
    {

        $default_params = array(
            'offset'     => NULL,
            'limit'      => 0,
            'sort_order' => 'desc',
            'parameter'    => NULL,
        );

        $CI = &get_instance();
        $CI->load->model('frontend/frontend_m');

        return $CI->frontend_m->get_detail_layanan(array_merge($default_params, $params));
    }
}
