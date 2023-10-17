<?php
class General extends Admin_controller
{

	public function __construct ()
	{
		parent::__construct();
	}

    public function index($id=NULL)
    {
		// Default value
		$this->data['localisation'] = array(
			'language_code'       => ''
		);

		$this->data['media'] = array(
			'image_lg_width'  => '750',
			'image_lg_height' => '380',
			'image_md_width'  => '358',
			'image_md_height' => '182',
			'image_sm_width'  => '200',
			'image_sm_height' => '200'
		);

		// Get value from database and merger with default value
		$this->data['localisation'] = array_merge($this->data['localisation'], $this->setting_m->get_setting('localisation_setting'));
		$this->data['media']        = array_merge($this->data['media'], $this->setting_m->get_setting('media_setting'));

		// Get general setting
		$general = $this->setting_m->get_setting('general_setting');
		if ($general) {
			$this->data['general'] = $general;
		} else {
            foreach($this->data['languages'] as $language)
            {
                $this->data['general'][$language['language_code']] = array(
					'website_name'        => set_value('website_name'),
					'website_description' => set_value('website_description'),
					'website_location'    => set_value('website_location'),
					'website_address'     => set_value('website_address'),
					'website_email'       => set_value('website_email'),
					'website_phone'       => set_value('website_phone')
                );
            }
		}

		// Process the form
		if ($this->input->method(TRUE) == 'POST' && $this->validate_modify('setting/General')) {
			if ($this->setting_m->save_setting($this->input->post())) {
				$this->session->set_flashdata('success', lang('success_update_data'));
			}
			redirect('admin/setting/general');
		}

		// Load view
        if ($this->user_m->hasPermission('access', 'setting/General')) {
            $this->data['subview'] = 'admin/setting/general/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }
}