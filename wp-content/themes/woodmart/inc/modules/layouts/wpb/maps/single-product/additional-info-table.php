<?php
/**
 * Additional info table map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_product_additional_info_table' ) ) {
	/**
	 * Additional info table map.
	 */
	function woodmart_vc_map_single_product_additional_info_table() {
		if ( ! shortcode_exists( 'woodmart_single_product_additional_info_table' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_single_product_additional_info_table',
				'name'        => esc_html__( 'Product additional information table', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'Attributes, dimensions, and weight', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-additional-information-table.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					// General.
					array(
						'title'      => esc_html__( 'General', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'general_divider',
					),

					array(
						'heading'          => esc_html__( 'Layout', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'layout',
						'value'            => array(
							esc_html__( 'List', 'woodmart' ) => 'list',
							esc_html__( 'Grid', 'woodmart' ) => 'grid',
						),
						'wood_tooltip'     => true,
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'style',
						'value'            => array(
							esc_html__( 'Default', 'woodmart' )  => 'default',
							esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						),
						'std'              => 'bordered',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'    => esc_html__( 'Columns', 'woodmart' ),
						'type'       => 'wd_slider',
						'param_name' => 'columns',
						'selectors'  => array(
							'{{WRAPPER}} .shop_attributes' => array(
								'--wd-attr-col: {{VALUE}};',
							),
						),
						'devices'    => array(
							'desktop' => array(
								'value' => '',
								'unit'  => '-',
							),
							'tablet'  => array(
								'value' => '',
								'unit'  => '-',
							),
							'mobile'  => array(
								'value' => '',
								'unit'  => '-',
							),
						),
						'range'      => array(
							'-' => array(
								'min'  => 1,
								'max'  => 6,
								'step' => 1,
							),
						),
					),

					array(
						'heading'    => esc_html__( 'Vertical spacing', 'woodmart' ),
						'type'       => 'wd_slider',
						'param_name' => 'vertical_gap',
						'selectors'  => array(
							'{{WRAPPER}} .shop_attributes' => array(
								'--wd-attr-v-gap: {{VALUE}}{{UNIT}};',
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
								'max'  => 150,
								'step' => 1,
							),
						),
					),

					array(
						'heading'    => esc_html__( 'Horizontal spacing', 'woodmart' ),
						'type'       => 'wd_slider',
						'param_name' => 'horizontal_gap',
						'selectors'  => array(
							'{{WRAPPER}} .shop_attributes' => array(
								'--wd-attr-h-gap: {{VALUE}}{{UNIT}};',
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
								'max'  => 150,
								'step' => 1,
							),
						),
					),

					// Image.
					array(
						'title'      => esc_html__( 'Image', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'image_divider',
					),

					array(
						'heading'     => esc_html__( 'Width', 'woodmart' ),
						'description' => esc_html__( 'Attribute image container width', 'woodmart' ),
						'type'        => 'wd_slider',
						'param_name'  => 'image_width',
						'selectors'   => array(
							'{{WRAPPER}} .shop_attributes' => array(
								'--wd-attr-img-width: {{VALUE}}{{UNIT}};',
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
	add_action( 'vc_before_init', 'woodmart_vc_map_single_product_additional_info_table' );
}
