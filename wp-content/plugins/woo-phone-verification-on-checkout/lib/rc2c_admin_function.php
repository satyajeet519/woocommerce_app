<?php

/******************************
* Send SMS notifications
******************************/

if ( ! defined( 'ABSPATH' ) ) exit;

if(isset($rc2c_options['enable_text_notification']) && $rc2c_options['enable_text_notification'] == true) {
	if(isset($rc2c_options['enable_pending']) && $rc2c_options['enable_pending'] == true) {
		function rc2c_status_pending($order_id) {
			$order = new WC_Order($order_id);
				global $rc2c_options;
				// SMS Replacements Variables
				include('rc2c_message_variable.php');
				$data = array();
				$data['phone'] = $order->billing_phone;
				$data['secret_key'] = $rc2c_options['secret_key'];
				$data['message'] = str_replace(array_keys( $replacements ), $replacements, $rc2c_options['pending_message']);
				// Sends SMS using RingCaptcha API
				include('rc2c_send_sms.php');
		}
	}
	if(isset($rc2c_options['enable_failed']) && $rc2c_options['enable_failed'] == true) {
		function rc2c_status_failed($order_id) {
			$order = new WC_Order($order_id);
				global $rc2c_options;
				// SMS Replacements Variables
				include('rc2c_message_variable.php');
				$data = array();
				$data['phone'] = $order->billing_phone;
				$data['secret_key'] = $rc2c_options['secret_key'];
				$data['message'] = str_replace(array_keys( $replacements ), $replacements, $rc2c_options['failed_message']);
				// Sends SMS using RingCaptcha API
				include('rc2c_send_sms.php');
		}
	}
	if(isset($rc2c_options['enable_on_hold']) && $rc2c_options['enable_on_hold'] == true) {
		function rc2c_status_hold($order_id) {
			$order = new WC_Order($order_id);
				global $rc2c_options;
				// SMS Replacements Variables
				include('rc2c_message_variable.php');
				$data = array();
				$data['phone'] = $order->billing_phone;
				$data['secret_key'] = $rc2c_options['secret_key'];
				$data['message'] = str_replace(array_keys( $replacements ), $replacements, $rc2c_options['on_hold_message']);
				// Sends SMS using RingCaptcha API
				include('rc2c_send_sms.php');
		}
	}
	if(isset($rc2c_options['enable_processing']) && $rc2c_options['enable_processing'] == true) {
		function rc2c_status_processing($order_id) {
			$order = new WC_Order($order_id);
				global $rc2c_options;
				// SMS Replacements Variables
				include('rc2c_message_variable.php');
				$data = array();
				$data['phone'] = $order->billing_phone;
				$data['secret_key'] = $rc2c_options['secret_key'];
				$data['message'] = str_replace(array_keys( $replacements ), $replacements, $rc2c_options['processing_message']);
				// Sends SMS using RingCaptcha API
				include('rc2c_send_sms.php');
		}
	}
	if(isset($rc2c_options['enable_completed']) && $rc2c_options['enable_completed'] == true) {
		function rc2c_status_completed($order_id) {
			$order = new WC_Order($order_id);
				global $rc2c_options;
				// SMS Replacements Variables
				include('rc2c_message_variable.php');
				$data = array();
				$data['phone'] = $order->billing_phone;
				$data['secret_key'] = $rc2c_options['secret_key'];
				$data['message'] = str_replace(array_keys( $replacements ), $replacements, $rc2c_options['completed_message']);
				// Sends SMS using RingCaptcha API
				include('rc2c_send_sms.php');
		}
	}
	if(isset($rc2c_options['enable_refunded']) && $rc2c_options['enable_refunded'] == true) {
		function rc2c_status_refunded($order_id) {
			$order = new WC_Order($order_id);
				global $rc2c_options;
				//SMS Replacements Variables
				include('rc2c_message_variable.php');
				$data = array();
				$data['phone'] = $order->billing_phone;
				$data['secret_key'] = $rc2c_options['secret_key'];
				$data['message'] = str_replace(array_keys( $replacements ), $replacements, $rc2c_options['refunded_message']);
				// Sends SMS using RingCaptcha API
				include('rc2c_send_sms.php');
		}
	}
	if(isset($rc2c_options['enable_cancelled']) && $rc2c_options['enable_cancelled'] == true) {
		function rc2c_status_cancelled($order_id) {
			$order = new WC_Order($order_id);
				global $rc2c_options;
				//SMS Replacements Variables
				include('rc2c_message_variable.php');
				$data = array();
				$data['phone'] = $order->billing_phone;
				$data['secret_key'] = $rc2c_options['secret_key'];
				$data['message'] = str_replace(array_keys( $replacements ), $replacements, $rc2c_options['cancelled_message']);
				// Sends SMS using RingCaptcha API
				include('rc2c_send_sms.php');
		}
	}
	if(isset($rc2c_options['enable_admin_message']) && $rc2c_options['enable_admin_message'] == true) {
		function rc2c_send_admin_notification( $order_id ) {
			$order = new WC_Order($order_id);
				global $rc2c_options;
				//SMS Replacements Variables
				include('rc2c_message_variable.php');
				$data = array();
				$data['phone'] = $rc2c_options['admin_mobile_number'];
				$data['secret_key'] = $rc2c_options['secret_key'];
				$data['message'] = str_replace(array_keys( $replacements ), $replacements, $rc2c_options['admin_sms_message']);
				// Sends SMS using RingCaptcha API
				include('rc2c_send_sms.php');
		}
	}
}
		add_action( 'woocommerce_order_status_pending', 'rc2c_status_pending');
		add_action( 'woocommerce_order_status_failed', 'rc2c_status_failed');
		add_action( 'woocommerce_order_status_on-hold', 'rc2c_status_hold');
		add_action( 'woocommerce_order_status_processing', 'rc2c_status_processing');
		add_action( 'woocommerce_order_status_completed', 'rc2c_status_completed');
		add_action( 'woocommerce_order_status_refunded', 'rc2c_status_refunded');
		add_action( 'woocommerce_order_status_cancelled', 'rc2c_status_cancelled');
		add_action( 'woocommerce_new_order','rc2c_send_admin_notification' );
