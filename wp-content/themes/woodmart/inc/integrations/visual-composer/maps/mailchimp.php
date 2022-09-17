<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_vc_map_mailchimp' ) ) {
	function woodmart_vc_map_mailchimp() {
		if ( ! shortcode_exists( 'woodmart_mailchimp' ) ) {
			return;
		}

		vc_map(
			array(
				'name'        => esc_html__( 'Mailchimp', 'woodmart' ),
				'base'        => 'woodmart_mailchimp',
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
				'description' => esc_html__( 'Newsletter subscription form', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/mailchimp.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Form', 'woodmart' ),
						'param_name' => 'extra_divider',
					),
					array(
						'type'             => 'woodmart_dropdown',
						'heading'          => esc_html__( 'Select form', 'woodmart' ),
						'param_name'       => 'form_id',
						'callback'         => 'woodmart_get_mailchimp_forms',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_button_set',
						'heading'          => esc_html__( 'Color Scheme', 'woodmart' ),
						'param_name'       => 'color_scheme',
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
							esc_html__( 'Light', 'woodmart' ) => 'light',
							esc_html__( 'Dark', 'woodmart' ) => 'dark',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Layout', 'woodmart' ),
						'param_name' => 'extra_divider',
					),
					array(
						'type'             => 'woodmart_image_select',
						'heading'          => esc_html__( 'Alignment', 'woodmart' ),
						'param_name'       => 'alignment',
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
						'std'              => 'center',
					),
					array(
						'type'             => 'wd_slider',
						'param_name'       => 'form_width',
						'heading'          => esc_html__( 'Form Width', 'woodmart' ),
						'devices'          => array(
							'desktop' => array(
								'unit'  => '%',
								'value' => 100,
							),
							'tablet'  => array(
								'unit'  => '%',
								'value' => '',
							),
							'mobile'  => array(
								'unit'  => '%',
								'value' => '',
							),
						),
						'range'            => array(
							'%'  => array(
								'min'  => 0,
								'max'  => 100,
								'step' => 1,
							),
							'px' => array(
								'min'  => 0,
								'max'  => 1000,
								'step' => 1,
							),
						),
						'selectors'        => array(
							'{{WRAPPER}}' => array(
								'--wd-max-width: {{VALUE}}{{UNIT}};',
							),
						),
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),

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
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
						'param_name' => 'extra_classes',
						'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS box', 'woodmart' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design Options', 'js_composer' ),
					),
					woodmart_get_vc_responsive_spacing_map(),
				),
			)
		);
	}

	add_action( 'vc_before_init', 'woodmart_vc_map_mailchimp' );
}
