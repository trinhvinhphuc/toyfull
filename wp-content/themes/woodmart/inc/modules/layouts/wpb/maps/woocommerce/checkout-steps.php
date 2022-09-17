<?php
/**
 * Checkout steps map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_woocommerce_checkout_steps' ) ) {
	/**
	 * Checkout steps map.
	 */
	function woodmart_vc_map_woocommerce_checkout_steps() {
		if ( ! shortcode_exists( 'woodmart_woocommerce_breadcrumb' ) || ( ! Main::is_layout_type( 'checkout_form' ) && ! Main::is_layout_type( 'cart' ) && ! Main::is_layout_type( 'checkout_content' ) ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_woocommerce_checkout_steps',
				'name'        => esc_html__( 'Checkout steps', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'WooCommerce', 'woodmart' ) ),
				'description' => esc_html__( 'Cart -> Checkout -> Complete', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/wc-icons/wc-checkout-steps.svg',
				'params'      => array(
					array(
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'          => esc_html__( 'Alignment', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'wd_select',
						'param_name'       => 'alignment',
						'style'            => 'images',
						'selectors'        => array(),
						'devices'          => array(
							'desktop' => array(
								'value' => 'left',
							),
						),
						'value'            => array(
							esc_html__( 'Left', 'woodmart' )   => 'left',
							esc_html__( 'Center', 'woodmart' ) => 'center',
							esc_html__( 'Right', 'woodmart' )  => 'right',
						),
						'images'           => array(
							'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
							'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
							'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
						),
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

	add_action( 'vc_before_init', 'woodmart_vc_map_woocommerce_checkout_steps' );
}
