<?php
class Download extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('download/download_m');
        $this->load->model('download/download_category_m');
    }

    public function index()
    {
        if ($this->user_m->hasPermission('access', 'Download')) {
            $this->data['subview'] = 'admin/download/index';
        } else {
            $this->session->set_flashdata('error', lang('error_permission'));
            $this->data['subview'] = 'admin/common/error';
        }

        $this->load->view('admin/_layout_main', $this->data);
    }

    public function get_datatables()
    {
        $config = array(
            'model_name'          => 'download_m',
            'sIndexColumn'        => 'download_id',
            'table_name'          => 'download',
            'table_join_name'     => '',
            'table_join_col_name' => '',
            'where_options'       => array(),
            'search_col_name'     => 'name',
            'aColumns'            => array('download_id', 'name', 'download_category_id', 'date_added', 'status', 'filename')
        );

        $query = $this->datatable->index($config);
        $rResult['aaData'] = array();
        if (!empty($query['aaData'])) {
            foreach ($query['aaData'] as $value) {
                $rResult['aaData'][] = array(
                    '0' => $value[0],
                    '1' => $value[1],
                    '2' => $this->download_category_m->get_download_category_name($value[2]),
                    '3' => $value[3],
                    '4' => $value[4],
                    '5' => $value[5]
                );
            }
        }

        $this->output->set_output(json_encode(array_replace_recursive($query, $rResult)));
    }

    public function edit($id = NULL)
    {
        // Fetch a data or set a new one
        if ($id) {
            $result  = $this->download_m->get($id);

            if ($result !== false) {
                $this->data['download'] = $result;
            } else {
                $this->data['download'] = $this->download_m->get_new_download();
            }
        } else {
            $this->data['download'] = $this->download_m->get_new_download();
        }

        // Download categories
        $this->data['download_categories'] = $this->download_category_m->get_by(array('status' => 1), FALSE);

        // Set up the form
        $rules = array(
            'name' => array(
                'field' => 'name',
                'label' => 'Judul Download',
                'rules' => 'trim|required'
            ),
            'filename' => array(
                'field' => 'filename',
                'label' => 'File',
                'rules' => 'trim|required'
            )
        );

        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'download_category_id' => $this->input->post('download_category_id'),
                'name'                 => $this->input->post('name'),
                'filename'             => $this->input->post('filename'),
                'status'               => $this->input->post('status'),
                'date_added'           => date('Y-m-d h:i:s')
            );

            $this->download_m->save($data, $id);
            redirect('admin/download');
        }

        // Load the view
        $this->data['subview'] = 'admin/download/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function status($id, $status)
    {
        if ($this->user_m->hasPermission('publish', 'Download')) {
            if ($status == 'true') {
                if ($this->download_m->update_status($id, 1)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            } elseif ($status == 'false') {
                if ($this->download_m->update_status($id, 0)) {
                    $json['success'] = lang('status_update_success');
                    $this->output->set_output(json_encode($json));
                }
            }
        } else {
            $json['error'] = lang('error_permission');
            $this->output->set_output(json_encode($json));
        }
    }

    public function delete($id = NULL)
    {
        if ($this->validate_delete_download('Download')) {
            if ($id) {
                $this->download_m->delete($id);
                $this->session->set_flashdata('success', lang('success_single_delete'));
                redirect('admin/download');
            } else {
                if ($this->input->post('selected')) {
                    foreach ($this->input->post('selected') as $id) {
                        $this->download_m->delete($id);
                    }

                    $this->session->set_flashdata('success', lang('success_multiple_delete'));
                    redirect('admin/download');
                } else {
                    $this->session->set_flashdata('error', lang('error_delete'));
                    redirect('admin/download');
                }
            }
        }
    }

    public function upload($dir = NULL)
    {
        // printr($_FILES); die();
        if (!empty($_FILES)) {
            $config['upload_path']   = "./uploads/files/" . $dir;
            $config['allowed_types'] = 'png|PNG|JPG|JPEG|jpg|jpeg|pdf|PDF|docx|doc|DOCX|DOC|xlsx|xls|XLXS|XLS|zip';

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload("file")) {
                $json['error'] = $this->upload->display_errors();
            } else {
                $upload_data      = $this->upload->data();
                $json['success']  = 'File Uploaded Successfully..';
                $json['filename'] = $upload_data['file_name'];
            }
            $this->output->set_output(json_encode($json));
        }
    }

    public function view($path = NULL, $filename = NULL)
    {
        // send results to browser to download
        if ($filename) {
            $file = './uploads/files/' . $path . '/' . $filename;
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            flush();
            readfile($file);
            exit;
        }

        return FALSE;
    }

    public function validate_delete_download($controller = NULL)
    {
        if ($this->user_m->hasPermission('publish', $controller) === TRUE) {
            return TRUE;
        }

        $this->session->set_flashdata('error', lang('error_permission'));
        redirect('admin/' . $controller);
        return FALSE;
    }
}
