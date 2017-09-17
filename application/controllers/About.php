<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public $data = array(
        'main_view'     => 'public/about/about',
        'judul_pendek'  => 'About Us',
        'judul_lengkap' => 'About Us',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_about', 'about', TRUE);
        $this->load->model('M_room', 'room', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data']      = $this->identitas->get_identitas();
    }

    public function index()
    {
        $id = '1';
        $row = $this->about->get_halaman($id);
        $this->data['data_halaman']  = $row;
        $this->data['judul_pendek'] = $row->judul;

        $this->data['room_data'] = $this->room->get_all_room_home();

        $this->load->view('public/public',$this->data);
    }
}
