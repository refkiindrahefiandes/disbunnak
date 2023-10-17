<?php
class Dashboard extends Admin_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dashboard/dashboard_m');
    }

    public function index() {
        // Blog dan Komentar
		$blogs      = $this->dashboard_m->count_totals('blog');
		$comments   = $this->dashboard_m->count_totals('blog_comment');
		$pages      = $this->dashboard_m->count_totals('page');
		$categories = $this->dashboard_m->count_totals('blog_term');

		$this->data['dashboard_info'] = array(
			'blog'     => $blogs,
			'comment'  => $comments,
			'page'     => $pages,
			'category' => $categories
	    );

        // Visitor Counter
        $results = $this->dashboard_m->getVisitor();

		$date        = '';
		$day_visitor = '';
		$day_hits    = '';
		$prefix      = '';
		foreach ($results['dt_min'] as $result)
		{
			$date        .= $prefix . '"' . short_date('d M', $result['date']) . '"';
			$day_visitor .= $prefix . $result['day_visitor'];
			$day_hits    .= $prefix . $result['day_hits'];
		    $prefix = ', ';
		}

		$this->data['date']           = $date;
		$this->data['day_visitor']    = $day_visitor;
		$this->data['day_hits']       = $day_hits;

		$this->data['today_visitor']  = $results['today_visitor'];
		$this->data['total_visitor']  = $results['total_visitor'];
		$this->data['today_hits']     = $results['today_hits'];
		$this->data['total_hits']     = $results['total_hits'];
		$this->data['online_visitor'] = $results['online_visitor'];

        $this->data['subview'] = 'admin/dashboard/index';
    	$this->load->view('admin/_layout_main', $this->data);
    }
}