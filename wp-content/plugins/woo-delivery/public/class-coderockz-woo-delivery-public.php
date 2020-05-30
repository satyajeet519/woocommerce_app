<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://coderockz.com
 * @since      1.0.0
 *
 * @package    Coderockz_Woo_Delivery
 * @subpackage Coderockz_Woo_Delivery/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Coderockz_Woo_Delivery
 * @subpackage Coderockz_Woo_Delivery/public
 * @author     CodeRockz <admin@coderockz.com>
 */
class Coderockz_Woo_Delivery_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->helper = new Coderockz_Woo_Delivery_Helper();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		if(is_checkout()) {
			wp_enqueue_style( "flatpickr_css", plugin_dir_url( __FILE__ ) . 'css/flatpickr.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/coderockz-woo-delivery-public.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		if(is_checkout()) {
			wp_enqueue_script( "flatpickr_js", plugin_dir_url( __FILE__ ) . 'js/flatpickr.min.js', [], $this->version, true );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/coderockz-woo-delivery-public.js', array( 'jquery','selectWoo', 'flatpickr_js' ), $this->version, true );
		}
		$coderockz_woo_delivery_nonce = wp_create_nonce('coderockz_woo_delivery_nonce');
	        wp_localize_script($this->plugin_name, 'coderockz_woo_delivery_ajax_obj', array(
	            'coderockz_woo_delivery_ajax_url' => admin_url('admin-ajax.php'),
	            'nonce' => $coderockz_woo_delivery_nonce,
	        ));

	}


		// This function adds the delivery time and delivery date fields and it's functionalities
	public function coderockz_woo_delivery_add_custom_field($checkout) {
		// retrieving the data for delivery time
		$delivery_time_settings = get_option('coderockz_woo_delivery_time_settings');

		// if any timezone data is saved, set default timezone with the data
		$timezone = $this->helper->get_the_timezone();
		date_default_timezone_set($timezone);

		
		// starting the creating of view of delivery date and delivery time
		
		echo "<div data-plugin-url='".CODEROCKZ_WOO_DELIVERY_URL."' id='coderockz_woo_delivery_setting_wrapper'>";

		$today = date('Y-m-d', time());

		// Delivery Date --------------------------------------------------------------

		$delivery_date_settings = get_option('coderockz_woo_delivery_date_settings');
		$processing_days_settings = get_option('coderockz_woo_delivery_processing_days_settings');
		$enable_delivery_date = (isset($delivery_date_settings['enable_delivery_date']) && !empty($delivery_date_settings['enable_delivery_date'])) ? $delivery_date_settings['enable_delivery_date'] : false;

		$auto_select_first_date = (isset($delivery_date_settings['auto_select_first_date']) && !empty($delivery_date_settings['auto_select_first_date'])) ? $delivery_date_settings['auto_select_first_date'] : false;


		$disable_fields_for_downloadable_products = (isset(get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products']) && !empty(get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products'])) ? get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products'] : false;

		$has_virtual_downloadable_products = $this->helper->check_virtual_downloadable_products();

		if( $enable_delivery_date && (!$has_virtual_downloadable_products || $disable_fields_for_downloadable_products) ) {

			$off_days = (isset($delivery_date_settings['off_days']) && !empty($delivery_date_settings['off_days'])) ? $delivery_date_settings['off_days'] : array();

			$delivery_days = isset($delivery_date_settings['delivery_days']) && $delivery_date_settings['delivery_days'] != "" ? $delivery_date_settings['delivery_days'] : "6,0,1,2,3,4,5";			

			$delivery_date_field_label = (isset($delivery_date_settings['field_label']) && !empty($delivery_date_settings['field_label'])) ? $delivery_date_settings['field_label'] : "Delivery Date";
			$delivery_date_mandatory = (isset($delivery_date_settings['delivery_date_mandatory']) && !empty($delivery_date_settings['delivery_date_mandatory'])) ? $delivery_date_settings['delivery_date_mandatory'] : false;
			$delivery_date_format = (isset($delivery_date_settings['date_format']) && !empty($delivery_date_settings['date_format'])) ? $delivery_date_settings['date_format'] : "F j, Y";
			$week_starts_from = (isset($delivery_date_settings['week_starts_from']) && !empty($delivery_date_settings['week_starts_from']))?$delivery_date_settings['week_starts_from']:"6";
			
			$selectable_date = (isset($delivery_date_settings['selectable_date']) && !empty($delivery_date_settings['selectable_date']))?$delivery_date_settings['selectable_date']:"365";
			

			$delivery_date_extra_label_text = '';
			

			$disable_dates = [];

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


			// Show notice message according to data
			// if($normal_max_processing_days_count > 0 ||  > 0)
			// {
				/*if($offdays_count > 0 && $weekend_offdays_count > 0)
				{
					$delivery_date_extra_label_text = $offdays_count . " offdays(". $off_days_dates_text .") + ". $weekend_offdays_count ." weekend(". implode(', ', $weekend_offdays) .")";
					if($normal_max_processing_days_count > 0 ||  > 0)
					{
						$delivery_date_extra_label_text .= "+ Need ". $normal_max_processing_days_count ." days for processing " . $category . " products";
					}
				}
				else if($offdays_count > 0)
				{
					$delivery_date_extra_label_text = $offdays_count . " offdays(". $off_days_dates_text .") + Need ". $normal_max_processing_days_count ." days for processing " . $category . " products";
				}
				else if($weekend_offdays_count > 0 || $weekend_offdays_count > 0)
				{
					$delivery_date_extra_label_text = $weekend_offdays_count . " weekend(". implode(', ', $weekend_offdays) .")";

					if($normal_max_processing_days_count > 0 ||  > 0)
					{
						$delivery_date_extra_label_text .= " + Need ". $normal_max_processing_days_count ." days for processing " . $category . " products";
					}
				}
				else
				{
					$delivery_date_extra_label_text = "Need " .  . " days for processing " . $category . " products";
				}*/
			// }

			woocommerce_form_field('coderockz_woo_delivery_date_field',
			[
				'type' => 'text',
				'class' => array(
				  'coderockz_woo_delivery_date_field form-row-wide'
				) ,
				'id' => "coderockz_woo_delivery_date_datepicker",
				'label' => $delivery_date_field_label,
				'placeholder' => $delivery_date_field_label,
				'required' => $delivery_date_mandatory,
				'custom_attributes' => [
					'data-selectable_dates' => $selectable_date,
					'data-disable_week_days' => json_encode($disable_week_days),
					'data-date_format' => $delivery_date_format,
					'data-disable_dates' => json_encode($disable_dates),
					'data-week_starts_from' => $week_starts_from,
					'data-default_date' => $auto_select_first_date,
				],
			] , $checkout->get_value('coderockz_woo_delivery_date_field'));
		}

		// End Delivery Date

		// Delivery Time --------------------------------------------------------------
		$enable_delivery_time = (isset($delivery_time_settings['enable_delivery_time']) && !empty($delivery_time_settings['enable_delivery_time'])) ? $delivery_time_settings['enable_delivery_time'] : false;

		$delivery_time_field_label = (isset($delivery_time_settings['field_label']) && !empty($delivery_time_settings['field_label'])) ? $delivery_time_settings['field_label'] : "Delivery Time";

		$delivery_time_mandatory = (isset($delivery_time_settings['delivery_time_mandatory']) && !empty($delivery_time_settings['delivery_time_mandatory'])) ? $delivery_time_settings['delivery_time_mandatory'] : false;

		$auto_select_first_time = (isset($delivery_time_settings['auto_select_first_time']) && !empty($delivery_time_settings['auto_select_first_time'])) ? $delivery_time_settings['auto_select_first_time'] : false;

		$order_limit_notice = (isset(get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice'])) ? "(".get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice'].")" : "(Maximum Order Limit Exceed)";

		if( $enable_delivery_time && (!$has_virtual_downloadable_products || $disable_fields_for_downloadable_products)) {

			echo '<div id="delivery_time_field">';
			
			woocommerce_form_field('coderockz_woo_delivery_time_field',
			[
				'type' => 'select',
				'class' => [
					'coderockz_woo_delivery_time_field form-row-wide'
				],
				'label' => $delivery_time_field_label,
				'placeholder' => $delivery_time_field_label,
				'options' => Coderockz_Woo_Delivery_Time_Option::delivery_time_option($delivery_time_settings),
				'required' => $delivery_time_mandatory,
				'custom_attributes' => [
					'data-default_time' => $auto_select_first_time,
					'data-order_limit_notice' => $order_limit_notice
				],
			], $checkout->get_value('coderockz_woo_delivery_time_field'));
			echo '</div>';
		}
		// End Delivery Time

		echo "</div>";
	}

	/**
	 * Checkout Process
	*/	
	public function coderockz_woo_delivery_customise_checkout_field_process() {
		
		$delivery_date_settings = get_option('coderockz_woo_delivery_date_settings');
		$enable_delivery_date = (isset($delivery_date_settings['enable_delivery_date']) && !empty($delivery_date_settings['enable_delivery_date'])) ? $delivery_date_settings['enable_delivery_date'] : false;
		$delivery_date_mandatory = (isset($delivery_date_settings['delivery_date_mandatory']) && !empty($delivery_date_settings['delivery_date_mandatory'])) ? $delivery_date_settings['delivery_date_mandatory'] : false;

		$checkout_date_notice = (isset(get_option('coderockz_woo_delivery_localization_settings')['checkout_date_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['checkout_date_notice'])) ? get_option('coderockz_woo_delivery_localization_settings')['checkout_date_notice'] : "Please Enter Delivery Date.";
		$checkout_time_notice = (isset(get_option('coderockz_woo_delivery_localization_settings')['checkout_time_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['checkout_time_notice'])) ? get_option('coderockz_woo_delivery_localization_settings')['checkout_time_notice'] : "Please Enter Delivery Time.";

		$disable_fields_for_downloadable_products = (isset(get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products']) && !empty(get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products'])) ? get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products'] : false;
		
		$has_virtual_downloadable_products = $this->helper->check_virtual_downloadable_products();

		// if the field is set, if not then show an error message.
		if($enable_delivery_date && $delivery_date_mandatory && (!$has_virtual_downloadable_products || $disable_fields_for_downloadable_products)) {
			if (!$_POST['coderockz_woo_delivery_date_field']) wc_add_notice(__($checkout_date_notice) , 'error');
		}



		$delivery_time_settings = get_option('coderockz_woo_delivery_time_settings');
		$enable_delivery_time = (isset($delivery_time_settings['enable_delivery_time']) && !empty($delivery_time_settings['enable_delivery_time'])) ? $delivery_time_settings['enable_delivery_time'] : false;
		$delivery_time_mandatory = (isset($delivery_time_settings['delivery_time_mandatory']) && !empty($delivery_time_settings['delivery_time_mandatory'])) ? $delivery_time_settings['delivery_time_mandatory'] : false;
		// if the field is set, if not then show an error message.
		if($enable_delivery_time && $delivery_time_mandatory && (!$has_virtual_downloadable_products || $disable_fields_for_downloadable_products)) {
			if (!$_POST['coderockz_woo_delivery_time_field']) wc_add_notice(__($checkout_time_notice) , 'error');
		}
		
	}

	/**
	 * Update value of field
	*/
	public function coderockz_woo_delivery_customise_checkout_field_update_order_meta($order_id) {
		
		$delivery_time_settings = get_option('coderockz_woo_delivery_time_settings');
		// if any timezone data is saved, set default timezone with the data
		$timezone = $this->helper->get_the_timezone();
		date_default_timezone_set($timezone);

		$disable_fields_for_downloadable_products = (isset(get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products']) && !empty(get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products'])) ? get_option('coderockz_woo_delivery_other_settings')['disable_fields_for_downloadable_products'] : false;
		
		$has_virtual_downloadable_products = $this->helper->check_virtual_downloadable_products();
		
		$delivery_date_settings = get_option('coderockz_woo_delivery_date_settings');
		$enable_delivery_date = (isset($delivery_date_settings['enable_delivery_date']) && !empty($delivery_date_settings['enable_delivery_date'])) ? $delivery_date_settings['enable_delivery_date'] : false;
		if ($enable_delivery_date && !empty($_POST['coderockz_woo_delivery_date_field']) && (!$has_virtual_downloadable_products || $disable_fields_for_downloadable_products)) {
	    	update_post_meta($order_id, 'delivery_date', strtotime(sanitize_text_field($_POST['coderockz_woo_delivery_date_field'])));
	  	}

		$enable_delivery_time = (isset($delivery_time_settings['enable_delivery_time']) && !empty($delivery_time_settings['enable_delivery_time'])) ? $delivery_time_settings['enable_delivery_time'] : false;
	  	if ($enable_delivery_time && !empty($_POST['coderockz_woo_delivery_time_field']) && (!$has_virtual_downloadable_products || $disable_fields_for_downloadable_products)) {
			update_post_meta($order_id, 'delivery_time', sanitize_text_field($_POST['coderockz_woo_delivery_time_field']));
	  	}
	}

	//Without this function of filter "woocommerce_order_data_store_cpt_get_orders_query" query with post_meta "delivery_date" is not possible
	public function coderockz_woo_delivery_handle_custom_query_var( $query, $query_vars ) {
		if ( ! empty( $query_vars['delivery_date'] ) ) {
			$query['meta_query'][] = array(
				'key' => 'delivery_date',
				'value' => esc_attr( $query_vars['delivery_date'] ),
			);
		}

		return $query;
	}

	public function coderockz_woo_delivery_get_orders() {

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

	
	public function coderockz_woo_delivery_add_account_orders_column( $columns ) {
		if(class_exists('Woocommerce_Delivery_Date_Time')) {
			$columns  = array_splice($columns, 0, 3, true) +
				['order_delivery_details' => "Delivery Details"] +
				array_splice($columns, 1, count($columns) - 1, true);
		}
		
	    return $columns;
	}

	public function coderockz_woo_delivery_show_delivery_details_my_account_tab($order) {
		if(class_exists('Woocommerce_Delivery_Date_Time')) {
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

			$date = get_post_meta($order->get_id(),"delivery_date",true);
			$minutes = get_post_meta($order->get_id(),"delivery_time",true);
			$minutes = explode(',', $minutes);
			$my_account_column = "";
			$my_account_column .= $delivery_date_field_label.": " . date($delivery_date_format, $date);
			$my_account_column .= "<br>";
			if($time_format == "H:i" && $minutes[1] == 1440){
				$time_value = date($time_format, mktime(0, (int)$minutes[0])) . ' - ' . '24:00';
			} else {
				$time_value = date($time_format, mktime(0, (int)$minutes[0])) . ' - ' . date($time_format, mktime(0, (int)$minutes[1]));
			}
			$my_account_column .= $time_value;

			echo $my_account_column;
		}
	}

	public function coderockz_woo_delivery_add_delivery_information_row( $total_rows, $order ) {
 
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

	    
	    if(metadata_exists('post', $order_id, 'delivery_date') && get_post_meta( $order_id, 'delivery_date', true ) != "") {
	    	$total_rows['delivery_date'] = array(
			   'label' => $delivery_date_field_label,
			   'value'   => date($delivery_date_format, get_post_meta( $order_id, 'delivery_date', true ))
			);
	    }
		
	    if(metadata_exists('post', $order_id, 'delivery_time') && get_post_meta($order_id,"delivery_time",true) != "") {
			$minutes = get_post_meta($order_id,"delivery_time",true);
			$minutes = explode(',', $minutes);
			if($time_format == "H:i" && $minutes[1] == 1440){
				$time_value = date($time_format, mktime(0, (int)$minutes[0])) . ' - ' . '24:00';
			} else {
				$time_value = date($time_format, mktime(0, (int)$minutes[0])) . ' - ' . date($time_format, mktime(0, (int)$minutes[1]));
			}
			$total_rows['delivery_time'] = array(
			   'label' => $delivery_time_field_label,
			   'value'   => $time_value
			);
		}
		 
		return $total_rows;
	}

}
