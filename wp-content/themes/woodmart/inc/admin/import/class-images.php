<?php
/**
 * Import images.
 *
 * @package Woodmart
 */

namespace XTS\Import;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import images.
 */
class Images {
	/**
	 * Version name.
	 *
	 * @var string
	 */
	private $version;
	/**
	 * Helpers.
	 *
	 * @var Helpers
	 */
	private $helpers;
	/**
	 * Blog.
	 *
	 * @var array
	 */
	private $blog = array(
		'exploring-atlantas-modern-homes',
		'green-interior-design-inspiration',
		'collar-brings-back-coffee-brewing-ritual',
		'reinterprets-the-classic-bookshelf',
		'creative-water-features-and-exterior',
		'minimalist-japanese-inspired-furniture',
		'new-home-decor-from-john-doerson',
		'the-big-design-wall-likes-pictures',
		'sweet-seat-functional-seat-for-it-folks',
	);
	/**
	 * Products.
	 *
	 * @var array
	 */
	private $products = array(
		'henectus-tincidunt',
		'ornare-auctor',
		'eames-plastic-side-chair',
		'augue-adipiscing-euismod',
		'iphone-dock',
		'wine-bottle-lantern',
		'decoration-wooden-present',
		'panton-tunior-chair',
		'smart-watches-wood-edition',
		'wooden-single-drawer',
		'classic-wooden-chair',
		'eames-lounge-chair',
	);
	/**
	 * Portfolio.
	 *
	 * @var array
	 */
	private $portfolio = array(
		'suspendisse-quam-at-vestibulum',
		'netus-eu-mollis-hac-dignis',
		'et-vestibulum-quis-a-suspendisse',
		'imperdiet-mauris-a-nontin',
		'venenatis-nam-phasellus',
		'leo-uteu-ullamcorper',
		'a-lacus-bibendum-pulvinar',
		'rhoncus-quisque-sollicitudin',
		'potenti-parturient-parturie',
	);
	/**
	 * Categories.
	 *
	 * @var array
	 */
	private $categories = array(
		'accessories',
		'clocks',
		'cooking',
		'furniture',
		'lighting',
		'toys',
	);

	/**
	 * Constructor.
	 *
	 * @param string $version Version name.
	 */
	public function __construct( $version ) {
		$this->helpers = Helpers::get_instance();
		$this->version = $version;

		$this->set_default_image_sizes();
		$this->import_images();
	}

	/**
	 * Set default image sizes.
	 */
	private function set_default_image_sizes() {
		$sizes = array(
			'thumbnail_size_w'                  => 150,
			'thumbnail_size_h'                  => 150,
			'medium_size_w'                     => 400,
			'medium_size_h'                     => 300,
			'large_size_w'                      => 1300,
			'large_size_h'                      => 800,
			'woocommerce_single_image_width'    => 700,
			'woocommerce_thumbnail_image_width' => 430,
			'woocommerce_thumbnail_cropping'    => 'uncropped',
		);

		foreach ( $sizes as $key => $value ) {
			update_option( $key, $value );
		}
	}

	/**
	 * Import images.
	 */
	private function import_images() {
		$default_file_path = $this->helpers->get_file_path( 'images.json', 'main' );
		$file_path         = $this->helpers->get_file_path( 'images.json', $this->version );

		if ( 'elementor' === woodmart_get_current_page_builder() ) {
			$default_file_path = $this->helpers->get_file_path( 'images-elementor.json', 'main' );
			$file_path         = $this->helpers->get_file_path( 'images-elementor.json', $this->version );
		}

		if ( $file_path ) {
			$data = json_decode( $this->helpers->get_local_file_content( $file_path ), true );
		}

		$data_default = json_decode( $this->helpers->get_local_file_content( $default_file_path ), true );

		if ( isset( $data['products'] ) ) {
			$this->replace_posts_images( $data['products'], $this->products, 'product' );
		} else {
			$this->replace_posts_images( $data_default['products'], $this->products, 'product' );
		}

		if ( isset( $data['blog'] ) ) {
			$this->replace_posts_images( $data['blog'], $this->blog, 'post' );
		} else {
			$this->replace_posts_images( $data_default['blog'], $this->blog, 'post' );
		}

		if ( isset( $data['portfolio'] ) ) {
			$this->replace_posts_images( $data['portfolio'], $this->portfolio, 'portfolio' );
		} else {
			$this->replace_posts_images( $data_default['portfolio'], $this->portfolio, 'portfolio' );
		}

		if ( isset( $data['categories'] ) ) {
			$this->replace_categories_images( $data['categories'] );
		} else {
			$this->replace_categories_images( $data_default['categories'] );
		}
	}

	/**
	 * Categories images.
	 *
	 * @param array $images Data.
	 */
	private function replace_categories_images( $images ) {
		$categories = $this->get_terms_by_slug( $this->categories );
		$images     = $this->update_ids( $images );

		foreach ( $categories as $category_id ) {
			$term = get_term( $category_id, 'product_cat' );

			if ( ! $term || is_wp_error( $term ) || ! isset( $images[ $term->slug ] ) ) {
				continue;
			}

			update_term_meta( $category_id, 'thumbnail_id', $images[ $term->slug ] );
		}
	}

	/**
	 * Posts images.
	 *
	 * @param array  $images    Data.
	 * @param array  $posts     Posts.
	 * @param string $post_type Post type.
	 */
	private function replace_posts_images( $images, $posts, $post_type ) {
		$posts  = $this->get_posts_by_slug( $posts, $post_type );
		$images = $this->update_ids( $images );

		foreach ( $posts as $post_id ) {
			$post = get_post( $post_id );

			if ( ! $post || ! isset( $images[ $post->post_name ] ) ) {
				continue;
			}

			update_post_meta( $post_id, '_thumbnail_id', $images[ $post->post_name ] );
		}
	}

	/**
	 * Get posts by slug.
	 *
	 * @param array  $posts     Posts.
	 * @param string $post_type Post type.
	 *
	 * @return array
	 */
	private function get_posts_by_slug( $posts, $post_type ) {
		$output = array();

		foreach ( $posts as $post ) {
			$output[] = get_page_by_path( $post, ARRAY_A, $post_type )['ID'];
		}

		return $output;
	}

	/**
	 * Get terms by slug.
	 *
	 * @param array $terms Terms.
	 *
	 * @return array
	 */
	private function get_terms_by_slug( $terms ) {
		$output = array();

		foreach ( $terms as $term_slug ) {
			$term = get_term_by( 'slug', $term_slug, 'product_cat', ARRAY_A );
			$output[] = isset( $term['term_id'] ) ? $term['term_id'] : '';
		}

		return $output;
	}

	/**
	 * Update IDS.
	 *
	 * @param array $ids Ids.
	 *
	 * @return array
	 */
	private function update_ids( $ids ) {
		$imported_data = $this->helpers->get_imported_data( $this->version );

		foreach ( $ids as $key => $current_id ) {
			if ( ! $current_id ) {
				continue;
			}

			$new_id = '';

			$data = isset( $imported_data['attachment'] ) ? $imported_data['attachment'] : array();

			if ( isset( $data[ $current_id ]['new'] ) && $data[ $current_id ]['new'] ) {
				$new_id = $data[ $current_id ]['new'];
			}

			if ( $new_id ) {
				$ids[ $key ] = $new_id;
			}
		}

		return $ids;
	}
}
