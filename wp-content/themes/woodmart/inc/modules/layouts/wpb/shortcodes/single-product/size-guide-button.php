<?php
/**
 * Size guide button shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_size_guide_button' ) ) {
	/**
	 * Size guide button shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_size_guide_button( $settings ) {
		$default_settings = array(
			'alignment' => 'left',
			'css'       => '',
			'style'     => 'text',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		if ( 'icon' === $settings['style'] ) {
			woodmart_enqueue_js_library( 'tooltips' );
			woodmart_enqueue_js_script( 'btns-tooltips' );
		}

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );

		$classes = ' wd-style-' . $settings['style'];

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-single-action-btn wd-single-size-guide-btn wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>"><?php woodmart_sguide_display( false, array( 'builder_classes' => $classes ) ); // Must be in one line. ?></div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
