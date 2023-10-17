<?php
class Page_M extends MY_Model
{
	protected $_table_name = 'page';
	protected $_order_by = 'page_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
		$this->load->model('setting/setting_m');
	}

	public function get_new_page()
	{
		$this->load->model('setting/language_m');
		$languages = $this->language_m->get();

		$result['page_data'] = array(
			'page_id'    => '',
			'sort_order' => '',
			'image'      => '',
			'image_path' => base_url('uploads/images/default/default-thumbnail.png'),
			'status'     => '1'
	    );

		foreach( $languages as $language )
		{
			$page_desc[$language['language_code']] = array(
				'page_id'     => '',
				'title'       => set_value('title'),
				'description' => set_value('description'),
			);
		}

		$result['page_desc']  = $page_desc;
		$result['page_image'] = array();

		return $result;
	}

	public function get_pages($id = NULL)
	{
		if ($id) {
			$this->_table_name = 'page';
			$where = array(
				'page_id' => $id
			);
	        $result['page_data'] = $this->get_by($where, TRUE);

			if ($result['page_data']) {
				$this->_table_name = 'page_description';
				$where = array(
					'page_id' => $id
				);
				$query = $this->get_by($where, FALSE);
				$languages = array();
				foreach( $query as $language )
				{
					$languages[$language['language_code']] = $language;
				}
				$result['page_desc'] = $languages;

				// Blog image
				$this->_table_name = 'page_image';
				$this->_order_by   = 'page_image_id';
				$where = array(
					'page_id' => $id
				);

				$images_result = $this->get_by($where, FALSE);

				$result['page_image'] = array();
				if ($images_result) {
					$result['page_image'] = $images_result;
				}

				return $result;
			}
		} else {
	        $results = $this->get();
	        if ($results) {
		        foreach ($results as $key => $page) {
					$result[$key]['page_data'] = $page;

					$this->_table_name = 'page_description';
					$where = array(
						'page_id' => $page['page_id']
					);
					$query = $this->get_by($where, FALSE);
					$languages = array();
					foreach( $query as $language )
					{
						$languages[$language['language_code']] = $language;
					}
					$result[$key]['page_desc'] = $languages;
		        }

	        	return $result;
	        }

	        return false;

		}
	}

	public function save_page($data, $id = NULL)
	{
		$this->_table_name = 'page';
		$languages = $this->language_m->get_active();

		if( isset($data['page_data']) )
		{
			if( (int) $data['page_data']['page_id'] > 0)
			{
				$this->db->set($data['page_data']);
				$this->db->where('page_id', $id);
				$this->db->update($this->_table_name);
			}
			else
			{
				unset($data["page_data"]['page_id']);
				$this->db->set($data['page_data']);
				$this->db->insert($this->_table_name);
				$data['page_data']['page_id'] = $this->db->insert_id();
			}
		}

		// page_desc data
		if( isset($data['page_desc']) )
		{
			$this->db->where('page_id', $data['page_data']['page_id']);
			$this->db->delete('page_description');

			foreach( $languages as $language )
			{
				$page_desc = array(
					'page_id'       => $data['page_data']['page_id'],
					'language_code' => $language['language_code'],
					'title'         => $data['page_desc'][$language['language_code']]['title'],
					'slug'          => $this->unique_page_slug(get_slug($data['page_desc'][$language['language_code']]['title']), $data['page_data']['page_id']),
					'description'   => $data['page_desc'][$language['language_code']]['description']
				);

				$this->db->set($page_desc);
				$this->db->insert('page_description');
			}
		}

		if( isset($data['post_image']) )
		{
			if (count($data['post_image'])) {
				// Delete all image by blog_id
				$this->db->where('page_id', $data['page_data']['page_id']);
				$this->db->delete('page_image');

				foreach ($data['post_image'] as $image) {
					$image['status'] = isset($image['status']) ? $image['status'] : 0;
					$image['page_id'] = $data['page_data']['page_id'];

					// Insert
					$this->db->set($image);
					$this->db->insert('page_image');
				}
			}
		}
	}

	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where('page_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}

    public function unique_page_slug($title = NULL, $page_id = NULL)
    {
        $slug = $title;
        $i = 1;
        while ($this->check_slug($slug, $page_id)) {
            $slug = $title . '-' . $i++;
        }
        return $slug;
    }

    public function check_slug($slug, $page_id)
    {
        $this->db->select('slug');
        $this->db->from('page_description');
        $this->db->where('slug', $slug);
        !$page_id || $this->db->where('page_id !=', $page_id);
        $slug = $this->db->get()->result_array();

        if (count($slug) > 0) {
            return TRUE;
        }
    }

    public function get_pages_sitemap($language_code = NULL)
    {
    	$this->db->select('page_id');
    	$this->db->from('page');
    	$this->db->order_by('page_id ASC');
    	$result_posts = $this->db->get()->result_array();

    	foreach ($result_posts as $result_post) {
	        $params = array(
				'table_name'    => 'page_description',
				'primary_key'   => 'page_id',
				'id'            => $result_post['page_id']
	        );
    		$result_descs[] = $this->get_slugs($params);
    	}

    	$results = array();
    	foreach ($result_descs as $key => $value) {
    		if (isset($value[$language_code])) {
    			$results[$key]['main_url'] = site_url('page/' . $value[$language_code]['slug']);
    			$results[$key]['alt_url'] = $value;
    		}
    	}
    	return $results;
    }

	public function delete_page($id)
	{
		$this->db->where('page_id', $id);
		$this->db->delete('page');
		$this->db->where('page_id', $id);
		$this->db->delete('page_description');
	}

}