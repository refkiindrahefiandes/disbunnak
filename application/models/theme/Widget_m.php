<?php
class Widget_M extends MY_Model
{
	protected $_table_name  = 'widget';
	protected $_primary_key = 'widget_id';
	protected $_order_by    = '';
	public $rules = array(
		'add-widget' => array(
			'field' => 'add-widget',
			'label' => 'widget Name',
			'rules' => 'trim|required'
		)
	);

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_widget()
	{
		$result[] = array(
			'widget_id' => '',
			'name'    => '',
			'slug'    => ''
        );
		return $result;
	}

	public function save_widget($data)
	{
		if($data) {
			$data = array(
				'name'    => $data,
				'slug'    => get_slug($data)
	        );
			$this->db->set($data);
			$this->db->insert($this->_table_name);
		}
	}

	public function save_widget_item($data)
	{
		if($data) {
			$this->db->set($data);
			$this->db->insert('widget_item');

			return true;
		}
	}

	public function get_widget($id = NULL)
	{
		if ($id) {
	        $this->db->select('*');
	        $this->db->from('widget');
	        $this->db->where('widget_id', $id);
	        $result = $this->db->get()->result_array();
	        return $result;
		} else {
	        $this->db->select('*');
	        $this->db->from('widget');
	        $result = $this->db->get()->result_array();
	        return $result;
		}
	}

	public function get_widget_item($params = array())
	{
		if (count($params)) {
	        $this->db->select('*');
	        $this->db->from('widget_item');

	        foreach ($params as $key => $value) {
	        	$this->db->where($key, $value);
	        }

	        $this->db->order_by('sort_order');
	        $results = $this->db->get()->result_array();

			if ($results) {
				foreach ($results as $key => $result) {
					$results[$key]['value'] = unserialize($result['value']);
				}
			}

			if ($results) {
	            foreach ($results as $key => $result) {
	                foreach($this->data['languages'] as $value){
	                    if( isset($result['value']['widget_title'][$value['language_code']]) ){
	                        $results[$key]['value']['widget_title'][$value['language_code']] = $result['value']['widget_title'][$value['language_code']];
	                    }else {
	                        $results[$key]['value']['widget_title'][$value['language_code']] = '';
	                    }
	                }
	            }
			}

	        return $results;
		}

		if ($widget_id) {
	        $this->db->select('*');
	        $this->db->from('widget_item');
	        $this->db->where('widget_id', $widget_id);
	        $this->db->order_by('sort_order');
	        $results = $this->db->get()->result_array();

			if ($results) {
				foreach ($results as $key => $result) {
					$results[$key]['value'] = unserialize($result['value']);
				}
			}
	        return $results;
		}
		return false;
	}

	public function save_item($widgets =  NULL)
	{
		if (count($widgets)) {
			foreach ($widgets as $key => $value) {
				if ($value['item_id'] !== '') {
					$data = array(
						'sort_order' => $key
					);

					$this->db->set($data);
					$this->db->where('widget_item_id', $value['item_id']);
					$this->db->update('widget_item');
				}
			}
			return true;
		}
	}

	public function delete_widget($id)
	{
		$this->db->where('widget_id', $id);
		$this->db->delete('widget');

		return true;
	}

	public function delete_item($id)
	{
		$this->db->where('widget_item_id', $id);
		$this->db->delete('widget_item');

		return true;
	}
}