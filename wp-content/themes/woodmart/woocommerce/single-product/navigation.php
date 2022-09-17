<?php
/**
 * Single product navigation.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$in_same_term = apply_filters( 'woodmart_get_prev_product_same_term', false );
$next         = woodmart_get_next_product( $in_same_term );
$prev         = woodmart_get_previous_product( $in_same_term );

$back_btn_classes = woodmart_get_old_classes( ' woodmart-back-btn' );
$wrapper_classes  = woodmart_get_old_classes( ' woodmart-products-nav' );

woodmart_enqueue_inline_style( 'woo-single-prod-el-navigation' );

?>

<div class="wd-products-nav<?php echo esc_attr( $wrapper_classes ); ?>">
	<?php if ( $prev ) : ?>
		<div class="wd-event-hover">
			<a class="wd-product-nav-btn wd-btn-prev" href="<?php echo esc_url( $prev->get_permalink() ); ?>"></a>

			<div class="wd-dropdown">
				<a href="<?php echo esc_url( $prev->get_permalink() ); ?>" class="wd-product-nav-thumb">
					<?php echo apply_filters( 'woodmart_products_nav_image', $prev->get_image() ); // phpcs:ignore ?>
				</a>

				<div class="wd-product-nav-desc">
					<a href="<?php echo esc_url( $prev->get_permalink() ); ?>" class="wd-entities-title">
						<?php echo $prev->get_title(); // phpcs:ignore ?>
					</a>

					<span class="price">
						<?php echo wp_kses_post( $prev->get_price_html() ); ?>
					</span>
				</div>
			</div>
		</div>
	<?php endif ?>

	<a href="<?php echo esc_url( apply_filters( 'woodmart_single_product_back_btn_url', get_permalink( wc_get_page_id( 'shop' ) ) ) ); ?>" class="wd-product-nav-btn wd-btn-back<?php echo esc_attr( $back_btn_classes ); ?>">
		<span>
			<?php esc_html_e( 'Back to products', 'woodmart' ); ?>
		</span>
	</a>

	<?php if ( $next ) : ?>
		<div class="wd-event-hover">
			<a class="wd-product-nav-btn wd-btn-next" href="<?php echo esc_url( $next->get_permalink() ); ?>"></a>

			<div class="wd-dropdown">
				<a href="<?php echo esc_url( $next->get_permalink() ); ?>" class="wd-product-nav-thumb">
					<?php echo apply_filters( 'woodmart_products_nav_image', $next->get_image() ); // phpcs:ignore ?>
				</a>

				<div class="wd-product-nav-desc">
					<a href="<?php echo esc_url( $next->get_permalink() ); ?>" class="wd-entities-title">
						<?php echo $next->get_title(); // phpcs:ignore ?>
					</a>

					<span class="price">
						<?php echo wp_kses_post( $next->get_price_html() ); ?>
					</span>
				</div>
			</div>
		</div>
	<?php endif ?>
</div>
