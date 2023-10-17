<?php
class Kiosk extends Frontend_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('frontend/frontend_m');
    }

    public function index() {
        $this->load->view('frontend/' . $this->data['active_theme'] . '/' . 'kiosk/index', $this->data);
    }

    public function detail($type=NULL)
    {
        if ($type) {
            $this->data['result_nested'] = $this->frontend_m->get_pelayanan_nested('bidang_' . $type, 'layanan_' . $type, $type . '_id');
            $this->data['type'] = $type;
            $this->load->view('frontend/' . $this->data['active_theme'] . '/' . 'kiosk/detail', $this->data);
    	}

    	return false;
    }

    public function view($type=NULL, $slug=NULL)
    {
        if ($slug) {
            $this->db->select('*');
            $this->db->from('layanan_'.$type);
            $this->db->where('slug', $slug);
            $result = $this->db->get()->row_array();

            $this->data['result'] = unserialize($result['content']);

            $this->load->view('frontend/' . $this->data['active_theme'] . '/' . 'kiosk/view', $this->data);
        }

        return false;
    }

    public function saran($type=NULL)
    {
        $this->data['type'] = array(
            'Pertanyaan' => 'Pertanyaan',
            'Informasi'  => 'Informasi',
            'Keluhan'    => 'Keluhan',
            'Saran'      => 'Saran'
        );

        $this->load->view('frontend/' . $this->data['active_theme'] . '/' . 'kiosk/saran', $this->data);
    }

    public function submit()
    {
        // Set up the form
        $rules = array(
            'nama' => array(
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ),
            'email' => array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
            ),
            'content' => array(
                'field' => 'content',
                'label' => 'Kolom Pengaduan',
                'rules' => 'trim|required|max_length[1000]'
            )
        );

        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $content = array (
                'jenis_pengaduan' => 'Kotak Saran',
                'desc_pengaduan'  => $this->input->post('desc_pengaduan')
            );

            $data = array (
                'name'       => $this->input->post('nama'),
                'email'      => $this->input->post('email'),
                'phone'      => $this->input->post('phone'),
                'type'       => $this->input->post('type'),
                'content'    => $this->input->post('content'),
                'status'     => 0,
                'date_added' => date('Y-m-d h:i:s')
            );

            if ($this->input->post('name') === '') {
                $this->db->set($data);
                $this->db->insert('contact');
            }

            $json['success'] = '<div class="alert alert-success alert-dismissable" role="alert"> <strong> Sukses! </strong> Saran telah dikirim, terima kasih! <button aria-hidden="true" class="close" data-dismiss="alert" type="button"> × </button> </div>';
            $this->output->set_output(json_encode($json));
        } else {
            $json['error'] = '<div class="alert alert-warning alert-dismissable" role="alert"> <strong> Gagal! </strong> Semua isian yang ditandai (*) wajib diisi! <button aria-hidden="true" class="close" data-dismiss="alert" type="button"> × </button> </div>';
            $this->output->set_output(json_encode($json));
        }
    }
}