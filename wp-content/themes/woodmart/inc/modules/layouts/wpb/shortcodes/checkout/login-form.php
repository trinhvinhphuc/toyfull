<?php
/**
 * Coupon form shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_checkout_login_form' ) ) {
	/**
	 * Coupon form shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_checkout_login_form( $settings ) {
		if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
			return '';
		}

		$default_settings = array(
			'css' => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-checkout-login wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-checkout-login-inner">
				<?php woocommerce_checkout_login_form(); ?>
			</div>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
