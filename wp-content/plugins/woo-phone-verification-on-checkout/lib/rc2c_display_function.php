<?php

/********************************************
* Add the RingCaptcha widget on checkout page
*********************************************/

function rc2c_custom_checkout_field( $fields ) {

  global $rc2c_options;
  global $rc2c_prefix;

  $gdpr_implementation = isset($rc2c_options['gdpr_implementation']) ? $rc2c_options['gdpr_implementation'] : false;
  $js_implementation = isset($rc2c_options['js_implementation']) ? $rc2c_options['js_implementation'] : false;
  $app_key = isset($rc2c_options['app_key']) ? $rc2c_options['app_key'] : '';

  $gdpr_consent_message_default = "I would like to receive discount updates and promotions in accordance with GDPR standards.";
  $gdpr_consent_message = $rc2c_options['gdpr_consent_message'] != '' ? $rc2c_options['gdpr_consent_message'] : $gdpr_consent_message_default;

  // If GDPR implementation is turned on, we embed `ringcaptcha-gdpr.js`
  if ($gdpr_implementation == true) { ?>
    <div id="widget-point"></div>
    <div style="clear:both;"></div>
    <input id="gdpr_consent" type="hidden" name="gdpr_consent" value="false">

    <?php
    if ($js_implementation == true) { ?>
      <input id="ringcaptcha_verified" type="hidden" name="ringcaptcha_verified" value="false">
      <?php
    }


//CALL helper function check_required
//give it variable
// $current_language - get_current_locale();



    wp_enqueue_script('ringcaptcha-gdpr', plugin_dir_url(__FILE__).'ringcaptcha-gdpr.js', false, false, true);
    wp_localize_script('ringcaptcha-gdpr', 'rc_options', array('app_key' => $app_key, 'js_implementation' => $js_implementation, 'gdpr_consent_message' => $gdpr_consent_message));
    wp_enqueue_script('api-ringcaptcha', 'https://s3.amazonaws.com/ringcaptcha-test/widget/ka-jquery-fix/bundle.js"', false, false, true );
  }

  // Else we only want the JS fix, we embed `ringcaptcha-verified.js`
  else if ($js_implementation == true) { ?>
    <input id="ringcaptcha_verified" type="hidden" name="ringcaptcha_verified" value="false">
    <div id="widget-point"></div>
    <div style="clear:both;"></div>
    <?php
    wp_enqueue_script('ringcaptcha-verified', plugin_dir_url(__FILE__).'ringcaptcha-verified.js', false, false, true);
    wp_localize_script('ringcaptcha-verified', 'rc_options', array('app_key' => $app_key));
    wp_enqueue_script('api-ringcaptcha', 'https://cdn.ringcaptcha.com/widget/v2/bundle.min.js', false, false, true );
  }

  // Default widget, no embed JS
  else { ?>
    <div data-widget data-app="<?php echo  $app_key; ?>" data-locale="en" data-type="dual"></div>
    <div style="clear:both;"></div>
    <?php
    wp_enqueue_script('api-ringcaptcha', 'https://cdn.ringcaptcha.com/widget/v2/bundle.min.js', false, false, true );
  }
}

add_action( 'woocommerce_checkout_billing', $rc2c_prefix .'custom_checkout_field', 15 );

function rc2c_custom_override_checkout_fields( $fields )
{

  global $rc2c_options;
  global $rc2c_prefix;

  if(isset($rc2c_options['enable']) && $rc2c_options['enable'] == true)
  {

       $fields['billing']['billing_email'] = array(

      'label'     => __('Email', 'crc2c_domain'),
      'placeholder'   => __('Email', 'placeholder', $rc2c_prefix .'domain'),
      'required'    => true,
      'clear'       => false,
      'type'        => 'text',
      'class'       => array('form-row-wide')
      );
      unset($fields['billing']['billing_phone']);


      require_once('Ringcaptcha.php');

      $app_key = isset($rc2c_options['app_key']) ? $rc2c_options['app_key'] : '';
      $secret_key = isset($rc2c_options['secret_key']) ? $rc2c_options['secret_key'] : '';
      $lib = new Ringcaptcha($app_key, $secret_key);
      //Configure to send the request using SSL.
      $lib->setSecure(true);

      // Check if all necessary fields are already filled-up
      if(!empty($_POST['billing_first_name']) || !empty($_POST['billing_last_name']) || !empty($_POST['billing_country']) || !empty($_POST['billing_address_1']) || !empty($_POST['billing_city']) || !empty($_POST['billing_state']) || !empty($_POST['billing_postcode']) || !empty($_POST['billing_email'])) {

        // Make sure user has already input phone and asked for PIN
        if (isset($_POST["ringcaptcha_session_id"]) && isset($_POST["ringcaptcha_pin_code"]) && isset($_POST["ringcaptcha_phone_number"]))
        {

          // 1. Javascript Implementation (Hosting provider has HTTP request turned off)
          if ($rc2c_options['js_implementation'] == true && $_POST['ringcaptcha_verified'] == "true") {
             $user_phone = $_POST["ringcaptcha_phone_number"];
             $file = WP_PLUGIN_DIR."/woo-phone-verification-on-checkout/phoneNumber.txt";

             file_put_contents($file, $user_phone);

          // 2. Secure implementation (/verify to RingCaptcha backend)
          } else if ($rc2c_options['js_implementation'] == false && $lib->isValid($_POST["ringcaptcha_pin_code"], $_POST["ringcaptcha_session_id"]) ) {
             // Successfull verification flow.
             $user_phone = $lib->getPhoneNumber(); //retrieve phone number
             $file = WP_PLUGIN_DIR."/woo-phone-verification-on-checkout/phoneNumber.txt";
             file_put_contents($file, $user_phone);

          // 3. Phone has not verified yet.
          } else {
             wc_add_notice( __( '<strong>Billing Phone </strong>is a required field (please verify your phone number).'), 'error', 30 );
          }

        } else {
          wc_add_notice( __( '<strong>Billing Phone </strong>is a required field (please verify your phone number).'), 'error', 30 );
        }
      }

  }

      return $fields;

}

add_filter( 'woocommerce_checkout_fields' , 'rc2c_custom_override_checkout_fields' );

// This will update meta data
function rc2c_phone_verified( $order_id ) {

  global $rc2c_options;
  global $rc2c_prefix;

  if(isset($rc2c_options['enable']) && $rc2c_options['enable'] == true) {

    $file = WP_PLUGIN_DIR."/woo-phone-verification-on-checkout/phoneNumber.txt";
    $user_phone = file_get_contents($file);
    $Phone = '_billing_phone';

    update_post_meta( $order_id, $Phone, $user_phone );
    unlink($file);
  }
}

function rc2c_gdpr_meta( $order_id ) {
    $order = wc_get_order( $order_id );
    $order->update_meta_data( 'gdpr_consent', $_POST['gdpr_consent'] );
    $order->save();
}

function widget_enqueue() {
  wp_enqueue_script('api-ringcaptcha', 'https://cdn.ringcaptcha.com/widget/v2/bundle.min.js', false, false, true);
}

function dc_enqueue() {
  global $rc2c_options;

  wp_enqueue_script('ringcaptcha-verified', plugin_dir_url(__FILE__).'ringcaptcha-verified.js', false, false, true);
  wp_localize_script('ringcaptcha-verified', 'rc_options', array('app_key' => $rc2c_options['app_key']));
}

add_action( 'woocommerce_checkout_update_order_meta', 'rc2c_phone_verified' );
add_action( 'woocommerce_checkout_update_order_meta', 'rc2c_gdpr_meta' );
