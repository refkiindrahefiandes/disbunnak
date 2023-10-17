<?php

class Notification_M extends MY_Model
{
	protected $_table_name  = 'app_notification';
	protected $_primary_key = 'id';
	protected $_order_by    = 'id DESC';

	function __construct()
	{
		parent::__construct();
	}

    public function get_notifications($id = NULL)
	{
        $data =array();
        $this->db->select('*');
        $this->db->from('pengaduan'); 
        $this->db->where('is_level',$id); 
        $this->db->where('status',0); 
        $query = $this->db->get()->result_array();
        if ($query) {
			foreach ($query as $notif) {
				$data[] = array(
                    'id'         => $notif['pengaduan_id'],
                    'type'       => $notif['type'],
                    'name'       => $notif['name'],
                    'url'        => base_url('admin/pengaduan/edit'),
                    'isi'        => $notif['content'],
                    'date_added' => $notif['date_added'],
				);
			}
		}
        return $data;
	}

    public function get_konsultasi($id = NULL)
	{
        $data =array();
        $this->db->select('*');
        $this->db->from('konsultasi'); 
        $this->db->where('is_level',$id); 
        $this->db->where('status',0); 
        $query = $this->db->get()->result_array();

        if ($query) {
			foreach ($query as $notif) {
				$data[] = array(
                    'id'      => $notif['konsul_id'],
                    'type'      => $notif['type'],
                    'name'       => $notif['name'],
                    'isi'        => $notif['content'],
                    'url'        => base_url('admin/konsultasi/edit'),
                    'date_added' => $notif['date_added'],
				);
			}
		}
        return $data;
	}
}