<?php
/**
 * Short description shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_short_description' ) ) {
	/**
	 * Short description shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_short_description( $settings ) {
		$default_settings = array(
			'css'            => '',
			'text_alignment' => 'left',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['text_alignment'], 'desktop' );

		ob_start();

		Main::setup_preview();

		global $post;

		$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

		if ( ! $short_description ) {
			return '';
		}

		?>
		<div class="wd-single-short-desc wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php wc_get_template( 'single-product/short-description.php' ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
