<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;
$wrapper_classes = '';
$is_quick_view   = woodmart_loop_prop( 'is_quick_view' );

if ( isset( $args['builder_meta_classes'] ) && ! empty( $args['builder_meta_classes'] ) ) {
	$wrapper_classes = $args['builder_meta_classes'];
} elseif ( 'after_tabs' === woodmart_get_opt( 'product_show_meta' ) || ( 'add_to_cart' === woodmart_get_opt( 'product_show_meta' ) && 'alt' === woodmart_get_opt( 'product_design' ) ) ) {
	$wrapper_classes = ' wd-layout-inline';

	if ( ! empty( $is_quick_view ) ) {
		$wrapper_classes = '';
	}
}

?>

<div class="product_meta<?php echo esc_attr( $wrapper_classes ); ?>">
	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		<?php $sku = $product->get_sku(); ?>

		<span class="sku_wrapper">
			<span class="meta-label">
				<?php esc_html_e( 'SKU:', 'woocommerce' ); ?>
			</span>
			<span class="sku">
				<?php echo $sku ? $sku : esc_html__( 'N/A', 'woocommerce' ); // phpcs:ignore ?>
			</span>
		</span>
	<?php endif; ?>

	<?php echo wc_get_product_category_list( $product->get_id(), '<span class="meta-sep">,</span> ', '<span class="posted_in"><span class="meta-label">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . '</span> ', '</span>' ); // phpcs:ignore ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), '<span class="meta-sep">,</span> ', '<span class="tagged_as"><span class="meta-label">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . '</span> ', '</span>' ); // phpcs:ignore ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>
</div>
