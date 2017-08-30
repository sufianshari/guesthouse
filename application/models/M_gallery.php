<?php
/**

 * Created by PhpStorm.

 * User: Kurma Sufi

 * Date: 08/05/2015

 * Time: 16:03

 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_gallery extends CI_Model
{

    public function __construct(){
        parent::__construct();
    }

    public function get_album()
    {
        $result = $this->db->select('*')
            ->from('album')
            ->order_by('id_album', 'ASC')
            ->get();

        if ($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return array();
        }
    }

    function get_album_by_id($id)
    {
        $result = $this->db->select('*')
            ->from('album')
            ->where('id_album', $id)
            ->get();
        if ($result->num_rows() == 1) {
            return $result->row_array();
        }else {
            return array();
        }
    }

    function get_gallery()
    {
        $result = $this->db->select('*')
            ->from('galeri')
            ->join('album', 'galeri.id_album = album.id_album', 'left')
            ->get();

        if ($result->num_rows() > 0) {
            return $result->result_array();
        }else{
            return array();
        }
    }
}