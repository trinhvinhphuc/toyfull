<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

// start Woodmart code.
use XTS\Modules\Layouts\Global_Data as Builder_Data;
use XTS\Modules\Layouts\Main as Builder;
// end Woodmart code.

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

// start Woodmart code.
$is_builder                    = Builder::get_instance()->has_custom_layout( 'single_product' );
$is_quick_shop                 = wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'woodmart_quick_shop' === $_REQUEST['action'] && woodmart_get_opt( 'quick_shop_variable' ); // phpcs:ignore
$is_quick_view                 = woodmart_loop_prop( 'is_quick_view' );
$swatches_use_variation_images = woodmart_get_opt( 'swatches_use_variation_images' );
$grid_swatches_attribute       = woodmart_grid_swatches_attribute();
$form_classes                  = '';
$wd_reset_classes              = '';

if ( $is_quick_shop ) {
	$form_classes .= ' wd-reset-bottom-lg wd-reset-bottom-md wd-label-top-lg wd-label-top-md';
}

if ( woodmart_get_opt( 'swatches_labels_name' ) ) {
	$form_classes .= ' wd-swatches-name';
}

if ( ! $is_quick_shop ) {
	if ( woodmart_get_opt( 'single_product_variations_price' ) ) {
		woodmart_enqueue_js_script( 'variations-price' );
		$form_classes .= ' wd-price-outside';
	}
}

if ( $is_builder ) {
	if ( ! empty( Builder_Data::get_instance()->get_data( 'form_classes' ) ) ) {
		$form_classes .= Builder_Data::get_instance()->get_data( 'form_classes' );
	}
} else {
	if ( 'default' === woodmart_get_opt( 'product_design' ) && ! $is_quick_shop ) {
		$form_classes .= ' wd-reset-side-lg';
	}
}

if ( ! $is_quick_shop && ! $is_builder ) {
	if ( 'default' === woodmart_get_opt( 'product_design' ) ) {
		$form_classes .= ' wd-reset-bottom-md wd-label-top-md';

		if ( woodmart_get_opt( 'swatches_labels_name' ) ) {
			$form_classes .= ' wd-label-top-lg';
		}
	} elseif ( 'alt' === woodmart_get_opt( 'product_design' ) ) {
		$form_classes .= ' wd-reset-bottom-lg wd-reset-bottom-md wd-label-top-lg wd-label-top-md';
	}
}

if ( $is_quick_view ) {
	$form_classes = ' wd-reset-side-lg wd-reset-bottom-md wd-label-top-md';

	if ( 'default' === woodmart_get_opt( 'product_design' ) && woodmart_get_opt( 'swatches_labels_name' ) ) {
		$form_classes .= ' wd-label-top-lg';
	}
}

woodmart_enqueue_js_library( 'tooltips' );
woodmart_enqueue_js_script( 'btns-tooltips' );
woodmart_enqueue_js_script( 'swatches-variations' );
// end Woodmart code.

woodmart_enqueue_inline_style( 'woo-mod-variation-form' );
woodmart_enqueue_inline_style( 'woo-mod-product-swatches' );

if ( is_product() || $is_quick_view ) {
	woodmart_enqueue_inline_style( 'woo-mod-variation-form-single' );
}

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart<?php echo esc_attr( $form_classes ); ?>" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // phpcs:ignore. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
			<?php $loop = 0; ?>
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<?php
				// start Woodmart code.
				$loop++;
				$swatches          = woodmart_has_swatches( $product->get_id(), $attribute_name, $options, $available_variations, $swatches_use_variation_images );
				$active_variations = woodmart_get_active_variations( $attribute_name, $available_variations );
				// end Woodmart code.
				?>
				<tr>
					<th class="label cell"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // phpcs:ignore. ?></label></th>
					<td class="value cell<?php echo ! empty( $swatches ) ? esc_attr( ' with-swatches' ) : ''; ?>">
						<?php // start Woodmart code. ?>
						<?php if ( ! empty( $swatches ) ) : ?>
							<div class="swatches-select swatches-on-single" data-id="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
								<?php
								if ( is_array( $options ) ) {
									if ( isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . $attribute_name ];
									} elseif ( isset( $selected_attributes[ $attribute_name ] ) ) {
										$selected_value = $selected_attributes[ $attribute_name ];
									} else {
										$selected_value = '';
									}

									// Get terms if this is a taxonomy - ordered.
									if ( taxonomy_exists( $attribute_name ) ) {
										$terms          = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );
										$swatch_size    = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_size' );
										$_i             = 0;
										$options_fliped = array_flip( $options );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) ) {
												continue;
											}

											$key    = $options_fliped[ $term->slug ];
											$style  = '';
											$class  = 'wd-swatch swatch-on-single ';
											$class .= woodmart_get_old_classes( ' woodmart-swatch ' );

											if ( ! empty( $swatches[ $key ]['color'] ) ) {
												$class .= 'swatch-with-bg';

												if ( ! woodmart_get_opt( 'swatches_labels_name' ) ) {
													$class .= ' wd-tooltip';
												}

												$style = 'background-color:' . $swatches[ $key ]['color'];

											} elseif ( $swatches_use_variation_images && $grid_swatches_attribute === $attribute_name && isset( $swatches[ $key ]['image_src'] ) ) {
												$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $swatches[ $key ]['variation_id'] ), 'woocommerce_thumbnail' );

												if ( ! empty( $thumb ) ) {
													$style  = 'background-image: url(' . $thumb[0] . ')';
													$class .= ' swatch-with-bg';

													if ( ! woodmart_get_opt( 'swatches_labels_name' ) ) {
														$class .= ' wd-tooltip';
													}
												}
											} elseif ( ! empty( $swatches[ $key ]['image'] ) && ( ! is_array( $swatches[ $key ]['image'] ) || ( is_array( $swatches[ $key ]['image'] ) && $swatches[ $key ]['image']['id'] ) ) ) {
												if ( is_array( $swatches[ $key ]['image'] ) && $swatches[ $key ]['image']['id'] ) {
													$swatches[ $key ]['image'] = wp_get_attachment_image_url( $swatches[ $key ]['image']['id'], 'full' );
												}

												$class .= 'swatch-with-bg';
												$style  = 'background-image: url(' . $swatches[ $key ]['image'] . ')';

												if ( ! woodmart_get_opt( 'swatches_labels_name' ) ) {
													$class .= ' wd-tooltip';
												}
											} elseif ( ! empty( $swatches[ $key ]['not_dropdown'] ) ) {
												$class .= ' text-only';
											}

											$class .= ' swatch-size-' . $swatch_size;

											if ( $selected_value === $term->slug ) {
												$class .= ' active-swatch';
											}

											if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && $active_variations ) {
												if ( in_array( $term->slug, $active_variations ) ) {
													$class .= ' swatch-enabled';
												} else {
													$class .= ' swatch-disabled';
												}
											}

											$title = woodmart_get_opt( 'swatches_labels_name' ) ? 'title="' . $term->name . '"' : '';

											echo '<div class="' . esc_attr( $class ) . '" ' . $title . ' data-value="' . esc_attr( $term->slug ) . '" data-title="' . esc_attr( $term->name ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . ' style="' . esc_attr( $style ) . '">' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</div>';

											$_i++;
										}
									} else {
										foreach ( $options as $option ) {
											$class = '';

											if ( $selected_value === $option ) {
												$class .= ' active-swatch';
											}

											if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && $active_variations ) {
												if ( in_array( $term->slug, $active_variations ) ) {
													$class .= ' swatch-enabled';
												} else {
													$class .= ' swatch-disabled';
												}
											}

											$title = woodmart_get_opt( 'swatches_labels_name' ) ? 'title="' . $term->name . '"' : '';

											echo '<div class="' . esc_attr( $class ) . '" ' . $title . ' data-value="' . esc_attr( sanitize_title( $option ) ) . '" data-title="' . esc_attr( $term->name ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</div>';
										}
									}
								}
								?>
							</div>
						<?php endif; ?>
						<?php // end Woodmart code. ?>
						<?php
						wc_dropdown_variation_attribute_options(
							array(
								'options'   => $options,
								'attribute' => $attribute_name,
								'product'   => $product,
							)
						);
						echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<div class="wd-reset-var' . $wd_reset_classes . '"><a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a></div>' ) ) : '';
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_variations_table' ); ?>

	<div class="single_variation_wrap">
		<?php
			/**
			 * Hook: woocommerce_before_single_variation.
			 */
			do_action( 'woocommerce_before_single_variation' );

			/**
			 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
			 *
			 * @since 2.4.0
			 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
			 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
			 */
			do_action( 'woocommerce_single_variation' );

			/**
			 * Hook: woocommerce_after_single_variation.
			 */
			do_action( 'woocommerce_after_single_variation' );
		?>
	</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
