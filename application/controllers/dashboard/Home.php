<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 8/20/2017
 * Time: 18:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

    public $data = array(
        'main_view' => 'dashboard/home/home',
        'judul_lengkap' => 'Dashboard',
        'judul_pendek' => 'Dashboard',
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


            //Menampilkan Daftar Reservation Terbaru
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




            $this->data['main_view']	= "dashboard/home/home";
            $this->load->view('dashboard/dashboard', $this->data);
        }
    }


}