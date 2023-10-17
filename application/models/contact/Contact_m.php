<?php
class Contact_M extends MY_Model
{
	protected $_table_name = 'contact';
	protected $_order_by = 'contact_id';
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
			$this->_table_name = 'contact';
			$where = array(
				'contact_id' => $id
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
		$this->_table_name = 'contact';
		$data_contact['status'] = $data['status'];
		if($data_contact)
		{
			if( (int) $data['contact_id'] > 0)
			{
				$this->db->set($data_contact);
				$this->db->where('contact_id', $id);
				$this->db->update($this->_table_name);
			}
		}

		$this->_table_name = 'contact_reply';
		$data_reply = array(
			'contact_id'  => $data['contact_id'],
			'user_email'  => $data['user_email'],
			'reply_title' => $data['reply_title'],
			'reply_desc'  => $data['reply_desc']
		);

		// SEND EMAIL
		if ($data_reply['reply_desc'] != '') {
			$message = $data_reply['reply_desc'];

			// Send email verification
			$params =array(
				'to'      => $data_reply['user_email'],
				'subject' => $data_reply['reply_title'],
				'message' => $data_reply['reply_desc']
			);
			mail_helper($params);
		}

		// SAVE RESPOND IF EMAIL SUCCES
		if($data_reply)
		{
			if( (int) $data['contact_id'] > 0)
			{
				$this->db->set($data_reply);
				$this->db->insert($this->_table_name);
			}
		}
	}

	public function delete_contact($id)
	{
		$this->db->where('contact_id', $id);
		$this->db->delete('contact');
	}

}