<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class MY_Model
 * @author	Masriadi
 */
class MY_Model extends CI_Model
{
	protected $_table_name     = '';
	protected $_primary_key    = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by       = '';
	public $rules              = array();
	protected $_timestamps     = FALSE;

	function __construct()
	{
		parent::__construct();
	}

	public function get($id = NULL, $single = FALSE)
	{
		if ($id != NULL) {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method = 'row_array';
		} elseif ($single == TRUE) {
			$method = 'row_array';
		} else {
			$method = 'result_array';
		}

		$this->db->order_by($this->_order_by);
		return $this->db->get($this->_table_name)->$method();
	}

	public function get_active($id = NULL, $single = FALSE)
	{
		if ($id != NULL) {

			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method = 'row_array';
		} elseif ($single == TRUE) {
			$method = 'row_array';
		} else {
			$method = 'result_array';
		}

		$this->db->order_by($this->_order_by);
		$this->db->where('status', 1);

		return $this->db->get($this->_table_name)->$method();
	}

	public function get_by($where, $single = FALSE)
	{
		$this->db->where($where);
		return $this->get(NULL, $single);
	}

	public function save($data, $id = NULL)
	{
		// Set timestamps
		if ($this->_timestamps == TRUE) {
			$now = date('Y-m-d H:i:s');
			$id || $data['date_added'] = $now;
			$data['date_modified'] = $now;
		}

		// Insert
		if ($id === NULL) {
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id = $this->db->insert_id();
		}
		// Update
		else {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->set($data);
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name);
		}

		return $id;
	}

	public function delete($id)
	{
		$filter = $this->_primary_filter;
		$id = $filter($id);

		if (!$id) {
			return FALSE;
		}
		$this->db->where($this->_primary_key, $id);
		$this->db->limit(1);
		$this->db->delete($this->_table_name);
	}

	public function get_datatables($sIndexColumn = NULL, $oWhere = NULL, $sWhere = NULL, $sOrder = NULL, $sLimit = NULL, $table_name = NULL, $table_join_name = NULL)
	{
		if ($table_join_name != NULL) {
			$query = $this->db->query("
	           	SELECT * FROM $table_name
	            JOIN $table_join_name ON $table_join_name.$sIndexColumn = $table_name.$sIndexColumn

	            $oWhere
	            $sWhere
	            $sOrder
	            $sLimit
	        ");
		} else {
			$query = $this->db->query("
	           	SELECT * FROM $table_name

	            $oWhere
	            $sWhere
	            $sOrder
	            $sLimit
	        ");
		}
		return $query;
	}

	public function get_datatable_total($sIndexColumn = NULL, $oWhere = NULL, $table_name = NULL, $table_join_name = NULL)
	{
		if ($table_join_name != NULL) {
			$query = $this->db->query("
	           	SELECT * FROM $table_name
	            JOIN $table_join_name ON $table_join_name.$sIndexColumn = $table_name.$sIndexColumn

	            $oWhere
	        ");
		} else {
			$query = $this->db->query("
	           	SELECT * FROM $table_name

	            $oWhere
	        ");
		}
		return $query;
	}

	// Get post slug by id
	public function get_slugs($params = array())
	{
		$this->db->select(array('slug', 'language_code'));
		$this->db->from($params['table_name']);
		$this->db->where($params['primary_key'], $params['id']);
		$this->db->order_by($params['primary_key'] . ' ASC');
		$query = $this->db->get()->result_array();
		if ($query) {
			foreach ($query as $post) {
				$result[$post['language_code']] = $post;
			}

			return $result;
		}
	}

	// Count table row
	public function count_totals($table_name = NULL, $where = NULL)
	{
		if ($where) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
				// $this->db->where('status', 1);
			}
		}

		return $this->db->count_all_results($table_name);
	}

	// Update status
	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where($this->_primary_key, $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}
}
