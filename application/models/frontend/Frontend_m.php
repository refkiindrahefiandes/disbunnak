<?php
class Frontend_M extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// Get Posts
	public function get_posts($params = array())
	{
		$this->db->from('blog');
		$this->db->join('blog_description', 'blog_description.blog_id = blog.blog_id');
		$this->db->where('language_code', $params['language_code']);
		$this->db->where('status', 1);

		if ($params['slug'] !== NULL) {
			$this->db->where('blog_description.slug', $params['slug']);
		}

		if ($params['blog_id'] !== NULL) {
			$this->db->where('blog.blog_id', $params['blog_id']);
		}

		if ($params['user_id'] !== NULL) {
			$this->db->where('md5(blog.user_id)', $params['user_id']);
		}

		if (isset($params['search_query'])) {
			$this->db->like(array('title' => $params['search_query'], 'content' => $params['search_query']));
		}

		if ($params['limit'] !== NULL) {
			$this->db->limit($params['limit'], 0);
		}

		if ($params['sort_order'] !== NULL) {
			$this->db->order_by('blog.blog_id', $params['sort_order']);
		}

		$results = $this->db->get('', $params['limit'], $params['offset'])->result_array();

		//Menambahkan galeri gambar
		$post_data = array();
		if (count($results)) {
			foreach ($results as $key => $val) {
				$post_data[$key] = $val;
				$post_data[$key]['galleries'] = $this->get_post_gallery($val['blog_id']);
			}
		}
		return $post_data;
	}

	public function get_post_gallery($blog_id = NULL)
	{
		// Blog image
		$this->_table_name = 'blog_image';
		$this->_order_by   = 'blog_image_id';
		$where = array(
			'blog_id' => $blog_id
		);

		return $this->get_by($where, FALSE);
	}

	// Get Posts by term
	public function get_posts_byterm($params = array())
	{
		$query = array();
		$results = array();
		if ($params['slug'] !== NULL && $params['slug_type'] !== NULL) {
			$this->db->from('blog_term');
			$this->db->join('blog_term_description', 'blog_term_description.term_id = blog_term.term_id');
			$this->db->where('blog_term.term_type', $params['slug_type']);
			$this->db->where('blog_term_description.slug', $params['slug']);

			$query = $this->db->get()->row_array();
		}


		if (!empty($query)) {
			$this->_table_name = 'blog_to_term';
			$this->_order_by   = 'blog_id DESC';
			$where = array(
				'term_id'   => $query['term_id'],
				'term_type' => $query['term_type']
			);

			$query = $this->get_by($where, FALSE);
		}


		if (!empty($query)) {
			foreach ($query as $blog) {
				$queries[] = query_posts(array('blog_id' => $blog['blog_id']));
			}

			if ($queries) {
				foreach ($queries as $key => $post) {
					if ($post) {
						foreach ($post as $key => $p) {
							$results[] = $p;
						}
					}
				}
			}

			$blogs_data = array_splice($results, $params['offset'], $params['limit']);
			return $blogs_data;
		}
		return false;
	}

	// Get Comments
	public function get_comments($params = array())
	{
		$this->_table_name = 'blog_comment';
		$this->_order_by   = '';

		$where = array(
			'blog_id' => $params['blog_id'],
			'status'  => 1
		);

		$results =  $this->get_by($where, FALSE);

		$store_all_id = array();
		foreach ($results as $comment_id) {
			array_push($store_all_id, $comment_id['parent_id']);
		}

		return  $this->in_parent_comments($params, 0, $params['blog_id'], $store_all_id);
	}

	public function in_parent_comments($params, $in_parent, $blog_id, $store_all_id)
	{
		$str = '';

		if (in_array($in_parent, $store_all_id)) {
			$this->_table_name = 'blog_comment';
			$this->_order_by   = '';

			$where = array(
				'blog_id'   => $blog_id,
				'parent_id' => $in_parent,
				'status'    => 1
			);

			$results =  $this->get_by($where, FALSE);

			foreach ($results as $comment) {
				$str .=  $in_parent == 0 ? "<" . $params['style'] . " class='media'>" : "<div class='media'>";
				$str .= "
	                <div class='media-left'><img alt='' src=" . get_gravatar(clean_output($comment['email']), $params['avatar_size']) . "></img></div>
                    <div class='media-body'>
                        <a href=mailto:" . clean_output($comment['email']) . "><h4>" . clean_output($comment['user']) . "</h4></a>
                        " . clean_output($comment['comment']) . "
                        <div class='date_rep'>
                            <a>" . $comment['created'] . "</a>
                            <a id='" . $comment['comment_id'] . "' class='reply' href='#respond'>Reply</a>
                        </div>
                    </div>
                ";
				$str .= $this->in_parent_comments($params, $comment['comment_id'], $blog_id, $store_all_id);
				$str .= "</" . $params['style'] . ">";
			}
		}

		return $str;
	}

	// Get terms
	public function get_terms($params = array())
	{
		$this->db->select('*');
		$this->db->from('blog_term');
		$this->db->join('blog_term_description', 'blog_term_description.term_id = blog_term.term_id');
		$this->db->where('language_code', $this->data['language_code']);
		$this->db->where('status', 1);

		if (!empty($params)) {
			foreach ($params as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		return $this->db->get()->result_array();
	}

	// Get terms info
	public function get_terms_info($params = array())
	{
		$this->_table_name = 'blog_to_term';
		$this->_order_by   = '';

		$where = array(
			'blog_id'   => $params['blog_id'],
			'term_type' => $params['term_type']
		);

		$results = $this->get_by($where, FALSE);

		$terms_info = array();
		if (count($results)) {
			foreach ($results as $result) {
				$terms_data[] = $this->get_terms(array('blog_term.term_id' => $result['term_id']));
			}

			foreach ($terms_data as $key => $result) {
				if (count($result)) {
					foreach ($result as $key => $p) {
						$terms_info[] = $p;
					}
				}
			}

			return $terms_info;
		}
	}

	// Get user info
	public function get_user_info($user_id = NULL)
	{
		if ($user_id !== NULL) {
			$this->_table_name = 'users';
			$this->_order_by   = '';

			$where = array(
				'md5(user_id)' => $user_id
			);

			$result = $this->get_by($where, TRUE);

			$user_info = array();
			if (count($result)) {
				$setting = $this->setting_m->get_setting($result['username']);

				$user_info = array(
					'user_id'     => $result['user_id'],
					'firstname'   => $result['firstname'],
					'lastname'    => $result['lastname'],
					'email'       => $result['email'],
					'description' => $setting['description'],
					'social'      => isset($setting['social']) ? $setting['social'] : NULL
				);
			}

			return $user_info;
		}
	}

	// Get pages
	public function get_pages($params = array())
	{
		$this->db->from('page');
		$this->db->join('page_description', 'page_description.page_id = page.page_id');
		$this->db->where('language_code', $this->data['language_code']);

		if (count($params)) {
			foreach ($params as $key => $value) {
				$this->db->where('page_description.' . $key, $value);
			}
		}

		$this->db->where('status', 1);
		$results = $this->db->get()->result_array();

		//Menambahkan galeri gambar
		$page_data = array();
		if (count($results)) {
			foreach ($results as $key => $val) {
				$page_data[$key] = $val;
				$page_data[$key]['galleries'] = $this->get_page_gallery($val['page_id']);
			}
		}
		return $page_data;
	}

	public function get_page_gallery($page_id = NULL)
	{
		// Blog image
		$this->_table_name = 'page_image';
		$this->_order_by   = 'page_image_id';
		$where = array(
			'page_id' => $page_id
		);

		return $this->get_by($where, FALSE);
	}

	// Get agenda
	public function get_agendas($params = array())
	{
		$this->db->from('agenda');
		$this->db->join('agenda_description', 'agenda_description.agenda_id = agenda.agenda_id');
		$this->db->where('language_code', $this->data['language_code']);
		$this->db->where('status', 1);

		if ($params['limit'] !== NULL) {
			$this->db->limit($params['limit'], 0);
		}

		if ($params['slug'] !== NULL) {
			$this->db->where('agenda_description.slug', $params['slug']);
		}

		if ($params['sort_order'] !== NULL) {
			$this->db->order_by('agenda.agenda_id', $params['sort_order']);
		}

		$results = $this->db->get('', $params['limit'], $params['offset'])->result_array();
		return $results;
	}

	// Get front_menus
	public function get_front_menus($name = NULL, $params = array())
	{
		$this->_table_name = 'menu';
		$this->_order_by   = '';
		$where = array(
			'name'   => trim($name)
		);

		$menu_result = $this->get_by($where, TRUE);

		if ($menu_result) {
			$this->db->from('menu_item');
			$this->db->join('menu_item_description', 'menu_item_description.menu_item_id = menu_item.menu_item_id');
			$this->db->where('language_code', $this->data['language_code']);
			$this->db->where('menu_id', $menu_result['menu_id']);
			$this->db->order_by('sort_order');
			$menu_items = $this->db->get()->result_array();

			$store_all_id = array();
			foreach ($menu_items as $menu_item) {
				array_push($store_all_id, $menu_item['menu_item_parent']);
			}

			return $this->_in_parent_items($params, 0, $menu_result['menu_id'], $store_all_id);
		}

		return false;
	}

	public function _in_parent_items($params, $in_parent, $menu_id, $store_all_id)
	{
		if (in_array($in_parent, $store_all_id)) {
			$this->db->from('menu_item');
			$this->db->join('menu_item_description', 'menu_item_description.menu_item_id = menu_item.menu_item_id');
			$this->db->where('language_code', $this->data['language_code']);
			$this->db->where('menu_id', $menu_id);
			$this->db->where('menu_item_parent', $in_parent);
			$this->db->order_by('sort_order');
			$results = $this->db->get()->result_array();

			$str = '';
			$str .= $in_parent == 0 ? '<ul class="' . $params['ul_class'] . '">' : '<ul class="' . $params['sub_ul_class'] . '">';
			foreach ($results as $item) {
				$has_children = $this->_has_children($item['menu_item_id']);

				$str .= $has_children === TRUE ? '<li class="' . $params['li_class'] . '"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="' . $item['url'] . '">' . $item['name'] . ' <i class="fa fa-angle-down"></i></a>' : '<li class="' . $params['li_class'] . '"><a href="' . $item['url'] . '">' . $item['name'] . '</a>';
				$str .= $this->_in_parent_items($params, $item['menu_item_id'], $menu_id, $store_all_id);
				$str .= '</li>';
			}
			$str .= '</ul>';

			return $str;
		}
	}

	public function _has_children($menu_item_id)
	{
		$this->_table_name = 'menu_item';
		$where = array(
			'menu_item_parent' => $menu_item_id
		);
		$results = $this->get_by($where, FALSE);

		if ($results) {
			return TRUE;
		}

		return false;
	}

	// Get front_widgets
	public function get_front_widgets($name = NULL)
	{
		$this->_table_name = 'widget';
		$this->_order_by   = '';

		$where = array(
			'name' => $name
		);

		$widget_result = $this->get_by($where, TRUE);

		$item_data = array();
		if ($widget_result) {
			$this->_table_name = 'widget_item';
			$this->_order_by   = 'sort_order';

			$where = array(
				'widget_id' => $widget_result['widget_id']
			);

			$results = $this->get_by($where, FALSE);

			if ($results) {
				foreach ($results as $result) {
					$item_data[] = array(
						'widget_item_id' => $result['widget_item_id'],
						'widget_type'    => $result['widget_type'],
						'widget_value'   => unserialize($result['value'])
					);
				}
			}
		}

		return $item_data;
	}

	// Get plugin
	public function get_plugin($plugin_name = NULL)
	{
		if ($plugin_name) {
			$explode = explode('_', $plugin_name);
			$plugin = $explode[0] . '_' . $explode[1];

			$this->db->from('plugin');
			$this->db->where('name', $plugin);
			$result = $this->db->get()->row_array();

			if ($result) {
				return $result;
			}
		} else {
			$this->db->from('plugin');
			$results = $this->db->get()->result_array();

			if ($results) {
				return $results;
			}
		}
	}

	// get_active_language
	public function get_active_language()
	{
		$this->_table_name = 'language';
		$where = array(
			'status' => 1
		);

		return $this->get_by($where, FALSE);
	}

	public function get_language_by_code($language_code = NULL)
	{
		$this->_table_name = 'language';
		$where = array(
			'language_code' => $language_code
		);

		return $this->get_by($where, TRUE);
	}

	// Get meta_title
	public function get_header_meta($params = array())
	{
		$this->db->from($params['table_name']);
		$this->db->where($params['primary_key'], $params['id']);
		$this->db->order_by($params['select'] . ' ASC');
		$query = $this->db->get()->result_array();

		if ($query) {
			foreach ($query as $post) {
				$results[$post['language_code']] = $post;
			}

			return $results;
		}
	}

	public function get_id_byslug($params)
	{
		$this->_table_name = $params['table'];
		$where = array(
			'slug'  => $params['slug']
		);

		return $this->get_by($where, TRUE);
	}

	// Save download hit
	public function save_download_hit($download_id = NULL)
	{
		if ($download_id) {
			$this->db->query(
				"UPDATE download SET hits=hits+1 WHERE download_id='$download_id'"
			);

			$result = $this->db->query("SELECT * FROM download WHERE download_id='$download_id'")->row_array();

			return $result;
		}
		return false;
	}

	public function get_pelayanan_nested($table_name = NULL, $children_table_name = NULL, $table_id = NULL)
	{
		$parents = $this->get_parent_categories($table_name);
		$data = array();

		if ($parents) {
			foreach ($parents as $parent) {
				$children_data = array();

				$childrens = $this->get_children($parent['bidang_id'], $children_table_name);

				if ($childrens) {
					foreach ($childrens as $child) {
						$children_data[] = array(
							$table_id 	   => $child[$table_id],
							'bidang_id'    => $child['bidang_id'],
							'name'         => $child['name'],
							'slug'         => $child['slug'],
							'sort_order'   => $child['sort_order'],
							'status'       => $child['status'],
							'date_added'   => $child['date_added'],
							'url'          => site_url($children_table_name . '/' . $child['slug'])
						);
					}
				}

				$data[] = array(
					'bidang_id' => $parent['bidang_id'],
					'name'        => $parent['name'],
					'slug'        => $parent['slug'],
					'parent_id'   => $parent['parent_id'],
					'sort_order'  => $parent['sort_order'],
					'children'    => $children_data
				);
			}
		}

		return $data;
	}

	// Pelayanan Categories and child
	public function get_parent_categories($table_name = NULL)
	{
		$this->db->select('*');
		$this->db->from($table_name);
		$this->db->where('parent_id', '0');
		$this->db->where('status', 1);
		$result = $this->db->get()->result_array();

		if ($result) {
			return $result;
		}

		return false;
	}

	public function get_children($id = NULL, $children_table_name = NULL)
	{
		$this->db->select('*');
		$this->db->from($children_table_name);
		$this->db->where('bidang_id', $id);
		$this->db->where('status', 1);
		$result = $this->db->get()->result_array();

		if ($result) {
			return $result;
		}

		return false;
	}

	// Pelayanan
	public function get_data($id = NULL, $table_name = NULL, $table_id = NULL)
	{
		if ($id && $table_id) {
			$this->db->select('*');
			$this->db->from($table_name);
			$this->db->where($table_id, $id);
			$result = $this->db->get()->row_array();
			return $result;
		} else {
			$this->db->select('*');
			$this->db->from($table_name);
			$this->db->where('status', 1);
			$this->db->order_by('sort_order', 'asc');
			$result = $this->db->get()->result_array();

			return $result;
		}

		return false;
	}


	public function get_pengaduan($params = array())
	{
		$data_pengaduan = array();
		$this->db->select('*');
		$this->db->from('pengaduan');
		// $this->db->where('status',2); 
		$this->db->where('is_public', 1);
		$query1 = $this->db->get()->result_array();
		if ($query1) {
			foreach ($query1 as $notif) {
				$data_pengaduan[] = array(
					'id'      	=> md5($notif['pengaduan_id']),
					'content'    => $notif['content'],
					'url'        => base_url('detail/pengaduan/'),
				);
			}
		}


		$data_konsultasi = array();
		$this->db->select('*');
		$this->db->from('konsultasi');
		// $this->db->where('status',2); 
		$this->db->where('is_public', 1);
		$query = $this->db->get()->result_array();

		if ($query) {
			foreach ($query as $notif) {
				$data_konsultasi[] = array(
					'id'      	 => md5($notif['konsul_id']),
					'content'    => $notif['content'],
					'url'        => base_url('detail/konsultasi/'),
				);
			}
		}

		$results = array_merge($data_pengaduan, $data_konsultasi);

		return $results;
	}

	public function get_detail_layanan($params = array())
	{
		switch ($params['parameter']) {
			case 'pengaduan':
				$this->db->select('*');
				$this->db->from('pengaduan a');
				$this->db->join('pengaduan_reply b', 'b.pengaduan_id = a.pengaduan_id', 'left');
				$this->db->where('md5(a.pengaduan_id)', $params['slug']);
				// $this->db->where('a.status',2); 
				$this->db->where('a.is_public', 1);
				$results = $this->db->get()->result_array();
				return $results;
				break;

			case 'konsultasi':
				$this->db->select('*');
				$this->db->from('konsultasi a');
				$this->db->join('konsultasi_reply b', 'b.konsul_id = a.konsul_id', 'left');
				$this->db->where('md5(a.konsul_id)', $params['slug']);
				// $this->db->where('a.status',2); 
				$this->db->where('a.is_public', 1);
				$results = $this->db->get()->result_array();
				return $results;
				break;

			default:
				# code...
				break;
		}
	}

	public function get_services($params = array())
	{
		$this->db->where('status', 1);
		if ($params['limit'] !== NULL) {
			$this->db->limit($params['limit'], 0);
		}

		if ($params['slug'] !== NULL) {
			$this->db->where('layanan.slug', $params['slug']);
		}

		if ($params['sort_order'] !== NULL) {
			$this->db->order_by('layanan.sort_order', $params['sort_order']);
		}

		$results = $this->db->get('layanan', $params['limit'], $params['offset'])->result_array();
		return $results;
	}
}
