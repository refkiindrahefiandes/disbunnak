<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Loader extends CI_Loader {
	function  __construct() {
		parent::__construct();
		$CI =& get_instance();
		$CI->load = $this;
	}

	public function ext_view($view, $vars = array(), $return = FALSE){
		$_ci_ext = pathinfo($view, PATHINFO_EXTENSION);
		$view = ($_ci_ext == '') ? $view.'.php' : $view;

		if (method_exists($this, '_ci_object_to_array')) {
			return $this->_ci_load(array(
				'_ci_vars' => $this->_ci_object_to_array($vars),
				'_ci_path' => $view, '_ci_return' => $return)
			);
		} else {
			return $this->_ci_load(array(
				'_ci_vars' => $this->_ci_prepare_view_vars($vars),
				'_ci_path' => $view, '_ci_return' => $return)
			);
		}
	}

}