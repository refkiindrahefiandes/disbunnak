<?php
class Konsultasi extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('contact/contact_m');
        $this->load->model('konsultasi/konsultasi_m');
        $this->load->model('user/user_permission_m');
        $this->load->model('konsultasi/konsultasi_replay_m');
        $this->load->model('setting/language_m');
        $this->load->model('setting/setting_m');
        $this->load->library('mail');

        $this->data['contact_status_text'] = array(
            // '0' => '<span class="badge brand-danger" style="position: relative; top:0;">Belum Diproses</span>',
            '1' => '<span class="badge brand-warning" style="position: relative; top:0;">Tidak Diproses</span>',
            '2' => '<span class="badge brand-success" style="position: relative; top:0;">Diproses</span>'
        );

        $this->data['contact_text'] = array(
            '0' => '<span class="badge brand-danger" style="position: relative; top:0;">Belum Diproses</span>',
            '1' => '<span class="badge brand-warning" style="position: relative; top:0;">Tidak Diproses</span>',
            '2' => '<span class="badge brand-success" style="position: relative; top:0;">Diproses</span>'
        );

        $this->data['is_level'] = array(
            // '0' => 'OPERATOR',
            '1' => 'PEMODALAN',
            '2' => 'PERIZINAN',
            '3' => 'NAKER'
        );
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'Contact')) {
            $this->data['subview'] = 'admin/konsultasi/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    

    public function get_datatables()
    {

        switch ($this->user_permission_m->get_user_group_slug()) {
            case 'administrator':
                $where = array('is_level' => 0);
                break;
            case 'admin-pengaduan':
                $where = array('is_level' => 0, 'status' => 0);
                break;
            case 'penanaman-modal':
                $where = array('is_level' => 1, 'status' => 0);
                break;
            case 'perizinan':
                $where = array('is_level' => 2, 'status' => 0);
                break;
            case 'naker':
                $where = array('is_level' => 3, 'status' => 0);
                break;
            
            default:
                # code...
                break;
        }
        $config = array(
            'model_name'          => 'konsultasi_m',
            'sIndexColumn'        => 'konsul_id',
            'table_name'          => 'konsultasi',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => $where,
            'search_col_name'     => 'name',
            'aColumns'            => array('konsul_id', 'name', 'email', 'type', 'date_added', 'status', 'konsul_id')
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
                    '4' => long_date('j M Y', $value[4], $this->data['language_code']),
                    '5' => $this->data['contact_text'][$value[5]],
                    '6' => $value[6]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {

        $allValues = array('penanaman-modal','perizinan','naker');
        if(in_array($this->user_permission_m->get_user_group_slug(),$allValues, true)){
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . 'Proses';
        }else{
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . 'Kirim';
        }
		// Fetch a contact or set a new one
		if ($id) {
			$result = $this->konsultasi_m->get_contacts($id);

			if ($result !== false) {
				$this->data['contact'] = $result;

                $this->data['contact_reply'] = $this->konsultasi_replay_m->get_by(array('konsul_id' => $result['konsul_id']));
			} else {
				redirect('admin/konsultasi');
			}
		}
		else {
			redirect('admin/konsultasi');
		}

		// Process the form
		if ($this->input->post() == TRUE && $this->validate_modify('Contact')) {
            $allValues = array('penanaman-modal','perizinan','naker');
            if(in_array($this->user_permission_m->get_user_group_slug(),$allValues, true)){

                $data = $this->input->post();
                if ($this->konsultasi_m->save_replay($data, $id)) {
                    $this->_send_success_message($data, $result);

                    $this->session->set_flashdata('success', '<strong>Sukses,</strong> Konsultasi berhasil diproses.');
                    redirect('admin/konsultasi');
                }

                $this->session->set_flashdata('error', '<strong>Gagal,</strong> Konsultasi tidak berhasil diproses.');
			    redirect('admin/konsultasi');
            }else{
                // $this->konsultasi_m->save_contact($this->input->post(), $id);
			    // redirect('admin/konsultasi');

                $data = $this->input->post();
                $data['date_submit'] = date('Y-m-d h:i:s');
                $this->konsultasi_m->save_contact($data, $id);
			    redirect('admin/konsultasi');
            }
		}

		// Load the view
        if ($this->user_m->hasPermission('access', 'Contact')) {
            $this->data['subview'] = 'admin/konsultasi/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

		$this->load->view('admin/_layout_main', $this->data);
    }

    public function delete($id = NULL)
    {
        if ($this->validate_delete('Contact')) {
            if ($id) {
                $this->konsultasi_m->delete_contact($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/konsultasi');
            }
            else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->konsultasi_m->delete_contact($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/konsultasi');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/konsultasi');       
                }
            }
        }
    }

    public function arsip()
    {
        if ($this->user_m->hasPermission('access', 'Contact')) {
            $this->data['subview'] = 'admin/konsultasi/arsip';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables_arsip()
    {

        switch ($this->user_permission_m->get_user_group_slug()) {
            case 'administrator':
                $where = array('is_level' => 0);
                break;
            case 'admin-pengaduan':
                $where = array('status' => 2);
                break;
            case 'penanaman-modal':
                $where = array('is_level' => 1, 'status' => 2);
                break;
            case 'perizinan':
                $where = array('is_level' => 2, 'status' => 2);
                break;
            case 'naker':
                $where = array('is_level' => 3, 'status' => 2);
                break;
            
            default:
                # code...
                break;
        }
        $config = array(
            'model_name'          => 'konsultasi_m',
            'sIndexColumn'        => 'konsul_id',
            'table_name'          => 'konsultasi',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => $where,
            'search_col_name'     => 'name',
            'aColumns'            => array('konsul_id', 'name', 'email', 'type', 'date_added', 'status', 'konsul_id')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            $no= 1;
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $no,
                    '1' => $value[1],
                    '2' => $value[2],
                    '3' => $value[3],
                    '4' => long_date('j M Y', $value[4], $this->data['language_code']),
                    '5' => $this->data['contact_text'][$value[5]],
                    '6' => $value[6]
                );

                $no++;
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function view($id = NULL)
    {

        $allValues = array('penanaman-modal','perizinan','naker');
        if(in_array($this->user_permission_m->get_user_group_slug(),$allValues, true)){
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . 'Proses';
        }else{
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . 'Kirim';
        }
		// Fetch a contact or set a new one
		if ($id) {
			$result = $this->konsultasi_m->get_contacts($id);

			if ($result !== false) {
				$this->data['contact'] = $result;

                $this->data['contact_reply'] = $this->konsultasi_replay_m->get_by(array('konsul_id' => $result['konsul_id']));
			} else {
				redirect('admin/konsultasi/arsip');
			}
		}
		else {
			redirect('admin/konsultasi/arsip');
		}



		// Load the view
        if ($this->user_m->hasPermission('access', 'Contact')) {
            $this->data['subview'] = 'admin/konsultasi/view';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

		$this->load->view('admin/_layout_main', $this->data);
    }

    protected function _send_success_message($data=NULL, $result=NULL)
    {
        // Send email to user
        $message  = 'Bapak/Ibu ' . $result['name'] . ', <br>';
        $message .= '<p>Terima kasih telah mengajukan Konsultasi di Sistem Layanan Pengaduan dan Konsultasi - DPMPTSPTK  Kab. Kuantan Singingi .</p>';
        $message .= '<p>Berikut penjelasan dari kami terkait konsultasi Bapak/Ibu dengan Nomor Konsultasi '. $result['noregistrasi'] .'  :</p>';
        $message .= '<p>'. $data['reply_desc'] .'</p>';
        $message .= '<p>Hormat kami, <br>Helpdesk DPMPTSPTK Kab. Kuantan Singingi</p>';

        // Send email verification
        $params =array(
            'to'      => $result['email'],
            'subject' => 'Balasan PENGADUAN & KONSULTASI DPMPTSPTK Kab. Kuantan Singingi.',
            'message' => $message
        );

        return $this->mail->send_mail($params);
    }
}