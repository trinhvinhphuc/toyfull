<?php
/**
 * This file adds some custom properties to the WPB editor.
 *
 * @package Woodmart.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

// **********************************************************************//
// Features that add GLOBAL maps to WPB Composer
// **********************************************************************//

if ( ! function_exists( 'woodmart_vc_row_custom_options' ) ) {
	/**
	 * Update custom params map to Default Row element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_row_custom_options() {
		$general_options = array(
			/**
			 * CSS ID Option.
			 */
			array(
				'type'       => 'woodmart_css_id',
				'param_name' => 'woodmart_css_id',
			),
		);

		$design_options = array(
			/**
			 * Responsive Spacing Option.
			 */
			array(
				'type'       => 'woodmart_responsive_spacing',
				'param_name' => 'responsive_spacing',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
			),
			/**
			 * Background Position Option.
			 */
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Background position', 'woodmart' ),
				'param_name'       => 'woodmart_bg_position',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'value'            => array(
					esc_html__( 'None', 'woodmart' )       => '',
					esc_html__( 'Left top', 'woodmart' )   => 'left-top',
					esc_html__( 'Left center', 'woodmart' ) => 'left-center',
					esc_html__( 'Left bottom', 'woodmart' ) => 'left-bottom',
					esc_html__( 'Right top', 'woodmart' )  => 'right-top',
					esc_html__( 'Right center', 'woodmart' ) => 'right-center',
					esc_html__( 'Right bottom', 'woodmart' ) => 'right-bottom',
					esc_html__( 'Center top', 'woodmart' ) => 'center-top',
					esc_html__( 'Center center', 'woodmart' ) => 'center-center',
					esc_html__( 'Center bottom', 'woodmart' ) => 'center-bottom',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Disable background image', 'woodmart' ),
				'param_name'       => 'responsive_tabs',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			/**
			 * Disable background image on mobile Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on mobile devices', 'woodmart' ),
				'param_name'       => 'mobile_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Disable background image on tablet Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on tablet devices', 'woodmart' ),
				'param_name'       => 'tablet_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'tablet' ),
				),
			),
			/**
			 * Parallax Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background parallax', 'woodmart' ),
				'param_name'       => 'woodmart_parallax',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
		);

		$advanced_options = array(
			/**
			 * Z Index Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_z_index',
				'heading'          => esc_html__( 'Z Index', 'woodmart' ),
				'hint'             => esc_html__( 'Enable this option if you would like to display this element above other elements on the page. You can specify a custom value as well.', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_number',
				'param_name'       => 'wd_z_index_custom',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'devices'          => array(
					'desktop' => array(
						'value' => 35,
					),
				),
				'min'              => -1,
				'max'              => 1000,
				'step'             => 1,
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'z-index: {{VALUE}}',
					),
				),
				'dependency'       => array(
					'element' => 'wd_z_index',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Disable overflow.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Disable "overflow:hidden;"', 'woodmart' ),
				'hint'             => esc_html__( 'Use this option if you have some elements inside this row that needs to overflow the boundaries. Examples: mega menu, filters, search with categories dropdowns.', 'woodmart' ),
				'param_name'       => 'woodmart_disable_overflow',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Row reverse', 'woodmart' ),
				'param_name'       => 'responsive_tabs_advanced',
				'hint'             => esc_html__( 'Reverse row columns on mobile and tablet devices.', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'content_width',
					'value'   => array( 'custom' ),
				),
			),
			/**
			 * Row reverse mobile.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'row_reverse_mobile',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_advanced',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Row reverse tablet.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'row_reverse_tablet',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_advanced',
					'value'   => array( 'tablet' ),
				),
			),
		);

		/**
		 * Gradient option.
		 */
		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$design_options[] = array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background gradient', 'woodmart' ),
				'param_name'       => 'woodmart_gradient_switch',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			);

			$design_options[] = array(
				'type'       => 'woodmart_gradient',
				'param_name' => 'woodmart_color_gradient',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
				'dependency' => array(
					'element' => 'woodmart_gradient_switch',
					'value'   => array( 'yes' ),
				),
			);
		}

		/**
		 * Box Shadow Option.
		 */
		$design_options[] = array(
			'type'             => 'woodmart_switch',
			'heading'          => esc_html__( 'Box Shadow', 'woodmart' ),
			'group'            => esc_html__( 'Design Options', 'js_composer' ),
			'param_name'       => 'woodmart_box_shadow',
			'true_state'       => 'yes',
			'false_state'      => 'no',
			'default'          => 'no',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		);

		$design_options[] = array(
			'type'             => 'wd_box_shadow',
			'param_name'       => 'wd_box_shadow',
			'group'            => esc_html__( 'Design Options', 'js_composer' ),
			'selectors'        => array(
				'{{WRAPPER}}' => array(
					'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				),
			),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'dependency'       => array(
				'element' => 'woodmart_box_shadow',
				'value'   => array( 'yes' ),
			),
			'default'          => array(
				'horizontal' => '0',
				'vertical'   => '0',
				'blur'       => '9',
				'spread'     => '0',
				'color'      => 'rgba(0, 0, 0, .15)',
			),
		);

		vc_add_params( 'vc_row', $general_options );
		vc_add_params( 'vc_row', $design_options );
		vc_add_params( 'vc_row', $advanced_options );

		vc_add_params( 'vc_row_inner', $general_options );
		vc_add_params( 'vc_row_inner', $design_options );
		vc_add_params( 'vc_row_inner', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_row_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_column_custom_options' ) ) {
	/**
	 * Update custom params map to Default Column element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_column_custom_options() {
		$general_options = array(
			/**
			 * CSS ID Option.
			 */
			array(
				'type'       => 'woodmart_css_id',
				'param_name' => 'woodmart_css_id',
			),
			/**
			 * Color Scheme Param.
			 */
			array(
				'type'       => 'woodmart_button_set',
				'heading'    => esc_html__( 'Color Scheme', 'woodmart' ),
				'param_name' => 'woodmart_color_scheme',
				'value'      => array(
					esc_html__( 'Inherit', 'woodmart' ) => '',
					esc_html__( 'Light', 'woodmart' )   => 'light',
					esc_html__( 'Dark', 'woodmart' )    => 'dark',
				),
			),
			/**
			 * Parallax On Scroll Option.
			 */
			woodmart_parallax_scroll_map( 'parallax_scroll' ),
			woodmart_parallax_scroll_map( 'scroll_x' ),
			woodmart_parallax_scroll_map( 'scroll_y' ),
			woodmart_parallax_scroll_map( 'scroll_z' ),
			woodmart_parallax_scroll_map( 'scroll_smooth' ),
			/**
			 * Enable sticky column Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Enable sticky column', 'woodmart' ),
				'description'      => esc_html__( 'Also enable equal columns height for the parent row to make it work', 'woodmart' ),
				'param_name'       => 'woodmart_sticky_column',
				'true_state'       => 'true',
				'false_state'      => 'false',
				'default'          => 'false',
				'dependency'       => array(
					'element' => 'wd_column_role',
					'value'   => array( '' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Sticky column offset', 'woodmart' ),
				'param_name'       => 'woodmart_sticky_column_offset',
				'dependency'       => array(
					'element' => 'woodmart_sticky_column',
					'value'   => array( 'true' ),
				),
				'value'            => 150,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Text align Option.
			 */
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Text align', 'woodmart' ),
				'param_name'       => 'woodmart_text_align',
				'value'            => array(
					esc_html__( 'Choose', 'woodmart' ) => '',
					esc_html__( 'Left', 'woodmart' )   => 'left',
					esc_html__( 'Center', 'woodmart' ) => 'center',
					esc_html__( 'Right', 'woodmart' )  => 'right',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Collapsible content Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Collapsible content', 'woodmart' ),
				'hint'             => esc_html__( 'Limit the column height and add the "Read more" button. IMPORTANT: you need to add our "Button" element to the end of this column and enable an appropriate option there as well.', 'woodmart' ),
				'param_name'       => 'wd_collapsible_content_switcher',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'dependency'       => array(
					'element' => 'wd_column_role',
					'value'   => array( '' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_slider',
				'param_name'       => 'wd_collapsible_content_max_height',
				'heading'          => esc_html__( 'Column content height', 'woodmart' ),
				'devices'          => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 300,
					),
					'tablet'  => array(
						'unit'  => 'px',
						'value' => 200,
					),
					'mobile'  => array(
						'unit'  => 'px',
						'value' => 100,
					),
				),
				'range'            => array(
					'px' => array(
						'min'  => 1,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'selectors'        => array(
					'{{WRAPPER}}.wd-collapsible-content > .vc_column-inner' => array(
						'max-height: {{VALUE}}{{UNIT}};',
					),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'wd_collapsible_content_switcher',
					'value'   => array( 'yes' ),
				),
			),
			array(
				'type'       => 'wd_colorpicker',
				'param_name' => 'wd_collapsible_content_fade_out_color',
				'heading'    => esc_html__( 'Fade out color', 'woodmart' ),
				'selectors'  => array(
					'{{WRAPPER}}.wd-collapsible-content:not(.wd-opened) .wpb_wrapper:after' => array(
						'color: {{VALUE}};',
					),
				),
				'default'    => array(
					'value' => '#fff',
				),
				'dependency' => array(
					'element' => 'wd_collapsible_content_switcher',
					'value'   => array( 'yes' ),
				),
			),
			/** Vertical Alignment */
			array(
				'type'             => 'wd_select',
				'heading'          => esc_html__( 'Vertical alignment', 'woodmart' ),
				'param_name'       => 'vertical_alignment',
				'style'            => 'select',
				'selectors'        => array(
					'{{WRAPPER}} > .vc_column-inner > .wpb_wrapper' => array(
						'align-items: {{VALUE}};',
					),
				),
				'devices'          => array(
					'desktop' => array(
						'value' => '',
					),
					'tablet'  => array(
						'value' => '',
					),
					'mobile'  => array(
						'value' => '',
					),
				),
				'value'            => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Top', 'woodmart' )     => 'flex-start',
					esc_html__( 'Middle', 'woodmart' )  => 'center',
					esc_html__( 'Bottom', 'woodmart' )  => 'flex-end',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/** Horizontal Alignment */
			array(
				'type'             => 'wd_select',
				'heading'          => esc_html__( 'Horizontal alignment', 'woodmart' ),
				'param_name'       => 'horizontal_alignment',
				'style'            => 'select',
				'selectors'        => array(
					'{{WRAPPER}} > .vc_column-inner > .wpb_wrapper' => array(
						'justify-content: {{VALUE}}',
					),
				),
				'devices'          => array(
					'desktop' => array(
						'value' => '',
					),
					'tablet'  => array(
						'value' => '',
					),
					'mobile'  => array(
						'value' => '',
					),
				),
				'value'            => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Start', 'woodmart' )   => 'flex-start',
					esc_html__( 'Center', 'woodmart' )  => 'center',
					esc_html__( 'End', 'woodmart' )     => 'flex-end',
					esc_html__( 'Space Between', 'woodmart' ) => 'space-between',
					esc_html__( 'Space Around', 'woodmart' ) => 'space-around',
					esc_html__( 'Space Evenly', 'woodmart' ) => 'space-evenly',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/** Off canvas column */
			array(
				'type'             => 'dropdown',
				'heading'          => __( 'Column role for "off-canvas layout"', 'woodmart' ),
				'description'      => esc_html__( 'You can create your page layout with an off-canvas sidebar. In this case, you need to have two columns: one will be set as the off-canvas sidebar and another as the content. NOTE: you need to also display the Off-canvas button element somewhere in your content column to open the sidebar. Also, you need to enable them on specific devices synchronously.', 'woodmart' ),
				'param_name'       => 'wd_column_role',
				'value'            => array(
					esc_html__( 'None', 'woodmart' ) => '',
					esc_html__( 'Off canvas column', 'woodmart' ) => 'offcanvas',
					esc_html__( 'Content column', 'woodmart' ) => 'content',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Desktop', 'woodmart' ),
				'param_name'       => 'wd_column_role_offcanvas_desktop',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'offcanvas' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Tablet', 'woodmart' ),
				'param_name'       => 'wd_column_role_offcanvas_tablet',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'offcanvas' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Mobile', 'woodmart' ),
				'param_name'       => 'wd_column_role_offcanvas_mobile',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'offcanvas' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Desktop', 'woodmart' ),
				'param_name'       => 'wd_column_role_content_desktop',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'content' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Tablet', 'woodmart' ),
				'param_name'       => 'wd_column_role_content_tablet',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'content' ),
				),
			),
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Mobile', 'woodmart' ),
				'param_name'       => 'wd_column_role_content_mobile',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'wd_dependency'    => array(
					'element' => 'wd_column_role',
					'value'   => array( 'content' ),
				),
			),
			array(
				'type'          => 'woodmart_button_set',
				'heading'       => esc_html__( 'Off canvas alignment', 'woodmart' ),
				'param_name'    => 'wd_off_canvas_alignment',
				'value'         => array(
					esc_html__( 'Left', 'woodmart' )  => 'left',
					esc_html__( 'Right', 'woodmart' ) => 'right',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'wd_dependency' => array(
					'element' => 'wd_column_role',
					'value'   => array( 'offcanvas' ),
				),
			),
		);

		$design_option = array(
			/**
			 * Background Position Option.
			 */
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Background position', 'woodmart' ),
				'param_name'       => 'woodmart_bg_position',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'value'            => array(
					esc_html__( 'None', 'woodmart' )       => '',
					esc_html__( 'Left top', 'woodmart' )   => 'left-top',
					esc_html__( 'Left center', 'woodmart' ) => 'left-center',
					esc_html__( 'Left bottom', 'woodmart' ) => 'left-bottom',
					esc_html__( 'Right top', 'woodmart' )  => 'right-top',
					esc_html__( 'Right center', 'woodmart' ) => 'right-center',
					esc_html__( 'Right bottom', 'woodmart' ) => 'right-bottom',
					esc_html__( 'Center top', 'woodmart' ) => 'center-top',
					esc_html__( 'Center center', 'woodmart' ) => 'center-center',
					esc_html__( 'Center bottom', 'woodmart' ) => 'center-bottom',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Disable background image', 'woodmart' ),
				'param_name'       => 'responsive_tabs',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'content_width',
					'value'   => array( 'custom' ),
				),
			),
			/**
			 * Hide bg img on mobile.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on mobile devices', 'woodmart' ),
				'param_name'       => 'mobile_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Hide bg img on tablet.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on tablet devices', 'woodmart' ),
				'param_name'       => 'tablet_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'tablet' ),
				),
			),
			/**
			 * Parallax Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background parallax', 'woodmart' ),
				'param_name'       => 'woodmart_parallax',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Box Shadow Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Box Shadow', 'woodmart' ),
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'param_name'       => 'woodmart_box_shadow',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_box_shadow',
				'param_name'       => 'wd_box_shadow',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'selectors'        => array(
					'{{WRAPPER}} > .vc_column-inner' => array(
						'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
					),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'woodmart_box_shadow',
					'value'   => array( 'yes' ),
				),
				'default'          => array(
					'horizontal' => '0',
					'vertical'   => '0',
					'blur'       => '9',
					'spread'     => '0',
					'color'      => 'rgba(0, 0, 0, .15)',
				),
			),
			/**
			 * Responsive Spacing Option.
			 */
			array(
				'type'       => 'woodmart_responsive_spacing',
				'param_name' => 'responsive_spacing',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
			),
		);

		$responsive_options = array(
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Reset margin (deprecated)', 'woodmart' ),
				'param_name'       => 'responsive_tabs_advanced',
				'group'            => esc_html__( 'Responsive Options', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element' => 'content_width',
					'value'   => array( 'custom' ),
				),
			),
			/**
			 * Reset margin (deprecated) on mobile Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'mobile_reset_margin',
				'group'            => esc_html__( 'Responsive Options', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_advanced',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Reset margin (deprecated) on tablet Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'tablet_reset_margin',
				'group'            => esc_html__( 'Responsive Options', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_advanced',
					'value'   => array( 'tablet' ),
				),
			),
		);

		$advanced_options = array(
			/**
			 * Z Index.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_z_index',
				'heading'          => esc_html__( 'Z Index', 'woodmart' ),
				'hint'             => esc_html__( 'Enable this option if you would like to display this element above other elements on the page. You can specify a custom value as well.', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_number',
				'param_name'       => 'wd_z_index_custom',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'devices'          => array(
					'desktop' => array(
						'value' => 35,
					),
				),
				'min'              => -1,
				'max'              => 1000,
				'step'             => 1,
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'z-index: {{VALUE}}',
					),
				),
				'dependency'       => array(
					'element' => 'wd_z_index',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
		);

		vc_add_params( 'vc_column', $general_options );
		vc_add_params( 'vc_column', $design_option );
		vc_add_params( 'vc_column', $responsive_options );
		vc_add_params( 'vc_column', $advanced_options );

		vc_add_params( 'vc_column_inner', $general_options );
		vc_add_params( 'vc_column_inner', $design_option );
		vc_add_params( 'vc_column_inner', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_column_custom_options' );

}

if ( ! function_exists( 'woodmart_vc_section_custom_options' ) ) {
	/**
	 * Update custom params map to Default Section element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_section_custom_options() {
		$general_options = array(
			/**
			 * CSS ID Option.
			 */
			array(
				'type'       => 'woodmart_css_id',
				'param_name' => 'woodmart_css_id',
			),
		);

		$design_options = array(
			/**
			 * Responsive Spacing Option.
			 */
			array(
				'type'       => 'woodmart_responsive_spacing',
				'param_name' => 'responsive_spacing',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
			),
			/**
			 * Background position Option.
			 */
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Background position', 'woodmart' ),
				'param_name'       => 'woodmart_bg_position',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'value'            => array(
					esc_html__( 'None', 'woodmart' )       => '',
					esc_html__( 'Left top', 'woodmart' )   => 'left-top',
					esc_html__( 'Left center', 'woodmart' ) => 'left-center',
					esc_html__( 'Left bottom', 'woodmart' ) => 'left-bottom',
					esc_html__( 'Right top', 'woodmart' )  => 'right-top',
					esc_html__( 'Right center', 'woodmart' ) => 'right-center',
					esc_html__( 'Right bottom', 'woodmart' ) => 'right-bottom',
					esc_html__( 'Center top', 'woodmart' ) => 'center-top',
					esc_html__( 'Center center', 'woodmart' ) => 'center-center',
					esc_html__( 'Center bottom', 'woodmart' ) => 'center-bottom',
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Responsive Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Disable background image', 'woodmart' ),
				'param_name'       => 'responsive_tabs',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			/**
			 * Disable background image on mobile Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on mobile devices', 'woodmart' ),
				'param_name'       => 'mobile_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'mobile' ),
				),
			),
			/**
			 * Disable background image on tablet Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'hint'             => esc_html__( 'Turn on to reset background image on tablet devices', 'woodmart' ),
				'param_name'       => 'tablet_bg_img_hidden',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'tablet' ),
				),
			),
			/**
			 * Parallax Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background parallax', 'woodmart' ),
				'param_name'       => 'woodmart_parallax',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
		);

		$advanced_options = array(
			/**
			 * Z Index Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_z_index',
				'heading'          => esc_html__( 'Z Index', 'woodmart' ),
				'hint'             => esc_html__( 'Enable this option if you would like to display this element above other elements on the page. You can specify a custom value as well.', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				'type'             => 'wd_number',
				'param_name'       => 'wd_z_index_custom',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'devices'          => array(
					'desktop' => array(
						'value' => 35,
					),
				),
				'min'              => -1,
				'max'              => 1000,
				'step'             => 1,
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'z-index: {{VALUE}}',
					),
				),
				'dependency'       => array(
					'element' => 'wd_z_index',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			/**
			 * Disable Overflow Option.
			 */
			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Disable "overflow:hidden;"', 'woodmart' ),
				'hint'             => esc_html__( 'Use this option if you have some elements inside this row that needs to overflow the boundaries. Examples: mega menu, filters, search with categories dropdowns.', 'woodmart' ),
				'param_name'       => 'woodmart_disable_overflow',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),

		);

		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$design_options[] = array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Background gradient', 'woodmart' ),
				'param_name'       => 'woodmart_gradient_switch',
				'group'            => esc_html__( 'Design Options', 'js_composer' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			);

			$design_options[] = array(
				'type'       => 'woodmart_gradient',
				'param_name' => 'woodmart_color_gradient',
				'group'      => esc_html__( 'Design Options', 'js_composer' ),
				'dependency' => array(
					'element' => 'woodmart_gradient_switch',
					'value'   => array( 'yes' ),
				),
			);
		}

		/**
		 * Box Shadow Option.
		 */
		$design_options[] = array(
			'type'             => 'woodmart_switch',
			'heading'          => esc_html__( 'Box Shadow', 'woodmart' ),
			'group'            => esc_html__( 'Design Options', 'js_composer' ),
			'param_name'       => 'woodmart_box_shadow',
			'true_state'       => 'yes',
			'false_state'      => 'no',
			'default'          => 'no',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		);
		$design_options[] = array(
			'type'             => 'wd_box_shadow',
			'param_name'       => 'wd_box_shadow',
			'group'            => esc_html__( 'Design Options', 'js_composer' ),
			'selectors'        => array(
				'{{WRAPPER}}' => array(
					'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				),
			),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'dependency'       => array(
				'element' => 'woodmart_box_shadow',
				'value'   => array( 'yes' ),
			),
			'default'          => array(
				'horizontal' => '0',
				'vertical'   => '0',
				'blur'       => '9',
				'spread'     => '0',
				'color'      => 'rgba(0, 0, 0, .15)',
			),
		);

		vc_add_params( 'vc_section', $general_options );
		vc_add_params( 'vc_section', $design_options );
		vc_add_params( 'vc_section', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_section_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_empty_space_custom_options' ) ) {
	/**
	 * Update custom params map to Default Empty Space element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_empty_space_custom_options() {
		$advanced_options = array(
			/**
			 * Hide empty space Options.
			 */
			array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Hide empty space', 'woodmart' ),
				'param_name'       => 'responsive_tabs',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Large', 'woodmart' )  => 'large',
					esc_html__( 'Medium', 'woodmart' ) => 'medium',
					esc_html__( 'Small', 'woodmart' )  => 'small',
				),
				'default'          => 'large',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			/**
			 * Hide on large.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'woodmart_hide_large',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'large' ),
				),
			),
			/**
			 * Hide on medium.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'woodmart_hide_medium',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'medium' ),
				),
			),
			/**
			 * Hide on small.
			 */
			array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'woodmart_hide_small',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 1,
				'false_state'      => 0,
				'default'          => 0,
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'small' ),
				),
			),
		);

		vc_add_params( 'vc_empty_space', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_empty_space_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_column_text_custom_options' ) ) {
	/**
	 * Update custom params map to Default Column Text element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_column_text_custom_options() {
		$design_options = array(
			woodmart_get_vc_display_inline_map(),

			array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Text larger', 'woodmart' ),
				'param_name'       => 'text_larger',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),

			woodmart_get_vc_animation_map( 'wd_animation' ),
			woodmart_get_vc_animation_map( 'wd_animation_delay' ),
			woodmart_get_vc_animation_map( 'wd_animation_duration' ),

			array(
				'type'       => 'woodmart_button_set',
				'heading'    => esc_html__( 'Color Scheme', 'woodmart' ),
				'param_name' => 'woodmart_color_scheme',
				'value'      => array(
					esc_html__( 'Inherit', 'woodmart' ) => '',
					esc_html__( 'Light', 'woodmart' )   => 'light',
					esc_html__( 'Dark', 'woodmart' )    => 'dark',
				),
			),
		);

		vc_add_params( 'vc_column_text', $design_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_column_text_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_images_carousel_custom_options' ) ) {
	/**
	 * Update custom params map to Default Images Carousel element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_images_carousel_custom_options() {
		vc_remove_param( 'vc_images_carousel', 'mode' );
		vc_remove_param( 'vc_images_carousel', 'partial_view' );
	}

	add_action( 'vc_before_init', 'woodmart_vc_images_carousel_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_single_image_custom_options' ) ) {
	/**
	 * Update custom params map to Default Single Image element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_single_image_custom_options() {
		$general_options = array(
			/**
			 * Woodmart Animation Option.
			 */
			woodmart_get_vc_animation_map( 'wd_animation' ),
			woodmart_get_vc_animation_map( 'wd_animation_delay' ),
			woodmart_get_vc_animation_map( 'wd_animation_duration' ),
			/**
			 * Parallax On Scroll Option.
			 */
			woodmart_parallax_scroll_map( 'parallax_scroll' ),
			woodmart_parallax_scroll_map( 'scroll_x' ),
			woodmart_parallax_scroll_map( 'scroll_y' ),
			woodmart_parallax_scroll_map( 'scroll_z' ),
			woodmart_parallax_scroll_map( 'scroll_smooth' ),
		);

		$advance_options = array(
			array(
				'type'        => 'woodmart_switch',
				'heading'     => esc_html__( 'Display inline', 'woodmart' ),
				'group'       => esc_html__( 'Advanced', 'woodmart' ),
				'param_name'  => 'woodmart_inline',
				'true_state'  => 'yes',
				'false_state' => 'no',
				'default'     => 'no',
			),
		);

		vc_add_params( 'vc_single_image', $general_options );
		vc_add_params( 'vc_single_image', $advance_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_single_image_custom_options' );
}

if ( ! function_exists( 'woodmart_contact_form_7_custom_options' ) ) {
	/**
	 * Update custom params map to Default Contact Form 7 element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_contact_form_7_custom_options() {
		$params = array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'woodmart' ),
				'param_name' => 'html_class',
				'value'      => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'With background', 'woodmart' ) => 'wd-style-with-bg',
				),
				'std'        => '',
			),
		);

		vc_add_params( 'contact-form-7', $params );
	}

	add_action( 'vc_before_init', 'woodmart_contact_form_7_custom_options' );
}

if ( ! function_exists( 'woodmart_vc_separator_custom_options' ) ) {
	/**
	 * Update custom params map to Default Separator element in WPBakery.
	 *
	 * @throws Exception .
	 */
	function woodmart_vc_separator_custom_options() {
		$advanced_options = array(
			woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
			woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
			woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
			woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),
		);

		vc_add_params( 'vc_separator', $advanced_options );
	}

	add_action( 'vc_before_init', 'woodmart_vc_separator_custom_options' );
}

// **********************************************************************//
// Filters for WPB Composer
// **********************************************************************//

if ( ! function_exists( 'woodmart_vc_extra_classes' ) ) {
	if ( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
		add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'woodmart_vc_extra_classes', 30, 3 );
	}

	/**
	 * Adds classes depending on the passed settings.
	 *
	 * @param array $class list of classes.
	 * @param mixed $base .
	 * @param array $atts list of settings.
	 * @return string new classes.
	 */
	function woodmart_vc_extra_classes( $class, $base, $atts ) {
		if ( isset( $atts['wd_z_index'] ) && 'yes' === $atts['wd_z_index'] ) {
			$class .= ' wd-z-index';
		}

		if ( 'vc_column' === $base || 'vc_column_inner' === $base ) {
			if ( ! empty( $atts['vertical_alignment'] ) || ! empty( $atts['horizontal_alignment'] ) ) {
				$class .= ' wd-enabled-flex';
			}
		}

		if ( 'vc_column' === $base ) {
			if ( isset( $atts['wd_column_role'] ) && ! empty( $atts['wd_column_role'] ) ) {
				woodmart_enqueue_inline_style( 'int-wpb-opt-off-canvas-column' );
			}

			if ( isset( $atts['wd_column_role_offcanvas_desktop'] ) && 'yes' === $atts['wd_column_role_offcanvas_desktop'] ) {
				$class .= ' wd-col-offcanvas-lg';
			}

			if ( isset( $atts['wd_column_role_offcanvas_tablet'] ) && 'yes' === $atts['wd_column_role_offcanvas_tablet'] ) {
				$class .= ' wd-col-offcanvas-md-sm';
			}

			if ( isset( $atts['wd_column_role_offcanvas_mobile'] ) && 'yes' === $atts['wd_column_role_offcanvas_mobile'] ) {
				$class .= ' wd-col-offcanvas-sm';
			}

			if ( isset( $atts['wd_column_role_content_desktop'] ) && 'yes' === $atts['wd_column_role_content_desktop'] ) {
				$class .= ' wd-col-content-lg';
			}

			if ( isset( $atts['wd_column_role_content_tablet'] ) && 'yes' === $atts['wd_column_role_content_tablet'] ) {
				$class .= ' wd-col-content-md-sm';
			}

			if ( isset( $atts['wd_column_role_content_mobile'] ) && 'yes' === $atts['wd_column_role_content_mobile'] ) {
				$class .= ' wd-col-content-sm';
			}

			if ( isset( $atts['wd_off_canvas_alignment'] ) && ! empty( $atts['wd_off_canvas_alignment'] ) ) {
				$class .= ' wd-alignment-' . $atts['wd_off_canvas_alignment'];
			}
		}

		if ( ! empty( $atts['woodmart_inline'] ) && 'yes' === $atts['woodmart_inline'] ) {
			$class .= ' inline-element';
		}
		if ( ! empty( $atts['woodmart_color_scheme'] ) && ( 'vc_column' === $base ||
		'vc_column_inner' === $base || 'vc_empty_space' === $base || 'vc_column_text' === $base ) ) {
			$class .= ' color-scheme-' . $atts['woodmart_color_scheme'];
		}
		if ( isset( $atts['text_larger'] ) && 'yes' === $atts['text_larger'] ) {
			$class .= ' text-larger';
		}
		if ( isset( $atts['woodmart_sticky_column'] ) && 'true' === $atts['woodmart_sticky_column'] ) {
			$class .= ' woodmart-sticky-column';

			if ( isset( $atts['woodmart_sticky_column_offset'] ) && $atts['woodmart_sticky_column_offset'] ) {
				$class .= ' wd_sticky_offset_' . $atts['woodmart_sticky_column_offset'];
			}
			woodmart_enqueue_js_library( 'sticky-kit' );
			woodmart_enqueue_js_script( 'sticky-column' );
		}
		if ( isset( $atts['woodmart_parallax'] ) && $atts['woodmart_parallax'] ) {
			$class .= ' wd-parallax';
			$class .= woodmart_get_old_classes( ' woodmart-parallax' );
			woodmart_enqueue_js_library( 'parallax' );
			woodmart_enqueue_js_script( 'parallax' );
		}
		if ( isset( $atts['woodmart_disable_overflow'] ) && $atts['woodmart_disable_overflow'] ) {
			$class .= ' wd-disable-overflow';
		}
		if ( isset( $atts['woodmart_gradient_switch'] ) && 'yes' === $atts['woodmart_gradient_switch'] && apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$class .= ' wd-row-gradient-enable';
		}
		// Bg option.
		if ( ! empty( $atts['woodmart_bg_position'] ) ) {
			$class .= ' wd-bg-' . $atts['woodmart_bg_position'];
		}
		// Text align option.
		if ( ! empty( $atts['woodmart_text_align'] ) ) {
			$class .= ' text-' . $atts['woodmart_text_align'];
		}
		// Responsive opt.
		if ( isset( $atts['woodmart_hide_large'] ) && $atts['woodmart_hide_large'] ) {
			$class .= ' hidden-lg';
		}
		if ( isset( $atts['woodmart_hide_medium'] ) && $atts['woodmart_hide_medium'] ) {
			$class .= ' hidden-md hidden-sm';
		}
		if ( isset( $atts['woodmart_hide_small'] ) && $atts['woodmart_hide_small'] ) {
			$class .= ' hidden-xs';
		}
		// Row reverse opt.
		if ( isset( $atts['row_reverse_mobile'] ) && $atts['row_reverse_mobile'] ) {
			$class .= ' row-reverse-mobile';
		}
		if ( isset( $atts['row_reverse_tablet'] ) && $atts['row_reverse_tablet'] ) {
			$class .= ' row-reverse-tablet';
		}

		// Hide bg img on mobile.
		if ( isset( $atts['mobile_bg_img_hidden'] ) && 'yes' === $atts['mobile_bg_img_hidden'] ) {
			$class .= ' mobile-bg-img-hidden';
		}

		// Hide bg img on tablet.
		if ( isset( $atts['tablet_bg_img_hidden'] ) && 'yes' === $atts['tablet_bg_img_hidden'] ) {
			$class .= ' tablet-bg-img-hidden';
		}

		// Reset margin (deprecated).
		if ( isset( $atts['mobile_reset_margin'] ) && 'yes' === $atts['mobile_reset_margin'] ) {
			$class .= ' reset-margin-mobile';
		}

		if ( isset( $atts['tablet_reset_margin'] ) && 'yes' === $atts['tablet_reset_margin'] ) {
			$class .= ' reset-margin-tablet';
		}

		if ( ! empty( $atts['css_animation'] ) && 'none' !== $atts['css_animation'] ) {
			woodmart_enqueue_inline_style( 'int-el-animations' );
		}

		if ( ! empty( $atts['wd_animation'] ) && 'none' !== $atts['wd_animation'] ) {
			$class .= ' wd-animation-' . $atts['wd_animation'];

			$duration = ! empty( $atts['wd_animation_duration'] ) ? $atts['wd_animation_duration'] : 'normal';
			$class   .= ' wd-animation-' . $duration;

			if ( ! empty( $atts['wd_animation_delay'] ) ) {
				$class .= ' wd_delay_' . $atts['wd_animation_delay'];
			}

			woodmart_enqueue_js_library( 'waypoints' );
			woodmart_enqueue_js_script( 'animations' );
			woodmart_enqueue_inline_style( 'animations' );
		}

		if ( ! empty( $atts['woodmart_css_id'] ) ) {
			$class .= ' wd-rs-' . $atts['woodmart_css_id'];
		}

		if ( isset( $atts['wd_hide_on_desktop'] ) && 'yes' === $atts['wd_hide_on_desktop'] ) {
			$class .= ' hidden-lg';
		}

		if ( isset( $atts['wd_hide_on_tablet'] ) && 'yes' === $atts['wd_hide_on_tablet'] ) {
			$class .= ' hidden-md hidden-sm';
		}

		if ( isset( $atts['wd_hide_on_mobile'] ) && 'yes' === $atts['wd_hide_on_mobile'] ) {
			$class .= ' hidden-xs';
		}

		if ( isset( $atts['wd_collapsible_content_switcher'] ) && 'yes' === $atts['wd_collapsible_content_switcher'] ) {
			woodmart_enqueue_inline_style( 'collapsible-content' );

			$class .= ' wd-collapsible-content';
		}

		/**
		 * Single Product Layout.
		 */
		if ( ( isset( $atts['width_desktop'] ) && ! empty( $atts['width_desktop'] ) ) || ( isset( $atts['width_tablet'] ) && ! empty( $atts['width_tablet'] ) || ( isset( $atts['width_mobile'] ) && ! empty( $atts['width_mobile'] ) ) ) ) {
			$class .= ' wd-enabled-width';
		}

		return $class;
	}
}

// **********************************************************************//
// Features that add FREQUENTLY USED maps to WPB Composer
// **********************************************************************//

if ( ! function_exists( 'woodmart_get_vc_display_inline_map' ) ) {
	/**
	 * Get display inline option map.
	 *
	 * @return array map.
	 */
	function woodmart_get_vc_display_inline_map() {
		return array(
			'type'             => 'woodmart_switch',
			'heading'          => esc_html__( 'Display inline', 'woodmart' ),
			'param_name'       => 'woodmart_inline',
			'true_state'       => 'yes',
			'false_state'      => 'no',
			'default'          => 'no',
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ) {
	/**
	 * Get responsive spacing option map.
	 *
	 * @return array map.
	 */
	function woodmart_get_vc_responsive_spacing_map() {
		return array(
			'type'       => 'woodmart_responsive_spacing',
			'param_name' => 'responsive_spacing',
			'group'      => esc_html__( 'Design Options', 'js_composer' ),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_responsive_visible_map' ) ) {
	/**
	 * Get responsive visible option map.
	 *
	 * @param string $key Needed map. Should be equal to map param_name.
	 *
	 * @return array map.
	 */
	function woodmart_get_vc_responsive_visible_map( $key ) {
		$map = array(
			/**
			 * Responsive Options.
			 */
			'responsive_tabs_hide' => array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Hide element', 'woodmart' ),
				'param_name'       => 'responsive_tabs_hide',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
					esc_html__( 'Tablet', 'woodmart' )  => 'tablet',
					esc_html__( 'Mobile', 'woodmart' )  => 'mobile',
				),
				'default'          => 'desktop',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			'wd_hide_on_desktop'   => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_hide_on_desktop',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_hide',
					'value'   => array( 'desktop' ),
				),
			),
			'wd_hide_on_tablet'    => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_hide_on_tablet',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_hide',
					'value'   => array( 'tablet' ),
				),
			),
			'wd_hide_on_mobile'    => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'wd_hide_on_mobile',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_hide',
					'value'   => array( 'mobile' ),
				),
			),
		);

		return array_key_exists( $key, $map ) ? $map[ $key ] : array();
	}
}

if ( ! function_exists( 'woodmart_get_responsive_reset_margin_map' ) ) {
	/**
	 * Get mobile reset option map.
	 *
	 * @param string $key Needed map. Should be equal to map param_name.
	 *
	 * @return array map.
	 */
	function woodmart_get_responsive_reset_margin_map( $key ) {
		$map = array(
			/**
			 * Responsive Options.
			 */
			'responsive_tabs_reset' => array(
				'type'             => 'woodmart_button_set',
				'heading'          => esc_html__( 'Reset margin (deprecated)', 'woodmart' ),
				'param_name'       => 'responsive_tabs_reset',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
					esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
				),
				'default'          => 'tablet',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			'mobile_reset_margin'   => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'mobile_reset_margin',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_reset',
					'value'   => array( 'mobile' ),
				),
			),
			'tablet_reset_margin'   => array(
				'type'             => 'woodmart_switch',
				'param_name'       => 'tablet_reset_margin',
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'wd_dependency'    => array(
					'element' => 'responsive_tabs_reset',
					'value'   => array( 'tablet' ),
				),
			),
		);

		return array_key_exists( $key, $map ) ? $map[ $key ] : array();
	}
}

// **********************************************************************//
// Add custom animations to WPB Composer
// **********************************************************************//

if ( ! function_exists( 'woodmart_add_css_animation' ) ) {
	/**
	 * Add animation map settings for VC.
	 *
	 * @param array $animations list of animations.
	 * @return array
	 */
	function woodmart_add_css_animation( $animations ) {
		$animations[] = array(
			'label'  => esc_html__( 'Woodmart Animations', 'woodmart' ),
			'values' => array(
				esc_html__( 'Slide from top', 'woodmart' ) => array(
					'value' => 'wd-slide-from-top',
					'type'  => 'in',
				),
				esc_html__( 'Slide from bottom', 'woodmart' ) => array(
					'value' => 'wd-slide-from-bottom',
					'type'  => 'in',
				),
				esc_html__( 'Slide from left', 'woodmart' ) => array(
					'value' => 'wd-slide-from-left',
					'type'  => 'in',
				),
				esc_html__( 'Slide from right', 'woodmart' ) => array(
					'value' => 'wd-slide-from-right',
					'type'  => 'in',
				),
				esc_html__( 'Right flip Y', 'woodmart' )   => array(
					'value' => 'wd-right-flip-y',
					'type'  => 'in',
				),
				esc_html__( 'Left flip Y', 'woodmart' )    => array(
					'value' => 'wd-left-flip-y',
					'type'  => 'in',
				),
				esc_html__( 'Top flip X', 'woodmart' )     => array(
					'value' => 'wd-top-flip-x',
					'type'  => 'in',
				),
				esc_html__( 'Bottom flip X', 'woodmart' )  => array(
					'value' => 'wd-bottom-flip-x',
					'type'  => 'in',
				),
				esc_html__( 'Zoom in', 'woodmart' )        => array(
					'value' => 'wd-zoom-in',
					'type'  => 'in',
				),
				esc_html__( 'Rotate Z', 'woodmart' )       => array(
					'value' => 'wd-rotate-z',
					'type'  => 'in',
				),
			),
		);

		return $animations;
	}

	add_action( 'vc_param_animation_style_list', 'woodmart_add_css_animation', 1000 );
}

if ( ! function_exists( 'woodmart_get_vc_animation_map' ) ) {
	/**
	 * Get animation map settings for VC.
	 *
	 * @param string $key Needed map. Should be equal to map param_name.
	 *
	 * @return array
	 */
	function woodmart_get_vc_animation_map( $key ) {
		$map = array(
			'wd_animation'          => array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Woodmart Animation', 'woodmart' ),
				'hint'             => esc_html__( 'Use custom theme animations if you want to run them in the slider element.' ),
				'param_name'       => 'wd_animation',
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
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			'wd_animation_delay'    => array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Woodmart Animation Delay (ms)', 'woodmart' ),
				'param_name'       => 'wd_animation_delay',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element'            => 'wd_animation',
					'value_not_equal_to' => array( '' ),
				),
			),
			'wd_animation_duration' => array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Woodmart Animation duration', 'woodmart' ),
				'param_name'       => 'wd_animation_duration',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
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
		);

		return array_key_exists( $key, $map ) ? $map[ $key ] : array();
	}
}

if ( ! function_exists( 'woodmart_get_tab_title_category_for_wpb' ) ) {
	/**
	 * Get tab title category for WPB builder.
	 *
	 * @param string $title Title category.
	 *
	 * @return string
	 */
	function woodmart_get_tab_title_category_for_wpb( $title, $layout = '' ) {
		if ( $layout ) {
			$layout = ' xts-layout-' . $layout;
		}

		return '<span class="xts-wpb-tab-title' . $layout . '">' . $title . '</span>';
	}
}
