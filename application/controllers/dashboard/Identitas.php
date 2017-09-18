<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Identitas extends CI_Controller
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

    public function index(){
        if (!$this->ion_auth->logged_in())
        {
            redirect('dashboard/login', 'refresh');
        }
        else {

            $row = $this->admin->get_by_id_identitas(1);

            if ($row) {

                $this->data['judul_pendek']     = 'Konfigurasi Website';
                $this->data['button']           = 'Update Konfigurasi Website';
                $this->data['action']           = site_url('dashboard/identitas/update_identitas');

                $this->data['id_identitas']     = set_value('id_identitas', $row->id_identitas);
                $this->data['nm_website']       = set_value('nm_website', $row->nm_website);
                $this->data['email_website']    = set_value('email_website', $row->email_website);
                $this->data['alamat']           = set_value('alamat', $row->alamat);
                $this->data['no_telp1']         = set_value('no_telp1', $row->no_telp1);
                $this->data['no_telp2']         = set_value('no_telp2', $row->no_telp2);
                $this->data['url_facebook']     = set_value('url_facebook', $row->url_facebook);
                $this->data['url_twitter']      = set_value('url_twitter', $row->url_twitter);
                $this->data['url_instagram']    = set_value('url_instagram', $row->url_instagram);
                $this->data['meta_deskripsi']   = set_value('meta_deskripsi', $row->meta_deskripsi);
                $this->data['meta_keyword']     = set_value('meta_keyword', $row->meta_keyword);
                $this->data['latitude']         = set_value('latitude', $row->latitude);
                $this->data['longitude']        = set_value('longitude', $row->longitude);
                $this->data['logo_website']     = set_value('logo_website', $row->logo_website);

                $this->data['main_view']	    = "dashboard/identitas/identitas_form";

            }
            else {
                $this->session->set_flashdata('message', 'Record Not Found');
                redirect(site_url('dashboard/identitas'));
            }

            $this->load->view('dashboard/dashboard', $this->data);
        }
    }

    public function create(){

        $this->load->view('dashboard/dashboard', $this->data);

    }
    public function update_identitas(){

        $nmfile = "file_".date('YmdHis');
        $config = array (
            'file_name' =>$nmfile,
            'upload_path' => './uploads/system/',
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
                'nm_website' => $this->input->post('nm_website',TRUE),
                'email_website' => $this->input->post('email_website',TRUE),
                'alamat' => $this->input->post('alamat',TRUE),
                'no_telp1' => $this->input->post('no_telp1',TRUE),
                'no_telp2' => $this->input->post('no_telp2',TRUE),
                'url_facebook' => $this->input->post('url_facebook',TRUE),
                'url_twitter' => $this->input->post('url_twitter',TRUE),
                'url_instagram' => $this->input->post('url_instagram',TRUE),
                'meta_deskripsi' => $this->input->post('meta_deskripsi',TRUE),
                'meta_keyword' => $this->input->post('meta_keyword',TRUE),
                'latitude' => $this->input->post('latitude',TRUE),
                'longitude' => $this->input->post('longitude',TRUE),
            );
        } else {

            //delete dulu foto yang lama ---------------------------------
            $row = $this->admin->get_by_id_identitas($this->input->post('id_identitas', TRUE));
            if ($row) {
                if(!empty($row->logo_website)){
                    $file = './uploads/system/'.$row->logo_website;
                    unlink($file);
                }
            }
            //------------------------------------------------------------

            $data = array(
                'nm_website' => $this->input->post('nm_website',TRUE),
                'email_website' => $this->input->post('email_website',TRUE),
                'alamat' => $this->input->post('alamat',TRUE),
                'no_telp1' => $this->input->post('no_telp1',TRUE),
                'no_telp2' => $this->input->post('no_telp2',TRUE),
                'url_facebook' => $this->input->post('url_facebook',TRUE),
                'url_twitter' => $this->input->post('url_twitter',TRUE),
                'url_instagram' => $this->input->post('url_instagram',TRUE),
                'meta_deskripsi' => $this->input->post('meta_deskripsi',TRUE),
                'meta_keyword' => $this->input->post('meta_keyword',TRUE),
                'latitude' => $this->input->post('latitude',TRUE),
                'longitude' => $this->input->post('longitude',TRUE),
                'logo_website' => $this->upload->file_name,
            );
        }

        $this->admin->update_identitas($this->input->post('id_identitas', TRUE), $data);

        $this->session->set_userdata('info','Sukses Update Profil');
        redirect(site_url('dashboard/identitas'));

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