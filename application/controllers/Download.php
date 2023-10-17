<?php
class Download extends Frontend_controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('datatable');
        $this->load->model('download/download_m');
        $this->load->helper('path');
        $this->load->helper('file');
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

        // Set up the form rules
        $rules = array(
            'download_email_confirm' => array(
                'field' => 'download_email_confirm',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
            )
        );

        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $this->get($this->input->post('download_id'));

            $data = array (
                'contact_id' => '',
                'email'      => $this->input->post('download_email_confirm'),
                'status'     => 0,
                'date_added' => date('Y-m-d')
            );

            $this->db->set($data);
            $this->db->insert('contact');
        }

        // Set data
        $download_category_result = $this->frontend_m->get_id_byslug(array('table' => 'download_category', 'slug' => $slug));
        $this->data['download_category'] = $download_category_result;

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'download';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function fetch_data($cat_id = NULL)
    {
        $config = array(
            'model_name'          => 'download_m',
            'sIndexColumn'        => 'download_id',
            'table_name'          => 'download',
            'table_join_name'     => '',
            'table_join_col_name' => '',
            'where_options'       => array('download_category_id' => $cat_id),
            'search_col_name'     => 'name',
            'aColumns'            => array('download_id', 'name', 'filename')
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

    public function get($download_id)
    {
        $result = $this->frontend_m->save_download_hit($download_id);

        // Path to file
        $file  = set_realpath('uploads/files/download/', FALSE) . $result['filename'];

        if (is_file( $file )) {
            // redirect to the real file to be downloaded
            header('Location:' . base_url('uploads/files/download/' . $result['filename']));
        } else {
            header('Location:' . site_url('download'));
        }
    }
}