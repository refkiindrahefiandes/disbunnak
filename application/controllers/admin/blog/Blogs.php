<?php
class Blogs extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog/blog_m');
        $this->load->model('blog/blog_category_m');
        $this->load->model('blog/blog_tag_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'blog/Blogs')) {
            $this->data['subview'] = 'admin/blog/blogs/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'blog_m',
            'sIndexColumn'        => 'blog_id',
            'table_name'          => 'blog',
            'table_join_name'     => 'blog_description',
            'table_join_col_name' => 'title',
            'where_options'       => array('blog_description.language_code' => $this->data['language_code']),
            'search_col_name'     => 'title',
            'aColumns'            => array('blog_id', 'title', 'user_id', 'blog_id', 'status', 'blog_id')
        );

        $query = $this->datatable->index($config);

        $rResult['aaData'] = array();
        if (!empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array(
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $this->get_username($value[2]),
                    '3' => $this->get_category_name($value[3]),
                    '4' => $value[4],
                    '5' => $value[5]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
        $this->data['categories']  = $this->blog_category_m->get_categories();

        // Button and publish permission
        if ($this->validate_publish_post('blog/Blogs')) {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_save');
            $this->data['publish_permission'] = TRUE;
        } else {
            $this->data['button'] = '<i class="icon ion-android-upload"></i> ' . lang('btn_send_to_editor');
            $this->data['publish_permission'] = FALSE;
        }

        // Data Status
        $this->data['comment_status'] = array(
            '1' => 'Enable',
            '0' => 'Disable'
        );

        // Fetch a blog or set a new one
        if ($id) {
            $result = $this->blog_m->get_posts($id);
            if ($result !== false) {
                // Featured Image
                if ($result['blog_data']['image']) {
                    $image_path = base_url($result['blog_data']['image']);
                } else {
                    $image_path = base_url('uploads/images/default/default-thumbnail.png');
                }

                $blog_data = array();
                $blog_data = $result;
                $blog_data['blog_data']['image_path'] = $image_path;


                // Featured video
                $url_embed = NULL;
                if ($result['blog_data']['video']) {
                    $url = explode("=", $result['blog_data']['video']);
                    if (isset($url[1])) {
                        $url_embed = '//www.youtube.com/embed/' . $url[1];
                    }
                }
                $blog_data['blog_data']['video_embed'] = $url_embed;


                // Menambaghkan key bahasa pada array blog_data
                foreach ($this->data['languages'] as $key => $value) {
                    if (isset($blog_data['blog_desc']) && isset($blog_data['blog_desc'][$value['language_code']])) {
                        $blog_data['blog_desc'][$value['language_code']] = $blog_data['blog_desc'][$value['language_code']];
                    } else {
                        $blog_data['blog_desc'][$value['language_code']] = array(
                            'title'            => '',
                            'content'          => '',
                            'meta_title'       => '',
                            'meta_description' => '',
                            'meta_keyword'     => '',
                            'tag'              => ''
                        );
                    }
                }

                // Galer gambar
                foreach ($result['blog_image'] as $key => $gambar) {
                    if ($gambar['image'] === '' || $gambar['image'] === NULL) {
                        $galeri_gambar = base_url('uploads/images/default/default-thumbnail.png');
                    } else {
                        $galeri_gambar = base_url($gambar['image']);
                    }

                    $blog_data['blog_image'][$key] = $gambar;
                    $blog_data['blog_image'][$key]['image'] = $galeri_gambar;
                    $blog_data['blog_image'][$key]['image_path'] = $gambar['image'];
                }

                $this->data['blog'] = $blog_data;
            } else {
                $this->data['blog'] = $this->blog_m->get_new_blog();
            }
        } else {
            $this->data['blog'] = $this->blog_m->get_new_blog();
        }

        // Set blog_desc_firstkey for tag (textextjs)
        $this->data['firstkey'] = $this->data['language_code'];

        // VALIDASI FORM
        $rules = $this->blog_m->rules;
        $this->form_validation->set_rules($rules);

        foreach ($this->data['languages'] as $language) {
            $this->form_validation->set_rules("blog_desc[$language[language_code]][title]", 'Title', 'trim|required|max_length[255]');
        }

        // Process the form
        if ($this->form_validation->run() == TRUE && $this->validate_modify_post('blog/Blogs')) {
            $data = $this->input->post();

            $data['blog_data']['user_id'] = $this->session->userdata['user_id'];

            if (empty($data['category_data'])) {
                $data['category_data'] = array(1);
            }

            if ($this->validate_publish_post('blog/Blogs')) {
                $data['blog_data']['status'] = $this->input->post('blog_data[status]');
            } else {
                $data['blog_data']['status'] = 0;
            }

            $r = $this->blog_m->save_post($data, $id);
            redirect('admin/blog/blogs');
        }

        // Load the view
        if ($this->user_m->hasPermission('access', 'blog/Blogs')) {
            $this->data['subview'] = 'admin/blog/blogs/edit';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('publish', 'blog/Blogs')) {
            if ($status == 'true') {
                if ($this->blog_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->blog_m->update_status($id, 0)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            }
        } else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }

    public function get_username($user_id = NULL)
    {
        if ($user_id != NULL) {
            $username = $this->user_m->get($user_id);
            return $username['username'];
        }
    }

    public function get_category_name($blog_id = NULL)
    {
        if ($blog_id) {
            $term_data = $this->blog_m->get_category_info($blog_id);

            $term_results = array();
            foreach ($term_data as $key => $term) {
                $term_results[] = $term['name'];
            }

            return implode(", ", $term_results);
        }
    }

    public function get_tags_ajax($lang_id = NULL)
    {
        $results = $this->blog_tag_m->get_tags(NULL, $lang_id);
        foreach ($results as $result) {
            $json[] = $result['name'];
        }

        $this->output->set_output(json_encode($json));
    }

    public function delete($id = NULL)
    {
        if ($this->validate_delete_post('blog/Blogs')) {
            if ($id) {
                $this->blog_m->delete_blog($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/blog/blogs');
            } else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->blog_m->delete_blog($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/blog/blogs');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/blog/blogs');
                }
            }
        }
    }

    // Validate
    public function validate_modify_post($controller = NULL)
    {
        if ($this->user_m->hasPermission('modify', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_publish_post($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    public function validate_delete_post($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}
