<?php
class Language_M extends MY_Model
{
	protected $_table_name = 'language';
	protected $_order_by = 'language_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
	}
}