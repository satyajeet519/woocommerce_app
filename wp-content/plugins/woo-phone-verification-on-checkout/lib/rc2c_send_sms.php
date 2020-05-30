<?php
/******************************
*  Ringcaptcha Direct SMS (Notifications)
******************************/

if ( ! defined( 'ABSPATH' ) ) exit;

global $rc2c_options;

$args = array(
    'method' => 'POST',
    'timeout' => 45,
    'redirection' => 5,
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => array(),
    'body' => $data,
    'cookies' => array()
);
 
$url = 'https://api.ringcaptcha.com/'.$rc2c_options['app_key'].'/sms';
$response = wp_remote_post( $url, $args );