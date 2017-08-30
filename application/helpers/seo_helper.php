<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 15/06/2015
 * Time: 16:03
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('seo_title'))
{
    function seo_title($s) {
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');

        $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d

        $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
        return $s;
    }
}