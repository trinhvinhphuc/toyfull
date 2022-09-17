<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Shortcode function to display posts as a slider or as a grid
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_generate_posts_slider' ) ) {
	function woodmart_generate_posts_slider( $atts, $query = false, $products = false ) {
		$posts_query     = $el_class = $args = $my_query = $speed = '';
		$slides_per_view = $wrap = $scroll_per_page = $title_out = '';
		$autoplay        = $hide_pagination_control = $hide_prev_next_buttons = $output = $owl_atts = '';
		$posts           = array();

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_owl_atts(),
				array(
					'el_class'               => '',
					'posts_query'            => '',
					'highlighted_products'   => 0,
					'product_quantity'       => 0,
					'products_bordered_grid' => 0,
					'products_bordered_grid_style' => 'outside',
					'blog_spacing'           => woodmart_get_opt( 'blog_spacing' ),
					'product_hover'          => woodmart_get_opt( 'products_hover' ),
					'spacing'                => woodmart_get_opt( 'products_spacing' ),
					'portfolio_spacing'      => woodmart_get_opt( 'portfolio_spacing' ),
					'blog_design'            => 'default',
					'blog_carousel_design'   => 'masonry',
					'img_size'               => 'large',
					'title'                  => '',
					'element_title'          => '',
					'scroll_carousel_init'   => 'no',
					'lazy_loading'           => 'no',
					'elementor'              => false,
					'title_alignment'        => 'left',
					'carousel_classes'       => '',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		if ( empty( $product_hover ) || $product_hover == 'inherit' ) {
			$product_hover = woodmart_get_opt( 'products_hover' );
		}

		woodmart_set_loop_prop( 'product_hover', $product_hover );
		woodmart_set_loop_prop( 'img_size', $img_size );

		if ( $blog_design == 'carousel' ) {
			woodmart_set_loop_prop( 'blog_layout', 'carousel' );
			woodmart_set_loop_prop( 'blog_design', $blog_carousel_design );
		}

		if ( ! $query && ! $products && function_exists( 'vc_build_loop_query' ) ) {
			list( $args, $query ) = vc_build_loop_query( $posts_query );
		}

		if ( ! $elementor ) {
			ob_start();
		}

		$carousel_id       = 'carousel-' . rand( 100, 999 );
		$carousel_classes .= $highlighted_products ? ' wd-highlighted-products' : '';
		$carousel_classes .= $highlighted_products ? woodmart_get_old_classes( ' woodmart-highlighted-products' ) : '';
		if ( $highlighted_products ) {
			woodmart_enqueue_inline_style( 'highlighted-product' );
		}
		if ( woodmart_loop_prop( 'product_quantity' ) ) {
			$carousel_classes .= ' wd-quantity-enabled';
		}

		$carousel_classes .= ( $element_title ) ? ' with-title' : '';

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		if ( isset( $query->query['post_type'] ) ) {
			$post_type = $query->query['post_type'];
		} elseif ( $products ) {
			$post_type = 'product';
		} else {
			$post_type = 'post';
		}

		if ( is_array( $post_type ) ) {
			$post_type = $post_type[0];
		}

		$classes           = woodmart_owl_items_per_slide( $slides_per_view, array(), $post_type, false, $custom_sizes );

		$carousel_classes .= ' slider-type-' . $post_type;

		if ( $post_type == 'post' ) {
			$carousel_classes .= ' wd-carousel-spacing-' . $blog_spacing;
		}

		if ( $post_type == 'product' ) {
			$carousel_classes .= ' products wd-carousel-spacing-' . $spacing;
		}

		if ( $post_type == 'portfolio' ) {
			$carousel_classes .= ' wd-portfolio-holder wd-carousel-spacing-' . $portfolio_spacing;
		}

		if ( $scroll_carousel_init == 'yes' ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$carousel_classes .= ' scroll-init';
		}

		if ( $products_bordered_grid && ! $highlighted_products ) {
			woodmart_enqueue_inline_style( 'bordered-product' );

			if ( 'outside' === $products_bordered_grid_style ) {
				$carousel_classes .= ' products-bordered-grid';
			} elseif ( 'inside' === $products_bordered_grid_style ) {
				$carousel_classes .= ' products-bordered-grid-ins';
			}
		}

		if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
			$carousel_classes .= ' disable-owl-mobile';
		}
		
		if ( $product_quantity ) {
			$carousel_classes .= ' wd-quantity-enabled';
		}

		if ( 'none' !== woodmart_get_opt( 'product_title_lines_limit' ) ) {
			woodmart_enqueue_inline_style( 'woo-opt-title-limit' );
			$carousel_classes .= ' title-line-' . woodmart_get_opt( 'product_title_lines_limit' );
		}

		if ( $el_class ) {
			$classes .= ' ' . $el_class;
		}

		if ( ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) && in_array( $product_hover,
				array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base' ) ) ) {
			woodmart_enqueue_inline_style( 'woo-opt-stretch-cont' );
			if ( woodmart_loop_prop( 'stretch_product_desktop' ) ) {
				$carousel_classes .= ' wd-stretch-cont-lg';
			}
			if ( woodmart_loop_prop( 'stretch_product_tablet' ) ) {
				$carousel_classes .= ' wd-stretch-cont-md';
			}
			if ( woodmart_loop_prop( 'stretch_product_mobile' ) ) {
				$carousel_classes .= ' wd-stretch-cont-sm';
			}
		}

		$parsed_atts['carousel_id'] = $carousel_id;
		$parsed_atts['post_type']   = $post_type;

		$owl_atts = woodmart_get_owl_attributes( $parsed_atts );

		woodmart_enqueue_inline_style( 'owl-carousel' );

		if ( ( $query && $query->have_posts() ) || $products ) {
			?>
			<?php if ( $title ) : ?>
				<?php $title_classes = ' text-' . $title_alignment; ?>

				<h3 class="title slider-title<?php echo esc_attr( $title_classes ); ?>"><span><?php echo esc_html( $title ); ?></span></h3>
			<?php endif; ?>
			<div id="<?php echo esc_attr( $carousel_id ); ?>"
				 class="wd-carousel-container <?php echo esc_attr( $carousel_classes ); ?>" <?php echo ! empty( $owl_atts ) ? $owl_atts : ''; ?>>
				<?php
				if ( $element_title ) {
					echo '<h4 class="title element-title">' . esc_html( $element_title ) . '</h4>';
				}
				?>
				<div class="owl-carousel <?php echo esc_attr( $classes ); ?>">
					
					<?php
					if ( $products ) {
						foreach ( $products as $product ) {
							woodmart_carousel_query_item( false, $product );
						}
					} else {
						while ( $query->have_posts() ) {
							woodmart_carousel_query_item( $query );
						}
					}

					?>
				
				</div> <!-- end product-items -->
			</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->
			
			<?php

		}
		wp_reset_postdata();

		woodmart_reset_loop();

		if ( function_exists( 'wc_reset_loop' ) ) {
			wc_reset_loop();
		}

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_deinit();
		}

		if ( ! $elementor ) {
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}
	}
}

if ( ! function_exists( 'woodmart_carousel_query_item' ) ) {
	function woodmart_carousel_query_item( $query = false, $product = false ) {
		global $post;
		if ( $query ) {
			$query->the_post(); // Get post from query
		} elseif ( $product ) {
			$post_object = get_post( $product->get_id() );
			$post        = $post_object;
			setup_postdata( $post );
		}
		?>
		<div class="slide-<?php echo get_post_type(); ?> owl-carousel-item">
			
			<?php if ( get_post_type() == 'product' || get_post_type() == 'product_variation' && woodmart_woocommerce_installed() ) : ?>
				<?php woodmart_set_loop_prop( 'is_slider', true ); ?>
				<?php wc_get_template_part( 'content-product' ); ?>
			<?php elseif ( get_post_type() == 'portfolio' ) : ?>
				<?php get_template_part( 'content', 'portfolio-slider' ); ?>
			<?php else : ?>
				<?php
				$blog_design = woodmart_loop_prop( 'blog_design' );
				$blog_template = woodmart_is_blog_design_new( $blog_design ) ? $blog_design : 'slider';
				?>
				<?php get_template_part( 'content', $blog_template ); ?>
			<?php endif ?>
		
		</div>
		<?php
	}
}
