<?php
/**
 * Product brands shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Global_Data as Builder_Data;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_brands' ) ) {
	/**
	 * Product brands shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_brands( $settings ) {
		$default_settings = array(
			'alignment'  => 'left',
			'css'        => '',
			'label_text' => esc_html__( 'Brands: ', 'woodmart' ),
			'layout'     => 'default',
			'style'      => 'default',
			'show_label' => 'no',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );
		$wrapper_classes .= ' wd-style-' . $settings['style'];
		$wrapper_classes .= ' wd-layout-' . $settings['layout'];

		ob_start();

		Main::setup_preview();

		$attr = woodmart_get_opt( 'brands_attribute' );

		if ( ! $attr || ( ! woodmart_get_opt( 'product_page_brand' ) && ! Main::get_instance()->has_custom_layout( 'single_product' ) ) ) {
			return '';
		}

		global $product;

		$attributes = $product->get_attributes();

		if ( ! isset( $attributes[ $attr ] ) || empty( $attributes[ $attr ] ) || empty( wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'all' ) ) ) ) {
			return '';
		}

		?>
		<div class="wd-single-brands wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php if ( 'yes' === $settings['show_label'] ) : ?>
				<?php Builder_Data::get_instance()->set_data( 'builder_label', $settings['label_text'] ); ?>
			<?php endif; ?>

			<?php woodmart_product_brand(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
