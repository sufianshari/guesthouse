<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_contact extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //insert
    function insert_hubungi($data)
    {
        $this->db->insert('hubungi', $data);
    }
}