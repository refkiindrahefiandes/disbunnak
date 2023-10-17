<?php
class Media extends Admin_controller
{
    protected $offset = 0;
    protected $limit  = 25;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('directory');
        $this->load->helper('file');
        $this->load->helper('number');
        $this->load->helper('date');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'Media')) {
            $this->data['subview'] = 'admin/media/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $files_info  = array();
        $files_data  = array();
        $images_data = array();

        $files_data  = glob_recursive('uploads/files/' . '*', GLOB_BRACE);
        $images_data = glob_recursive('uploads/images/' . '*', GLOB_BRACE);

        foreach (array_merge($files_data, $images_data) as $file) {
            if (is_file($file)) {
                $result = get_file_info($file);

                if ($result) {
                    $files_info[] = array(
                        '0' => $result['server_path'],
                        '2' => $result['name'],
                        '3' => byte_format($result['size']),
                        '4' => $result['date'],
                        '5' => get_mime_by_extension($result['server_path'])
                    );
                }
            }
        }

        if ($files_info) {
            $img_mimes = array('image/gif', 'image/jpeg', 'image/png');
            foreach ($files_info as $key => $file_info) {
                if (in_array($file_info['5'], $img_mimes)) {
                    $files_info[$key]['1'] = image_thumb($file_info['0'], 'medium');
                } else {
                    $files_info[$key]['1'] = base_url('uploads/images/default/default-thumbnail-file.png');
                }
            }

            $offset = $_GET['iDisplayStart'];
            $limit  = $_GET['iDisplayLength'];

            // Search datatable
            if (isset($_GET['sSearch'])) {
                $files_info = search_array($_GET['sSearch'], $files_info, $key = 2);
            }

            // Sort datatable
            if (isset($_GET['iSortCol_0'])) {
                $files_info = sort_array($files_info, $_GET['iSortCol_0'], $_GET['sSortDir_0']);
            }

            $rResult['sEcho']                = $_GET['sEcho'];
            $rResult['iTotalRecords']        = count($files_info);
            $rResult['iTotalDisplayRecords'] = count($files_info);
            $rResult['aaData']               = array();

            $files_data = array_splice($files_info, $offset, $limit);

            if (!empty($files_data)) {
                foreach ($files_data as $value) {
                    $rResult['aaData'][] = array(
                        '0' => $value['0'],
                        '1' => $value['1'],
                        '2' => $value['2'],
                        '3' => $value['3'],
                        '4' => timespan($value['4'], time(), 1) . ' ago'
                    );
                }
            }

            $this->output->set_output(json_encode($rResult));
        }
    }

    public function file_manager($target = NULL, $thumb = NULL)
    {
        // Return the target ID for the file manager to set the value
        if ($target) {
            $this->data['target'] = $target;
        } else {
            $this->data['target'] = '';
        }

        // Return the thumbnail for the file manager to show a thumbnail
        if ($thumb) {
            $this->data['thumb'] = $thumb;
        } else {
            $this->data['thumb'] = '';
        }

        $this->load->view('admin/common/file_manager', $this->data);
    }

    public function ajax_load()
    {
        // Set default array
        $files_data  = array();
        $images_data = array();
        $files_info  = array();

        // Set upload directory
        $files_dir   = 'uploads/files/';
        $images_dir  = 'uploads/images/';

        // Get file by file type
        if ($this->input->post('file_type') === 'all') {
            $files_data  = glob_recursive($files_dir . '*', GLOB_BRACE);
            $images_data = glob_recursive($images_dir . '*', GLOB_BRACE);
        }

        if ($this->input->post('file_type') === 'file') {
            $files_data  = glob_recursive($files_dir . '*', GLOB_BRACE);
        }

        if ($this->input->post('file_type') === 'image') {
            $images_data = glob_recursive($images_dir . '*', GLOB_BRACE);
        }

        // Set results file info
        foreach (array_merge($files_data, $images_data) as $file) {
            if (is_file($file)) {
                $result = get_file_info($file);

                if ($result) {
                    $files_info[] = array(
                        'name'        => $result['name'],
                        'server_path' => $result['server_path'],
                        'size'        => byte_format($result['size']),
                        'date'        => timespan($result['date'], time(), 1) . ' ago',
                        'mime'        => get_mime_by_extension($result['server_path'])
                    );
                }
            }
        }

        // Add thumb to results
        if ($files_info) {
            $img_mimes = array('image/gif', 'image/jpeg', 'image/png');
            foreach ($files_info as $key => $file_info) {
                if (in_array($file_info['mime'], $img_mimes)) {
                    $files_info[$key]['thumb']    = image_thumb($file_info['server_path'], 'medium');
                    $files_info[$key]['is_image'] = 1;
                } else {
                    $files_info[$key]['thumb']    = image_thumb('uploads/images/default/default-thumbnail-file.png', 'medium');
                    $files_info[$key]['is_image'] = 0;
                }
            }
        }

        // Set default array
        $json['totals']     = count($files_info);
        $json['clear_list'] = 'true';
        $json['results']    = array();

        // Filter results by search
        if ($this->input->post('search') !== NULL && $this->input->post('search') !== '') {
            $search_data        = search_array($this->input->post('search'), $files_info, $key = 'name');
            $search_to_loadmore = $search_data;
            $json['totals']     = count($search_data);
            $json['results']    = array_splice($search_data, $this->offset, $this->limit);
            $json['offset']     = count($json['results']) + $this->input->post('offset');
        }

        // Loadmore results
        if ($this->input->post('offset') !== NULL && $this->input->post('offset') !== '') {
            $this->offset = $this->input->post('offset');

            if ($this->input->post('search') !== NULL && $this->input->post('search') !== '') {
                $data_loadmore = $search_to_loadmore;
            } else {
                $data_loadmore = $files_info;
            }

            $json['totals']     = count($data_loadmore);
            $json['clear_list'] = 'false';
            $json['results']    = array_splice($data_loadmore, $this->offset, $this->limit);
            $json['offset']     = count($json['results']) + $this->input->post('offset');
        }

        // Default results to show
        if (!$this->input->post('search') && !$this->input->post('offset')) {
            $json['results']    = array_splice($files_info, $this->offset, $this->limit);
            $json['offset']     = count($json['results']) + $this->input->post('offset');
        }

        // Send results to view with json
        $this->output->set_output(json_encode($json));
    }

    public function add($id = NULL)
    {
        // Load view
        if ($this->user_m->hasPermission('access', 'Media')) {
            $this->data['subview'] = 'admin/media/add_media';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function upload($dir = NULL)
    {
        if (!empty($_FILES)) {
            $image_mime = array('image/png', 'image/jpeg', 'image/gif');

            if (!in_array($_FILES['file']['type'], $image_mime)) {
                $config['upload_path']   = "./uploads/files/";
            } else {
                $config['upload_path']   = "./uploads/images/";
            }

            $config['allowed_types'] = 'jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF|pdf|PDF|docx|doc|DOC|xlsx|xls|XLXS|XLS|zip|rar|gz|tar.gz';
            $config['max_size']      = '2000';

            $this->load->library('upload', $config);
            if ($this->user_m->hasPermission('modify', 'Media')) {
                if (!$this->upload->do_upload("file")) {
                    $json['error'] = $this->upload->display_errors();
                } else {
                    $upload_data = $this->upload->data();
                    $json['is_image'] = $upload_data['is_image'] ? 1 : 0;
                    if ($upload_data['is_image']) {
                        $json['url']  = image_thumb('uploads/images/' . $upload_data['file_name'], 'medium');
                        $json['path'] = 'uploads/images/' . $upload_data['file_name'];
                        $json['name'] = $upload_data['file_name'];
                    } else {
                        $json['url']  = image_thumb('uploads/images/default/default-thumbnail-file.png');
                        $json['path'] = 'uploads/files/' . $upload_data['file_name'];
                        $json['name'] = $upload_data['file_name'];
                    }
                }
            } else {
                $json['error'] = lang('error_permission');
            }
            $this->output->set_output(json_encode($json));
        }
    }

    public function delete()
    {
        if ($this->validate_delete('Media')) {
            $media = $this->setting_m->get_setting('media_setting');

            if ($this->input->post('file_to_remove')) {
                $file_to_remove = $this->input->post('file_to_remove');
                $file_small     = dirname($file_to_remove) . '/cache/' . $media['image_sm_width'] . 'x' . $media['image_sm_height'] . '_' . basename($file_to_remove);
                $file_medium    = dirname($file_to_remove) . '/cache/' . $media['image_md_width'] . 'x' . $media['image_md_height'] . '_' . basename($file_to_remove);
                $file_larger    = dirname($file_to_remove) . '/cache/' . $media['image_lg_width'] . 'x' . $media['image_lg_height'] . '_' . basename($file_to_remove);

                if (file_exists($file_small)) {
                    unlink($file_small);
                }

                if (file_exists($file_medium)) {
                    unlink($file_medium);
                }

                if (file_exists($file_larger)) {
                    unlink($file_larger);
                }

                if (file_exists($file_to_remove)) {
                    unlink($file_to_remove);
                }
            }

            if ($this->input->post('selected')) {
                foreach ($this->input->post('selected') as $file) {
                    $file_to_remove = $file;
                    $file_small     = dirname($file_to_remove) . '/cache/' . $media['image_sm_width'] . 'x' . $media['image_sm_height'] . '_' . basename($file_to_remove);
                    $file_medium    = dirname($file_to_remove) . '/cache/' . $media['image_md_width'] . 'x' . $media['image_md_height'] . '_' . basename($file_to_remove);
                    $file_larger    = dirname($file_to_remove) . '/cache/' . $media['image_lg_width'] . 'x' . $media['image_lg_height'] . '_' . basename($file_to_remove);

                    if (file_exists($file_small)) {
                        unlink($file_small);
                    }

                    if (file_exists($file_medium)) {
                        unlink($file_medium);
                    }

                    if (file_exists($file_larger)) {
                        unlink($file_larger);
                    }

                    if (file_exists($file_to_remove)) {
                        unlink($file_to_remove);
                    }
                }

                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/media');
            }

            if (!$this->input->post('file_to_remove') && !$this->input->post('selected')) {
                $this->session->set_flashdata('error', lang('error_delete'));
                redirect('admin/media');
            }
        }
    }
}
