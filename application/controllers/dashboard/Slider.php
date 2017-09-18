<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller
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

            $config['base_url'] = base_url() . 'dashboard/slider/index/';
            $config['total_rows'] = $this->admin->total_rows_slider();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/slider';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $slider = $this->admin->index_limit_slider($config['per_page'], $start);


            $this->data['slider_data']   = $slider;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Home Slider';

            $this->data['main_view']	= "dashboard/slider/slider_list";
            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_slider()
    {
        $this->form_validation->set_rules('nm_slider', ' ', 'trim|required');
        $this->form_validation->set_rules('gambar', ' ', 'trim');

        $this->form_validation->set_rules('id_slider', 'id_slider', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    public function create(){

        $this->data['button']       = 'Tambah Data';
        $this->data['action']       = site_url('dashboard/slider/create_action');
        $this->data['id_slider']    = set_value('id_slider');
        $this->data['nm_slider']    = set_value('nm_slider');
        $this->data['gambar']       = set_value('gambar');

        $this->data['main_view']	= "dashboard/slider/slider_form";

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update($id){

        $row = $this->admin->get_by_id_slider($id);

        if ($row) {

            $this->data['button']       = 'Update Data';
            $this->data['action']       = site_url('dashboard/slider/update_action');
            $this->data['id_slider']    = set_value('id_slider', $row->id_slider);
            $this->data['nm_slider']    = set_value('nm_slider', $row->nm_slider);
            $this->data['gambar']       = set_value('gambar', $row->gambar);

            $this->data['main_view']	= "dashboard/slider/slider_form";
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dashboard/slider'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function delete($id){
        $row = $this->admin->get_by_id_slider($id);

        if ($row) {

            if(!empty($row->gambar)){

                //lokasi file secara spesifik
                $file = './uploads/foto_slider/'.$row->gambar;
                if (!unlink($file)){
                    $this->session->set_flashdata('message', 'File tidak dapat dihapus.');
                    redirect(site_url('dashboard/slider'));
                } else {
                    $this->admin->delete_slider($id);
                    $this->session->set_flashdata('message', 'Hapus data berhasil.');
                    redirect(site_url('dashboard/slider'));
                }
            } else {
                $this->admin->delete_slider($id);
                $this->session->set_flashdata('message', 'Hapus data berhasil.');
                redirect(site_url('dashboard/slider'));
            }
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('dashboard/slider'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function create_action(){
        $this->_rules_slider();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/slider/create'));
        } else {
            $nmfile = "file_".date('YmdHis');
            $config = array (
                'file_name' =>$nmfile,
                'upload_path' => './uploads/foto_slider/',
                'allowed_types' => 'jpg|jpeg|gif|png|bmp',
                'file_ext_tolower' => TRUE,
                'overwrite' => TRUE,
                'max_size' => 20000,
                'max_filename' => 0,
                'remove_spaces' => TRUE
            );
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                $data = array(
                    'nm_slider' => $this->input->post('nm_slider',TRUE),
                );
            } else {
                $data = array(
                    'nm_slider' => $this->input->post('nm_slider',TRUE),
                    'gambar' => $this->upload->file_name,
                );
            }

            $this->admin->insert_slider($data);
            $this->session->set_flashdata('message', 'Tambah Data Berhasil');
            redirect(site_url('dashboard/slider'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update_action(){
        $this->_rules_slider();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/slider/update/'.$this->input->post('id_slider', TRUE)));
        } else {

            $nmfile = "file_".date('YmdHis');
            $config = array (
                'file_name' =>$nmfile,
                'upload_path' => './uploads/foto_slider/',
                'allowed_types' => 'jpg|jpeg|gif|png|bmp',
                'file_ext_tolower' => TRUE,
                'overwrite' => TRUE,
                'max_size' => 20000,
                'max_filename' => 0,
                'remove_spaces' => TRUE
            );
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                $data = array(
                    'nm_slider' => $this->input->post('nm_slider',TRUE),
                );
            } else {
                $data = array(
                    'nm_slider' => $this->input->post('nm_slider',TRUE),
                    'gambar' => $this->upload->file_name,
                );
            }

            $this->admin->update_slider($this->input->post('id_slider', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Data Berhasil');
            redirect(site_url('dashboard/slider'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function search(){
        $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(3)=='search') {
            $config['base_url'] = base_url() . 'dashboard/slider/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'dashboard/slider/index/';
        }

        $config['total_rows'] = $this->admin->search_total_rows_slider($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $config['first_url'] = base_url() . 'dashboard/slider/search/'.$keyword;
        $this->pagination->initialize($config);

        $start = $this->uri->segment(5, 0);
        $slider = $this->admin->search_index_limit_slider($config['per_page'], $start, $keyword);

        $this->data['slider_data']   = $slider;
        $this->data['keyword']      = $keyword;
        $this->data['pagination']   = $this->pagination->create_links();
        $this->data['total_rows']   = $config['total_rows'];
        $this->data['start']        = $start;

        $this->data['main_view']	= "dashboard/slider/slider_list";

        $this->load->view('dashboard/dashboard', $this->data);

    }



}