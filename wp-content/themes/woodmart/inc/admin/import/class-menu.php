<?php
/**
 * Import menu.
 *
 * @package Woodmart
 */

namespace XTS\Import;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import menu.
 */
class Menu {
	/**
	 * Version name.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Constructor.
	 *
	 * @param string $version Version name.
	 */
	public function __construct( $version ) {
		$this->version = $version;

		$this->set_home_page();
		$this->add_default_pages_to_menu();
	}

	/**
	 * Add default pages to menu.
	 */
	public function add_default_pages_to_menu() {
		$home_block = get_page_by_title( 'Menu home', OBJECT, 'cms_block' );
		$home_meta  = array();

		if ( ! is_null( $home_block ) ) {
			$home_meta = array(
				'block'  => $home_block->ID,
				'design' => 'full-width',
			);
		}

		$shop_block = get_page_by_title( 'Menu shop', OBJECT, 'cms_block' );
		$shop_meta  = array();

		if ( ! is_null( $shop_block ) ) {
			$shop_meta = array(
				'block'  => $shop_block->ID,
				'design' => 'full-width',
			);
		}

		$this->add_menu_item_by_title( 'Home ' . $this->version, 1, 'main', $home_meta );
		$this->add_menu_item_by_title( 'Home ' . $this->version, 1, 'mobile', $home_meta );
		$this->add_menu_item_by_title( 'Home ' . $this->version, 1, 'left', $home_meta );

		$this->add_menu_item_by_title( 'Shop', 2, 'main', $shop_meta );
		$this->add_menu_item_by_title( 'Shop', 2, 'mobile', $shop_meta );
		$this->add_menu_item_by_title( 'Shop', 2, 'left', $shop_meta );
	}

	/**
	 * Set home page.
	 */
	public function set_home_page() {
		$home_page_title = 'Home ' . $this->version;
		$home_page       = get_page_by_title( $home_page_title );

		if ( ! is_null( $home_page ) ) {
			update_option( 'page_on_front', $home_page->ID );
			update_option( 'show_on_front', 'page' );
		}
	}

	/**
	 * Add menu item by title.
	 *
	 * @param string $title    Param.
	 * @param false  $position Param.
	 * @param string $menu     Param.
	 * @param array  $meta     Param.
	 *
	 * @return int|string
	 */
	public function add_menu_item_by_title( $title, $position = false, $menu = 'main', $meta = array() ) {
		$page = get_page_by_title( $title );

		if ( is_null( $page ) ) {
			return '';
		}

		if ( strstr( $title, 'Home' ) ) {
			$title = 'Home';
		}

		$this->insert_menu_item( $title, $position, $page->ID, $menu, $meta );

		return $page->ID;
	}

	/**
	 * Insert menu item.
	 *
	 * @param string $page_title Param.
	 * @param false  $position   Param.
	 * @param false  $page_id    Param.
	 * @param string $menu       Param.
	 * @param array  $meta       Param.
	 */
	private function insert_menu_item( $page_title, $position = false, $page_id = false, $menu = 'main', $meta = array() ) {
		$menu_id = $this->get_menu_id( $menu );

		$all_items = wp_get_nav_menu_items( $menu_id );

		if ( ! is_array( $all_items ) ) {
			return;
		}

		foreach ( $all_items as $item ) {
			if ( $item->title === $page_title ) {
				wp_delete_post( $item->ID, true );
			}
		}

		$args = array(
			'menu-item-title'  => $page_title,
			'menu-item-object' => 'page',
			'menu-item-type'   => 'post_type',
			'menu-item-status' => 'publish',
		);

		if ( $position ) {
			$args['menu-item-position'] = $position;
		}

		if ( $page_id ) {
			$args['menu-item-object-id'] = $page_id;
		}

		$menu_item_id = wp_update_nav_menu_item( $menu_id, 0, $args );

		if ( ! empty( $meta ) ) {
			foreach ( $meta as $key => $value ) {
				if ( 'content' === $key ) {
					wp_update_post(
						array(
							'ID'           => $menu_item_id,
							'post_content' => $value,
						)
					);
				} else {
					add_post_meta( $menu_item_id, '_menu_item_' . $key, $value );
				}
			}
		}
	}

	/**
	 * Get menu id.
	 *
	 * @param string $menu Menu key.
	 *
	 * @return mixed
	 */
	private function get_menu_id( $menu ) {
		$main_menu   = get_term_by( 'name', 'Main navigation', 'nav_menu' );
		$mobile_menu = get_term_by( 'name', 'Mobile navigation', 'nav_menu' );
		$left_menu   = get_term_by( 'name', 'Main menu left', 'nav_menu' );

		$menu_ids = array(
			'main'   => $main_menu->term_id,
			'mobile' => $mobile_menu->term_id,
			'left'   => $left_menu->term_id,
		);

		return $menu_ids[ $menu ];
	}
}
