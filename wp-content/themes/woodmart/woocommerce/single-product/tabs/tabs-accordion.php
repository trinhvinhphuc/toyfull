<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @var array $args This is an array of data to display this template.
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs             = apply_filters( 'woocommerce_product_tabs', array() );
$content_count            = 0;
$wrapper_classes          = $args['builder_accordion_classes'];
$accordion_state          = $args['builder_state'];
$accordion_opener_classes = $args['builder_opener_classes'];

woodmart_enqueue_inline_style( 'accordion' );
woodmart_enqueue_js_script( 'accordion-element' );
?>
<?php if ( ! empty( $product_tabs ) ) : ?>
	<div class="wd-accordion<?php echo esc_attr( $wrapper_classes ); ?>" data-state="<?php echo esc_attr( $accordion_state ); ?>">
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php
			$title_wrapper_classes  = ' tab-title-' . $key;
			$title_wrapper_classes .= $args['builder_title_classes'];
			$content_classes        = ' woocommerce-Tabs-panel--' . $key;

			if ( isset( $args['builder_content_classes'] ) && ! empty( $args['builder_content_classes'] ) ) {
				$content_classes .= $args['builder_content_classes'];
			}

			if ( 0 === $content_count && 'first' === $accordion_state ) {
				$title_wrapper_classes .= ' wd-active';
				$content_classes       .= ' wd-active';
			}

			if ( 'woocommerce_product_additional_information_tab' === $product_tab['callback'] ) {
				$content_classes .= ' wd-single-attrs';
				$content_classes .= $args['builder_additional_info_classes'];
			}

			if ( 'comments_template' === $product_tab['callback'] ) {
				$content_classes .= ' wd-single-reviews';
				$content_classes .= $args['builder_reviews_classes'];
			}
			?>
			<div class="wd-accordion-item">
				<div href="#tab-<?php echo esc_attr( $key ); ?>" class="wd-accordion-title<?php echo esc_attr( $title_wrapper_classes ); ?>" data-accordion-index="<?php echo esc_attr( $key ); ?>">
					<div class="wd-accordion-title-text">
						<span>
							<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
						</span>
					</div>

					<span class="wd-accordion-opener<?php echo esc_attr( $accordion_opener_classes ); ?>"></span>
				</div>

				<div class="woocommerce-Tabs-panel panel entry-content wc-tab wd-scroll wd-accordion-content<?php echo esc_attr( $content_classes ); ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>" data-accordion-index="<?php echo esc_attr( $key ); ?>">
					<div class="wd-scroll-content">
						<?php if ( isset( $product_tab['callback'] ) ) : ?>
							<?php call_user_func( $product_tab['callback'], $key, $product_tab ); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<?php $content_count++; ?>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>
<?php endif; ?>
