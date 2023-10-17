<?php
class Contact extends Frontend_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('frontend/frontend_m');
    }

    public function index($page_slug = NULL)
    {
        // Switch language
        if (count($this->data['languages'])) {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code'] . '/' . 'contact' . '.html'
                );
            }
        }

        $this->data['type'] = array(
            'Pertanyaan' => 'Pertanyaan',
            'Informasi'  => 'Informasi',
            'Keluhan'    => 'Keluhan',
            'Saran'      => 'Saran'
        );

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
                'label' => 'Pesan',
                'rules' => 'trim|required|max_length[1000]'
            )
        );

        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $data = array (
				'name'       => $this->input->post('nama', TRUE),
				'email'      => $this->input->post('email', TRUE),
				'phone'      => $this->input->post('phone', TRUE),
				'type'       => $this->input->post('type', TRUE),
				'content'    => $this->input->post('content', TRUE),
				'status'     => 0,
				'date_added' => date('Y-m-d')
            );

            if ($this->input->post('name') === '') {
                $this->db->set($data);
                $this->db->insert('contact');
            }

            $this->session->set_flashdata('success', lang('success_contact'));
            redirect(site_url('contact'));
        }

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'contact';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}