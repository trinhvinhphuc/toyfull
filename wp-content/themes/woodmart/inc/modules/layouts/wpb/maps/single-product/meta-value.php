<?php
/**
 * Meta value map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_product_meta_value' ) ) {
	/**
	 * Meta value map.
	 */
	function woodmart_vc_map_single_product_meta_value() {
		if ( ! shortcode_exists( 'woodmart_single_product_meta_value' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		$typography = woodmart_get_typography_map(
			array(
				'key'      => 'text',
				'selector' => '{{WRAPPER}}',
			)
		);

		vc_map(
			array(
				'base'        => 'woodmart_single_product_meta_value',
				'name'        => esc_html__( 'Product meta value', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'Custom meta value by key', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-meta-value.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'          => esc_html__( 'Meta key', 'woodmart' ),
						'description'      => esc_html__( 'Specify your custom meta key.', 'woodmart' ),
						'type'             => 'textfield',
						'param_name'       => 'meta_key',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Alignment', 'woodmart' ),
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

					$typography['font_family'],
					$typography['font_size'],
					$typography['font_weight'],
					$typography['text_transform'],
					$typography['font_style'],
					$typography['line_height'],

					array(
						'heading'          => esc_html__( 'Color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'color',
						'selectors'        => array(
							'{{WRAPPER}}' => array(
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
	add_action( 'vc_before_init', 'woodmart_vc_map_single_product_meta_value' );
}
