<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://coderockz.com
 * @since      1.0.0
 *
 * @package    Coderockz_Woo_Delivery
 * @subpackage Coderockz_Woo_Delivery/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Coderockz_Woo_Delivery
 * @subpackage Coderockz_Woo_Delivery/admin
 * @author     CodeRockz <admin@coderockz.com>
 */
class Coderockz_Woo_Delivery_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public $helper;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->helper = new Coderockz_Woo_Delivery_Helper();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Coderockz_Woo_Delivery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Coderockz_Woo_Delivery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'select2mincss', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( "flatpickr_css", CODEROCKZ_WOO_DELIVERY_URL . 'public/css/flatpickr.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/coderockz-woo-delivery-admin.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Coderockz_Woo_Delivery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Coderockz_Woo_Delivery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'jquery-effects-slide' );
		wp_enqueue_script( "animejs", plugin_dir_url( __FILE__ ) . 'js/anime.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( "flatpickr_js", CODEROCKZ_WOO_DELIVERY_URL . 'public/js/flatpickr.min.js', [], $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/coderockz-woo-delivery-admin.js', array( 'jquery', 'animejs', 'selectWoo', 'flatpickr_js' ), $this->version, true );
		$coderockz_woo_delivery_nonce = wp_create_nonce('coderockz_woo_delivery_nonce');
	        wp_localize_script($this->plugin_name, 'coderockz_woo_delivery_ajax_obj', array(
	            'coderockz_woo_delivery_ajax_url' => admin_url('admin-ajax.php'),
	            'nonce' => $coderockz_woo_delivery_nonce,
	        ));

	}

	public function coderockz_woo_delivery_menus_sections() {

        add_menu_page(
			__('Woo Delivery', 'coderockz-woo-delivery'),
            __('Woo Delivery', 'coderockz-woo-delivery'),
			'manage_options',
			'coderockz-woo-delivery-settings',
			array($this, "coderockz_woo_delivery_main_layout"),
			"dashicons-cart",
			null
		);

    }

	public function coderockz_woo_delivery_settings_link( $links ) {
    	if ( array_key_exists( 'deactivate', $links ) ) {
			$links['deactivate'] = str_replace( '<a', '<a class="coderockz-woo-delivery-deactivate-link"', $links['deactivate'] );
		}
        $links[] = '<a href="admin.php?page=coderockz-woo-delivery-settings">Settings</a>';
        return $links;
    }

    public function coderockz_woo_delivery_process_delivery_timezone_form() { 
    	check_ajax_referer('coderockz_woo_delivery_nonce');
		parse_str( $_POST[ 'dateFormData' ], $date_form_data );
		$timezone_form_settings = [];

		$store_location_timezone = sanitize_text_field($date_form_data['coderockz_delivery_time_timezone']);

		$timezone_form_settings['store_location_timezone'] = $store_location_timezone;


		if(get_option('coderockz_woo_delivery_time_settings') == false) {
			update_option('coderockz_woo_delivery_time_settings', $timezone_form_settings);
		} else {
			$timezone_form_settings = array_merge(get_option('coderockz_woo_delivery_time_settings'),$timezone_form_settings);
			update_option('coderockz_woo_delivery_time_settings', $timezone_form_settings);
		}

		wp_send_json_success();
	}
    
    public function coderockz_woo_delivery_process_delivery_date_form() { 
    	check_ajax_referer('coderockz_woo_delivery_nonce');
		
		$date_form_settings = [];

		parse_str( $_POST[ 'dateFormData' ], $date_form_data );

		$enable_delivery_date = !isset($date_form_data['coderockz_enable_delivery_date']) ? false : true;
		
		$delivery_date_mandatory = !isset($date_form_data['coderockz_delivery_date_mandatory']) ? false : true;
		
		$delivery_date_field_label = sanitize_text_field($date_form_data['coderockz_delivery_date_field_label']);
		
		$delivery_date_selectable_date = sanitize_text_field($date_form_data['coderockz_delivery_date_selectable_date']);
		
		$delivery_date_format = sanitize_text_field($date_form_data['coderockz_delivery_date_format']);

		$auto_select_first_date = !isset($date_form_data['coderockz_auto_select_first_date']) ? false : true;
		
		$delivery_week_starts_from = sanitize_text_field($date_form_data['coderockz_delivery_date_week_starts_from']);
		
		$delivery_date_delivery_days="";
		if(isset($date_form_data['coderockz_delivery_date_delivery_days'])) {
			$delivery_days = $this->helper->coderockz_woo_delivery_array_sanitize($date_form_data['coderockz_delivery_date_delivery_days']);
			$delivery_date_delivery_days = implode(',', $delivery_days);
		}
		

		$date_form_settings['enable_delivery_date'] = $enable_delivery_date;
		$date_form_settings['delivery_date_mandatory'] = $delivery_date_mandatory;
		$date_form_settings['field_label'] = $delivery_date_field_label;
		$date_form_settings['selectable_date'] = $delivery_date_selectable_date;
		$date_form_settings['date_format'] = $delivery_date_format;
		$date_form_settings['auto_select_first_date'] = $auto_select_first_date;
		$date_form_settings['delivery_days'] = $delivery_date_delivery_days;
		$date_form_settings['week_starts_from'] = $delivery_week_starts_from;
		
		if(get_option('coderockz_woo_delivery_date_settings') == false) {
			update_option('coderockz_woo_delivery_date_settings', $date_form_settings);
		} else {
			$date_form_settings = array_merge(get_option('coderockz_woo_delivery_date_settings'),$date_form_settings);
			update_option('coderockz_woo_delivery_date_settings', $date_form_settings);
		}
		wp_send_json_success();
		
    }

    public function coderockz_woo_delivery_process_delivery_date_offdays_form() { 
    	check_ajax_referer('coderockz_woo_delivery_nonce');
    	$year_array = [];
    	$offdays_array = [];
    	parse_str( $_POST[ 'dateFormData' ], $date_form_data );
    	foreach($date_form_data as $key => $value) {
		    if (strpos($key, 'coderockz_woo_delivery_offdays_year_') === 0) {
		        array_push($year_array,sanitize_text_field($value));
		    }
		}
		foreach($year_array as $year) {
			$offdays_months = $this->helper->coderockz_woo_delivery_array_sanitize($date_form_data["coderockz_woo_delivery_offdays_month_".$year]);
			if(!empty($offdays_months)){
				foreach($offdays_months as $offdays_month) {
					if($offdays_month != "") {
						$offdays_days = sanitize_text_field($date_form_data["coderockz_woo_delivery_offdays_dates_".$offdays_month."_".$year]);
						if(isset($offdays_days) && $offdays_days != "") {
							$formated_offdays = [];
							$offdays_days = explode(',', $offdays_days);
							foreach($offdays_days as $offdays_day) {
								$formated_offdays[] = sprintf("%02d", $offdays_day);
							}
							$formated_offdays = implode(',', $formated_offdays);
							$offdays_array[$year][$offdays_month] = $formated_offdays;
						}	
					}
				}
			}
			
		}
		$date_form_settings['off_days'] = $offdays_array;
		if(get_option('coderockz_woo_delivery_date_settings') == false) {
			update_option('coderockz_woo_delivery_date_settings', $date_form_settings);
		} else {
			$date_form_settings = array_merge(get_option('coderockz_woo_delivery_date_settings'),$date_form_settings);
			update_option('coderockz_woo_delivery_date_settings', $date_form_settings);
		}
		wp_send_json_success();
		
    }

    public function coderockz_woo_delivery_process_delivery_time_form() { 
    	check_ajax_referer('coderockz_woo_delivery_nonce');
		parse_str( $_POST[ 'dateFormData' ], $date_form_data );
		$time_form_settings = [];
		$enable_delivery_time = !isset($date_form_data['coderockz_enable_delivery_time']) ? false : true;
		$delivery_time_mandatory = !isset($date_form_data['coderockz_delivery_time_mandatory']) ? false : true;
		$delivery_time_field_label = sanitize_text_field($date_form_data['coderockz_delivery_time_field_label']);
		$disable_current_time_slot = !isset($date_form_data['coderockz_delivery_time_disable_current_time_slot']) ? false : true;
		$delivery_time_format = sanitize_text_field($date_form_data['coderockz_delivery_time_format']);
		$delivery_time_maximum_order = sanitize_text_field($date_form_data['coderockz_delivery_time_maximum_order']);
		$auto_select_first_time = !isset($date_form_data['coderockz_auto_select_first_time']) ? false : true;
		$delivery_time_slot_starts_hour = (isset($date_form_data['coderockz_delivery_time_slot_starts_hour']) && $date_form_data['coderockz_delivery_time_slot_starts_hour'] !="") ? sanitize_text_field($date_form_data['coderockz_delivery_time_slot_starts_hour']) : "0";
		
		$delivery_time_slot_starts_min = (isset($date_form_data['coderockz_delivery_time_slot_starts_min']) && $date_form_data['coderockz_delivery_time_slot_starts_min'] !="") ? sanitize_text_field($date_form_data['coderockz_delivery_time_slot_starts_min']) : "0"; 

		$delivery_time_slot_starts_format = sanitize_text_field($date_form_data['coderockz_delivery_time_slot_starts_format']);
		if($delivery_time_slot_starts_format == "am") {
			$delivery_time_slot_starts_hour = ($delivery_time_slot_starts_hour == "12") ? "0" : $delivery_time_slot_starts_hour;
			$delivery_time_slot_starts = ((int)$delivery_time_slot_starts_hour * 60) + (int)$delivery_time_slot_starts_min;
		} else {
			$delivery_time_slot_starts_hour = ($delivery_time_slot_starts_hour == "12") ? "0" : $delivery_time_slot_starts_hour;
			$delivery_time_slot_starts = (((int)$delivery_time_slot_starts_hour + 12)*60) + (int)$delivery_time_slot_starts_min;
		}

		$delivery_time_slot_ends_hour = (isset($date_form_data['coderockz_delivery_time_slot_ends_hour']) && $date_form_data['coderockz_delivery_time_slot_ends_hour'] !="") ? sanitize_text_field($date_form_data['coderockz_delivery_time_slot_ends_hour']) : "0";
		
		$delivery_time_slot_ends_min = (isset($date_form_data['coderockz_delivery_time_slot_ends_min']) && $date_form_data['coderockz_delivery_time_slot_ends_min'] !="") ? sanitize_text_field($date_form_data['coderockz_delivery_time_slot_ends_min']) : "0"; 

		$delivery_time_slot_ends_format = sanitize_text_field($date_form_data['coderockz_delivery_time_slot_ends_format']);

		if($delivery_time_slot_ends_format == "am") {
			$delivery_time_slot_ends_hour_12 = ($delivery_time_slot_ends_hour == "12") ? "0" : $delivery_time_slot_ends_hour;
			$delivery_time_slot_ends = ((int)$delivery_time_slot_ends_hour_12 * 60) + (int)$delivery_time_slot_ends_min;
		} else {
			$delivery_time_slot_ends_hour = ($delivery_time_slot_ends_hour == "12") ? "0" : $delivery_time_slot_ends_hour;
			$delivery_time_slot_ends = (((int)$delivery_time_slot_ends_hour + 12)*60) + (int)$delivery_time_slot_ends_min;
		}

		if($delivery_time_slot_ends_format == "am" && $delivery_time_slot_ends_hour == "12" && ($delivery_time_slot_ends_min =="0"||$delivery_time_slot_ends_min =="00")) {
				$delivery_time_slot_ends = 1440;
		}

		$delivery_time_slot_duration_time = (isset($date_form_data['coderockz_delivery_time_slot_duration_time']) && $date_form_data['coderockz_delivery_time_slot_duration_time'] !="") ? sanitize_text_field($date_form_data['coderockz_delivery_time_slot_duration_time']) : "0";
		$delivery_time_slot_duration_format = sanitize_text_field($date_form_data['coderockz_delivery_time_slot_duration_format']);

		if($delivery_time_slot_duration_format == "hour") {
			$each_time_slot = (int)$delivery_time_slot_duration_time * 60;
			$each_time_slot = $each_time_slot != 0 ? $each_time_slot : "";
		} else {
			$each_time_slot = (int)$delivery_time_slot_duration_time;
			$each_time_slot = $each_time_slot != 0 ? $each_time_slot : "";
		}

		$time_form_settings['enable_delivery_time'] = $enable_delivery_time;
		$time_form_settings['delivery_time_mandatory'] = $delivery_time_mandatory;
		$time_form_settings['field_label'] = $delivery_time_field_label;
		$time_form_settings['time_format'] = $delivery_time_format;
		$time_form_settings['delivery_time_starts'] = (string)$delivery_time_slot_starts;
		$time_form_settings['delivery_time_ends'] = (string)$delivery_time_slot_ends;
		$time_form_settings['each_time_slot'] = (string)$each_time_slot;
		$time_form_settings['max_order_per_slot'] = $delivery_time_maximum_order;
		$time_form_settings['disabled_current_time_slot'] = $disable_current_time_slot;
		$time_form_settings['auto_select_first_time'] = $auto_select_first_time;

		if(get_option('coderockz_woo_delivery_time_settings') == false) {
			update_option('coderockz_woo_delivery_time_settings', $time_form_settings);
		} else {
			$time_form_settings = array_merge(get_option('coderockz_woo_delivery_time_settings'),$time_form_settings);
			update_option('coderockz_woo_delivery_time_settings', $time_form_settings);
		}

		wp_send_json_success();
	}

	public function coderockz_woo_delivery_process_localization_settings() { 
    	check_ajax_referer('coderockz_woo_delivery_nonce');
		
		$localization_settings_form_settings = [];

		parse_str( $_POST[ 'formData' ], $form_data );
		
		$order_limit_notice = sanitize_text_field($form_data['coderockz_woo_delivery_order_limit_notice']);
		$delivery_details_text = sanitize_text_field($form_data['coderockz_woo_delivery_delivery_details_text']);
		$order_metabox_heading = sanitize_text_field($form_data['coderockz_woo_delivery_order_metabox_heading']);

		$checkout_date_notice = sanitize_text_field($form_data['coderockz_woo_delivery_checkout_date_notice']);
		$checkout_time_notice = sanitize_text_field($form_data['coderockz_woo_delivery_checkout_time_notice']);

		$localization_settings_form_settings['order_limit_notice'] = $order_limit_notice;
		$localization_settings_form_settings['delivery_details_text'] = $delivery_details_text;
		$localization_settings_form_settings['order_metabox_heading'] = $order_metabox_heading;
		$localization_settings_form_settings['checkout_date_notice'] = $checkout_date_notice;
		$localization_settings_form_settings['checkout_time_notice'] = $checkout_time_notice;

		
		if(get_option('coderockz_woo_delivery_localization_settings') == false) {
			update_option('coderockz_woo_delivery_localization_settings', $localization_settings_form_settings);
		} else {
			$localization_settings_form_settings = array_merge(get_option('coderockz_woo_delivery_localization_settings'),$localization_settings_form_settings);
			update_option('coderockz_woo_delivery_localization_settings', $localization_settings_form_settings);
		}
		wp_send_json_success();
		
    }


    public function coderockz_woo_delivery_process_other_settings() { 
    	check_ajax_referer('coderockz_woo_delivery_nonce');
		
		$other_settings_form_settings = [];

		parse_str( $_POST[ 'dateFormData' ], $date_form_data );
		
		$field_position = sanitize_text_field($date_form_data['coderockz_woo_delivery_field_position']);
		$other_settings_form_settings['field_position'] = $field_position;

		$coderockz_disable_fields_for_downloadable_products = !isset($date_form_data['coderockz_disable_fields_for_downloadable_products']) ? false : true;

		$other_settings_form_settings['disable_fields_for_downloadable_products'] = $coderockz_disable_fields_for_downloadable_products;

		
		if(get_option('coderockz_woo_delivery_other_settings') == false) {
			update_option('coderockz_woo_delivery_other_settings', $other_settings_form_settings);
		} else {
			$other_settings_form_settings = array_merge(get_option('coderockz_woo_delivery_other_settings'),$other_settings_form_settings);
			update_option('coderockz_woo_delivery_other_settings', $other_settings_form_settings);
		}
		wp_send_json_success();
		
    }

    /**
	 * Add custom column in orders page in admin panel
	*/
	public function coderockz_woo_delivery_add_custom_fields_orders_list($columns) {
		
		$delivery_details_text = (isset(get_option('coderockz_woo_delivery_localization_settings')['delivery_details_text']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['delivery_details_text'])) ? get_option('coderockz_woo_delivery_localization_settings')['delivery_details_text'] : "Delivery Details";

		$new_columns = [];

		foreach($columns as $name => $value)
		{
			$new_columns[$name] = $value;

			if($name == 'order_status') {
				$new_columns['order_delivery_details'] = $delivery_details_text;
			}
		}
		return $new_columns;
	}

	public function coderockz_woo_delivery_show_custom_fields_data_orders_list($column) {
		global $post;

		$delivery_date_settings = get_option('coderockz_woo_delivery_date_settings');			
		$delivery_time_settings = get_option('coderockz_woo_delivery_time_settings');

		$delivery_date_field_label = (isset($delivery_date_settings['field_label']) && !empty($delivery_date_settings['field_label'])) ? $delivery_date_settings['field_label'] : "Delivery Date";
		$delivery_time_field_label = (isset($delivery_time_settings['field_label']) && !empty($delivery_time_settings['field_label'])) ? $delivery_time_settings['field_label'] : "Delivery Time";
		$delivery_date_format = (isset($delivery_date_settings['date_format']) && !empty($delivery_date_settings['date_format'])) ? $delivery_date_settings['date_format'] : "F j, Y";

		// if any timezone data is saved, set default timezone with the data
		$timezone = $this->helper->get_the_timezone();
		date_default_timezone_set($timezone);

		$time_format = (isset($delivery_time_settings['time_format']) && !empty($delivery_time_settings['time_format']))?$delivery_time_settings['time_format']:"12";
		if($time_format == 12) {
			$time_format = "h:i A";
		} elseif ($time_format == 24) {
			$time_format = "H:i";
		}

		if($column == 'order_delivery_details')
		{
			if(metadata_exists('post', $post->ID, 'delivery_date') && get_post_meta($post->ID, 'delivery_date', true) !="")
			{
				echo $delivery_date_field_label.": " . date($delivery_date_format, get_post_meta( $post->ID, 'delivery_date', true ));
			}

			if(metadata_exists('post', $post->ID, 'delivery_time') && get_post_meta($post->ID, 'delivery_time', true) !="")
			{
				echo " <br > ";
				$times = get_post_meta($post->ID,"delivery_time",true);
				$minutes = explode(',', $times);

				if($time_format == "H:i" && $minutes[1] == 1440){
    				echo $delivery_time_field_label.": " . date($time_format, mktime(0, (int)$minutes[0])) . ' - ' . "24:00";
    			} else {
    				echo $delivery_time_field_label.": " . date($time_format, mktime(0, (int)$minutes[0])) . ' - ' . date($time_format, mktime(0, (int)$minutes[1]));
    			}
			}
		}
	}

	public function coderockz_woo_delivery_information_after_shipping_address($order){
	    
	    $delivery_date_settings = get_option('coderockz_woo_delivery_date_settings');			
		$delivery_time_settings = get_option('coderockz_woo_delivery_time_settings');

		$delivery_date_field_label = (isset($delivery_date_settings['field_label']) && !empty($delivery_date_settings['field_label'])) ? $delivery_date_settings['field_label'] : "Delivery Date";
		$delivery_time_field_label = (isset($delivery_time_settings['field_label']) && !empty($delivery_time_settings['field_label'])) ? $delivery_time_settings['field_label'] : "Delivery Time";
		$delivery_date_format = (isset($delivery_date_settings['date_format']) && !empty($delivery_date_settings['date_format'])) ? $delivery_date_settings['date_format'] : "F j, Y";


		// if any timezone data is saved, set default timezone with the data
		$timezone = $this->helper->get_the_timezone();
		date_default_timezone_set($timezone);

		$time_format = (isset($delivery_time_settings['time_format']) && !empty($delivery_time_settings['time_format']))?$delivery_time_settings['time_format']:"12";
		if($time_format == 12) {
			$time_format = "h:i A";
		} elseif ($time_format == 24) {
			$time_format = "H:i";
		}

		if( version_compare( get_option( 'woocommerce_version' ), '3.0.0', ">=" ) ) {            
	        $order_id = $order->get_id();
	    } else {
	        $order_id = $order->id;
	    }
	    if(metadata_exists('post', $order_id, 'delivery_date') && get_post_meta($order_id, 'delivery_date', true) !="") {
	    	echo '<p><strong>'.$delivery_date_field_label.':</strong> ' . date($delivery_date_format, get_post_meta( $order_id, 'delivery_date', true )) . '</p>';
	    }

	    if(metadata_exists('post', $order_id, 'delivery_time') && get_post_meta($order_id, 'delivery_time', true) !="") {
	    	$minutes = get_post_meta($order_id,"delivery_time",true);
	    	$minutes = explode(',', $minutes);

	    	if($time_format == "H:i" && $minutes[1] == 1440){
				echo '<p><strong>'.$delivery_time_field_label.':</strong> ' . date($time_format, mktime(0, (int)$minutes[0])) . ' - ' . '24:00' . '</p>';
			} else {
				echo '<p><strong>'.$delivery_time_field_label.':</strong> ' . date($time_format, mktime(0, (int)$minutes[0])) . ' - ' . date($time_format, mktime(0, (int)$minutes[1])) . '</p>';
			}
	    }
	    
	}

	public function coderockz_woo_delivery_review_notice() {
	    $options = get_option('coderockz_woo_delivery_review_notice');

	    $activation_time = get_option('coderockz-woo-delivery-activation-time');

	    $notice = '<div class="coderockz-woo-delivery-review-notice notice notice-success is-dismissible">';
        $notice .= '<img class="coderockz-woo-delivery-review-notice-left" src="'.CODEROCKZ_WOO_DELIVERY_URL.'admin/images/woo-delivery-logo.png" alt="coderockz-woo-delivery">';
        $notice .= '<div class="coderockz-woo-delivery-review-notice-right">';
        $notice .= '<p><b>We have worked relentlessly to develop the plugin and it would really appreciate us if you dropped a short review about the plugin. Your review means a lot to us and we are working to make the plugin more awesome. Thanks for using WooCommerce Delivery Date & Time.</b></p>';
        $notice .= '<ul>';
        $notice .= '<li><a val="later" href="#">Remind me later</a></li>';
        $notice .= '<li><a style="font-weight:bold;" val="given" href="#" target="_blank">Review Here</a></li>';
		$notice .= '<li><a val="never" href="#">I would not</a></li>';	        
        $notice .= '</ul>';
        $notice .= '</div>';
        $notice .= '</div>';
        
	    if(!$options && time()>= $activation_time + (60*60*24*15)){
	        echo $notice;
	    } else if(is_array($options)) {
	        if((!array_key_exists('review_notice',$options)) || ($options['review_notice'] =='later' && time()>=($options['updated_at'] + (60*60*24*30) ))){
	            echo $notice;
	        }
	    }
	}

	public function coderockz_woo_delivery_save_review_notice() {
	    $notice = sanitize_text_field($_POST['notice']);
	    $value = array();
	    $value['review_notice'] = $notice;
	    $value['updated_at'] = time();

	    update_option('coderockz_woo_delivery_review_notice',$value);
	    wp_send_json_success($value);
	}

	public function coderockz_woo_delivery_get_deactivate_reasons() {

		$reasons = array(
			array(
				'id'          => 'could-not-understand',
				'text'        => 'I couldn\'t understand how to make it work',
				'type'        => 'textarea',
				'placeholder' => 'Would you like us to assist you?'
			),
			array(
				'id'          => 'found-better-plugin',
				'text'        => 'I found a better plugin',
				'type'        => 'text',
				'placeholder' => 'Which plugin?'
			),
			array(
				'id'          => 'not-have-that-feature',
				'text'        => 'I need specific feature that you don\'t support',
				'type'        => 'textarea',
				'placeholder' => 'Could you tell us more about that feature?'
			),
			array(
				'id'          => 'is-not-working',
				'text'        => 'The plugin is not working',
				'type'        => 'textarea',
				'placeholder' => 'Could you tell us a bit more whats not working?'
			),
			array(
				'id'          => 'temporary-deactivation',
				'text'        => 'It\'s a temporary deactivation',
				'type'        => '',
				'placeholder' => ''
			),
			array(
				'id'          => 'other',
				'text'        => 'Other',
				'type'        => 'textarea',
				'placeholder' => 'Could you tell us a bit more?'
			),
		);

		return $reasons;
	}

	public function coderockz_woo_delivery_deactivate_reason_submission(){
		check_ajax_referer('coderockz_woo_delivery_nonce');
		global $wpdb;

		if ( ! isset( $_POST['reason_id'] ) ) { // WPCS: CSRF ok, Input var ok.
			wp_send_json_error();
		}

		$current_user = new WP_User(get_current_user_id());

		$data = array(
			'reason_id'     => sanitize_text_field( $_POST['reason_id'] ), // WPCS: CSRF ok, Input var ok.
			'plugin'        => "Woo Delivery Free",
			'url'           => home_url(),
			'user_email'    => "",
			'user_name'     => "",
			'reason_info'   => isset( $_REQUEST['reason_info'] ) ? trim( stripslashes( $_REQUEST['reason_info'] ) ) : '',
			'software'      => $_SERVER['SERVER_SOFTWARE'],
			'date'			=> time(),
			'php_version'   => phpversion(),
			'mysql_version' => $wpdb->db_version(),
			'wp_version'    => get_bloginfo( 'version' )
		);


		$this->coderockz_woo_delivery_deactivate_send_request( $data);
		wp_send_json_success();

	}

	public function coderockz_woo_delivery_deactivate_send_request( $params) {
		$api_url = "https://coderockz.com/wp-json/coderockz-api/v1/deactivation-reason";
		return  wp_remote_post($api_url, array(
				'method'      => 'POST',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => false,
				'headers'     => array( 'user-agent' => 'WooDelivery/' . md5( esc_url( home_url() ) ) . ';' ),
				'body'        => $params,
				'cookies'     => array()
			)
		);
	}

	public function coderockz_woo_delivery_deactivate_scripts() {

		global $pagenow;

		if ( 'plugins.php' != $pagenow ) {
			return;
		}

		$reasons = $this->coderockz_woo_delivery_get_deactivate_reasons();
		?>
		<!--pop up modal-->
		<div class="coderockz_woo_delivery_deactive_plugin-modal" id="coderockz_woo_delivery_deactive_plugin-modal">
			<div class="coderockz_woo_delivery_deactive_plugin-modal-wrap">
				<div class="coderockz_woo_delivery_deactive_plugin-modal-header">
					<h2 style="margin:0;"><span class="dashicons dashicons-testimonial"></span><?php _e( ' QUICK FEEDBACK' ); ?></h2>
				</div>

				<div class="coderockz_woo_delivery_deactive_plugin-modal-body">
					<p style="font-size:15px;font-weight:bold"><?php _e( 'If you have a moment, please share why you are deactivating Our plugin', 'coderockz-woo-delivery' ); ?></p>
					<ul class="reasons">
						<?php foreach ($reasons as $reason) { ?>
							<li data-type="<?php echo esc_attr( $reason['type'] ); ?>" data-placeholder="<?php echo esc_attr( $reason['placeholder'] ); ?>">
								<label><input type="radio" name="selected-reason" value="<?php echo $reason['id']; ?>"> <?php echo $reason['text']; ?></label>
							</li>
						<?php } ?>
					</ul>
				</div>

				<div class="coderockz_woo_delivery_deactive_plugin-modal-footer">
					<a href="#" class="coderockz-woo-delivery-skip-deactivate"><?php _e( 'Skip & Deactivate', 'coderockz-woo-delivery' ); ?></a>
					<div style="float:left">
					<button class="coderockz-woo-delivery-deactivate-button button-primary"><?php _e( 'Submit & Deactivate', 'coderockz-woo-delivery' ); ?></button>
					<button class="coderockz-woo-delivery-cancel-button button-secondary"><?php _e( 'Cancel', 'coderockz-woo-delivery' ); ?></button>
					</div>
				</div>
			</div>
		</div>

		<?php
	}


	public function coderockz_woo_delivery_custom_meta_box() {
		$order_metabox_heading = (isset(get_option('coderockz_woo_delivery_localization_settings')['order_metabox_heading']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['order_metabox_heading'])) ? get_option('coderockz_woo_delivery_localization_settings')['order_metabox_heading'] : "Delivery Date & Time";
		add_meta_box( 'coderockz_woo_delivery_meta_box', __($order_metabox_heading,'coderockz-woo-delivery'), array($this,"coderockz_woo_delivery_meta_box_markup"), 'shop_order', 'normal', 'default', null );
	}

	public function coderockz_woo_delivery_meta_box_markup() {
		global $post;
		$delivery_date_settings = get_option('coderockz_woo_delivery_date_settings');
		$delivery_time_settings = get_option('coderockz_woo_delivery_time_settings');
		// if any timezone data is saved, set default timezone with the data
		$timezone = $this->helper->get_the_timezone();
		date_default_timezone_set($timezone);

		$enable_delivery_date = (isset($delivery_date_settings['enable_delivery_date']) && !empty($delivery_date_settings['enable_delivery_date'])) ? $delivery_date_settings['enable_delivery_date'] : false;
		$off_days = (isset($delivery_date_settings['off_days']) && !empty($delivery_date_settings['off_days'])) ? $delivery_date_settings['off_days'] : array();

		$delivery_days = isset($delivery_date_settings['delivery_days']) && $delivery_date_settings['delivery_days'] != "" ? $delivery_date_settings['delivery_days'] : "6,0,1,2,3,4,5";


		$delivery_date_field_label = (isset($delivery_date_settings['field_label']) && !empty($delivery_date_settings['field_label'])) ? $delivery_date_settings['field_label'] : "Delivery Date";
		$delivery_date_mandatory = (isset($delivery_date_settings['delivery_date_mandatory']) && !empty($delivery_date_settings['delivery_date_mandatory'])) ? $delivery_date_settings['delivery_date_mandatory'] : false;
		$delivery_date_format = (isset($delivery_date_settings['date_format']) && !empty($delivery_date_settings['date_format'])) ? $delivery_date_settings['date_format'] : "F j, Y";
		$week_starts_from = (isset($delivery_date_settings['week_starts_from']) && !empty($delivery_date_settings['week_starts_from']))?$delivery_date_settings['week_starts_from']:"0";
		
		$order_limit_notice = (isset(get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice'])) ? "(".get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice'].")" : "(Maximum Order Limit Exceed)";

		$selectable_date = "365";

		$product_cat = [];
		// get categories from order products
		$disable_dates = [];
		$disable_week_days = [];

		$delivery_days = explode(',', $delivery_days);

		$selectable_start_date = date('Y-m-d H:i:s', time());
		$start_date = new DateTime($selectable_start_date);

		if(count($delivery_days)) {
			$week_days = ['0', '1', '2', '3', '4', '5', '6'];
			$ignore_days = array_diff($week_days, $delivery_days);

			$ignore_week_days = [];

			foreach ($week_days as $key => $week_day)
			{
				if(in_array($week_day, $ignore_days))
				{
					$ignore_week_days[] = $week_day;
				}
			}

			$disable_week_days = $ignore_week_days;
		}

		if(count($off_days)) {
			$date = $start_date;
			foreach ($off_days as $year => $months) {
				foreach($months as $month =>$days){
					$days = explode(',', $days);
					foreach($days as $day){
						$disable_dates[] = $year . "-" . date('m',strtotime($month)) . "-" .$day;
					}
				}
			}
		}

		$disable_dates = array_unique($disable_dates, false);
		$disable_dates = array_values($disable_dates);


		$enable_delivery_time = (isset($delivery_time_settings['enable_delivery_time']) && !empty($delivery_time_settings['enable_delivery_time'])) ? $delivery_time_settings['enable_delivery_time'] : false;
		$time_format = (isset($delivery_time_settings['time_format']) && !empty($delivery_time_settings['time_format']))?$delivery_time_settings['time_format']:"12";
		if($time_format == 12) {
			$time_format = "h:i A";
		} elseif ($time_format == 24) {
			$time_format = "H:i";
		}

	    if(metadata_exists('post', $post->ID, 'delivery_date')) {
	    	$delivery_date = date($delivery_date_format, get_post_meta(  $post->ID, 'delivery_date', true ));
	    } else {
	    	$delivery_date="";
	    }

	    $disable_week_days = implode(",",$disable_week_days);
	    $disable_dates = implode("::",$disable_dates);

	    $time_options = Coderockz_Woo_Delivery_Time_Option::delivery_time_option($delivery_time_settings,"meta_box");

	    if(metadata_exists('post', $post->ID, 'delivery_time')) {
	    	$time = get_post_meta($post->ID,"delivery_time",true);
	    } else {
	    	$time="";
	    }


        $meta_box = '<input type="hidden" id="coderockz_woo_delivery_meta_box_order_id" value="' . $post->ID . '" readonly>';
        if($enable_delivery_date) {
        $meta_box .= '<input style="width:100%;margin:5px auto;" type="text" id="coderockz_woo_delivery_meta_box_datepicker" placeholder="Delivery Date" name="coderockz_woo_delivery_meta_box_datepicker" data-disable_dates="'.$disable_dates.'" data-selectable_dates="'.$selectable_date.'" data-disable_week_days="'.$disable_week_days.'" data-week_starts_from="'.$week_starts_from.'" data-date_format="'.$delivery_date_settings['date_format'].'" value="' . $delivery_date . '">';
    	}
    	if($enable_delivery_time) {
    		$meta_box .= '<select style="width:100%;margin:5px auto;" name ="coderockz_woo_delivery_meta_box_time_field" data-order_limit_notice="'.$order_limit_notice.'" id="coderockz_woo_delivery_meta_box_time_field">';
    		$meta_box .= '<option value="" disabled="disabled" selected>Select Time Slot</option>';
    		foreach($time_options as $key => $value) {
    			$selected = ($key == $time) ? "selected" : "";
    			$meta_box .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
    		}
    		$meta_box .= '</select>';
    	}
    	$meta_box .= '<div class="coderockz-woo-delivery-metabox-update-section">';
        $meta_box .= '<a class="coderockz-woo-delivery-metabox-update-btn" href="#" style="margin-right:10px"><button type="button" class="button button-primary">Update</button></a>';
        $meta_box .= '</div>';
        echo $meta_box;
        
	}

	public function coderockz_woo_delivery_save_meta_box_information() {
		check_ajax_referer('coderockz_woo_delivery_nonce');
		$delivery_time_settings = get_option('coderockz_woo_delivery_time_settings');
		// if any timezone data is saved, set default timezone with the data
		$timezone = $this->helper->get_the_timezone();
		date_default_timezone_set($timezone);

		$order_id = sanitize_text_field($_POST['orderId']);
		if(isset($_POST['date'])) {
			$date = sanitize_text_field($_POST['date']);
			update_post_meta( $order_id, 'delivery_date', strtotime($date) );
		}

		if(isset($_POST['time'])) {
			$time = sanitize_text_field($_POST['time']);
			update_post_meta( $order_id, 'delivery_time', $time );
		}

		wp_send_json_success();
	}

	public function coderockz_woo_delivery_meta_box_get_orders() {

		check_ajax_referer('coderockz_woo_delivery_nonce');
		
		$delivery_time_settings = get_option('coderockz_woo_delivery_time_settings');
		// if any timezone data is saved, set default timezone with the data
		$timezone = $this->helper->get_the_timezone();
		date_default_timezone_set($timezone);
		$delivery_date_settings = get_option('coderockz_woo_delivery_date_settings');
		$delivery_date_format = (isset($delivery_date_settings['date_format']) && !empty($delivery_date_settings['date_format'])) ? $delivery_date_settings['date_format'] : "F j, Y";

		$max_order_per_slot = (isset($delivery_time_settings['max_order_per_slot']) && !empty($delivery_time_settings['max_order_per_slot'])) ? $delivery_time_settings['max_order_per_slot'] : 0;
		
		$disabled_current_time_slot = (isset($delivery_time_settings['disabled_current_time_slot']) && !empty($delivery_time_settings['disabled_current_time_slot'])) ? $delivery_time_settings['disabled_current_time_slot'] : false;

		if($_POST['onlyDeliveryTime']) {
			$order_date = date("Y-m-d", sanitize_text_field(strtotime($_POST['date']))); 
			$args = array(
		        'limit' => -1,
		        'date_created' => $order_date,
		        'return' => 'ids'
		    );

		} else {
			$args = array(
		        'limit' => -1,
		        'delivery_date' => strtotime(sanitize_text_field($_POST['date'])),
		        'return' => 'ids'
		    );
		}

	    $order_ids = wc_get_orders( $args );

		$delivery_times = [];

		foreach ($order_ids as $order) {
			$date = get_post_meta($order,"delivery_date",true);
			$time = get_post_meta($order,"delivery_time",true);

			if((isset($date) && isset($time)) || isset($time)) {
				$times = explode(',', $time);
				$delivery_times[] = $times[0] . ',' . $times[1];				
			}
		}

		$current_time = (date("G")*60)+date("i");

		$response = [
			"delivery_times" => $delivery_times,
			"max_order_per_slot" => $max_order_per_slot,
			'disabled_current_time_slot' => $disabled_current_time_slot,
			"current_time" => $current_time,
		];
		$response = json_encode($response);
		wp_send_json_success($response);
	}

	public function override_post_meta_box_order( $order ) {
	    return array(
	        'normal' => join( 
	            ",", 
	            array(
	                'order_data',
	                'coderockz_woo_delivery_meta_box',
	                'woocommerce-order-items',
	            )
	        ),
	    );
	}


    public function coderockz_woo_delivery_main_layout() {
        include_once CODEROCKZ_WOO_DELIVERY_DIR . '/admin/partials/coderockz-woo-delivery-admin-display.php';
    }

}
