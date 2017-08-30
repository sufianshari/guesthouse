<?php
/**
 * Created by PhpStorm.
 * User: Kurma Sufi
 * Date: 11/26/2015
 * Time: 10:01
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//untuk mengetahui bulan bulan
if ( ! function_exists('youtube_thumb_url'))
{
    function youtube_thumb_url($url)
    {
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            // URL is Not valid
            return false;
        }
        $domain=parse_url($url,PHP_URL_HOST);
        if($domain=='www.youtube.com' OR $domain=='youtube.com') // http://www.youtube.com/watch?v=t7rtVX0bcj8&feature=topvideos_film
        {
            if($querystring=parse_url($url,PHP_URL_QUERY))
            {
                parse_str($querystring);
                if(!empty($v)) return "http://img.youtube.com/vi/$v/0.jpg";
                else return false;
            }
            else return false;

        }
        elseif($domain == 'youtu.be') // something like http://youtu.be/t7rtVX0bcj8
        {
            $v= str_replace('/','', parse_url($url, PHP_URL_PATH));
            return (empty($v)) ? false : "http://img.youtube.com/vi/$v/0.jpg" ;
        }
        else
        {
            return false;
        }
    }
}