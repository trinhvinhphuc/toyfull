<?php
/**
 * Brand information shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_brand_information' ) ) {
	/**
	 * Brand information shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_brand_information( $settings ) {
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

		$attr = woodmart_get_opt( 'brands_attribute' );

		if ( ! $attr ) {
			return '';
		}

		global $product;

		$attributes = $product->get_attributes();

		if ( ! isset( $attributes[ $attr ] ) || empty( $attributes[ $attr ] ) || empty( wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'slugs' ) ) ) ) {
			return '';
		}

		?>
		<div class="wd-single-brand-info wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>"><?php woodmart_product_brand_tab_content(); ?></div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
