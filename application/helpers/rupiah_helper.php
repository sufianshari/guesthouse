<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 15/06/2015
 * Time: 16:03
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//untuk mengetahui bulan bulan
if ( ! function_exists('format_rupiah'))
{
    function format_rupiah($angka){
        $rupiah=number_format($angka,0,',','.');
        return $rupiah;
    }
}