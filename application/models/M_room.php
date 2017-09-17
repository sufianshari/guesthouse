<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_room extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_room_home(){
        $result = $this->db->select("*")
            ->from("kamar")
            ->limit(4)
            ->order_by('id_kamar', 'desc')
            ->get()
            ->result();
        return $result;
    }

    public function get_all_room(){
        $result = $this->db->select("*")
            ->from("kamar")
            ->order_by('id_kamar', 'desc')
            ->get()
            ->result();
        return $result;
    }

}