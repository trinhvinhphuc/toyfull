<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Portfolio shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_portfolio' ) ) {
	function woodmart_shortcode_portfolio( $atts ) {
		if ( ! woodmart_get_opt( 'portfolio', '1' ) ) {
			return;
		}
		
		$output = $el_class = '';
		$parsed_atts = shortcode_atts( array(
			'posts_per_page' => woodmart_get_opt( 'portoflio_per_page' ),
			'filters' => false,
			'filters_type' => 'masonry',
			'categories' => '',
			'style' => woodmart_get_opt( 'portoflio_style' ),
			'columns' => 3,
			'columns_tablet' => 'auto',
			'columns_mobile' => 'auto',
			'spacing' => woodmart_get_opt( 'portfolio_spacing' ),
			'pagination' => woodmart_get_opt( 'portfolio_pagination' ),
			'ajax_page' => '',
			'orderby' => woodmart_get_opt( 'portoflio_orderby' ),
			'order' => woodmart_get_opt( 'portoflio_order' ),
			'layout' => 'grid',
			'speed' => '5000',
			'slides_per_view' => '3',
			'slides_per_view_tablet' => '',
			'slides_per_view_mobile' => '',
			'wrap' => '',
			'autoplay' => 'no',
			'hide_pagination_control' => '',
			'hide_prev_next_buttons' => '',
			'lazy_loading' => 'no',
			'scroll_carousel_init' => 'no',
			'scroll_per_page' => 'yes',
			'el_class' => '',
			'image_size' => 'large'
		), $atts );

		extract( $parsed_atts );

		$encoded_atts = json_encode( $parsed_atts );

		$is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX);
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if( $ajax_page > 1 ) $paged = $ajax_page;

		$s = false;

		if( isset( $_REQUEST['s'] ) ) {
			$s = sanitize_text_field( $_REQUEST['s'] );
		}

		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $posts_per_page,
			'orderby' => $orderby,
			'order' => $order,
			'paged' => $paged
		);

		if( $s ) {
			$args['s'] = $s;
		}
 
		if( get_query_var('project-cat') != '' ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'project-cat',
					'field'    => 'slug',
					'terms'    => get_query_var('project-cat')
				),
			);
		}

		if( $categories != '' ) {

			$args['tax_query'] = array(
				array(
					'taxonomy' => 'project-cat',
					'field'    => 'term_id',
					'operator' => 'IN',
					'terms'    => $categories
				),
			);
		}

		ob_start();

		if ( empty( $style ) || $style == 'inherit' ) $style = woodmart_get_opt( 'portoflio_style' );

		woodmart_set_loop_prop( 'portfolio_style', $style );
		woodmart_set_loop_prop( 'portfolio_column', $columns );
		woodmart_set_loop_prop( 'portfolio_image_size', $image_size );

		if ( 'auto' !== $columns_tablet ) {
			woodmart_set_loop_prop( 'portfolio_columns_tablet', $columns_tablet );
		}
		if ( 'auto' !== $columns_mobile ) {
			woodmart_set_loop_prop( 'portfolio_columns_mobile', $columns_mobile );
		}

		if ( $style == 'parallax' ) {
			woodmart_enqueue_js_library( 'panr-parallax-bundle' );
			woodmart_enqueue_js_script( 'portfolio-effect' );
		}

		woodmart_enqueue_portfolio_loop_styles( $style );

		$query = new WP_Query( $args );

		$parsed_atts['custom_sizes'] = apply_filters( 'woodmart_portfolio_shortcode_custom_sizes', false );

		wp_enqueue_script( 'imagesloaded' );
		woodmart_enqueue_js_library( 'isotope-bundle' );
		woodmart_enqueue_js_script( 'masonry-layout' );

		woodmart_enqueue_js_library( 'photoswipe-bundle' );
		woodmart_enqueue_inline_style( 'photoswipe' );
		woodmart_enqueue_js_script( 'portfolio-photoswipe' );

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		woodmart_enqueue_inline_style( 'portfolio-base' );

		if ( 'carousel' === $layout ) {
			$parsed_atts['portfolio_spacing'] = $spacing;
			$parsed_atts['carousel_classes']  = 'wd-wpb';

			if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
				$parsed_atts['custom_sizes'] = array(
					'desktop' => $slides_per_view,
					'tablet_landscape' => $slides_per_view_tablet,
					'tablet' => $slides_per_view_mobile,
					'mobile' => $slides_per_view_mobile,
				);
			}

			return woodmart_generate_posts_slider( $parsed_atts, $query );
		}

		?>
			<?php if ( $query->have_posts() ) : ?>
				<?php if ( ! $is_ajax ): ?>
					<?php if ( ! is_tax() && $filters && ! $s && $layout != 'carousel' ): ?>
						<?php woodmart_portfolio_filters( $categories, $filters_type ); ?>
					<?php endif ?>

					<div class="<?php echo 'carousel' !== $layout ? 'masonry-container' : ''; ?> wd-portfolio-holder row wd-spacing-<?php echo esc_attr( $spacing ); ?>" data-atts="<?php echo esc_attr( $encoded_atts ); ?>" data-source="shortcode" data-paged="1">
				<?php endif ?>
					<?php

						while ( $query->have_posts() ) {
							$query->the_post();
							get_template_part( 'content', 'portfolio' );
						}
					?>

				<?php if ( ! $is_ajax ): ?>
					</div>
					<?php
						if ( $query->max_num_pages > 1 && !$is_ajax && $pagination != 'disable' && $layout != 'carousel' ) {
							?>
								<?php wp_enqueue_script( 'imagesloaded' ); ?>
								<?php woodmart_enqueue_js_script( 'portfolio-load-more' ); ?>
								<?php woodmart_enqueue_js_library( 'waypoints' ); ?>
						        <div class="wd-loop-footer portfolio-footer">
						            <?php if ( $pagination == 'infinit' || $pagination == 'load_more'): ?>
							            <?php woodmart_enqueue_inline_style( 'load-more-button' ); ?>
										<a href="#" rel="nofollow noopener" class="btn wd-load-more wd-portfolio-load-more load-on-<?php echo 'load_more' === $pagination ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e('Load more projects', 'woodmart'); ?></span></a>
										<div class="btn wd-load-more wd-load-more-loader"><span class="load-more-loading"><?php esc_html_e('Loading...', 'woodmart'); ?></span></div>
					                <?php else: ?>
						                <?php query_pagination( $query->max_num_pages ); ?>
						            <?php endif ?>
						        </div>
						    <?php
						}
					?>

				<?php endif ?>

			<?php elseif ( ! $is_ajax ) : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		<?php

		$output .= ob_get_clean();

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_deinit();
		}

		wp_reset_postdata();
		
		woodmart_reset_loop();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $query->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts',
	    	);
	    }

		return $output;
	}
}
