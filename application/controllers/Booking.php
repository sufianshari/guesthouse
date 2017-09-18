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
        $this->data['action']           = site_url('booking/proses_booking');
        $this->data['captcha']          = $this->recaptcha->getWidget();
        $this->data['script_captcha']   = $this->recaptcha->getScriptTag();




        $this->load->view('public/public',$this->data);
    }

    public function proses_booking(){

        // validasi form
        $this->_rules_booking();

        $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);

        if ($this->form_validation->run() == FALSE || !isset($response['success']) || $response['success'] <> true) {
            $this->session->set_flashdata('message', 'Reservation Form Failed!');
            redirect(site_url('booking/'));
        } else {
            $data = array(
                'check_in' => $this->input->post('check_in',TRUE),
                'check_out' => $this->input->post('check_out',TRUE),
                'adult_count' => $this->input->post('adult_count',TRUE),
                'child_count' => $this->input->post('child_count',TRUE),
                'first_name' => $this->input->post('first_name',TRUE),
                'last_name' => $this->input->post('last_name',TRUE),
                'email' => $this->input->post('email',TRUE),
                'phone' => $this->input->post('phone',TRUE),
            );

            $this->booking->insert_booking($data);
            $this->session->set_flashdata('message', 'Reservation Success!');
            redirect(site_url('booking/'));
        }
    }

    function _rules_booking()
    {
        $this->form_validation->set_rules('check_in', ' ', 'trim|required');
        $this->form_validation->set_rules('check_out', ' ', 'trim|required');
        $this->form_validation->set_rules('first_name', ' ', 'trim|required');
        $this->form_validation->set_rules('last_name', ' ', 'trim|required');
        $this->form_validation->set_rules('adult_count', ' ', 'trim|required');
        $this->form_validation->set_rules('child_count', ' ', 'trim|required');
        $this->form_validation->set_rules('email', ' ', 'trim|required');
        $this->form_validation->set_rules('phone', ' ', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    }

}