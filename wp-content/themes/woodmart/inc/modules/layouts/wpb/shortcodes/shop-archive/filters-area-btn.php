<?php
/**
 * Filters area button shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shop_archive_filters_area_btn' ) ) {
	/**
	 * Filters area button shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shop_archive_filters_area_btn( $settings ) {
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

		woodmart_enqueue_inline_style( 'shop-filter-area' );
		?>
		<div class="wd-shop-filters-btn wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woodmart_filter_buttons(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
