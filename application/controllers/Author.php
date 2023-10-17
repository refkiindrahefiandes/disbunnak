<?php
class Author extends Frontend_controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect(base_url());
    }

    public function get($user_id = NULL, $offset = 0)
    {
        if (count($this->data['languages'])) {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code'] . '/' . 'author/get/' . $user_id . '.html'
                );
            }
        }

        $this->data['archive_title'] = '';

        $result = $this->frontend_m->get_user_info($user_id);
        if ($result) {
            $this->data['archive_title'] = lang('text_author') . ' : ' . $result['firstname'] . $result['lastname'];
        }

        $this->data['user_id']     = $user_id;
        $this->data['offset']      = $offset;
        $this->data['base_url']    = base_url('author/get/' . $user_id . '/');
        $this->data['total_post']  = $this->frontend_m->count_totals('blog', array('user_id' => $user_id));
        $this->data['uri_segment'] = 4;

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'author-archive';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}