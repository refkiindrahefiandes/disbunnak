<?php
class Agenda_M extends MY_Model
{
	protected $_table_name = 'agenda';
	protected $_order_by = 'agenda_id';
	public $rules = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('setting/setting_m');
	}

	public function get_new_agenda()
	{
		$this->load->model('setting/language_m');
		$languages = $this->language_m->get();

		$result['agenda_data'] = array(
			'agenda_id'  => '',
			'date_begin' => set_value('date_begin'),
			'date_end'   => set_value('date_end'),
			'time'       => set_value('time'),
			'location'   => set_value('location'),
			'organizer'  => set_value('organizer'),
			'status'     => '1'
		);

		foreach ($languages as $language) {
			$agenda_desc[$language['language_code']] = array(
				'agenda_id'   => '',
				'description' => set_value('description'),
				'information' => set_value('information')
			);
		}

		$result['agenda_desc']   = $agenda_desc;

		return $result;
	}

	public function get_agendas($id = NULL)
	{
		if ($id) {
			$this->_table_name = 'agenda';
			$where = array(
				'agenda_id' => $id
			);
			$result['agenda_data'] = $this->get_by($where, TRUE);

			if ($result['agenda_data']) {
				$this->_table_name = 'agenda_description';
				$where = array(
					'agenda_id' => $id
				);
				$query = $this->get_by($where, FALSE);
				$languages = array();
				foreach ($query as $language) {
					$languages[$language['language_code']] = $language;
				}
				$result['agenda_desc'] = $languages;

				return $result;
			}
		} else {
			$results = $this->get();
			foreach ($results as $key => $agenda) {
				$result[$key]['agenda_data'] = $agenda;

				$this->_table_name = 'agenda_description';
				$where = array(
					'agenda_id' => $agenda['agenda_id']
				);
				$query = $this->get_by($where, FALSE);
				$languages = array();
				foreach ($query as $language) {
					$languages[$language['language_code']] = $language;
				}
				$result[$key]['agenda_desc'] = $languages;

				return $result;
			}
		}
	}

	public function save_agenda($data, $id = NULL)
	{
		$this->_table_name = 'agenda';
		$languages = $this->language_m->get_active();

		if (isset($data['agenda_data'])) {
			if ((int) $data['agenda_data']['agenda_id'] > 0) {
				$this->db->set($data['agenda_data']);
				$this->db->where('agenda_id', $id);
				$this->db->update($this->_table_name);
			} else {
				unset($data["agenda_data"]['agenda_id']);
				$this->db->set($data['agenda_data']);
				$this->db->insert($this->_table_name);
				$data['agenda_data']['agenda_id'] = $this->db->insert_id();
			}
		}

		// agenda_desc data
		if (isset($data['agenda_desc'])) {
			$this->db->where('agenda_id', $data['agenda_data']['agenda_id']);
			$this->db->delete('agenda_description');

			foreach ($languages as $language) {
				$agenda_desc = array(
					'agenda_id'     => $data['agenda_data']['agenda_id'],
					'language_code' => $language['language_code'],
					'description'   => $data['agenda_desc'][$language['language_code']]['description'],
					'slug'			=> get_slug($data['agenda_desc'][$language['language_code']]['description']),
					'information'   => $data['agenda_desc'][$language['language_code']]['information']
				);

				$this->db->set($agenda_desc);
				$this->db->insert('agenda_description');
			}
		}
	}

	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where('agenda_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}

	public function unique_agenda_slug($title = NULL, $agenda_id = NULL)
	{
		$slug = $title;
		$i = 1;
		while ($this->check_slug($slug, $agenda_id)) {
			$slug = $title . '-' . $i++;
		}
		return $slug;
	}

	public function check_slug($slug, $agenda_id)
	{
		$this->db->select('slug');
		$this->db->from('agenda_description');
		$this->db->where('slug', $slug);
		!$agenda_id || $this->db->where('agenda_id !=', $agenda_id);
		$slug = $this->db->get()->result_array();

		if (count($slug) > 0) {
			return TRUE;
		}
	}

	public function get_agendas_sitemap($language_code = NULL)
	{
		$this->db->select('agenda_id');
		$this->db->from('agenda');
		$this->db->order_by('agenda_id ASC');
		$result_posts = $this->db->get()->result_array();

		foreach ($result_posts as $result_post) {
			$params = array(
				'table_name'    => 'agenda_description',
				'select'        => 'agenda_id',
				'id'            => $result_post['agenda_id']
			);
			$result_descs[] = $this->get_slugs($params);
		}

		$results = array();
		foreach ($result_descs as $key => $value) {
			if (isset($value[$language_code])) {
				$results[$key]['main_url'] = site_url('agenda/' . $value[$language_code]['slug']);
				$results[$key]['alt_url'] = $value;
			}
		}
		return $results;
	}

	public function delete_agenda($id)
	{
		$this->db->where('agenda_id', $id);
		$this->db->delete('agenda');
		$this->db->where('agenda_id', $id);
		$this->db->delete('agenda_description');
	}
}
