<?php
class Comment extends Admin_controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('blog/comment_m');
        $this->load->model('blog/blog_m');
    }

    public function index() {
        if ($this->user_m->hasPermission('access', 'blog/Comment')) {
            $this->data['subview'] = 'admin/blog/comment/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'comment_m',
            'sIndexColumn'        => 'comment_id',
            'table_name'          => 'blog_comment',
            'table_join_name'     => NULL,
            'table_join_col_name' => NULL,
            'where_options'       => array(),
            'search_col_name'     => 'comment',
            'aColumns'            => array('comment_id', 'user', 'email', 'created', 'comment', 'blog_id', 'status', 'comment_id')
        );

        $query = $this->datatable->index($config);

        $rResult['aaData'] = array();
        if (! empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array (
                    '0' => $value[0],
                    '1' => '<img src="' . get_gravatar( $value[2], 100 ) . '" class="tbl-image-circle">' . '<span style="font-weight:bold; display: block; clear: both;">' . mailto($value[2], $value[1]) . '</span>',
                    '2' => '<small class="text-primary">Dikirim pada : ' . $value[3] . '</small><br>' . substr( clean_output($value[4]),0, 100 ) . '...',
                    '3' => $this->get_post_title($value[5]),
                    '4' => $value[6],
                    '5' => $value[7]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
        // Fetch a comment or set a new one
        if ($id) {
            $result = $this->comment_m->get_comment($id);
            $result['article_title'] = $this->get_post_title($result['blog_id']);
            $this->data['comment'] = $result;
        } else {
            $this->data['comment'] = '';
        }

        // Set up the form
        $rules = $this->comment_m->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE && $this->validate_modify('blog/Comment')) {
            $data = $this->input->post();
            $this->comment_m->save_comment($data, $id);
            redirect('admin/blog/comment/index');
        }

        // Load the view
        if ($this->user_m->hasPermission('access', 'blog/Comment')) {
            $this->data['subview'] = 'admin/blog/comment/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('modify', 'blog/Comment')) {
            if ($status == 'true') {
                if ($this->comment_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->comment_m->update_status($id, 0)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            }
        }else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }

    protected function get_post_title($blog_id = NULL)
    {
        $result = $this->blog_m->get_posts($blog_id);

        if ($result) {
            return clean_output($result['blog_desc'][$this->data['language_code']]['title']);
        }

        return FALSE;
    }

    public function delete($id = NULL)
    {
        if ($this->validate_delete('blog/Comment')) {
            if ($id) {
                $this->comment_m->delete_comment($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/blog/comment');
            }
            else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->comment_m->delete_comment($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/blog/comment');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/blog/comment');
                }
            }
        }
    }

}