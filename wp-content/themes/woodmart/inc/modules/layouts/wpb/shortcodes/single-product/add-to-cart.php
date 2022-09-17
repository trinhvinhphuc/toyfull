<?php
/**
 * Add to cart shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Global_Data as Builder;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_add_to_cart' ) ) {
	/**
	 * Single product add to cart shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_add_to_cart( $settings ) {
		$default_settings = array(
			'alignment'             => 'left',
			'button_design'         => 'default',
			'design'                => 'default',
			'swatch_layout'         => 'default',
			'reset_button_position' => 'side',
			'label_position'        => 'side',
			'css'                   => '',
			'width_desktop'         => '',
			'width_tablet'          => '',
			'width_mobile'          => '',
		);
		$settings         = wp_parse_args( $settings, $default_settings );

		$form_classes    = '';
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		// Form classes.
		$form_classes .= ' wd-reset-' . woodmart_vc_get_control_data( $settings['reset_button_position'], 'desktop' ) . '-lg';
		$form_classes .= ' wd-reset-' . woodmart_vc_get_control_data( $settings['reset_button_position'], 'mobile' ) . '-md';
		$form_classes .= ' wd-label-' . woodmart_vc_get_control_data( $settings['label_position'], 'desktop' ) . '-lg';
		$form_classes .= ' wd-label-' . woodmart_vc_get_control_data( $settings['label_position'], 'mobile' ) . '-md';

		// Wrapper classes.
		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}
		$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );
		$wrapper_classes .= ' wd-btn-design-' . $settings['button_design'];
		$wrapper_classes .= ' wd-design-' . $settings['design'];
		$wrapper_classes .= ' wd-swatch-layout-' . $settings['swatch_layout'];

		if ( 'justify' === $settings['design'] ) {
			woodmart_enqueue_inline_style( 'woo-single-prod-el-add-to-cart-opt-design-justify-builder' );

			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation' );
			add_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation' );
		}

		Builder::get_instance()->set_data( 'form_classes', $form_classes );

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-single-add-cart wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woocommerce_template_single_add_to_cart(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
