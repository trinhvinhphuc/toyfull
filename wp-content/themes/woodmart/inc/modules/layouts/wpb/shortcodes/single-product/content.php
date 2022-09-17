<?php
/**
 * Content shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_content' ) ) {
	/**
	 * Single product content shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_content( $settings ) {
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

		$content = get_the_content();

		if ( ! $content ) {
			return '';
		}

		?>
		<div class="wd-single-content wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php echo apply_filters( 'the_content', $content ); //phpcs:ignore ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
