<?php
class Notification extends Admin_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('notification/notification_m');
        $this->load->model('user/user_permission_m');
    }

    public function index() {
		
        $this->data['subview'] = 'admin/notification/index';
    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get() {
        // Only ajax
        check_is_ajax();

		// Notifications
        switch ($this->user_permission_m->get_user_group_slug()) {
            case 'administrator':
                $id = 4;
                break;
            case 'admin-pengaduan':
                $id = 0;
                break;
            case 'penanaman-modal':
                $id = 1;
                break;
            case 'perizinan':
                $id = 2;
                break;
            case 'naker':
                $id = 3;
                break;
            
            default:
                # code...
                break;
        }
        $pengaduan  = $this->notification_m->get_notifications($id);
        $konsul  = $this->notification_m->get_konsultasi($id);

        $results_notif = array_merge($pengaduan,$konsul);
        $data = [];
		if ($results_notif) {
			foreach ($results_notif as $notif) {
				$data[] = array(
                    'id'         => $notif['id'],
                    'type'       => $notif['type'],
                    'name'       => $notif['name'],
                    'url'        => $notif['url'],
                    'isi'        => get_excerpt($notif['isi'], 40),
                    'date_added' => $notif['date_added'],
				);
			}
		}

	    $json['notifications'] = $data;
	  
        // Send results to view with json
        $this->output->set_output(json_encode($json));
	}

   

}