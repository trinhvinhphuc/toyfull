<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
 * ------------------------------------------------------------------------------------------------
 * Categories grid shortcode
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_shortcode_categories' ) ) {
	function woodmart_shortcode_categories( $atts, $content ) {
		$extra_class = $carousel_classes = '';

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_owl_atts(),
				array(
					// Query.
					'data_source'               => 'custom_query',
					'number'                    => null,
					'orderby'                   => '',
					'order'                     => 'ASC',
					'ids'                       => '',

					'type'                      => 'grid',
					'images'                    => 'yes',
					'product_count'             => 'yes',
					'mobile_accordion'          => 'yes',
					'shop_categories_ancestors' => 'no',
					'show_categories_neighbors' => 'no',

					// Layout.
					'columns'                   => '4',
					'hide_empty'                => 'yes',
					'parent'                    => '',
					'style'                     => 'default',
					'title'                     => esc_html__( 'Categories', 'woodmart' ),

					// Design.
					'categories_design'         => woodmart_get_opt( 'categories_design' ),
					'color_scheme'              => woodmart_get_opt( 'categories_color_scheme' ),
					'categories_with_shadow'    => woodmart_get_opt( 'categories_with_shadow' ),
					'nav_alignment'             => 'left',
					'nav_color_scheme'          => '',
					'img_size'                  => '',

					// Extra.
					'spacing'                   => 30,
					'lazy_loading'              => 'no',
					'scroll_carousel_init'      => 'no',
					'el_class'                  => '',
					'css'                       => '',
					'woodmart_css_id'           => '',

					// Width option.
					'width_desktop'             => '',
					'width_tablet'              => '',
					'width_mobile'              => '',
					'slides_per_view' => '3',
					'slides_per_view_tablet' => 'auto',
					'slides_per_view_mobile' => 'auto',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		$extra_class            = '';
		$carousel_classes       = '';
		$extra_wrapper_classes  = 'wd-wpb';
		$extra_wrapper_classes .= apply_filters( 'vc_shortcodes_css_class', '', '', $parsed_atts );

		if ( $parsed_atts['css'] ) {
			$extra_wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $parsed_atts['css'] );
		}

		if ( ! empty( $img_size ) ) {
			woodmart_set_loop_prop( 'product_categories_image_size', $img_size );
		}

		if ( 'default' === $categories_design || 'alt' === $categories_design || 'center' === $categories_design || 'replace-title' === $categories_design ) {
			woodmart_set_loop_prop( 'old_structure', true );
		}

		if ( isset( $ids ) ) {
			$ids = explode( ',', $ids );
			$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == 'yes' || $hide_empty == 1 ) ? 1 : 0;

		// get terms and workaround WP bug with parents/pad counts.
		$args = array(
			'taxonomy'   => 'product_cat',
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent,
		);

		if ( $orderby ) $args['orderby'] = $orderby;

		if ( 'navigation' === $type ) {
			$wrapper_classes  = ' text-' . woodmart_vc_get_control_data( $nav_alignment, 'desktop' );
			$wrapper_classes .= ' wd-nav-product-cat-wrap';

			if ( 'yes' === $mobile_accordion ) {
				woodmart_enqueue_inline_style( 'woo-categories-loop-nav-mobile-accordion' );
				$wrapper_classes .= ' wd-nav-accordion-mb-on';
			}

			if ( $nav_color_scheme ) {
				$wrapper_classes .= ' color-scheme-' . $nav_color_scheme;
			}

			ob_start();
			?>
			<div class="<?php echo esc_attr( $extra_wrapper_classes ); ?>">
				<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
					<?php woodmart_product_categories_nav( $args, $parsed_atts ); ?>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}

		if ( 'wc_query' === $data_source ) {
			$product_categories = woocommerce_get_product_subcategories( is_product_category() ? get_queried_object_id() : 0 );
		} else {
			$product_categories = get_terms( 'product_cat', $args );
		}

		if ( '' !== $parent ) {
			$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		}

		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( $category->count == 0 ) {
					unset( $product_categories[ $key ] );
				}
			}
		}

		if ( $number ) {
			$product_categories = array_slice( $product_categories, 0, $number );
		}

		if ( woodmart_is_compressed_data( $columns ) ) {
			$columns_desktop = woodmart_vc_get_control_data( $columns, 'desktop' );
			$columns_tablet  = woodmart_vc_get_control_data( $columns, 'tablet' );
			$columns_mobile  = woodmart_vc_get_control_data( $columns, 'mobile' );
		} else {
			$columns_desktop = absint( $columns );
		}

		if ( 'masonry' === $style ) {
			$extra_class .= ' categories-masonry';
			wp_enqueue_script( 'imagesloaded' );
			woodmart_enqueue_js_library( 'isotope-bundle' );
			woodmart_enqueue_js_script( 'shop-masonry' );
		}

		woodmart_set_loop_prop( 'product_categories_color_scheme', $color_scheme );
		woodmart_set_loop_prop( 'product_categories_is_element', true );

		woodmart_set_loop_prop( 'products_different_sizes', false );

		if ( 'masonry-first' === $style ) {
			woodmart_set_loop_prop( 'products_different_sizes', array( 1 ) );
			$extra_class    .= ' categories-masonry';
			$columns_desktop = 4;
			wp_enqueue_script( 'imagesloaded' );
			woodmart_enqueue_js_library( 'isotope-bundle' );
			woodmart_enqueue_js_script( 'shop-masonry' );
		}

		if ( 'carousel' === $style ) {
			$extra_class .= ' wd-carousel-spacing-' . $spacing;
		} else {
			$extra_class .= ' wd-spacing-' . $spacing;
		}

		$extra_class .= $el_class ? ' ' . $el_class : '';

		if ( empty( $categories_design ) || $categories_design == 'inherit' ) $categories_design = woodmart_get_opt( 'categories_design' );

		woodmart_set_loop_prop( 'product_categories_design', $categories_design );
		woodmart_set_loop_prop( 'product_categories_shadow', $categories_with_shadow );
		woodmart_set_loop_prop( 'product_categories_style', $style );

		if ( isset( $columns_desktop ) ) {
			woodmart_set_loop_prop( 'products_columns', $columns_desktop );
		}

		if ( isset( $columns_tablet ) ) {
			woodmart_set_loop_prop( 'products_columns_tablet', $columns_tablet );
		}

		if ( isset( $columns_mobile ) ) {
			woodmart_set_loop_prop( 'products_columns_mobile', $columns_mobile );
		}

		$carousel_id = 'carousel-' . rand( 100, 999 );

		ob_start();

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		if ( 'alt' !== $categories_design && 'inherit' !== $categories_design ) {
			woodmart_enqueue_inline_style( 'categories-loop-' . $categories_design );
		}

		if ( 'center' === $categories_design ) {
			woodmart_enqueue_inline_style( 'categories-loop-center' );
		}

		if ( 'replace-title' === $categories_design ) {
			woodmart_enqueue_inline_style( 'categories-loop-replace-title' );
		}

		if ( 'mask-subcat' === $categories_design ) {
			woodmart_enqueue_inline_style( 'woo-categories-loop-mask-subcat' );
		}

		if ( 'masonry' === $style || 'masonry-first' === $style || 'carousel' === $style ) {
			woodmart_enqueue_inline_style( 'woo-categories-loop-layout-masonry' );
		}

		if ( woodmart_loop_prop( 'old_structure' ) ) {
			woodmart_enqueue_inline_style( 'categories-loop' );
		} else {
			woodmart_enqueue_inline_style( 'woo-categories-loop' );
		}

		if ( $product_categories ) {
			if ( 'alt' !== $categories_design && 'inherit' !== $categories_design ) {
				woodmart_enqueue_inline_style( 'categories-loop-' . $categories_design );
			}

			if ( $style == 'carousel' ) {
				woodmart_enqueue_inline_style( 'owl-carousel' );
				$custom_sizes = apply_filters( 'woodmart_categories_shortcode_custom_sizes', false );
				
				$parsed_atts['carousel_id'] = $carousel_id;
				$parsed_atts['post_type'] = 'product';
				$parsed_atts['custom_sizes'] = $custom_sizes;
				
				if ( $scroll_carousel_init == 'yes' ) {
					woodmart_enqueue_js_library( 'waypoints' );
					$carousel_classes .= ' scroll-init';
				}
				
				if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
					$carousel_classes .= ' disable-owl-mobile';
				}

				if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
					$parsed_atts['custom_sizes'] = array(
						'desktop' => $slides_per_view,
						'tablet_landscape' => $slides_per_view_tablet,
						'tablet' => $slides_per_view_mobile,
						'mobile' => $slides_per_view_mobile,
					);
				}
				
				$carousel_classes .= ' categories-style-' . $style;

				?>
				<div class="<?php echo esc_attr( $extra_wrapper_classes ); ?>">
					<div id="<?php echo esc_attr( $carousel_id ); ?>" class="products woocommerce wd-carousel-container <?php echo esc_attr( $carousel_classes ); ?> <?php echo esc_attr( $extra_class ); ?>" <?php echo woodmart_get_owl_attributes( $parsed_atts ); ?>>
						<div class="owl-carousel carousel-items <?php echo woodmart_owl_items_per_slide( $slides_per_view, array(), 'product', false, $parsed_atts['custom_sizes'] ); ?>">
							<?php foreach ( $product_categories as $category ): ?>
								<?php
								wc_get_template( 'content-product-cat.php', array(
									'category' => $category
								) );
								?>
							<?php endforeach; ?>
						</div>
					</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->
				</div>
				<?php
			} else {
				
				foreach ( $product_categories as $category ) {
					wc_get_template( 'content-product-cat.php', array(
						'category' => $category
					) );
				}
			}
			
		}
		
		woodmart_reset_loop();
		
		if ( function_exists( 'woocommerce_reset_loop' ) ) woocommerce_reset_loop();
		
		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_deinit();
		}

		if( $style == 'carousel' ) {
			return ob_get_clean();
		} else {
			return '<div class=" ' . esc_attr( $extra_wrapper_classes ) . ' "><div class="products woocommerce row categories-style-'. esc_attr( $style ) . ' ' . esc_attr( $extra_class ) . ' columns-' . $columns_desktop . '">' . ob_get_clean() . '</div></div>';
		}
	}
}