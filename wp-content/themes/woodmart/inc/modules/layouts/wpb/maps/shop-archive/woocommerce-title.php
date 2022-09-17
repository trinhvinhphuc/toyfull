<?php
/**
 * Woocommerce title map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_shop_archive_woocommerce_title' ) ) {
	/**
	 * Woocommerce title map.
	 */
	function woodmart_vc_map_shop_archive_woocommerce_title() {
		if ( ! shortcode_exists( 'woodmart_shop_archive_woocommerce_title' ) || ! Main::is_layout_type( 'shop_archive' ) ) {
			return;
		}

		$typography = woodmart_get_typography_map(
			array(
				'key'      => 'title',
				'selector' => '{{WRAPPER}} .title',
			)
		);

		vc_map(
			array(
				'base'        => 'woodmart_shop_archive_woocommerce_title',
				'name'        => esc_html__( 'WooCommerce title', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Products archive', 'woodmart' ), 'shop_archive' ),
				'description' => esc_html__( 'Show current archive page title', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sa-icons/sa-woocommerce-title.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'          => esc_html__( 'Alignment', 'woodmart' ),
						'type'             => 'wd_select',
						'param_name'       => 'text_alignment',
						'style'            => 'images',
						'selectors'        => array(),
						'devices'          => array(
							'desktop' => array(
								'value' => 'left',
							),
						),
						'value'            => array(
							esc_html__( 'Left', 'woodmart' ) => 'left',
							esc_html__( 'Center', 'woodmart' ) => 'center',
							esc_html__( 'Right', 'woodmart' ) => 'right',
						),
						'images'           => array(
							'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
							'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
							'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Tag', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'tag',
						'value'            => array(
							esc_html__( 'h1', 'woodmart' ) => 'h1',
							esc_html__( 'h2', 'woodmart' ) => 'h2',
							esc_html__( 'h3', 'woodmart' ) => 'h3',
							esc_html__( 'h4', 'woodmart' ) => 'h4',
							esc_html__( 'h5', 'woodmart' ) => 'h5',
							esc_html__( 'h6', 'woodmart' ) => 'h6',
							esc_html__( 'p', 'woodmart' )  => 'p',
							esc_html__( 'div', 'woodmart' ) => 'div',
							esc_html__( 'span', 'woodmart' ) => 'span',
						),
						'std'              => 'span',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					$typography['font_family'],
					$typography['font_size'],
					$typography['font_weight'],
					$typography['text_transform'],
					$typography['font_style'],
					$typography['line_height'],

					array(
						'heading'          => esc_html__( 'Text color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'text_color',
						'selectors'        => array(
							'{{WRAPPER}} .title' => array(
								'color: {{VALUE}};',
							),
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
	add_action( 'vc_before_init', 'woodmart_vc_map_shop_archive_woocommerce_title' );
}
