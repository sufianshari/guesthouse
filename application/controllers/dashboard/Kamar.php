<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Kamar extends CI_Controller
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

            $config['base_url'] = base_url() . 'dashboard/kamar/index/';
            $config['total_rows'] = $this->admin->total_rows_kamar();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/kamar';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $kamar = $this->admin->index_limit_kamar($config['per_page'], $start);


            $this->data['kamar_data']   = $kamar;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Manajemen Kamar';

            $this->data['main_view']	= "dashboard/kamar/kamar_list";
            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_kamar()
    {
        $this->form_validation->set_rules('nm_kamar', ' ', 'trim|required');
        $this->form_validation->set_rules('pic_kamar', ' ', 'trim');

        $this->form_validation->set_rules('id_intro', 'id_intro', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    public function create(){

        $this->data['button']       = 'Tambah Data';
        $this->data['action']       = site_url('dashboard/kamar/create_action');
        $this->data['id_kamar']     = set_value('id_kamar');
        $this->data['nm_kamar']     = set_value('nm_kamar');
        $this->data['harga_kamar']     = set_value('harga_kamar');
        $this->data['deskripsi']     = set_value('deskripsi');
        $this->data['pic_kamar']    = set_value('pic_kamar');

        $this->data['option_fasilitas']    = $this->admin->get_all_fasilitas();

        $this->data['main_view']	= "dashboard/kamar/kamar_form";

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update($id){

        $row = $this->admin->get_by_id_kamar($id);

        if ($row) {

            $this->data['button']       = 'Update Data';
            $this->data['action']       = site_url('dashboard/kamar/update_action');
            $this->data['id_kamar']     = set_value('id_kamar', $row->id_kamar);
            $this->data['nm_kamar']     = set_value('nm_kamar', $row->nm_kamar);
            $this->data['harga_kamar']     = set_value('harga_kamar', $row->harga_kamar);
            $this->data['deskripsi']     = set_value('deskripsi', $row->deskripsi);
            $this->data['pic_kamar']    = set_value('pic_kamar', $row->pic_kamar);
            $this->data['fasilitas']    = set_value('fasilitas', $row->fasilitas);

            $this->data['option_fasilitas']    = $this->admin->get_all_fasilitas();

            $this->data['main_view']	= "dashboard/kamar/kamar_form";
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dashboard/kamar'));
        }
        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function delete($id){
        $row = $this->admin->get_by_id_kamar($id);

        if ($row) {

            if(!empty($row->pic_kamar)){

                //lokasi file secara spesifik
                $file = './uploads/foto_kamar/'.$row->pic_kamar;
                if (!unlink($file)){
                    $this->session->set_flashdata('message', 'File tidak dapat dihapus.');
                    redirect(site_url('dashboard/kamar'));
                } else {
                    $this->admin->delete_kamar($id);
                    $this->session->set_flashdata('message', 'Hapus data berhasil.');
                    redirect(site_url('dashboard/kamar'));
                }
            } else {
                $this->admin->delete_kamar($id);
                $this->session->set_flashdata('message', 'Hapus data berhasil.');
                redirect(site_url('dashboard/kamar'));
            }
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('dashboard/kamar'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function create_action(){
        $this->_rules_kamar();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/kamar/create'));
        } else {

            $fasilitas = array();
            foreach ($this->input->post('fasilitas',TRUE) as $names){
                $fasilitas[] = $names;
            }
            $arrFasilitas = implode(",", $fasilitas);

            $nmfile = "file_".date('YmdHis');
            $config = array (
                'file_name' =>$nmfile,
                'upload_path' => './uploads/foto_kamar/',
                'allowed_types' => 'jpg|jpeg|gif|png|bmp',
                'file_ext_tolower' => TRUE,
                'overwrite' => TRUE,
                'max_size' => 200000,
                'max_filename' => 0,
                'remove_spaces' => TRUE
            );
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                $data = array(
                    'nm_kamar' => $this->input->post('nm_kamar',TRUE),
                    'seo_kamar' => seo_title($this->input->post('nm_kamar',TRUE)),
                    'harga_kamar' => $this->input->post('harga_kamar',TRUE),
                    'deskripsi' => $this->input->post('deskripsi',TRUE),
                    'fasilitas' => $arrFasilitas
                );
            } else {
                $data = array(
                    'nm_kamar' => $this->input->post('nm_kamar',TRUE),
                    'seo_kamar' => seo_title($this->input->post('nm_kamar',TRUE)),
                    'harga_kamar' => $this->input->post('harga_kamar',TRUE),
                    'deskripsi' => $this->input->post('deskripsi',TRUE),
                    'fasilitas' => $arrFasilitas,
                    'pic_kamar' => $this->upload->file_name,
                );
            }

            $this->admin->insert_kamar($data);
            $this->session->set_flashdata('message', 'Tambah Data Berhasil');
            redirect(site_url('dashboard/kamar'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update_action(){
        $this->_rules_kamar();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/kamar/update/'.$this->input->post('id_kamar', TRUE)));
        } else {

            $fasilitas = array();
            foreach ($this->input->post('fasilitas',TRUE) as $names){
                $fasilitas[] = $names;
            }
            $arrFasilitas = implode(",", $fasilitas);

            $nmfile = "file_".date('YmdHis');
            $config = array (
                'file_name' =>$nmfile,
                'upload_path' => './uploads/foto_kamar/',
                'allowed_types' => 'jpg|jpeg|gif|png|bmp',
                'file_ext_tolower' => TRUE,
                'overwrite' => TRUE,
                'max_size' => 200000,
                'max_filename' => 0,
                'remove_spaces' => TRUE
            );
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                $data = array(
                    'nm_kamar' => $this->input->post('nm_kamar',TRUE),
                    'seo_kamar' => seo_title($this->input->post('nm_kamar',TRUE)),
                    'harga_kamar' => $this->input->post('harga_kamar',TRUE),
                    'deskripsi' => $this->input->post('deskripsi',TRUE),
                    'fasilitas' => $arrFasilitas,
                );
            }
            else {
                //delete dulu foto yang lama ---------------------------------
                $row = $this->admin->get_by_id_kamar($this->input->post('id_kamar', TRUE));
                if ($row) {
                    if(!empty($row->pic_kamar)){
                        $file = './uploads/foto_kamar/'.$row->pic_kamar;
                        unlink($file);
                    }
                }
                //------------------------------------------------------------
                $data = array(
                    'nm_kamar' => $this->input->post('nm_kamar',TRUE),
                    'seo_kamar' => seo_title($this->input->post('nm_kamar',TRUE)),
                    'harga_kamar' => $this->input->post('harga_kamar',TRUE),
                    'deskripsi' => $this->input->post('deskripsi',TRUE),
                    'fasilitas' => $arrFasilitas,
                    'pic_kamar' => $this->upload->file_name,
                );
            }

            $this->admin->update_kamar($this->input->post('id_kamar', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Data Berhasil');
            redirect(site_url('dashboard/kamar'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function search(){
        $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(3)=='search') {
            $config['base_url'] = base_url() . 'dashboard/kamar/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'dashboard/kamar/index/';
        }

        $config['total_rows'] = $this->admin->search_total_rows_kamar($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $config['first_url'] = base_url() . 'dashboard/kamar/search/'.$keyword;
        $this->pagination->initialize($config);

        $start = $this->uri->segment(5, 0);
        $kamar = $this->admin->search_index_limit_kamar($config['per_page'], $start, $keyword);

        $this->data['kamar_data']   = $kamar;
        $this->data['keyword']      = $keyword;
        $this->data['pagination']   = $this->pagination->create_links();
        $this->data['total_rows']   = $config['total_rows'];
        $this->data['start']        = $start;

        $this->data['main_view']	= "dashboard/kamar/kamar_list";

        $this->load->view('dashboard/dashboard', $this->data);

    }




}