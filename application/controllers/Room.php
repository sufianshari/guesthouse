<?php

/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 29/08/2017
 * Time: 6:40
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {
    
    public $data = array(
        'main_view'     => 'public/room/room',
        'judul_pendek'  => 'Lookbook',
        'judul_lengkap' => 'Lookbook',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_room', 'room', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data']      = $this->identitas->get_identitas();
    }

    public function index()
    {
        $this->data['data_room']      = $this->room->get_room();

        $this->load->view('public/public',$this->data);
    }
}