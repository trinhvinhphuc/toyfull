<?php
/**
 * Active filters shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shop_archive_active_filters' ) ) {
	/**
	 * Active filters shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shop_archive_active_filters( $settings ) {
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

		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$min_price          = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : 0; // phpcs:ignore.
		$max_price          = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : 0; // phpcs:ignore.
		$rating_filter      = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', wp_unslash( $_GET['rating_filter'] ) ) ) ) : array(); // phpcs:ignore.

		if ( 0 === count( $_chosen_attributes ) && empty( $min_price ) && empty( $max_price ) && empty( $rating_filter ) ) {
			return '';
		}

		woodmart_enqueue_inline_style( 'woo-shop-el-active-filters' );
		?>
		<div class="wd-shop-active-filters wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woodmart_get_active_filters(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
