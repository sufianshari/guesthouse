<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller
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

            $config['base_url'] = base_url() . 'dashboard/galeri/index/';
            $config['total_rows'] = $this->admin->total_rows_galeri();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/galeri';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $galeri = $this->admin->index_limit_galeri($config['per_page'], $start);


            $this->data['galeri_data']   = $galeri;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Galeri Foto';

            $this->data['main_view']	= "dashboard/galeri/galeri_list";
            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_galeri()
    {
        $this->form_validation->set_rules('nm_galeri', ' ', 'trim|required');
        $this->form_validation->set_rules('pic_galeri', ' ', 'trim');

        $this->form_validation->set_rules('id_galeri', 'id_galeri', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function create(){

        $this->data['button']       = 'Tambah Data';
        $this->data['action']       = site_url('dashboard/galeri/create_action');
        $this->data['id_galeri']     = set_value('id_galeri');
        $this->data['nm_galeri']     = set_value('nm_galeri');
        $this->data['pic_galeri']    = set_value('pic_galeri');
        $this->data['id_album']    = set_value('id_album');

        $album = $this->admin->get_all_album();
        if($album) {
            foreach($album as $row) {
                $this->data['option_album'][$row->id_album] = $row->nm_album;
            }
        }
        else {
            $this->data['option_album']['0'] = '-';
            $this->data['pesan'] = 'Data Album tidak tersedia. Silahkan isi dahulu data album.';
        }

        $this->data['main_view']	= "dashboard/galeri/galeri_form";

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update($id){

        $row = $this->admin->get_by_id_galeri($id);

        if ($row) {

            $this->data['button']       = 'Update Data';
            $this->data['action']       = site_url('dashboard/galeri/update_action');
            $this->data['id_galeri']    = set_value('id_galeri', $row->id_galeri);
            $this->data['nm_galeri']    = set_value('nm_galeri', $row->nm_galeri);
            $this->data['pic_galeri']   = set_value('pic_galeri', $row->pic_galeri);
            $this->data['id_album']     = set_value('id_album', $row->id_album);

            $album = $this->admin->get_all_album();
            if($album) {
                foreach($album as $row) {
                    $this->data['option_album'][$row->id_album] = $row->nm_album;
                }
            }

            $this->data['main_view']	= "dashboard/galeri/galeri_form";
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dashboard/galeri'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function delete($id){
        $row = $this->admin->get_by_id_galeri($id);

        if ($row) {

            if(!empty($row->pic_galeri)){

                //lokasi file secara spesifik
                $file = './uploads/foto_galeri/'.$row->pic_galeri;
                if (!unlink($file)){
                    $this->session->set_flashdata('message', 'File tidak dapat dihapus.');
                    redirect(site_url('dashboard/galeri'));
                } else {
                    $this->admin->delete_galeri($id);
                    $this->session->set_flashdata('message', 'Hapus data berhasil.');
                    redirect(site_url('dashboard/galeri'));
                }
            } else {
                $this->admin->delete_galeri($id);
                $this->session->set_flashdata('message', 'Hapus data berhasil.');
                redirect(site_url('dashboard/galeri'));
            }
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('dashboard/galeri'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function create_action(){
        $this->_rules_galeri();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/galeri/create'));
        } else {
            $nmfile = "file_".date('YmdHis');
            $config = array (
                'file_name' =>$nmfile,
                'upload_path' => './uploads/foto_galeri/',
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
                    'nm_galeri' => $this->input->post('nm_galeri',TRUE),
                    'id_album' => $this->input->post('id_album',TRUE),
                );
            } else {
                $data = array(
                    'nm_galeri' => $this->input->post('nm_galeri',TRUE),
                    'id_album' => $this->input->post('id_album',TRUE),
                    'pic_galeri' => $this->upload->file_name,
                );
            }

            $this->admin->insert_galeri($data);
            $this->session->set_flashdata('message', 'Tambah Data Berhasil');
            redirect(site_url('dashboard/galeri'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update_action(){
        $this->_rules_galeri();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/galeri/update/'.$this->input->post('id_galeri', TRUE)));
        } else {

            $nmfile = "file_".date('YmdHis');
            $config = array (
                'file_name' =>$nmfile,
                'upload_path' => './uploads/foto_galeri/',
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
                    'nm_galeri' => $this->input->post('nm_galeri',TRUE),
                    'id_album' => $this->input->post('id_album',TRUE),
                );
            }
            else {
                //delete dulu foto yang lama ---------------------------------
                $row = $this->admin->get_by_id_galeri($this->input->post('id_galeri', TRUE));
                if ($row) {
                    if(!empty($row->pic_galeri)){
                        $file = './uploads/foto_galeri/'.$row->pic_galeri;
                        unlink($file);
                    }
                }
                //------------------------------------------------------------

                $data = array(
                    'nm_galeri' => $this->input->post('nm_galeri',TRUE),
                    'id_album' => $this->input->post('id_album',TRUE),
                    'pic_galeri' => $this->upload->file_name,
                );
            }

            $this->admin->update_galeri($this->input->post('id_galeri', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Data Berhasil');
            redirect(site_url('dashboard/galeri'));
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function search(){
        $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(3)=='search') {
            $config['base_url'] = base_url() . 'dashboard/galeri/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'dashboard/galeri/index/';
        }

        $config['total_rows'] = $this->admin->search_total_rows_galeri($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $config['first_url'] = base_url() . 'dashboard/galeri/search/'.$keyword;
        $this->pagination->initialize($config);

        $start = $this->uri->segment(5, 0);
        $galeri = $this->admin->search_index_limit_galeri($config['per_page'], $start, $keyword);

        $this->data['galeri_data']   = $galeri;
        $this->data['keyword']      = $keyword;
        $this->data['pagination']   = $this->pagination->create_links();
        $this->data['total_rows']   = $config['total_rows'];
        $this->data['start']        = $start;

        $this->data['main_view']	= "dashboard/galeri/galeri_list";

        $this->load->view('dashboard/dashboard', $this->data);

    }




}