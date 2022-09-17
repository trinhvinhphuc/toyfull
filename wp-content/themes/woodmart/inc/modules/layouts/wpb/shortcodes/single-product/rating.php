<?php
/**
 * Rating shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_rating' ) ) {
	/**
	 * Rating shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_rating( $settings ) {
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

		global $product;

		if ( ! wc_review_ratings_enabled() || $product->get_rating_count() <= 0 ) {
			return '';
		}

		?>
		<div class="wd-single-rating wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php wc_get_template( 'single-product/rating.php' ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
