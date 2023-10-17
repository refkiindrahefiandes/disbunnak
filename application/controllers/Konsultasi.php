<?php
class Konsultasi extends Frontnologin_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('frontend/frontend_m');
        $this->load->model('front_m');
        $this->load->library('datatable');
    }

    public function index($offset = 0) {
       
        $this->data['type'] = array(
            'Perizinan'    => 'Perizinan',
            'Pemodalan'    => 'Pemodalan',
            'Tenaga Kerja' => 'Tenaga Kerja'
        );

        $this->data['is_public'] = array(
            '1' => 'Dilihat Publik/Umum',
            '2' => 'Privasi (Untuk Sendiri)',
        );

          // Set up the form
          $rules = array(
            'content' => array(
                'field' => 'content',
                'label' => 'Pesan',
                'rules' => 'trim|required'
            ),
            'type' => array(
                'field' => 'type',
                'label' => 'Pesan',
                'rules' => 'trim|required'
            ),
        );

        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            
            $data_post = [
                'name'             => $this->session->userdata['name'],
                'email'            => $this->session->userdata['frontend_user_email'],
                'phone'            => $this->session->userdata['phone_number'],
                'type'             => $this->input->post('type'),
                'content'          => $this->input->post('content'),
                'frontend_user_id' => $this->session->userdata['frontend_user_id'],
                'date_added'       => date('Y-m-d'),
                'status'           => 0,
                'is_level'         => 0,
                'is_public'        => $this->input->post('is_public'),
            ];

            if ($this->save('konsultasi', $data_post)) {
                $this->session->set_flashdata('success', lang('success_save'));
                redirect(site_url('konsultasi'));
            }
        }

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'konsultasi';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function save($table = 'konsultasi', $data = array())
    {
        $this->db->set($data);
        $this->db->insert($table);
            $id_no =  sprintf("%05d", $this->db->insert_id());
			$this->db->set(array('noregistrasi' => 'K'.$id_no));
			$this->db->where('konsul_id ', $id_no);
            $this->db->update($table);
        return TRUE;
    }

    public function laporan()
    {

        $this->data['laporan'] = $this->front_m->get_laporan($this->session->userdata['frontend_user_id']);

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'front/konsultasi_laporan';

        
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function fetch_data()
    {
        // printr('download list');die;
        $config = array(
            'model_name'          => 'front_m',
            'sIndexColumn'        => 'konsul_id',
            'table_name'          => 'konsultasi',
            'table_join_name'     => '',
            'table_join_col_name' => '',
            'where_options'       => array('frontend_user_id'=> $this->session->userdata['frontend_user_id']),
            'search_col_name'     => 'content',
            'aColumns'            => array('konsul_id', 'type', 'content',  'status', 'date_added')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $value[2],
                    '3' => $value[4],
                    '4' => $this->status_laporan($value[3], $value[0]),
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function status_laporan($kode_status, $id_dokter)
    {
        $string = null;
        switch ($kode_status) {
            case '0':
                $string = 'Menunggu Diproses';
                break;
            case '1':
                $string = 'Sedang Diproses';
                break;
            case '2':
                $string = '<button data-id='.$id_dokter.' class="btn btn-default ink-reaction btn-primary reply-laporan"><i class="fa fa-reply"></i> Dibalas</button>';
                break;
            
            default:
            $string = 'Belum Diproses';
                break;
        }

        return $string;
    }

    
    public function balasan($id)
    {
        if ($id) {
            $pesan = $this->front_m->get_balasan_konsultasi($id);
          
            if (empty($pesan['reply_desc'])) {
                $this->data['pesan']['reply_desc'] = 'Balasan tidak tersedia';
            }else{
                $this->data['pesan']['reply_desc'] = $pesan['reply_desc'];
            }
        }


        $output = array(
            'data'   => $this->load->view('frontend/' . $this->data['active_theme'] . '/' . 'front/template_balasan', $this->data, TRUE)
        );

        $this->output->set_output(json_encode($output));
    }


}