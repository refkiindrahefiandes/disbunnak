<?php
class Menu_M extends MY_Model
{
	protected $_table_name  = 'menu';
	protected $_primary_key = 'menu_id';
	protected $_order_by    = '';
	public $rules = array(
		'add-menu' => array(
			'field' => 'add-menu',
			'label' => 'Menu Name',
			'rules' => 'trim|required'
		)
	);

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_menu()
	{
		$result[] = array(
			'menu_id' => '',
			'name'    => '',
			'slug'    => ''
        );
		return $result;
	}

	public function save_menu($data)
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

	public function save_menu_item($data = NULL)
	{
		if($data) {
			$this->db->set($data['menu_data']);
			$this->db->insert('menu_item');

			$menu_item_id = $this->db->insert_id();

			if (count($data['menu_desc'])) {
				foreach ($data['menu_desc'] as $menu_desc) {
					$menu_desc['menu_item_id'] = $menu_item_id;
					$this->db->set($menu_desc);
					$this->db->insert('menu_item_description');
				}
			}
		}
	}

	public function get_menu($id = NULL)
	{
		if ($id) {
	        $this->db->select('*');
	        $this->db->from('menu');
	        $this->db->where('menu_id', $id);
	        $result = $this->db->get()->result_array();
	        return $result;
		} else {
	        $this->db->select('*');
	        $this->db->from('menu');
	        $result = $this->db->get()->result_array();
	        return $result;
		}
	}

	public function get_menu_items($menu_id = NULL)
	{
        $this->db->from('menu_item');
        $this->db->join('menu_item_description', 'menu_item_description.menu_item_id = menu_item.menu_item_id');
       	$this->db->where('language_code', $this->data['language_code']);
        $this->db->order_by('sort_order');
        $result = $this->db->get()->result_array();

		if ($result) {
			return $result;
		}

		return false;
	}

	public function get_item_byparent($menu_id = NULL, $parent_id = NULL)
	{
        $this->db->from('menu_item');
        $this->db->join('menu_item_description', 'menu_item_description.menu_item_id = menu_item.menu_item_id');
        $this->db->where('menu_id', $menu_id);
        $this->db->where('menu_item_parent', $parent_id);
        $this->db->where('language_code', $this->data['language_code']);
        $this->db->order_by('sort_order');
        $result = $this->db->get()->result_array();

		if ($result) {
			return $result;
		}

		return false;
	}

	public function save_item($menus =  NULL)
	{
		if (count($menus)) {
			foreach ($menus as $key => $value) {
				if ($value['item_id'] !== '') {
					$data = array(
						'menu_item_parent' => (int) $value['parent_id'],
						'sort_order' => $key
					);

					$this->db->set($data);
					$this->db->where('menu_item_id', $value['item_id']);
					$this->db->update('menu_item');
				}
			}

			return TRUE;
		}
	}

	public function delete_menu($id)
	{
		$this->db->where('menu_id', $id);
		$this->db->delete('menu');

		return true;
	}

	public function delete_item($id)
	{
		$this->db->where('menu_item_id', $id);
		$this->db->delete('menu_item');

		$this->db->where('menu_item_id', $id);
		$this->db->delete('menu_item_description');

		return true;
	}
}