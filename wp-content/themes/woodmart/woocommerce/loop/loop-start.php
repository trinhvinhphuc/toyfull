<?php
/**
 * Product Loop Start
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

use XTS\Modules\Layouts\Global_Data;
use XTS\Modules\Layouts\Main;

$spacing      = woodmart_loop_prop( 'products_spacing' ) || 0 === woodmart_loop_prop( 'products_spacing' ) || '0' === woodmart_loop_prop( 'products_spacing' ) ? woodmart_loop_prop( 'products_spacing' ) : woodmart_get_opt( 'products_spacing' );
$class        = '';
$current_view = woodmart_loop_prop( 'products_view' );
$is_slider    = woodmart_loop_prop( 'is_slider' );
$is_shortcode = woodmart_loop_prop( 'is_shortcode' );
$shop_view    = woodmart_get_opt( 'shop_view' );

if ( ( 'grid' === $shop_view || 'list' === $shop_view ) && ! Main::get_instance()->has_custom_layout( 'shop_archive' ) ) {
	$current_view = $shop_view;
}

if ( $is_slider ) {
	$current_view = 'grid';
}

if ( $is_shortcode ) {
	$current_view = woodmart_loop_prop( 'products_view' );
}

if ( woodmart_loop_prop( 'products_masonry' ) ) {
	$class .= ' grid-masonry';
	wp_enqueue_script( 'imagesloaded' );
	woodmart_enqueue_js_library( 'isotope-bundle' );
	woodmart_enqueue_js_script( 'shop-masonry' );
}

if ( 'list' === $current_view ) {
	$class .= ' elements-list';
} else {
	$class .= ' wd-spacing-' . $spacing;
	$class .= ' grid-columns-' . woodmart_loop_prop( 'products_columns' );
}

if ( ( woodmart_loop_prop( 'products_bordered_grid' ) && 'enable' === woodmart_loop_prop( 'products_bordered_grid' ) ) || ( ! woodmart_loop_prop( 'products_bordered_grid' ) && woodmart_get_opt( 'products_bordered_grid' ) ) ) {
	woodmart_enqueue_inline_style( 'bordered-product' );

	if ( 'outside' === woodmart_loop_prop( 'products_bordered_grid_style' ) ) {
		$class .= ' products-bordered-grid';
	} elseif ( 'inside' === woodmart_loop_prop( 'products_bordered_grid_style' ) ) {
		$class .= ' products-bordered-grid-ins';
	}
}

if ( woodmart_get_opt( 'quick_shop_variable' ) ) {
	woodmart_enqueue_js_script( 'quick-shop' );
	woodmart_enqueue_js_script( 'swatches-variations' );
	woodmart_enqueue_js_script( 'add-to-cart-all-types' );
	wp_enqueue_script( 'wc-add-to-cart-variation' );
}

if ( woodmart_get_opt( 'product_quantity' ) ) {
	$class .= ' wd-quantity-enabled';
}

if ( Global_Data::get_instance()->get_data( 'shop_pagination' ) ) {
	$pagination_type = Global_Data::get_instance()->get_data( 'shop_pagination' );
} else {
	$pagination_type = woodmart_get_opt( 'shop_pagination' );
}

$class .= ' pagination-' . $pagination_type;

if ( 'none' !== woodmart_get_opt( 'product_title_lines_limit' ) && 'list' !== $current_view ) {
	woodmart_enqueue_inline_style( 'woo-opt-title-limit' );
	$class .= ' title-line-' . woodmart_get_opt( 'product_title_lines_limit' );
}

// fix for price filter ajax
$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

$product_design    = woodmart_loop_prop( 'product_hover' );
$categories_design = woodmart_loop_prop( 'product_categories_design' );

if ( 'list' === $current_view ) {
	$product_design = 'list';
}

if ( 'default' === $categories_design || 'alt' === $categories_design || 'center' === $categories_design || 'replace-title' === $categories_design ) {
	woodmart_set_loop_prop( 'old_structure', true );
}

woodmart_enqueue_product_loop_styles( $product_design );
if ( 'alt' !== $categories_design && 'inherit' !== $categories_design ) {
	woodmart_enqueue_inline_style( 'categories-loop-' . $categories_design );
}

if ( 'center' === $categories_design ) {
	woodmart_enqueue_inline_style( 'categories-loop-center' );
}

if ( 'replace-title' === $categories_design ) {
	woodmart_enqueue_inline_style( 'categories-loop-replace-title' );
}

if ( 'mask-subcat' === $categories_design ) {
	woodmart_enqueue_inline_style( 'woo-categories-loop-mask-subcat' );
}

if ( woodmart_loop_prop( 'old_structure' ) ) {
	woodmart_enqueue_inline_style( 'categories-loop' );
} else {
	woodmart_enqueue_inline_style( 'woo-categories-loop' );
}

if ( ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) && in_array( $product_design,
		array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base' ) ) ) {
	woodmart_enqueue_inline_style( 'woo-opt-stretch-cont' );
	if ( woodmart_loop_prop( 'stretch_product_desktop' ) ) {
		$class .= ' wd-stretch-cont-lg';
	}
	if ( woodmart_loop_prop( 'stretch_product_tablet' ) ) {
		$class .= ' wd-stretch-cont-md';
	}
	if ( woodmart_loop_prop( 'stretch_product_mobile' ) ) {
		$class .= ' wd-stretch-cont-sm';
	}
}

$class .= ' align-items-start';

?>

<div class="products elements-grid wd-products-holder <?php echo esc_attr( $class ); ?> row" data-source="main_loop" data-min_price="<?php echo esc_attr( $min_price ); ?>" data-max_price="<?php echo esc_attr( $max_price ); ?>" data-columns="<?php echo esc_attr( woodmart_loop_prop( 'products_columns' ) ); ?>">
