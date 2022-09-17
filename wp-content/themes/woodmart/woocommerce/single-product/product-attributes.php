<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}
?>
<table class="woocommerce-product-attributes shop_attributes">
	<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
		<?php
		$attribute_name = str_replace( 'attribute_pa_', '', $product_attribute_key );
		$thumb_id       = get_option( 'woodmart_pa_' . $attribute_name . '_thumbnail' );
		$image_size     = apply_filters( 'woodmart_product_attributes_table_image_size', 'thumbnail' );
		?>

		<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
			<th class="woocommerce-product-attributes-item__label">
				<?php if ( ! empty( $thumb_id ) ) : ?>
					<?php if ( woodmart_is_svg( wp_get_attachment_image_url( $thumb_id ) ) ) : ?>
						<?php echo woodmart_get_svg_html( $thumb_id, $image_size, array( 'class' => 'wd-attr-img' ) ); //phpcs:ignore. ?>
					<?php else : ?>
						<?php echo wp_get_attachment_image( $thumb_id, $image_size, false, array( 'class' => 'wd-attr-img' ) ); ?>
					<?php endif; ?>
				<?php endif; ?>

				<span>
					<?php echo wp_kses_post( $product_attribute['label'] ); ?>
				</span>
			</th>
			<td class="woocommerce-product-attributes-item__value">
				<?php echo wp_kses_post( $product_attribute['value'] ); ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
