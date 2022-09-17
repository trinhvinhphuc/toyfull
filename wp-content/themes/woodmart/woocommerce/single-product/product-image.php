<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

$thumbs_position   = woodmart_get_opt( 'thums_position' );
$image_action      = woodmart_get_opt( 'image_action' );
$is_quick_view     = woodmart_loop_prop( 'is_quick_view' );
$product_design    = woodmart_product_design();
$attachment_ids    = $product->get_gallery_image_ids();
$post_thumbnail_id = $product->get_image_id();
$placeholder       = $post_thumbnail_id ? 'with-images' : 'without-images';
$thumb_image_size  = 'woocommerce_single';
$hide_owl_classes  = array();

// Builder settings.
if ( isset( $args['builder_thumbnails_position'] ) && 'inherit' !== $args['builder_thumbnails_position'] ) {
	$thumbs_position = $args['builder_thumbnails_position'];
}

$columns         = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size  = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$full_size_image = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$wrapper_classes = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

if ( 'sticky' === $product_design ) {
	$attachment_ids = false;
}

if ( 'bottom_column' === $thumbs_position || 'bottom_grid' === $thumbs_position || 'bottom_combined' === $thumbs_position ) {
	$hide_owl_classes = array( 'lg' );
}

$gallery_classes = woodmart_owl_items_per_slide( 1, $hide_owl_classes, false, 'main-gallery' );

if ( 'carousel_two_columns' === $thumbs_position ) {
	$gallery_classes = woodmart_owl_items_per_slide(
		2,
		$hide_owl_classes,
		false,
		'main-gallery',
		array(
			'desktop'          => 2,
			'tablet_landscape' => 2,
			'tablet'           => 2,
			'mobile'           => 2,
		)
	);
}

if ( 'sticky' !== $product_design && 'without' === $thumbs_position || 'centered' === $thumbs_position || 'bottom' === $thumbs_position || 'left' === $thumbs_position || 'carousel_two_columns' === $thumbs_position ) {
	$gallery_classes .= ' owl-carousel';
}

if ( 'popup' === $image_action ) {
	woodmart_enqueue_js_library( 'photoswipe-bundle' );
	woodmart_enqueue_inline_style( 'photoswipe' );
	woodmart_enqueue_js_script( 'product-images' );
}

if ( 'zoom' === $image_action ) {
	woodmart_enqueue_js_script( 'init-zoom' );
}

woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery' );

if ( 'left' === $thumbs_position ) {
	woodmart_enqueue_js_library( 'slick' );
	woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery-opt-thumb-left' );
}

if ( 'left' !== $thumbs_position && 'bottom' !== $thumbs_position && 'without' !== $thumbs_position ) {
	woodmart_enqueue_inline_style( 'woo-single-prod-el-gallery-opt-thumb-columns' );
}

woodmart_enqueue_js_library( 'owl' );
woodmart_enqueue_js_script( 'product-images-gallery' );
woodmart_enqueue_inline_style( 'owl-carousel' );
wp_enqueue_script( 'imagesloaded' );

?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?> images row align-items-start thumbs-position-<?php echo esc_attr( $thumbs_position ); ?> image-action-<?php echo esc_attr( $image_action ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<?php
	$main_gallery_classes = '';

	if ( $attachment_ids && 'left' === $thumbs_position && ! $is_quick_view ) {
		$main_gallery_classes .= 'col-lg-9 order-lg-last';
	} else {
		$main_gallery_classes .= 'col-12';
	}

	?>

	<div class="<?php echo esc_attr( $main_gallery_classes ); ?>">
		<?php do_action( 'woodmart_before_single_product_main_gallery' ); ?>

		<figure class="woocommerce-product-gallery__wrapper <?php echo esc_attr( $gallery_classes ); ?>">
			<?php
			$attributes = array(
				'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
				'data-src'                => isset( $full_size_image[0] ) ? $full_size_image[0] : '',
				'data-large_image'        => isset( $full_size_image[0] ) ? $full_size_image[0] : '',
				'data-large_image_width'  => isset( $full_size_image[1] ) ? $full_size_image[1] : '',
				'data-large_image_height' => isset( $full_size_image[2] ) ? $full_size_image[2] : '',
				'class'                   => apply_filters( 'woodmart_single_product_gallery_image_class', 'wp-post-image' ),
			);

			if ( $product->get_image_id() ) {
				$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
				$thumbnail_size    = apply_filters(
					'woocommerce_gallery_thumbnail_size',
					array(
						$gallery_thumbnail['width'],
						$gallery_thumbnail['height'],
					)
				);

				$thumbnail_src = get_the_post_thumbnail_url( $post->ID, $thumbnail_size );
				$html          = '<div class="product-image-wrap"><figure data-thumb="' . $thumbnail_src . '" class="woocommerce-product-gallery__image"><a data-elementor-open-lightbox="no" href="' . esc_url( $full_size_image[0] ) . '">';
				$html         .= get_the_post_thumbnail( $post->ID, $thumb_image_size, $attributes );
				$html         .= '</a></figure></div>';
			} else {
				$html = '<div class="product-image-wrap"><figure data-thumb="' . esc_url( wc_placeholder_img_src( $thumb_image_size ) ) . '" class="woocommerce-product-gallery__image--placeholder"><a data-elementor-open-lightbox="no" href="' . esc_url( wc_placeholder_img_src( $thumb_image_size ) ) . '">';

				$html .= sprintf( '<img src="%s" alt="%s" data-src="%s" data-large_image="%s" data-large_image_width="700" data-large_image_height="800" class="attachment-woocommerce_single size-woocommerce_single wp-post-image" />', esc_url( wc_placeholder_img_src( $thumb_image_size ) ), esc_html__( 'Awaiting product image', 'woocommerce' ), esc_url( wc_placeholder_img_src( $thumb_image_size ) ), esc_url( wc_placeholder_img_src( $thumb_image_size ) ) );

				$html .= '</a></figure></div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ) // phpcs:ignore;
			?>

			<?php do_action( 'woocommerce_product_thumbnails' ); ?>
		</figure>

		<?php do_action( 'woodmart_on_product_image' ); ?>
	</div>

	<?php if ( $attachment_ids && ( 'sticky' !== $product_design && ( 'bottom' === $thumbs_position || 'left' === $thumbs_position ) ) ) : ?>
		<?php
		$thumbs_classes = '';

		if ( 'left' === $thumbs_position && ! $is_quick_view ) {
			$thumbs_wrapper_classes = 'col-lg-3 order-lg-first';
		} else {
			$thumbs_wrapper_classes = 'col-12';
		}

		if ( 'bottom' === $thumbs_position ) {
			$thumbs_classes .= ' owl-items-lg-4 owl-items-md-3 owl-carousel';
		}

		?>
		<div class="<?php echo esc_attr( $thumbs_wrapper_classes ); ?>">
			<div class="thumbnails owl-items-sm-3 owl-items-xs-3<?php echo esc_attr( $thumbs_classes ); ?>"></div>
		</div>
	<?php endif; ?>
</div>
