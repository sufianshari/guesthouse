<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 08/05/2015
 * Time: 16:03
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_identitas extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_identitas()
    {
        $result = $this->db->select('*')
            ->from('identitas')
            ->where('id_identitas', '1')
            ->get();

        if ($result->num_rows() == 1){
            return $result->row_array();
        }
        else {
            return array();
        }
    }

}