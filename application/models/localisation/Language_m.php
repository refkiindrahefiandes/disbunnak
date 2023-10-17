<?php
class Language_M extends MY_Model
{
	protected $_table_name = 'language';
	protected $_order_by = 'language_id';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required'
		),
		'language_code' => array(
			'field' => 'language_code',
			'label' => 'Code',
			'rules' => 'trim|required|callback__unique_code'
		),
		'locale' => array(
			'field' => 'locale',
			'label' => 'Locale',
			'rules' => 'trim|required'
		),
		'image' => array(
			'field' => 'image',
			'label' => 'Image',
			'rules' => 'trim|required'
		),
		'date_format_lite' => array(
			'field' => 'date_format_lite',
			'label' => 'Date Format',
			'rules' => 'trim|required'
		),
		'date_format_full' => array(
			'field' => 'date_format_full',
			'label' => 'Data Format (Full)',
			'rules' => 'trim|required'
		)
	);

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_language()
	{
		$result = array(
			'language_id'      => '',
			'name'             => set_value('name'),
			'language_code'    => set_value('language_code'),
			'locale'           => set_value('locale'),
			'image'            => set_value('image'),
			'date_format_lite' => 'd M Y',
			'date_format_full' => 'd M Y H:i:s',
			'sort_order'       => '',
			'status'           => 1,
			'is_rtl'           => 0
        );
		return $result;
	}

	public function get_language($id = NULL)
	{
		if ($id !== NULL) {
	        $this->db->select('*');
	        $this->db->from($this->_table_name);
	        $this->db->where('language_id', $id);
	        $result = $this->db->get()->row_array();

	        if ($result) {
	        	return $result;
	        }
		} else {
	        $this->db->select('*');
	        $this->db->from($this->_table_name);
	        $result = $this->db->get()->result_array();

	        if ($result) {
	        	return $result;
	        }
		}

        return false;
	}

	public function save_language($data, $id = NULL)
	{
		if($data) {
			if( (int) $id > 0)
			{
				$this->db->set($data);
				$this->db->where('language_id', $id);
				$this->db->update($this->_table_name);
			}
			else
			{
				unset($id);
				$this->db->set($data);
				$this->db->insert($this->_table_name);
			}
		}
	}

	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where('language_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}

	public function delete_language($id)
	{
		$this->db->where('language_id', $id);
		$this->db->delete($this->_table_name);
	}

}