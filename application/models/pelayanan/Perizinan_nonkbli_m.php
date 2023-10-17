<?php
class Perizinan_nonkbli_M extends MY_Model
{
	protected $_table_name  = 'layanan_perizinan_nonkbli';
	protected $_primary_key = 'id';
	protected $_order_by    = 'id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_perizinan_nonkbli()
	{
        $result = array(
			'id'       => '',
			'bidang_id'          => set_value('bidang_id'),
			'name'               => set_value('name'),
			'sort_order'         => 0,
			'status'             => 1,
			'dasar_hukum'        => set_value('dasar_hukum'),
			'pemohon_baru'       => set_value('pemohon_baru'),
			'perpanjangan'       => set_value('perpanjangan'),
			'mekanisme'          => set_value('mekanisme'),
			'lama_penyelesaian'  => set_value('lama_penyelesaian'),
			'biaya'              => set_value('biaya'),
			'hasil'              => set_value('hasil'),
			'informasi_tambahan' => set_value('informasi_tambahan'),
			'files'              => set_value('files'),
        );

		return $result;
	}
}