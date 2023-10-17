<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;

// Backend
$route['admin'] = "admin/dashboard";

// Frontend
@require_once(BASEPATH . 'database/DB.php');
$db     = &DB();
$query  = $db->get('language');
$result = $query->result();

foreach ($result as $value) {
	$code[] = $value->language_code;
}

$group_langs = implode('|', $code);
$route["($group_langs)"]                            = $route['default_controller'];
$route["($group_langs)/blog/(:any)"]                = "blog/single/$2";
$route["($group_langs)/blog/category/(:any)"]       = "blog/category/$2";
$route["($group_langs)/blog/tag/(:any)"]            = "blog/tag/$2";
$route["($group_langs)/page/(:any)"]                = "page/index/$2";
$route["($group_langs)/agenda"]                     = "agenda/index/";
$route["($group_langs)/agenda/(:any)"]              = "agenda/index/$2";
$route["($group_langs)/author/get/(:any)"]          = "author/get/$2";
$route["($group_langs)/search"]                     = "search";
$route["($group_langs)/search/index/(:any)/(:any)"] = "search/index/$2";
$route["($group_langs)/contact"]                    = "contact";
$route["($group_langs)/download"]                   = "download";
$route["($group_langs)/download/(:any)"]            = "download/index/$2";
$route["($group_langs)/skm"]                        = "skm";
// $route["($group_langs)/skm/(:any)"]                 = "skm/index/$2";
$route["($group_langs)/skm/penilaian"]              = "skm/penilaian/$2";

// Agenda
$route["($group_langs)/agenda/(:any)"]              = "agenda/single/$2";

//front user dasboard
$route["($group_langs)/user/login"]          = "user/login";
$route["($group_langs)/home"]                = "home";
$route["($group_langs)/user/logout"]         = "user/logout";
$route["($group_langs)/user/register"]       = "user/register";
$route["($group_langs)/user/forgoten"]       = "user/forgoten";
$route["($group_langs)/user/reset_password"] = "user/reset_password";
$route["($group_langs)/user/edit"]           = "user/edit";
$route["($group_langs)/pengaduan"]           = "pengaduan";
$route["($group_langs)/konsultasi"]          = "konsultasi";
$route["($group_langs)/pengaduan/laporan"]   = "pengaduan/laporan";
$route["($group_langs)/konsultasi/laporan"]  = "konsultasi/laporan";

// Sitemap
$route["($group_langs)/sitemap.xml"] = "sitemap";
$route["sitemap.xml"]                = "sitemap";

// Rss Feed
$route["($group_langs)/rss"]  = "feed";
$route["($group_langs)/feed"] = "feed";
$route["rss"]                 = "feed";
$route["feed"]                = "feed";
