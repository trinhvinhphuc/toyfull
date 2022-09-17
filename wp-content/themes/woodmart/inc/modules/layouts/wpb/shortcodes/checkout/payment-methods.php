<?php
/**
 * Order review shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_checkout_payment_methods' ) ) {
	/**
	 * Order review shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_checkout_payment_methods( $settings ) {
		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			return '';
		}

		$default_settings = array(
			'button_alignment' => 'left',
			'css'              => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' wd-btn-align-' . woodmart_vc_get_control_data( $settings['button_alignment'], 'desktop' );

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-payment-methods wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woocommerce_checkout_payment(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
