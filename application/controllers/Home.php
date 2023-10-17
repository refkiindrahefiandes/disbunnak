<?php
class Home extends Frontend_controller
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
                    'redirect'  => base_url() . $language['language_code']
                );
            }
        }
        // Set data
        $this->data['offset']        = $offset;

        $this->data['base_url']      = base_url('home/index/');
        $this->data['total_post']    = $this->frontend_m->count_totals('blog');
        $this->data['uri_segment']   = 3;

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'home';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}
