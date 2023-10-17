<?php
class Detail extends Frontend_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('frontend/frontend_m');
    }

    // public function index($page_slug = NULL)
    // {
    //   printr('LOL'); die;
    //     $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'detail';
    // 	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    // }


    public function konsultasi($page_slug = NULL)
    {
        $this->data['slug'] = $page_slug;
        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'detail';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function pengaduan($page_slug = NULL)
    {
        $this->data['slug'] = $page_slug;
        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'detail_pengaduan';
    	$this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}