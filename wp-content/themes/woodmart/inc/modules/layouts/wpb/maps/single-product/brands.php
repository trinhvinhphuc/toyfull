<?php
/**
 * Product brands map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_product_brands' ) ) {
	/**
	 * Product brands map.
	 */
	function woodmart_vc_map_single_product_brands() {
		if ( ! shortcode_exists( 'woodmart_single_product_brands' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		$typography = woodmart_get_typography_map(
			array(
				'key'        => 'tabs_title',
				'selector'   => '{{WRAPPER}} .wd-label',
				'dependency' => array(
					'element' => 'show_label',
					'value'   => 'yes',
				),
			)
		);

		vc_map(
			array(
				'base'        => 'woodmart_single_product_brands',
				'name'        => esc_html__( 'Product brands', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'Brands assigned to the product', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-brands.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					// Label.
					array(
						'title'      => esc_html__( 'Label', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'label_divider',
					),

					array(
						'heading'          => esc_html__( 'Show label', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'show_label',
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Label text', 'woodmart' ),
						'type'             => 'textfield',
						'param_name'       => 'label_text',
						'value'            => esc_html__( 'Brands: ', 'woodmart' ),
						'dependency'       => array(
							'element' => 'show_label',
							'value'   => 'yes',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Label color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'color',
						'selectors'        => array(
							'{{WRAPPER}} .wd-label' => array(
								'color: {{VALUE}};',
							),
						),
						'dependency'       => array(
							'element' => 'show_label',
							'value'   => 'yes',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					$typography['font_family'],
					$typography['font_size'],
					$typography['font_weight'],
					$typography['text_transform'],
					$typography['font_style'],
					$typography['line_height'],

					// General.
					array(
						'title'      => esc_html__( 'General', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'label_divider',
					),

					array(
						'heading'          => esc_html__( 'Layout', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'layout',
						'value'            => array(
							esc_html__( 'Default', 'woodmart' )  => 'default',
							esc_html__( 'Justify', 'woodmart' )  => 'justify',
							esc_html__( 'Inline', 'woodmart' )   => 'inline',
						),
						'dependency'       => array(
							'element'            => 'show_label',
							'value_not_equal_to' => 'no',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
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

					// Image.
					array(
						'title'      => esc_html__( 'Image', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'label_divider',
					),

					array(
						'heading'    => esc_html__( 'Style', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'dropdown',
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Shadow', 'woodmart' )  => 'shadow',
						),
					),

					array(
						'heading'    => esc_html__( 'Width', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'wd_slider',
						'param_name' => 'vertical_gap',
						'selectors'  => array(
							'{{WRAPPER}} img' => array(
								'max-width: {{VALUE}}{{UNIT}};',
							),
						),
						'devices'    => array(
							'desktop' => array(
								'value' => '',
								'unit'  => 'px',
							),
							'tablet'  => array(
								'value' => '',
								'unit'  => 'px',
							),
							'mobile'  => array(
								'value' => '',
								'unit'  => 'px',
							),
						),
						'range'      => array(
							'px' => array(
								'min'  => 0,
								'max'  => 300,
								'step' => 1,
							),
						),
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
	add_action( 'vc_before_init', 'woodmart_vc_map_single_product_brands' );
}
