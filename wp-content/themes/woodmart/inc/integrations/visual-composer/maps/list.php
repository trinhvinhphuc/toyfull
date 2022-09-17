<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_vc_map_list' ) ) {
	function woodmart_vc_map_list() {
		if ( ! shortcode_exists( 'woodmart_list' ) ) {
			return;
		}

		vc_map(
			array(
				'name'        => esc_html__( 'List', 'woodmart' ),
				'base'        => 'woodmart_list',
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
				'description' => esc_html__( 'Display a list with icon', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/list.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),
					// General.
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'General settings', 'woodmart' ),
						'param_name' => 'general_divider',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'List items font size', 'woodmart' ),
						'param_name'       => 'size',
						'value'            => array(
							esc_html__( 'Default (14px)', 'woodmart' ) => 'default',
							esc_html__( 'Medium (16px)', 'woodmart' ) => 'medium',
							esc_html__( 'Large (18px)', 'woodmart' ) => 'large',
							esc_html__( 'Extra Large (22px)', 'woodmart' ) => 'extra-large',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_button_set',
						'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
						'param_name'       => 'color_scheme',
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => '',
							esc_html__( 'Light', 'woodmart' ) => 'light',
							esc_html__( 'Dark', 'woodmart' )  => 'dark',
							esc_html__( 'Custom', 'woodmart' )  => 'custom',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_colorpicker',
						'heading'          => esc_html__( 'Text color', 'woodmart' ),
						'param_name'       => 'text_color',
						'css_args'         => array(
							'color' => array(
								' li',
							),
						),
						'dependency'       => array(
							'element' => 'color_scheme',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_colorpicker',
						'heading'          => esc_html__( 'Text color hover', 'woodmart' ),
						'param_name'       => 'text_color_hover',
						'css_args'         => array(
							'color' => array(
								' li:hover',
							),
						),
						'dependency'       => array(
							'element' => 'color_scheme',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_image_select',
						'heading'          => esc_html__( 'Align', 'woodmart' ),
						'param_name'       => 'align',
						'value'            => array(
							esc_html__( 'Left', 'woodmart' )  => 'left',
							esc_html__( 'Center', 'woodmart' ) => 'center',
							esc_html__( 'Right', 'woodmart' ) => 'right',
						),
						'images_value'     => array(
							'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
							'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
							'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
						),
						'std'              => 'left',
						'wood_tooltip'     => true,
						'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
					),
					array(
						'type'             => 'wd_slider',
						'param_name'       => 'list_items_gap',
						'heading'          => esc_html__( 'List items gap', 'woodmart' ),
						'devices'          => array(
							'desktop' => array(
								'unit'  => 'px',
								'value' => 15,
							),
							'tablet'  => array(
								'unit'  => 'px',
								'value' => 0,
							),
							'mobile'  => array(
								'unit'  => 'px',
								'value' => 0,
							),
						),
						'range'            => array(
							'px' => array(
								'min'  => 0,
								'max'  => 100,
								'step' => 1,
							),
						),
						'selectors'        => array(
							'{{WRAPPER}}.wd-list' => array(
								'--li-mb: {{VALUE}}{{UNIT}};',
							),
						),
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Extra settings', 'woodmart' ),
						'param_name' => 'extra_divider',
					),
					( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
						'param_name' => 'el_class',
						'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
					),
					// List.
					array(
						'type'       => 'param_group',
						'param_name' => 'list',
						'group'      => esc_html__( 'List', 'woodmart' ),
						'params'     => array(
							array(
								'type'       => 'vc_link',
								'heading'    => esc_html__( 'Link', 'woodmart' ),
								'param_name' => 'link',
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Content', 'woodmart' ),
								'param_name' => 'list-content',
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Item icon type', 'woodmart' ),
								'value'            => array(
									esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
									esc_html__( 'With image', 'woodmart' ) => 'image',
								),
								'param_name'       => 'item_type',
								'edit_field_class' => 'vc_col-sm-6 vc_column',
							),
							array(
								'type'             => 'attach_image',
								'heading'          => esc_html__( 'Custom image', 'woodmart' ),
								'param_name'       => 'image_id',
								'value'            => '',
								'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
								'edit_field_class' => 'vc_col-sm-6 vc_column',
								'dependency'       => array(
									'element' => 'item_type',
									'value'   => array( 'image' ),
								),
							),
							array(
								'type'             => 'textfield',
								'heading'          => esc_html__( 'Image size', 'woodmart' ),
								'param_name'       => 'item_image_size',
								'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x50 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
								'dependency'       => array(
									'element' => 'item_type',
									'value'   => array( 'image' ),
								),
								'edit_field_class' => 'vc_col-sm-6 vc_column',
								'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x50\'.', 'woodmart' ),
							),
						),
					),
					// Icon.
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Icon settings', 'woodmart' ),
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'param_name' => 'icon_divider',
					),
					array(
						'type'             => 'dropdown',
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'heading'          => esc_html__( 'List icon type', 'woodmart' ),
						'value'            => array(
							esc_html__( 'With icon', 'woodmart' ) => 'icon',
							esc_html__( 'With image', 'woodmart' ) => 'image',
							esc_html__( 'Ordered', 'woodmart' ) => 'ordered',
							esc_html__( 'Unordered', 'woodmart' ) => 'unordered',
							esc_html__( 'Without icon', 'woodmart' ) => 'without',
						),
						'param_name'       => 'list_type',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'dropdown',
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'heading'          => esc_html__( 'List style', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Rounded', 'woodmart' ) => 'rounded',
							esc_html__( 'Square', 'woodmart' ) => 'square',
						),
						'param_name'       => 'list_style',
						'dependency'       => array(
							'element' => 'list_type',
							'value'   => array( 'icon', 'ordered', 'unordered' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'attach_image',
						'heading'          => esc_html__( 'Image', 'woodmart' ),
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'param_name'       => 'image',
						'value'            => '',
						'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
						'dependency'       => array(
							'element' => 'list_type',
							'value'   => array( 'image' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Image size', 'woodmart' ),
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'param_name'       => 'img_size',
						'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x50 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
						'dependency'       => array(
							'element' => 'list_type',
							'value'   => array( 'image' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x50\'.', 'woodmart' ),
					),
					array(
						'type'       => 'dropdown',
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'heading'    => esc_html__( 'Icon library', 'woodmart' ),
						'value'      => array(
							esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
							esc_html__( 'Open Iconic', 'woodmart' ) => 'openiconic',
							esc_html__( 'Typicons', 'woodmart' ) => 'typicons',
							esc_html__( 'Entypo', 'woodmart' ) => 'entypo',
							esc_html__( 'Linecons', 'woodmart' ) => 'linecons',
							esc_html__( 'Mono Social', 'woodmart' ) => 'monosocial',
							esc_html__( 'Material', 'woodmart' ) => 'material',
						),
						'param_name' => 'icon_library',
						'hint'       => esc_html__( 'Select icon library.', 'woodmart' ),
						'dependency' => array(
							'element' => 'list_type',
							'value'   => 'icon',
						),
					),
					array(
						'type'       => 'iconpicker',
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'param_name' => 'icon_fontawesome',
						'value'      => 'far fa-bell',
						'settings'   => array(
							'emptyIcon'    => false,
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_library',
							'value'   => 'fontawesome',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'type'       => 'iconpicker',
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'param_name' => 'icon_openiconic',
						'settings'   => array(
							'emptyIcon'    => false,
							'type'         => 'openiconic',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_library',
							'value'   => 'openiconic',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'type'       => 'iconpicker',
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'param_name' => 'icon_typicons',
						'settings'   => array(
							'emptyIcon'    => false,
							'type'         => 'typicons',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_library',
							'value'   => 'typicons',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'type'       => 'iconpicker',
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'param_name' => 'icon_entypo',
						'settings'   => array(
							'emptyIcon'    => false,
							'type'         => 'entypo',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_library',
							'value'   => 'entypo',
						),
					),
					array(
						'type'       => 'iconpicker',
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'param_name' => 'icon_linecons',
						'settings'   => array(
							'emptyIcon'    => false,
							'type'         => 'linecons',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_library',
							'value'   => 'linecons',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'type'       => 'iconpicker',
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'param_name' => 'icon_monosocial',
						'settings'   => array(
							'emptyIcon'    => false,
							'type'         => 'monosocial',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_library',
							'value'   => 'monosocial',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'type'       => 'iconpicker',
						'group'      => esc_html__( 'Icon', 'woodmart' ),
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'param_name' => 'icon_material',
						'settings'   => array(
							'emptyIcon'    => false,
							'type'         => 'material',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_library',
							'value'   => 'material',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'type'             => 'woodmart_colorpicker',
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'heading'          => esc_html__( 'Icons color', 'woodmart' ),
						'param_name'       => 'icons_color',
						'css_args'         => array(
							'color' => array(
								' .list-icon',
							),
						),
						'dependency'       => array(
							'element' => 'list_type',
							'value'   => array( 'icon', 'ordered', 'unordered' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_colorpicker',
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'heading'          => esc_html__( 'Icons color hover', 'woodmart' ),
						'param_name'       => 'icons_color_hover',
						'css_args'         => array(
							'color' => array(
								' li:hover .list-icon',
							),
						),
						'dependency'       => array(
							'element' => 'list_type',
							'value'   => array( 'icon', 'ordered', 'unordered' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_colorpicker',
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'heading'          => esc_html__( 'Icons background color', 'woodmart' ),
						'param_name'       => 'icons_bg_color',
						'css_args'         => array(
							'background-color' => array(
								' .list-icon',
							),
						),
						'dependency'       => array(
							'element' => 'list_style',
							'value'   => array( 'rounded', 'square' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_colorpicker',
						'group'            => esc_html__( 'Icon', 'woodmart' ),
						'heading'          => esc_html__( 'Icons background color hover', 'woodmart' ),
						'param_name'       => 'icons_bg_color_hover',
						'css_args'         => array(
							'background-color' => array(
								' li:hover .list-icon',
							),
						),
						'dependency'       => array(
							'element' => 'list_style',
							'value'   => array( 'rounded', 'square' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					// Style.
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
	add_action( 'vc_before_init', 'woodmart_vc_map_list' );
}
