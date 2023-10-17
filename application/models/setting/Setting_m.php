<?php
class Setting_M extends MY_Model
{
	protected $_table_name  = 'setting';
	protected $_primary_key = 'setting_id';
	protected $_order_by    = '';
	public $rules = array();

	function __construct()
	{
		parent::__construct();
	}

	public function get_setting($setting_key = NULL) // active_theme
	{
		$settings = array();

		if ($setting_key != NULL) {
			$this->db->select('*');
			$this->db->from($this->_table_name);
			$this->db->where('setting_key', $setting_key);
			$results = $this->db->get()->result_array();

			if ($results) {
				foreach ($results as $result) {
					if (!$result['serialized']) {
						$settings = $result['value'];
					} else {
						$settings = unserialize($result['value']);
					}
				}
			}
		} else {
			$this->db->select('*');
			$this->db->from($this->_table_name);
			$results = $this->db->get()->result_array();

			if ($results) {
				foreach ($results as $result) {
					if (!$result['serialized']) {
						$settings[$result['setting_key']] = $result['value'];
					} else {
						$settings[$result['setting_key']] = unserialize($result['value']);
					}
				}
			}
		}

		return $settings;
	}

	public function save_setting($data = array())
	{
		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$setting_data = array(
					'setting_key'   => $key,
					'value'         => $data[$key]
				);
			} else {
				$setting_data = array(
					'setting_key'   => $key,
					'value'         => serialize($data[$key]),
					'serialized'    => '1'
				);
			}

			$this->db->where('setting_key', $setting_data['setting_key']);
			$this->db->delete($this->_table_name);

			$this->db->set($setting_data);
			$this->db->insert($this->_table_name);
		}

		return TRUE;
	}

	public function search_setting($query = NULL)
	{
		$this->db->select('*');
		$this->db->from('setting');
		$this->db->where("setting_key LIKE '%$query%'");
		$results = $this->db->get()->result_array();

		$settings = array();
		if ($results) {
			foreach ($results as $result) {
				if (!$result['serialized']) {
					$settings[$result['setting_key']] = $result['value'];
				} else {
					$settings[$result['setting_key']] = unserialize($result['value']);
				}
			}
		}
		return $settings;
	}

	public function delete_setting($setting_key = NULL)
	{
		$this->db->where('setting_key', $setting_key);
		$this->db->delete('setting');
	}
}
