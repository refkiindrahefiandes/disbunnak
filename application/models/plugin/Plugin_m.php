<?php
class Plugin_M extends MY_Model
{
    protected $_table_name = 'plugin';
    protected $_order_by   = 'plugin_id';
    public $rules          = array();

    function __construct ()
    {
        parent::__construct();
    }

    public function get_installed ($plugin_name = NULL)
    {
        $this->db->select('*');
        $this->db->from($this->_table_name);

        if ($plugin_name !== NULL) {
            $this->db->where('name', $plugin_name);
            $result = $this->db->get()->row_array();
        } else {
            $result = $this->db->get()->result_array();
        }
        return $result;
    }

    public function install($plugin)
    {
        $this->db->where('name', $plugin);
        $this->db->delete($this->_table_name);

        $plugin_data['name'] = $plugin;

        $this->db->set($plugin_data);
        $this->db->insert($this->_table_name);
    }

    public function uninstall($plugin)
    {
        $this->db->where('name', $plugin);
        $this->db->delete($this->_table_name);
    }

}