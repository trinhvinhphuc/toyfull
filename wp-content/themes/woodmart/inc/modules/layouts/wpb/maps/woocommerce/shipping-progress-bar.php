<?php
/**
 * Shipping progress bar map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_shipping_progress_bar' ) ) {
	/**
	 * Shipping progress bar map.
	 */
	function woodmart_vc_map_shipping_progress_bar() {
		if ( ! shortcode_exists( 'woodmart_shipping_progress_bar' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_shipping_progress_bar',
				'name'        => esc_html__( 'Shipping progress bars', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'WooCommerce', 'woodmart' ) ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/wc-icons/wc-shopping-progress-bar.svg',
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

	add_action( 'vc_before_init', 'woodmart_vc_map_shipping_progress_bar' );
}
