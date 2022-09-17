<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Dokan compatibility
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_dokan_edit_product_wrap_start' ) ) {
	function woodmart_dokan_edit_product_wrap_start() {
		echo '<div class="site-content col-12" role="main">';
	}

	add_action( 'dokan_dashboard_wrap_before', 'woodmart_dokan_edit_product_wrap_start', 10 );
}

if ( ! function_exists( 'woodmart_dokan_edit_product_wrap_end' ) ) {
	function woodmart_dokan_edit_product_wrap_end() {
		echo '</div>';
	}

	add_action( 'dokan_dashboard_wrap_after', 'woodmart_dokan_edit_product_wrap_end', 10 );
}

if ( ! function_exists( 'woodmart_dokan_lazy_load_fix' ) ) {
	function woodmart_dokan_lazy_load_fix() {
		return array(
			'img' => array(
				'alt'           => array(),
				'class'         => array(),
				'height'        => array(),
				'src'           => array(),
				'width'         => array(),
				'data-wood-src' => array(),
				'data-srcset'   => array(),
			),
		);
	}

	add_filter( 'dokan_product_image_attributes', 'woodmart_dokan_lazy_load_fix', 10 );
}

if ( ! function_exists( 'woodmart_dokan_remove_map_from_shop_page' ) ) {
	function woodmart_dokan_remove_map_from_shop_page() {
		if ( ! function_exists( 'Dokan_Pro' ) ) {
			return;
		}

		$source = dokan_get_option( 'map_api_source', 'dokan_appearance', 'google_maps' );

		if ( 'mapbox' === $source ) {
			dokan_remove_hook_for_anonymous_class( 'woocommerce_before_shop_loop',
				'Dokan_Geolocation_Product_View', 'before_shop_loop', 10 );
			dokan_remove_hook_for_anonymous_class( 'woocommerce_no_products_found',
				'Dokan_Geolocation_Product_View', 'before_shop_loop', 9 );
		}
	}

	add_action( 'init', 'woodmart_dokan_remove_map_from_shop_page' );
}

if ( ! function_exists( 'woodmart_dokan_add_map_before_main_content' ) ) {
	function woodmart_dokan_add_map_before_main_content() {
		if ( ! class_exists( 'Dokan_Pro' ) ) {
			return;
		}

		$show_filters   = dokan_get_option( 'show_filters_before_locations_map', 'dokan_geolocation', 'on' );
		$map_location   = dokan_get_option( 'show_locations_map', 'dokan_geolocation', 'top' );
		$source         = dokan_get_option( 'map_api_source', 'dokan_appearance', 'google_maps' );
		$show_map_pages = dokan_get_option( 'show_location_map_pages', 'dokan_geolocation', 'shop' );

		if ( 'store_listing' === $show_map_pages ) {
			return;
		}

		?>
		<div class="wd-dokan-geo">
			<?php if ( 'on' === $show_filters && 'mapbox' === $source ) : ?>
				<?php dokan_geo_filter_form( 'product' ); ?>
			<?php endif; ?>

			<?php if ( 'top' === $map_location && 'mapbox' === $source ) : ?>
				<?php dokan_geo_get_template( 'map', array( 'layout' => 'top' ) ); ?>
			<?php endif; ?>
		</div>
		<?php
	}

	add_action( 'woocommerce_before_main_content', 'woodmart_dokan_add_map_before_main_content' );
}