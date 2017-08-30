<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 16/04/2015
 * Time: 14:37
 */

if(!defined('BASEPATH'))
    exit('No direct sript access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if(!isset($_SESSION))
        {
            session_start();
        }

        // cek status login user
        if ($this->session->userdata('login') == FALSE)
        {
            redirect('dashboard/login');
        }
    }
}