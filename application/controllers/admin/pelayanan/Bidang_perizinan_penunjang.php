<?php
class Bidang_perizinan_penunjang extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pelayanan/bidang_perizinan_penunjang_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'pelayanan/Bidang_perizinan_penunjang')) {
            $this->data['subview'] = 'admin/pelayanan/bidang_perizinan_penunjang/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'bidang_perizinan_penunjang_m',
            'sIndexColumn'        => 'bidang_id',
            'table_name'          => 'bidang_perizinan_penunjang',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => array(),
            'search_col_name'     => 'name',
            'aColumns'            => array('bidang_id', 'name', 'sort_order', 'status', 'bidang_id')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $value[2],
                    '3' => $value[3],
                    '4' => $value[4]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
        $result = $this->bidang_perizinan_penunjang_m->get_by(array('bidang_id' => $id), TRUE);

        // Fetch a page or set a new one
        if ($result) {
            $this->data['bidang_perizinan_penunjang'] = $result;
        }
        else {
            $this->data['bidang_perizinan_penunjang'] = $this->bidang_perizinan_penunjang_m->get_new_bidang();
        }

        // Set up the form
        $rules = array(
            'name' => array(
                'field' => 'name',
                'label' => 'Bidang Name',
                'rules' => 'trim|required'
            )
        );

        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $data = array (
                'name'       => $this->input->post('name'),
                'slug'       => get_slug($this->input->post('name')),
                'parent_id'  => '0',
                'sort_order' => $this->input->post('sort_order'),
                'status'     => $this->input->post('status'),
                'date_added' => date('Y-m-d h:i:s')
            );

            if ($this->bidang_perizinan_penunjang_m->save($data, $id)) {
                $this->session->set_flashdata('success', lang('success_update_data'));
                redirect('admin/pelayanan/bidang_perizinan_penunjang');
            }
        }

        // Load the view
        $this->data['subview'] = 'admin/pelayanan/bidang_perizinan_penunjang/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('modify', 'pelayanan/Bidang_perizinan_penunjang')) {
            if ($status == 'true') {
                if ($this->bidang_perizinan_penunjang_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }

            } elseif ($status == 'false') {
                if ($this->bidang_perizinan_penunjang_m->update_status($id, 0)) {
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
            $this->bidang_perizinan_penunjang_m->delete($id);
            $this->session->set_flashdata('success', 'Sukses! data telah dihapus!');
            redirect('admin/pelayanan/bidang_perizinan_penunjang');
        }
        else {
            if ($this->input->post('selected')) {
                foreach ($this->input->post('selected') as $id) {
                    $this->bidang_perizinan_penunjang_m->delete($id);
                }

                $this->session->set_flashdata('success', 'Sukses! data telah dihapus!');
                redirect('admin/pelayanan/bidang_perizinan_penunjang');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada data yang dipilih!');
                redirect('admin/pelayanan/bidang_perizinan_penunjang');
            }
        }
    }
}