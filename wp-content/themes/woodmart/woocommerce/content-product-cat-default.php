<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div <?php wc_product_cat_class( $args['classes'], $args['category'] ); ?> data-loop="<?php echo esc_attr( $args['woocommerce_loop'] ); ?>">
	<div class="wrapp-category">
		<div class="category-image-wrapp">
			<a href="<?php echo esc_url( get_term_link( $args['category']->slug, 'product_cat' ) ); ?>" class="category-image">
				<?php do_action( 'woocommerce_before_subcategory', $args['category'] ); ?>

				<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woodmart_category_thumb_double_size - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $args['category'] );
				?>
			</a>
		</div>
		<div class="hover-mask">
			<h3 class="wd-entities-title<?php echo woodmart_get_old_classes( ' category-title' ); ?>">
				<?php
				echo esc_html( $args['category']->name );

				if ( $args['category']->count > 0 ) {
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $args['category']->count . ')</mark>', $args['category'] );
				}
				?>
			</h3>

			<?php if ( ! $args['hide_product_count'] ) : ?>
				<div class="more-products"><a href="<?php echo esc_url( get_term_link( $args['category']->slug, 'product_cat' ) ); ?>"><?php echo sprintf( _n( '%s product', '%s products', $args['category']->count, 'woodmart' ), $args['category']->count ); ?></a></div>
			<?php endif; ?>

			<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $args['category'] );
			?>
		</div>

		<?php /* translators: %s: Name product category */ ?>
		<a href="<?php echo esc_url( get_term_link( $args['category']->slug, 'product_cat' ) ); ?>" class="category-link wd-fill" aria-label="<?php echo esc_attr( sprintf( __( 'Product category %s', 'woodmart' ), $args['category']->slug ) ); ?>"></a>
		<?php do_action( 'woocommerce_after_subcategory', $args['category'] ); ?>
	</div>
</div>
