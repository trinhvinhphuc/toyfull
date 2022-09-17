<?php
/**
 * Sidebar shortcode.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_sidebar' ) ) {
	/**
	 * Sidebar shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_sidebar( $settings ) {
		$default_settings = array(
			'css'          => '',
			'sidebar_name' => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		?>
		<div class="wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php dynamic_sidebar( $settings['sidebar_name'] ); ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
