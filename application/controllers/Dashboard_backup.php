<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public $data = array(
        'main_view'     => 'dashboard/home/home',
        'judul_lengkap' => 'Dashboard Admin',
        'judul_pendek'  => 'Dashboard',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth','form_validation'));
        $this->load->helper(array('url','language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->load->model('M_dashboard', 'admin', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data']      = $this->identitas->get_identitas();

    }

    // redirect if needed, otherwise display the user list
    public function index()
    {

        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('dashboard/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }
        else
        {
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $this->data['users'] = $this->ion_auth->users()->result();
            foreach ($this->data['users'] as $k => $user)
            {
                $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            $this->data['main_view']	= "dashboard/home/home";
            $this->load->view('dashboard/dashboard', $this->data);
        }
    }



    // ---------------------------------------------------------------------
    // ------------------------- MANAJEMEN LOGIN ---------------------------
    // ---------------------------------------------------------------------

    // log the user in
    public function login()
    {
        $this->data['title'] = $this->lang->line('login_heading');

        //validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() == true)
        {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('/dashboard', 'refresh');
            }
            else
            {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('dashboard/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array(
                'name'        => 'identity',
                'id'          => 'identity',
                'type'        => 'email',
                'value'       => $this->form_validation->set_value('identity'),
                'class'       => 'form-control',
                'placeholder' => lang('login_identity_label')
            );
            $this->data['password'] = array(
                'name'        => 'password',
                'id'          => 'password',
                'type'        => 'password',
                'class'       => 'form-control',
                'placeholder' => lang('login_password_label')
            );


            $this->data['judul_pendek'] = 'Login Administrator';
            $this->data['main_view']	= "dashboard/login";
            $this->load->view('dashboard/login', $this->data);
        }
    }

    // log the user out
    public function logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('dashboard/login', 'refresh');
    }

    // change password
    public function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('dashboard/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false)
        {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id'   => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name'    => 'new',
                'id'      => 'new',
                'type'    => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name'    => 'new_confirm',
                'id'      => 'new_confirm',
                'type'    => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $user->id,
            );

            // render

            $this->data['judul_pendek'] = 'Ganti Password';
            $this->data['main_view']	= "dashboard/change_password";
            $this->load->view('dashboard/login', $this->data);
        }
        else
        {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('dashboard/change_password', 'refresh');
            }
        }
    }



    // ---------------------------------------------------------------------
    // ------------------------- MANAJEMEN WEBSITE -------------------------
    // ---------------------------------------------------------------------

    public function identitas()
    {
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
            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);

            if($mau_ke == "update_identitas"){

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

            }

            $this->load->view('dashboard/dashboard', $this->data);


        }
    }



    //----------------------------- Manajemen Modul Halaman-------------------------------
    public function halaman()
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
            $this->data['judul_pendek'] = 'Halaman Profil';

            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);
            $idu					= $this->uri->segment(4);
            if($mau_ke == "create"){

                $this->data['button']       = 'Tambah Data';
                $this->data['action']       = site_url('dashboard/halaman/create_action');
                $this->data['id_halaman']   = set_value('id_halaman');
                $this->data['judul']        = set_value('judul');
                $this->data['pic_halaman']  = set_value('pic_halaman');
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
                    $this->data['id_halaman']   = set_value('id_halaman', $row->id_halaman);
                    $this->data['judul']        = set_value('judul', $row->judul);
                    $this->data['pic_halaman']  = set_value('pic_halaman', $row->pic_halaman);
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
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload()){
                        $this->upload->display_errors();
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
                            'pic_halaman' => $this->upload->file_name,
                            'isi_halaman' => $this->input->post('isi_halaman',TRUE),
                            'aktif_hal' => $this->input->post('aktif_hal',TRUE)
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
                        'allowed_types' => 'jpg|jpeg|gif|png|bmp',
                        'file_ext_tolower' => TRUE,
                        'overwrite' => TRUE,
                        'max_size' => 200000,
                        'max_filename' => 0,
                        'remove_spaces' => TRUE
                    );
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload()){
                        echo $this->upload->display_errors();
                        $this->session->set_flashdata('message', $this->upload->display_errors());

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
                            'pic_halaman' => $this->upload->file_name,
                            'isi_halaman' => $this->input->post('isi_halaman',TRUE),
                            'aktif_hal' => $this->input->post('aktif_hal',TRUE)
                        );
                    }

                    $this->admin->update_halaman($this->input->post('id_halaman', TRUE), $data);
                    // $this->session->set_flashdata('message', 'Update Data Berhasil');
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
        $this->form_validation->set_rules('judul', ' ', 'trim|required');
        $this->form_validation->set_rules('pic_halaman', ' ', 'trim');
        $this->form_validation->set_rules('isi_halaman', ' ', 'trim|required');
        $this->form_validation->set_rules('aktif_hal', ' ', 'trim|required');

        $this->form_validation->set_rules('id_halaman', 'id_halaman', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }





    /*------------------------------MANAJEMEN USER-----------------------------*/
    public function users()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('dashboard/login', 'refresh');
        }
        else {

            $keyword = '';

            $config['base_url'] = base_url() . 'dashboard/users/index/';
            $config['total_rows'] = $this->admin->total_rows_users();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/users';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $users = $this->admin->index_limit_users($config['per_page'], $start);


            $this->data['users_data']   = $users;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Master User';

            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);
            $idu					= $this->uri->segment(4);
            if($mau_ke == "create"){

                $this->data['button']       = 'Tambah Data';
                $this->data['action']       = site_url('dashboard/users/create_action');
                $this->data['id_user']      = set_value('id_user');
                $this->data['username']     = set_value('username');
                $this->data['userpass']     = set_value('userpass');
                $this->data['nama_lengkap'] = set_value('nama_lengkap');
                $this->data['stts']         = set_value('stts');
                $this->data['option_stts']  = array(
                    'Administrator' => 'Administrator',
                    'User' => 'User',
                );

                $this->data['main_view']	= "dashboard/users/users_form";

            }
            elseif($mau_ke == "update"){

                $row = $this->admin->get_by_id_users($idu);

                if ($row) {

                    $this->data['button']       = 'Update Data';
                    $this->data['action']       = site_url('dashboard/users/update_action');
                    $this->data['id_user']      = set_value('id_user', $row->id_user);
                    $this->data['username']     = set_value('username', $row->username);
                    $this->data['nama_lengkap'] = set_value('nama_lengkap', $row->nama_lengkap);
                    $this->data['stts']         = set_value('stts', $row->stts);
                    $this->data['option_stts']  = array(
                        'Administrator' => 'Administrator',
                        'User' => 'User',
                    );

                    $this->data['main_view']	= "dashboard/users/users_form";
                } else {
                    $this->session->set_flashdata('message', 'Record Not Found');
                    redirect(site_url('dashboard/users'));
                }

            }
            elseif($mau_ke == "delete"){
                $row = $this->admin->get_by_id_users($idu);

                if ($row) {
                    $this->admin->delete_users($idu);
                    $this->session->set_flashdata('message', 'Hapus data berhasil.');
                    redirect(site_url('dashboard/users'));
                } else {
                    $this->session->set_flashdata('message', 'Data tidak ditemukan.');
                    redirect(site_url('dashboard/users'));
                }

            }
            elseif($mau_ke == "create_action"){
                $this->_rules_users();

                if ($this->form_validation->run() == FALSE) {
                    //$this->create();
                    redirect(site_url('dashboard/users/create'));
                } else {
                    $data = array(
                        'username' => $this->input->post('username',TRUE),
                        'userpass' => md5($this->input->post('userpass',TRUE)),
                        'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
                        'stts' => $this->input->post('stts',TRUE),
                    );

                    $this->admin->insert_users($data);
                    $this->session->set_flashdata('message', 'Tambah Data Berhasil');
                    redirect(site_url('dashboard/users'));
                }

            }
            elseif($mau_ke == "update_action"){
                $this->_rules_users();

                if ($this->form_validation->run() == FALSE) {
                    //$this->update($this->input->post('id_user', TRUE));
                    redirect(site_url('dashboard/users/update/'.$this->input->post('id_user', TRUE)));
                } else {
                    //cek apakah input password baru atau tidak
                    if (strip_tags($this->input->post('userpass', TRUE) != "")){
                        $data = array(
                            'username' => $this->input->post('username',TRUE),
                            'userpass' => md5($this->input->post('userpass',TRUE)),
                            'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
                            'stts' => $this->input->post('stts',TRUE),
                        );

                    }else {
                        $data = array(
                            'username' => $this->input->post('username',TRUE),
                            'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
                            'stts' => $this->input->post('stts',TRUE),
                        );
                    }

                    $this->admin->update_users($this->input->post('id_user', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Data Berhasil');
                    redirect(site_url('dashboard/users'));
                }

            }
            elseif($mau_ke == "search"){
                $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
                $this->load->library('pagination');

                if ($this->uri->segment(3)=='search') {
                    $config['base_url'] = base_url() . 'dashboard/users/search/' . $keyword;
                } else {
                    $config['base_url'] = base_url() . 'dashboard/users/index/';
                }

                $config['total_rows'] = $this->admin->search_total_rows_users($keyword);
                $config['per_page'] = 10;
                $config['uri_segment'] = 5;
                $config['first_url'] = base_url() . 'dashboard/users/search/'.$keyword;
                $this->pagination->initialize($config);

                $start = $this->uri->segment(5, 0);
                $users = $this->admin->search_index_limit_users($config['per_page'], $start, $keyword);

                $this->data['users_data']   = $users;
                $this->data['keyword']      = $keyword;
                $this->data['pagination']   = $this->pagination->create_links();
                $this->data['total_rows']   = $config['total_rows'];
                $this->data['start']        = $start;

                $this->data['main_view']	= "dashboard/users/users_list";

            }
            else {
                $this->data['main_view']	= "dashboard/users/users_list";
            }

            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_users()
    {
        $this->form_validation->set_rules('username', ' ', 'trim|required');
        $this->form_validation->set_rules('userpass', ' ', 'trim');
        $this->form_validation->set_rules('nama_lengkap', ' ', 'trim|required');
        $this->form_validation->set_rules('stts', ' ', 'trim|required');

        $this->form_validation->set_rules('id_user', 'id_user', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    /*------------------------------MANAJEMEN KATEGORI-----------------------------*/

    public function kategori()
    {

        if (!$this->ion_auth->logged_in())
        {
            redirect('dashboard/login', 'refresh');
        }
        else {

            $keyword = '';

            $config['base_url'] = base_url() . 'dashboard/kategori/index/';
            $config['total_rows'] = $this->admin->total_rows_kategori();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/kategori';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $kategori = $this->admin->index_limit_kategori($config['per_page'], $start);


            $this->data['kategori_data']   = $kategori;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Kategori Produk';

            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);
            $idu					= $this->uri->segment(4);

            if($mau_ke == "create"){

                $this->data['button']           = 'Tambah Data';
                $this->data['action']           = site_url('dashboard/kategori/create_action');
                $this->data['id_kategori']      = set_value('id_kategori');
                $this->data['nm_kategori']      = set_value('nm_kategori');
                $this->data['gen_kategori']     = set_value('gen_kategori');

                $this->data['option_gender']  = array(
                    'Woman' => 'Woman',
                    'Man' => 'Man',
                    'Kids' => 'Kids',
                );

                $this->data['main_view']	= "dashboard/kategori/kategori_form";

            }
            elseif($mau_ke == "update"){

                $row = $this->admin->get_by_id_kategori($idu);

                if ($row) {

                    $this->data['button']           = 'Update Data';
                    $this->data['action']           = site_url('dashboard/kategori/update_action');
                    $this->data['id_kategori']      = set_value('id_kategori', $row->id_kategori);
                    $this->data['nm_kategori']      = set_value('nm_kategori', $row->nm_kategori);
                    $this->data['gen_kategori']      = set_value('gen_kategori', $row->gen_kategori);

                    $this->data['option_gender']  = array(
                        'Woman' => 'Woman',
                        'Man' => 'Man',
                        'Kids' => 'Kids',
                    );

                    $this->data['main_view']	= "dashboard/kategori/kategori_form";
                } else {
                    $this->session->set_flashdata('message', 'Record Not Found');
                    redirect(site_url('dashboard/kategori'));
                }

            }
            elseif($mau_ke == "delete"){
                $row = $this->admin->get_by_id_kategori($idu);

                if ($row) {
                    $this->admin->delete_kategori($idu);
                    $this->session->set_flashdata('message', 'Hapus data berhasil.');
                    redirect(site_url('dashboard/kategori'));
                } else {
                    $this->session->set_flashdata('message', 'Data tidak ditemukan.');
                    redirect(site_url('dashboard/kategori'));
                }

            }
            elseif($mau_ke == "create_action"){
                $this->_rules_kategori();

                if ($this->form_validation->run() == FALSE) {
                    redirect(site_url('dashboard/kategori/create'));
                } else {
                    $data = array(
                        'nm_kategori' => $this->input->post('nm_kategori', TRUE),
                        'gen_kategori' => $this->input->post('gen_kategori', TRUE),
                        'seo_kategori' => seo_title($this->input->post('nm_kategori', TRUE)),
                        'gen_seo_kategori' => seo_title($this->input->post('gen_kategori', TRUE)),
                    );

                    $this->admin->insert_kategori($data);
                    $this->session->set_flashdata('message', 'Tambah Data Berhasil');
                    redirect(site_url('dashboard/kategori'));
                }

            }
            elseif($mau_ke == "update_action"){
                $this->_rules_kategori();

                if ($this->form_validation->run() == FALSE) {
                    redirect(site_url('dashboard/kategori/update/'.$this->input->post('id_kategori', TRUE)));
                } else {

                    $data = array(
                        'nm_kategori' => $this->input->post('nm_kategori', TRUE),
                        'gen_kategori' => $this->input->post('gen_kategori', TRUE),
                        'seo_kategori' => seo_title($this->input->post('nm_kategori', TRUE)),
                        'gen_seo_kategori' => seo_title($this->input->post('gen_kategori', TRUE)),
                    );

                    $this->admin->update_kategori($this->input->post('id_kategori', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Data Berhasil');
                    redirect(site_url('dashboard/kategori'));
                }

            }
            elseif($mau_ke == "search"){
                $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
                $this->load->library('pagination');

                if ($this->uri->segment(3)=='search') {
                    $config['base_url'] = base_url() . 'dashboard/kategori/search/' . $keyword;
                } else {
                    $config['base_url'] = base_url() . 'dashboard/kategori/index/';
                }

                $config['total_rows'] = $this->admin->search_total_rows_kategori($keyword);
                $config['per_page'] = 10;
                $config['uri_segment'] = 5;
                $config['first_url'] = base_url() . 'dashboard/kategori/search/'.$keyword;
                $this->pagination->initialize($config);

                $start = $this->uri->segment(5, 0);
                $kategori = $this->admin->search_index_limit_kategori($config['per_page'], $start, $keyword);

                $this->data['kategori_data']   = $kategori;
                $this->data['keyword']      = $keyword;
                $this->data['pagination']   = $this->pagination->create_links();
                $this->data['total_rows']   = $config['total_rows'];
                $this->data['start']        = $start;

                $this->data['main_view']	= "dashboard/kategori/kategori_list";

            }
            else {
                $this->data['main_view']	= "dashboard/kategori/kategori_list";
            }

            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_kategori()
    {
        $this->form_validation->set_rules('nm_kategori', ' ', 'trim');
        $this->form_validation->set_rules('gen_kategori', ' ', 'trim');

        $this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }



    /*--------------------------------MANAJEMEN SLIDER------------------------------------------*/
    public function slider()
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

            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);
            $idu					= $this->uri->segment(4);
            if($mau_ke == "create"){

                $this->data['button']       = 'Tambah Data';
                $this->data['action']       = site_url('dashboard/slider/create_action');
                $this->data['id_slider']    = set_value('id_slider');
                $this->data['nm_slider']    = set_value('nm_slider');
                $this->data['gambar']       = set_value('gambar');

                $this->data['main_view']	= "dashboard/slider/slider_form";

            }
            elseif($mau_ke == "update"){

                $row = $this->admin->get_by_id_slider($idu);

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

            }
            elseif($mau_ke == "delete"){
                $row = $this->admin->get_by_id_slider($idu);

                if ($row) {

                    if(!empty($row->gambar)){

                        //lokasi file secara spesifik
                        $file = './uploads/foto_slider/'.$row->gambar;
                        if (!unlink($file)){
                            $this->session->set_flashdata('message', 'File tidak dapat dihapus.');
                            redirect(site_url('dashboard/slider'));
                        } else {
                            $this->admin->delete_slider($idu);
                            $this->session->set_flashdata('message', 'Hapus data berhasil.');
                            redirect(site_url('dashboard/slider'));
                        }
                    } else {
                        $this->admin->delete_slider($idu);
                        $this->session->set_flashdata('message', 'Hapus data berhasil.');
                        redirect(site_url('dashboard/slider'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Data tidak ditemukan.');
                    redirect(site_url('dashboard/slider'));
                }

            }
            elseif($mau_ke == "create_action"){
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

            }
            elseif($mau_ke == "update_action"){
                $this->_rules_slider();

                if ($this->form_validation->run() == FALSE) {
                    redirect(site_url('dashboard/slider/update/'.$this->input->post('id_link', TRUE)));
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

            }
            elseif($mau_ke == "search"){
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

            }
            else {
                $this->data['main_view']	= "dashboard/slider/slider_list";
            }

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



    /*--------------------------------MANAJEMEN ALBUM------------------------------------------*/

    public function album()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('dashboard/login', 'refresh');
        }
        else {

            $keyword = '';

            $config['base_url'] = base_url() . 'dashboard/album/index/';
            $config['total_rows'] = $this->admin->total_rows_album();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/album';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $album = $this->admin->index_limit_album($config['per_page'], $start);


            $this->data['album_data']   = $album;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Album Galeri';

            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);
            $idu					= $this->uri->segment(4);
            if($mau_ke == "create"){

                $this->data['button']       = 'Tambah Data';
                $this->data['action']       = site_url('dashboard/album/create_action');
                $this->data['id_album']     = set_value('id_album');
                $this->data['nm_album']     = set_value('nm_album');
                $this->data['pic_album']    = set_value('pic_album');

                $this->data['main_view']	= "dashboard/album/album_form";

            }
            elseif($mau_ke == "update"){

                $row = $this->admin->get_by_id_album($idu);

                if ($row) {

                    $this->data['button']       = 'Update Data';
                    $this->data['action']       = site_url('dashboard/album/update_action');
                    $this->data['id_album']     = set_value('id_album', $row->id_album);
                    $this->data['nm_album']     = set_value('nm_album', $row->nm_album);
                    $this->data['pic_album']    = set_value('pic_album', $row->pic_album);

                    $this->data['main_view']	= "dashboard/album/album_form";
                } else {
                    $this->session->set_flashdata('message', 'Record Not Found');
                    redirect(site_url('dashboard/album'));
                }

            }
            elseif($mau_ke == "delete"){
                $row = $this->admin->get_by_id_album($idu);

                if ($row) {

                    if(!empty($row->pic_album)){

                        //lokasi file secara spesifik
                        $file = './uploads/foto_album/'.$row->pic_album;
                        if (!unlink($file)){
                            $this->session->set_flashdata('message', 'File tidak dapat dihapus.');
                            redirect(site_url('dashboard/album'));
                        } else {
                            $this->admin->delete_album($idu);
                            $this->session->set_flashdata('message', 'Hapus data berhasil.');
                            redirect(site_url('dashboard/album'));
                        }
                    } else {
                        $this->admin->delete_album($idu);
                        $this->session->set_flashdata('message', 'Hapus data berhasil.');
                        redirect(site_url('dashboard/album'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Data tidak ditemukan.');
                    redirect(site_url('dashboard/album'));
                }

            }
            elseif($mau_ke == "create_action"){
                $this->_rules_album();

                if ($this->form_validation->run() == FALSE) {
                    redirect(site_url('dashboard/album/create'));
                } else {
                    $nmfile = "file_".date('YmdHis');
                    $config = array (
                        'file_name' =>$nmfile,
                        'upload_path' => './uploads/foto_album/',
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
                            'nm_album' => $this->input->post('nm_album',TRUE),
                        );
                    } else {
                        $data = array(
                            'nm_album' => $this->input->post('nm_album',TRUE),
                            'pic_album' => $this->upload->file_name,
                        );
                    }

                    $this->admin->insert_album($data);
                    $this->session->set_flashdata('message', 'Tambah Data Berhasil');
                    redirect(site_url('dashboard/album'));
                }

            }
            elseif($mau_ke == "update_action"){
                $this->_rules_album();

                if ($this->form_validation->run() == FALSE) {
                    redirect(site_url('dashboard/album/update/'.$this->input->post('id_link', TRUE)));
                } else {

                    $nmfile = "file_".date('YmdHis');
                    $config = array (
                        'file_name' =>$nmfile,
                        'upload_path' => './uploads/foto_album/',
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
                            'nm_album' => $this->input->post('nm_album',TRUE),
                        );
                    }
                    else {
                        //delete dulu foto yang lama ---------------------------------
                        $row = $this->admin->get_by_id_album($this->input->post('id_album', TRUE));
                        if ($row) {
                            if(!empty($row->pic_album)){
                                $file = './uploads/foto_album/'.$row->pic_album;
                                unlink($file);
                            }
                        }
                        //------------------------------------------------------------
                        $data = array(
                            'nm_album' => $this->input->post('nm_album',TRUE),
                            'pic_album' => $this->upload->file_name,
                        );
                    }

                    $this->admin->update_album($this->input->post('id_album', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Data Berhasil');
                    redirect(site_url('dashboard/album'));
                }

            }
            elseif($mau_ke == "search"){
                $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
                $this->load->library('pagination');

                if ($this->uri->segment(3)=='search') {
                    $config['base_url'] = base_url() . 'dashboard/album/search/' . $keyword;
                } else {
                    $config['base_url'] = base_url() . 'dashboard/album/index/';
                }

                $config['total_rows'] = $this->admin->search_total_rows_album($keyword);
                $config['per_page'] = 10;
                $config['uri_segment'] = 5;
                $config['first_url'] = base_url() . 'dashboard/album/search/'.$keyword;
                $this->pagination->initialize($config);

                $start = $this->uri->segment(5, 0);
                $album = $this->admin->search_index_limit_album($config['per_page'], $start, $keyword);

                $this->data['album_data']   = $album;
                $this->data['keyword']      = $keyword;
                $this->data['pagination']   = $this->pagination->create_links();
                $this->data['total_rows']   = $config['total_rows'];
                $this->data['start']        = $start;

                $this->data['main_view']	= "dashboard/album/album_list";

            }
            else {
                $this->data['main_view']	= "dashboard/album/album_list";
            }

            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_album()
    {
        $this->form_validation->set_rules('nm_album', ' ', 'trim|required');
        $this->form_validation->set_rules('pic_album', ' ', 'trim');

        $this->form_validation->set_rules('id_intro', 'id_intro', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    /*------------------------------MANAJEMEN GALERI-----------------------------*/
    public function galeri()
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

            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);
            $idu					= $this->uri->segment(4);
            if($mau_ke == "create"){

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

            }
            elseif($mau_ke == "update"){

                $row = $this->admin->get_by_id_galeri($idu);

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

            }
            elseif($mau_ke == "delete"){
                $row = $this->admin->get_by_id_galeri($idu);

                if ($row) {

                    if(!empty($row->pic_galeri)){

                        //lokasi file secara spesifik
                        $file = './uploads/foto_galeri/'.$row->pic_galeri;
                        if (!unlink($file)){
                            $this->session->set_flashdata('message', 'File tidak dapat dihapus.');
                            redirect(site_url('dashboard/galeri'));
                        } else {
                            $this->admin->delete_galeri($idu);
                            $this->session->set_flashdata('message', 'Hapus data berhasil.');
                            redirect(site_url('dashboard/galeri'));
                        }
                    } else {
                        $this->admin->delete_galeri($idu);
                        $this->session->set_flashdata('message', 'Hapus data berhasil.');
                        redirect(site_url('dashboard/galeri'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Data tidak ditemukan.');
                    redirect(site_url('dashboard/galeri'));
                }

            }
            elseif($mau_ke == "create_action"){
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

            }
            elseif($mau_ke == "update_action"){
                $this->_rules_galeri();

                if ($this->form_validation->run() == FALSE) {
                    redirect(site_url('dashboard/galeri/update/'.$this->input->post('id_link', TRUE)));
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

            }
            elseif($mau_ke == "search"){
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

            }
            else {
                $this->data['main_view']	= "dashboard/galeri/galeri_list";
            }

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


    /*------------------------------MANAJEMEN FASILITAS-----------------------------*/

    public function fasilitas()
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

            //ambil variabel URL
            $mau_ke					= $this->uri->segment(3);
            $idu					= $this->uri->segment(4);

            if($mau_ke == "create"){

                $this->data['button']           = 'Tambah Data';
                $this->data['action']           = site_url('dashboard/fasilitas/create_action');
                $this->data['id_fasilitas']      = set_value('id_fasilitas');
                $this->data['nm_fasilitas']      = set_value('nm_fasilitas');

                $this->data['main_view']	= "dashboard/fasilitas/fasilitas_form";

            }
            elseif($mau_ke == "update"){

                $row = $this->admin->get_by_id_fasilitas($idu);

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

            }
            elseif($mau_ke == "delete"){
                $row = $this->admin->get_by_id_fasilitas($idu);

                if ($row) {
                    $this->admin->delete_fasilitas($idu);
                    $this->session->set_flashdata('message', 'Hapus data berhasil.');
                    redirect(site_url('dashboard/fasilitas'));
                } else {
                    $this->session->set_flashdata('message', 'Data tidak ditemukan.');
                    redirect(site_url('dashboard/fasilitas'));
                }

            }
            elseif($mau_ke == "create_action"){
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

            }
            elseif($mau_ke == "update_action"){
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

            }
            elseif($mau_ke == "search"){
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

            }
            else {
                $this->data['main_view']	= "dashboard/fasilitas/fasilitas_list";
            }

            $this->load->view('dashboard/dashboard', $this->data);

        }
    }
    function _rules_fasilitas()
    {
        $this->form_validation->set_rules('nm_fasilitas', ' ', 'trim');

        $this->form_validation->set_rules('id_fasilitas', 'id_fasilitas', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}