<?php
class Contact extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('contact/contact_m');
        $this->load->model('contact/contact_reply_m');
        $this->load->model('setting/language_m');
        $this->load->model('setting/setting_m');

        $this->data['contact_status_text'] = array(
            '0' => '<span class="badge brand-danger" style="position: relative; top:0;">Belum Diproses</span>',
            '1' => '<span class="badge brand-warning" style="position: relative; top:0;">Sedang Diproses</span>',
            '2' => '<span class="badge brand-success" style="position: relative; top:0;">Telah Diproses</span>'
        );
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'Contact')) {
            $this->data['subview'] = 'admin/contact/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'contact_m',
            'sIndexColumn'        => 'contact_id',
            'table_name'          => 'contact',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => array(),
            'search_col_name'     => 'name',
            'aColumns'            => array('contact_id', 'name', 'email', 'type', 'date_added', 'status', 'contact_id')
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
                    '5' => $this->data['contact_status_text'][$value[5]],
                    '6' => $value[6]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
		// Fetch a contact or set a new one
		if ($id) {
			$result = $this->contact_m->get_contacts($id);

			if ($result !== false) {
				$this->data['contact'] = $result;

                $this->data['contact_reply'] = $this->contact_reply_m->get_by(array('contact_id' => $result['contact_id']));
			} else {
				redirect('admin/contact');
			}
		}
		else {
			redirect('admin/contact');
		}

		// Process the form
		if ($this->input->post() == TRUE && $this->validate_modify('Contact')) {
			$this->contact_m->save_contact($this->input->post(), $id);
			redirect('admin/contact');
		}

		// Load the view
        if ($this->user_m->hasPermission('access', 'Contact')) {
            $this->data['subview'] = 'admin/contact/edit';
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
                $this->contact_m->delete_contact($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/contact');
            }
            else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->contact_m->delete_contact($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/contact');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/contact');          }
            }
        }
    }
}