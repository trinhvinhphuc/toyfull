<?php
/**
 * Render file for 'Small' product design.
 * Products(grid or carousel) element.
 *
 * @package Woodmart
 */

global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

?>

<?php do_action( 'woodmart_before_shop_loop_thumbnail' ); ?>

<div class="wd-product-thumb">
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="wd-product-link wd-fill"></a>

	<div class="wd-product-image">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
	</div>
</div>

<div class="wd-product-content">
<?php
	do_action( 'woocommerce_shop_loop_item_title' );
	woocommerce_template_loop_rating();
	do_action( 'woocommerce_after_shop_loop_item_title' );
?>
</div>

