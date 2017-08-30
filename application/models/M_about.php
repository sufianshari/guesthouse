<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 08/05/2015
 * Time: 16:03
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_about extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_halaman($id)
    {
        $result = $this->db->select('*')
            ->from('halaman')
            ->where('id_halaman', $id)
            ->get();

        if ($result->num_rows() == 1)
        {
            return $result->row();
        }
        else
        {
            return array();
        }
    }

}