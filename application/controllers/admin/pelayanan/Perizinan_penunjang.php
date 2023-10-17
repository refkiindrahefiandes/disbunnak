<?php
class Perizinan_penunjang extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pelayanan/perizinan_penunjang_m');
        $this->load->model('pelayanan/bidang_perizinan_penunjang_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'pelayanan/Perizinan_penunjang')) {
            $this->data['subview'] = 'admin/pelayanan/perizinan_penunjang/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }
        
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'perizinan_penunjang_m',
            'sIndexColumn'        => 'id',
            'table_name'          => 'layanan_perizinan_penunjang',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => array(),
            'search_col_name'     => 'name',
            'aColumns'            => array('id', 'name', 'bidang_id', 'sort_order', 'status', 'id')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $this->bidang_perizinan_penunjang_m->get($value[2], TRUE)['name'],
                    '3' => $value[3],
                    '4' => $value[4],
                    '5' => $value[5]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
        $this->data['data_bidang']  = $this->bidang_perizinan_penunjang_m->get();

        $result = $this->perizinan_penunjang_m->get_by(array('id' => $id), TRUE);

        // Fetch a data or set a new one
        if ($result) {
            $this->data['data'] = $result;
            $this->data['data']['content_mikro']    = $result['content_mikro'] ? unserialize($result['content_mikro']) : [];
            $this->data['data']['content_kecil']    = $result['content_kecil'] ? unserialize($result['content_kecil']) : [];
            $this->data['data']['content_menengah'] = $result['content_menengah'] ? unserialize($result['content_menengah']) : [];
            $this->data['data']['content_besar']    = $result['content_besar'] ? unserialize($result['content_besar']) : [];
            $this->data['data']['files']            = $result['files'] ? unserialize($result['files']) : [];
        }
        else {
            $this->data['data'] = $this->perizinan_penunjang_m->get_new();
        }

        // Set up the rules
        $rules = array(
            'name' => array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required'
            ),
            'bidang_id' => array(
                'field' => 'bidang_id',
                'label' => 'Bidang',
                'rules' => 'trim|required'
            )
        );

        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $data = array (
                'bidang_id'        => $this->input->post('bidang_id'),
                'name'             => $this->input->post('name'),
                'slug'             => get_slug($this->input->post('name')),
                'content_mikro'    => $this->input->post('content[mikro]') ? serialize($this->input->post('content[mikro]')) : '',
                'content_kecil'    => $this->input->post('content[kecil]') ? serialize($this->input->post('content[kecil]')) : '',
                'content_menengah' => $this->input->post('content[menengah]') ? serialize($this->input->post('content[menengah]')) : '',
                'content_besar'    => $this->input->post('content[besar]') ? serialize($this->input->post('content[besar]')) : '',
                'sort_order'       => $this->input->post('sort_order'),
                'status'           => $this->input->post('status'),
                'date_added'       => date('Y-m-d h:i:s'),
                'files'            => serialize($this->input->post('files'))
            );

            // printr($data); die();


            if ($this->perizinan_penunjang_m->save($data, $id)) {
                $this->session->set_flashdata('success', lang('success_update_data'));
                redirect('admin/pelayanan/perizinan_penunjang');
            }
        }

        // Load the view
        $this->data['subview'] = 'admin/pelayanan/perizinan_penunjang/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('modify', 'pelayanan/Perizinan_penunjang')) {
            if ($status == 'true') {
                if ($this->perizinan_penunjang_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }

            } elseif ($status == 'false') {
                if ($this->perizinan_penunjang_m->update_status($id, 0)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            }
        } else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }

    public function delete($id = NULL)
    {
        if ($id) {
            $this->perizinan_penunjang_m->delete($id);
            $this->session->set_flashdata('success', 'Sukses! data telah dihapus!');
            redirect('admin/pelayanan/perizinan_penunjang');
        }
        else {
            if ($this->input->post('selected')) {
                foreach ($this->input->post('selected') as $id) {
                    $this->perizinan_penunjang_m->delete($id);
                }

                $this->session->set_flashdata('success', 'Sukses! data telah dihapus!');
                redirect('admin/pelayanan/perizinan_penunjang');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada data yang dipilih!');
                redirect('admin/pelayanan/perizinan_penunjang');
            }
        }
    }

    public function get_bidang_name($bidang_id = NULL)
    {
        if ($bidang_id != NULL) {
            $result = $this->pelayanan_m->get_data($bidang_id, 'bidang_perizinan_penunjang', 'bidang_id');
            // printr($bidang_id); die();
            return $result['name'];
        }
    }

    public function upload($dir = NULL)
    {
        // printr($_FILES); die();
        if ( ! empty($_FILES))
        {
            $config['upload_path']   = "./uploads/files/" . $dir;
            $config['allowed_types'] = 'pdf|PDF|docx|doc|DOC|xlsx|xls|XLXS|XLS|zip';
            $config['max_size']      = '10000';

            $this->load->library('upload', $config);
            if (! $this->upload->do_upload("file")) {
                $json['error'] = $this->upload->display_errors();
            } else {
                $upload_data      = $this->upload->data();
                $json['success']  = 'File Uploaded Successfully..';
                $json['filename'] = $upload_data['file_name'];
            }
            $this->output->set_output(json_encode($json));
        }
    }
}