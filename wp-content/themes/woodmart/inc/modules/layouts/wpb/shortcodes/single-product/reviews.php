<?php
/**
 * Reviews shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_reviews' ) ) {
	/**
	 * Reviews shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_reviews( $settings ) {
		$default_settings = array(
			'css'    => '',
			'layout' => 'one-column',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' wd-layout-' . woodmart_vc_get_control_data( $settings['layout'], 'desktop' );

		ob_start();

		Main::setup_preview();

		global  $withcomments, $post;

		if ( ! ( is_single() || is_page() || $withcomments ) || empty( $post ) ) {
			return '';
		}

		woodmart_enqueue_inline_style( 'woo-single-prod-el-reviews' );
		woodmart_enqueue_inline_style( 'mod-comments' );

		?>
		<div class="wd-single-reviews wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php comments_template(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
