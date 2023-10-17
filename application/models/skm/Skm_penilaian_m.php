<?php
class Skm_penilaian_M extends MY_Model
{
	protected $_table_name  = 'app_skm_penilaian';
	protected $_primary_key = 'penilaian_id';
	protected $_order_by    = 'penilaian_id';
	public $rules = array(
        'usia' => array(
            'field' => 'usia',
            'label' => 'Usia',
            'rules' => 'trim|required|max_length[1000]'
        ),
        'jenis_kelamin' => array(
            'field' => 'jenis_kelamin',
            'label' => 'Jenis Kelamin',
            'rules' => 'trim|required|max_length[1000]'
        ),
        'pendidikan' => array(
            'field' => 'pendidikan',
            'label' => 'Pendidikan',
            'rules' => 'trim|required|max_length[1000]'
        ),
        'pekerjaan' => array(
            'field' => 'pekerjaan',
            'label' => 'Pekerjaan',
            'rules' => 'trim|required|max_length[1000]'
        ),
        'saran' => array(
            'field' => 'saran',
            'label' => 'Saran',
            'rules' => 'trim|max_length[1000]'
        )
	);

	function __construct ()
	{
		parent::__construct();
	}
}