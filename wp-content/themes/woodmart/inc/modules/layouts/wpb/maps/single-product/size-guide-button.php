<?php
/**
 * Size guide button map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_size_guide_button' ) ) {
	/**
	 * Size guide button map.
	 */
	function woodmart_vc_map_single_size_guide_button() {
		if ( ! shortcode_exists( 'woodmart_single_product_size_guide_button' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		$typography = woodmart_get_typography_map(
			array(
				'key'        => 'button',
				'selector'   => '{{WRAPPER}} .wd-sizeguide-btn > a span',
				'dependency' => array(
					'element' => 'style',
					'value'   => 'text',
				),
			)
		);

		vc_map(
			array(
				'base'        => 'woodmart_single_product_size_guide_button',
				'name'        => esc_html__( 'Size guide button', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'Size guide popup button', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-size-guide-button.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					// Button.
					array(
						'title'      => esc_html__( 'Button', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'button_divider',
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

					array(
						'heading'          => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'woodmart_image_select',
						'param_name'       => 'style',
						'value'            => array(
							esc_html__( 'Icon with text', 'woodmart' ) => 'text',
							esc_html__( 'Icon only', 'woodmart' ) => 'icon',
						),
						'images_value'     => array(
							'text' => WOODMART_ASSETS_IMAGES . '/settings/icon-style/icon-with-text.jpg',
							'icon' => WOODMART_ASSETS_IMAGES . '/settings/icon-style/only-icon.jpg',
						),
						'wood_tooltip'     => true,
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					// Text.
					array(
						'title'      => esc_html__( 'Text', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'label_divider',
						'dependency' => array(
							'element' => 'style',
							'value'   => 'text',
						),
					),

					array(
						'heading'          => esc_html__( 'Idle color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'text_color',
						'selectors'        => array(
							'{{WRAPPER}} .wd-sizeguide-btn > a span' => array(
								'color: {{VALUE}};',
							),
						),
						'dependency'       => array(
							'element' => 'style',
							'value'   => 'text',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Hover color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'text_color_hover',
						'selectors'        => array(
							'{{WRAPPER}} .wd-sizeguide-btn > a:hover span' => array(
								'color: {{VALUE}};',
							),
						),
						'dependency'       => array(
							'element' => 'style',
							'value'   => 'text',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					$typography['font_family'],
					$typography['font_size'],
					$typography['font_weight'],
					$typography['text_transform'],
					$typography['font_style'],
					$typography['line_height'],

					// Icon.
					array(
						'title'      => esc_html__( 'Icon', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'label_divider',
					),

					array(
						'heading'    => esc_html__( 'Icon size', 'woodmart' ),
						'type'       => 'wd_slider',
						'param_name' => 'icon_size',
						'selectors'  => array(
							'{{WRAPPER}} .wd-sizeguide-btn[class*="wd-style-"] > a:before, {{WRAPPER}} .wd-sizeguide-btn[class*="wd-style-"] > a:after' => array(
								'font-size: {{VALUE}}px;',
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
								'max'  => 50,
								'step' => 1,
							),
						),
					),

					array(
						'heading'          => esc_html__( 'Idle color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'icon_color',
						'selectors'        => array(
							'{{WRAPPER}} .wd-sizeguide-btn > a:before' => array(
								'color: {{VALUE}};',
							),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Hover color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'icon_color_hover',
						'selectors'        => array(
							'{{WRAPPER}} .wd-sizeguide-btn > a:hover:before' => array(
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
	add_action( 'vc_before_init', 'woodmart_vc_map_single_size_guide_button' );
}
