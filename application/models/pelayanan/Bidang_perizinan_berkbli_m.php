<?php
class Bidang_perizinan_berkbli_M extends MY_Model
{
	protected $_table_name  = 'bidang_perizinan_berkbli';
	protected $_primary_key = 'bidang_id';
	protected $_order_by    = 'bidang_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_bidang()
	{
		$result = array(
            'bidang_id' => '',
            'name'        => '',
            'parent_id'   => '',
            'sort_order'  => '',
            'status'      => 1
	    );

		return $result;
	}
}