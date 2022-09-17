<?php
/**
 * Navigation map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_nav' ) ) {
	/**
	 * Navigation map.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_nav( $settings ) {
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
		<div class="wd-single-nav wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php wc_get_template( 'single-product/navigation.php' ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
