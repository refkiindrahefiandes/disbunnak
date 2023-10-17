<?php
class Front_M extends MY_Model
{
	protected $_table_name  = 'users';
	protected $_primary_key = 'user_id';
	protected $_order_by    = 'user_id';

	function __construct ()
	{
		parent::__construct();
	}

	public function get_laporan($user_id, $tipe = 'pengaduan')
    {
        $this->db->select('*');
        $this->db->where('frontend_user_id' , $user_id);
        $this->db->from($tipe);

        return $this->db->get()->result_array();
    }

	public function get_balasan($pengaduan_id)
	{
		$this->db->select('*');
        $this->db->where('pengaduan_id' , $pengaduan_id);
        $this->db->from('pengaduan_reply');

        return $this->db->get()->row_array();
	}

	public function get_balasan_konsultasi($konsultasi_id)
	{
		$this->db->select('*');
        $this->db->where('konsul_id' , $konsultasi_id);
        $this->db->from('konsultasi_reply');

        return $this->db->get()->row_array();
	}
}