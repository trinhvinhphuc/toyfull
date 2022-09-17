<?php
/**
 * Layouts class file.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Plugin;
use XTS\Modules\Layouts\Global_Data as Builder_Data;
use XTS\Singleton;

/**
 * Layouts class.
 */
class Main extends Singleton {
	/**
	 * Layout.
	 *
	 * @var array
	 */
	private $layouts_cache = array();

	/**
	 * Constructor.
	 */
	public function init() {
		add_filter( 'init', array( $this, 'define_constants' ), 5 );
		add_filter( 'init', array( $this, 'include_files' ), 10 );
		add_filter( 'init', array( $this, 'register_elementor_categories' ), 20 );
	}

	/**
	 * Define constants.
	 */
	public function define_constants() {
		define( 'XTS_LAYOUTS_DIR', WOODMART_THEMEROOT . '/inc/modules/layouts/' );
		define( 'XTS_LAYOUTS_TEMPLATES_DIR', '/inc/modules/layouts/templates/' );
	}

	/**
	 * Include files.
	 */
	public function include_files() {
		require_once XTS_LAYOUTS_DIR . 'admin/class-admin.php';
		require_once XTS_LAYOUTS_DIR . 'admin/class-conditions-cache.php';
		require_once XTS_LAYOUTS_DIR . 'admin/class-manager.php';
		require_once XTS_LAYOUTS_DIR . 'admin/class-import.php';
		require_once XTS_LAYOUTS_DIR . 'class-layout-type.php';
		require_once XTS_LAYOUTS_DIR . 'class-checkout.php';
		require_once XTS_LAYOUTS_DIR . 'class-cart.php';
		require_once XTS_LAYOUTS_DIR . 'class-shop-archive.php';
		require_once XTS_LAYOUTS_DIR . 'class-single-product.php';

		$directory       = '';
		$current_builder = woodmart_get_current_page_builder();

		if ( 'wpb' === $current_builder ) {
			$directory = XTS_LAYOUTS_DIR . 'wpb/**/**/*.php';
		} elseif ( 'elementor' === $current_builder ) {
			$directory = XTS_LAYOUTS_DIR . 'elementor/**/*.php';
		}

		if ( $directory ) {
			foreach ( glob( $directory, GLOB_NOSORT ) as $file ) {
				require_once $file;
			}
		}
	}

	/**
	 * Add theme widget categories.
	 */
	public function register_elementor_categories() {
		if ( ! woodmart_is_elementor_installed() ) {
			return;
		}

		Plugin::instance()->elements_manager->add_category( 'wd-woocommerce-elements', array(
			'title' => esc_html__( '[XTemos] WooCommerce', 'woodmart' ),
			'icon'  => 'fab fa-plug',
		) );

		Plugin::instance()->elements_manager->add_category( 'wd-single-product-elements', array(
			'title' => esc_html__( '[XTemos] Single product', 'woodmart' ),
			'icon'  => 'fab fa-plug',
		) );

		Plugin::instance()->elements_manager->add_category( 'wd-shop-archive-elements', array(
			'title' => esc_html__( '[XTemos] Products archive', 'woodmart' ),
			'icon'  => 'fab fa-plug',
		) );

		Plugin::instance()->elements_manager->add_category( 'wd-cart-elements', array(
			'title' => esc_html__( '[XTemos] Cart', 'woodmart' ),
			'icon'  => 'fab fa-plug',
		) );

		Plugin::instance()->elements_manager->add_category( 'wd-checkout-elements', array(
			'title' => esc_html__( '[XTemos] Checkout', 'woodmart' ),
			'icon'  => 'fab fa-plug',
		) );
	}

	/**
	 * Check if the custom template is set.
	 *
	 * @param  string  $type  Template type.
	 *
	 * @return bool
	 */
	public function has_custom_layout( $type ) {
		do_action( 'woodmart_get_layout_id', $this );

		if ( ! woodmart_woocommerce_installed() ) {
			return false;
		}

		$id   = $this->get_layout_id( $type );
		$post = get_post( $id );

		return ( ! empty( $id ) && $post && 'publish' === $post->post_status ) || self::is_layout_type( $type );
	}

	/**
	 * Get custom template ID.
	 *
	 * @param  string  $type  Template type.
	 *
	 * @return string
	 */
	public function get_layout_id( $type ) {
		if ( isset( $this->layouts_cache[ $type ] ) ) {
			return apply_filters( 'woodmart_layout_id', $this->layouts_cache[ $type ] );
		}

		$conditions_data         = get_option( 'wd_layouts_conditions' );
		$current_conditions_data = isset( $conditions_data[ $type ] ) ? $conditions_data[ $type ] : array();
		$sorted_data             = array();
		$conditions_priority     = array();

		foreach ( $current_conditions_data as $post_id => $conditions ) {
			foreach ( $conditions as $condition ) {
				$is_active = false;

				if ( 'single_product' === $type ) {
					$is_active = Single_Product::get_instance()->check( $condition );
				} elseif ( 'shop_archive' === $type ) {
					$is_active = Shop_Archive::get_instance()->check( $condition );
				} elseif ( 'checkout_form' === $type || 'checkout_content' === $type ) {
					$is_active = Checkout::get_instance()->check( $condition, $type );
				} elseif ( 'cart' === $type ) {
					$is_active = Cart::get_instance()->check( $condition );
				}

				if ( $is_active ) {
					$sorted_data[ $post_id ][$condition['condition_comparison']][] = [
						'is_active'  => $is_active,
						'priority'   => $this->get_condition_priority( $condition['condition_type'] ),
					];
				}
			}
		}

		foreach ( $sorted_data as $post_id => $conditions ) {
			if ( isset( $conditions['include'] ) ) {
				foreach ( $conditions['include'] as $condition ) {
					if ( $condition['is_active'] ) {
						$conditions_priority[ $post_id ] = $condition['priority'];
					}
				}
			}

			if ( isset( $conditions['exclude'] ) ) {
				foreach ( $conditions['exclude'] as $condition ) {
					if ( $condition['is_active'] ) {
						unset( $conditions_priority[ $post_id ] );
					}
				}
			}
		}

		asort( $conditions_priority );

		$conditions_priority = array_flip( $conditions_priority );

		$this->layouts_cache[ $type ] = end( $conditions_priority );

		return apply_filters( 'woodmart_layout_id', $this->layouts_cache[ $type ] );
	}

	/**
	 * Get condition priority;
	 *
	 * @param  string  $type  Condition type.
	 *
	 * @return int
	 */
	private function get_condition_priority( $type ) {
		$priority = 100;

		switch ( $type ) {
			case 'all':
				$priority = 10;
				break;
			case 'shop_page':
				$priority = 20;
				break;
			case 'product_cats':
			case 'product_tags':
			case 'product_attr':
				$priority = 30;
				break;
			case 'product_cat_children':
				$priority = 40;
				break;
			case 'product_search':
				$priority = 50;
				break;
			case 'product_cat':
			case 'product_tag':
			case 'product_attr_term':
			case 'product_term':
				$priority = 70;
				break;
			case 'product':
				$priority = 80;
				break;
		}

		return apply_filters( 'woodmart_layouts_condition_priority', $priority, $type );
	}

	/**
	 * Setup preview.
	 *
	 * @param  array  $shop_args  Shop query arguments.
	 */
	public static function setup_preview( $shop_args = array() ) {
		$layout_type = get_post_meta( get_the_ID(), 'wd_layout_type', true );

		if ( 'single_product' === $layout_type || ( wp_doing_ajax() && isset( $_POST['action'] ) && 'wd_layout_create' === $_POST['action'] ) ) {
			Single_Product::setup_postdata();
		} elseif ( 'shop_archive' === $layout_type ) {
			if ( ! $shop_args ) {
				$shop_args = array(
					'post_type'      => 'product',
					'posts_per_page' => woodmart_get_products_per_page(),
				);
			}

			Shop_Archive::switch_to_preview_query( $shop_args );
		}
	}

	/**
	 * Restore preview.
	 */
	public static function restore_preview() {
		Single_Product::reset_postdata();
		Shop_Archive::restore_current_query();
	}

	/**
	 * Return true if currently type.
	 *
	 * @param  string  $type  Layout type.
	 *
	 * @return bool
	 */
	public static function is_layout_type( $type ) {
		$layout_id = '';

		if ( Builder_Data::get_instance()->get_data( 'layout_id' ) ) {
			$layout_id = Builder_Data::get_instance()->get_data( 'layout_id' );
		} elseif ( ( 'post.php' === $GLOBALS['pagenow'] || wp_doing_ajax() ) && ( isset( $_GET['post'] ) || isset( $_REQUEST['post_id'] ) || isset( $_POST['post_ID'] ) ) ) { //phpcs:ignore
			if ( isset( $_GET['post'] ) && $_GET['post'] ) { //phpcs:ignore
				$layout_id = woodmart_clean( $_GET['post'] ); //phpcs:ignore
			} elseif ( isset( $_REQUEST['post_id'] ) && $_REQUEST['post_id'] ) { //phpcs:ignore
				$layout_id = woodmart_clean( $_REQUEST['post_id'] ); //phpcs:ignore
			} elseif ( isset( $_POST['post_ID'] ) && $_POST['post_ID'] ) { //phpcs:ignore
				$layout_id = woodmart_clean( $_POST['post_ID'] ); //phpcs:ignore
			}
		} elseif ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
			$layout_id = (int) vc_get_param( 'vc_post_id' );
		} else {
			$layout_id = get_the_ID();
		}

		if ( isset( $_POST['action'] ) && 'wd_layout_create' === $_POST['action'] ) {
			return true;
		}

		$layout_type = get_post_meta( $layout_id, 'wd_layout_type', true );

		return $layout_type === $type;
	}
}

Main::get_instance();
