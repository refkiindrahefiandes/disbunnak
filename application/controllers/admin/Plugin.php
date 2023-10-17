<?php
class Plugin extends Admin_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('plugin/plugin_m');
        $this->load->library('plugins');
        $this->load->helper('file');
    }

    public function index()
    {
        // Get data
        $results = $this->plugin_m->get_installed();
        $plugins = array();
        foreach ($results as $result) {
            $plugins[] = $result['name'];
        }

        $files = glob(FCPATH . 'plugins/*/*_plugin.php');

        $this->data['plugins'] = array();
        if ($files) {
            foreach ($files as $file) {
                $plugin_slug = strtolower(basename($file, '.php'));

                // Get plugin class from library
                $this->plugins->load($plugin_slug);

                $load = new $plugin_slug();
                $plugin_name = isset($load->_plugin_name) ? $load->_plugin_name : '';
                $plugin_desc = isset($load->_plugin_desc) ? $load->_plugin_desc : '';

                $action = array();
                if (!in_array($plugin_slug, $plugins)) {
                    if (method_exists($load,'index')) {
                        $action['href_edit']   = site_url('admin/plugin/edit/' . $plugin_slug);
                    }

                    $action['href_delete'] = site_url('admin/plugin/delete/' . $plugin_slug);
                    $action['status']      = '0';
                } else {
                    if (method_exists($load,'index')) {
                        $action['href_edit']   = site_url('admin/plugin/edit/' . $plugin_slug);
                    }

                    $action['href_delete'] = site_url('admin/plugin/delete/' . $plugin_slug);
                    $action['status']      = '1';
                }

                $this->data['plugins'][] = array(
                    'name'        => $plugin_name,
                    'desc'        => $plugin_desc,
                    'code'        => $plugin_slug,
                    'data_widget' => $plugin_slug,
                    'action'      => $action
                );
            }
        }

        // Load the view
        if ($this->user_m->hasPermission('access', 'Plugin')) {
            $this->data['subview'] = 'admin/plugin/plugin';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

    	$this->load->view('admin/_layout_main', $this->data);
    }

    public function add()
    {
        // Load view
        if ($this->user_m->hasPermission('access', 'Plugin')) {
            $this->data['subview'] = 'admin/plugin/add_plugin';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function upload_plugin($dir = NULL)
    {
        if (!empty($_FILES))
        {
            $config['upload_path']   = "./plugins/";
            $config['allowed_types'] = 'zip';
            $config['max_size']      = '5000';

            $this->load->library('upload', $config);
            if ($this->user_m->hasPermission('modify', 'Plugin')) {
                if (!$this->upload->do_upload("file")) {
                    $json['error'] = $this->upload->display_errors();
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $zip = new ZipArchive;
                    $file = $data['upload_data']['full_path'];
                    chmod($file,0755);
                    if ($zip->open($file) === TRUE) {
                        $zip->extractTo($config['upload_path']);
                        $zip->close();
                        unlink($file);
                        $json['redirect']     = true;
                        $json['redirect_url'] = site_url('admin/plugin');
                    } else {
                        $json['error'] = lang('error_cant_extract_archive');
                    }
                }
            } else {
                $json['error'] = lang('error_permission');
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
        }
    }

    public function edit($plugin_key)
    {
        // Set data
        $this->data['redirect'] = 'admin/plugin/edit/' . $plugin_key;
        $this->data['back_to_plugins'] = site_url('admin/plugin');

        // Get plugin class from library
        $this->plugins->load($plugin_key);

        $query = new $plugin_key();

        if (method_exists($query,'index') && $this->user_m->hasPermission('access', 'Plugin')) {
            $plugin_data = $query->index();

            $this->data['subview'] = 'plugins/' . $plugin_key . '/' . $plugin_key . '_view';
            $this->load->ext_view('themes/admin/_layout_main_ext', $this->data);
        } else {
            redirect('admin/plugin');
        }
    }

    public function delete($plugin_key)
    {
        if ($this->validate_delete('Plugin')) {
            if ($plugin_key)
            {
                $path = 'plugins/' . $plugin_key;

                if (delete_files($path, true) && rmdir($path)) {
                    // Remove orphan data
                    $this->setting_m->delete_setting($plugin_key . '_widget');
                    $this->session->set_flashdata('success', lang('success_single_delete'));
                    redirect('admin/plugin');
                } else {
                    $this->session->set_flashdata('error', "<strong>Error!</strong> Plugin gagal dihapus!");
                    redirect('admin/plugin');
                }
                redirect('admin/plugin');
            } else {
                $this->session->set_flashdata('error', "<strong>Error!</strong> Plugin gagal dihapus!");
                redirect('admin/plugin');
            }
        }
    }

    public function status($plugin, $status, $data_widget = NULL)
    {
        if ($this->user_m->hasPermission('modify', 'Plugin')) {
            if ($status == 'true') {
                $this->plugin_m->install($plugin);

                // Get plugin class from library
                $this->plugins->load($data_widget);

                $query = new $data_widget();
                if (method_exists($query,'widget_init')) {
                    $plugin_data = $query->widget_init();
                }
            }

            if ($status == 'false') {
                $this->plugin_m->uninstall($plugin);
            }

            if ($status == 'false' && $data_widget != NULL) {
                $this->setting_m->delete_setting($data_widget . '_widget');

                // Delete widget item
                $this->db->where('widget_type', $data_widget . '_widget');
                $this->db->delete('widget_item');
            }

            $json['success'] = lang('status_update_success');
            $this->output->set_output(json_encode($json));
        } else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }
}