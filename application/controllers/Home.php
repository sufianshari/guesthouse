<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public $data = array(
        'main_view'     => 'public/home/home',
        'judul_pendek'  => 'Home',
        'judul_lengkap' => 'Home',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home', 'home', TRUE);
        $this->load->model('M_room', 'room', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data']      = $this->identitas->get_identitas();
    }

    public function index()
    {
        $this->data['slider_data'] = $this->home->get_all_slider();
        $this->data['room_data'] = $this->room->get_all_room_home();

        $this->load->view('public/public',$this->data);
    }
}

