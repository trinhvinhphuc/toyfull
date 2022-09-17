<?php
/**
 * Woocommerce title shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shop_archive_woocommerce_title' ) ) {
	/**
	 * Woocommerce title shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shop_archive_woocommerce_title( $settings ) {
		$default_settings = array(
			'css'            => '',
			'tag'            => 'span',
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

		?>
		<div class="wd-woo-page-title wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<<?php echo esc_attr( $settings['tag'] ); ?> class="entry-title title">
				<?php woocommerce_page_title(); ?>
			</<?php echo esc_attr( $settings['tag'] ); ?>>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
