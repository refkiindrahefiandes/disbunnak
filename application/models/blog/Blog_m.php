<?php
class Blog_M extends MY_Model
{
	protected $_table_name = 'blog';
	protected $_order_by   = '';
	public $rules          = array();

	function __construct()
	{
		parent::__construct();
	}

	public function get_new_blog()
	{
		$this->load->model('setting/language_m');
		$languages = $this->language_m->get();

		$result['blog_data'] = array(
			'blog_id'        => '',
			'term_id'        => '',
			'created'        => '',
			'status'         => '1',
			'comment_status' => '1',
			'user_id'        => '',
			'hits'           => '',
			'image'          => '',
			'video'          => '',
			'image_path'     => base_url('uploads/images/default/default-thumbnail.png'),
			'date_modified'  => '',
			'date_published' => '',
			'code'           => ''
		);

		$query = array();
		foreach ($languages as $language) {
			$blog_desc[$language['language_code']] = array(
				'blog_id' => '',
				'title'   => set_value('title'),
				'content' => set_value('content'),
				'tag'     => array()
			);
		}

		$result['blog_desc']     = $blog_desc;
		$result['category_data'] = array();
		$result['blog_image']    = array();
		return $result;
	}

	public function get_posts($id = NULL)
	{
		$language_code  = $this->data['language_code'];

		$this->_table_name = 'blog';
		$this->_order_by   = 'blog_id';
		$where = array(
			'blog_id' => $id
		);

		$result['blog_data'] = $this->get_by($where, TRUE);

		if ($result) {
			// Get blog data
			if ($result['blog_data']) {
				// Get blog desc
				$this->_table_name = 'blog_description';
				$query = $this->get_by($where, FALSE);

				$languages = array();
				foreach ($query as $language) {
					$languages[$language['language_code']] = $language;
					$languages[$language['language_code']]['tag'] = array();
				}
				$result['blog_desc'] = $languages;

				// Get categories data
				$this->_table_name = 'blog_to_term';
				$where = array(
					'blog_id' => $id,
					'term_type' => 'category'
				);

				$result['category_data'] = $this->get_by($where, FALSE);

				// Get tags data
				$this->_table_name = 'blog_to_term';
				$where = array(
					'blog_id' => $id,
					'term_type' => 'tag'
				);

				$query = $this->get_by($where, FALSE);

				$tag_results = array();
				foreach ($query as $key => $tag) {
					$this->db->from('blog_term');
					$this->db->join('blog_term_description', 'blog_term_description.term_id = blog_term.term_id');
					$this->db->where('blog_term.term_id', $tag['term_id']);
					$tag_results[] = $this->db->get()->row_array();
				}

				if (count($tag_results)) {
					foreach ($result['blog_desc'] as $key => $value) {
						$tag_data[$key] = search_array($key, $tag_results, 'language_code');
					}

					foreach ($tag_data as $key => $tags) {
						foreach ($tags as $tag) {
							$result['blog_desc'][$key]['tag'][] = $tag['name'];
						}
					}
				}

				// Blog image
				$this->_table_name = 'blog_image';
				$this->_order_by   = 'blog_image_id';
				$where = array(
					'blog_id' => $id
				);

				$images_result = $this->get_by($where, FALSE);

				$result['blog_image'] = array();
				if ($images_result) {
					$result['blog_image'] = $images_result;
				}

				return $result;
			}
		} else {
			$results = $this->get();
			foreach ($results as $key => $blog) {
				$result[$key]['blog_data'] = $blog;

				$this->_table_name = 'blog_description';
				$where = array(
					'blog_id' => $blog['blog_id']
				);
				$query = $this->get_by($where, FALSE);
				$languages = array();
				foreach ($query as $language) {
					$languages[$language['language_code']] = $language;
					$languages[$language['language_code']]['tag'] = array();
				}
				$result[$key]['blog_desc'] = $languages;
			}

			return $result;
		}
		return FALSE;
	}

	public function save_post($data, $id = NULL)
	{
		$this->_table_name = 'blog';
		$languages = $this->language_m->get_active();

		// Blog data
		if (isset($data['blog_data'])) {
			if ((int) $data['blog_data']['blog_id'] > 0) {
				$blog_data = array();

				$blog_data = $data['blog_data'];
				$this->db->set($blog_data);
				$this->db->where('blog_id', $id);
				$this->db->update($this->_table_name);
			} else {
				unset($data["blog_data"]['blog_id']);
				$blog_data = array();

				$blog_data = $data['blog_data'];
				$this->db->set($blog_data);
				$this->db->insert($this->_table_name);
				$data['blog_data']['blog_id'] = $this->db->insert_id();
			}
		}

		// Blog_desc data
		if (isset($data['blog_desc'])) {
			$this->db->where('blog_id', $data['blog_data']['blog_id']);
			$this->db->delete('blog_description');

			foreach ($languages as $language) {
				$blog_desc = array(
					'blog_id'       => $data['blog_data']['blog_id'],
					'language_code' => $language['language_code'],
					'title'         => $data['blog_desc'][$language['language_code']]['title'],
					'slug'          => $this->unique_blog_slug(get_slug($data['blog_desc'][$language['language_code']]['title']), $data['blog_data']['blog_id']),
					'content'       => $data['blog_desc'][$language['language_code']]['content']
				);

				$this->db->set($blog_desc);
				$this->db->insert('blog_description');
			}
		}

		// Category blog_to_term data
		if (isset($data['category_data'])) {
			$this->db->where('blog_id', $data['blog_data']['blog_id']);
			$this->db->delete('blog_to_term');

			foreach ($data['category_data'] as $category_id) {
				$blog_category = array(
					'blog_id'   => $data['blog_data']['blog_id'],
					'term_id'   => (int) $category_id,
					'term_type' => 'category'
				);

				$this->db->set($blog_category);
				$this->db->insert('blog_to_term');
			}
		}

		// Blog desc data - tag data
		if (isset($data['blog_desc'])) {
			$blog_tags = array();
			foreach ($languages as $language) {
				$tags_decode = json_decode($data['blog_desc'][$language['language_code']]['tag']);
				if (count($tags_decode)) {
					foreach ($tags_decode as $tag) {
						// Get term
						$this->db->from('blog_term');
						$this->db->join('blog_term_description', 'blog_term_description.term_id = blog_term.term_id');
						$this->db->where('blog_term.term_type', 'tag');
						$this->db->where('blog_term_description.slug', get_slug($tag));

						$query = $this->db->get()->row_array();

						$blog_tags[] = array(
							'tag_data' => array(
								'term_id'    => $query['term_id'],
								'sort_order' => '',
								'status'     => '1',
								'term_type'  => 'tag'
							),
							'tag_desc' => array(
								$language['language_code'] => array(
									'name'   => $tag,
									'slug'   => get_slug($tag)
								)
							)
						);
					}
					foreach ($blog_tags as $key => $value) {
						if ($value['tag_data']['term_id'] == '') {

							if (isset($value['tag_data'])) {
								$this->db->set($value['tag_data']);
								$this->db->insert('blog_term');
								$blog_tags[$key]['tag_data']['term_id'] = $this->db->insert_id();
							}

							if (isset($value['tag_data'])) {
								$tag_desc = array(
									'term_id'       => $blog_tags[$key]['tag_data']['term_id'],
									'language_code' => $language['language_code'],
									'name'          => $value['tag_desc'][$language['language_code']]['name'],
									'slug'          => $value['tag_desc'][$language['language_code']]['slug']
								);

								$this->db->set($tag_desc);
								$this->db->insert('blog_term_description');
							}
						}
					}
				}
			}

			if (count($blog_tags)) {
				foreach ($blog_tags as $key => $tag) {
					$blog_tag = array(
						'blog_id'     => $data['blog_data']['blog_id'],
						'term_id'     => (int) $tag['tag_data']['term_id'],
						'term_type'   => 'tag'
					);

					$this->db->where('blog_id', $blog_tag['blog_id']);
					$this->db->where('term_id', $blog_tag['term_id']);
					$this->db->where('term_type', $blog_tag['term_type']);
					$this->db->delete('blog_to_term');

					$this->db->set($blog_tag);
					$this->db->insert('blog_to_term');
				}
			}
		}

		if (isset($data['post_image'])) {
			if (count($data['post_image'])) {
				// Delete all image by blog_id
				$this->db->where('blog_id', $data['blog_data']['blog_id']);
				$this->db->delete('blog_image');

				foreach ($data['post_image'] as $image) {
					$image['status'] = isset($image['status']) ? $image['status'] : 0;
					$image['blog_id'] = $data['blog_data']['blog_id'];

					// Insert
					$this->db->set($image);
					$this->db->insert('blog_image');
				}
			}
		}
	}

	public function get_category_info($blog_id = NULL)
	{
		if ($blog_id) {
			$language_code  = $this->data['language_code'];
			$this->db->from('blog_to_term');
			$this->db->where('blog_id', $blog_id);
			$this->db->where('term_type', 'category');
			$results = $this->db->get()->result_array();

			$term_data = array();
			foreach ($results as $result) {
				$this->db->from('blog_term');
				$this->db->join('blog_term_description', 'blog_term_description.term_id = blog_term.term_id');
				$this->db->where('language_code', $language_code);
				$this->db->where('blog_term.status', 1);
				$this->db->where('blog_term.term_id', $result['term_id']);
				$term_data[] = $this->db->get()->row_array();
			}

			return $term_data;
		}
	}

	public function update_status($id, $status)
	{
		$data['status'] = $status;

		$this->db->set($data);
		$this->db->where('blog_id', $id);
		$this->db->update($this->_table_name);

		return TRUE;
	}

	public function unique_blog_slug($title = NULL, $blog_id = NULL)
	{
		$slug = $title;
		$i = 1;
		while ($this->check_slug($slug, $blog_id)) {
			$slug = $title . '-' . $i++;
		}
		return $slug;
	}

	public function check_slug($slug, $blog_id)
	{
		$this->db->select('slug');
		$this->db->from('blog_description');
		$this->db->where('slug', $slug);
		!$blog_id || $this->db->where('blog_id !=', $blog_id);
		$slug = $this->db->get()->result_array();

		if (count($slug) > 0) {
			return TRUE;
		}
	}

	public function get_posts_sitemap($language_code = NULL)
	{
		$this->db->select('blog_id');
		$this->db->from('blog');
		$this->db->order_by('blog_id ASC');
		$result_posts = $this->db->get()->result_array();

		foreach ($result_posts as $result_post) {
			$params = array(
				'table_name'    => 'blog_description',
				'primary_key'   => 'blog_id',
				'id'            => $result_post['blog_id']
			);
			$result_descs[] = $this->get_slugs($params);
		}

		$results = array();
		foreach ($result_descs as $key => $value) {
			if (isset($value[$language_code])) {
				$results[$key]['main_url'] = site_url('blog/' . $value[$language_code]['slug']);
				$results[$key]['alt_url'] = $value;
			}
		}
		return $results;
	}

	public function delete_blog($id)
	{
		$this->db->where('blog_id', $id);
		$this->db->delete('blog');
		$this->db->where('blog_id', $id);
		$this->db->delete('blog_description');
		$this->db->where('blog_id', $id);
		$this->db->delete('blog_to_term');
		$this->db->where('blog_id', $id);
		$this->db->delete('blog_comment');
	}
}
