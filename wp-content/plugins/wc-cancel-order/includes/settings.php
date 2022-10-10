<?php
defined( 'ABSPATH' ) || exit;

if(!class_exists('WC_Cancel_Settings')){
	class WC_Cancel_Settings {

		/**
		 * Bootstraps the class and hooks required actions & filters.
		 *
		 */

		public static function init() {
			add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
			add_action( 'woocommerce_settings_tabs_wc_cancel_settings', __CLASS__ . '::settings_tab' );
			add_action( 'woocommerce_update_options_wc_cancel_settings', __CLASS__ . '::update_settings' );
		}


		/**
		 * Add a new settings tab to the WooCommerce settings tabs array.
		 *
		 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
		 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
		 */
		public static function add_settings_tab( $settings_tabs ) {
			$settings_tabs['wc_cancel_settings'] = __( 'WC Cancel', 'wc-cancel-order' );
			return $settings_tabs;
		}


		/**
		 * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
		 *
		 * @uses woocommerce_admin_fields()
		 * @uses self::get_settings()
		 */
		public static function settings_tab() {
			woocommerce_admin_fields(self::get_settings());
		}


		/**
		 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
		 *
		 * @uses woocommerce_update_options()
		 * @uses self::get_settings()
		 */
		public static function update_settings(){
			woocommerce_update_options(self::get_settings());
		}


		/**
		 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
		 *
		 * @return array Array of settings for @see woocommerce_admin_fields() function.
		 */

		public static function get_settings(){
			//$statuses = WC_Cancel_Order_Init()->wc_cancel_get_order_statuses();
			//echo '<pre>'; print_r(array_keys($statuses)); echo '</pre>';
			$settings = array(
				'section_title' => array(
					'name'     => __('Wc Cancel Order Setting','wc-cancel-order'),
					'type'     => 'title',
					'desc'     => '',
					'id'       => 'wc_cancel_settings_section_title'
				),
				'wc_cancel_order_setting' => array(
					'name'     => '',
					'type'     => 'wc_cancel_setting',
					'desc'     => '',
					'id'       => 'wc_cancel_order_setting'
				),
			);
			return apply_filters('wc_cancel_settings',$settings);
		}
	}
}
?>