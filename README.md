# Web DPMPTSPTK

Website DPMPTSPTK

Instalasi

1. Buat file application/config/constants.php

<?php defined('BASEPATH') OR exit('No direct script access allowed');
$URL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']) : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']);

defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb');
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b');
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');
defined('EXIT_SUCCESS')         OR define('EXIT_SUCCESS', 0);
defined('EXIT_ERROR')           OR define('EXIT_ERROR', 1);
defined('EXIT_CONFIG')          OR define('EXIT_CONFIG', 3);
defined('EXIT_UNKNOWN_FILE')    OR define('EXIT_UNKNOWN_FILE', 4);
defined('EXIT_UNKNOWN_CLASS')   OR define('EXIT_UNKNOWN_CLASS', 5);
defined('EXIT_UNKNOWN_METHOD')  OR define('EXIT_UNKNOWN_METHOD', 6);
defined('EXIT_USER_INPUT')      OR define('EXIT_USER_INPUT', 7);
defined('EXIT_DATABASE')        OR define('EXIT_DATABASE', 8);
defined('EXIT__AUTO_MIN')       OR define('EXIT__AUTO_MIN', 9);
defined('EXIT__AUTO_MAX')       OR define('EXIT__AUTO_MAX', 125);
defined('BASE_URL')             OR define('BASE_URL', $URL.'/'); // URL Aplikasi
defined('ADMIN_ASSETS_URL')     OR define('ADMIN_ASSETS_URL', BASE_URL . 'themes/admin/assets/');
defined('FRONTEND_URL')         OR define('FRONTEND_URL', BASE_URL . 'themes/frontend/');
defined('THUMBNAIL_IMAGE_DEFAULT')      OR define('THUMBNAIL_IMAGE', 'uploads/images/default/default-thumbnail-image.png');
defined('THUMBNAIL_FILE_DEFAULT')       OR define('THUMBNAIL_FILE', 'uploads/images/default/default-thumbnail-file.png');

2. Buat file application/config/database.php

<?php defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default']['dsn'] = '';
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'johndoe';
$db['default']['password'] = 'toor';
$db['default']['database'] = 'kuansing';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = (ENVIRONMENT !== 'production');
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_unicode_ci';
$db['default']['swap_pre'] = '';
$db['default']['encrypt']  = FALSE;
$db['default']['compress'] = FALSE;
$db['default']['stricton'] = FALSE;
$db['default']['failover'] = array();
$db['default']['save_queries'] = TRUE;

3. Buat file .htaccess

<IfModule mod_rewrite.c>

    Options +FollowSymLinks
    RewriteEngine on

    # Send request via index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]

</IfModule>

4. Import database
