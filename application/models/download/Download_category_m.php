<?php
class Download_category_M extends MY_Model
{
	protected $_table_name  = 'download_category';
	protected $_primary_key = 'download_category_id';
	protected $_order_by    = 'download_category_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_download_category()
	{
		$result = array(
			'download_category_id' => '',
			'name'                 => set_value('name'),
			'description'          => set_value('description'),
			'sort_order'           => '',
			'status'               => set_value('status'),
	    );

		return $result;
	}

	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where('download_category_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}

	public function get_download_category_name($id=NULL)
	{
		$result = $this->get($id);

		if ($result) {
			return $result['name'];
		}
		return FALSE;
	}
}