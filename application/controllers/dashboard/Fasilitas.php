<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Fasilitas extends CI_Controller
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

            $config['base_url'] = base_url() . 'dashboard/fasilitas/index/';
            $config['total_rows'] = $this->admin->total_rows_fasilitas();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/fasilitas';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $fasilitas = $this->admin->index_limit_fasilitas($config['per_page'], $start);


            $this->data['fasilitas_data']   = $fasilitas;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Fasilitas Kamar';

            $this->data['main_view']	= "dashboard/fasilitas/fasilitas_list";
            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_fasilitas()
    {
        $this->form_validation->set_rules('nm_fasilitas', ' ', 'trim');

        $this->form_validation->set_rules('id_fasilitas', 'id_fasilitas', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function create(){

        $this->data['button']           = 'Tambah Data';
        $this->data['action']           = site_url('dashboard/fasilitas/create_action');
        $this->data['id_fasilitas']      = set_value('id_fasilitas');
        $this->data['nm_fasilitas']      = set_value('nm_fasilitas');

        $this->data['main_view']	= "dashboard/fasilitas/fasilitas_form";

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update($id){

        $row = $this->admin->get_by_id_fasilitas($id);

        if ($row) {

            $this->data['button']           = 'Update Data';
            $this->data['action']           = site_url('dashboard/fasilitas/update_action');
            $this->data['id_fasilitas']      = set_value('id_fasilitas', $row->id_fasilitas);
            $this->data['nm_fasilitas']      = set_value('nm_fasilitas', $row->nm_fasilitas);

            $this->data['main_view']	= "dashboard/fasilitas/fasilitas_form";
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dashboard/fasilitas'));
        }
        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function delete($id){
        $row = $this->admin->get_by_id_fasilitas($id);

        if ($row) {
            $this->admin->delete_fasilitas($id);
            $this->session->set_flashdata('message', 'Hapus data berhasil.');
            redirect(site_url('dashboard/fasilitas'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('dashboard/fasilitas'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function create_action(){
        $this->_rules_fasilitas();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/fasilitas/create'));
        } else {
            $data = array(
                'nm_fasilitas' => $this->input->post('nm_fasilitas', TRUE),
                'seo_fasilitas' => seo_title($this->input->post('nm_fasilitas', TRUE)),
            );

            $this->admin->insert_fasilitas($data);
            $this->session->set_flashdata('message', 'Tambah Data Berhasil');
            redirect(site_url('dashboard/fasilitas'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update_action(){
        $this->_rules_fasilitas();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/fasilitas/update/'.$this->input->post('id_fasilitas', TRUE)));
        } else {

            $data = array(
                'nm_fasilitas' => $this->input->post('nm_fasilitas', TRUE),
                'seo_fasilitas' => seo_title($this->input->post('nm_fasilitas', TRUE)),
            );

            $this->admin->update_fasilitas($this->input->post('id_fasilitas', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Data Berhasil');
            redirect(site_url('dashboard/fasilitas'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function search(){
        $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(3)=='search') {
            $config['base_url'] = base_url() . 'dashboard/fasilitas/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'dashboard/fasilitas/index/';
        }

        $config['total_rows'] = $this->admin->search_total_rows_fasilitas($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $config['first_url'] = base_url() . 'dashboard/fasilitas/search/'.$keyword;
        $this->pagination->initialize($config);

        $start = $this->uri->segment(5, 0);
        $fasilitas = $this->admin->search_index_limit_fasilitas($config['per_page'], $start, $keyword);

        $this->data['fasilitas_data']   = $fasilitas;
        $this->data['keyword']      = $keyword;
        $this->data['pagination']   = $this->pagination->create_links();
        $this->data['total_rows']   = $config['total_rows'];
        $this->data['start']        = $start;

        $this->data['main_view']	= "dashboard/fasilitas/fasilitas_list";

        $this->load->view('dashboard/dashboard', $this->data);

    }


}