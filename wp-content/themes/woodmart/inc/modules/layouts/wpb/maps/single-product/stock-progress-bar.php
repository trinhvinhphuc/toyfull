<?php
/**
 * Stock progress bar map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_product_stock_progress_bar' ) ) {
	/**
	 * Stock progress bar map.
	 */
	function woodmart_vc_map_single_product_stock_progress_bar() {
		if ( ! shortcode_exists( 'woodmart_single_product_stock_progress_bar' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_single_product_stock_progress_bar',
				'name'        => esc_html__( 'Product stock progress bar', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'Shows number of products left in stock', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-stock-progress-bar.svg',
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
					function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',
				),
			)
		);

	}
	add_action( 'vc_before_init', 'woodmart_vc_map_single_product_stock_progress_bar' );
}
