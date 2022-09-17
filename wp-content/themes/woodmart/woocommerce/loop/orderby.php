<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

woodmart_enqueue_inline_style( 'woo-shop-el-order-by' );

use XTS\Modules\Layouts\Global_Data as Builder_Data;

$builder_ordering_classes = Builder_Data::get_instance()->get_data( 'builder_ordering_classes' );

$ordering_classes  = ! empty( $list ) ? 'woocommerce-ordering-list' : 'woocommerce-ordering';
$ordering_classes .= ! empty( $builder_ordering_classes ) ? $builder_ordering_classes : ' wd-style-underline wd-ordering-mb-icon';
?>
<form class="<?php echo esc_attr( $ordering_classes ); ?>" method="get">
	<?php if ( ! empty( $list ) ): ?>
		<ul>
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<?php 

					$link = woodmart_shop_page_link( true );

					$link = add_query_arg( 'orderby', $id, $link );

				 ?>
				<li>
					<a href="<?php echo esc_url( $link ); ?>" data-order="<?php echo esc_attr( $id ); ?>" class="<?php if(selected( $orderby, $id, false ) ) echo 'selected-order'; ?>"><?php echo esc_html( $name ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>
		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged' ) ); ?>
	<?php endif ?>
</form>
