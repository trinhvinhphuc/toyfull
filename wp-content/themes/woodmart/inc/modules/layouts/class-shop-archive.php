<?php
/**
 * Shop archive builder.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use WP_Query;

/**
 * Shop archive builder class.
 */
class Shop_Archive extends Layout_Type {
	/**
	 * Switched data.
	 *
	 * @var array Switched data.
	 */
	private static $switched_data = array();

	/**
	 * Check.
	 *
	 * @param  array  $condition  Condition.
	 * @param  string  $type  Layout type.
	 */
	public function check( $condition, $type = '' ) {
		$is_active = false;

		switch ( $condition['condition_type'] ) {
			case 'all':
				$is_active = is_shop() || is_product_category() || is_product_tag() || woodmart_is_product_attribute_archive() ? true : false;
				break;
			case 'shop_page':
				$is_active = is_shop();
				break;
			case 'product_search':
				$is_active = is_search() && 'product' === get_query_var( 'post_type' );
				break;
			case 'product_term':
				$object      = get_queried_object();
				$taxonomy_id = is_object( $object ) && property_exists( $object,
					'term_id' ) ? $object->term_id : false;

				$is_active = (int) $taxonomy_id === (int) $condition['condition_query'];
				break;
			case 'product_cat_children':
				$object        = get_queried_object();
				$taxonomy_id   = is_object( $object ) && property_exists( $object,
					'term_id' ) ? $object->term_id : false;
				$term_children = get_term_children( $condition['condition_query'], 'product_cat' );

				$is_active = in_array( $taxonomy_id, $term_children, false );
				break;
			case 'product_cats':
				$is_active = is_product_category();
				break;
			case 'product_tags':
				$is_active = is_product_tag();
				break;
			case 'product_attr':
				$is_active = woodmart_is_product_attribute_archive();
				break;
		}

		return $is_active;
	}

	/**
	 * Priority.
	 */
	public function priority() {
	}

	/**
	 * Override templates.
	 *
	 * @param  string  $template  Template.
	 *
	 * @return bool|string
	 */
	public function override_template( $template ) {
		if ( woodmart_woocommerce_installed() && ( is_shop() || is_product_taxonomy() ) && Main::get_instance()->has_custom_layout( 'shop_archive' ) ) {
			$this->display_template();

			return false;
		}

		return $template;
	}

	/**
	 * Display custom template on the shop page.
	 */
	private function display_template() {
		$this->before_template_content();
		$this->template_content( 'shop_archive' );
		$this->after_template_content();
	}

	/**
	 * Before template content.
	 */
	public function before_template_content() {
		if ( woodmart_is_woo_ajax() === 'fragments' ) {
			woodmart_woocommerce_main_loop( true );
			die();
		}

		if ( ! woodmart_is_woo_ajax() ) {
			get_header();
		} else {
			woodmart_page_top_part();
		}

		do_action( 'woocommerce_before_main_content' );

		woodmart_enqueue_inline_style( 'woo-shop-builder' );
	}

	/**
	 * Before template content.
	 */
	public function after_template_content() {
		do_action( 'woocommerce_after_main_content' );

		if ( ! woodmart_is_woo_ajax() ) {
			get_footer();
		} else {
			woodmart_page_bottom_part();
		}
	}

	/**
	 * Switch to preview query.
	 *
	 * @param  array  $new_query  New query variables.
	 */
	public static function switch_to_preview_query( $new_query ) {
		if ( ! is_singular( 'woodmart_layout' ) && ! wp_doing_ajax() ) {
			return;
		}

		global $wp_query;
		$current_query_vars = $wp_query->query;

		// If is already switched, or is the same query, return.
		if ( $current_query_vars === $new_query ) {
			self::$switched_data[] = false;

			return;
		}

		$new_query = new WP_Query( $new_query );

		$switched_data = array(
			'switched' => $new_query,
			'original' => $wp_query,
		);

		if ( ! empty( $GLOBALS['post'] ) ) {
			$switched_data['post'] = $GLOBALS['post'];
		}

		self::$switched_data[] = $switched_data;

		$wp_query = $new_query; // phpcs:ignore

		// Ensure the global post is set only if needed.
		unset( $GLOBALS['post'] );

		WC()->query->product_query( $new_query );
		wc_set_loop_prop( 'total', 20 );
	}

	/**
	 * Restore default query.
	 *
	 * @return void
	 */
	public static function restore_current_query() {
		$data = array_pop( self::$switched_data );

		// If not switched, return.
		if ( ! $data ) {
			wc_reset_loop();

			return;
		}

		global $wp_query;

		$wp_query = $data['original']; // phpcs:ignore

		// Ensure the global post/authordata is set only if needed.
		unset( $GLOBALS['post'] );

		if ( ! empty( $data['post'] ) ) {
			$GLOBALS['post'] = $data['post']; // phpcs:ignore
			setup_postdata( $GLOBALS['post'] );
		}

		WC()->query->product_query( $wp_query );
		wc_reset_loop();
	}
}

Shop_Archive::get_instance();
