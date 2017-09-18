<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 17/09/2017
 * Time: 19:59
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Hubungi extends CI_Controller {

    public $data = array(
        'main_view'     => 'dashboard/home/home',
        'judul_lengkap' => 'Dashboard Admin',
        'judul_pendek'  => 'Home',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_dashboard', 'admin', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data']      = $this->identitas->get_identitas();
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()){
            redirect('dashboard/login', 'refresh');
        } else {

            $keyword = '';

            $config['base_url'] = base_url() . 'dashboard/hubungi/index/';
            $config['total_rows'] = $this->admin->total_rows_hubungi();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/hubungi';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $hubungi = $this->admin->index_limit_hubungi($config['per_page'], $start);


            $this->data['hubungi_data']   = $hubungi;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Kotak Masuk';

            $this->data['main_view']	= "dashboard/hubungi/hubungi_list";

            $this->load->view('dashboard/dashboard', $this->data);
        }
    }

    public function update($id){

        $row = $this->admin->get_by_id_hubungi($id);

        if ($row) {

            $this->data['button']       = 'Balas Email';
            $this->data['action']       = site_url('dashboard/hubungi/update_action');
            $this->data['id_hubungi']   = set_value('id_hubungi', $row->id_hubungi);
            $this->data['nama']         = set_value('nama', $row->nama);
            $this->data['email']        = set_value('email', $row->email);
            $this->data['subjek']       = set_value('subjek', $row->subjek);
            $this->data['pesan']        = set_value('pesan', $row->pesan);

            $this->data['main_view']	= "dashboard/hubungi/hubungi_form";
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dashboard/hubungi'));
        }

        $this->load->view('dashboard/dashboard', $this->data);
    }

    public function delete($id){
        $row = $this->admin->get_by_id_hubungi($id);

        if ($row) {
            $this->admin->delete_hubungi($id);
            $this->session->set_flashdata('message', 'Hapus data berhasil.');
            redirect(site_url('dashboard/hubungi'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('dashboard/hubungi'));
        }

        $this->load->view('dashboard/dashboard', $this->data);
    }

    public function update_action(){
        $this->_rules_hubungi();

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('dashboard/hubungi/update/'.$this->input->post('id_hubungi', TRUE)));
        } else {

            $this->load->library('email');

            //konfigurasi email
            $config = array();
//                    $config['charset'] = 'utf-8';
            $config['charset'] = 'iso-8859-1';
            $config['useragent'] = 'Andy Guesthouse'; //bebas sesuai keinginan kamu
            $config['protocol']= "smtp";
            $config['mailtype']= "html";
            $config['smtp_host']= "ssl://smtp.gmail.com";
            $config['smtp_port']= "465";
            $config['smtp_timeout']= "5";
            $config['smtp_user']= "info@andyguesthouse.com";//isi dengan email kamu
            $config['smtp_pass']= "andyinfo123"; // isi dengan password kamu
            $config['crlf']="\r\n";
            $config['newline']="\r\n";

            $config['wordwrap'] = TRUE;
            //memanggil library email dan set konfigurasi untuk pengiriman email

            $this->email->initialize($config);
            //konfigurasi pengiriman
            $this->email->from("info@andyguesthouse.com","Andy Guesthouse");
            $this->email->to($this->input->post('email'));
            $this->email->subject($this->input->post('subjek'));
            $this->email->message($this->input->post('pesan'));

            if($this->email->send()){
                $data = array(
                    'pesan' => $this->input->post('pesan',TRUE),
                    'dibaca' => 'Y',
                );

                $this->admin->update_hubungi($this->input->post('id_hubungi', TRUE), $data);
                $this->session->set_flashdata('message', 'Merespon pesan telah berhasil.');
                redirect(site_url('dashboard/hubungi'));
            }
            else {
                $this->session->set_flashdata('message', $this->email->print_debugger());
                redirect(site_url('dashboard/hubungi'));
            }
        }

        $this->load->view('dashboard/dashboard', $this->data);

    }

    public function search(){
        $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(3)=='search') {
            $config['base_url'] = base_url() . 'dashboard/hubungi/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'dashboard/hubungi/index/';
        }

        $config['total_rows'] = $this->admin->search_total_rows_hubungi($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $config['first_url'] = base_url() . 'dashboard/hubungi/search/'.$keyword;
        $this->pagination->initialize($config);

        $start = $this->uri->segment(5, 0);
        $hubungi = $this->admin->search_index_limit_hubungi($config['per_page'], $start, $keyword);

        $this->data['hubungi_data']   = $hubungi;
        $this->data['keyword']      = $keyword;
        $this->data['pagination']   = $this->pagination->create_links();
        $this->data['total_rows']   = $config['total_rows'];
        $this->data['start']        = $start;

        $this->data['main_view']	= "dashboard/hubungi/hubungi_list";

        $this->load->view('dashboard/dashboard', $this->data);
    }

    function _rules_hubungi()
    {
        $this->form_validation->set_rules('nama', ' ', 'trim|required');
        $this->form_validation->set_rules('email', ' ', 'trim|required');
        $this->form_validation->set_rules('subjek', ' ', 'trim');
        $this->form_validation->set_rules('pesan', ' ', 'trim');

        $this->form_validation->set_rules('id_hubungi', 'id_hubungi', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }




    /*
        public function send()
        {

            $this->load->helper('form');

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'katalogdata@gmail.com',
                'smtp_pass' => '******',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            $this->email->from('katalogdata@gmail.com', 'Katalo Kode'); (email pengirim)
            $this->email->to('info@katalog-kode.info'); (email tujuan)
            $this->email->subject('Katalog Data'); (subject email)
            $this->email->message('Tutorial Bagaimana cara mengirim email dengan codeigniter dan google smtp mail.');

            if (!$this->email->send()) {
                show_error($this->email->print_debugger()); (jika email gagal terkirim, akan mencetak error)
            }else{
                echo 'Success to send email'; (jika email terkirim, akan mencetak seccess to send email)
            }
        }*/

}