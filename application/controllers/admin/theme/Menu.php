<?php
class Menu extends Admin_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog/blog_category_m');
		$this->load->model('download/download_category_m');
		$this->load->model('page/page_m');
		$this->load->model('theme/menu_m');
		$this->data['languages'] = $this->language_m->get_active();
	}

	public function index($id = NULL)
	{
		$language_code = $this->data['language_code'];
		// Fetch data pages
		$result_pages = $this->page_m->get_pages();
		$pages = [];
		if ($result_pages) {
			foreach ($result_pages as $page) {
				$pages[] = array(
					'page_id' => $page['page_data']['page_id'],
					'title'   => $page['page_desc'][$language_code]['title'],
					'url'     => site_url('page/' . $page['page_desc'][$this->data['language_code']]['slug']),
				);
			}
		}
		$this->data['pages'] = $pages;

		// Fetch data blog categories
		$result_blog_categories = $this->blog_category_m->get_categories();
		$blog_categories = [];
		if ($result_blog_categories) {
			foreach ($result_blog_categories as $blog_category) {
				$blog_categories[] = array(
					'term_id' => $blog_category['term_data']['term_id'],
					'name'    => $blog_category['term_desc'][$language_code]['name'],
					'url'     => base_url('blog/category/' . $blog_category['term_desc'][$language_code]['slug']),
				);
			}
		}
		$this->data['blog_categories'] = $blog_categories;

		// Fetch data download categories
		$result_download_categories = $this->download_category_m->get();
		$download_categories = [];
		if ($result_download_categories) {
			foreach ($result_download_categories as $download_category) {
				$download_categories[] = array(
					'download_category_id' => $download_category['download_category_id'],
					'name'                 => $download_category['name'],
					'url'                  => site_url($language_code . '/download/' . $download_category['slug']),
				);
			}
		}
		$this->data['download_categories'] = $download_categories;

		// Fetch data menus
		$this->data['menus'] = $this->menu_m->get_menu();

		// Set up the form
		$rules = $this->menu_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE && $this->validate_modify('theme/Menu')) {
			$this->menu_m->save_menu($this->input->post('add-menu'), $id);
			redirect('admin/theme/menu');
		}

		// Load view
		if ($this->user_m->hasPermission('access', 'theme/Menu')) {
			$this->data['subview'] = 'admin/theme/menu';
		} else {
			$this->session->set_flashdata('error', lang('error_permission'));
			$this->data['subview'] = 'admin/common/error';
		}

		$this->load->view('admin/_layout_main', $this->data);
	}

	public function ajax_add_item($type = NULL, $menu_id)
	{
		if ($this->user_m->hasPermission('modify', 'theme/Menu')) {
			$data_results = array();
			if ($type === 'page' && count($this->input->post('menu-item'))) {
				foreach ($this->input->post('menu-item') as $key_menu => $item) {
					$menu_item = $this->page_m->get_pages($item);
					if ($menu_item) {
						$data_results[$key_menu]['menu_data'] = array(
							'menu_id' => $menu_id,
							'type'    => $type,
						);

						foreach ($menu_item['page_desc'] as $key => $item) {
							$data_results[$key_menu]['menu_desc'][$key] = array(
								'language_code' => $item['language_code'],
								'name'          => $item['title'],
								'slug'          => $item['slug'],
								'url'           => site_url($item['language_code'] . '/' . 'page/' . $item['slug'])
							);
						}
					}
				}
			}

			if ($type === 'link' && count($this->input->post())) {
				$menu_data = array(
					'menu_id' => $menu_id,
					'type'    => $type,
				);

				foreach ($this->data['languages'] as $key => $language) {
					$data = $this->input->post();
					$menu_desc[$key] = array(
						'language_code' => $language['language_code'],
						'name'          => $data['menu_text'][$language['language_code']],
						'slug'          => get_slug($data['menu_text'][$language['language_code']]),
						'url'           => $data['menu_url'][$language['language_code']]
					);
				}

				$data_results[] = array(
					'menu_data' => $menu_data,
					'menu_desc' => $menu_desc
				);
			}

			if ($type === 'blog-category' && count($this->input->post('menu-item'))) {
				foreach ($this->input->post('menu-item') as $key_menu => $item) {
					$menu_item = $this->blog_category_m->get_categories($item);
					if ($menu_item) {
						$data_results[$key_menu]['menu_data'] = array(
							'menu_id' => $menu_id,
							'type'    => $type,
						);

						foreach ($menu_item['category_desc'] as $key => $item) {
							$data_results[$key_menu]['menu_desc'][$key] = array(
								'language_code' => $item['language_code'],
								'name'          => $item['name'],
								'slug'          => $item['slug'],
								'url'           => site_url($item['language_code'] . '/blog/category/' . $item['slug'])
							);
						}
					}
				}
			}

			if ($type === 'download-category' && count($this->input->post('menu-item'))) {
				foreach ($this->input->post('menu-item') as $key_menu => $item) {
					$menu_item = $this->download_category_m->get_by(array('download_category_id' => $item), FALSE);

					if ($menu_item) {
						$data_results[$key_menu]['menu_data'] = array(
							'menu_id' => $menu_id,
							'type'    => $type,
						);

						foreach ($menu_item as $key => $item) {
							$data_results[$key_menu]['menu_desc'][$key] = array(
								'language_code' => $this->data['language_code'],
								'name'          => $item['name'],
								'slug'          => $item['slug'],
								'url'           => site_url($this->data['language_code'] . '/download/' . $item['slug'])
							);
						}
					}
				}
			}

			if (count($data_results)) {
				foreach ($data_results as $result) {
					$this->menu_m->save_menu_item($result);
				}

				$json['success'] = TRUE;
				$this->output->set_output(json_encode($json));
			}
		} else {
			$json['error'] = lang('error_permission');
			$this->output->set_output(json_encode($json));
		}
	}

	public function ajax_get_item($menu_id = NULL)
	{
		$menu_items   = $this->menu_m->get_menu_items($menu_id);
		$store_all_id = array();

		if ($menu_items) {
			foreach ($menu_items as $menu_item) {
				array_push($store_all_id, $menu_item['menu_item_parent']);
			}
		}

		$json['data'] = $this->in_parent_items(0, $menu_id, $store_all_id);
		$this->output->set_output(json_encode($json));
	}

	public function in_parent_items($in_parent, $menu_id, $store_all_id)
	{
		$str = '';
		if (in_array($in_parent, $store_all_id)) {
			$results = $this->menu_m->get_item_byparent($menu_id, $in_parent);

			$str .= $in_parent == 0 ? '<ol class="sortable list-unstyled">' : '<ol>';
			if ($results) {
				foreach ($results as $item) {
					$str .= '<li id="list_' . $item['menu_item_id'] . '" class="drag-item">';
					$str .= 	'<div class="card card-line card-sm" style="margin-bottom: 5px;">';
					$str .= 		'<div class="card-header" style="cursor: pointer;">';
					$str .= 			'<div class="card-header-title">' . $item['name'] . '</div>';
					$str .= 			'<div class="tools">';
					$str .= 				'<div class="btn-group">';
					$str .= 					'<a class="btn btn-default btn-icon-toggle remove-item" data-toggle="tooltip" title="Delete Item" data-item="' . $item['menu_item_id'] . '"><i class="icon ion-trash-a"></i></a>';
					$str .= 					'<a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>';
					$str .= 				'</div>';
					$str .= 			'</div>';
					$str .= 		'</div>';
					$str .= 		'<div class="card-body" style="display: none;">';
					$str .= 			'<div class="form-group">';
					$str .= 				'<input type="text" class="form-control" id="url" name="url" value="' . $item['url'] . '" disabled>';
					$str .= 				'<label for="url">URL</label>';
					$str .= 			'</div>';
					$str .= 			'<div class="form-group">';
					$str .= 				'<input type="text" class="form-control" id="name" name="name" value="' . $item['name'] . '" disabled>';
					$str .= 				'<label for="name">Link Text</label>';
					$str .= 			'</div>';
					$str .= 		'</div>';
					$str .= 	'</div>';

					if (isset($item['children']) && count($item['children'])) {
						$str .= $this->get_item($item['children'], TRUE);
					}

					$str .= $this->in_parent_items($item['menu_item_id'], $menu_id, $store_all_id);

					$str .= '</li>';
				}
			}

			$str .= '</ol>';

			return $str;
		}
	}

	public function save_order_ajax()
	{
		if ($this->input->post('sortable') && $this->user_m->hasPermission('modify', 'theme/Menu')) {
			$data = $this->input->post('sortable');

			foreach ($data as $key => $value) {
				$data[$key] = array(
					'item_id'   => $value['item_id'],
					'parent_id' => $value['parent_id'],
					'depth'     => $value['depth'],
					'left'      => $value['left'],
					'right'     => $value['right']
				);
			}

			if ($this->menu_m->save_item($data)) {
				$json['success'] = "Urutan menu telah disimpan!";
				$this->output->set_output(json_encode($json));
			}
		} else {
			$json['error'] = lang('error_permission');
			$this->output->set_output(json_encode($json));
		}
	}

	public function ajax_delete_menu()
	{
		if ($this->input->post('menu_to_remove') && $this->user_m->hasPermission('modify', 'theme/Menu')) {
			$id = $this->input->post('menu_to_remove');
			if ($this->menu_m->delete_menu($id)) {
				$json['success'] = TRUE;
				$this->output->set_output(json_encode($json));
			}
		} else {
			$json['error'] = lang('error_permission');
			$this->output->set_output(json_encode($json));
		}
	}

	public function ajax_delete_item()
	{
		if ($this->input->post('item_to_remove') && $this->user_m->hasPermission('modify', 'theme/Menu')) {
			$id = $this->input->post('item_to_remove');
			if ($this->menu_m->delete_item($id)) {
				$json['success'] = TRUE;
				$this->output->set_output(json_encode($json));
			}
		} else {
			$json['error'] = lang('error_permission');
			$this->output->set_output(json_encode($json));
		}
	}
}
