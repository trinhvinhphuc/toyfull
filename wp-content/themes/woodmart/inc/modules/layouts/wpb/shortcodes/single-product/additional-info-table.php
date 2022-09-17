<?php
/**
 * Additional info table shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_additional_info_table' ) ) {
	/**
	 * Additional info table shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_additional_info_table( $settings ) {
		$default_settings = array(
			'layout' => 'list',
			'style'  => 'bordered',
			'css'    => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' wd-layout-' . $settings['layout'];
		$wrapper_classes .= ' wd-style-' . $settings['style'];

		ob_start();

		Main::setup_preview();

		global $product;
		?>
		<div class="wd-single-attrs wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>"><?php do_action( 'woocommerce_product_additional_information', $product ); // Must be in one line. ?></div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
