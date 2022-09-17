<?php
/**
 * Hook map.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use XTS\WC_Wishlist\Ui;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Hook extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_wc_hook';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'WooCommerce Hook', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-hook';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-woocommerce-elements' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {

		/**
		 * Content tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'hook',
			array(
				'label'       => esc_html__( 'Hook', 'woodmart' ),
				'description' => esc_html__( 'Select which PHP hook do you want to display here.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => array(
					'0'                                    => esc_html__( 'Select', 'woodmart' ),
					'woocommerce_before_single_product'    => 'woocommerce_before_single_product',
					'woocommerce_before_single_product_summary' => 'woocommerce_before_single_product_summary',
					'woocommerce_product_thumbnails'       => 'woocommerce_product_thumbnails',
					'woocommerce_single_product_summary'   => 'woocommerce_single_product_summary',
					'woocommerce_before_add_to_cart_form'  => 'woocommerce_before_add_to_cart_form',
					'woocommerce_before_variations_form'   => 'woocommerce_before_variations_form',
					'woocommerce_before_add_to_cart_button' => 'woocommerce_before_add_to_cart_button',
					'woocommerce_before_single_variation'  => 'woocommerce_before_single_variation',
					'woocommerce_single_variation'         => 'woocommerce_single_variation',
					'woocommerce_after_single_variation'   => 'woocommerce_after_single_variation',
					'woocommerce_after_add_to_cart_button' => 'woocommerce_after_add_to_cart_button',
					'woocommerce_after_variations_form'    => 'woocommerce_after_variations_form',
					'woocommerce_after_add_to_cart_form'   => 'woocommerce_after_add_to_cart_form',
					'woocommerce_product_meta_start'       => 'woocommerce_product_meta_start',
					'woocommerce_product_meta_end'         => 'woocommerce_product_meta_end',
					'woocommerce_share'                    => 'woocommerce_share',
					'woocommerce_after_single_product_summary' => 'woocommerce_after_single_product_summary',
					'woocommerce_after_single_product'     => 'woocommerce_after_single_product',

					'woocommerce_before_cart'              => 'woocommerce_before_cart',
					'woocommerce_after_cart_table'         => 'woocommerce_after_cart_table',
					'woocommerce_cart_collaterals'         => 'woocommerce_cart_collaterals',
					'woocommerce_after_cart'               => 'woocommerce_after_cart',

					'woocommerce_before_checkout_form'     => 'woocommerce_before_checkout_form',
					'woocommerce_checkout_before_customer_details' => 'woocommerce_checkout_before_customer_details',
					'woocommerce_checkout_after_customer_details' => 'woocommerce_checkout_after_customer_details',
					'woocommerce_checkout_billing'         => 'woocommerce_checkout_billing',
					'woocommerce_checkout_shipping'        => 'woocommerce_checkout_shipping',
					'woocommerce_checkout_before_order_review_heading' => 'woocommerce_checkout_before_order_review_heading',
					'woocommerce_checkout_before_order_review' => 'woocommerce_checkout_before_order_review',
					'woocommerce_checkout_order_review'    => 'woocommerce_checkout_order_review',
					'woocommerce_checkout_after_order_review' => 'woocommerce_checkout_after_order_review',
					'woocommerce_after_checkout_form'      => 'woocommerce_after_checkout_form',
				),
				'default'     => '0',
			)
		);

		$this->add_control(
			'clean_actions',
			array(
				'label'        => esc_html__( 'Clean actions', 'woodmart' ),
				'description'  => esc_html__( 'You can clean all default WooCommerce PHP functions hooked to this action.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings = wp_parse_args(
			$this->get_settings_for_display(),
			array(
				'hook'          => '0',
				'clean_actions' => 'yes',
			)
		);

		Main::setup_preview();

		if ( 'yes' === $settings['clean_actions'] ) {
			if ( 'woocommerce_checkout_billing' === $settings['hook'] ) {
				remove_action( 'woocommerce_checkout_billing', array( WC()->checkout(), 'checkout_form_billing' ) );
			} elseif ( 'woocommerce_checkout_shipping' === $settings['hook'] ) {
				remove_action( 'woocommerce_checkout_shipping', array( WC()->checkout(), 'checkout_form_shipping' ) );
			} elseif ( 'woocommerce_checkout_before_customer_details' === $settings['hook'] ) {
				remove_action( 'woocommerce_checkout_before_customer_details', 'wc_get_pay_buttons', 30 );
			} elseif ( 'woocommerce_before_checkout_form' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
			} elseif ( 'woocommerce_cart_collaterals' === $settings['hook'] ) {
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
			} elseif ( 'woocommerce_before_cart' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
			} elseif ( 'woocommerce_before_single_product' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices' );
				remove_action( 'woocommerce_before_single_product', 'wc_print_notices' );
				remove_action( 'woocommerce_before_single_product', 'woodmart_product_extra_content', 20 );
			} elseif ( 'woocommerce_before_single_product_summary' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			} elseif ( 'woocommerce_product_thumbnails' === $settings['hook'] ) {
				remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			} elseif ( 'woocommerce_single_product_summary' === $settings['hook'] ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 3 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 8 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_share_buttons', 62 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_display_product_attributes', 21 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_add_to_cart', 30 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_sguide_display', 38 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_before_add_to_cart_area', 25 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_after_add_to_cart_area', 31 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_add_to_compare_single_btn', 33 );

				if ( woodmart_get_opt( 'wishlist' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( UI::get_instance(), 'add_to_wishlist_single_btn' ), 33 );
				}
			} elseif ( 'woocommerce_before_add_to_cart_form' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_add_to_cart_form', 'woodmart_single_product_add_to_cart_scripts' );
			} elseif ( 'woocommerce_before_variations_form' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation' );
			} elseif ( 'woocommerce_single_variation' === $settings['hook'] ) {
				remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation' );
				remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
				remove_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation' );
			} elseif ( 'woocommerce_after_single_product_summary' === $settings['hook'] ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
				remove_action( 'woocommerce_after_single_product_summary', 'woodmart_wc_comments_template', 50 );
			} elseif ( 'woocommerce_checkout_order_review' === $settings['hook'] ) {
				remove_action( 'woocommerce_checkout_order_review', 'woodmart_open_table_wrapper_div', 7 );
				remove_action( 'woocommerce_checkout_order_review', 'woodmart_close_table_wrapper_div', 13 );
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 20 );
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 10 );
			}
		}

		if ( 'woocommerce_before_checkout_form' === $settings['hook'] || 'woocommerce_after_checkout_form' === $settings['hook'] ) {
			do_action( $settings['hook'], WC()->checkout() );
		} else {
			do_action( $settings['hook'] );
		}

		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Hook() );
