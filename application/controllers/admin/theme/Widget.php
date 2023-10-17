<?php
class Widget extends Admin_controller
{

	public function __construct ()
	{
		parent::__construct();
		$this->load->model('blog/blog_category_m');
		$this->load->model('page/page_m');
		$this->load->model('theme/widget_m');
	}

    public function index($id = NULL)
    {
		// Fetch data widgets
		$this->data['widgets'] = $this->widget_m->get_widget();
		$this->data['widgets_item'] = $this->setting_m->search_setting('_plugin_widget');

		// Set up the form
		$rules = $this->widget_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE && $this->validate_modify('theme/Widget')) {
			$this->widget_m->save_widget($this->input->post('add-widget'), $id);
			redirect('admin/theme/widget');
		}

		// Load view
        if ($this->user_m->hasPermission('access', 'theme/Widget')) {
            $this->data['subview'] = 'admin/theme/widget';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function ajax_add_item($type = NULL, $widget_id)
    {
    	// Save data
    	if ($this->input->method(TRUE) == 'POST' && $this->user_m->hasPermission('modify', 'theme/Widget')) {
			$data_widget = array(
				'widget_id'   => $widget_id,
				'widget_type' => $type,
				'sort_order'  => '',
				'value'       => serialize(elements(array('widget_title', 'widget_data'), $this->input->post()))
			);

    		if ($this->widget_m->save_widget_item($data_widget)) {
                $json['success'] = TRUE;
                $this->output->set_output(json_encode($json));
    		}
    	} else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
    	}
    }

    public function ajax_get_item($widget_id = NULL)
    {
		$json['data'] = NULL;
		$widgets_item = $this->widget_m->get_widget_item(array('widget_id' => $widget_id));
		if ($widgets_item) {
	    	$json['data'] =  $this->get_item($widgets_item, $widget_id);
		}
		$this->output->set_output(json_encode($json));
    }

    public function get_item($data, $widget_id)
    {
		$str = '';

		if (count($data)) {
			$str .= '<ol class="sortable list-unstyled">';
			foreach ($data as $key => $item) {
				$widgets_item = $this->setting_m->get_setting($item['widget_type']);
				if ($item['widget_id'] === $widget_id) {
		    		$str .= '<li id="list_' . $item['widget_item_id'] .'" class="drag-item">';
		    		$str .= 	'<div class="card card-line card-sm" style="margin-bottom: 5px;">';
		    		$str .= 		'<div class="card-header" style="cursor: pointer;">';
		    		$str .= 			'<div class="card-header-title">' . $widgets_item['widget_name'] . '</div>';
		    		$str .= 			'<div class="tools">';
		    		$str .= 				'<div class="btn-group">';
		    		$str .= 					'<a class="btn btn-default btn-icon-toggle remove-item" data-toggle="tooltip" title="Delete Item" data-item="' . $item['widget_item_id'] . '"><i class="icon ion-trash-a"></i></a>';
		    		$str .= 					'<a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down widget-caret"></i></a>';
		    		$str .= 				'</div>';
		    		$str .= 			'</div>';
		    		$str .= 		'</div>';
		    		$str .= 		'<div class="card-body" style="display: none;">';
		    		$str .= 			'<div class="form-group">';
		    		foreach ($this->data['languages'] as $language) {
                    $str .=         		'<div class="input-group" style="width: 100%; margin-bottom: 10px;">';
                    $str .=             		'<input class="form-control" value="' . $item['value']['widget_title'][$language['language_code']] . '" disabled>';
                    $str .=             		'<span class="input-group-addon" style="width: 30px; padding-right: 0;"><img src="'. ADMIN_ASSETS_URL . 'images/flags/' . $language['image'] .'" alt=""></span>';
                    $str .=         		'</div>';
					}
                    $str .=         		'<label for="widget_title">Widget Title</label>';
                    $str .=         	'</div>';
		    		$str .= 			'<div class="form-group">';
                    $str .=             	'<input class="form-control" value="Widget ' . $item['value']['widget_data'] . '" disabled>';
                    $str .=         		'<label for="widget_title">Pilih Widget</label>';
                    $str .=         	'</div>';
		    		$str .= 		'</div>';
		    		$str .= 	'</div>';
		    		$str .= '</li>';
				}
			}
			$str .= '</ol>';

			return $str;
		}
    }

    public function save_order_ajax()
    {
    	if ($this->input->post('sortable') && $this->user_m->hasPermission('modify', 'theme/Widget')) {
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

			if ($this->widget_m->save_item($data)) {
                $json['success'] = "Order widget telah disimpan!";
                $this->output->set_output(json_encode($json));
			}
    	} else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
    	}
    }

    public function ajax_delete_widget()
    {
		if ($this->input->post('widget_to_remove') && $this->user_m->hasPermission('modify', 'theme/Widget'))
		{
			$id = $this->input->post('widget_to_remove');
			if ($this->widget_m->delete_widget($id)) {
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
		if ($this->input->post('item_to_remove') && $this->user_m->hasPermission('modify', 'theme/Widget'))
		{
			$id = $this->input->post('item_to_remove');
			if ($this->widget_m->delete_item($id)) {
                $json['success'] = TRUE;
                $this->output->set_output(json_encode($json));
			}

		} else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
    	}
    }
}