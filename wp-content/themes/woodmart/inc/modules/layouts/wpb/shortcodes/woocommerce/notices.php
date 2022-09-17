<?php
/**
 * Woocommerce notices shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_woocommerce_notices' ) ) {
	/**
	 * Woocommerce notices shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_woocommerce_notices( $settings ) {
		$default_settings = array(
			'css' => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		if ( ! function_exists( 'wc_print_notices' ) ) {
			return ob_get_clean();
		}

		Main::setup_preview();

		?>
		<div class="wd-wc-notices wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woocommerce_output_all_notices(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
