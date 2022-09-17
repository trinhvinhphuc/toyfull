<?php
/**
 * Result count shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shop_archive_result_count' ) ) {
	/**
	 * Result count shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shop_archive_result_count( $settings ) {
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
		<div class="wd-shop-result-count wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woocommerce_result_count(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
