<?php
/**
 * Products per page shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shop_archive_per_page' ) ) {
	/**
	 * Products per page shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shop_archive_per_page( $settings ) {
		$default_settings = array(
			'css'              => '',
			'per_page_options' => '9,12,18,24',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		Main::setup_preview();

		woodmart_enqueue_inline_style( 'woo-shop-el-products-per-page' );
		?>
		<div class="wd-shop-prod-per-page wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woodmart_products_per_page_select( false, $settings ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
