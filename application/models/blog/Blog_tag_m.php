<?php
class Blog_tag_M extends MY_Model
{
	protected $_table_name = 'blog_term';
	protected $_order_by = 'term_id';
	public $rules = array();

	function __construct ()
	{
		parent::__construct();
	}

	public function get_new_tag()
	{
		$this->load->model('setting/language_m');
		$languages = $this->language_m->get();

		$result['tag_data'] = array(
			'term_id'    => '',
			'parent_id'  => '',
			'sort_order' => '',
			'status'     => ''
	    );

		$result['tag_desc'] = array(
			'term_id'     => '',
			'language_code' => '',
			'name'        => set_value('name'),
			'description' => set_value('description')
		);

		return $result;
	}

	public function get_tags($term_id = NULL, $lang_code = NULL)
	{
		if ($term_id) {
			$where = array(
				'term_id' => $term_id
			);

	        $result['tag_data'] = $this->get_by($where, TRUE);

	        if ($result['tag_data']) {
		        $this->_table_name = 'blog_term_description';
		        $query = $this->get_by($where, TRUE);

				$result['tag_desc'] = $query;

				return $result;
	        }
		} elseif($lang_code) {
	        $this->db->select('*');
	        $this->db->from('blog_term');
	        $this->db->join('blog_term_description', 'blog_term_description.term_id = blog_term.term_id');
	        $this->db->where(array('language_code' => $lang_code));
	        $this->db->where('term_type', 'tag');
	        $result = $this->db->get()->result_array();
	        return $result;
	    } else {
	        $this->db->from('blog_term');
	        $this->db->join('blog_term_description', 'blog_term_description.term_id = blog_term.term_id');
	        $this->db->where(array('language_code' => $this->data['language_code']));
	        $this->db->where('term_type', 'tag');
	        $result = $this->db->get()->result_array();
	        return $result;
	    }
	}

	public function save_tag($data, $id = NULL)
	{
		$this->_table_name = 'blog_term';

		if( isset($data['tag_data']) )
		{
			if( (int) $data['tag_data']['term_id'] > 0)
			{
				$this->db->set($data['tag_data']);
				$this->db->where('term_id', $id);
				$this->db->update($this->_table_name);
			}
			else
			{
				unset($data["tag_data"]['term_id']);

				$this->db->set($data['tag_data']);
				$this->db->insert($this->_table_name);
				$data['tag_data']['term_id'] = $this->db->insert_id();
			}
		}

		// tag_desc data
		if( isset($data['tag_desc']) )
		{
			$this->db->where('term_id', $data['tag_data']['term_id']);
			$this->db->delete('blog_term_description');

			$tag_desc = array(
				'term_id'       => $data['tag_data']['term_id'],
				'language_code' => $data['tag_desc']['language_code'],
				'name'          => $data['tag_desc']['name'],
				'slug'          => $this->unique_term_tag_slug(get_slug($data['tag_desc']['name']), $data['tag_data']['term_id']),
				'description'   => $data['tag_desc']['description']
			);

			$this->db->set($tag_desc);
			$this->db->insert('blog_term_description');
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

    public function unique_term_tag_slug($title = NULL, $term_id = NULL)
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
        $this->db->where('blog_term.term_type', 'tag');
        $this->db->where('blog_term_description.slug', $slug);
        !$term_id || $this->db->where('blog_term_description.term_id !=', $term_id);

        $slug = $this->db->get()->result_array();

        if (count($slug) > 0) {
            return TRUE;
        }
    }

	public function delete_tag($id)
	{
		// Delete by term_id
		$this->db->where('term_id', $id);
		$this->db->delete('blog_term');
		$this->db->where('term_id', $id);
		$this->db->delete('blog_term_description');
		$this->db->where('term_id', $id);
		$this->db->delete('blog_to_term');
	}
}