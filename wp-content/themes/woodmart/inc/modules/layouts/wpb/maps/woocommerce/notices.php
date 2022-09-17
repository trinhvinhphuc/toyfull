<?php
/**
 * WooCommerce notices map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_woocommerce_notices' ) ) {
	/**
	 * WooCommerce notices map.
	 */
	function woodmart_vc_map_woocommerce_notices() {
		if ( ! shortcode_exists( 'woodmart_woocommerce_notices' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_woocommerce_notices',
				'name'        => esc_html__( 'WooCommerce notices', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'WooCommerce', 'woodmart' ) ),
				'description' => esc_html__( 'WooCommerce notices area', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-notices.svg',
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

	add_action( 'vc_before_init', 'woodmart_vc_map_woocommerce_notices' );
}
