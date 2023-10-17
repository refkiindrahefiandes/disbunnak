<?php
class Blog extends Frontend_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog/comment_m');
    }

    public function index()
    {
        redirect(base_url());
    }

    public function single($slug = NULL)
    {
        // Get id by slug
        $id = get_id_byslug(array('table' => 'blog_description', 'slug' => $slug));
        $this->data['post_url'] = base_url() . $this->data['language_code'] . '/' . 'blog/' . $slug . '.html';

        // Set post slug data
        $this->data['slug'] = $slug;

        // Set header meta
        $params = array(
            'table_name'  => 'blog_description',
            'select'      => 'title',
            'primary_key' => 'blog_id',
            'id'          => $id['blog_id']
        );
        $results = $this->frontend_m->get_header_meta($params);

        if ($results && isset($results[$this->data['language_code']])) {
            $tag_result = array();
            $tags = $this->frontend_m->get_terms_info(array('blog_id' => $results[$this->data['language_code']]['blog_id'], 'term_type' => 'tag'));
            if ($tags) {
                foreach ($tags as $tag) {
                    $tag_result[] = $tag['name'];
                }
            }
            $this->data['header_meta'] = array(
                'meta_title'       => $results[$this->data['language_code']]['title'] . ' | ' . $this->data['general'][$this->data['language_code']]['website_name'],
                'meta_description' => get_excerpt($results[$this->data['language_code']]['content'], 150),
                'meta_keyword'     => implode(',', $tag_result)
            );
        }

        // Switch language
        $params = array(
            'table_name'  => 'blog_description',
            'primary_key' => 'blog_id',
            'id'          => $id['blog_id']
        );
        $post_desc = $this->frontend_m->get_slugs($params);

        if ($post_desc) {
            foreach ($this->data['languages'] as $language) {
                if (isset($post_desc[$language['language_code']])) {
                    $this->data['switch_langs'][] = array(
                        'lang_name' => $language['name'],
                        'redirect'  => base_url() . $language['language_code'] . '/' . 'blog/' . $post_desc[$language['language_code']]['slug'] . '.html'
                    );
                } else {
                    $this->data['switch_langs'][] = array(
                        'lang_name' => $language['name'],
                        'redirect'  => base_url() . $language['language_code']
                    );
                }
            }
        } else {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code']
                );
            }
        }

        // Set up the form
        $rules = array(
            'user' => array(
                'field' => 'user',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[200]'
            ),
            'email' => array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email|max_length[100]'
            ),
            'url' => array(
                'field' => 'url',
                'label' => 'URL',
                'rules' => 'max_length[500]'
            ),
            'comment' => array(
                'field' => 'comment',
                'label' => 'Comment',
                'rules' => 'trim|required|max_length[1500]'
            )
        );

        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'blog_id'   => $this->input->post('blog_id'),
                'parent_id' => $this->input->post('parent_id'),
                'user'      => $this->input->post('user'),
                'email'     => $this->input->post('email'),
                'url'       => '', //$this->input->post('url'),
                'comment'   => $this->input->post('comment'),
                'status'    => 0,
                'created'   => date('Y-m-d h:i:s')
            );

            if ($this->input->post('name') === '') {
                $this->comment_m->save_comment($data);
            }

            redirect('/blog/' . $slug);
        }

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'single';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function category($category_slug = NULL, $offset = 0)
    {
        // Get id by slug
        $id = get_id_byslug(array('table' => 'blog_term_description', 'slug' => $category_slug));

        // Set meta
        $params = array(
            'table_name'  => 'blog_term_description',
            'select'      => 'name',
            'primary_key' => 'term_id',
            'id'          => $id['term_id']
        );
        $results = $this->frontend_m->get_header_meta($params);

        if ($results && isset($results[$this->data['language_code']])) {
            $this->data['header_meta'] = array(
                'meta_title'       => $results[$this->data['language_code']]['name'] . ' | ' . $this->data['general'][$this->data['language_code']]['website_name'],
                'meta_description' => get_excerpt($results[$this->data['language_code']]['description'], 150),
                'meta_keyword'     => $results[$this->data['language_code']]['name']
            );
        }

        // Switch language
        $params = array(
            'table_name'  => 'blog_term_description',
            'primary_key' => 'term_id',
            'id'          => $id['term_id']
        );
        $term_desc = $this->frontend_m->get_slugs($params);

        if ($term_desc) {
            foreach ($this->data['languages'] as $language) {
                if (isset($term_desc[$language['language_code']])) {
                    $this->data['switch_langs'][] = array(
                        'lang_name' => $language['name'],
                        'redirect'  => base_url() . $language['language_code'] . '/' . 'blog/category/' . $term_desc[$language['language_code']]['slug'] . '.html'
                    );
                } else {
                    $this->data['switch_langs'][] = array(
                        'lang_name' => $language['name'],
                        'redirect'  => base_url() . $language['language_code']
                    );
                }
            }
        } else {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code']
                );
            }
        }

        // Get category data
        $results = $this->frontend_m->get_terms(array('slug' => $category_slug));
        if (count($results)) {
            foreach ($results as $result) {
                $this->data['term_data'] = $result;
                $this->data['term_data']['name'] = 'Category : ' . $result['name'];
                $this->data['term_data']['total_post'] = $this->frontend_m->count_totals('blog_to_term', array('term_id' => $result['term_id'], 'term_type' => 'category'));
            }
        } else {
            $this->data['term_data'] = array(
                'name'       => '',
                'term_type'  => '',
                'total_post' => 0
            );
        }

        // Set data
        $this->data['slug']        = $category_slug;
        $this->data['slug_type']   = $this->data['term_data']['term_type'];
        $this->data['offset']      = $offset;

        $this->data['base_url']    = base_url('blog/category/' . $category_slug . '/');
        $this->data['total_post']  = $this->data['term_data']['total_post'];
        $this->data['uri_segment'] = 4;

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'archive';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function tag($tag_slug = NULL, $offset = 0)
    {
        // Get id by slug
        $id = get_id_byslug(array('table' => 'blog_term_description', 'slug' => $tag_slug));

        // Set meta
        $params = array(
            'table_name'  => 'blog_term_description',
            'select'      => 'name',
            'primary_key' => 'term_id',
            'id'          => $id['term_id']
        );
        $results = $this->frontend_m->get_header_meta($params);

        if ($results && isset($results[$this->data['language_code']])) {
            $this->data['header_meta'] = array(
                'meta_title'       => $results[$this->data['language_code']]['name'] . ' | ' . $this->data['general'][$this->data['language_code']]['website_name'],
                'meta_description' => get_excerpt($results[$this->data['language_code']]['description'], 150),
                'meta_keyword'     => $results[$this->data['language_code']]['name']
            );
        }

        // Switch language
        $params = array(
            'table_name'  => 'blog_term_description',
            'primary_key' => 'term_id',
            'id'          => $id['term_id']
        );
        $term_desc = $this->frontend_m->get_slugs($params);

        if ($term_desc) {
            foreach ($this->data['languages'] as $language) {
                if (isset($term_desc[$language['language_code']])) {
                    $this->data['switch_langs'][] = array(
                        'lang_name' => $language['name'],
                        'redirect'  => base_url() . $language['language_code'] . '/' . 'blog/tag/' . $term_desc[$language['language_code']]['slug'] . '.html'
                    );
                } else {
                    $this->data['switch_langs'][] = array(
                        'lang_name' => $language['name'],
                        'redirect'  => base_url() . $language['language_code']
                    );
                }
            }
        } else {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code']
                );
            }
        }

        // Get tag data
        $results = $this->frontend_m->get_terms(array('slug' => $tag_slug));

        if (count($results)) {
            foreach ($results as $result) {
                $this->data['term_data'] = $result;
                $this->data['term_data']['name'] = 'Tag : ' . $result['name'];
                $this->data['term_data']['total_post'] = $this->frontend_m->count_totals('blog_to_term', array('term_id' => $result['term_id'], 'term_type' => 'tag'));
            }
        } else {
            $this->data['term_data'] = array(
                'name'       => '',
                'term_type'  => '',
                'total_post' => 0
            );
        }

        // Set data
        $this->data['slug']        = $tag_slug;
        $this->data['slug_type']   = $this->data['term_data']['term_type'];
        $this->data['offset']      = $offset;

        $this->data['base_url']    = base_url('blog/tag/' . $tag_slug . '/');
        $this->data['total_post']  = $this->data['term_data']['total_post'];
        $this->data['uri_segment'] = 4;

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'archive';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}
