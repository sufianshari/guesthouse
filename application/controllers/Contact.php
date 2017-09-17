<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 03/05/2016
 * Time: 06:10
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public $data = array(
        'main_view'     => 'public/contact/contact',
        'judul_pendek'  => 'Contact Us',
        'judul_lengkap' => 'Contact Us',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_contact', 'contact', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data']      = $this->identitas->get_identitas();
    }

    public function index()
    {
        $this->data['action']           = site_url('contact/proses_hubungi');
        $this->data['captcha']          = $this->recaptcha->getWidget();
        $this->data['script_captcha']   = $this->recaptcha->getScriptTag();

        $this->load->view('public/public',$this->data);
    }

    public function proses_hubungi(){

        // validasi form
        $this->_rules_hubungi();

        $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);

        if ($this->form_validation->run() == FALSE || !isset($response['success']) || $response['success'] <> true) {
            $this->session->set_flashdata('message', 'Pengisian Formulir Kontak Kami Gagal!');
            redirect(site_url('contact/'));
        } else {
            $data = array(
                'nama' => $this->input->post('nama',TRUE),
                'email' => $this->input->post('email',TRUE),
                'subjek' => $this->input->post('subjek',TRUE),
                'pesan' => $this->input->post('pesan',TRUE),
            );

            $this->contact->insert_hubungi($data);
            $this->session->set_flashdata('message', 'Pengisian Formulir Kontak Kami Berhasil!');
            redirect(site_url('contact/'));
        }
    }

    function _rules_hubungi()
    {
        $this->form_validation->set_rules('nama', ' ', 'trim|required');
        $this->form_validation->set_rules('email', ' ', 'trim|required');
        $this->form_validation->set_rules('subjek', ' ', 'trim|required');
        $this->form_validation->set_rules('pesan', ' ', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    }

}