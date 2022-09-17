<?php
/**
 * Maps for off canvas button element.
 *
 * @package Elements.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_vc_map_off_canvas_btn' ) ) {

	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_vc_map_off_canvas_btn() {
		if ( ! shortcode_exists( 'woodmart_off_canvas_btn' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_off_canvas_btn',
				'name'        => esc_html__( 'Off canvas column button', 'woodmart' ),
				'description' => esc_html__( 'Button for off canvas column', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/off-canvas-column-button.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),
					/**
					 * General settings.
					 */
					array(
						'param_name' => 'button_text',
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Button text', 'woodmart' ),
						'std'        => 'Show column',
					),
					array(
						'param_name'       => 'sticky',
						'type'             => 'woodmart_switch',
						'heading'          => esc_html__( 'Sticky', 'woodmart' ),
						'hint'             => esc_html__( 'Make the off canvas sidebar button sticky.', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'std'              => 'no',
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),
					/**
					 * Icon settings.
					 */
					array(
						'param_name' => 'icon_style_section',
						'type'       => 'woodmart_title_divider',
						'title'      => esc_html__( 'Icon', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
					),
					array(
						'param_name'       => 'icon_type',
						'type'             => 'woodmart_dropdown',
						'heading'          => esc_html__( 'Type', 'woodmart' ),
						'std'              => 'default',
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-12 vc_column',
						'value'            => array(
							esc_html__( 'Without icon', 'woodmart' ) => 'without',
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Custom image', 'woodmart' ) => 'custom',
						),
					),
					array(
						'param_name'       => 'img_id',
						'type'             => 'attach_image',
						'heading'          => esc_html__( 'Image', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-12 vc_column',
						'dependency'       => array(
							'element' => 'icon_type',
							'value'   => array( 'custom' ),
						),
					),
					array(
						'param_name'       => 'img_size',
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Image size', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-12 vc_column',
						'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'20x20\' size.', 'woodmart' ),
						'dependency'       => array(
							'element' => 'icon_type',
							'value'   => array( 'custom' ),
						),
					),
					// Design Options tab.
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS box', 'woodmart' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design Options', 'js_composer' ),
					),
					woodmart_get_vc_responsive_spacing_map(),

					/**
					 * Advanced tab.
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

	add_action( 'vc_before_init', 'woodmart_vc_map_off_canvas_btn' );
}
