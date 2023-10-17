<?php
class Skm extends Frontend_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('skm/skm_m');
        $this->load->model('skm/skm_penilaian_m');
    }

    public function index($slug = NULL)
    {
        // Switch language
        if (count($this->data['languages'])) {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code']
                );
            }
        }

        // Data Form
        $this->data['jenis_kelamin'] = array('Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan');
        $this->data['pendidikan'] = array(
            'SD'         => 'SD',
            'SMP'        => 'SMP',
            'SMA'        => 'SMA',
            'D1-D2-D3'   => 'D1-D2-D3',
            'S1'         => 'S1',
            'S2 Ke atas' => 'S2 Ke atas',
            // 'Lainnya'    => 'Lainnya'
        );

        $this->data['pekerjaan'] = array(
            'PNS'        => 'PNS',
            'TNI/ Polri' => 'TNI/ Polri',
            'SWASTA'     => 'SWASTA',
            'LAINNYA'    => 'LAINNYA'
        );

        $this->data['pertanyaan'] = $this->skm_m->get_by(array('status' => 1), FALSE);

        // Setup form
        $rules = $this->skm_penilaian_m->rules;
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'usia'          => $this->input->post('usia', TRUE),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                'pendidikan'    => $this->input->post('pendidikan', TRUE),
                'pekerjaan'     => $this->input->post('pekerjaan', TRUE),
                'saran'         => $this->input->post('saran', TRUE),
                'penilaian'     => serialize($this->input->post('penilaian', TRUE))
            );

            if ($this->input->post('name') === '') {
                if ($this->skm_penilaian_m->save($data, NULL)) {
                    $this->session->set_flashdata('success', '<strong>Penilaian telah dikirim, </strong>Terima kasih atas penilaian yang telah Bapak/Ibu berikan, masukan Bapak/Ibu sangat berarti bagi kami dalam meningkatkan pelayanan.');
                    redirect('skm');
                }
            }
        }

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'skm';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function penilaian()
    {
        // DATA PENILAIAN
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

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'skm_penilaian';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
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
}
