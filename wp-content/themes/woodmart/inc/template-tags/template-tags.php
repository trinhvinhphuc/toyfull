<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

use XTS\Modules\Layouts\Main as Builder;
use XTS\Modules\Layouts\Global_Data as Builder_Data;

if ( ! function_exists( 'woodmart_sticky_loader' ) ) {
	/**
	 * Sticky loader.
	 */
	function woodmart_sticky_loader() {
		woodmart_enqueue_js_script( 'shop-loader' );
		woodmart_enqueue_inline_style( 'sticky-loader' );

		?>
		<div class="wd-sticky-loader"><span class="wd-loader"></span></div>
		<?php
	}

	add_action( 'wp_head', 'woodmart_meta_viewport' );
}

if ( ! function_exists( 'woodmart_meta_viewport' ) ) {
	/**
	 * Meta viewport tag.
	 */
	function woodmart_meta_viewport() {
		?>
		<?php if ( 'not_scalable' === woodmart_get_opt( 'site_viewport', 'not_scalable' ) ) : ?>
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<?php else : ?>
			<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php endif; ?>
		<?php
	}

	add_action( 'wp_head', 'woodmart_meta_viewport' );
}

if ( ! function_exists( 'woodmart_preloader_template' ) ) {
	function woodmart_preloader_template() {
		if ( ! woodmart_get_opt( 'preloader' ) ) {
			return;
		}

		$background_color = woodmart_get_opt( 'preloader_background_color' );
		$image            = woodmart_get_opt( 'preloader_image' );
		$color_scheme     = woodmart_get_opt( 'preloader_color_scheme', 'dark' );
		$classes          = ' color-scheme-' . $color_scheme;
		?>
			<style class="wd-preloader-style">
				html {
					overflow: hidden;
				}
			</style>
			<div class="wd-preloader<?php echo esc_attr( $classes ); ?>">
				<style>
					<?php if ( isset( $background_color['idle'] ) && $background_color['idle'] ) : ?>
						.wd-preloader {
							background-color: <?php echo esc_attr( $background_color['idle'] ); ?>
						}
					<?php endif; ?>

					<?php if ( ! isset( $image['id'] ) || ( isset( $image['id'] ) && ! $image['id'] ) ) : ?>

						@keyframes wd-preloader-Rotate {
							0%{
								transform:scale(1) rotate(0deg);
							}
							50%{
								transform:scale(0.8) rotate(360deg);
							}
							100%{
								transform:scale(1) rotate(720deg);
							}
						}

						.wd-preloader-img:before {
							content: "";
							display: block;
							width: 50px;
							height: 50px;
							border: 2px solid #BBB;
							border-top-color: #000;
							border-radius: 50%;
							animation: wd-preloader-Rotate 2s cubic-bezier(0.63, 0.09, 0.26, 0.96) infinite ;
						}

						.color-scheme-light .wd-preloader-img:before {
							border-color: rgba(255,255,255,0.2);
							border-top-color: #fff;
						}
					<?php endif; ?>

					@keyframes wd-preloader-fadeOut {
						from {
							visibility: visible;
						}
						to {
							visibility: hidden;
						}
					}

					.wd-preloader {
						position: fixed;
						top: 0;
						left: 0;
						right: 0;
						bottom: 0;
						opacity: 1;
						visibility: visible;
						z-index: 2500;
						display: flex;
						justify-content: center;
						align-items: center;
						animation: wd-preloader-fadeOut 20s ease both;
						transition: opacity .4s ease;
					}

					.wd-preloader.preloader-hide {
						pointer-events: none;
						opacity: 0 !important;
					}

					.wd-preloader-img {
						max-width: 300px;
						max-height: 300px;
					}
				</style>

				<div class="wd-preloader-img">
					<?php if ( isset( $image['id'] ) && $image['id'] ) : ?>
						<img src="<?php echo esc_url( wp_get_attachment_url( $image['id'] ) ); ?>" alt="preloader">
					<?php endif; ?>
				</div>
			</div>
		<?php
	}

	add_action( 'woodmart_after_body_open', 'woodmart_preloader_template', 500 );
}

if ( ! function_exists( 'woodmart_age_verify_popup' ) ) {
	function woodmart_age_verify_popup() {
		if ( ! woodmart_get_opt( 'age_verify' ) ) {
			return;
		}

		woodmart_enqueue_js_library( 'magnific' );
		woodmart_enqueue_js_script( 'age-verify' );
		woodmart_enqueue_inline_style( 'age-verify' );
		woodmart_enqueue_inline_style( 'mfp-popup' );

		$wrapper_classes = ' color-scheme-' . woodmart_get_opt( 'age_verify_color_scheme' );

		?>
			<div class="mfp-with-anim wd-popup wd-age-verify<?php echo esc_attr( $wrapper_classes ); ?>">
				<div class="wd-age-verify-text">
					<?php echo do_shortcode( woodmart_get_opt( 'age_verify_text' ) ); ?>
				</div>
				
				<div class="wd-age-verify-text-error">
					<?php echo do_shortcode( woodmart_get_opt( 'age_verify_text_error' ) ); ?>
				</div>
				
				<div class="wd-age-verify-buttons">
					<a href="#" rel="nofollow noopener" class="btn btn-color-primary wd-age-verify-allowed">
						<?php esc_html_e( 'I am 18 or Older', 'woodmart' ); ?>
					</a>
					
					<a href="#" rel="nofollow noopener" class="btn wd-age-verify-forbidden">
						<?php esc_html_e( 'I am Under 18', 'woodmart' ); ?>
					</a>
				</div>
			</div>
		<?php
	}

	add_action( 'woodmart_before_wp_footer', 'woodmart_age_verify_popup', 400 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Main loop
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_main_loop' ) ) {

	add_action( 'woodmart_main_loop', 'woodmart_main_loop' );

	function woodmart_main_loop() {
		global $paged, $wp_query;

		$max_page = $wp_query->max_num_pages;

		$pagination   = woodmart_get_opt( 'blog_pagination' );
		$blog_design  = woodmart_get_opt( 'blog_design' );
		$blog_spacing = woodmart_get_opt( 'blog_spacing' );

		$id = uniqid();

		// fix bug with wrong escaped url generated by next_posts() call
		if ( is_search() ) {
			$pagination = 'pagination';
		}

		$classes = 'blog-pagination-' . $pagination;
		if ( $blog_design == 'masonry' || $blog_design == 'mask' || 'meta-image' === $blog_design ) {
			if ( 'meta-image' !== $blog_design ) {
				$classes .= ' masonry-container';
				wp_enqueue_script( 'imagesloaded' );
				woodmart_enqueue_js_library( 'isotope-bundle' );
				woodmart_enqueue_js_script( 'masonry-layout' );
			}

			$classes .= ' wd-spacing-' . $blog_spacing;
			$classes .= ' row';
		}

		$is_ajax = woodmart_is_woo_ajax();

		if ( ! $paged ) {
			$paged = 1;
		}

		if ( ! $is_ajax ) {
			if ( woodmart_is_blog_design_new( $blog_design ) ) {
				woodmart_enqueue_inline_style( 'blog-loop-base' );
			} else {
				woodmart_enqueue_inline_style( 'blog-loop-base-old' );
			}
			if ( 'small-images' === $blog_design || 'chess' === $blog_design ) {
				woodmart_enqueue_inline_style( 'blog-loop-design-small-img-chess' );
			} else {
				woodmart_enqueue_inline_style( 'blog-loop-design-' . $blog_design );
			}
		}

		?>

			<?php if ( have_posts() ) : ?>

				<?php if ( ! $is_ajax ) : ?>

					<?php if ( is_tag() && tag_description() ) : // Show an optional tag description ?>
						<div class="archive-meta"><?php echo tag_description(); ?></div>
					<?php endif; ?>

					<?php if ( is_category() && category_description() ) : // Show an optional category description ?>
						<div class="archive-meta"><?php echo category_description(); ?></div>
					<?php endif; ?>

					<?php if ( is_author() && get_the_author_meta( 'description' ) ) : ?>
						<?php get_template_part( 'author-bio' ); ?>
					<?php endif ?>

				<?php endif ?>

				<?php if ( ! $is_ajax ) : ?>
					<div class="wd-blog-holder <?php echo esc_attr( $classes ); ?>" id="<?php echo esc_attr( $id ); ?>" data-paged="1" data-source="main_loop">
				<?php endif ?>

					<?php
					if ( $is_ajax ) {
						ob_start();
					}
					$name = woodmart_is_blog_design_new( $blog_design ) ? $blog_design : '';
					?>

					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<?php get_template_part( 'content', $name ); ?>
					<?php endwhile; ?>

					<?php
					if ( $is_ajax ) {
						$output = ob_get_clean();}
					?>

				<?php if ( ! $is_ajax ) : ?>
					</div>

					<?php if ( $max_page > 1 && $pagination ) : ?>
						<div class="wd-loop-footer blog-footer">
							<?php if ( $pagination == 'infinit' || $pagination == 'load_more' ) : ?>
								<?php if ( get_next_posts_link() ) : ?>
									<?php wp_enqueue_script( 'imagesloaded' ); ?>
									<?php woodmart_enqueue_js_script( 'blog-load-more' ); ?>
									<?php if ( 'infinit' === $pagination ) : ?>
										<?php woodmart_enqueue_js_library( 'waypoints' ); ?>
									<?php endif; ?>
									<?php woodmart_enqueue_inline_style( 'load-more-button' ); ?>
									<a href="<?php echo add_query_arg( 'woo_ajax', '1', next_posts( $max_page, false ) ); ?>" rel="nofollow noopener" data-holder-id="<?php echo esc_attr( $id ); ?>" class="btn wd-load-more wd-blog-load-more load-on-<?php echo 'load_more' === $pagination ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e( 'Load more posts', 'woodmart' ); ?></span></a>
									<div class="btn wd-load-more wd-load-more-loader"><span class="load-more-loading"><?php esc_html_e('Loading...', 'woodmart'); ?></span></div>
								<?php endif; ?>
							<?php else : ?>
								<?php woodmart_paging_nav(); ?>
							<?php endif ?>
						</div>
					<?php endif; ?>
				<?php endif ?>


			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		<?php

		if ( $is_ajax ) {
			$output = array(
				'items'    => $output,
				'status'   => ( $max_page > $paged ) ? 'have-posts' : 'no-more-posts',
				'nextPage' => add_query_arg( 'woo_ajax', '1', next_posts( $max_page, false ) ),
				'currentPage' => strtok( woodmart_get_current_url(), '?' ),
			);

			echo json_encode( $output );
		}
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Footer woodmart extra action
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_extra_footer_action' ) ) {
	function woodmart_extra_footer_action() {
		if ( woodmart_needs_footer() && ! woodmart_is_compare_iframe() ) {
			do_action( 'woodmart_after_footer' );
		}
	}

	add_action( 'wp_footer', 'woodmart_extra_footer_action', 500 );
}


/**
 * ------------------------------------------------------------------------------------------------
 * Read more button
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_modify_read_more_link' ) ) {
	function woodmart_modify_read_more_link() {
		return '</p><p class="read-more-section">' . woodmart_read_more_tag();
	}
}

add_filter( 'the_content_more_link', 'woodmart_modify_read_more_link' );



if ( ! function_exists( 'woodmart_read_more_tag' ) ) {
	function woodmart_read_more_tag() {
		return '<a class="btn-read-more more-link" href="' . get_permalink() . '">' . esc_html__( 'Continue reading', 'woodmart' ) . '</a>';
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get post image
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_get_post_thumbnail' ) ) {
	function woodmart_get_post_thumbnail( $size = 'medium', $attach_id = false ) {
		global $post;

		if ( has_post_thumbnail() ) {

			if ( woodmart_is_elementor_installed() ) {
				if ( ! $attach_id ) {
					$attach_id = get_post_thumbnail_id();
				}

				if ( woodmart_loop_prop( 'img_size' ) ) {
					$size = woodmart_loop_prop( 'img_size' );
				}

				$custom_sizes = woodmart_loop_prop( 'img_size_custom' );

				if ( is_array( $size ) ) {
					$custom_sizes['width']  = $size[0];
					$custom_sizes['height'] = $size[1];
					$size                   = 'custom';
				}

				$img = woodmart_get_image_html( // phpcs:ignore
					array(
						'image_size'             => $size,
						'image_custom_dimension' => $custom_sizes,
						'image'                  => array(
							'id' => $attach_id,
						),
					),
					'image'
				);
			} elseif ( function_exists( 'wpb_getImageBySize' ) ) {
				if ( ! $attach_id ) {
					$attach_id = get_post_thumbnail_id();
				}

				if ( woodmart_loop_prop( 'img_size' ) ) {
					$size = woodmart_loop_prop( 'img_size' );
				}

				$img = wpb_getImageBySize(
					array(
						'attach_id'  => $attach_id,
						'thumb_size' => $size,
						'class'      => 'attachment-large wp-post-image',
					)
				);
				$img = isset( $img['thumbnail'] ) ? $img['thumbnail'] : '';

			} else {
				$img = get_the_post_thumbnail( $post->ID, $size );
			}

			return $img;
		}
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get post content
 * ------------------------------------------------------------------------------------------------
 */


if ( ! function_exists( 'woodmart_get_content' ) ) {
	function woodmart_get_content( $btn = true, $force_full = false ) {
		global $post;

		$type = woodmart_get_opt( 'blog_excerpt' );

		if ( $force_full ) {
			$type = 'full';
		}

		if ( $type == 'full' ) {
			woodmart_get_full_content( $btn );
		} elseif ( $type == 'excerpt' ) {

			if ( ! empty( $post->post_excerpt ) ) {
				the_excerpt();
			} else {
				$excerpt_length = apply_filters( 'woodmart_get_excerpt_length', woodmart_get_opt( 'blog_excerpt_length' ) );
				echo woodmart_excerpt_from_content( $post->post_content, intval( $excerpt_length ) );
			}

			if ( $btn ) {
				echo '<p class="read-more-section">' . woodmart_read_more_tag() . '</p>';
			}
		}

	}
}

if ( ! function_exists( 'woodmart_get_full_content' ) ) {
	function woodmart_get_full_content( $btn = false ) {

		$strip_gallery = apply_filters( 'woodmart_strip_gallery', true );

		if ( get_post_format() == 'gallery' && $strip_gallery ) {

			if ( $btn ) {
				$content = woodmart_strip_shortcode_gallery( get_the_content() );
			} else {
				$content = woodmart_strip_shortcode_gallery( get_the_content( '' ) );
			}
			echo str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $content ) );
		} else {
			if ( $btn ) {
				the_content();
			} else {
				the_content( '' );
			}
		}
	}
}

if ( ! function_exists( 'woodmart_get_the_content' ) ) {
	function woodmart_get_the_content() {
		$id = get_the_ID();

		if ( get_post_meta( $id, '_woodmart_mobile_content', true ) && wp_is_mobile() ) {
			$content = woodmart_get_html_block( get_post_meta( $id, '_woodmart_mobile_content', true ) );
		} else {
			$content = get_the_content();

			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
		}

		return $content;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Display meta information for a specific post
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_post_modified_date' ) ) {
	function woodmart_post_modified_date() {
		?>
		<time class="updated" datetime="<?php echo get_the_modified_date( 'c' ); // phpcs:ignore ?>">
			<?php echo get_the_modified_date(); // phpcs:ignore ?>
		</time>
		<?php
	}
}

if ( ! function_exists( 'woodmart_post_meta_author' ) ) {
	function woodmart_post_meta_author( $avatar, $label = 'short' ) {
		?>
		<span>
			<?php if ( 'short' === $label ) : ?>
				<?php esc_html_e( 'By', 'woodmart' ); ?>
			<?php elseif ( 'long' === $label ) : ?>
				<?php esc_html_e( 'Posted by', 'woodmart' ); ?>
			<?php endif; ?>
		</span>

		<?php if ( $avatar ) : ?>
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', 'author-avatar' ); ?>
		<?php endif; ?>

		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<span class="vcard author author_name">
				<span class="fn"><?php echo get_the_author(); ?></span>
			</span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'woodmart_post_meta_reply' ) ) {
	function woodmart_post_meta_reply() {
		$comment_link_template = '<span class="replies-count">%s</span> <span class="replies-count-label">%s</span>';

		comments_popup_link(
			sprintf( $comment_link_template, '0', esc_html__( 'comments', 'woodmart' ) ),
			sprintf( $comment_link_template, '1', esc_html__( 'comment', 'woodmart' ) ),
			sprintf( $comment_link_template, '%', esc_html__( 'comments', 'woodmart' ) )
		);
	}
}

if ( ! function_exists( 'woodmart_post_meta' ) ) {
	function woodmart_post_meta( $atts = array() ) {
		extract(
			shortcode_atts(
				array(
					'author'        => 1,
					'author_avatar' => 0,
					'date'          => 1,
					'author_label'  => 'short',
					'comments'      => 1,
				),
				$atts
			)
		);
		?>
			<ul class="entry-meta-list">
				<?php if ( get_post_type() === 'post' ) : ?>
					<li class="modified-date">
						<?php woodmart_post_modified_date(); ?>
					</li>

					<?php if ( is_sticky() ) : ?>
						<li class="meta-featured-post">
							<?php esc_html_e( 'Featured', 'woodmart' ); ?>
						</li>
					<?php endif; ?>

					<?php if ( $author ) : ?>
						<li class="meta-author">
							<?php woodmart_post_meta_author( $author_avatar, $author_label ); ?>
						</li>
					<?php endif ?>

					<?php if ( $date ) : ?>
						<li class="meta-date">
							<?php echo esc_html( _x( 'On', 'meta-date', 'woodmart' ) ) . ' ' . get_the_date(); ?>
						</li>
					<?php endif ?>

					<?php if ( $comments && comments_open() ) : ?>
						<li class="meta-reply">
							<?php woodmart_post_meta_reply(); ?>
						</li>
					<?php endif; ?>
				<?php endif; ?>
			</ul>
		<?php
	}
}

if ( ! function_exists( 'woodmart_post_date' ) ) {
	function woodmart_post_date( $args ) {
		$has_title = get_the_title() != '';
		$attr      = '';
		if ( ! $has_title && ! is_single() ) {
			$url  = get_the_permalink();
			$attr = 'window.location=\'' . $url . '\';';
		}
		$classes  = '';
		$classes .= ' ' . $args['style'];
		$classes .= woodmart_get_old_classes( ' woodmart-post-date' );
		?>
			<div class="post-date wd-post-date<?php echo esc_attr( $classes ); ?>" onclick="<?php echo esc_attr( $attr ); ?>">
				<span class="post-date-day">
					<?php echo get_the_time( 'd' ); ?>
				</span>
				<span class="post-date-month">
					<?php echo get_the_time( 'M' ); ?>
				</span>
			</div>
		<?php
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Display posts next/prev navigation
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_posts_navigation' ) ) {
	function woodmart_posts_navigation() {
		woodmart_enqueue_inline_style( 'page-navigation' );
		?>
		<div class="wd-page-nav<?php echo woodmart_get_old_classes( ' single-post-navigation' ); ?>">
				 <?php
						$next_post = get_next_post();
						$prev_post = get_previous_post();

						$archive_url = false;

					if ( get_post_type() == 'post' ) {
						$archive_page = get_option( 'page_for_posts' );
						$archive_url  = get_permalink( $archive_page );
					} elseif ( get_post_type() == 'portfolio' ) {
						$archive_page = woodmart_get_portfolio_page_id();
						$archive_url  = get_permalink( $archive_page );
					}
					?>
					<div class="wd-page-nav-btn prev-btn<?php echo woodmart_get_old_classes( ' blog-posts-nav-btn' ); ?>">
						<?php if ( ! empty( $next_post ) ) : ?>
							<a href="<?php echo get_permalink( $next_post->ID ); ?>">
								<span class="btn-label"><?php esc_html_e( 'Newer', 'woodmart' ); ?></span>
								<span class="wd-entities-title"><?php echo get_the_title( $next_post->ID ); ?></span>
							</a>
						<?php endif; ?>
					</div>

					<?php if ( $archive_url && 'page' == get_option( 'show_on_front' ) ) : ?>
						<?php woodmart_enqueue_js_script( 'btns-tooltips' ); ?>
						<?php woodmart_enqueue_js_library( 'tooltips' ); ?>
						<a href="<?php echo esc_url( $archive_url ); ?>" class="back-to-archive wd-tooltip"><?php esc_html_e( 'Back to list', 'woodmart' ); ?></a>
					<?php endif ?>

					<div class="wd-page-nav-btn next-btn<?php echo woodmart_get_old_classes( ' blog-posts-nav-btn' ); ?>">
						<?php if ( ! empty( $prev_post ) ) : ?>
							<a href="<?php echo get_permalink( $prev_post->ID ); ?>">
								<span class="btn-label"><?php esc_html_e( 'Older', 'woodmart' ); ?></span>
								<span class="wd-entities-title"><?php echo get_the_title( $prev_post->ID ); ?></span>
							</a>
						<?php endif; ?>
					</div>
			</div>
		<?php
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Display entry meta
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_entry_meta' ) ) {
	function woodmart_entry_meta() {
		if ( apply_filters( 'woodmart_entry_meta', false ) ) {
			?>
				<footer class="entry-meta">
					<?php if ( is_user_logged_in() ) : ?>
						<p><?php edit_post_link( esc_html__( 'Edit', 'woodmart' ), '<span class="edit-link">', '</span>' ); ?></p>
					<?php endif; ?>
				</footer><!-- .entry-meta -->
			<?php
		}
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Display navigation to the next/previous set of posts.
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_paging_nav' ) ) {
	function woodmart_paging_nav() {
		$enable_pagination = apply_filters( 'woodmart_enable_pagination', true );

		if ( $enable_pagination ) {
			query_pagination();
			return;
		}
		?>

			<ul>
				<?php if ( get_previous_posts_link() ) : ?>
					<li class="next">
						<?php previous_posts_link( esc_html__( 'Newer Posts &rarr;', 'woodmart' ) ); ?>
					</li>
				<?php endif; ?>

				<?php if ( get_next_posts_link() ) : ?>
					<li class="previous">
						<?php next_posts_link( esc_html__( '&larr; Older Posts', 'woodmart' ) ); ?>
					</li>
				<?php endif; ?>
			</ul>

		<?php
	}
}

if ( ! function_exists( 'query_pagination' ) ) {
	function query_pagination( $pages = '', $range = 2 ) {
		$show_items = ( $range * 2 ) + 1;

		global $paged;

		$page = $paged;

		if ( empty( $page ) ) {
			$page = 1;
		}

		if ( '' === $pages ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 !== $pages ) {
			echo '<nav class="wd-pagination' . woodmart_get_old_classes( ' woodmart-pagination' ) . '">';
			echo '<ul>';

			if ( $page > 2 && $page > $range + 1 && $show_items < $pages ) {
				echo '<li><a href="' . esc_url( get_pagenum_link() ) . '" class="page-numbers">&laquo;</a></li>';
			}

			if ( $page > 1 && $show_items < $pages ) {
				echo '<li><a href="' . esc_url( get_pagenum_link( $page - 1 ) ) . '" class="page-numbers">&lsaquo;</a></li>';
			}

			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( 1 !== $pages && ( ! ( $i >= $page + $range + 1 || $i <= $page - $range - 1 ) || $pages <= $show_items ) ) {
					echo ( $page === $i ) ? '<li><span class="current page-numbers">' . esc_html( $i ) . '</span></li>' : '<li><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-numbers" >' . esc_html( $i ) . '</a></li>';
				}
			}

			if ( $page < $pages && $show_items < $pages ) {
				echo '<li><a href="' . esc_url( get_pagenum_link( $page + 1 ) ) . '" class="page-numbers">&rsaquo;</a></li>';
			}

			if ( $page < $pages - 1 && $page + $range - 1 < $pages && $show_items < $pages ) {
				echo '<li><a href="' . esc_url( get_pagenum_link( $pages ) ) . '" class="page-numbers">&raquo;</a></li>';
			}

			echo '</ul>';
			echo '</nav>';
		}
	}
}

// **********************************************************************//
// ! Page top part
// **********************************************************************//

if ( ! function_exists( 'woodmart_page_top_part' ) ) {
	function woodmart_page_top_part() {
		?>
		<?php if ( ! woodmart_is_woo_ajax() ) : ?>
			<div class="main-page-wrapper">
		<?php elseif ( woodmart_is_pjax() ) : ?>
			<title><?php echo esc_html( woodmart_get_document_title() ); ?></title>
		<?php endif ?>

		<?php

			/**
			 * woodmart_after_header hook
			 *
			 * @hooked woodmart_show_page_title - 10
			 */
			do_action( 'woodmart_after_header' );
		?>

		<!-- MAIN CONTENT AREA -->
		<?php $main_container_class = woodmart_get_main_container_class(); ?>
		<div class="<?php echo esc_attr( $main_container_class ); ?>">
			<div class="row content-layout-wrapper align-items-start">
		<?php
	}
}

// **********************************************************************//
// ! Page bottom part
// **********************************************************************//

if ( ! function_exists( 'woodmart_page_bottom_part' ) ) {
	function woodmart_page_bottom_part() {
		if ( ! woodmart_is_woo_ajax() ) :
			?>
			</div><!-- .main-page-wrapper -->
			<?php
		endif;
	}
}

if ( ! function_exists( 'woodmart_get_owl_atts' ) ) {
	function woodmart_get_owl_atts() {
		return array(
			'carousel_id'             => '5000',
			'speed'                   => '5000',
			'slides_per_view'         => '1',
			'wrap'                    => '',
			'loop'                    => false,
			'autoplay'                => 'no',
			'autoheight'              => 'no',
			'hide_pagination_control' => '',
			'hide_prev_next_buttons'  => '',
			'scroll_per_page'         => 'yes',
			'dragEndSpeed'            => 200,
			'center_mode'             => 'no',
			'custom_sizes'            => '',
			'sliding_speed'           => false,
			'animation'               => false,
			'content_animation'       => false,
			'post_type'               => '',
			'slider'                  => '',
			'library'                 => 'owl',
		);
	}
}

if ( ! function_exists( 'woodmart_get_owl_attributes' ) ) {
	function woodmart_get_owl_attributes( $atts = array(), $witout_init = false ) {
		$default_atts = woodmart_get_owl_atts();
		$atts         = shortcode_atts( $default_atts, $atts );
		$output       = $witout_init ? array() : array( 'data-owl-carousel' );

		wp_enqueue_script( 'imagesloaded' );
		if ( 'owl' === $atts['library'] ) {
			woodmart_enqueue_js_library( 'owl' );
			woodmart_enqueue_js_script( 'owl-carousel' );
		}

		foreach ( $atts as $key => $value ) {
			if ( isset( $default_atts[ $key ] ) && $default_atts[ $key ] == $value ) {
				unset( $atts[ $key ] );
			}
		}

		$slides_per_view = isset( $atts['slides_per_view'] ) ? $atts['slides_per_view'] : $default_atts['slides_per_view'];
		$post_type       = isset( $atts['post_type'] ) ? $atts['post_type'] : $default_atts['post_type'];

		$custom_sizes = isset( $atts['custom_sizes'] ) ? $atts['custom_sizes'] : false;

		$items = woodmart_get_owl_items_numbers( $slides_per_view, $post_type, $custom_sizes );

		$excerpt = array(
			'slides_per_view',
			'post_type',
			'custom_sizes',
			'loop',
			'carousel_id',
		);

		foreach ( $atts as $key => $value ) {
			if ( in_array( $key, $excerpt ) ) {
				continue;
			}

			if ( is_array( $value ) ) {
				$value = '\'' . wp_json_encode( $value ) . '\'';
			} else {
				$value = '"' . $value . '"';
			}

			$output[] = 'data-' . $key . '=' . $value . '';
		}

		foreach ( $items as $key => $value ) {
			$output[] = 'data-' . $key . '="' . $value . '"';
		}

		return implode( ' ', $output );
	}
}

if ( ! function_exists( 'woodmart_page_title' ) ) {
	/**
	 * Page title.
	 */
	function woodmart_page_title() {
		global $wp_query;

		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			return '';
		}

		$disable               = false;
		$page_title            = true;
		$breadcrumbs           = woodmart_get_opt( 'breadcrumbs' );
		$style                 = '';
		$page_for_posts        = get_option( 'page_for_posts' );
		$page_for_projects     = woodmart_get_portfolio_page_id();
		$title_class           = ' page-title-';
		$title_type            = 'default';
		$title_design          = woodmart_get_opt( 'page-title-design' );
		$title_size            = woodmart_get_opt( 'page-title-size' );
		$title_color           = woodmart_get_opt( 'page-title-color' );
		$shop_title            = woodmart_get_opt( 'shop_title' );
		$shop_categories       = woodmart_get_opt( 'shop_categories' );
		$single_post_design    = woodmart_get_opt( 'single_post_design' );
		$title_tag             = 'h1';
		$custom_page_title_tag = woodmart_get_opt( 'page_title_tag' );
		$page_id               = woodmart_page_ID();

		if ( 'default' !== $custom_page_title_tag && $custom_page_title_tag ) {
			$title_tag = $custom_page_title_tag;
		}

		/*
		 * Builder.
		 */
		$is_product_builder          = Builder::get_instance()->has_custom_layout( 'single_product' );
		$is_shop_product_builder     = Builder::get_instance()->has_custom_layout( 'shop_archive' );
		$is_cart_builder             = Builder::get_instance()->has_custom_layout( 'cart' );
		$is_checkout_form_builder    = Builder::get_instance()->has_custom_layout( 'checkout_form' );
		$is_checkout_content_builder = Builder::get_instance()->has_custom_layout( 'checkout_content' );
		$is_builder_element          = Builder_Data::get_instance()->get_data( 'builder' );
		$builder_title_classes       = Builder_Data::get_instance()->get_data( 'title_classes' );

		if ( ( $is_product_builder || $is_shop_product_builder || $is_cart_builder || $is_checkout_form_builder || $is_checkout_content_builder ) && ! $is_builder_element ) {
			return '';
		}

		/*
		 * End Builder.
		 */

		if ( 0 !== (int) $page_id ) {
			$disable = get_post_meta( $page_id, '_woodmart_title_off', true );

			$image = get_post_meta( $page_id, '_woodmart_title_image', true );

			$custom_title_color    = get_post_meta( $page_id, '_woodmart_title_color', true );
			$custom_title_bg_color = get_post_meta( $page_id, '_woodmart_title_bg_color', true );

			if ( is_array( $image ) && isset( $image['id'] ) ) {
				$image = wp_get_attachment_image_url( $image['id'], 'full' );
			}

			if ( $image ) {
				$style .= 'background-image: url(' . $image . ');';
			}

			if ( '' !== $custom_title_bg_color ) {
				$style .= 'background-color: ' . $custom_title_bg_color . ';';
			}

			if ( '' !== $custom_title_color && 'default' !== $custom_title_color ) {
				$title_color = $custom_title_color;
			}
		}

		if ( 'disable' === $title_design ) {
			$page_title = false;
		}

		if ( ! $page_title && ! $breadcrumbs ) {
			$disable = true;
		}

		if ( is_singular( 'post' ) && 'large_image' === $single_post_design ) {
			$disable = false;
		}

		if ( $disable ) {
			return '';
		}

		woodmart_enqueue_inline_style( 'page-title' );

		if ( woodmart_woocommerce_installed() && ( is_product_taxonomy() || is_shop() || is_product_category() || is_product_tag() || woodmart_is_product_attribute_archive() ) ) {
			woodmart_enqueue_inline_style( 'woo-shop-page-title' );

			if ( woodmart_get_opt( 'shop_title' ) ) {
				woodmart_enqueue_inline_style( 'woo-shop-opt-without-title' );
			}

			if ( woodmart_get_opt( 'shop_categories' ) ) {
				woodmart_enqueue_inline_style( 'shop-title-categories' );
				woodmart_enqueue_inline_style( 'woo-categories-loop-nav-mobile-accordion' );
			}
		}

		$title_class .= $title_type;
		$title_class .= ' title-size-' . $title_size;
		$title_class .= ' title-design-' . $title_design;

		if ( $builder_title_classes ) {
			$title_class .= $builder_title_classes;
		}

		if ( 'large_image' === $single_post_design && is_singular( 'post' ) ) {
			$title_class .= ' color-scheme-light';
		} else {
			$title_class .= ' color-scheme-' . $title_color;
		}

		do_action( 'woodmart_page_title', $title_class, $style, $title_tag, $breadcrumbs, $page_title );

		if ( 'large_image' === $single_post_design && is_singular( 'post' ) ) {
			$image_url = get_the_post_thumbnail_url( $page_id );
			if ( $image_url && ! $style ) {
				$style .= 'background-image: url(' . $image_url . ');';
			}
			$title_class .= ' post-title-large-image';

			?>
				<div class="page-title<?php echo esc_attr( $title_class ); ?>" style="<?php echo esc_attr( $style ); ?>">
					<div class="container">
						<?php if ( get_the_category_list( ', ' ) ) : ?>
							<div class="meta-post-categories wd-post-cat wd-style-with-bg"><?php echo get_the_category_list( ', ' ); // phpcs:ignore ?></div>
						<?php endif ?>

						<<?php echo esc_attr( $title_tag ); ?> class="entry-title title"><?php the_title(); ?></<?php echo esc_attr( $title_tag ); ?>>

						<?php do_action( 'woodmart_page_title_after_title' ); ?>

						<div class="entry-meta wd-entry-meta">
							<?php
							woodmart_post_meta(
								array(
									'author'        => 1,
									'author_avatar' => 1,
									'date'          => 1,
									'comments'      => 1,
									'author_label'  => 'long',
								)
							);
							?>
						</div>
					</div>
				</div>
			<?php
			return '';
		}

		// Heading for pages.
		if ( is_singular( 'page' ) && ( ! $page_for_posts || ! is_page( $page_for_posts ) ) || $is_product_builder || $is_cart_builder || $is_checkout_content_builder || $is_checkout_form_builder ) {
			$title = get_the_title();
			?>
				<div class="page-title <?php echo esc_attr( $title_class ); ?>" style="<?php echo esc_attr( $style ); ?>">
					<div class="container">
						<?php if ( woodmart_woocommerce_installed() && ( is_cart() || is_checkout() || $is_cart_builder || $is_checkout_content_builder || $is_checkout_form_builder ) ) : ?>
							<?php woodmart_checkout_steps(); ?>
						<?php else : ?>
							<?php if ( $is_product_builder || $page_title ) : ?>
								<<?php echo esc_attr( $title_tag ); ?> class="entry-title title">
									<?php echo esc_html( $title ); ?>
								</<?php echo esc_attr( $title_tag ); ?>>

								<?php do_action( 'woodmart_page_title_after_title' ); ?>
							<?php endif; ?>

							<?php if ( $breadcrumbs ) : ?>
								<?php woodmart_current_breadcrumbs( 'pages' ); ?>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			<?php
			return '';
		}

		// Heading for blog and archives.
		if ( 'large_image' !== $single_post_design && is_singular( 'post' ) || woodmart_is_blog_archive() ) {
			$title = ( ! empty( $page_for_posts ) ) ? get_the_title( $page_for_posts ) : esc_html__( 'Blog', 'woodmart' );

			if ( is_tag() ) {
				$title = esc_html__( 'Tag Archives: ', 'woodmart' ) . single_tag_title( '', false );
			}

			if ( is_category() ) {
				$title = '<span>' . single_cat_title( '', false ) . '</span>';
			}

			if ( is_date() ) {
				if ( is_day() ) {
					$title = esc_html__( 'Daily Archives: ', 'woodmart' ) . get_the_date();
				} elseif ( is_month() ) {
					$title = esc_html__( 'Monthly Archives: ', 'woodmart' ) . get_the_date( _x( 'F Y', 'monthly archives date format', 'woodmart' ) );
				} elseif ( is_year() ) {
					$title = esc_html__( 'Yearly Archives: ', 'woodmart' ) . get_the_date( _x( 'Y', 'yearly archives date format', 'woodmart' ) );
				} else {
					$title = esc_html__( 'Archives', 'woodmart' );
				}
			}

			if ( is_author() ) {
				the_post();

				$title = esc_html__( 'Posts by ', 'woodmart' ) . '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>';

				rewind_posts();
			}

			if ( is_search() ) {
				$title = esc_html__( 'Search Results for: ', 'woodmart' ) . get_search_query();
			}

			?>
				<div class="page-title <?php echo esc_attr( $title_class ); ?> title-blog" style="<?php echo esc_attr( $style ); ?>">
					<div class="container">
						<?php if ( $page_title && is_single() ) : ?>
							<h3 class="entry-title title"><?php echo wp_kses( $title, woodmart_get_allowed_html() ); ?></h3>
						<?php elseif ( $page_title ) : ?>
							<<?php echo esc_attr( $title_tag ); ?> class="entry-title title"><?php echo wp_kses( $title, woodmart_get_allowed_html() ); ?></<?php echo esc_attr( $title_tag ); ?>>
						<?php endif; ?>

						<?php do_action( 'woodmart_page_title_after_title' ); ?>

						<?php if ( $breadcrumbs && ! is_search() ) : ?>
							<?php woodmart_current_breadcrumbs( 'pages' ); ?>
						<?php endif; ?>
					</div>
				</div>
			<?php
			return '';
		}

		// Heading for portfolio.
		if ( is_singular( 'portfolio' ) || woodmart_is_portfolio_archive() ) {
			if ( woodmart_get_opt( 'single_portfolio_title_in_page_title' ) && is_singular( 'portfolio' ) ) {
				$title = get_the_title();
			} else {
				$title = get_the_title( $page_for_projects );
			}

			if ( is_tax( 'project-cat' ) ) {
				$title = single_term_title( '', false );
			}

			?>
			<div class="page-title <?php echo esc_attr( $title_class ); ?> title-blog" style="<?php echo esc_attr( $style ); ?>">
				<div class="container">
					<?php if ( $page_title ) : ?>
						<<?php echo esc_attr( $title_tag ); ?> class="entry-title title"><?php echo esc_html( $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
					<?php endif; ?>

					<?php do_action( 'woodmart_page_title_after_title' ); ?>

					<?php if ( $breadcrumbs ) : ?>
						<?php woodmart_current_breadcrumbs( 'pages' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php
			return '';
		}

		// Page heading for shop page.
		if ( ( woodmart_is_shop_archive() || $is_shop_product_builder ) && ( $shop_categories || $shop_title ) ) {
			if ( is_product_category() ) {
				$cat       = $wp_query->get_queried_object();
				$cat_image = woodmart_get_category_page_title_image( $cat );

				if ( is_array( $cat_image ) && isset( $cat_image['id'] ) ) {
					$cat_image = wp_get_attachment_image_url( $cat_image['id'], 'full' );
				}

				if ( $cat_image ) {
					$style = 'background-image: url(' . $cat_image . ')';
				}
			}

			if ( is_product_category() || is_product_tag() ) {
				$title_class .= ' with-back-btn';
			}

			if ( ! $shop_title ) {
				$title_class .= ' without-title';
			}

			if ( woodmart_get_opt( 'shop_categories' ) ) {
				$title_class .= ' wd-nav-accordion-mb-on';
			}

			$title_class .= woodmart_get_old_classes( ' nav-shop' );

			?>
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) && ! is_singular( 'product' ) ) : ?>
				<div class="page-title <?php echo esc_attr( $title_class ); ?> title-shop" style="<?php echo esc_attr( $style ); ?>">
					<div class="container">
						<?php if ( is_product_category() || is_product_tag() ) : ?>
							<?php woodmart_back_btn(); ?>
						<?php endif ?>

						<?php if ( $shop_title ) : ?>
							<<?php echo esc_attr( $title_tag ); ?> class="entry-title title">
								<?php woocommerce_page_title(); ?>
							</<?php echo esc_attr( $title_tag ); ?>>

							<?php do_action( 'woodmart_page_title_after_title' ); ?>
						<?php endif; ?>

						<?php if ( ! is_singular( 'product' ) && $shop_categories ) : ?>
							<?php woodmart_product_categories_nav(); ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php
			return '';
		}
	}

	add_action( 'woodmart_after_header', 'woodmart_page_title', 10 );
}

if ( ! function_exists( 'woodmart_back_btn' ) ) {
	function woodmart_back_btn() {
		woodmart_enqueue_js_script( 'back-history' );
		?>
			<div class="wd-back-btn wd-action-btn wd-style-icon<?php echo woodmart_get_old_classes( ' woodmart-back-btn' ); ?>"><a href="#" rel="nofollow noopener" aria-label="<?php esc_attr_e( 'Go back', 'woodmart' ); ?>"></a></div>
		<?php
	}
}

// **********************************************************************//
// ! Recursive function to get page title image for the category or
// ! take it from some parent term
// **********************************************************************//

if ( ! function_exists( 'woodmart_get_category_page_title_image' ) ) {
	function woodmart_get_category_page_title_image( $cat ) {
		$taxonomy  = 'product_cat';
		$meta_key  = 'title_image';
		$cat_image = get_term_meta( $cat->term_id, $meta_key, true );
		if ( $cat_image != '' ) {
			return $cat_image;
		} elseif ( ! empty( $cat->parent ) ) {
			$parent = get_term_by( 'term_id', $cat->parent, $taxonomy );
			return woodmart_get_category_page_title_image( $parent );
		} else {
			return '';
		}
	}
}



// **********************************************************************//
// ! Breacdrumbs function
// ! Snippet from http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
// **********************************************************************//

if ( ! function_exists( 'woodmart_breadcrumbs' ) ) {
	function woodmart_breadcrumbs( $builder_wrapper_classes = '' ) {

		/* === OPTIONS === */
		$text['home']     = esc_html__( 'Home', 'woodmart' ); // text for the 'Home' link
		$text['category'] = esc_html__( 'Archive by Category "%s"', 'woodmart' ); // text for a category page
		$text['search']   = esc_html__( 'Search Results for "%s" Query', 'woodmart' ); // text for a search results page
		$text['tag']      = esc_html__( 'Posts Tagged "%s"', 'woodmart' ); // text for a tag page
		$text['author']   = esc_html__( 'Articles Posted by %s', 'woodmart' ); // text for an author page
		$text['404']      = esc_html__( 'Error 404', 'woodmart' ); // text for the 404 page

		$show_current_post = 0; // 1 - show current post
		$show_current      = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
		$show_on_home      = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_home_link    = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_title        = 1; // 1 - show the title for the links, 0 - don't show
		$delimiter         = ' &raquo; '; // delimiter between crumbs.
		$before            = '<span class="current">'; // tag before the current crumb
		$after             = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;

		$home_link    = home_url( '/' );
		$link_before  = '<span typeof="v:Breadcrumb">';
		$link_after   = '</span>';
		$link_attr    = ' rel="v:url" property="v:title"';
		$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
		$parent_id    = $parent_id_2 = ( ! empty( $post ) && is_a( $post, 'WP_Post' ) ) ? $post->post_parent : 0;
		$frontpage_id = get_option( 'page_on_front' );
		$projects_id  = woodmart_get_portfolio_page_id();

		if ( is_home() || is_front_page() ) {

			if ( $show_on_home == 1 ) {
				echo '<div class="breadcrumbs' . $builder_wrapper_classes . '"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';
			}
		} else {

			echo '<div class="breadcrumbs' . $builder_wrapper_classes . '">';
			if ( $show_home_link == 1 ) {
				echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
				if ( $frontpage_id == 0 || $parent_id != $frontpage_id ) {
					echo esc_html( $delimiter );
				}
			}

			if ( is_category() ) {
				$this_cat = get_category( get_query_var( 'cat' ), false );
				if ( $this_cat->parent != 0 ) {
					$cats = get_category_parents( $this_cat->parent, true, $delimiter );
					if ( $show_current == 0 ) {
						$cats = preg_replace( "#^(.+)$delimiter$#", '$1', $cats );
					}
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
					if ( $show_title == 0 ) {
						$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}
					echo wp_kses_post( $cats );
				}
				if ( $show_current == 1 ) {
					echo wp_kses_post( $before ) . sprintf( $text['category'], single_cat_title( '', false ) ) . wp_kses_post( $after );
				}
			} elseif ( is_tax( 'project-cat' ) ) {
				printf( $link, get_the_permalink( $projects_id ), get_the_title( $projects_id ) );
			} elseif ( is_search() ) {
				echo wp_kses_post( $before ) . sprintf( $text['search'], get_search_query() ) . wp_kses_post( $after );

			} elseif ( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
				echo wp_kses_post( $before ) . get_the_time( 'd' ) . wp_kses_post( $after );

			} elseif ( is_month() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo wp_kses_post( $before ) . get_the_time( 'F' ) . wp_kses_post( $after );

			} elseif ( is_year() ) {
				echo wp_kses_post( $before ) . get_the_time( 'Y' ) . wp_kses_post( $after );

			} elseif ( is_single() && ! is_attachment() ) {
				if ( get_post_type() == 'portfolio' ) {
					printf( $link, get_the_permalink( $projects_id ), get_the_title( $projects_id ) );
					if ( $show_current == 1 ) {
							echo esc_html( $delimiter ) . $before . get_the_title() . $after;
					}
				} elseif ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					printf( $link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name );
					if ( $show_current == 1 ) {
							echo esc_html( $delimiter ) . $before . get_the_title() . $after;
					}
				} else {
					$cat = get_the_category();
					if ( $cat && isset( $cat[0] ) ) {
						$cat  = $cat[0];
						$cats = get_category_parents( $cat, true, $delimiter );
						if ( $show_current == 0 ) {
							$cats = preg_replace( "#^(.+)$delimiter$#", '$1', $cats );
						}
						$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
						$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
						if ( $show_title == 0 ) {
							$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
						}
						echo wp_kses_post( $cats );
						if ( $show_current_post == 1 ) {
							echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
						}
					}
				}
			} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				if ( is_object( $post_type ) ) {
					echo wp_kses_post( $before ) . $post_type->labels->singular_name . wp_kses_post( $after );
				}
			} elseif ( is_attachment() ) {
				$parent = get_post( $parent_id );
				$cat    = get_the_category( $parent->ID );
				$cat    = $cat[0];
				if ( $cat ) {
					$cats = get_category_parents( $cat, true, $delimiter );
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
					if ( $show_title == 0 ) {
							$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}
					echo wp_kses_post( $cats );
				}
				printf( $link, get_permalink( $parent ), $parent->post_title );
				if ( $show_current == 1 ) {
					echo esc_html( $delimiter ) . $before . get_the_title() . $after;
				}
			} elseif ( is_page() && ! $parent_id ) {
				if ( $show_current == 1 ) {
					echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
				}
			} elseif ( is_page() && $parent_id ) {
				if ( $parent_id != $frontpage_id ) {
						$breadcrumbs = array();
					while ( $parent_id ) {
						$page = get_page( $parent_id );
						if ( $parent_id != $frontpage_id ) {
									$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );
						}
						$parent_id = $page->post_parent;
					}
						$breadcrumbs = array_reverse( $breadcrumbs );
					for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
						echo wp_kses_post( $breadcrumbs[ $i ] );
						if ( $i != count( $breadcrumbs ) - 1 ) {
							echo esc_html( $delimiter );
						}
					}
				}
				if ( $show_current == 1 ) {
					if ( $show_home_link == 1 || ( $parent_id_2 != 0 && $parent_id_2 != $frontpage_id ) ) {
						echo esc_html( $delimiter );
					}
					echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
				}
			} elseif ( is_tag() ) {
				echo wp_kses_post( $before ) . sprintf( $text['tag'], single_tag_title( '', false ) ) . wp_kses_post( $after );

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo wp_kses_post( $before ) . sprintf( $text['author'], $userdata->display_name ) . wp_kses_post( $after );

			} elseif ( is_404() ) {
				echo wp_kses_post( $before ) . $text['404'] . wp_kses_post( $after );

			} elseif ( has_post_format() && ! is_singular() ) {
				echo get_post_format_string( get_post_format() );
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}
				echo esc_html__( 'Page', 'woodmart' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_day() ||
				is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}
			}

			echo '</div><!-- .breadcrumbs -->';

		}
	}
}

// **********************************************************************//
// ! Promo popup
// **********************************************************************//

if ( ! function_exists( 'woodmart_promo_popup' ) ) {
	add_action( 'woodmart_before_wp_footer', 'woodmart_promo_popup', 200 );

	function woodmart_promo_popup() {
		if ( ! woodmart_get_opt( 'promo_popup' ) ) {
			return;
		}

		woodmart_enqueue_js_library( 'magnific' );
		woodmart_enqueue_js_script( 'promo-popup' );
		woodmart_enqueue_inline_style( 'promo-popup' );
		woodmart_enqueue_inline_style( 'mfp-popup' );

		?>
			<div class="mfp-with-anim wd-popup wd-promo-popup<?php echo woodmart_get_old_classes( ' woodmart-promo-popup' ); ?>">
				<div class="wd-popup-inner">
					<?php if ( 'text' === woodmart_get_opt( 'promo_popup_content_type', 'text' ) ) : ?>
						<?php echo do_shortcode( woodmart_get_opt( 'popup_text' ) ); ?>
					<?php else : ?>
						<?php echo woodmart_get_html_block( woodmart_get_opt( 'popup_html_block' ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php
	}
}

// **********************************************************************//
// ! Cookies law popup
// **********************************************************************//

if ( ! function_exists( 'woodmart_cookies_popup' ) ) {
	add_action( 'woodmart_before_wp_footer', 'woodmart_cookies_popup', 300 );

	function woodmart_cookies_popup() {
		if ( ! woodmart_get_opt( 'cookies_info' ) ) {
			return;
		}

		woodmart_enqueue_js_script( 'cookies-popup' );
		woodmart_enqueue_inline_style( 'cookies-popup' );

		$page_id = woodmart_get_opt( 'cookies_policy_page' );

		?>
			<div class="wd-cookies-popup<?php echo woodmart_get_old_classes( ' woodmart-cookies-popup' ); ?>">
				<div class="wd-cookies-inner<?php echo woodmart_get_old_classes( ' woodmart-cookies-inner' ); ?>">
					<div class="cookies-info-text">
						<?php echo do_shortcode( woodmart_get_opt( 'cookies_text' ) ); ?>
					</div>
					<div class="cookies-buttons">
						<?php if ( $page_id ) : ?>
							<a href="<?php echo get_permalink( $page_id ); ?>" class="cookies-more-btn"><?php esc_html_e( 'More info', 'woodmart' ); ?></a>
						<?php endif ?>
						<a href="#" rel="nofollow noopener" class="btn btn-size-small btn-color-primary cookies-accept-btn"><?php esc_html_e( 'Accept', 'woodmart' ); ?></a>
					</div>
				</div>
			</div>
		<?php
	}
}


class WOODMART_Custom_Walker_Category extends Walker_Category {

	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters(
			'list_cats',
			esc_attr( $category->name ),
			$category
		);

		// Don't generate an element if the category name is empty.
		if ( ! $cat_name ) {
			return;
		}

		$link = '<a class="pf-value" href="' . esc_url( get_term_link( $category ) ) . '" data-val="' . esc_attr( $category->slug ) . '" data-title="' . esc_attr( $category->name ) . '" ';
		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			/**
			 * Filters the category description for display.
			 *
			 * @since 1.2.0
			 *
			 * @param string $description Category description.
			 * @param object $category    Category object.
			 */
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		$link .= $cat_name . '</a>';

		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			$link .= ' ';

			if ( empty( $args['feed_image'] ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

			if ( empty( $args['feed'] ) ) {
				$alt = ' alt="' . sprintf( esc_html__( 'Feed for all posts filed under %s', 'woodmart' ), $cat_name ) . '"';
			} else {
				$alt   = ' alt="' . $args['feed'] . '"';
				$name  = $args['feed'];
				$link .= empty( $args['title'] ) ? '' : $args['title'];
			}

			$link .= '>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= $name;
			} else {
				$link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
			}
			$link .= '</a>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= ')';
			}
		}

		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' (' . number_format_i18n( $category->count ) . ')';
		}
		if ( 'list' == $args['style'] ) {
			$output     .= "\t<li";
			$css_classes = array(
				'cat-item',
				'cat-item-' . $category->term_id,
			);

			if ( ! empty( $args['current_category'] ) ) {
				// 'current_category' can be an array, so we use `get_terms()`.
				$_current_terms = get_terms(
					$category->taxonomy,
					array(
						'include'    => $args['current_category'],
						'hide_empty' => false,
					)
				);

				foreach ( $_current_terms as $_current_term ) {
					if ( $category->term_id == $_current_term->term_id ) {
						$css_classes[] = 'current-cat chosen';
					} elseif ( $category->term_id == $_current_term->parent ) {
						$css_classes[] = 'current-cat-parent';
					}
					while ( $_current_term->parent ) {
						if ( $category->term_id == $_current_term->parent ) {
							$css_classes[] = 'current-cat-ancestor';
							break;
						}
						$_current_term = get_term( $_current_term->parent, $category->taxonomy );
					}
				}
			}

			/**
			 * Filters the list of CSS classes to include with each category in the list.
			 *
			 * @since 4.2.0
			 *
			 * @see wp_list_categories()
			 *
			 * @param array  $css_classes An array of CSS classes to be applied to each list item.
			 * @param object $category    Category data object.
			 * @param int    $depth       Depth of page, used for padding.
			 * @param array  $args        An array of wp_list_categories() arguments.
			 */
			$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

			$output .= ' class="' . $css_classes . '"';
			$output .= ">$link\n";
		} elseif ( isset( $args['separator'] ) ) {
			$output .= "\t$link" . $args['separator'] . "\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}
}

if ( ! function_exists( 'woodmart_mobile_menu' ) ) {
	function woodmart_mobile_menu() {

		$menu_locations = get_nav_menu_locations();

		$location = apply_filters( 'woodmart_main_menu_location', 'main-menu' );

		$menu_link = get_admin_url( null, 'nav-menus.php' );

		$search_args = array();
		$nav_classes = '';
		$tab_classes = '';
		$settings = whb_get_settings();

		$toolbar_fields = woodmart_get_opt( 'sticky_toolbar_fields' ) ? woodmart_get_opt( 'sticky_toolbar_fields' ) : array();

		if ( isset( $settings['search'] ) ) {
			$search_args['post_type'] = $settings['search']['post_type'];
			$search_args['ajax']      = $settings['search']['ajax'];
		}

		if ( isset( $settings['burger'] ) && isset( $settings['burger']['post_type'] ) ) {
			$search_args['post_type'] = $settings['burger']['post_type'];
		}

		if ( isset( $settings['burger'] ) || in_array( 'mobile', $toolbar_fields ) || in_array( 'search_args', $toolbar_fields ) ) {
			$mobile_categories      = isset( $settings['burger']['categories_menu'] ) ? $settings['burger']['categories_menu'] : false;
			$search_form            = isset( $settings['burger']['search_form'] ) ? $settings['burger']['search_form'] : true;
			$close_btn             = isset( $settings['burger']['close_btn'] ) ?
				$settings['burger']['close_btn'] : false;
			$position               = isset( $settings['burger']['position'] ) ? $settings['burger']['position'] : 'left';
			$mobile_categories_menu = ( $mobile_categories ) ? $settings['burger']['menu_id'] : '';
			$primary_menu_title     = ! empty( $settings['burger']['primary_menu_title'] ) ? $settings['burger']['primary_menu_title'] : esc_html__( 'Menu', 'woodmart' );
			$secondary_menu_title   = ! empty( $settings['burger']['secondary_menu_title'] ) ? $settings['burger']['secondary_menu_title'] : esc_html__( 'Categories', 'woodmart' );
		} else {
			return '';
		}

		$nav_classes .= ' wd-' . $position;
		$nav_classes .= woodmart_get_old_classes( ' wd-' . $position );

		if ( 'light' === whb_get_dropdowns_color() ) {
			$nav_classes .= ' color-scheme-light';
		}

		$pages_active      = ' wd-active';
		$categories_active = '';

		if ( isset( $settings['burger']['tabs_swap'] ) && $settings['burger']['tabs_swap'] ) {
			$pages_active       = '';
			$categories_active .= ' wd-active';
			$tab_classes       .= ' wd-swap';
		}

		woodmart_enqueue_js_script( 'mobile-navigation' );

		echo '<div class="mobile-nav wd-side-hidden' . esc_attr( $nav_classes ) . '">';

		if ( $close_btn ) {
			echo '<div class="wd-heading widget-heading"><div class="close-side-widget wd-action-btn wd-style-text wd-cross-icon"><a href="#" rel="nofollow">' . esc_html__( 'Close', 'woodmart' ) . '</a></div></div>';
		}

		if ( $search_form ) {
			woodmart_search_form( $search_args );
		}

		$tab_classes .= woodmart_get_old_classes( ' mobile-menu-tab mobile-nav-tabs' );

		if ( $mobile_categories ) {
			?>
				<ul class="wd-nav wd-nav-mob-tab wd-style-underline<?php echo esc_attr( $tab_classes ); ?>">
					<li class="mobile-tab-title mobile-pages-title <?php echo esc_attr( $pages_active ); ?>" data-menu="pages">
						<a href="#" rel="nofollow noopener">
							<span class="nav-link-text">
								<?php echo esc_html( $primary_menu_title ); ?>
							</span>
						</a>
					</li>
					<li class="mobile-tab-title mobile-categories-title <?php echo esc_attr( $categories_active ); ?>" data-menu="categories">
						<a href="#" rel="nofollow noopener">
							<span class="nav-link-text">
								<?php echo esc_html( $secondary_menu_title ); ?>
							</span>
						</a>
					</li>
				</ul>
			<?php
			if ( ! empty( $mobile_categories_menu ) ) {
				wp_nav_menu(
					array(
						'container'  => '',
						'menu'       => $mobile_categories_menu,
						'menu_class' => 'mobile-categories-menu wd-nav wd-nav-mobile' . $categories_active . woodmart_get_old_classes( ' site-mobile-menu' ),
						'walker'     => new WOODMART_Mega_Menu_Walker(),
					)
				);
			} else {
				?>
					<div class="create-nav-msg"><?php esc_html_e( 'Set your categories menu in Theme Settings -> Header -> Menu -> Mobile menu (categories)', 'woodmart' ); ?></div>
				<?php
			}
		}

		if ( isset( $menu_locations['mobile-menu'] ) && $menu_locations['mobile-menu'] != 0 ) {
			$location = 'mobile-menu';
		}

		if ( has_nav_menu( $location ) ) {
			wp_nav_menu(
				array(
					'container'      => '',
					'theme_location' => $location,
					'menu_class'     => 'mobile-pages-menu wd-nav wd-nav-mobile' . $pages_active . woodmart_get_old_classes( ' site-mobile-menu' ),
					'walker'         => new WOODMART_Mega_Menu_Walker(),
				)
			);
		} else {
			?>
			<div class="create-nav-msg">
			<?php
				printf(
					wp_kses(
						__( 'Create your first <a href="%s"><strong>navigation menu here</strong></a>', 'woodmart' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					$menu_link
				);
			?>
			</div>
			<?php
		}
		?>

		<?php if ( is_active_sidebar( 'mobile-menu-widgets' ) ) : ?>
			<div class="widgetarea-mobile">
				<?php dynamic_sidebar( 'mobile-menu-widgets' ); ?>
			</div>
			<?php
		endif;

		echo '</div><!--END MOBILE-NAV-->';
	}

	add_action( 'woodmart_before_wp_footer', 'woodmart_mobile_menu', 130 );

}

// **********************************************************************//
// Header banner
// **********************************************************************//
if ( ! function_exists( 'woodmart_header_banner' ) ) {
	function woodmart_header_banner() {
		if ( ! woodmart_get_opt( 'header_banner' ) ) {
			return;
		}

		woodmart_enqueue_js_script( 'header-banner' );
		woodmart_enqueue_inline_style( 'header-banner' );

		$banner_link = woodmart_get_opt( 'header_banner_link' );

		?>
		<div class="header-banner color-scheme-<?php echo esc_attr( woodmart_get_opt( 'header_banner_color' ) ); ?>">
			<?php if ( woodmart_get_opt( 'header_close_btn' ) ) : ?>
				<div class="close-header-banner wd-action-btn wd-style-icon wd-cross-icon"><a href="javascript:void(0);" rel="nofollow noopener" aria-label="<?php esc_attr_e( 'Close header banner', 'woodmart' ); ?>"></a></div>
			<?php endif; ?>

			<?php if ( $banner_link ) : ?>

				<a href="<?php echo esc_url( $banner_link ); ?>" class="header-banner-link wd-fill" aria-label="<?php esc_attr_e( 'Header banner link', 'woodmart' ); ?>"></a>
			<?php endif; ?>

			<div class="container header-banner-container set-cont-mb-s reset-last-child">
				<?php echo do_shortcode( woodmart_get_opt( 'header_banner_shortcode' ) ); ?>
			</div>
		</div>
		<?php
	}

	add_action( 'woodmart_before_wp_footer', 'woodmart_header_banner', 160 );
}

// **********************************************************************//
// Get star rating
// **********************************************************************//
if ( ! function_exists( 'woodmart_get_star_rating' ) ) {
	function woodmart_get_star_rating( $rating ) {
		?>
			<div class="star-rating">
				<span style="width:<?php echo ( ( $rating / 5 ) * 100 ); ?>%">
					<?php
					printf(
						esc_html__( '%1$s out of %2$s', 'woodmart' ),
						'<strong class="rating">' . esc_html( $rating ) . '</strong>',
						'<span>5</span>'
					);
					?>
				</span>
			</div>
		<?php
	}
}

// **********************************************************************//
// Get twitter posts
// **********************************************************************//
if ( ! function_exists( 'woodmart_get_twitts' ) ) {
	function woodmart_get_twitts( $args = array() ) {
		// Get the tweets from Twitter.
		if ( ! class_exists( 'TwitterOAuth' ) ) {
			return;
		}

		if ( ! isset( $args['name'] ) || ! isset( $args['consumer_key'] ) || ! isset( $args['consumer_secret'] ) || ! isset( $args['access_token'] ) || ! isset( $args['accesstoken_secret'] ) ) {
			echo '<p>You need to enter your Consumer key and secret to display your recent Twitter feed.</p>';
		}

		if ( ! isset( $args['name'] ) ) {
			$args['name'] = 'Twitter';
		}
		if ( ! isset( $args['num_tweets'] ) ) {
			$args['num_tweets'] = 5;
		}
		if ( ! isset( $args['consumer_key'] ) ) {
			$args['consumer_key'] = '';
		}
		if ( ! isset( $args['consumer_secret'] ) ) {
			$args['consumer_secret'] = '';
		}
		if ( ! isset( $args['access_token'] ) ) {
			$args['access_token'] = '';
		}
		if ( ! isset( $args['accesstoken_secret'] ) ) {
			$args['accesstoken_secret'] = '';
		}
		if ( ! isset( $args['exclude_replies'] ) ) {
			$args['exclude_replies'] = '';
		}

		$connection = new TwitterOAuth(
			$args['consumer_key'],          // Consumer key
			$args['consumer_secret'],       // Consumer secret
			$args['access_token'],          // Access token
			$args['accesstoken_secret'] // Access token secret
		);

		$posts_data_transient_name = 'wood-twitter-posts-data-' . sanitize_title_with_dashes( $args['name'] . $args['num_tweets'] . $args['exclude_replies'] );
		$fetchedTweets             = maybe_unserialize( base64_decode( get_transient( $posts_data_transient_name ) ) );

		if ( ! $fetchedTweets ) {
			$fetchedTweets = $connection->get(
				'statuses/user_timeline',
				array(
					'screen_name'     => $args['name'],
					'count'           => $args['num_tweets'],
					'exclude_replies' => ( isset( $args['exclude_replies'] ) ) ? $args['exclude_replies'] : '',
				)
			);

			if ( $connection->http_code != 200 ) {
				echo esc_html__( 'Twitter does not return 200', 'woodmart' );
				return;
			}

			$encode_posts = base64_encode( maybe_serialize( $fetchedTweets ) );
			set_transient( $posts_data_transient_name, $encode_posts, apply_filters( 'wood_twitter_cache_time', HOUR_IN_SECONDS * 2 ) );
		}

		if ( ! $fetchedTweets ) {
			echo esc_html__( 'Twitter does not return any data', 'woodmart' );
		}

		$limitToDisplay = min( $args['num_tweets'], count( $fetchedTweets ) );

		for ( $i = 0; $i < $limitToDisplay; $i++ ) {
			$tweet = $fetchedTweets[ $i ];

			// Core info.
			$name = $tweet->user->name;

			// COMMUNITY REQUEST !!!!!! (2)
			$screen_name = $tweet->user->screen_name;

			$permalink = 'https://twitter.com/' . $screen_name . '/status/' . $tweet->id_str;
			$tweet_id  = $tweet->id_str;

			// Check for SSL via protocol https then display relevant image - thanks SO - this should do
			if ( is_ssl() ) {
				$image = $tweet->user->profile_image_url_https;
			} else {
				$image = $tweet->user->profile_image_url;
			}

			// Process Tweets - Use Twitter entities for correct URL, hash and mentions
			$text = woodmart_twitter_process_links( $tweet );

			// lets strip 4-byte emojis
			$text = preg_replace( '/[\xF0-\xF7][\x80-\xBF]{3}/', '', $text );

			// Need to get time in Unix format.
			$time  = $tweet->created_at;
			$time  = date_parse( $time );
			$uTime = mktime( $time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year'] );

			// Now make the new array.
			$tweets[] = array(
				'text'      => $text,
				'name'      => $name,
				'permalink' => $permalink,
				'image'     => $image,
				'time'      => $uTime,
				'tweet_id'  => $tweet_id,
			);
		}

		// Now display the tweets, if we can.
		if ( isset( $tweets ) ) {
			?>
			<ul <?php echo ( isset( $args['show_avatar'] ) ) ? ' class="twitter-avatar-enabled"' : ''; ?>>
			<?php foreach ( $tweets as $t ) { ?>
				<li class="twitter-post">
					<?php if ( isset( $args['show_avatar'] ) && $args['show_avatar'] ) : ?>
						<div class="twitter-image-wrapper">
							<img <?php echo ( isset( $args['avatar_size'] ) ) ? 'width="' . $args['avatar_size'] . 'px" height="' . $args['avatar_size'] . 'px"' : 'width="48px" height="48px"'; ?> src="<?php echo esc_url( $t['image'] ); ?>" alt="<?php esc_html_e( 'Tweet Avatar', 'woodmart' ); ?>">
						</div>
					<?php endif ?>
					<div class="twitter-content-wrapper">
						<?php
						echo wp_kses(
							$t['text'],
							array(
								'a' => array(
									'href'   => true,
									'target' => true,
									'rel'    => true,
								),
							)
						);
						?>
						<span class="stt-em">
							<a href="<?php echo esc_url( $t['permalink'] ); ?>" target="_blank">
								<?php
									$timeDisplay = human_time_diff( $t['time'], current_time( 'timestamp' ) );
									$displayAgo  = _x( ' ago', 'leading space is required to keep gap from date', 'woodmart' );
									// Use to make il8n compliant
									printf( esc_html__( '%1$s%2$s', 'woodmart' ), $timeDisplay, $displayAgo );
								?>
							</a>
						</span>
					</div>
				</li>
				<?php
			}
			?>
			</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'woodmart_full_screen_main_nav' ) ) {
	function woodmart_full_screen_main_nav() {
		if ( ! whb_is_full_screen_menu() || ( wp_is_mobile() && woodmart_get_opt( 'mobile_optimization', 0 ) ) || ( woodmart_get_opt( 'maintenance_mode' ) && ! is_user_logged_in() ) ) {
			return;
		}

		$location     = apply_filters( 'woodmart_main_menu_location', 'main-menu' );
		$sidebar_name = 'sidebar-full-screen-menu';

		woodmart_enqueue_js_script( 'full-screen-menu' );
		woodmart_enqueue_inline_style( 'header-fullscreen-menu' );
		?>
			<div class="wd-fs-menu wd-fill wd-scroll color-scheme-light<?php echo woodmart_get_old_classes( ' full-screen-wrapper' ); ?>">
				<div class="wd-fs-close wd-action-btn wd-style-icon wd-cross-icon<?php echo woodmart_get_old_classes( ' full-screen-close-icon' ); ?>">
					<a aria-label="<?php esc_attr_e( 'Close main menu', 'woodmart' ); ?>"></a>
				</div>
				<div class="container wd-scroll-content">
					<div class="wd-fs-inner<?php echo woodmart_get_old_classes( ' full-screen-inner' ); ?>">
						<?php woodmart_get_main_nav( $location ); ?>

						<?php if ( is_active_sidebar( $sidebar_name ) ) : ?>
							<div class="wd-fs-widget-area">
								<?php dynamic_sidebar( $sidebar_name ); ?>
							</div>
						<?php endif ?>
					</div>
				</div>
			</div>
		<?php
	}

	add_action( 'woodmart_before_wp_footer', 'woodmart_full_screen_main_nav', 120 );
}

// **********************************************************************//
// Get main nav
// **********************************************************************//
if ( ! function_exists( 'woodmart_get_main_nav' ) ) {
	function woodmart_get_main_nav( $location ) {
		?>
		<?php
		if ( has_nav_menu( $location ) ) {
			wp_nav_menu(
				array(
					'container'      => '',
					'theme_location' => $location,
					'menu_class'     => 'menu wd-nav wd-nav-fs wd-style-underline' . woodmart_get_old_classes( ' full-screen-nav' ),
					'walker'         => new WOODMART_Mega_Menu_Walker(),
				)
			);
		} else {
			$menu_link = get_admin_url( null, 'nav-menus.php' );
			?>
					<div class="create-nav-msg">
				<?php
					printf(
						wp_kses(
							__( 'Create your first <a href="%s"><strong>navigation menu here</strong></a>', 'woodmart' ),
							array(
								'a' => array(
									'href' => array(),
								),
							)
						),
						$menu_link
					);
				?>
					</div>
				<?php
		}
		?>
		<?php
	}
}

// **********************************************************************//
// Get sticky social icon
// **********************************************************************//
if ( ! function_exists( 'woodmart_get_sticky_social' ) ) {
	function woodmart_get_sticky_social() {
		if ( ! woodmart_get_opt( 'sticky_social' ) ) {
			return;
		}

		$classes  = 'wd-sticky-social';
		$classes .= ' wd-sticky-social-' . woodmart_get_opt( 'sticky_social_position' );
		$atts     = array(
			'type'     => woodmart_get_opt( 'sticky_social_type' ),
			'el_class' => $classes,
			'style'    => 'colored',
			'size'     => 'custom',
			'form'     => 'square',
			'sticky'   => true,
		);

		echo woodmart_shortcode_social( $atts );

		woodmart_enqueue_js_script( 'sticky-social-buttons' );
		woodmart_enqueue_inline_style( 'sticky-social-buttons' );
	}
	add_action( 'woodmart_before_wp_footer', 'woodmart_get_sticky_social', 200 );
}

// **********************************************************************//
// Get current breadcrumbs
// **********************************************************************//

if ( ! function_exists( 'woodmart_current_breadcrumbs' ) ) {
	/**
	 * Get current breadcrumbs.
	 *
	 * @param string $type post type.
	 */
	function woodmart_current_breadcrumbs( $type, $return = false ) {
		if ( $return ) {
			ob_start();
		}

		if ( woodmart_get_opt( 'yoast_' . $type . '_breadcrumbs' ) && function_exists( 'yoast_breadcrumb' ) ) {
			?>
			<div class="yoast-breadcrumb">
				<?php echo yoast_breadcrumb(); // phpcs:ignore ?>
			</div>
			<?php
		} elseif ( 'shop' === $type ) {
			woocommerce_breadcrumb();
		} else {
			woodmart_breadcrumbs();
		}

		if ( $return ) {
			return ob_get_clean();
		}
	}
}

// **********************************************************************//
// Display icon
// **********************************************************************//
if ( ! function_exists( 'woodmart_display_icon' ) ) {
	function woodmart_display_icon( $img_id, $img_size, $default_size ) {
		$icon     = wpb_getImageBySize(
			array(
				'attach_id'  => $img_id,
				'thumb_size' => $img_size,
			)
		);
		$icon_src = $icon['p_img_large'][0];
		$icon_id  = rand( 999, 9999 );

		$sizes = woodmart_get_explode_size( $img_size, $default_size );

		if ( woodmart_is_svg( $icon_src ) ) {
			return '<div class="img-wrapper"><span class="svg-icon" style="width: ' . $sizes[0] . 'px;height: ' . $sizes[1] . 'px;">' . woodmart_get_any_svg( $icon_src, $icon_id ) . '</span></div>';
		} else {
			return '<div class="img-wrapper">' . $icon['thumbnail'] . '</div>';
		}
	}
}
