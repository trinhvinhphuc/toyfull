<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_vc_map_text_block' ) ) {
	function woodmart_vc_map_text_block() {
		if ( ! shortcode_exists( 'woodmart_text_block' ) ) {
			return;
		}

		$secondary_font = woodmart_get_opt( 'secondary-font' );
		$primary_font   = woodmart_get_opt( 'primary-font' );

		$secondary_font_title = isset( $secondary_font[0] ) ? esc_html__( 'Secondary font', 'woodmart' ) . ' (' . $secondary_font[0]['font-family'] . ')' : esc_html__( 'Secondary font', 'woodmart' );
		$primary_font_title   = isset( $primary_font[0] ) ? esc_html__( 'Title font', 'woodmart' ) . ' (' . $primary_font[0]['font-family'] . ')' : esc_html__( 'Title font', 'woodmart' );

		vc_map(
			array(
				'name'        => esc_html__( 'Text block', 'woodmart' ),
				'base'        => 'woodmart_text_block',
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
				'description' => esc_html__( 'A block of text', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/text-block.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),
					/**
					 * Content.
					 */
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Content', 'woodmart' ),
						'param_name' => 'content_divider',
					),
					array(
						'type'       => 'textarea_html',
						'holder'     => 'div',
						'heading'    => esc_html__( 'Text', 'woodmart' ),
						'param_name' => 'content',
						'std'        => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					),
					array(
						'type'             => 'woodmart_button_set',
						'heading'          => esc_html__( 'Color Scheme', 'woodmart' ),
						'param_name'       => 'text_color_scheme',
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
							esc_html__( 'Light', 'woodmart' ) => 'light',
							esc_html__( 'Dark', 'woodmart' ) => 'dark',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					/**
					 * Paragraph.
					 */
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Paragraph', 'woodmart' ),
						'param_name' => 'paragraph_divider',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Text font', 'woodmart' ),
						'param_name'       => 'text_font_family',
						'value'            => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							$primary_font_title   => 'primary',
							$secondary_font_title => 'alt',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Font size', 'woodmart' ),
						'param_name'       => 'text_font_size',
						'value'            => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Extra Small (14px)', 'woodmart' ) => 'xs',
							esc_html__( 'Small (16px)', 'woodmart' ) => 's',
							esc_html__( 'Medium (18px)', 'woodmart' ) => 'm',
							esc_html__( 'Large (22px)', 'woodmart' ) => 'l',
							esc_html__( 'Extra Large (26px)', 'woodmart' ) => 'xl',
							esc_html__( 'XXL (36px)', 'woodmart' ) => 'xxl',
							esc_html__( 'XXXL (46px)', 'woodmart' ) => 'xxxl',
							esc_html__( 'Custom', 'woodmart' ) => 'custom',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_responsive_size',
						'heading'          => esc_html__( 'Size', 'woodmart' ),
						'param_name'       => 'text_font_size_custom',
						'css_args'         => array(
							'font-size' => array(
								'.wd-text-block',
							),
						),
						'dependency'       => array(
							'element' => 'text_font_size',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_responsive_size',
						'heading'          => esc_html__( 'Line height', 'woodmart' ),
						'param_name'       => 'text_line_height_custom',
						'css_args'         => array(
							'line-height' => array(
								'.wd-text-block',
							),
						),
						'dependency'       => array(
							'element' => 'text_font_size',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'       => 'woodmart_empty_space',
						'param_name' => 'woodmart_empty_space',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Font weight', 'woodmart' ),
						'param_name'       => 'text_font_weight',
						'value'            => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Ultra-Light 100', 'woodmart' ) => 100,
							esc_html__( 'Light 200', 'woodmart' ) => 200,
							esc_html__( 'Book 300', 'woodmart' ) => 300,
							esc_html__( 'Normal 400', 'woodmart' ) => 400,
							esc_html__( 'Medium 500', 'woodmart' ) => 500,
							esc_html__( 'Semi-Bold 600', 'woodmart' ) => 600,
							esc_html__( 'Bold 700', 'woodmart' ) => 700,
							esc_html__( 'Extra-Bold 800', 'woodmart' ) => 800,
							esc_html__( 'Ultra-Bold 900', 'woodmart' ) => 900,
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_dropdown',
						'heading'          => esc_html__( 'Color', 'woodmart' ),
						'param_name'       => 'text_color',
						'value'            => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Title', 'woodmart' ) => 'title',
							esc_html__( 'Primary', 'woodmart' ) => 'primary',
							esc_html__( 'Alternative', 'woodmart' ) => 'alt',
							esc_html__( 'Custom', 'woodmart' ) => 'custom',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'       => 'woodmart_colorpicker',
						'heading'    => esc_html__( 'Custom Color', 'woodmart' ),
						'param_name' => 'text_color_custom',
						'css_args'   => array(
							'color' => array(
								'.wd-text-block',
							),
						),
						'dependency' => array(
							'element' => 'text_color',
							'value'   => array( 'custom' ),
						),
					),
					/**
					 * Layout
					 */
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Layout', 'woodmart' ),
						'param_name' => 'layout_divider',
					),
					array(
						'type'             => 'woodmart_image_select',
						'heading'          => esc_html__( 'Text align', 'woodmart' ),
						'param_name'       => 'text_align',
						'value'            => array(
							esc_html__( 'Left', 'woodmart' )   => 'left',
							esc_html__( 'Center', 'woodmart' ) => 'center',
							esc_html__( 'Right', 'woodmart' )  => 'right',
						),
						'images_value'     => array(
							'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
							'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
							'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
						),
						'wood_tooltip'     => true,
						'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Content width', 'woodmart' ),
						'param_name'       => 'content_width',
						'value'            => array(
							'100%' => '100',
							'90%'  => '90',
							'80%'  => '80',
							'70%'  => '70',
							'60%'  => '60',
							'50%'  => '50',
							'40%'  => '40',
							'30%'  => '30',
							'20%'  => '20',
							'10%'  => '10',
							esc_html__( 'Custom', 'woodmart' ) => 'custom',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_button_set',
						'heading'          => esc_html__( 'Custom content width', 'woodmart' ),
						'param_name'       => 'custom_content_width',
						'tabs'             => true,
						'value'            => array(
							esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
							esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
							esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
						),
						'default'          => 'desktop',
						'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
						'dependency'       => array(
							'element' => 'content_width',
							'value'   => array( 'custom' ),
						),
					),
					array(
						'type'             => 'woodmart_slider',
						'param_name'       => 'content_desktop_width',
						'min'              => '0',
						'max'              => '1000',
						'step'             => '1',
						'default'          => '600',
						'units'            => 'px',
						'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
						'css_args'         => array(
							'--wd-max-width' => array(
								'',
							),
						),
						'css_params'       => array(
							'device' => 'desktop',
						),
						'wd_dependency'    => array(
							'element' => 'custom_content_width',
							'value'   => array( 'desktop' ),
						),
						'dependency'       => array(
							'element' => 'content_width',
							'value'   => array( 'custom' ),
						),
					),
					array(
						'type'             => 'woodmart_slider',
						'heading'          => esc_html__( 'Content tablet width', 'woodmart' ),
						'param_name'       => 'content_tablet_width',
						'min'              => '0',
						'max'              => '1000',
						'step'             => '1',
						'default'          => '0',
						'units'            => 'px',
						'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
						'css_args'         => array(
							'--wd-max-width' => array(
								'',
							),
						),
						'css_params'       => array(
							'device' => 'tablet',
						),
						'wd_dependency'    => array(
							'element' => 'custom_content_width',
							'value'   => array( 'tablet' ),
						),
						'dependency'       => array(
							'element' => 'content_width',
							'value'   => array( 'custom' ),
						),
					),
					array(
						'type'             => 'woodmart_slider',
						'heading'          => esc_html__( 'Content mobile width', 'woodmart' ),
						'param_name'       => 'content_mobile_width',
						'min'              => '0',
						'max'              => '1000',
						'step'             => '1',
						'default'          => '0',
						'units'            => 'px',
						'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
						'css_args'         => array(
							'--wd-max-width' => array(
								'',
							),
						),
						'css_params'       => array(
							'device' => 'mobile',
						),
						'wd_dependency'    => array(
							'element' => 'custom_content_width',
							'value'   => array( 'mobile' ),
						),
						'dependency'       => array(
							'element' => 'content_width',
							'value'   => array( 'custom' ),
						),
					),
					woodmart_get_vc_display_inline_map(),
					/**
					 * Extra
					 */
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Extra options', 'woodmart' ),
						'param_name' => 'extra_divider',
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS box', 'woodmart' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design Options', 'js_composer' ),
					),
					woodmart_get_vc_responsive_spacing_map(),

					woodmart_parallax_scroll_map( 'parallax_scroll' ),
					woodmart_parallax_scroll_map( 'scroll_x' ),
					woodmart_parallax_scroll_map( 'scroll_y' ),
					woodmart_parallax_scroll_map( 'scroll_z' ),
					woodmart_parallax_scroll_map( 'scroll_smooth' ),

					woodmart_get_vc_animation_map( 'wd_animation' ),
					woodmart_get_vc_animation_map( 'wd_animation_delay' ),
					woodmart_get_vc_animation_map( 'wd_animation_duration' ),

					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
						'param_name' => 'extra_classes',
						'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
					),

					woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),
				),
			)
		);
	}

	add_action( 'vc_before_init', 'woodmart_vc_map_text_block' );
}
