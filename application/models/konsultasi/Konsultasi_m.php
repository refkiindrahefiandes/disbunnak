<?php
class Konsultasi_M extends MY_Model
{
	protected $_table_name = 'konsultasi';
	protected $_order_by = 'konsul_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
		$this->load->model('setting/setting_m');
		$this->load->library('email');
	}

	public function get_contacts($id = NULL)
	{
		if ($id) {
			$this->_table_name = 'konsultasi';
			$where = array(
				'konsul_id' => $id
			);
	        $result = $this->get_by($where, TRUE);

			if ($result) {
				return $result;
			}

			return false;
		}
	}

	public function save_contact($data, $id = NULL)
	{
		$this->_table_name = 'konsultasi';
		if( (int) $id > 0)
		{
			$this->db->set($data);
			$this->db->where('konsul_id', $id);
			$this->db->update($this->_table_name);
		}
		
		
	}

	public function save_replay($data = NULL, $id = NULL)
	{
		$this->_table_name = 'konsultasi_reply';
		$data_reply = array(
			'konsul_id'   => $data['konsul_id'],
			'user_email'  => $data['user_email'],
			'reply_title' => $data['reply_title'],
			'reply_desc'  => $data['reply_desc']
		);

		// SAVE RESPOND IF EMAIL SUCCES
		if($data_reply)
		{
			if( (int) $data['konsul_id'] > 0)
			{
				$this->db->set($data_reply);
				$this->db->insert($this->_table_name);

				$this->_table_name = 'konsultasi';
				$data_contact['status'] = $data['status'];
				$data_contact['date_modified'] = date('Y-m-d');
				if($data_contact)
				{
					if( (int) $data['konsul_id'] > 0)
					{
						$this->db->set($data_contact);
						$this->db->where('konsul_id', $id);
						$this->db->update($this->_table_name);
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function delete_contact($id)
	{
		$this->db->where('konsul_id', $id);
		$this->db->delete('konsultasi');
	}

}