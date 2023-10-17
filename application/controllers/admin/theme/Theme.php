<?php
class Theme extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('directory');
        $this->load->helper('file');
        $this->load->model('theme/theme_m');
    }

    public function index($id = NULL)
    {
        // Active theme check
        if (!$this->setting_m->get_setting('active_theme')) {
            $this->theme_m->set_default_theme();
        }

        // Get all theme
        $list_dir = glob('themes/frontend/' . "*", GLOB_ONLYDIR);

        foreach ($list_dir as $key => $result) {
            $data_results[] = array(
                'theme_name'  => $this->get_name($result),
                'theme_thumb' => $this->get_screnshoot($result),
                'theme_path'  => $result,
                'activated'   => $this->check_activated($result)
            );
        }

        $this->data['themes'] = $data_results;

        // Load view
        if ($this->user_m->hasPermission('access', 'theme/Theme')) {
            $this->data['subview'] = 'admin/theme/theme';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function option()
    {
        // Add theme function
        $active_theme = $this->setting_m->get_setting('active_theme');
        $theme_functions = FCPATH . 'themes/frontend/' . $active_theme . '/functions.php';

        if ($this->user_m->hasPermission('access', 'theme/Theme')) {
            if (is_file($theme_functions)) {
                @include_once($theme_functions);

                if ($this->input->post() && $this->validate_modify('theme/Theme')) {
                    $data['theme_options_' . $active_theme] = $this->input->post();
                    if ($this->setting_m->save_setting($data)) {
                        $this->session->set_flashdata('success', lang('success_update_data'));
                    }
                }

                if ($this->setting_m->get_setting('theme_options_' . $active_theme)) {
                    $this->data['theme_option'] = $this->setting_m->get_setting('theme_options_' . $active_theme);
                } else {
                    $this->data['theme_option'] = $theme_option_default;
                }

                $this->data['file_dir'] = base_url('themes/frontend/' . $active_theme . '/');
                $this->data['subview']  = dirname($theme_functions) . $panel_file;
                $this->load->ext_view('themes/admin/_layout_main_ext', $this->data);
            } else {
                $this->session->set_flashdata('error', lang('error_404_heading'));
                $this->data['subview'] = 'admin/common/error';
                $this->load->view('admin/_layout_main', $this->data);
            }
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function add()
    {
        // Load view
        if ($this->user_m->hasPermission('access', 'theme/Theme')) {
            $this->data['subview'] = 'admin/theme/add_theme';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function upload_theme($dir = NULL)
    {
        if (!empty($_FILES)) {
            $config['upload_path']   = "./themes/frontend/";
            $config['allowed_types'] = 'zip';
            $config['max_size']      = '5000';

            $this->load->library('upload', $config);
            if ($this->user_m->hasPermission('modify', 'theme/Theme')) {
                if (!$this->upload->do_upload("file")) {
                    $json['error'] = $this->upload->display_errors();
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $zip = new ZipArchive;
                    $file = $data['upload_data']['full_path'];
                    chmod($file, 0755);
                    if ($zip->open($file) === TRUE) {
                        $zip->extractTo($config['upload_path']);
                        $zip->close();
                        unlink($file);
                        $json['redirect']     = true;
                        $json['redirect_url'] = site_url('admin/theme/theme');
                    } else {
                        $json['error'] = 'Can not extract archive file!';
                    }
                }
            } else {
                $json['error'] = lang('error_permission');
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($json));
        }
    }

    public function ajax_save_theme()
    {
        if ($this->input->post('active_theme') && $this->validate_modify('theme/Theme')) {
            $this->setting_m->save_setting($this->input->post());
        }
    }

    public function ajax_delete_theme()
    {
        if ($this->input->post('delete_theme')) {
            $path = $this->input->post('delete_theme');

            delete_files($path, true);
            rmdir($path);
        }
    }

    public function get_name($path)
    {
        $theme_name = explode('/', $path);
        return $theme_name[2];
    }

    public function check_activated($path)
    {
        $theme_name = explode('/', $path);

        if (trim($theme_name[2]) === trim($this->setting_m->get_setting('active_theme'))) {
            return lang('text_active');
        }

        return lang('text_inactive');
    }

    public function get_screnshoot($path)
    {
        $check_file = $path . '/' . 'screenshot.png';
        $screenshot = base_url($path . '/' . 'screenshot.png');
        if (!is_file($check_file)) {
            $screenshot = base_url('uploads/images/default/default-thumbnail.png');
        }
        return $screenshot;
    }
}
