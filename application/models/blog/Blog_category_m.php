<?php
class Blog_category_M extends MY_Model
{
	protected $_table_name = 'blog_term';
	protected $_order_by = 'term_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_category()
	{
		$this->load->model('setting/language_m');
		$languages = $this->language_m->get_active();

		$result['category_data'] = array(
			'term_id'    => '',
			'parent_id'  => '',
			'sort_order' => '',
			'status'     => ''
	    );

		foreach( $languages as $language )
		{
			$category_desc[$language['language_code']] = array(
				'term_id'     => '',
				'name'        => set_value('name'),
				'description' => set_value('description')
			);
		}

		$result['category_desc']   = $category_desc;

		return $result;
	}

	public function get_categories($term_id = NULL)
	{
		if ($term_id) {
			$this->_table_name = 'blog_term';
			$where = array(
				'term_id' => $term_id
			);

	        $result['category_data'] = $this->get_by($where, TRUE);

	        if ($result['category_data']) {
		        $this->_table_name = 'blog_term_description';
		        $query = $this->get_by($where, FALSE);

				$languages = array();
				foreach( $query as $language )
				{
					$languages[$language['language_code']] = $language;
				}
				$result['category_desc'] = $languages;

				return $result;
	        }
		} else {
			$this->_table_name = 'blog_term';
			$where = array(
				'term_type' => 'category'
			);
			$results = $this->get_by($where, FALSE);

			if ($results) {
		        foreach ($results as $key => $term) {
					$result[$key]['term_data'] = $term;

					$this->_table_name = 'blog_term_description';
					$where = array(
						'term_id' => $term['term_id']
					);
					$query = $this->get_by($where, FALSE);
					$languages = array();
					foreach( $query as $language )
					{
						$languages[$language['language_code']] = $language;
					}
					$result[$key]['term_desc'] = $languages;
				}
				return $result;
			}

			return false;
		}
	}

	public function save_category($data, $id = NULL)
	{
		$this->_table_name = 'blog_term';
		$languages = $this->language_m->get_active();

		if( isset($data['category_data']) )
		{
			if( (int) $data['category_data']['term_id'] > 0)
			{
				$this->db->set($data['category_data']);
				$this->db->where('term_id', $id);
				$this->db->update($this->_table_name);
			}
			else
			{
				unset($data["category_data"]['term_id']);

				$this->db->set($data['category_data']);
				$this->db->insert($this->_table_name);
				$data['category_data']['term_id'] = $this->db->insert_id();
			}
		}

		// category_desc data
		if( isset($data['category_desc']) )
		{
			$this->db->where('term_id', $data['category_data']['term_id']);
			$this->db->delete('blog_term_description');

			foreach( $languages as $language )
			{
				$category_desc = array(
					'term_id'       => $data['category_data']['term_id'],
					'language_code' => $language['language_code'],
					'name'          => $data['category_desc'][$language['language_code']]['name'],
					'slug'          => $this->unique_term_category_slug(get_slug($data['category_desc'][$language['language_code']]['name']), $data['category_data']['term_id']),
					'description'   => $data['category_desc'][$language['language_code']]['description'],
				);

				$this->db->set($category_desc);
				$this->db->insert('blog_term_description');
			}
		}
	}

	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where('term_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}

    public function unique_term_category_slug($title = NULL, $term_id = NULL)
    {
        $slug = $title;
        $i = 1;
        while ($this->check_slug($slug, $term_id)) {
            $slug = $title . '-' . $i++;
        }
        return $slug;
    }

    public function check_slug($slug, $term_id)
    {
        $this->db->select('slug');
        $this->db->from('blog_term');
        $this->db->join('blog_term_description', 'blog_term_description.term_id = blog_term.term_id');
        $this->db->where('blog_term.term_type', 'category');
        $this->db->where('blog_term_description.slug', $slug);
        !$term_id || $this->db->where('blog_term_description.term_id !=', $term_id);

        $slug = $this->db->get()->result_array();

        if (count($slug) > 0) {
            return TRUE;
        }
    }

	public function delete_category($id)
	{
		// Get blog_id in blog_to_term by term_id
		$this->_table_name = 'blog_to_term';
		$where = array(
			'term_id' => $id
		);

		$query = $this->get_by($where, FALSE);

		// Get how many blog_id have term
		$results = array();
		foreach ($query as $key => $term) {
			$where = array(
				'blog_id'   => $term['blog_id'],
				'term_type' => 'category'
			);

			$results[] = $this->get_by($where, FALSE);
		}

		// Count how many blog_id have term
		$blogs = array();
		foreach ($results as  $key => $result) {
            if (count($result)) {
                foreach ($result as $p) {
                    $blogs[$key] = array(
						'blog_id'   => $p['blog_id'],
						'count' => count($result)
                    );
                }
            }
		}

		// Add default category to blog_id when blog_id only have one term
		foreach ($blogs as $value) {
			if ($value['count'] === 1) {
				$blog_tag = array(
					'blog_id'   => $value['blog_id'],
					'term_id'   => 1, // default category_id
					'term_type' => 'category'
				);

				$this->db->set($blog_tag);
				$this->db->insert('blog_to_term');
			}
		}

		// Delete by term_id
		$tables = array('blog_term', 'blog_term_description', 'blog_to_term');
		$this->db->where('term_id', $id);
		$this->db->delete($tables);
	}

}