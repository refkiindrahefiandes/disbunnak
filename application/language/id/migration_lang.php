<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['migration_none_found']          = 'Tidak ada migrasi yang ditemukan.';
$lang['migration_not_found']           = 'Migrasi ini tidak ditemukan.';
$lang['migration_sequence_gap']        = 'There is a gap in the migration sequence near version number: %s.';
$lang['migration_multiple_version']    = 'Terdapat multi-migrasi dengan nomor versi yang sama: %d.';
$lang['migration_class_doesnt_exist']  = 'Migration class "%s" tidak ditemukan.';
$lang['migration_missing_up_method']   = 'Migration class "%s" tidak terdapat "up" method.';
$lang['migration_missing_down_method'] = 'Migration class "%s" tidak terdapat "down" method.';
$lang['migration_invalid_filename']    = 'Nama Migrasi "%s" tidak sah.';