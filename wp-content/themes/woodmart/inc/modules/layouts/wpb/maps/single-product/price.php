<?php
/**
 * Price map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_product_price' ) ) {
	/**
	 * Price map.
	 */
	function woodmart_vc_map_single_product_price() {
		if ( ! shortcode_exists( 'woodmart_single_product_price' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		$typography_price = woodmart_get_typography_map(
			array(
				'key'           => 'price',
				'selector'      => '{{WRAPPER}} .price',
				'wd_dependency' => array(
					'element' => 'price_style_tabs',
					'value'   => array( 'main_price' ),
				),
			)
		);

		$typography_old_price = woodmart_get_typography_map(
			array(
				'key'           => 'old_price',
				'selector'      => '{{WRAPPER}} .price del, {{WRAPPER}} del .amount',
				'wd_dependency' => array(
					'element' => 'price_style_tabs',
					'value'   => array( 'old_price' ),
				),
			)
		);

		$typography_suffix = woodmart_get_typography_map(
			array(
				'key'           => 'suffix',
				'selector'      => '{{WRAPPER}} .woocommerce-price-suffix',
				'wd_dependency' => array(
					'element' => 'price_style_tabs',
					'value'   => array( 'suffix' ),
				),
			)
		);

		vc_map(
			array(
				'base'        => 'woodmart_single_product_price',
				'name'        => esc_html__( 'Product price', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'Regular and sale price', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-price.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
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

					// Price.
					array(
						'title'      => esc_html__( 'Price', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'label_divider',
					),

					array(
						'heading'          => '',
						'type'             => 'woodmart_button_set',
						'param_name'       => 'price_style_tabs',
						'tabs'             => true,
						'value'            => array(
							esc_html__( 'Regular price', 'woodmart' ) => 'main_price',
							esc_html__( 'Old price', 'woodmart' )  => 'old_price',
							esc_html__( 'Suffix', 'woodmart' )     => 'suffix',
						),
						'default'          => 'main_price',
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),

					$typography_price['font_family'],
					$typography_price['font_size'],
					$typography_price['font_weight'],
					$typography_price['text_transform'],
					$typography_price['font_style'],
					$typography_price['line_height'],

					array(
						'heading'          => esc_html__( 'Text color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'main_price_text_color',
						'selectors'        => array(
							'{{WRAPPER}} .price, {{WRAPPER}} .amount, {{WRAPPER}} del' => array(
								'color: {{VALUE}};',
							),
						),
						'wd_dependency'    => array(
							'element' => 'price_style_tabs',
							'value'   => array( 'main_price' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					$typography_old_price['font_family'],
					$typography_old_price['font_size'],
					$typography_old_price['font_weight'],
					$typography_old_price['text_transform'],
					$typography_old_price['font_style'],
					$typography_old_price['line_height'],

					array(
						'heading'          => esc_html__( 'Text color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'old_price_text_color',
						'selectors'        => array(
							'{{WRAPPER}} .price del, {{WRAPPER}} del .amount' => array(
								'color: {{VALUE}};',
							),
						),
						'wd_dependency'    => array(
							'element' => 'price_style_tabs',
							'value'   => array( 'old_price' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					$typography_suffix['font_family'],
					$typography_suffix['font_size'],
					$typography_suffix['font_weight'],
					$typography_suffix['text_transform'],
					$typography_suffix['font_style'],
					$typography_suffix['line_height'],

					array(
						'heading'          => esc_html__( 'Text color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'suffix_text_color',
						'selectors'        => array(
							'{{WRAPPER}} .woocommerce-price-suffix' => array(
								'color: {{VALUE}};',
							),
						),
						'wd_dependency'    => array(
							'element' => 'price_style_tabs',
							'value'   => array( 'suffix' ),
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
	add_action( 'vc_before_init', 'woodmart_vc_map_single_product_price' );
}
