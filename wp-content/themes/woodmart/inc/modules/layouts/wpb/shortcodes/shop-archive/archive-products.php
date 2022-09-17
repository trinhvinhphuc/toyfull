<?php
/**
 * Archive products shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Global_Data;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shop_archive_products' ) ) {
	/**
	 * Archive products shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shop_archive_products( $settings ) {
		$default_settings = array(
			'css'                          => '',
			'img_size'                     => '',
			'products_view'                => 'inherit',
			'products_columns'             => 'inherit',
			'products_spacing'             => 'inherit',
			'shop_pagination'              => 'inherit',
			'product_hover'                => 'inherit',
			'products_bordered_grid'       => 'inherit',
			'products_bordered_grid_style' => 'inherit',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		if ( 'inherit' !== $settings['products_view'] ) {
			woodmart_set_loop_prop( 'products_view', woodmart_new_get_shop_view( $settings['products_view'], true ) );
		}

		$products_columns = woodmart_vc_get_control_data( $settings['products_columns'], 'desktop' );
		if ( 'inherit' !== $products_columns ) {
			woodmart_set_loop_prop( 'products_columns', woodmart_new_get_products_columns_per_row( $products_columns, true ) );
		}

		$products_columns_tablet = woodmart_vc_get_control_data( $settings['products_columns'], 'tablet' );
		if ( 'inherit' !== $products_columns_tablet ) {
			woodmart_set_loop_prop( 'products_columns_tablet', $products_columns_tablet );
		}

		$products_columns_mobile = woodmart_vc_get_control_data( $settings['products_columns'], 'mobile' );
		if ( 'inherit' !== $products_columns_mobile ) {
			woodmart_set_loop_prop( 'products_columns_mobile', $products_columns_mobile );
		}

		$products_spacing = woodmart_vc_get_control_data( $settings['products_spacing'], 'desktop' );
		if ( 'inherit' !== $products_spacing ) {
			woodmart_set_loop_prop( 'products_spacing', $products_spacing );
		}

		if ( 'inherit' !== $settings['product_hover'] ) {
			woodmart_set_loop_prop( 'product_hover', $settings['product_hover'] );
		}

		if ( 'inherit' !== $settings['shop_pagination'] ) {
			Global_Data::get_instance()->set_data( 'shop_pagination', $settings['shop_pagination'] );
		}

		if ( 'inherit' !== $settings['products_bordered_grid'] ) {
			woodmart_set_loop_prop( 'products_bordered_grid', $settings['products_bordered_grid'] );
		}

		if ( 'inherit' !== $settings['products_bordered_grid_style'] ) {
			woodmart_set_loop_prop( 'products_bordered_grid_style', $settings['products_bordered_grid_style'] );
		}

		if ( $settings['img_size'] ) {
			woodmart_set_loop_prop( 'img_size', $settings['img_size'] );
		}

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-shop-product wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woodmart_sticky_loader(); ?>
			<?php do_action( 'woodmart_woocommerce_main_loop' ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
