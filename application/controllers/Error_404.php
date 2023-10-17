<?php
class Error_404 extends Frontend_controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
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

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'error-404';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}