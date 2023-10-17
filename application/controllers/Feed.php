<?php
class Feed extends Frontend_controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('xml','text'));
        $this->load->model('frontend/frontend_m');
    }

    public function index()
    {
        $general_setting = $this->setting_m->get_setting('general_setting');
        $blogs = query_posts(array('limit' => 10));

        $data = array(
            'encoding'          => 'utf-8',
            'feed_name'         => $general_setting[$this->data['language_code']]['website_name'],
            'feed_url'          => base_url('feed'),
            'page_description'  => $general_setting[$this->data['language_code']]['website_description'],
            'page_language'     => $this->data['language_code'],
            'creator_email'     => '',
            'blogs'             => $blogs
        );

        header("Content-Type: application/rss+xml");
        $this->load->view('feed', $data);
    }
}