<?php
/**
 * Gallery shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_gallery' ) ) {
	/**
	 * Gallery shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_gallery( $settings ) {
		$default_settings = array(
			'css'                 => '',
			'thumbnails_position' => 'inherit',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		wp_enqueue_script( 'zoom' );
		wp_enqueue_script( 'wc-single-product' );

		Main::setup_preview();

		?>
		<div class="wd-single-gallery wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php
			wc_get_template(
				'single-product/product-image.php',
				array(
					'builder_thumbnails_position' => $settings['thumbnails_position'],
				)
			);
			?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
