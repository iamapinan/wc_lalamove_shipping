<?php
/*
Plugin Name: LALAMOVE Shipping
Plugin URI: 
Description: Adds lalamove shipping method. 
Version: 1.1.1
Author: Apinan Woratrakun
Author URI: https://apinu.com
*/
 
/**
 * Check if WooCommerce is active
 */

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
	function lalamove_init() {
		if ( ! class_exists( 'WC_LALAMOVE_SHIPPING' ) ) {
			class WC_LALAMOVE_SHIPPING extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'lalamove_rate_reg'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Shipping Price' );  // Title shown in admin
					$this->method_description = __( 'Price base on shipping adress and weight delivery via motorcycle.' ); // Description shown in admin
 
					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "LALAMOVE Rate"; // This can be added as an setting but for this example its forced.
 
					$this->init();
				}
 
				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
					// Load the settings API
					$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
					$this->init_settings(); // This is part of the settings API. Loads settings you previously init.
 
					// Save settings in admin if you have any defined
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
				}
 
				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $data
				 * @return void
				 */
				public function calculate_shipping( $data ) {
					
					$cost = 140;
					
					$rate = array(
						'id' => $this->id,
						'label' => $this->title,
						'cost' => round($cost,2),
						'taxes' => '',
						'calc_tax' => 'per_order'
					);
 
					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}
 
	add_action( 'woocommerce_shipping_init', 'lalamove_init' );
 
	function add_lalamove_method( $methods ) {
		$methods[] = 'WC_Your_Shipping_Method';
		return $methods;
	}
 
	add_filter( 'woocommerce_shipping_methods', 'add_lalamove_method' );
}
