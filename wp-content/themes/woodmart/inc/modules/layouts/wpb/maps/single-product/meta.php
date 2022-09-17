<?php
/**
 * Meta map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_product_meta' ) ) {
	/**
	 * Meta map.
	 */
	function woodmart_vc_map_single_product_meta() {
		if ( ! shortcode_exists( 'woodmart_single_product_meta' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		$typography = array();

		if ( function_exists( 'woodmart_get_typography_map' ) ) {
			$typography = woodmart_get_typography_map(
				array(
					'key'      => 'label',
					'selector' => '{{WRAPPER}} .meta-label',
					'group'    => esc_html__( 'Style', 'js_composer' ),
				)
			);
		}

		vc_map(
			array(
				'base'        => 'woodmart_single_product_meta',
				'name'        => esc_html__( 'Product meta', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'SKU, category, and tags', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-meta.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
						'group'      => esc_html__( 'Style', 'js_composer' ),
					),
					/**
					 * Style tab.
					 */
					// General.
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'General', 'woodmart' ),
						'param_name' => 'style_general_divider',
						'dependency' => array(
							'element' => 'show_label',
							'value'   => 'yes',
						),
						'group'      => esc_html__( 'Style', 'js_composer' ),
					),
					array(
						'heading'          => esc_html__( 'Layout', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'layout',
						'value'            => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Inline', 'woodmart' )  => 'inline',
							esc_html__( 'Justify', 'woodmart' ) => 'justify',
						),
						'wood_tooltip'     => true,
						'group'            => esc_html__( 'Style', 'js_composer' ),
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
						'dependency'       => array(
							'element'            => 'layout',
							'value_not_equal_to' => 'justify',
						),
						'group'            => esc_html__( 'Style', 'js_composer' ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					// Label.
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Label', 'woodmart' ),
						'param_name' => 'style_label_divider',
						'group'      => esc_html__( 'Style', 'js_composer' ),
					),
					function_exists( 'woodmart_get_typography_map' ) ? $typography['font_family'] : '',
					function_exists( 'woodmart_get_typography_map' ) ? $typography['font_size'] : '',
					function_exists( 'woodmart_get_typography_map' ) ? $typography['font_weight'] : '',
					function_exists( 'woodmart_get_typography_map' ) ? $typography['text_transform'] : '',
					function_exists( 'woodmart_get_typography_map' ) ? $typography['font_style'] : '',
					function_exists( 'woodmart_get_typography_map' ) ? $typography['line_height'] : '',
					array(
						'heading'          => esc_html__( 'Label color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'label_color',
						'selectors'        => array(
							'{{WRAPPER}} .meta-label' => array(
								'color: {{VALUE}};',
							),
						),
						'group'            => esc_html__( 'Style', 'js_composer' ),
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
	add_action( 'vc_before_init', 'woodmart_vc_map_single_product_meta' );
}
