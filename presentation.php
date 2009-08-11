<?php
/*
Plugin Name: Google Presentation
Plugin URI: http://www.omerucel.com/gunluk/2009/08/11/google-presentation/
Description: A filter for wordpress. You can add Google Docs Presentation in your posts.
Version: 0.1
Author: Ömer ÜCEL
Author URI: http://www.omerucel.com/
*/

function google_presentation_callback($match)
{
    $iframe         = '<iframe src="#URL#" frameborder="0" width="#WIDTH#" height="#HEIGHT#"></iframe>';
    $present_url    = 'http://docs.google.com/present/embed?id=';
    $params         = explode(" ", rtrim($match[0], "]"));
    $url_params     = array(
        'id'        => '',
        'interval'  => '',
        'size'      => '',
        'loop'      => '',
        'autoStart' => ''
    );

    foreach($params as $key => $value){
        $param = split('=',$value);
        $url_params[$param[0]] = ereg_replace('[^a-zA-Z0-9\_]','',$param[1]);
    }

    $present_url.=$url_params['id'];
    if ($url_params['interval']!='')    $present_url.='&interval='.$url_params['interval'];
    if ($url_params['size']!='')        $present_url.='&size='.$url_params['size'];
    if ($url_params['loop']!='')        $present_url.='&loop='.$url_params['loop'];
    if ($url_params['autoStart']!='')   $present_url.='&autoStart='.$url_params['autoStart'];

    $iframe = str_replace('#URL#',$present_url,$iframe);
    if ($url_params['size']=='l'){
        $iframe = str_replace('#WIDTH#','700',$iframe);
        $iframe = str_replace('#HEIGHT#','559',$iframe);
    }else if ($url_params['size']=='m'){
        $iframe = str_replace('#WIDTH#','555',$iframe);
        $iframe = str_replace('#HEIGHT#','451',$iframe);
    }else{
        $iframe = str_replace('#WIDTH#','410',$iframe);
        $iframe = str_replace('#HEIGHT#','342',$iframe);
    }

    return ($iframe);
}

function google_presentation_plugin($content)
{
    return (preg_replace_callback('/\[presentation ([[:print:]]+)\]/', 'google_presentation_callback', $content));
}

add_filter('the_content', 'google_presentation_plugin', 1);
add_filter('the_content_rss', 'google_presentation_plugin');
add_filter('comment_text', 'google_presentation_plugin');
?>
