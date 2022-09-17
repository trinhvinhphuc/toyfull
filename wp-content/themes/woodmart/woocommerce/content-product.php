<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

use XTS\Modules\Layouts\Main;

defined( 'ABSPATH' ) || exit;

global $product;

$is_slider      = woodmart_loop_prop( 'is_slider' );
$is_shortcode   = woodmart_loop_prop( 'is_shortcode' );
$different_size = woodmart_loop_prop( 'products_different_sizes' );
$hover          = woodmart_loop_prop( 'product_hover' );
$current_view   = woodmart_loop_prop( 'products_view' );
$shop_view      = woodmart_get_opt( 'shop_view' );

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Increase loop count.
wc_set_loop_prop( 'loop', woodmart_loop_prop( 'woocommerce_loop' ) + 1 );
woodmart_set_loop_prop( 'woocommerce_loop', woodmart_loop_prop( 'woocommerce_loop' ) + 1 );
$woocommerce_loop = woodmart_loop_prop( 'woocommerce_loop' );

// Swatches.
woodmart_set_loop_prop( 'swatches', woodmart_swatches_list() );

// Extra post classes.
$classes = array( 'product-grid-item' );

if ( 'info' === $hover && ( woodmart_get_opt( 'new_label' ) && woodmart_is_new_label_needed( $product->get_id() ) ) || woodmart_get_product_attributes_label() || $product->is_on_sale() || $product->is_featured() || ! $product->is_in_stock() ) {
	$classes[] = 'wd-with-labels';
}

$classes[] = 'product';

if ( get_option( 'woocommerce_enable_review_rating' ) == 'yes' && $product->get_rating_count() > 0 && 'base' === $hover ) {
	$classes[] = 'has-stars';
}

if ( 'base' === $hover && ! woodmart_loop_prop( 'swatches' ) ) {
	$classes[] = 'product-no-swatches';
}

// Grid or list style.
if ( ( 'grid' === $shop_view || 'list' === $shop_view ) && ! Main::get_instance()->has_custom_layout( 'shop_archive' ) ) {
	$current_view = $shop_view;
}

if ( $is_slider ) {
	$current_view = 'grid';
}

if ( $is_shortcode ) {
	$current_view = woodmart_loop_prop( 'products_view' );
}

if ( 'base' === $hover ) {
	wp_enqueue_script( 'imagesloaded' );
	woodmart_enqueue_js_script( 'product-hover' );
	woodmart_enqueue_js_script( 'product-more-description' );
}

if ( $current_view == 'list' ) {
	$hover = 'list';
	$classes[] = 'product-list-item';
	woodmart_set_loop_prop( 'products_columns', 1 );
} else {
	$classes[] = 'wd-hover-' . $hover;
	$classes[] = woodmart_get_old_classes( 'woodmart-hover-' . $hover );
}

if ( ! empty( $different_sizes ) && $different_sizes && in_array( $woocommerce_loop, woodmart_get_wide_items_array( $different_sizes ) ) ) {
	woodmart_set_loop_prop( 'double_size', true );
}


$desktop_columns = woodmart_loop_prop( 'products_columns' );
$tablet_columns  = woodmart_loop_prop( 'products_columns_tablet' );
$mobile_columns  = woodmart_loop_prop( 'products_columns_mobile' );

if ( ! $is_slider ) {
	if ( ! isset( $different_sizes ) ) {
		$different_sizes = false;
	}

	if ( ( 'auto' !== $tablet_columns && ! empty( $tablet_columns ) ) || ( 'auto' !== $mobile_columns && ! empty( $mobile_columns ) ) ) {
		if ( $desktop_columns == 1 ) {
			$mobile_columns = 1;
			$tablet_columns = 1;
		}
		$classes[] = woodmart_get_grid_el_class_new( $woocommerce_loop, $different_sizes, $desktop_columns, $tablet_columns, $mobile_columns );
	} else {
		$xs_columns = woodmart_loop_prop( 'products_columns_mobile' ) ? woodmart_loop_prop( 'products_columns_mobile' ) : (int) woodmart_get_opt( 'products_columns_mobile' );
		$xs_size = 12 / $xs_columns;
		if ( $desktop_columns == 1 ) {
			$xs_size = 12;
		}
		$classes[] = woodmart_get_grid_el_class( $woocommerce_loop, $desktop_columns, $different_sizes, $xs_size );
	}
} elseif ( 'base' === $hover ) {
	$classes[] = 'product-in-carousel';
}

?>
<div <?php wc_product_class( $classes, $product ); ?> data-loop="<?php echo esc_attr( $woocommerce_loop ); ?>" data-id="<?php echo esc_attr( $product->get_id() ); ?>">
	<?php if ( woodmart_grid_swatches_attribute() ) : ?>
		<?php woodmart_enqueue_inline_style( 'woo-mod-product-swatches' ); ?>
	<?php endif; ?>

	<?php wc_get_template_part( 'content', 'product-' . $hover ); ?>
</div>
