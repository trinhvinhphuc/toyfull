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
$tab_count                = 0;
$tabs_classes             = $args['builder_tabs_classes'];
$nav_tabs_wrapper_classes = $args['builder_nav_tabs_wrapper_classes'];

woodmart_enqueue_inline_style( 'tabs' );
woodmart_enqueue_inline_style( 'woo-single-prod-el-tabs-opt-layout-tabs' );
?>
<?php if ( ! empty( $product_tabs ) ) : ?>
	<div class="woocommerce-tabs wc-tabs-wrapper">
		<div class="wd-nav-wrapper wd-nav-tabs-wrapper<?php echo esc_attr( $nav_tabs_wrapper_classes ); ?>">
			<ul class="wd-nav wd-nav-tabs wd-icon-pos-left tabs wc-tabs<?php echo esc_attr( $tabs_classes ); ?>">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<?php
					$li_classes = $key . '_tab';

					if ( 0 === $tab_count ) {
						$li_classes .= ' active';
					}
					?>
					<li class="<?php echo esc_attr( $li_classes ); ?>" id="tab-title-<?php echo esc_attr( $key ); ?>"
						role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a class="wd-nav-link" href="#tab-<?php echo esc_attr( $key ); ?>">
							<span class="nav-link-text wd-tabs-title">
								<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
							</span>
						</a>
					</li>

					<?php $tab_count++; ?>
				<?php endforeach; ?>
			</ul>
		</div>

		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php
			$content_classes = ' woocommerce-Tabs-panel--' . $key;

			if ( isset( $args['builder_content_classes'] ) && ! empty( $args['builder_content_classes'] ) ) {
				$content_classes .= $args['builder_content_classes'];
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
			<div class="woocommerce-Tabs-panel panel entry-content wc-tab<?php echo esc_attr( $content_classes ); ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>" data-accordion-index="<?php echo esc_attr( $key ); ?>">
				<?php if ( isset( $product_tab['callback'] ) ) : ?>
					<?php call_user_func( $product_tab['callback'], $key, $product_tab ); ?>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>
<?php endif; ?>
