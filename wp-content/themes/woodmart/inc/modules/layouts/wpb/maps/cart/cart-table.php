<?php
/**
 * Cart table map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_cart_table' ) ) {
	/**
	 * Cart table map.
	 */
	function woodmart_vc_map_cart_table() {
		if ( ! shortcode_exists( 'woodmart_cart_table' ) || ! Main::is_layout_type( 'cart' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_cart_table',
				'name'        => esc_html__( 'Cart table', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Cart elements', 'woodmart' ), 'cart' ),
				'description' => esc_html__( 'Product table and coupon code', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/ct-icons/ct-cart-table.svg',
				'params'      => array(
					array(
						'group'      => esc_html__( 'Design Options', 'js_composer' ),
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
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

	add_action( 'vc_before_init', 'woodmart_vc_map_cart_table' );
}
