<?php
/**
 * Payment methods map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_checkout_payment_methods' ) ) {
	/**
	 * Payment methods map.
	 */
	function woodmart_vc_map_checkout_payment_methods() {
		if ( ! shortcode_exists( 'woodmart_checkout_payment_methods' ) || ! Main::is_layout_type( 'checkout_form' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_checkout_payment_methods',
				'name'        => esc_html__( 'Payment methods', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Checkout', 'woodmart' ), 'checkout_form' ),
				'description' => esc_html__( 'Payment methods and checkout button', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/ch-icons/ch-payment-methods.svg',
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
						'heading'    => esc_html__( 'Button alignment', 'woodmart' ),
						'type'       => 'wd_select',
						'param_name' => 'button_alignment',
						'style'      => 'select',
						'selectors'  => array(),
						'devices'    => array(
							'desktop' => array(
								'value' => 'left',
							),
						),
						'value'      => array(
							esc_html__( 'Left', 'woodmart' ) => 'left',
							esc_html__( 'Center', 'woodmart' ) => 'center',
							esc_html__( 'Right', 'woodmart' ) => 'right',
							esc_html__( 'Full width', 'woodmart' ) => 'full-width',
						),
					),

					// Payment description.
					array(
						'title'      => esc_html__( 'Payment description', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'payment_description_divider',
					),

					array(
						'heading'          => esc_html__( 'Background color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'payment_description_background_color',
						'selectors'        => array(
							'{{WRAPPER}} .payment_box' => array(
								'background-color: {{VALUE}};',
							),
							'{{WRAPPER}} .payment_box:before' => array(
								'color: {{VALUE}};',
							),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Color', 'woodmart' ),
						'type'             => 'wd_colorpicker',
						'param_name'       => 'payment_description_color',
						'selectors'        => array(
							'{{WRAPPER}} .payment_box' => array(
								'color: {{VALUE}};',
							),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					// Terms and conditions.
					array(
						'title'      => esc_html__( 'Terms and conditions', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'terms_conditions_divider',
					),

					array(
						'heading'    => esc_html__( 'Background color', 'woodmart' ),
						'type'       => 'wd_colorpicker',
						'param_name' => 'terms_conditions_background_color',
						'selectors'  => array(
							'{{WRAPPER}} .woocommerce-terms-and-conditions' => array(
								'background-color: {{VALUE}};',
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

	add_action( 'vc_before_init', 'woodmart_vc_map_checkout_payment_methods' );
}
