<?php
class Search extends Frontend_controller {

    public function __construct(){
        parent::__construct();
    }

    public function index($query = NULL, $offset = 0) {
        // Switch language
        if (count($this->data['languages'])) {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code'] . '/' . 'search' . '.html'
                );
            }
        }

        // get search string
        $query      = ($this->input->post("search")) ? $this->input->post("search") : '';
        $query      = ($this->uri->segment(4)) ? $this->uri->segment(4) : $query;
        $total_post = query_posts(array('search_query' => $query, 'limit' => 0, 'offset' => $offset));

        // Set data
        $this->data['search_query']  = $query;
        $this->data['offset']        = $offset;

        $this->data['base_url']      = base_url($this->data['language_code'] . '/search/index/' . $query . '/');
        $this->data['total_post']    = is_array($total_post) ? count($total_post) : 0;
        $this->data['uri_segment']   = 4;

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'search';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}