<?php
class user_permission_m extends MY_Model
{
	protected $_table_name  = 'user_group';
	protected $_primary_key = 'user_group_id';
	protected $_order_by    = 'user_group_id';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'name',
			'rules' => 'trim|required'
		)
	);

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_user_group()
	{
		$result = array(
			'user_group_id' => '',
			'name'          => set_value('name'),
			'status'        => set_value('status')
	    );

		$result['permission']['access']  = array();
		$result['permission']['modify']  = array();
		$result['permission']['publish'] = array();

		return $result;
	}

	public function save($data, $id = NULL)
	{
		$this->_table_name = 'user_group';

		if( isset($data) )
		{
			if($id)
			{
				$this->db->set($data);
				$this->db->where('user_group_id', $id);
				$this->db->update($this->_table_name);
			} else {
				$this->db->set($data);
				$this->db->where('user_group_id', $id);
				$this->db->insert($this->_table_name);
			}
		}
	}

	public function get_user_group_slug()
	{
		$result = $this->get_by(array('user_group_id' => $this->session->userdata['user_group_id']), TRUE);
		return $result['slug'];
	}

}