<?php
class Perizinan_penunjang_M extends MY_Model
{
	protected $_table_name  = 'layanan_perizinan_penunjang';
	protected $_primary_key = 'id';
	protected $_order_by    = 'id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new()
	{
        $result = array(
			'id'       => '',
			'bidang_id'          => set_value('bidang_id'),
			'name'               => set_value('name'),
			'sort_order'         => 0,
			'status'             => 1,
			'content_mikro' => [
				'skala'                 => set_value('skala'),
				'luas_lahan'            => set_value('luas_lahan'),
				'tingkat_risiko'        => set_value('tingkat_risiko'),
				'perizinan_berusaha'    => set_value('perizinan_berusaha'),
				'jangka_waktu'          => set_value('jangka_waktu'),
				'masa_berlaku'          => set_value('masa_berlaku'),
				'parameter'             => set_value('parameter'),
				'kewenangan'            => set_value('kewenangan'),
				'persyaratan_perizinan' => set_value('persyaratan_perizinan'),
				'jw_persyaratan'        => set_value('jw_persyaratan'),
				'kewajiban_perizinan'   => set_value('kewajiban_perizinan'),
				'jw_kewajiban'          => set_value('jw_kewajiban')
			],
			'content_kecil' => [
				'skala'                 => set_value('skala'),
				'luas_lahan'            => set_value('luas_lahan'),
				'tingkat_risiko'        => set_value('tingkat_risiko'),
				'perizinan_berusaha'    => set_value('perizinan_berusaha'),
				'jangka_waktu'          => set_value('jangka_waktu'),
				'masa_berlaku'          => set_value('masa_berlaku'),
				'parameter'             => set_value('parameter'),
				'kewenangan'            => set_value('kewenangan'),
				'persyaratan_perizinan' => set_value('persyaratan_perizinan'),
				'jw_persyaratan'        => set_value('jw_persyaratan'),
				'kewajiban_perizinan'   => set_value('kewajiban_perizinan'),
				'jw_kewajiban'          => set_value('jw_kewajiban')
			],
			'content_menengah' => [
				'skala'                 => set_value('skala'),
				'luas_lahan'            => set_value('luas_lahan'),
				'tingkat_risiko'        => set_value('tingkat_risiko'),
				'perizinan_berusaha'    => set_value('perizinan_berusaha'),
				'jangka_waktu'          => set_value('jangka_waktu'),
				'masa_berlaku'          => set_value('masa_berlaku'),
				'parameter'             => set_value('parameter'),
				'kewenangan'            => set_value('kewenangan'),
				'persyaratan_perizinan' => set_value('persyaratan_perizinan'),
				'jw_persyaratan'        => set_value('jw_persyaratan'),
				'kewajiban_perizinan'   => set_value('kewajiban_perizinan'),
				'jw_kewajiban'          => set_value('jw_kewajiban')
			],
			'content_besar' => [
				'skala'                 => set_value('skala'),
				'luas_lahan'            => set_value('luas_lahan'),
				'tingkat_risiko'        => set_value('tingkat_risiko'),
				'perizinan_berusaha'    => set_value('perizinan_berusaha'),
				'jangka_waktu'          => set_value('jangka_waktu'),
				'masa_berlaku'          => set_value('masa_berlaku'),
				'parameter'             => set_value('parameter'),
				'kewenangan'            => set_value('kewenangan'),
				'persyaratan_perizinan' => set_value('persyaratan_perizinan'),
				'jw_persyaratan'        => set_value('jw_persyaratan'),
				'kewajiban_perizinan'   => set_value('kewajiban_perizinan'),
				'jw_kewajiban'          => set_value('jw_kewajiban')
			],
			'files'              => set_value('files'),
        );

		return $result;
	}
}