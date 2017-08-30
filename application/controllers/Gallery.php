<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

    public $data = array(
        'main_view'     => 'public/gallery/gallery',
        'judul_pendek'  => 'Gallery',
        'judul_lengkap' => 'Gallery',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_gallery', 'gallery', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data']      = $this->identitas->get_identitas();
    }

    public function index()
    {
        $this->data['data_album']       = $this->gallery->get_album();
        $this->data['data_gallery']     = $this->gallery->get_gallery();

        $this->load->view('public/public',$this->data);
    }
}

