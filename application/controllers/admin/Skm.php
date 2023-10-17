<?php
class Skm extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('skm/skm_m');
        $this->load->model('skm/skm_penilaian_m');
        $this->load->model('setting/language_m');
        $this->load->model('setting/setting_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'Skm')) {
            $this->data['subview'] = 'admin/skm/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function penilaian()
    {
        $where = array(
            'MONTH(date_added)' => date('m'),
            'YEAR(date_added)'  => date('Y')
        );
        $results = $this->skm_penilaian_m->get_by($where, FALSE);
        if ($results) {
            foreach ($results as $key => $result) {
                $data_penilaian[$key] = $result;
                $data_penilaian[$key]['penilaian'] = unserialize($result['penilaian']);
            }

            $this->data['jumlah']                     = count($data_penilaian);

            $this->data['jenis_kelamin']['laki_laki'] = count(search_array('Laki-laki', $data_penilaian, 'jenis_kelamin'));
            $this->data['jenis_kelamin']['perempuan'] = count(search_array('Perempuan', $data_penilaian, 'jenis_kelamin'));

            $this->data['pendidikan']['sd']           = count(search_array('SD', $data_penilaian, 'pendidikan'));
            $this->data['pendidikan']['smp']          = count(search_array('SMP', $data_penilaian, 'pendidikan'));
            $this->data['pendidikan']['sma']          = count(search_array('SMA', $data_penilaian, 'pendidikan'));
            $this->data['pendidikan']['di_d2_d3']     = count(search_array('D1-D2-D3', $data_penilaian, 'pendidikan'));
            $this->data['pendidikan']['s1']           = count(search_array('S1', $data_penilaian, 'pendidikan'));
            $this->data['pendidikan']['s2_keatas']    = count(search_array('S2 Ke atas', $data_penilaian, 'pendidikan'));
            $this->data['pendidikan']['lainnya']      = count(search_array('Lainnya', $data_penilaian, 'pendidikan'));

            $this->data['pekerjaan']['pns']       = count(search_array('PNS', $data_penilaian, 'pekerjaan'));
            $this->data['pekerjaan']['tni_polri'] = count(search_array('TNI\/ Polri', $data_penilaian, 'pekerjaan'));
            $this->data['pekerjaan']['swasta']    = count(search_array('SWASTA', $data_penilaian, 'pekerjaan'));
            $this->data['pekerjaan']['lainnya']   = count(search_array('LAINNYA', $data_penilaian, 'pekerjaan'));

            $this->data['ikm'] = $this->_sum_penilaian($data_penilaian);
        }

        if ($this->user_m->hasPermission('access', 'Skm')) {
            $this->data['subview'] = 'admin/skm/penilaian';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    protected function _sum_penilaian($data = array())
    {
        $results_penilaian = [];
        $result_sum = [];
        if ($data) {
            $results_pertanyaan = $this->skm_m->get_by(array('status' => 1), FALSE);

            foreach ($data as $key => $val) {
                $results_penilaian[] = $val['penilaian'];
            }

            foreach ($results_pertanyaan as $k => $v) {
                $result_sum[$v['skm_id']] = array(
                    'skm_id'            => $v['skm_id'],
                    'judul'             => $v['judul'],
                    'keterangan'        => $v['keterangan'],
                    'total_nilai'       => array_sum(array_column($results_penilaian, $v['skm_id'])),
                    'nilai'             => array_sum(array_column($results_penilaian, $v['skm_id'])) / count($results_penilaian),
                    'jumlah_responden'  => count($data),
                    'jumlah_pertanyaan' => count($results_pertanyaan)
                );
            }
        }

        return $result_sum;
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'skm_m',
            'sIndexColumn'        => 'skm_id',
            'table_name'          => 'app_skm',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => array(),
            'search_col_name'     => 'judul',
            'aColumns'            => array('skm_id', 'judul', 'keterangan', 'status', 'skm_id')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        if (!empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array(
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $value[2],
                    '3' => $value[3],
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function get_datatables_penilaian()
    {
        $where = array(
            'MONTH(date_added)' => date('m'),
            'YEAR(date_added)'  => date('Y')
        );

        $config = array(
            'model_name'          => 'skm_penilaian_m',
            'sIndexColumn'        => 'penilaian_id',
            'table_name'          => 'app_skm_penilaian',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => $where,
            'search_col_name'     => 'saran',
            'aColumns'            => array('penilaian_id', 'usia', 'jenis_kelamin', 'pendidikan', 'pekerjaan', 'saran', 'penilaian_id')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        $no = $this->input->get('iDisplayStart') + 1;
        if (!empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array(
                    '0' => $no,
                    '1' => $value[1],
                    '2' => $value[2],
                    '3' => $value[3],
                    '4' => $value[4],
                    '5' => $value[5],
                    '6' => $value[6]
                );

                $no++;
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
        $result = $this->skm_m->get_by(array('skm_id' => $id), TRUE);

        // Fetch a contact or set a new one
        if ($result) {
            if ($result !== false) {
                $this->data['skm'] = $result;
            } else {
                $this->data['skm'] = $this->skm_m->get_new_skm();
            }
        } else {
            $this->data['skm'] = $this->skm_m->get_new_skm();
        }

        // Set up the form
        $rules = $this->skm_m->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE && $this->validate_modify('Skm')) {
            $data = array(
                'judul'      => $this->input->post('judul'),
                'keterangan' => $this->input->post('keterangan'),
                'status'     => $this->input->post('status'),
            );
            if ($this->skm_m->save($data, $id)) {
                $this->session->set_flashdata('success', lang('success_update_data'));
                redirect('admin/skm');
            }
        }

        // Load the view
        if ($this->user_m->hasPermission('access', 'Skm')) {
            $this->data['subview'] = 'admin/skm/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function delete($id = NULL)
    {
        if ($this->validate_delete('Skm')) {
            if ($id) {
                $this->skm_m->delete_skm($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/skm');
            } else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->skm_m->delete_skm($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/skm');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/skm');
                }
            }
        }
    }

    public function delete_penilaian($id = NULL)
    {
        if ($this->validate_delete('Skm')) {
            if ($id) {
                $this->skm_penilaian_m->delete($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/skm/penilaian');
            } else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->skm_penilaian_m->delete($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/skm/penilaian');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/skm/penilaian');
                }
            }
        }
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('modify', 'Skm')) {
            if ($status == 'true') {
                if ($this->skm_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->skm_m->update_status($id, 0)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            }
        } else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }
}
