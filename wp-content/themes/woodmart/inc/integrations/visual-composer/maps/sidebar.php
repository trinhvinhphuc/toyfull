<?php
/**
 * Sidebar map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_sidebar' ) ) {
	/**
	 * Sidebar map.
	 */
	function woodmart_vc_map_sidebar() {
		if ( ! shortcode_exists( 'woodmart_sidebar' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_sidebar',
				'name'        => esc_html__( 'Sidebar', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
				'description' => esc_html__( 'Shows any sidebar with widgets', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sa-icons/sa-sidebar.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'    => esc_html__( 'Choose Sidebar', 'woodmart' ),
						'type'       => 'dropdown',
						'param_name' => 'sidebar_name',
						'value'      => woodmart_get_sidebars_for_builder_in_shop_page(),
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

	/**
	 * Get all sidebars for shop page builder.
	 *
	 * @return array
	 */
	function woodmart_get_sidebars_for_builder_in_shop_page() {
		global $wp_registered_sidebars;

		$options = array();

		if ( ! $wp_registered_sidebars ) {
			$options[ esc_html__( 'No sidebars were found', 'woodmart' ) ] = '';
		} else {
			$options[ esc_html__( 'Choose Sidebar', 'woodmart' ) ] = '';

			foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
				$options[ $sidebar['name'] ] = $sidebar_id;
			}
		}

		return $options;
	}

	add_action( 'vc_before_init', 'woodmart_vc_map_sidebar' );
}
