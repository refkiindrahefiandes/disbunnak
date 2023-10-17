<?php
class Dashboard_M extends MY_Model
{
	protected $_table_name = 'visitor_counter';

	function __construct()
	{
		parent::__construct();
	}

	// Visitor Counter Model
	public function getVisitor()
	{
		$dt            = date("Y-m-d");
		$dt_show_limit = 7;
		$online_limit  = time() - 1800;

		$dt_min = array();

		for ($i = $dt_show_limit; $i > -1; $i--) {
			$dt_min[] = array(
				'date' => date('Y-m-d', strtotime('-' . $i . 'days', strtotime($dt))),
				'day_visitor' => $this->today_visitor(date('Y-m-d', strtotime('-' . $i . 'days', strtotime($dt)))),
				'day_hits'    => $this->today_hits(date('Y-m-d', strtotime('-' . $i . 'days', strtotime($dt))))
			);
		}

		$total_visitor  = $this->db->query("SELECT COUNT(hits) FROM $this->_table_name")->row_array();
		$total_hits     = $this->db->query("SELECT SUM(hits) FROM $this->_table_name")->row_array();
		$online_visitor = $this->db->query("SELECT * FROM $this->_table_name WHERE online > '$online_limit'")->num_rows();

		$results = array(
			'today_visitor'  => $this->today_visitor($dt),
			'total_visitor'  => $total_visitor["COUNT(hits)"],
			'today_hits'     => $this->today_hits($dt),
			'total_hits'     => $total_hits["SUM(hits)"],
			'online_visitor' => $online_visitor,
			'dt_min'         => $dt_min
		);
		return $results;
	}

	function today_visitor($date)
	{
		$today_visitor = $this->db->query("SELECT * FROM $this->_table_name WHERE dt='$date' GROUP BY ip")->num_rows();
		return $today_visitor;
	}

	function today_hits($date)
	{
		// $today_hits = $this->db->query("SELECT SUM(hits) FROM $this->_table_name WHERE dt='$date' GROUP BY dt")->row_array();
		// return $today_hits["SUM(hits)"] != '' ? $today_hits["SUM(hits)"] : '0';
	}
}
