<?php
/**
 * Post types file.
 *
 * @package Woodmart
 */

namespace WOODCORE;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Post types class.
 */
class Post_Types {
	/**
	 * Instance.
	 *
	 * @var null
	 */
	public static $instance = null;

	/**
	 * Instance.
	 *
	 * @return Post_Types|null
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_layout' ), 10 );
	}

	/**
	 * Register layout post type.
	 */
	public function register_layout() {
		register_post_type(
			'woodmart_layout',
			array(
				'label'              => esc_html__( 'Layouts', 'woodmart' ),
				'labels'             => array(
					'name'          => esc_html__( 'Layouts', 'woodmart' ),
					'singular_name' => esc_html__( 'Layout', 'woodmart' ),
					'menu_name'     => esc_html__( 'Layouts', 'woodmart' ),
				),
				'supports'           => array( 'title', 'editor' ),
				'hierarchical'       => false,
				'public'             => true,
				'menu_position'      => 28,
				'menu_icon'          => 'dashicons-format-gallery',
				'publicly_queryable' => is_user_logged_in(),
				'show_in_rest'       => true,
			)
		);
	}
}

Post_Types::get_instance();
