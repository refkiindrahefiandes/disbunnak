<?php

$panel_file  = "/admin_panel/admin_panel.php";

$theme_option_default = array(
	'main_color'             => 'c36678',
	'navbar_header_bg'       => '212429',
	'footer_bg'              => '17191C',
	'facebook_moderation_id' => 'masriadi.doank',
	'about_us_title'         => '',
	'about_us_description'   => '',
	'about_us_location'      => '',
	'about_us_image'         => 'uploads/images/default/default-thumbnail.png',
	'about_us_social'        => array(),
	'footer_script'          => '',
	'location'               => '',

	// WEB PKM
	'web_profile'                  => '',
	'web_profile_url'              => '',
	'organisation_visi'            => '',
	'organisation_misi'            => '',
	'organisation_tata_nilai'      => '',
	'organisation_motto'           => '',
	'organisation_janji_pelayanan' => ''
);

// Split Tanggal dan Bulan Agenda
if (!function_exists('date_agenda')) {
    function date_agenda($index, $date) {
        $split = array();
        $split = explode(" ", $date);
        return $split[$index];
    }
}



