<?php
/**
 * Result count map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_shop_archive_result_count' ) ) {
	/**
	 * Result count map.
	 */
	function woodmart_vc_map_shop_archive_result_count() {
		if ( ! shortcode_exists( 'woodmart_shop_archive_result_count' ) || ! Main::is_layout_type( 'shop_archive' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_shop_archive_result_count',
				'name'        => esc_html__( 'Result count', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Products archive', 'woodmart' ), 'shop_archive' ),
				'description' => esc_html__( 'Number of products displayed', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sa-icons/sa-result-count.svg',
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

					/**
					 * Advanced Tab.
					 */
					woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),

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
	add_action( 'vc_before_init', 'woodmart_vc_map_shop_archive_result_count' );
}
