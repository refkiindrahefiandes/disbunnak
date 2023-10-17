<?php
class Perizinan_nonkbli extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pelayanan/perizinan_nonkbli_m');
        $this->load->model('pelayanan/bidang_perizinan_nonkbli_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'pelayanan/Perizinan_nonkbli')) {
            $this->data['subview'] = 'admin/pelayanan/perizinan_nonkbli/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }
        
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'perizinan_nonkbli_m',
            'sIndexColumn'        => 'id',
            'table_name'          => 'layanan_perizinan_nonkbli',
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
                    '2' => $this->bidang_perizinan_nonkbli_m->get($value[2], TRUE)['name'],
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
        $this->data['data_bidang']  = $this->bidang_perizinan_nonkbli_m->get();

        $result = $this->perizinan_nonkbli_m->get_by(array('id' => $id), TRUE);

        // Fetch a data or set a new one
        if ($result) {
            $content = unserialize($result['content']);

            $this->data['perizinan_nonkbli'] = array(
                'id'       => $result['id'],
                'bidang_id'          => $result['bidang_id'],
                'name'               => $result['name'],
                'sort_order'         => $result['sort_order'],
                'status'             => $result['status'],
                'dasar_hukum'        => $content['dasar_hukum'],
                'pemohon_baru'       => $content['pemohon_baru'],
                'perpanjangan'       => $content['perpanjangan'],
                'mekanisme'          => $content['mekanisme'],
                'lama_penyelesaian'  => $content['lama_penyelesaian'],
                'biaya'              => $content['biaya'],
                'hasil'              => $content['hasil'],
                'informasi_tambahan' => $content['informasi_tambahan'],
                'files'              => isset($content['files']) ? $content['files'] : array()
            );
        }
        else {
            $this->data['perizinan_nonkbli'] = $this->perizinan_nonkbli_m->get_new_perizinan_nonkbli();
        }

        // printr($this->data); die();

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
            // printr($this->input->post()); die();
            $content = array (
                'dasar_hukum'        => $this->input->post('dasar_hukum'),
                'pemohon_baru'       => $this->input->post('pemohon_baru'),
                'perpanjangan'       => $this->input->post('perpanjangan'),
                'mekanisme'          => $this->input->post('mekanisme'),
                'lama_penyelesaian'  => $this->input->post('lama_penyelesaian'),
                'biaya'              => $this->input->post('biaya'),
                'hasil'              => $this->input->post('hasil'),
                'informasi_tambahan' => $this->input->post('informasi_tambahan'),
                'files'              => $this->input->post('files')
            );

            $data = array (
                'bidang_id'    => $this->input->post('bidang_id'),
                'name'         => $this->input->post('name'),
                'slug'         => get_slug($this->input->post('name')),
                'content'      => serialize($content),
                'sort_order'   => $this->input->post('sort_order'),
                'status'       => $this->input->post('status'),
                'date_added'   => date('Y-m-d h:i:s')
            );

            if ($this->perizinan_nonkbli_m->save($data, $id)) {
                $this->session->set_flashdata('success', lang('success_update_data'));
                redirect('admin/pelayanan/perizinan_nonkbli');
            }
        }

        // Load the view
        $this->data['subview'] = 'admin/pelayanan/perizinan_nonkbli/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('modify', 'pelayanan/Perizinan_nonkbli')) {
            if ($status == 'true') {
                if ($this->perizinan_nonkbli_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }

            } elseif ($status == 'false') {
                if ($this->perizinan_nonkbli_m->update_status($id, 0)) {
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
            $this->perizinan_nonkbli_m->delete($id);
            $this->session->set_flashdata('success', 'Sukses! data telah dihapus!');
            redirect('admin/pelayanan/perizinan_nonkbli');
        }
        else {
            if ($this->input->post('selected')) {
                foreach ($this->input->post('selected') as $id) {
                    $this->perizinan_nonkbli_m->delete($id);
                }

                $this->session->set_flashdata('success', 'Sukses! data telah dihapus!');
                redirect('admin/pelayanan/perizinan_nonkbli');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada data yang dipilih!');
                redirect('admin/pelayanan/perizinan_nonkbli');
            }
        }
    }

    public function get_bidang_name($bidang_id = NULL)
    {
        if ($bidang_id != NULL) {
            $result = $this->pelayanan_m->get_data($bidang_id, 'bidang_perizinan_nonkbli', 'bidang_id');
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