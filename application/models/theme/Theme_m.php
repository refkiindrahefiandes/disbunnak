<?php
class Theme_M extends MY_Model
{
	protected $_table_name  = 'theme';
	protected $_primary_key = 'theme_id';
	protected $_order_by    = '';
	public $rules           = array();

	function __construct ()
	{
		parent::__construct();
	}

	public function set_default_theme()
	{
		$add_default_theme = array(
			'active_theme' => 'default'
		);

		$this->setting_m->save_setting($add_default_theme);
	}
}