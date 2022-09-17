<?php
/**
 * Order by shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Global_Data as Builder_Data;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shop_archive_orderby' ) ) {
	/**
	 * Order by shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shop_archive_orderby( $settings ) {
		$default_settings = array(
			'css'         => '',
			'mobile_icon' => 'no',
			'style'       => 'default',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$ordering_classes = ' wd-style-' . $settings['style'];

		if ( 'yes' === $settings['mobile_icon'] ) {
			$ordering_classes .= ' wd-ordering-mb-icon';
		}

		ob_start();

		Main::setup_preview();

		Builder_Data::get_instance()->set_data( 'builder_ordering_classes', $ordering_classes );
		woodmart_enqueue_inline_style( 'woo-shop-el-order-by' );
		?>
		<div class="wd-shop-ordering wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woocommerce_catalog_ordering(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
