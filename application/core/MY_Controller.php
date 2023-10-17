<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class MY_Controller
 * @author	Masriadi
 */
class MY_Controller extends CI_Controller
{
    public $data = array();
    function __construct() {
        parent::__construct();
        $this->data['error'] = array();
    }
}
