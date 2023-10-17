<?php
class Tool extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function backup()
    {
        if (count($this->input->post('table_data'))) {
            $table_data = $this->input->post('table_data');

            foreach ($this->input->post('table_data') as $key => $value) {
                if ($value === 'blog') {
                    array_push($table_data, 'blog_description');
                    array_push($table_data, 'blog_to_term');
                }

                if ($value === 'page') {
                    array_push($table_data, 'page_description');
                }

                if ($value === 'blog_term') {
                    array_push($table_data, 'blog_term_description');
                }

                if ($value === 'menu') {
                    array_push($table_data, 'menu_item');
                }
            }

            // Load the DB utility class
            $this->load->dbutil();

            $prefs = array(
                'tables'     => $table_data,
                'ignore'     => array(),
                'format'     => 'sql',
                'add_drop'   => TRUE,
                'add_insert' => TRUE,
                'newline'    => "\n"
            );

            $backup  =& $this->dbutil->backup($prefs);
            $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.sql';
            $save    = './backups/'.$db_name;

            // $this->load->helper('file');
            // write_file($save, $backup);

            $this->load->helper('download');
            force_download($db_name, $backup);
        }

        $this->data['tables'] = array(
            array(
                'table_slug' => 'blog',
                'table_name' => 'Posts'
            ),
            array(
                'table_slug' => 'page',
                'table_name' => 'Pages'
            ),
            array(
                'table_slug' => 'blog_comment',
                'table_name' => 'Post Comments'
            ),
            array(
                'table_slug' => 'blog_term',
                'table_name' => 'Categories & Tags'
            ),
            array(
                'table_slug' => 'menu',
                'table_name' => 'Menus'
            )
        );

        // Load view
        if ($this->user_m->hasPermission('access', 'Tool')) {
            $this->data['subview'] = 'admin/tool/backup';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function upload_backup()
    {
        if (!empty($_FILES))
        {
            $config['upload_path']   = "./uploads/files/";
            $config['allowed_types'] = 'sql|txt';
            $config['max_size']      = '2000';

            $this->load->library('upload', $config);

            $json = array();

            if ($this->user_m->hasPermission('modify', 'Tool')) {
                if (! $this->upload->do_upload("file")) {
                    $json['error'] = $this->upload->display_errors();
                } else {
                    $upload_data  = $this->upload->data();
                    $file_restore = $this->load->file($upload_data['full_path'], true);

                    foreach (explode(";\n", $file_restore) as $sql) {
                        $sql = trim($sql);

                        if ($sql) {
                            $this->db->query($sql);
                        }
                    }

                    // Delete file after restore
                    unlink($upload_data['full_path']);

                    $json['success'] = lang('success_restore');
                }
            } else {
                $json['error'] = lang('error_permission');
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($json));
        }
    }
}