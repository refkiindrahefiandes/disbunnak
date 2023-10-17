<?php
class Download_M extends MY_Model
{
	protected $_table_name  = 'download';
	protected $_primary_key = 'download_id';
	protected $_order_by    = 'download_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
		$this->load->model('setting/setting_m');
	}

	public function get_new_download()
	{
		$result = array(
			'download_id'          => '',
			'download_category_id' => '',
			'name'                 => set_value('name'),
			'filename'             => set_value('filename'),
			'mask'                 => '',
			'date_added'           => '',
			'status'               => 1
	    );

		return $result;
	}

	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where('download_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}
}