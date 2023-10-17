<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Class Plugin
* @author	Masriadi
*/
class Plugins
{
	public function load($plugin = NULL)
	{
		if ($plugin) {
			$file = FCPATH . 'plugins/' . $plugin . '/' . $plugin . '.php';
			if (file_exists($file) && is_file($file)) {
				@include_once($file);
			}
		}
	}
}