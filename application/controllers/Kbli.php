<?php
class Kbli extends Frontend_controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('datatable');
        $this->load->model('dm/kbli_m');
    }

    public function index($slug = NULL) {
        // Switch language
        if (count($this->data['languages'])) {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code']
                );
            }
        }

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'kbli';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function fetch_data($cat_id = NULL)
    {
        $config = array(
            'model_name'          => 'kbli_m',
            'sIndexColumn'        => 'kbli_id',
            'table_name'          => 'dm_kbli',
            'table_join_name'     => '',
            'table_join_col_name' => '',
            'where_options'       => '',
            'search_col_name'     => 'judul',
            'aColumns'            => array('kode', 'judul', 'keterangan')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $value[2]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }
}