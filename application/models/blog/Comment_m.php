<?php
class Comment_M extends MY_Model
{
	protected $_table_name = 'blog_comment';
	protected $_order_by = 'comment_id';
	public $rules = array(
		'user' => array(
			'field' => 'user',
			'label' => 'Penulis Komentar',
			'rules' => 'trim|required'
		)
	);

	function __construct ()
	{
		parent::__construct();
	}

	public function get_comment($id = NULL)
	{
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->where('comment_id', $id);
        $result = $this->db->get()->row_array();

        if ($result) {
        	return $result;
        }

        return false;
	}

	public function save_comment($data, $id = NULL)
	{
		if($data) {
			if( (int) $id > 0)
			{
				$this->db->set($data);
				$this->db->where('comment_id', $id);
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
		$this->db->where('comment_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}

	public function delete_comment($id)
	{
		$this->db->where('comment_id', $id);
		$this->db->delete($this->_table_name);
	}

}