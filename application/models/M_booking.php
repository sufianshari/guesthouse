<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_booking extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }

    //insert
    function insert_booking($data)
    {
        $this->db->insert('reservation', $data);
    }
}
