<?php
/**
 * WooCommerce hook map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_woocommerce_hook' ) ) {
	/**
	 * WooCommerce hook map.
	 */
	function woodmart_vc_map_woocommerce_hook() {
		if ( ! shortcode_exists( 'woodmart_woocommerce_hook' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_woocommerce_hook',
				'name'        => esc_html__( 'WooCommerce Hook', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'WooCommerce', 'woodmart' ) ),
				'description' => esc_html__( 'WooCommerce PHP hook', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-hook.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'          => esc_html__( 'Hook', 'woodmart' ),
						'description'      => esc_html__( 'Select which PHP hook do you want to display here.', 'woodmart' ),
						'type'             => 'wd_select',
						'param_name'       => 'hook',
						'style'            => 'select',
						'selectors'        => array(),
						'devices'          => array(
							'desktop' => array(
								'value' => '0',
							),
						),
						'value'            => array(
							esc_html__( 'Select', 'woodmart' ) => 0,
							'woocommerce_before_single_product' => 'woocommerce_before_single_product',
							'woocommerce_before_single_product_summary' => 'woocommerce_before_single_product_summary',
							'woocommerce_product_thumbnails' => 'woocommerce_product_thumbnails',
							'woocommerce_single_product_summary' => 'woocommerce_single_product_summary',
							'woocommerce_before_add_to_cart_form' => 'woocommerce_before_add_to_cart_form',
							'woocommerce_before_variations_form' => 'woocommerce_before_variations_form',
							'woocommerce_before_add_to_cart_button' => 'woocommerce_before_add_to_cart_button',
							'woocommerce_before_single_variation' => 'woocommerce_before_single_variation',
							'woocommerce_single_variation' => 'woocommerce_single_variation',
							'woocommerce_after_single_variation' => 'woocommerce_after_single_variation',
							'woocommerce_after_add_to_cart_button' => 'woocommerce_after_add_to_cart_button',
							'woocommerce_after_variations_form' => 'woocommerce_after_variations_form',
							'woocommerce_after_add_to_cart_form' => 'woocommerce_after_add_to_cart_form',
							'woocommerce_product_meta_start' => 'woocommerce_product_meta_start',
							'woocommerce_product_meta_end' => 'woocommerce_product_meta_end',
							'woocommerce_share'            => 'woocommerce_share',
							'woocommerce_after_single_product_summary' => 'woocommerce_after_single_product_summary',
							'woocommerce_after_single_product' => 'woocommerce_after_single_product',

							'woocommerce_before_cart'      => 'woocommerce_before_cart',
							'woocommerce_after_cart_table' => 'woocommerce_after_cart_table',
							'woocommerce_cart_collaterals' => 'woocommerce_cart_collaterals',
							'woocommerce_after_cart'       => 'woocommerce_after_cart',

							'woocommerce_before_checkout_form' => 'woocommerce_before_checkout_form',
							'woocommerce_checkout_before_customer_details' => 'woocommerce_checkout_before_customer_details',
							'woocommerce_checkout_after_customer_details' => 'woocommerce_checkout_after_customer_details',
							'woocommerce_checkout_billing' => 'woocommerce_checkout_billing',
							'woocommerce_checkout_shipping' => 'woocommerce_checkout_shipping',
							'woocommerce_checkout_before_order_review_heading' => 'woocommerce_checkout_before_order_review_heading',
							'woocommerce_checkout_before_order_review' => 'woocommerce_checkout_before_order_review',
							'woocommerce_checkout_order_review' => 'woocommerce_checkout_order_review',
							'woocommerce_checkout_after_order_review' => 'woocommerce_checkout_after_order_review',
							'woocommerce_after_checkout_form' => 'woocommerce_after_checkout_form',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Clean actions', 'woodmart' ),
						'description'      => esc_html__( 'You can clean all default WooCommerce PHP functions hooked to this action.', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'clean_actions',
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'yes',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'    => esc_html__( 'CSS box', 'woodmart' ),
						'group'      => esc_html__( 'Design Options', 'js_composer' ),
						'type'       => 'css_editor',
						'param_name' => 'css',
					),
					woodmart_get_vc_responsive_spacing_map(),

					// Width option (with dependency Columns option, responsive).
					woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
					woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
					woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
					woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
					woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
					woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
					woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),
				),
			)
		);
	}

	add_action( 'vc_before_init', 'woodmart_vc_map_woocommerce_hook' );
}
