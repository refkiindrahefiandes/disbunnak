<?php
class Sitemap extends Frontend_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('blog/blog_m');
        $this->load->model('page/page_m');
        $this->load->model('blog/blog_category_m');
        $this->load->model('blog/blog_tag_m');
    }

    public function index($id = NULL) {
        // Home
        $this->data['home'][] = array(
            'main_url' => base_url() . $this->data['language_code'],
            'alt_url'  => $this->data['languages']
        );

        // Blog
        $this->data['posts'] = $this->blog_m->get_posts_sitemap($this->data['language_code']);

        // Page
        $this->data['pages'] = $this->page_m->get_pages_sitemap($this->data['language_code']);

        // Term category
        $terms = $this->blog_category_m->get_categories();
        foreach ($terms as $term) {
            $this->data['categories'][] = array(
                'main_url' => site_url('blog/category/' . $term['term_desc'][$this->data['language_code']]['slug']),
                'alt_url' => $term['term_desc']
            );
        }

        // Term tag
        $terms = $this->blog_tag_m->get_tags();
        foreach ($terms as $term) {
            $this->data['tags'][] = array(
                'main_url' => site_url('blog/tag/' . $term['slug']),
            );
        }

        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('sitemap', $this->data);
    }
}