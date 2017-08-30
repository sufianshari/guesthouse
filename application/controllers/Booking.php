<?php

/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 29/08/2017
 * Time: 6:40
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public $data = array(
        'main_view'     => 'public/booking/booking',
        'judul_pendek'  => 'Reservation',
        'judul_lengkap' => 'Reservation',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_booking', 'booking', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data']      = $this->identitas->get_identitas();
    }

    public function index()
    {
        $this->load->view('public/public',$this->data);
    }
}