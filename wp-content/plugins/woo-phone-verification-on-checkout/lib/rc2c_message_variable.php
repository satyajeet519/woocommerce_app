<?php
/******************************
* SMS Variables
******************************/

if ( ! defined( 'ABSPATH' ) ) exit;

$replacements = array(
	'{name}'   		 => ucfirst($order->billing_first_name),
	'{shop_name}'    => get_bloginfo('name'),
	'{order_id}'     => $order->get_order_number(),
	'{order_amount}' => $order->get_total()
					);
