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

if ( 'mask-subcat' === woodmart_loop_prop( 'product_categories_design' ) ) {
	$sub_categories = get_terms(
		'product_cat',
		array(
			'fields'       => 'all',
			'parent'       => $category->term_id,
			'hierarchical' => true,
			'hide_empty'   => true,
		)
	);
}
?>

<div <?php wc_product_cat_class( $args['classes'], $args['category'] ); ?> data-loop="<?php echo esc_attr( $args['woocommerce_loop'] ); ?>">
	<div class="wd-cat-inner">
		<div class="wd-cat-thumb">
			<?php do_action( 'woocommerce_after_subcategory', $args['category'] ); ?>
			<div class="wd-cat-image">
				<?php do_action( 'woocommerce_before_subcategory', $args['category'] ); ?>

				<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woodmart_category_thumb_double_size - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $args['category'] );
				?>
			</div>
		</div>
		<div class="wd-cat-content wd-scroll wd-fill">
			<a class="wd-fill" href="<?php echo esc_url( get_term_link( $args['category']->slug, 'product_cat' ) ); ?>"></a>
			<div class="wd-cat-header">
				<h3 class="wd-entities-title<?php echo esc_attr( woodmart_get_old_classes( ' category-title' ) ); ?>">
					<a href="<?php echo esc_url( get_term_link( $args['category']->slug, 'product_cat' ) ); ?>">
						<?php
							echo esc_html( $args['category']->name );
						?>
					</a>
				</h3>

				<?php if ( ! $args['hide_product_count'] ) : ?>
					<div class="wd-cat-count">
						<?php echo esc_html( $args['category']->count ); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( isset( $sub_categories ) && ! empty( $sub_categories ) ) : ?>
				<div class="wd-cat-footer wd-scroll-content">
					<ul class="wd-cat-sub-menu wd-sub-menu">
						<?php foreach ( $sub_categories as $sub_category ) : // phpcs:ignore ?>
							<li>
								<a href="<?php echo esc_url( get_term_link( $sub_category->term_id ) ); ?>">
									<?php echo esc_html( $sub_category->name ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
