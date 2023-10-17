<?php
class Layanan extends Frontend_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($offset = 0)
    {
        // Switch language
        if (count($this->data['languages'])) {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code'] . '/' . 'layanan' . '.html'
                );
            }
        }

        // get search string
        $total_layanan = query_services(array('limit' => 0, 'offset' => $offset));

        // Set data
        $this->data['offset']           = $offset;

        $this->data['base_url']         = base_url($this->data['language_code'] . '/layanan' . '/');
        $this->data['total_layanan']    = count(array($total_layanan));
        $this->data['uri_segment']      = 3;

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'layanan';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}
