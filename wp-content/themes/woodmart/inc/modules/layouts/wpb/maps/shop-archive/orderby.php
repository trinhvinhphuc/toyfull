<?php
/**
 * Order by map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_shop_archive_orderby' ) ) {
	/**
	 * Order by map.
	 */
	function woodmart_vc_map_shop_archive_orderby() {
		if ( ! shortcode_exists( 'woodmart_shop_archive_orderby' ) || ! Main::is_layout_type( 'shop_archive' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_shop_archive_orderby',
				'name'        => esc_html__( 'Order by', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Products archive', 'woodmart' ), 'shop_archive' ),
				'description' => esc_html__( 'WooCommerce order by dropdown', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sa-icons/sa-order-by.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'          => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'style',
						'value'            => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Underline', 'woodmart' )  => 'underline',
						),
						'std'              => 'default',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Icon on mobile', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'mobile_icon',
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
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
	add_action( 'vc_before_init', 'woodmart_vc_map_shop_archive_orderby' );
}
