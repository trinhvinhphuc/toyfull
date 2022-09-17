<?php
/**
 * Archive description shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shop_archive_description' ) ) {
	/**
	 * Archive description shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shop_archive_description( $settings ) {
		$default_settings = array(
			'alignment' => 'left',
			'css'       => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-shop-desc wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>"><?php // Must be in one line.
			woocommerce_taxonomy_archive_description();
			woocommerce_product_archive_description();
		?></div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
