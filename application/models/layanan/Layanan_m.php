<?php
class Layanan_M extends MY_Model
{
    protected $_table_name = 'layanan';
    protected $_order_by = 'layanan_id';
    public $rules = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model('setting/setting_m');
    }

    public function get_new_layanan()
    {
        $this->load->model('setting/language_m');

        $result['layanan_data'] = array(
            'layanan_id'    => '',
            'title'         => set_value('title'),
            'description'   => set_value('description'),
            'sort_order'    => null,
            'status'        => '1'
        );

        return $result;
    }

    public function get_layanan($id = NULL)
    {
        if ($id) {
            $this->_table_name = 'layanan';
            $where = array(
                'layanan_id' => $id
            );
            $result['layanan_data'] = $this->get_by($where, TRUE);
            return $result;
        } else {
            $results = $this->get();
            foreach ($results as $key => $layanan) {
                $result[$key]['layanan_data'] = $layanan;
                return $result;
            }
        }
    }

    public function save_layanan($data, $id = NULL)
    {
        $this->_table_name = 'layanan';
        if (isset($data['layanan_data'])) {
            if ((int) $data['layanan_data']['layanan_id'] > 0) {
                $layanan_data = array(
                    'title'         => $data['layanan_data']['title'],
                    'slug'          => get_slug($data['layanan_data']['title']),
                    'description'   => $data['layanan_data']['description'],
                    'sort_order'    => $data['layanan_data']['sort_order'],
                    'status'        => $data['layanan_data']['status'],
                );
                $this->db->set($layanan_data);
                $this->db->where('layanan_id', $id);
                $this->db->update($this->_table_name);
            } else {
                unset($data["layanan_data"]['layanan_id']);
                $layanan_data = array(
                    'title'         => $data['layanan_data']['title'],
                    'slug'          => get_slug($data['layanan_data']['title']),
                    'description'   => $data['layanan_data']['description'],
                    'sort_order'    => $data['layanan_data']['sort_order'],
                    'status'        => $data['layanan_data']['status'],
                );
                $this->db->set($layanan_data);
                $this->db->insert($this->_table_name);
                $layanan_data['layanan_id'] = $this->db->insert_id();
            }
        }
    }

    public function update_status($id, $status)
    {
        $data['status'] = $status;

        $this->db->set($data);
        $this->db->where('layanan_id', $id);
        $this->db->update($this->_table_name);

        return TRUE;
    }

    public function delete_service($id)
    {
        $this->db->where('layanan_id', $id);
        $this->db->delete('layanan');
    }
}
