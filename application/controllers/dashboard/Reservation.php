<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller
{

    public $data = array(
        'main_view' => 'dashboard/login',
        'judul_lengkap' => 'Login Administrator',
        'judul_pendek' => 'Login',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->load->model('M_dashboard', 'admin', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data'] = $this->identitas->get_identitas();
    }

    public function index()
    {

        if (!$this->ion_auth->logged_in())
        {
            redirect('dashboard/login', 'refresh');
        }
        else {

            $keyword = '';

            $config['base_url'] = base_url() . 'dashboard/reservation/index/';
            $config['total_rows'] = $this->admin->total_rows_reservation();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/reservation';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $reservation = $this->admin->index_limit_reservation($config['per_page'], $start);


            $this->data['reservation_data']   = $reservation;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Laporan Reservasi';

            $this->data['main_view']	= "dashboard/reservation/reservation_list";
            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_reservation()
    {
        $this->form_validation->set_rules('nm_reservation', ' ', 'trim');

        $this->form_validation->set_rules('id_reservation', 'id_reservation', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function create(){

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update($id){

        $row = $this->admin->get_by_id_reservation($id);

        if ($row) {

            $this->data['button']           = 'Update Data';
            $this->data['action']           = site_url('dashboard/reservation/update_action');
            $this->data['id_reservation']      = set_value('id_reservation', $row->id_reservation);
            $this->data['nm_reservation']      = set_value('nm_reservation', $row->nm_reservation);

            $this->data['main_view']	= "dashboard/reservation/reservation_form";
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dashboard/reservation'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function delete($id){
        $row = $this->admin->get_by_id_reservation($id);

        if ($row) {
            $this->admin->delete_reservation($id);
            $this->session->set_flashdata('message', 'Hapus data berhasil.');
            redirect(site_url('dashboard/reservation'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('dashboard/reservation'));
        }
        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function create_action(){

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update_action(){
        $this->_rules_reservation();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/reservation/update/'.$this->input->post('id_reservation', TRUE)));
        } else {

            $data = array(
                'nm_reservation' => $this->input->post('nm_reservation', TRUE),
                'seo_reservation' => seo_title($this->input->post('nm_reservation', TRUE)),
            );

            $this->admin->update_reservation($this->input->post('id_reservation', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Data Berhasil');
            redirect(site_url('dashboard/reservation'));
        }
        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function search(){
        $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(3)=='search') {
            $config['base_url'] = base_url() . 'dashboard/reservation/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'dashboard/reservation/index/';
        }

        $config['total_rows'] = $this->admin->search_total_rows_reservation($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $config['first_url'] = base_url() . 'dashboard/reservation/search/'.$keyword;
        $this->pagination->initialize($config);

        $start = $this->uri->segment(5, 0);
        $reservation = $this->admin->search_index_limit_reservation($config['per_page'], $start, $keyword);

        $this->data['reservation_data']   = $reservation;
        $this->data['keyword']      = $keyword;
        $this->data['pagination']   = $this->pagination->create_links();
        $this->data['total_rows']   = $config['total_rows'];
        $this->data['start']        = $start;

        $this->data['main_view']	= "dashboard/reservation/reservation_list";

        $this->load->view('dashboard/dashboard', $this->data);

    }




}