<?php
class Skm_M extends MY_Model
{
	protected $_table_name  = 'app_skm';
	protected $_primary_key = 'skm_id';
	protected $_order_by    = 'skm_id';
	public $rules = array(
		'judul' => array(
			'field' => 'judul',
			'label' => 'Judul',
			'rules' => 'trim|required'
		),
		'keterangan' => array(
			'field' => 'keterangan',
			'label' => 'Keterangan',
			'rules' => 'trim|required'
		)
	);

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_skm()
	{
		$result = array(
			'judul'      => set_value('judul'),
			'keterangan' => set_value('keterangan'),
			'status'     => set_value('status')
        );
		return $result;
	}

	public function delete_skm($id)
	{
		$this->db->where($this->_primary_key, $id);
		$this->db->delete($this->_table_name);
	}
}