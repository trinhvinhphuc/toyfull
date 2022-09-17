<?php
/**
 * This file creates WOODMART Banner Widget.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
};

if ( ! class_exists( 'WOODMART_Banner_Widget' ) ) {
	/**
	 * Register widget based on VC_MAP parameters that display banner shortcode
	 */
	class WOODMART_Banner_Widget extends WPH_Widget {

		/**
		 * This method creates these widgets.
		 */
		public function __construct() {
			if ( ! function_exists( 'woodmart_get_banner_params' ) ) {
				return;
			};

			$secondary_font = woodmart_get_opt( 'secondary-font' );
			$text_font      = woodmart_get_opt( 'text-font' );
			$primary_font   = woodmart_get_opt( 'primary-font' );

			$secondary_font_title = isset( $secondary_font[0] ) ? esc_html__( 'Secondary', 'woodmart' ) . ' (' . $secondary_font[0]['font-family'] . ')' : esc_html__( 'Secondary', 'woodmart' );
			$text_font_title      = isset( $text_font[0] ) ? esc_html__( 'Text', 'woodmart' ) . ' (' . $text_font[0]['font-family'] . ')' : esc_html__( 'Text', 'woodmart' );
			$primary_font_title   = isset( $primary_font[0] ) ? esc_html__( 'Primary', 'woodmart' ) . ' (' . $primary_font[0]['font-family'] . ')' : esc_html__( 'Primary', 'woodmart' );

			$this->create_widget(
				array(
					'label'       => esc_html__( 'WOODMART Banner', 'woodmart' ),
					'description' => esc_html__( 'Promo banner with text', 'woodmart' ),
					'slug'        => 'woodmart-banner',
					'fields'      => array(
						/**
						 * Image.
						 */
						array(
							'type'       => 'woodmart_title_divider',
							'holder'     => 'div',
							'title'      => esc_html__( 'Image', 'woodmart' ),
							'param_name' => 'image_divider',
						),
						array(
							'type'             => 'attach_image',
							'heading'          => esc_html__( 'Image', 'woodmart' ),
							'param_name'       => 'image',
							'value'            => '',
							'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Image size', 'woodmart' ),
							'param_name'  => 'img_size',
							'description' => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\'.', 'woodmart' ),
						),
						array(
							'type'             => 'woodmart_slider',
							'heading'          => esc_html__( 'Banner height', 'woodmart' ),
							'param_name'       => 'height',
							'min'              => '100',
							'max'              => '2000',
							'step'             => '1',
							'default'          => '300',
							'units'            => 'px',
							'value'            => array(
								'600' => '600',
								'500' => '500',
								'400' => '400',
								'350' => '350',
								'300' => '300',
								'250' => '250',
								'200' => '200',
								'150' => '150',
								'100' => '100',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
							'hint'             => esc_html__( 'Default: 300', 'woodmart' ),
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Image Position', 'woodmart' ),
							'param_name'       => 'image_bg_position',
							'value'            => array(
								esc_html__( 'Center', 'woodmart' ) => 'center',
								esc_html__( 'Top', 'woodmart' )    => 'top',
								esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
								esc_html__( 'Left', 'woodmart' )   => 'left',
								esc_html__( 'Right', 'woodmart' )  => 'right',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'       => 'vc_link',
							'heading'    => esc_html__( 'Banner link', 'woodmart' ),
							'param_name' => 'link',
							'hint'       => esc_html__( 'Enter URL if you want this banner to have a link.', 'woodmart' ),
						),
						/**
						 * Style.
						 */
						array(
							'type'       => 'woodmart_title_divider',
							'holder'     => 'div',
							'title'      => esc_html__( 'Style', 'woodmart' ),
							'param_name' => 'style_divider',
						),
						array(
							'type'             => 'woodmart_image_select',
							'heading'          => esc_html__( 'Banner style', 'woodmart' ),
							'param_name'       => 'style',
							'value'            => array(
								esc_html__( 'Default', 'woodmart' ) => 'default',
								esc_html__( 'Color mask', 'woodmart' ) => 'mask',
								esc_html__( 'Mask with shadow', 'woodmart' ) => 'shadow',
								esc_html__( 'Bordered', 'woodmart' ) => 'border',
								esc_html__( 'Bordered background', 'woodmart' ) => 'background',
								esc_html__( 'Content background', 'woodmart' ) => 'content-background',
							),
							'images_value'     => array(
								'default'            => WOODMART_ASSETS_IMAGES . '/settings/banner-style/default.png',
								'mask'               => WOODMART_ASSETS_IMAGES . '/settings/banner-style/mask.png',
								'shadow'             => WOODMART_ASSETS_IMAGES . '/settings/banner-style/shadow.png',
								'border'             => WOODMART_ASSETS_IMAGES . '/settings/banner-style/border.png',
								'background'         => WOODMART_ASSETS_IMAGES . '/settings/banner-style/background.png',
								'content-background' => WOODMART_ASSETS_IMAGES . '/settings/banner-style/content-background.png',
							),
							'wood_tooltip'     => true,
							'hint'             => esc_html__( 'You can use some of our predefined styles for your banner content.', 'woodmart' ),
							'edit_field_class' => 'vc_col-xs-12 vc_column banner-style',
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Hover effect', 'woodmart' ),
							'param_name'       => 'hover',
							'value'            => array(
								esc_html__( 'Zoom image', 'woodmart' ) => 'zoom',
								esc_html__( 'Parallax', 'woodmart' ) => 'parallax',
								esc_html__( 'Background', 'woodmart' ) => 'background',
								esc_html__( 'Bordered', 'woodmart' ) => 'border',
								esc_html__( 'Zoom reverse', 'woodmart' ) => 'zoom-reverse',
								esc_html__( 'Disable', 'woodmart' ) => 'none',
							),
							'hint'             => esc_html__( 'Set beautiful hover effects for your banner.', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_button_set',
							'heading'          => esc_html__( 'Color Scheme', 'woodmart' ),
							'param_name'       => 'woodmart_color_scheme',
							'value'            => array(
								esc_html__( 'Inherit', 'woodmart' ) => '',
								esc_html__( 'Light', 'woodmart' ) => 'light',
								esc_html__( 'Dark', 'woodmart' )  => 'dark',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_colorpicker',
							'heading'          => esc_html__( 'Content background color', 'woodmart' ),
							'param_name'       => 'custom_content_bg_color',
							'css_args'         => array(
								'background-color' => array(
									' .wrapper-content-banner',
								),
							),
							'dependency'       => array(
								'element' => 'style',
								'value'   => array( 'content-background' ),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						/**
						 * Extra.
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
							'param_name' => 'el_class',
							'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
						),
						/**
						 * Title.
						 */
						array(
							'type'       => 'woodmart_title_divider',
							'holder'     => 'div',
							'title'      => esc_html__( 'Title', 'woodmart' ),
							'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name' => 'title_divider',
						),
						array(
							'type'       => 'textarea',
							'heading'    => esc_html__( 'Title', 'woodmart' ),
							'param_name' => 'title',
							'holder'     => 'div',
							'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Font', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'title_font',
							'value'            => array(
								esc_html__( 'Default', 'woodmart' ) => '',
								$text_font_title      => 'text',
								$primary_font_title   => 'primary',
								$secondary_font_title => 'alt',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Title tag', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'title_tag',
							'value'            => array(
								'h1'   => 'h1',
								'h2'   => 'h2',
								'h3'   => 'h3',
								'h4'   => 'h4',
								'h5'   => 'h5',
								'h6'   => 'h6',
								'p'    => 'p',
								'div'  => 'div',
								'span' => 'span',
							),
							'std'              => 'h4',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Predefined title size', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'title_size',
							'value'            => array(
								esc_html__( 'Default (22px)', 'woodmart' ) => 'default',
								esc_html__( 'Small (16px)', 'woodmart' ) => 'small',
								esc_html__( 'Large (26px)', 'woodmart' ) => 'large',
								esc_html__( 'Extra Large (36px)', 'woodmart' ) => 'extra-large',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Font weight', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'font_weight',
							'value'            => array(
								'' => '',
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
							'type'             => 'woodmart_responsive_size',
							'heading'          => esc_html__( 'Custom font size', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'custom_title_size',
							'css_args'         => array(
								'font-size' => array(
									' .banner-title',
								),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_responsive_size',
							'heading'          => esc_html__( 'Custom line height', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'custom_title_line_height',
							'css_args'         => array(
								'line-height' => array(
									' .banner-title',
								),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'       => 'woodmart_empty_space',
							'param_name' => 'woodmart_empty_space',
							'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
						),
						array(
							'type'             => 'woodmart_colorpicker',
							'heading'          => esc_html__( 'Color', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'custom_title_color',
							'css_args'         => array(
								'color' => array(
									' .banner-title',
								),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						/**
						 * Subtitle.
						 */
						array(
							'type'       => 'woodmart_title_divider',
							'holder'     => 'div',
							'title'      => esc_html__( 'Subtitle', 'woodmart' ),
							'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name' => 'subtitle_divider',
						),
						array(
							'type'       => 'textarea',
							'heading'    => esc_html__( 'Sub title', 'woodmart' ),
							'param_name' => 'subtitle',
							'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Font', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'subtitle_font',
							'value'            => array(
								esc_html__( 'Default', 'woodmart' ) => '',
								$text_font_title      => 'text',
								$primary_font_title   => 'primary',
								$secondary_font_title => 'alt',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Font weight', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'subtitle_font_weight',
							'value'            => array(
								'' => '',
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
							'type'             => 'woodmart_responsive_size',
							'heading'          => esc_html__( 'Size', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'custom_subtitle_size',
							'css_args'         => array(
								'font-size' => array(
									' .banner-subtitle',
								),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_responsive_size',
							'heading'          => esc_html__( 'Line height', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'custom_subtitle_line_height',
							'css_args'         => array(
								'line-height' => array(
									' .banner-subtitle',
								),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'       => 'woodmart_empty_space',
							'param_name' => 'woodmart_empty_space',
							'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
						),
						array(
							'type'             => 'woodmart_dropdown',
							'heading'          => esc_html__( 'Predefined subtitle color scheme', 'woodmart' ),
							'param_name'       => 'subtitle_color',
							'value'            => array(
								esc_html__( 'Default', 'woodmart' ) => 'default',
								esc_html__( 'Primary', 'woodmart' ) => 'primary',
								esc_html__( 'Alternative', 'woodmart' ) => 'alt',
							),
							'style'            => array(
								'default' => '#f3f3f3',
								'primary' => woodmart_get_color_value( 'primary-color', '#7eb934' ),
								'alt'     => woodmart_get_color_value( 'secondary-color', '#fbbc34' ),
							),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_colorpicker',
							'heading'          => esc_html__( 'Custom color', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'custom_subtitle_color',
							'css_args'         => array(
								'color' => array(
									' .banner-subtitle',
								),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_image_select',
							'heading'          => esc_html__( 'Subtitle style', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'subtitle_style',
							'value'            => array(
								esc_html__( 'Default', 'woodmart' ) => 'default',
								esc_html__( 'Background', 'woodmart' ) => 'background',
							),
							'images_value'     => array(
								'default'    => WOODMART_ASSETS_IMAGES . '/settings/subtitle-style/default.png',
								'background' => WOODMART_ASSETS_IMAGES . '/settings/subtitle-style/background.png',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_colorpicker',
							'heading'          => esc_html__( 'Background color', 'woodmart' ),
							'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
							'param_name'       => 'custom_subtitle_bg_color',
							'css_args'         => array(
								'background-color' => array(
									' .banner-subtitle',
								),
							),
							'dependency'       => array(
								'element' => 'subtitle_style',
								'value'   => array( 'background' ),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						/**
						 * Content.
						 */
						array(
							'type'       => 'woodmart_title_divider',
							'holder'     => 'div',
							'title'      => esc_html__( 'Content', 'woodmart' ),
							'group'      => esc_html__( 'Content', 'woodmart' ),
							'param_name' => 'content_divider',
						),
						array(
							'type'       => 'textarea_html',
							'holder'     => 'div',
							'heading'    => esc_html__( 'Banner content', 'woodmart' ),
							'group'      => esc_html__( 'Content', 'woodmart' ),
							'param_name' => 'content',
							'hint'       => esc_html__( 'Add here few words to your banner image.', 'woodmart' ),
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Text size', 'woodmart' ),
							'group'            => esc_html__( 'Content', 'woodmart' ),
							'param_name'       => 'content_text_size',
							'value'            => array(
								esc_html__( 'Default (14px)', 'woodmart' ) => 'default',
								esc_html__( 'Medium (16px)', 'woodmart' ) => 'medium',
								esc_html__( 'Large (18px)', 'woodmart' ) => 'large',
								esc_html__( 'Custom', 'woodmart' ) => 'custom',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_colorpicker',
							'heading'          => esc_html__( 'Color', 'woodmart' ),
							'group'            => esc_html__( 'Content', 'woodmart' ),
							'param_name'       => 'custom_text_color',
							'css_args'         => array(
								'color' => array(
									' .banner-inner',
								),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_responsive_size',
							'heading'          => esc_html__( 'Size', 'woodmart' ),
							'group'            => esc_html__( 'Content', 'woodmart' ),
							'param_name'       => 'custom_text_size',
							'css_args'         => array(
								'font-size' => array(
									' .banner-inner',
								),
							),
							'dependency'       => array(
								'element' => 'content_text_size',
								'value'   => array( 'custom' ),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_responsive_size',
							'heading'          => esc_html__( 'Line height', 'woodmart' ),
							'group'            => esc_html__( 'Content', 'woodmart' ),
							'param_name'       => 'custom_text_line_height',
							'css_args'         => array(
								'line-height' => array(
									' .banner-inner',
								),
							),
							'dependency'       => array(
								'element' => 'content_text_size',
								'value'   => array( 'custom' ),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						/**
						 * Button.
						 */
						array(
							'type'       => 'woodmart_title_divider',
							'holder'     => 'div',
							'title'      => esc_html__( 'Button', 'woodmart' ),
							'group'      => esc_html__( 'Button', 'woodmart' ),
							'param_name' => 'button_divider',
						),
						array(
							'type'             => 'textfield',
							'heading'          => esc_html__( 'Button text', 'woodmart' ),
							'param_name'       => 'btn_text',
							'group'            => esc_html__( 'Button', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_button_set',
							'heading'          => esc_html__( 'Button position', 'woodmart' ),
							'param_name'       => 'btn_position',
							'value'            => array(
								esc_html__( 'Show on hover', 'woodmart' ) => 'hover',
								esc_html__( 'Static', 'woodmart' ) => 'static',
							),
							'group'            => esc_html__( 'Button', 'woodmart' ),
							'dependency'       => array(
								'element'            => 'style',
								'value_not_equal_to' => array( 'content-background' ),
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_dropdown',
							'group'            => esc_html__( 'Button', 'woodmart' ),
							'heading'          => esc_html__( 'Predefined button color', 'woodmart' ),
							'param_name'       => 'btn_color',
							'value'            => array(
								esc_html__( 'Default', 'woodmart' ) => 'default',
								esc_html__( 'Primary color', 'woodmart' ) => 'primary',
								esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
								esc_html__( 'White', 'woodmart' ) => 'white',
								esc_html__( 'Black', 'woodmart' ) => 'black',
							),
							'style'            => array(
								'default' => '#f3f3f3',
								'primary' => woodmart_get_color_value( 'primary-color', '#7eb934' ),
								'alt'     => woodmart_get_color_value( 'secondary-color', '#fbbc34' ),
								'black'   => '#212121',
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Button size', 'woodmart' ),
							'param_name'       => 'btn_size',
							'value'            => array(
								esc_html__( 'Default', 'woodmart' ) => 'default',
								esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
								esc_html__( 'Small', 'woodmart' ) => 'small',
								esc_html__( 'Large', 'woodmart' ) => 'large',
								esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
							),
							'group'            => esc_html__( 'Button', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_image_select',
							'heading'          => esc_html__( 'Button style', 'woodmart' ),
							'group'            => esc_html__( 'Button', 'woodmart' ),
							'param_name'       => 'btn_style',
							'value'            => array(
								esc_html__( 'Default', 'woodmart' ) => 'default',
								esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
								esc_html__( 'Link button', 'woodmart' ) => 'link',
								esc_html__( '3D', 'woodmart' ) => '3d',
							),
							'images_value'     => array(
								'default'  => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/default.png',
								'bordered' => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/bordered.png',
								'link'     => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/link.png',
								'3d'       => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/3d.png',
							),
							'title'            => false,
							'std'              => 'default',
							'edit_field_class' => 'vc_col-xs-12 vc_column button-style',
						),
						array(
							'type'             => 'woodmart_image_select',
							'heading'          => esc_html__( 'Button shape', 'woodmart' ),
							'group'            => esc_html__( 'Button', 'woodmart' ),
							'param_name'       => 'btn_shape',
							'value'            => array(
								esc_html__( 'Rectangle', 'woodmart' ) => 'rectangle',
								esc_html__( 'Circle', 'woodmart' ) => 'round',
								esc_html__( 'Round', 'woodmart' ) => 'semi-round',
							),
							'images_value'     => array(
								'rectangle'  => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/rectangle.png',
								'round'      => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/circle.png',
								'semi-round' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/round.png',
							),
							'dependency'       => array(
								'element'            => 'btn_style',
								'value_not_equal_to' => array( 'round', 'link' ),
							),
							'title'            => false,
							'std'              => 'rectangle',
							'edit_field_class' => 'vc_col-xs-12 vc_column button-shape',
						),
						array(
							'type'             => 'woodmart_switch',
							'heading'          => esc_html__( 'Hide button on tablet', 'woodmart' ),
							'group'            => esc_html__( 'Button', 'woodmart' ),
							'param_name'       => 'hide_btn_tablet',
							'true_state'       => 'yes',
							'false_state'      => 'no',
							'default'          => 'no',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_switch',
							'heading'          => esc_html__( 'Hide button on mobile', 'woodmart' ),
							'group'            => esc_html__( 'Button', 'woodmart' ),
							'param_name'       => 'hide_btn_mobile',
							'true_state'       => 'yes',
							'false_state'      => 'no',
							'default'          => 'no',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						/**
						 * Layouts.
						 */
						array(
							'type'       => 'woodmart_title_divider',
							'holder'     => 'div',
							'title'      => esc_html__( 'Layouts', 'woodmart' ),
							'group'      => esc_html__( 'Layouts', 'woodmart' ),
							'param_name' => 'positioning_divider',
						),
						array(
							'type'             => 'woodmart_image_select',
							'heading'          => esc_html__( 'Content horizontal alignment', 'woodmart' ),
							'group'            => esc_html__( 'Layouts', 'woodmart' ),
							'param_name'       => 'horizontal_alignment',
							'value'            => array(
								esc_html__( 'Left', 'woodmart' ) => 'left',
								esc_html__( 'Center', 'woodmart' ) => 'center',
								esc_html__( 'Right', 'woodmart' ) => 'right',
							),
							'images_value'     => array(
								'left'   => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/left.png',
								'center' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/center.png',
								'right'  => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/right.png',
							),
							'std'              => 'left',
							'wood_tooltip'     => true,
							'edit_field_class' => 'vc_col-sm-6 vc_column content-position',
						),
						array(
							'type'             => 'woodmart_image_select',
							'heading'          => esc_html__( 'Content vertical alignment', 'woodmart' ),
							'param_name'       => 'vertical_alignment',
							'group'            => esc_html__( 'Layouts', 'woodmart' ),
							'value'            => array(
								esc_html__( 'Top', 'woodmart' ) => 'top',
								esc_html__( 'Middle', 'woodmart' ) => 'middle',
								esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
							),
							'images_value'     => array(
								'top'    => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/top.png',
								'middle' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/middle.png',
								'bottom' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/bottom.png',
							),
							'std'              => 'top',
							'wood_tooltip'     => true,
							'edit_field_class' => 'vc_col-sm-6 vc_column content-position',
						),
						array(
							'type'             => 'woodmart_image_select',
							'heading'          => esc_html__( 'Text alignment', 'woodmart' ),
							'group'            => esc_html__( 'Layouts', 'woodmart' ),
							'param_name'       => 'text_alignment',
							'value'            => array(
								esc_html__( 'Left', 'woodmart' ) => 'left',
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
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Content width', 'woodmart' ),
							'group'            => esc_html__( 'Layouts', 'woodmart' ),
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
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'             => 'woodmart_switch',
							'heading'          => esc_html__( 'Increase spaces', 'woodmart' ),
							'group'            => esc_html__( 'Layouts', 'woodmart' ),
							'param_name'       => 'increase_spaces',
							'hint'             => esc_html__( 'Suggest to use this option if you have large banners. Padding will be set in percentage to your screen width.', 'woodmart' ),
							'true_state'       => 'yes',
							'false_state'      => 'no',
							'default'          => 'no',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						/**
						 * Deprecated.
						 */
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Title desktop text size ( > 1024px )', 'woodmart' ),
							'param_name' => 'title_desktop_text_size',
							'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
							'group'      => esc_html__( 'Custom size', 'woodmart' ),
							'dependency' => array(
								'element' => 'title_size',
								'value'   => array( 'custom' ),
							),
						),
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Title tablet text size ( < 1024px )', 'woodmart' ),
							'param_name' => 'title_tablet_text_size',
							'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
							'group'      => esc_html__( 'Custom size', 'woodmart' ),
							'dependency' => array(
								'element' => 'title_size',
								'value'   => array( 'custom' ),
							),
						),
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Title mobile text size ( < 767px )', 'woodmart' ),
							'param_name' => 'title_mobile_text_size',
							'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
							'group'      => esc_html__( 'Custom size', 'woodmart' ),
							'dependency' => array(
								'element' => 'title_size',
								'value'   => array( 'custom' ),
							),
						),
						/**
						 * Subtitle custom size.
						 */
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Subtitle desktop text size ( > 1024px )', 'woodmart' ),
							'param_name' => 'subtitle_desktop_text_size',
							'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
							'group'      => esc_html__( 'Custom size', 'woodmart' ),
							'dependency' => array(
								'element' => 'title_size',
								'value'   => array( 'custom' ),
							),
						),
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Subtitle tablet text size ( < 1024px )', 'woodmart' ),
							'param_name' => 'subtitle_tablet_text_size',
							'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
							'group'      => esc_html__( 'Custom size', 'woodmart' ),
							'dependency' => array(
								'element' => 'title_size',
								'value'   => array( 'custom' ),
							),
						),
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Subtitle mobile text size ( < 767px )', 'woodmart' ),
							'param_name' => 'subtitle_mobile_text_size',
							'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
							'group'      => esc_html__( 'Custom size', 'woodmart' ),
							'dependency' => array(
								'element' => 'title_size',
								'value'   => array( 'custom' ),
							),
						),
					),
				)
			);
		}

		/**
		 * This method render this widget.
		 *
		 * @param array $args general settings for this widget.
		 * @param array $instance the value of the options for output.
		 */
		public function widget( $args, $instance ) {
			extract( $args );

			echo wp_kses_post( $before_widget );

			echo woodmart_shortcode_promo_banner( $instance, $instance['content'] );

			echo wp_kses_post( $after_widget );
		}
	}
}
