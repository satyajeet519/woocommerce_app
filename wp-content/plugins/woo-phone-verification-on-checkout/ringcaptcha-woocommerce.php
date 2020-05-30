<?php
/*
Plugin Name: RingCaptcha - Phone Verification on Checkout & SMS Order Notifications
Plugin URI: https://wordpress.org/plugins/woo-phone-verification-on-checkout/
Description: This plugin replaces the default phone field on your WooCommerce checkout page with RingCaptcha’s phone verification widget. It also adds automated SMS notifications for both sellers and customers. For more information about <a href="https://ringcaptcha.com/" target="_blank">RingCaptcha</a> visit our site.
Version: 2.8
WC requires at least: 2.5
WC tested up to: 3.5.7
Author: RingCaptcha
Author URI: https://www.ringcaptcha.com
Text Domain: woo-phone-verification-on-checkout
Domain Path: /languages

/******************************
* global variables
******************************/

if ( ! defined( 'ABSPATH' ) ) exit;

$rc2c_prefix = 'rc2c_';
$plugin_version = '2.8';
$rc2c_plugin_name = 'RingCaptcha - Phone Verification on Checkout & SMS Order Notifications';

// retrieve our plugin settings from the options table
$rc2c_options = get_option('rc2c_settings');

/******************************
* includes
******************************/


include('lib/rc2c_admin.php'); // Admin Settings
include('lib/rc2c_admin_function.php'); // Sending Message
include('lib/rc2c_display_function.php'); // Display Funtion
load_plugin_textdomain('woo-phone-verification-on-checkout', false, basename( dirname( __FILE__ ) ) . '/languages' );

DEFINE ('PLUGIN_DIR', plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) . '/' );
