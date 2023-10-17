<?php
class Page extends Frontend_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($page_slug = NULL)
    {
        // Get id by slug
        $id = get_id_byslug(array('table' => 'page_description', 'slug' => $page_slug));

        // Set post slug data
        $this->data['page_slug'] = $page_slug;

        // Set meta
        $params = array(
            'table_name'  => 'page_description',
            'select'      => 'title',
            'primary_key' => 'page_id',
            'id'          => $id['page_id']
        );
        $results = $this->frontend_m->get_header_meta($params);

        if ($results && isset($results[$this->data['language_code']])) {
            $this->data['header_meta'] = array(
                'meta_title'       => $results[$this->data['language_code']]['title'] . ' | ' . $this->data['general'][$this->data['language_code']]['website_name'],
                'meta_description' => get_excerpt($results[$this->data['language_code']]['description'], 150),
                'meta_keyword'     => $results[$this->data['language_code']]['title']
            );
        }
        // Switch language
        $params = array(
            'table_name'  => 'page_description',
            'primary_key' => 'page_id',
            'id'          => $id['page_id']
        );
        $page_desc = $this->frontend_m->get_slugs($params);

        if ($page_desc) {
            foreach ($this->data['languages'] as $language) {
                if (isset($page_desc[$language['language_code']])) {
                    $this->data['switch_langs'][] = array(
                        'lang_name' => $language['name'],
                        'redirect'  => base_url() . $language['language_code'] . '/' . 'page/' . $page_desc[$language['language_code']]['slug'] . '.html'
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

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'page';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}
