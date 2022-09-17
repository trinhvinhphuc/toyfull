<?php
/**
 * Accordion for accordion element.
 *
 * @package Elements.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_vc_map_accordion' ) ) {

	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_vc_map_accordion() {
		if ( ! shortcode_exists( 'woodmart_accordion' ) ) {
			return;
		}

		$secondary_font = woodmart_get_opt( 'secondary-font' );
		$primary_font   = woodmart_get_opt( 'primary-font' );
		$text_font      = woodmart_get_opt( 'text-font' );

		$secondary_font_title = isset( $secondary_font[0] ) ? esc_html__( 'Secondary font', 'woodmart' ) . ' (' . $secondary_font[0]['font-family'] . ')' : esc_html__( 'Secondary font', 'woodmart' );
		$text_font_title      = isset( $text_font[0] ) ? esc_html__( 'Text font', 'woodmart' ) . ' (' . $text_font[0]['font-family'] . ')' : esc_html__( 'Text', 'woodmart' );
		$primary_font_title   = isset( $primary_font[0] ) ? esc_html__( 'Title font', 'woodmart' ) . ' (' . $primary_font[0]['font-family'] . ')' : esc_html__( 'Title font', 'woodmart' );

		vc_map(
			array(
				'base'            => 'woodmart_accordion',
				'name'            => esc_html__( 'Accordion', 'woodmart' ),
				'description'     => esc_html__( 'Tabbed content', 'woodmart' ),
				'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
				'icon'            => WOODMART_ASSETS . '/images/vc-icon/accordion.svg',
				'as_parent'       => array( 'only' => 'woodmart_accordion_item' ),
				'content_element' => true,
				'js_view'         => 'VcColumnView',
				'default_content' => '[woodmart_accordion_item title="Accordion title"]Ac non ac hac ullamcorper rhoncus velit maecenas convallis torquent elit accumsan eu est pulvinar pretium congue a vestibulum suspendisse scelerisque condimentum parturient quam.Aliquet faucibus condimentum amet nam a nascetur suspendisse habitant a mollis senectus suscipit a vestibulum primis molestie parturient aptent nisi aenean.A scelerisque quam consectetur condimentum risus lobortis cum dignissim mi fusce primis rhoncus a rhoncus bibendum parturient condimentum odio a justo a et mollis pulvinar venenatis metus sodales elementum.Parturient ullamcorper natoque mi sagittis a nibh nisi a suspendisse a.[/woodmart_accordion_item][woodmart_accordion_item title="Accordion title"]Ac non ac hac ullamcorper rhoncus velit maecenas convallis torquent elit accumsan eu est pulvinar pretium congue a vestibulum suspendisse scelerisque condimentum parturient quam.Aliquet faucibus condimentum amet nam a nascetur suspendisse habitant a mollis senectus suscipit a vestibulum primis molestie parturient aptent nisi aenean.A scelerisque quam consectetur condimentum risus lobortis cum dignissim mi fusce primis rhoncus a rhoncus bibendum parturient condimentum odio a justo a et mollis pulvinar venenatis metus sodales elementum.Parturient ullamcorper natoque mi sagittis a nibh nisi a suspendisse a.[/woodmart_accordion_item][woodmart_accordion_item title="Accordion title"]Ac non ac hac ullamcorper rhoncus velit maecenas convallis torquent elit accumsan eu est pulvinar pretium congue a vestibulum suspendisse scelerisque condimentum parturient quam.Aliquet faucibus condimentum amet nam a nascetur suspendisse habitant a mollis senectus suscipit a vestibulum primis molestie parturient aptent nisi aenean.A scelerisque quam consectetur condimentum risus lobortis cum dignissim mi fusce primis rhoncus a rhoncus bibendum parturient condimentum odio a justo a et mollis pulvinar venenatis metus sodales elementum.Parturient ullamcorper natoque mi sagittis a nibh nisi a suspendisse a.[/woodmart_accordion_item]',
				'params'          => array(
					/**
					 * General Settings.
					 */
					array(
						'param_name' => 'woodmart_css_id',
						'type'       => 'woodmart_css_id',
						'group'      => esc_html__( 'Title', 'woodmart' ),
					),
					array(
						'param_name' => 'accordion_general_divider',
						'type'       => 'woodmart_title_divider',
						'title'      => esc_html__( 'Style', 'woodmart' ),
						'group'      => esc_html__( 'Title', 'woodmart' ),
						'holder'     => 'div',
					),
					array(
						'param_name'       => 'style',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Style', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Shadow', 'woodmart' ) => 'shadow',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'state',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Items state', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							esc_html__( 'First opened', 'woodmart' ) => 'first',
							esc_html__( 'All closed', 'woodmart' ) => 'all_closed',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'wd_box_shadow',
						'param_name'       => 'box_shadow',
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'heading'          => esc_html__( 'Box shadow', 'woodmart' ),
						'selectors'        => array(
							'{{WRAPPER}}.wd-style-shadow .wd-accordion-item' => array(
								'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
							),
						),
						'edit_field_class' => 'vc_col-sm-12 vc_column',
						'dependency'       => array(
							'element' => 'style',
							'value'   => array( 'shadow' ),
						),
						'default'          => array(
							'horizontal' => '0',
							'vertical'   => '0',
							'blur'       => '9',
							'spread'     => '0',
							'color'      => 'rgba(0, 0, 0, .15)',
						),
					),

					array(
						'param_name'       => 'title_text_alignment',
						'type'             => 'woodmart_image_select',
						'heading'          => esc_html__( 'Alignment', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Left', 'woodmart' ) => 'left',
							esc_html__( 'Right', 'woodmart' ) => 'right',
						),
						'images_value'     => array(
							'left'  => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
							'right' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
						),
						'std'              => 'left',
						'wood_tooltip'     => true,
						'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
					),
					/**
					 * Title Settings.
					 */
					array(
						'param_name' => 'accordion_typography_divider',
						'type'       => 'woodmart_title_divider',
						'title'      => esc_html__( 'Typography', 'woodmart' ),
						'group'      => esc_html__( 'Title', 'woodmart' ),
						'holder'     => 'div',
					),
					array(
						'param_name'       => 'title_font_family',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Font family', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							$primary_font_title   => 'primary',
							$text_font_title      => 'text',
							$secondary_font_title => 'alt',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'title_font_size',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Predefined size', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Small (16px)', 'woodmart' ) => 's',
							esc_html__( 'Extra Small (14px)', 'woodmart' ) => 'xs',
							esc_html__( 'Medium (18px)', 'woodmart' ) => 'm',
							esc_html__( 'Large (22px)', 'woodmart' ) => 'l',
							esc_html__( 'Extra Large (26px)', 'woodmart' ) => 'xl',
							esc_html__( 'Custom', 'woodmart' ) => 'custom',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'title_custom_font_size',
						'type'             => 'woodmart_responsive_size',
						'heading'          => esc_html__( 'Custom font size', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'css_args'         => array(
							'font-size' => array(
								' .wd-fontsize-custom',
							),
						),
						'dependency'       => array(
							'element' => 'title_font_size',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'title_line_height',
						'type'             => 'woodmart_responsive_size',
						'heading'          => esc_html__( 'Custom line height', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'css_args'         => array(
							'line-height' => array(
								' .wd-fontsize-custom',
							),
						),
						'dependency'       => array(
							'element' => 'title_font_size',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'title_font_weight',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Font weight', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => '',
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
						'std'              => 600,
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'title_text_color_scheme',
						'type'             => 'woodmart_dropdown',
						'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
							esc_html__( 'Dark', 'woodmart' ) => 'dark',
							esc_html__( 'Light', 'woodmart' ) => 'light',
							esc_html__( 'Custom', 'woodmart' ) => 'custom',
						),
						'style'            => array(
							'dark' => '#2d2a2a',
						),
						'std'              => 'inherit',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'custom_title_text_color',
						'type'             => 'woodmart_colorpicker',
						'heading'          => esc_html__( 'Text color', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'css_args'         => array(
							'color' => array(
								' .wd-accordion-title-text',
							),
						),
						'dependency'       => array(
							'element' => 'title_text_color_scheme',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'custom_title_text_hover_color',
						'type'             => 'woodmart_colorpicker',
						'heading'          => esc_html__( 'Text hover color', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'css_args'         => array(
							'color' => array(
								' .wd-accordion-title-text:hover',
							),
						),
						'dependency'       => array(
							'element' => 'title_text_color_scheme',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'custom_title_text_active_color',
						'type'             => 'woodmart_colorpicker',
						'heading'          => esc_html__( 'Text active color', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'css_args'         => array(
							'color' => array(
								'.wd-accordion:not(.wd-inited) .wd-accordion-item:first-child .wd-accordion-title-text',
								' .wd-accordion-title.wd-active .wd-accordion-title-text',
							),
						),
						'dependency'       => array(
							'element' => 'title_text_color_scheme',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					/**
					 * Opener.
					 */
					array(
						'param_name' => 'accordion_opener_divider',
						'type'       => 'woodmart_title_divider',
						'title'      => esc_html__( 'Opener', 'woodmart' ),
						'group'      => esc_html__( 'Title', 'woodmart' ),
						'holder'     => 'div',
					),
					array(
						'param_name'       => 'opener_style',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Style', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Arrow', 'woodmart' ) => 'arrow',
							esc_html__( 'Plus', 'woodmart' ) => 'plus',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'opener_alignment',
						'type'             => 'woodmart_image_select',
						'heading'          => esc_html__( 'Alignment', 'woodmart' ),
						'group'            => esc_html__( 'Title', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Left', 'woodmart' ) => 'left',
							esc_html__( 'Right', 'woodmart' ) => 'right',
						),
						'images_value'     => array(
							'left'  => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
							'right' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
						),
						'std'              => 'left',
						'wood_tooltip'     => true,
						'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
					),
					/**
					 * Content Settings.
					 */
					array(
						'param_name' => 'content_typography_divider',
						'type'       => 'woodmart_title_divider',
						'title'      => esc_html__( 'Typography', 'woodmart' ),
						'group'      => esc_html__( 'Content', 'woodmart' ),
						'holder'     => 'div',
					),
					array(
						'param_name'       => 'content_font_family',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Font family', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => '',
							$primary_font_title   => 'primary',
							$text_font_title      => 'text',
							$secondary_font_title => 'alt',
						),
						'std'              => '',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'content_font_size',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Predefined size', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => '',
							esc_html__( 'Small (16px)', 'woodmart' ) => 's',
							esc_html__( 'Extra Small (14px)', 'woodmart' ) => 'xs',
							esc_html__( 'Medium (18px)', 'woodmart' ) => 'm',
							esc_html__( 'Large (22px)', 'woodmart' ) => 'l',
							esc_html__( 'Extra Large (26px)', 'woodmart' ) => 'xl',
							esc_html__( 'Custom', 'woodmart' ) => 'custom',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'content_custom_font_size',
						'type'             => 'woodmart_responsive_size',
						'heading'          => esc_html__( 'Custom font size', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'css_args'         => array(
							'font-size' => array(
								' .wd-fontsize-custom',
							),
						),
						'dependency'       => array(
							'element' => 'content_font_size',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'content_line_height',
						'type'             => 'woodmart_responsive_size',
						'heading'          => esc_html__( 'Custom line height', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'css_args'         => array(
							'line-height' => array(
								' .wd-fontsize-custom',
							),
						),
						'dependency'       => array(
							'element' => 'content_font_size',
							'value'   => array( 'custom' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'content_font_weight',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Font weight', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => '',
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
						'param_name'       => 'content_text_color_scheme',
						'type'             => 'woodmart_dropdown',
						'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
							esc_html__( 'Dark', 'woodmart' ) => 'dark',
							esc_html__( 'Light', 'woodmart' ) => 'light',
							esc_html__( 'Custom', 'woodmart' ) => 'custom',
						),
						'style'            => array(
							'dark' => '#2d2a2a',
						),
						'std'              => 'inherit',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name' => 'content_text_color_custom',
						'type'       => 'woodmart_colorpicker',
						'heading'    => esc_html__( 'Custom Color', 'woodmart' ),
						'group'      => esc_html__( 'Content', 'woodmart' ),
						'css_args'   => array(
							'color' => array(
								' .wd-accordion-content',
							),
						),
						'dependency' => array(
							'element' => 'content_text_color_scheme',
							'value'   => array( 'custom' ),
						),
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS box', 'woodmart' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design Options', 'js_composer' ),
					),
					/**
					 * Animations Settings.
					 */
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Woodmart Animation', 'woodmart' ),
						'hint'             => esc_html__( 'Use custom theme animations if you want to run them in the slider element.' ),
						'param_name'       => 'wd_animation',
						'group'            => esc_html__( 'Advanced', 'woodmart' ),
						'admin_label'      => true,
						'value'            => array(
							esc_html__( 'None', 'woodmart' )       => '',
							esc_html__( 'Slide from top', 'woodmart' ) => 'slide-from-top',
							esc_html__( 'Slide from bottom', 'woodmart' ) => 'slide-from-bottom',
							esc_html__( 'Slide from left', 'woodmart' ) => 'slide-from-left',
							esc_html__( 'Slide from right', 'woodmart' ) => 'slide-from-right',
							esc_html__( 'Slide short from left', 'woodmart' ) => 'slide-short-from-left',
							esc_html__( 'Flip X bottom', 'woodmart' ) => 'bottom-flip-x',
							esc_html__( 'Flip X top', 'woodmart' ) => 'top-flip-x',
							esc_html__( 'Flip Y left', 'woodmart' ) => 'left-flip-y',
							esc_html__( 'Flip Y right', 'woodmart' ) => 'right-flip-y',
							esc_html__( 'Zoom in', 'woodmart' )    => 'zoom-in',
						),
						'std'              => '',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Woodmart Animation Delay (ms)', 'woodmart' ),
						'param_name'       => 'wd_animation_delay',
						'group'            => esc_html__( 'Advanced', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'dependency'       => array(
							'element'            => 'wd_animation',
							'value_not_equal_to' => array( '' ),
						),
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Woodmart Animation duration', 'woodmart' ),
						'param_name'       => 'wd_animation_duration',
						'group'            => esc_html__( 'Advanced', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'value'            => array(
							esc_html__( 'Slow', 'woodmart' )   => 'slow',
							esc_html__( 'Normal', 'woodmart' ) => 'normal',
							esc_html__( 'Fast', 'woodmart' )   => 'fast',
						),
						'dependency'       => array(
							'element'            => 'wd_animation',
							'value_not_equal_to' => array( '' ),
						),
						'std'              => 'normal',
					),

					woodmart_get_vc_responsive_spacing_map(),

					woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
					woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),
				),
			)
		);

		vc_map(
			array(
				'base'            => 'woodmart_accordion_item',
				'name'            => esc_html__( 'Accordion Item', 'woodmart' ),
				'description'     => esc_html__( 'Add accordion item in accordion area', 'woodmart' ),
				'category'        => esc_html__( 'woodmart_accordion', 'woodmart' ),
				'icon'            => WOODMART_ASSETS . '/images/vc-icon/accordion-item.svg',
				'as_child'        => array( 'only' => 'woodmart_accordion' ),
				'content_element' => true,
				'params'          => array(
					/**
					 * Title.
					 */
					array(
						'param_name' => 'title',
						'type'       => 'textarea',
						'holder'     => 'div',
						'heading'    => esc_html__( 'Title', 'woodmart' ),
					),
					/**
					 * Content.
					 */
					array(
						'param_name' => 'content_divider',
						'type'       => 'woodmart_title_divider',
						'title'      => esc_html__( 'Content', 'woodmart' ),
					),
					array(
						'param_name'       => 'content_type',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Content type', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Text', 'woodmart' ) => 'text',
							esc_html__( 'HTML Block', 'woodmart' ) => 'html_block',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name' => 'content',
						'type'       => 'textarea_html',
						'heading'    => esc_html__( 'Content', 'woodmart' ),
						'dependency' => array(
							'element' => 'content_type',
							'value'   => array( 'text' ),
						),
					),
					array(
						'param_name' => 'html_block_id',
						'type'       => 'woodmart_dropdown',
						'heading'    => esc_html__( 'Select block', 'woodmart' ),
						'callback'   => 'woodmart_get_html_blocks_array_with_empty',
						'dependency' => array(
							'element' => 'content_type',
							'value'   => array( 'html_block' ),
						),
					),

					/**
					 * Icon.
					 */
					array(
						'param_name' => 'icon_divider',
						'type'       => 'woodmart_title_divider',
						'title'      => esc_html__( 'Icon settings', 'woodmart' ),
						'holder'     => 'div',
					),
					array(
						'param_name'       => 'icon_type',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'List type', 'woodmart' ),
						'value'            => array(
							esc_html__( 'With icon', 'woodmart' ) => 'icon',
							esc_html__( 'With image', 'woodmart' ) => 'image',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'image',
						'type'             => 'attach_image',
						'heading'          => esc_html__( 'Image', 'woodmart' ),
						'value'            => '',
						'dependency'       => array(
							'element' => 'icon_type',
							'value'   => array( 'image' ),
						),
						'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'image_size',
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Image size', 'woodmart' ),
						'dependency'       => array(
							'element' => 'icon_type',
							'value'   => array( 'image' ),
						),
						'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
						'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name'       => 'icon_libraries',
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Icon library', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
							esc_html__( 'Open Iconic', 'woodmart' )  => 'openiconic',
							esc_html__( 'Typicons', 'woodmart' )     => 'typicons',
							esc_html__( 'Entypo', 'woodmart' )       => 'entypo',
							esc_html__( 'Linecons', 'woodmart' )     => 'linecons',
							esc_html__( 'Mono Social', 'woodmart' )  => 'monosocial',
							esc_html__( 'Material', 'woodmart' )     => 'material',
						),
						'dependency'       => array(
							'element' => 'icon_type',
							'value'   => 'icon',
						),
						'hint'             => esc_html__( 'Select icon library.', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'param_name' => 'icon_fontawesome',
						'type'       => 'iconpicker',
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'settings'   => array(
							'emptyIcon'    => true,
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_libraries',
							'value'   => 'fontawesome',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'param_name' => 'icon_openiconic',
						'type'       => 'iconpicker',
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'settings'   => array(
							'emptyIcon'    => true,
							'type'         => 'openiconic',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_libraries',
							'value'   => 'openiconic',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'param_name' => 'icon_typicons',
						'type'       => 'iconpicker',
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'settings'   => array(
							'emptyIcon'    => true,
							'type'         => 'typicons',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_libraries',
							'value'   => 'typicons',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'param_name' => 'icon_entypo',
						'type'       => 'iconpicker',
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'settings'   => array(
							'emptyIcon'    => true,
							'type'         => 'entypo',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_libraries',
							'value'   => 'entypo',
						),
					),
					array(
						'param_name' => 'icon_linecons',
						'type'       => 'iconpicker',
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'settings'   => array(
							'emptyIcon'    => true,
							'type'         => 'linecons',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_libraries',
							'value'   => 'linecons',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'param_name' => 'icon_monosocial',
						'type'       => 'iconpicker',
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'settings'   => array(
							'emptyIcon'    => true,
							'type'         => 'monosocial',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_libraries',
							'value'   => 'monosocial',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
					array(
						'param_name' => 'icon_material',
						'type'       => 'iconpicker',
						'heading'    => esc_html__( 'Icon', 'woodmart' ),
						'settings'   => array(
							'emptyIcon'    => true,
							'type'         => 'material',
							'iconsPerPage' => 50,
						),
						'dependency' => array(
							'element' => 'icon_libraries',
							'value'   => 'material',
						),
						'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
					),
				),
			)
		);

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			/**
			 * Create woodmart accordion wrapper.
			 */
			class WPBakeryShortCode_woodmart_accordion extends WPBakeryShortCodesContainer {}

		}
	}

	add_action( 'vc_before_init', 'woodmart_vc_map_accordion' );
}
