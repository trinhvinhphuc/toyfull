<?php
/**
 * Billing details map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_checkout_billing_details_form' ) ) {
	/**
	 * Billing details map.
	 */
	function woodmart_vc_map_checkout_billing_details_form() {
		if ( ! shortcode_exists( 'woodmart_checkout_billing_details_form' ) || ! Main::is_layout_type( 'checkout_form' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_checkout_billing_details_form',
				'name'        => esc_html__( 'Billing details', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Checkout', 'woodmart' ), 'checkout_form' ),
				'description' => esc_html__( 'Billing information fields', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/ch-icons/ch-billing-details.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'          => esc_html__( 'Enable title', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'show_title',
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'yes',
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

	add_action( 'vc_before_init', 'woodmart_vc_map_checkout_billing_details_form' );
}
