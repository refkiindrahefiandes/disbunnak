<?php
class Agenda extends Frontend_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($offset = 0)
    {
        // Switch language
        if (count($this->data['languages'])) {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code'] . '/' . 'agenda' . '.html'
                );
            }
        }

        // get search string
        $total_agenda = query_agendas(array('limit' => 0, 'offset' => $offset));

        // Set data
        $this->data['offset']        = $offset;

        $this->data['base_url']      = base_url($this->data['language_code'] . '/agenda' . '/');
        $this->data['total_agenda']  = count(array($total_agenda));
        $this->data['uri_segment']   = 3;

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'agenda/index';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }

    public function single($slug = NULL)
    {
        $result = $this->frontend_m->get_data($slug, 'agenda_description', 'slug');

        $agenda_data = array(
            'agenda_id'         => $result['agenda_id'],
            'language_code'     => $result['language_code'],
            'description'       => $result['description'],
            'slug'              => $result['slug'],
            'information'       => $result['information']
        );

        $this->data['agenda'] = $agenda_data;

        // Switch language
        if (count($this->data['languages'])) {
            foreach ($this->data['languages'] as $key => $language) {
                $this->data['switch_langs'][] = array(
                    'lang_name' => $language['name'],
                    'redirect'  => base_url() . $language['language_code']
                );
            }
        }

        $this->data['subview'] = 'frontend/' . $this->data['active_theme'] . '/' . 'agenda/detail';
        $this->load->view('frontend/' . $this->data['active_theme'] . '/_layout_main', $this->data);
    }
}
