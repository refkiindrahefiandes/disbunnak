<?php
class Kbli_M extends MY_Model
{
	protected $_table_name  = 'dm_kbli';
	protected $_primary_key = 'kbli_id';
	protected $_order_by    = 'kbli_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
	}
}