<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Halaman extends CI_Controller
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

            $config['base_url'] = base_url() . 'dashboard/halaman/index/';
            $config['total_rows'] = $this->admin->total_rows_halaman();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/halaman';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $halaman = $this->admin->index_limit_halaman($config['per_page'], $start);


            $this->data['halaman_data']   = $halaman;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Halaman Statis';

            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);
            $idu					= $this->uri->segment(4);
            if($mau_ke == "create"){

                $this->data['button']       = 'Tambah Data';
                $this->data['action']       = site_url('dashboard/halaman/create_action');
                $this->data['id_halaman']     = set_value('id_halaman');
                $this->data['judul']     = set_value('judul');
                $this->data['pic_halaman']    = set_value('pic_halaman');
                $this->data['isi_halaman']  = set_value('isi_halaman');
                $this->data['aktif_hal']    = set_value('aktif_hal');
                $this->data['option_aktif']  = array(
                    'Y' => 'Ya',
                    'N' => 'Tidak',
                );
                $this->data['main_view']	= "dashboard/halaman/halaman_form";
            }
            elseif($mau_ke == "update"){

                $row = $this->admin->get_by_id_halaman($idu);

                if ($row) {

                    $this->data['button']       = 'Update Data';
                    $this->data['action']       = site_url('dashboard/halaman/update_action');
                    $this->data['id_halaman']    = set_value('id_halaman', $row->id_halaman);
                    $this->data['judul']    = set_value('judul', $row->judul);
                    $this->data['pic_halaman']   = set_value('pic_halaman', $row->pic_halaman);
                    $this->data['isi_halaman']  = set_value('isi_halaman', $row->isi_halaman);
                    $this->data['aktif_hal']    = set_value('aktif_hal', $row->aktif_hal);
                    $this->data['option_aktif'] = array(
                        'Y' => 'Ya',
                        'N' => 'Tidak',
                    );

                    $this->data['main_view']	= "dashboard/halaman/halaman_form";
                } else {
                    $this->session->set_flashdata('message', 'Record Not Found');
                    redirect(site_url('dashboard/halaman'));
                }

            }
            elseif($mau_ke == "delete"){
                $row = $this->admin->get_by_id_halaman($idu);

                if ($row) {

                    if(!empty($row->pic_halaman)){

                        //lokasi file secara spesifik
                        $file = './uploads/foto_halaman/'.$row->pic_halaman;
                        if (!unlink($file)){
                            $this->session->set_flashdata('message', 'File tidak dapat dihapus.');
                            redirect(site_url('dashboard/halaman'));
                        } else {
                            $this->admin->delete_halaman($idu);
                            $this->session->set_flashdata('message', 'Hapus data berhasil.');
                            redirect(site_url('dashboard/halaman'));
                        }
                    } else {
                        $this->admin->delete_halaman($idu);
                        $this->session->set_flashdata('message', 'Hapus data berhasil.');
                        redirect(site_url('dashboard/halaman'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Data tidak ditemukan.');
                    redirect(site_url('dashboard/halaman'));
                }

            }
            elseif($mau_ke == "create_action"){
                $this->_rules_halaman();

                if ($this->form_validation->run() == FALSE) {
                    redirect(site_url('dashboard/halaman/create'));
                } else {
                    $nmfile = "file_".date('YmdHis');
                    $config = array (
                        'file_name' =>$nmfile,
                        'upload_path' => './uploads/foto_halaman/',
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
                            'judul' => $this->input->post('judul',TRUE),
                            'judul_seo' => seo_title($this->input->post('judul',TRUE)),
                            'isi_halaman' => $this->input->post('isi_halaman',TRUE),
                            'aktif_hal' => $this->input->post('aktif_hal',TRUE)
                        );
                    } else {
                        $data = array(
                            'judul' => $this->input->post('judul',TRUE),
                            'judul_seo' => seo_title($this->input->post('judul',TRUE)),
                            'isi_halaman' => $this->input->post('isi_halaman',TRUE),
                            'aktif_hal' => $this->input->post('aktif_hal',TRUE),
                            'pic_halaman' => $this->upload->file_name
                        );
                    }

                    $this->admin->insert_halaman($data);
                    $this->session->set_flashdata('message', 'Tambah Data Berhasil');
                    redirect(site_url('dashboard/halaman'));
                }

            }
            elseif($mau_ke == "update_action"){
                $this->_rules_halaman();

                if ($this->form_validation->run() == FALSE) {
                    redirect(site_url('dashboard/halaman/update/'.$this->input->post('id_halaman', TRUE)));
                } else {

                    $nmfile = "file_".date('YmdHis');
                    $config = array (
                        'file_name' =>$nmfile,
                        'upload_path' => './uploads/foto_halaman/',
                        'file_ext_tolower' => TRUE,
                        'overwrite' => TRUE,
                        'max_size' => 200000,
                        'max_filename' => 0,
                        'remove_spaces' => TRUE
                    );
                    $this->load->library('upload', $config);

                    /*$result = $this->upload->data();
                    echo "<pre>";
                    print_r($result);
                    echo "</pre>";*/

                    if (!$this->upload->do_upload()){
                        $data = array(
                            'judul' => $this->input->post('judul',TRUE),
                            'judul_seo' => seo_title($this->input->post('judul',TRUE)),
                            'isi_halaman' => $this->input->post('isi_halaman',TRUE),
                            'aktif_hal' => $this->input->post('aktif_hal',TRUE)
                        );
                    }
                    else {

                        //delete dulu foto yang lama ---------------------------------
                        $row = $this->admin->get_by_id_halaman($this->input->post('id_halaman', TRUE));
                        if ($row) {
                            if(!empty($row->pic_halaman)){
                                $file = './uploads/foto_halaman/'.$row->pic_halaman;
                                unlink($file);
                            }
                        }
                        //------------------------------------------------------------
                        $data = array(
                            'judul' => $this->input->post('judul',TRUE),
                            'judul_seo' => seo_title($this->input->post('judul',TRUE)),
                            'isi_halaman' => $this->input->post('isi_halaman',TRUE),
                            'aktif_hal' => $this->input->post('aktif_hal',TRUE),
                            'pic_halaman' => $this->upload->file_name
                        );
                    }

                    $this->admin->update_halaman($this->input->post('id_halaman', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Data Berhasil');
                    redirect(site_url('dashboard/halaman'));
                }

            }
            elseif($mau_ke == "search"){
                $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
                $this->load->library('pagination');

                if ($this->uri->segment(3)=='search') {
                    $config['base_url'] = base_url() . 'dashboard/halaman/search/' . $keyword;
                } else {
                    $config['base_url'] = base_url() . 'dashboard/halaman/index/';
                }

                $config['total_rows'] = $this->admin->search_total_rows_halaman($keyword);
                $config['per_page'] = 10;
                $config['uri_segment'] = 5;
                $config['first_url'] = base_url() . 'dashboard/halaman/search/'.$keyword;
                $this->pagination->initialize($config);

                $start = $this->uri->segment(5, 0);
                $halaman = $this->admin->search_index_limit_halaman($config['per_page'], $start, $keyword);

                $this->data['halaman_data']   = $halaman;
                $this->data['keyword']      = $keyword;
                $this->data['pagination']   = $this->pagination->create_links();
                $this->data['total_rows']   = $config['total_rows'];
                $this->data['start']        = $start;

                $this->data['main_view']	= "dashboard/halaman/halaman_list";

            }
            else {
                $this->data['main_view']	= "dashboard/halaman/halaman_list";
            }



            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_halaman()
    {
        $this->form_validation->set_rules('judul', '', 'trim|required');
        $this->form_validation->set_rules('isi_halaman', '', 'trim');
        $this->form_validation->set_rules('pic_halaman', '', 'trim');

        $this->form_validation->set_rules('id_halaman', 'id_halaman', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    public function create(){

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update($id){

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function delete($id){

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function create_action(){

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update_action(){

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function search(){

        $this->load->view('dashboard/dashboard', $this->data);

    }



}