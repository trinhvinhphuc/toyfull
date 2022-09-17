<?php
/**
 * Products template function
 *
 * @package xts
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_elementor_products_config' ) ) {
	/**
	 * Products element config
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function woodmart_get_elementor_products_config() {
		return array(
			// General.
			'element_title'            => '',

			// Title.
			'title_alignment'          => 'left',

			// Query.
			'post_type'                => 'product',
			'include'                  => '',
			'taxonomies'               => '',
			'offset'                   => '',
			'orderby'                  => '',
			'query_type'               => 'OR',
			'order'                    => '',
			'meta_key'                 => '', // phpcs:ignore
			'exclude'                  => '',
			'shop_tools'               => '0',
			'hide_out_of_stock'        => 'no',

			// Carousel.
			'speed'                    => '5000',
			'slides_per_view'          => array( 'size' => 4 ),
			'slides_per_view_tablet'   => array( 'size' => '' ),
			'slides_per_view_mobile'   => array( 'size' => '' ),
			'wrap'                     => '',
			'autoplay'                 => 'no',
			'center_mode'              => 'no',
			'hide_pagination_control'  => '',
			'hide_prev_next_buttons'   => '',
			'scroll_per_page'          => 'yes',

			// Layout.
			'layout'                   => 'grid',
			'pagination'               => '',
			'items_per_page'           => 12,
			'spacing'                  => woodmart_get_opt( 'products_spacing' ),
			'columns'                  => array( 'size' => 4 ),
			'columns_tablet'           => array( 'size' => '' ),
			'columns_mobile'           => array( 'size' => '' ),
			'products_masonry'         => woodmart_get_opt( 'products_masonry' ),
			'products_different_sizes' => woodmart_get_opt( 'products_different_sizes' ),
			'product_quantity'         => woodmart_get_opt( 'product_quantity' ),

			// Design.
			'product_hover'                => woodmart_get_opt( 'products_hover' ),
			'sale_countdown'               => 0,
			'stretch_product'              => 0,
			'stretch_product_tablet'       => 0,
			'stretch_product_mobile'       => 0,
			'stock_progress_bar'           => 0,
			'highlighted_products'         => 0,
			'products_bordered_grid'       => 0,
			'products_bordered_grid_style' => 'outside',
			'img_size'                     => 'woocommerce_thumbnail',

			// Extra.
			'ajax_page'                => '',
			'force_not_ajax'           => 'no',
			'lazy_loading'             => 'no',
			'scroll_carousel_init'     => 'no',
			'custom_sizes'             => apply_filters( 'woodmart_products_shortcode_custom_sizes', false ),
			'elementor'                => true,
		);
	}
}


if ( ! function_exists( 'woodmart_elementor_products_template' ) ) {
	function woodmart_elementor_products_template( $settings ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}
		global $product;

		$default_settings = woodmart_get_elementor_products_config();
		$settings         = wp_parse_args( $settings, $default_settings );

		if ( empty( $settings['spacing'] ) && '0' !== $settings['spacing'] && 0 !== $settings['spacing'] ) {
			$settings['spacing'] = woodmart_get_opt( 'products_spacing' );
		}

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		if ( isset( $_GET['product-page'] ) ) { // phpcs:ignore
			$paged = wc_clean( wp_unslash( $_GET['product-page'] ) ); // phpcs:ignore
		}

		$is_ajax                    = woodmart_is_woo_ajax() && 'yes' !== $settings['force_not_ajax'];
		$settings['force_not_ajax'] = 'no';
		$wrapper_classes            = '';
		$products_element_classes   = '';
		$encoded_settings           = wp_json_encode( array_intersect_key( $settings, $default_settings ) );

		if ( $settings['ajax_page'] > 1 ) {
			$paged = $settings['ajax_page'];
		}

		// Query settings.
		$ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'paged'               => $paged,
			'orderby'             => $ordering_args['orderby'],
			'order'               => $ordering_args['order'],
			'posts_per_page'      => $settings['items_per_page'],
			'meta_query'          => WC()->query->get_meta_query(), // phpcs:ignore
			'tax_query'           => WC()->query->get_tax_query(), // phpcs:ignore
		);

		if ( 'new' === $settings['post_type'] ) {
			$days = woodmart_get_opt( 'new_label_days_after_create' );
			if ( $days ) {
				$query_args['date_query'] = array(
					'after' => date( 'Y-m-d', strtotime( '-' . $days . ' days' ) ),
				);
			} else {
				$query_args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => '_woodmart_new_label',
						'value'   => 'on',
						'compare' => 'IN',
					),
					array(
						'key'     => '_woodmart_new_label_date',
						'value'   => date( 'Y-m-d' ), // phpcs:ignore
						'compare' => '>',
						'type'    => 'DATE',
					),
				);
			}
		}

		if ( $ordering_args['meta_key'] ) {
			$query_args['meta_key'] = $ordering_args['meta_key']; // phpcs:ignore
		}
		if ( $settings['meta_key'] ) {
			$query_args['meta_key'] = $settings['meta_key']; // phpcs:ignore
		}
		if ( 'ids' === $settings['post_type'] && $settings['include'] ) {
			$query_args['post__in'] = $settings['include'];
		}
		if ( $settings['exclude'] ) {
			$query_args['post__not_in'] = $settings['exclude'];
		}
		if ( $settings['taxonomies'] ) {
			$taxonomy_names = get_object_taxonomies( 'product' );
			$terms          = get_terms(
				$taxonomy_names,
				array(
					'orderby'    => 'name',
					'include'    => $settings['taxonomies'],
					'hide_empty' => false,
				)
			);

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				if ( 'featured' === $settings['post_type'] ) {
					$query_args['tax_query'] = [ 'relation' => 'AND' ]; // phpcs:ignore
				}

				$relation = $settings['query_type'] ? $settings['query_type'] : 'OR';
				if ( count( $terms ) > 1 ) {
					$query_args['tax_query']['categories'] = array( 'relation' => $relation );
				}

				foreach ( $terms as $term ) {
					$query_args['tax_query']['categories'][] = array(
						'taxonomy'         => $term->taxonomy,
						'field'            => 'slug',
						'terms'            => array( $term->slug ),
						'include_children' => true,
						'operator'         => 'IN',
					);
				}
			}
		}
		if ( 'featured' === $settings['post_type'] ) {
			$query_args['tax_query'][] = array(
				'taxonomy'         => 'product_visibility',
				'field'            => 'name',
				'terms'            => 'featured',
				'operator'         => 'IN',
				'include_children' => false,
			);
		}
		if ( 'yes' === $settings['hide_out_of_stock'] || apply_filters( 'woodmart_hide_out_of_stock_items', false ) && 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_stock_status',
				'value'   => 'outofstock',
				'compare' => 'NOT IN',
			);
		}
		if ( $settings['order'] ) {
			$query_args['order'] = $settings['order'];
		}
		if ( $settings['offset'] ) {
			$query_args['offset'] = $settings['offset'];
		}
		if ( 'sale' === $settings['post_type'] ) {
			$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		}
		if ( 'bestselling' === $settings['post_type'] ) {
			$query_args['orderby']  = 'meta_value_num';
			$query_args['meta_key'] = 'total_sales'; // phpcs:ignore
			$query_args['order']    = 'DESC';
		}

		WC()->query->remove_ordering_args();

		if ( isset( $_GET['orderby'] ) && $settings['shop_tools'] ) { // phpcs:ignore
			$element_orderby = wc_clean( wp_unslash( $_GET['orderby'] ) ); // phpcs:ignore

			if ( 'date' === $element_orderby ) {
				$query_args['orderby'] = 'date';
				$query_args['order']   = 'DESC';
			} elseif ( 'price-desc' === $element_orderby ) {
				$query_args['orderby'] = 'price';
				$query_args['order']   = 'DESC';
			} else {
				$query_args['orderby'] = $element_orderby;
				$query_args['order']   = 'ASC';
			}
		}

		if ( 'price' === $query_args['orderby'] ) {
			$query_args['orderby']  = 'meta_value_num';
			$query_args['meta_key'] = '_price'; // phpcs:ignore
		}

		if ( isset( $_GET['per_page'] ) && $settings['shop_tools'] ) { // phpcs:ignore
			$query_args['posts_per_page'] = wc_clean( wp_unslash( $_GET['per_page'] ) ); // phpcs:ignore
		}

		if ( 'upsells' === $settings['post_type'] ) {
			if ( $product ) {
				$query_args['post__in'] = array_merge( array( 0 ), $product->get_upsell_ids() );

				if ( ! isset( $query_args['post__in'][1] ) && 0 === $query_args['post__in'][0] ) {
					return false;
				}
			}
		}

		if ( 'related' === $settings['post_type'] ) {
			if ( $product ) {
				$query_args['post__in'] = array_merge( array( 0 ), wc_get_related_products( $product->get_id(), $query_args['posts_per_page'], $product->get_upsell_ids() ) );

				if ( ! isset( $query_args['post__in'][1] ) && 0 === $query_args['post__in'][0] ) {
					return false;
				}
			}
		}

		if ( 'cross-sells' === $settings['post_type'] ) {
			if ( is_object( WC()->cart )  ) {
				$cross_sells = WC()->cart->get_cross_sells();

				if ( ! $cross_sells ) {
					return false;
				}

				if ( $cross_sells ) {
					$query_args['post__in'] = array_merge( array( 0 ), $cross_sells );
				}
			} else {
				return false;
			}
		}

		if ( 'top_rated_products' === $settings['post_type'] ) {
			add_filter( 'posts_clauses', 'woodmart_order_by_rating_post_clauses' );
			$products = new WP_Query( apply_filters( 'woodmart_product_element_query_args', $query_args ) );
			remove_filter( 'posts_clauses', 'woodmart_order_by_rating_post_clauses' );
		} else {
			$products = new WP_Query( apply_filters( 'woodmart_product_element_query_args', $query_args ) );
		}

		// Element settings.
		if ( 'inherit' === $settings['product_hover'] ) {
			$settings['product_hover'] = woodmart_get_opt( 'products_hover' );
			$settings['stretch_product'] = woodmart_get_opt( 'stretch_product_desktop' );
			$settings['stretch_product_tablet'] = woodmart_get_opt( 'stretch_product_tablet' );
			$settings['stretch_product_mobile'] = woodmart_get_opt( 'stretch_product_mobile' );
		}

		if ( 'small' === $settings['product_hover'] ) {
			woodmart_enqueue_inline_style( 'woo-prod-loop-small' );
		}

		// Loop settings.
		woodmart_set_loop_prop( 'timer', $settings['sale_countdown'] );
		woodmart_set_loop_prop( 'progress_bar', $settings['stock_progress_bar'] );
		woodmart_set_loop_prop( 'stretch_product_desktop', $settings['stretch_product'] );
		woodmart_set_loop_prop( 'stretch_product_tablet', $settings['stretch_product_tablet'] );
		woodmart_set_loop_prop( 'stretch_product_mobile', $settings['stretch_product_mobile'] );
		woodmart_set_loop_prop( 'product_hover', $settings['product_hover'] );
		woodmart_set_loop_prop( 'products_view', $settings['layout'] );
		woodmart_set_loop_prop( 'is_shortcode', true );
		woodmart_set_loop_prop( 'img_size', $settings['img_size'] );

		if ( isset( $settings['img_size_custom'] ) ) {
			woodmart_set_loop_prop( 'img_size_custom', $settings['img_size_custom'] );
		}
		if ( isset( $settings['columns']['size'] ) ) {
			woodmart_set_loop_prop( 'products_columns', $settings['columns']['size'] );
		}
		if ( isset( $settings['columns_tablet']['size'] ) && $settings['columns_tablet']['size'] ) {
			woodmart_set_loop_prop( 'products_columns_tablet', $settings['columns_tablet']['size'] );
		}
		if ( isset( $settings['columns_mobile']['size'] ) && $settings['columns_mobile']['size'] ) {
			woodmart_set_loop_prop( 'products_columns_mobile', $settings['columns_mobile']['size'] );
		}
		if ( $settings['products_masonry'] ) {
			woodmart_set_loop_prop( 'products_masonry', 'enable' === $settings['products_masonry'] );
		}
		if ( $settings['products_different_sizes'] ) {
			woodmart_set_loop_prop( 'products_different_sizes', 'enable' === $settings['products_different_sizes'] );
		}
		if ( $settings['product_quantity'] ) {
			woodmart_set_loop_prop( 'product_quantity', 'enable' === $settings['product_quantity'] );
		}
		if ( 'arrows' !== $settings['pagination'] ) {
			woodmart_set_loop_prop( 'woocommerce_loop', $settings['items_per_page'] * ( $paged - 1 ) );
		}
		if ( isset( $_GET['shop_view'] ) && $settings['shop_tools'] ) { // phpcs:ignore
			woodmart_set_loop_prop( 'products_view', wc_clean( wp_unslash( $_GET['shop_view'] ) ) ); // phpcs:ignore
		}

		if ( isset( $_GET['per_row'] ) && $settings['shop_tools'] ) { // phpcs:ignore
			woodmart_set_loop_prop( 'products_columns', wc_clean( wp_unslash( $_GET['per_row'] ) ) ); // phpcs:ignore
			$settings['columns']['size'] = wc_clean( wp_unslash( $_GET['per_row'] ) ); // phpcs:ignore
		}

		if ( 'carousel' === $settings['layout'] ) {
			$settings['slides_per_view'] = $settings['slides_per_view']['size'];

			woodmart_enqueue_product_loop_styles( $settings['product_hover'] );

			if ( ( isset( $settings['slides_per_view_tablet']['size'] ) && ! empty( $settings['slides_per_view_tablet']['size'] ) ) || ( isset( $settings['slides_per_view_mobile']['size'] ) && ! empty( $settings['slides_per_view_mobile']['size'] ) ) ) {
				$settings['custom_sizes'] = array(
					'desktop' => $settings['slides_per_view'],
					'tablet_landscape' => $settings['slides_per_view_tablet']['size'],
					'tablet' => $settings['slides_per_view_mobile']['size'],
					'mobile' => $settings['slides_per_view_mobile']['size'],
				);
			}

			return woodmart_generate_posts_slider( $settings, $products );
		}

		if ( $settings['shop_tools'] ) {
			woodmart_enqueue_inline_style( 'woo-shop-el-order-by' );
			woodmart_enqueue_inline_style( 'woo-shop-el-products-per-page' );
			woodmart_enqueue_inline_style( 'woo-shop-el-products-view' );
			woodmart_enqueue_inline_style( 'woo-mod-shop-loop-head' );
		}

		if ( $is_ajax ) {
			ob_start();
		}

		// Classes.
		$wrapper_classes .= ' pagination-' . $settings['pagination'];
		if ( 'list' === $settings['layout'] ) {
			woodmart_enqueue_inline_style( 'product-loop-list' );

			$wrapper_classes .= ' elements-list';
		} else {
			if ( ! $settings['highlighted_products'] ) {
				$wrapper_classes .= ' wd-spacing-' . $settings['spacing'];
			}

			$wrapper_classes .= ' grid-columns-' . $settings['columns']['size'];
		}
		if ( $settings['products_bordered_grid'] && ! $settings['highlighted_products'] ) {
			woodmart_enqueue_inline_style( 'bordered-product' );

			if ( 'outside' === $settings['products_bordered_grid_style'] ) {
				$wrapper_classes .= ' products-bordered-grid';
			} elseif ( 'inside' === $settings['products_bordered_grid_style'] ) {
				$wrapper_classes .= ' products-bordered-grid-ins';
			}
		}
		if ( woodmart_loop_prop( 'product_quantity' ) ) {
			$wrapper_classes .= ' wd-quantity-enabled';
		}
		if ( 'none' !== woodmart_get_opt( 'product_title_lines_limit' ) && 'list' !== $settings['layout'] ) {
			woodmart_enqueue_inline_style( 'woo-opt-title-limit' );
			$wrapper_classes .= ' title-line-' . woodmart_get_opt( 'product_title_lines_limit' );
		}
		if ( woodmart_loop_prop( 'products_masonry' ) ) {
			$wrapper_classes .= ' grid-masonry';
			wp_enqueue_script( 'imagesloaded' );
			woodmart_enqueue_js_library( 'isotope-bundle' );
			woodmart_enqueue_js_script( 'shop-masonry' );
		}

		if ( woodmart_get_opt( 'quick_shop_variable' ) ) {
			woodmart_enqueue_js_script( 'quick-shop' );
			woodmart_enqueue_js_script( 'swatches-variations' );
			woodmart_enqueue_js_script( 'add-to-cart-all-types' );
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}

		if ( $settings['highlighted_products'] ) {
			woodmart_enqueue_inline_style( 'highlighted-product' );
		}

		$products_element_classes .= $settings['highlighted_products'] ? ' wd-highlighted-products' : '';
		$products_element_classes .= $settings['highlighted_products'] ? woodmart_get_old_classes( ' woodmart-highlighted-products' ) : '';
		$products_element_classes .= $settings['element_title'] ? ' with-title' : '';

		wc_set_loop_prop( 'total', $products->found_posts );
		wc_set_loop_prop( 'total_pages', $products->max_num_pages );
		wc_set_loop_prop( 'current_page', $products->query['paged'] );
		wc_set_loop_prop( 'is_shortcode', true );

		if ( $products->have_posts() ) {
			woodmart_enqueue_product_loop_styles( $settings['product_hover'] );
		}

		// Lazy loading.
		if ( 'yes' === $settings['lazy_loading'] ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		if ( ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) && in_array( $settings['product_hover'],
				array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base' ) ) ) {
			woodmart_enqueue_inline_style( 'woo-opt-stretch-cont' );
			if ( woodmart_loop_prop( 'stretch_product_desktop' ) ) {
				$wrapper_classes .= ' wd-stretch-cont-lg';
			}
			if ( woodmart_loop_prop( 'stretch_product_tablet' ) ) {
				$wrapper_classes .= ' wd-stretch-cont-md';
			}
			if ( woodmart_loop_prop( 'stretch_product_mobile' ) ) {
				$wrapper_classes .= ' wd-stretch-cont-sm';
			}
		}

		$wrapper_classes .= ' align-items-start';

		?>
		<?php if ( ! $is_ajax ) : ?>
			<div class="wd-products-element<?php echo esc_attr( $products_element_classes ); ?>">

			<?php if ( 'arrows' === $settings['pagination'] ) : ?>
				<?php woodmart_enqueue_js_script( 'products-load-more' ); ?>
				<?php woodmart_enqueue_inline_style( 'product-arrows' ); ?>
				<div class="wd-products-loader"><span class="wd-loader"></span></div>
			<?php endif; ?>

			<?php if ( $settings['shop_tools'] ) : ?>
				<div class="shop-loop-head">
					<div class="wd-shop-tools">
						<?php woodmart_products_per_page_select( true ); ?>
						<?php woodmart_products_view_select( true ); ?>
						<?php woocommerce_catalog_ordering(); ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="products elements-grid row wd-products-holder<?php echo esc_attr( $wrapper_classes ); ?>" data-paged="1" data-atts="<?php echo esc_attr( $encoded_settings ); ?>" data-source="shortcode" data-columns="<?php echo isset( $settings['columns']['size'] ) ? esc_attr( $settings['columns']['size'] ) : ''; ?>">
		<?php endif; ?>

		<?php if ( ( ! $is_ajax || 'arrows' === $settings['pagination'] ) && $settings['element_title'] ) : ?>
			<h4 class="title element-title col-12">
				<?php echo esc_html( $settings['element_title'] ); ?>
			</h4>
		<?php endif; ?>

		<?php while ( $products->have_posts() ) : ?>
			<?php $products->the_post(); ?>
			<?php wc_get_template_part( 'content', 'product' ); ?>
		<?php endwhile; ?>

		<?php if ( ! $is_ajax ) : ?>
		</div>
	<?php endif; ?>

		<?php woodmart_set_loop_prop( 'shop_pagination', $settings['pagination'] ); ?>

		<?php if ( $products->max_num_pages > 1 && ! $is_ajax && $settings['pagination'] ) : ?>
			<?php wp_enqueue_script( 'imagesloaded' ); ?>
			<?php woodmart_enqueue_js_script( 'products-load-more' ); ?>
			<?php if ( 'infinit' === $settings['pagination'] ) : ?>
				<?php woodmart_enqueue_js_library( 'waypoints' ); ?>
			<?php endif; ?>
			<div class="wd-loop-footer products-footer">
				<?php if ( 'more-btn' === $settings['pagination'] || 'infinit' === $settings['pagination'] ) : ?>
					<?php woodmart_enqueue_inline_style( 'load-more-button' ); ?>
					<a href="#" rel="nofollow noopener" class="btn wd-load-more wd-products-load-more load-on-<?php echo 'more-btn' === $settings['pagination'] ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e( 'Load more products', 'woodmart' ); ?></span></a>
					<div class="btn wd-load-more wd-load-more-loader"><span class="load-more-loading"><?php esc_html_e( 'Loading...', 'woodmart' ); ?></span></div>
				<?php elseif ( 'arrows' === $settings['pagination'] ) : ?>
					<?php woodmart_enqueue_inline_style( 'product-arrows' ); ?>
					<div class="wrap-loading-arrow">
						<div class="wd-products-load-prev wd-btn-arrow disabled"></div>
						<div class="wd-products-load-next wd-btn-arrow"></div>
					</div>
				<?php elseif ( 'links' === $settings['pagination'] ) : ?>
					<?php woocommerce_pagination(); ?>
				<?php endif ?>
			</div>
		<?php endif; ?>

		<?php if ( ! $is_ajax ) : ?>
			</div>
		<?php endif; ?>

		<?php

		wc_reset_loop();
		wp_reset_postdata();
		woodmart_reset_loop();

		// Lazy loading.
		if ( 'yes' === $settings['lazy_loading'] ) {
			woodmart_lazy_loading_deinit();
		}

		if ( $is_ajax ) {
			return array(
				'items'  => ob_get_clean(),
				'status' => $products->max_num_pages > $paged ? 'have-posts' : 'no-more-posts',
			);
		}
	}
}
