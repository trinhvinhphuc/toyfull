<?php
/**
 * Layout conditions cache class file.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use WP_Query;

/**
 * Layout conditions cache class.
 */
class Conditions_Cache {
	/**
	 * Option name.
	 *
	 * @var string
	 */
	private $option_name = 'wd_layouts_conditions';
	/**
	 * Post type.
	 *
	 * @var string
	 */
	private $post_type = 'woodmart_layout';
	/**
	 * Conditions meta key.
	 *
	 * @var string
	 */
	private $conditions_meta_key = 'wd_layout_conditions';
	/**
	 * Type meta key.
	 *
	 * @var string
	 */
	private $type_meta_key = 'wd_layout_type';
	/**
	 * Conditions.
	 *
	 * @var string
	 */
	private $conditions = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->refresh();
	}

	/**
	 * Add.
	 *
	 * @param string $type       Type.
	 * @param array  $conditions Conditions.
	 * @param int    $post_id    Post id.
	 *
	 * @return $this
	 */
	public function add( $type, $conditions, $post_id ) {
		if ( $type ) {
			if ( ! isset( $this->conditions[ $type ] ) ) {
				$this->conditions[ $type ] = [];
			}
			$this->conditions[ $type ][ $post_id ] = $conditions;
		}

		return $this;
	}

	/**
	 * Remove.
	 *
	 * @param int $post_id Post id.
	 *
	 * @return $this
	 */
	public function remove( $post_id ) {
		$post_id = absint( $post_id );

		foreach ( $this->conditions as $type => $templates ) {
			foreach ( $templates as $id => $template ) {
				if ( $post_id === $id ) {
					unset( $this->conditions[ $type ][ $id ] );
				}
			}
		}

		return $this;
	}

	/**
	 * Save.
	 */
	public function save() {
		return update_option( $this->option_name, $this->conditions );
	}

	/**
	 * Refresh.
	 */
	public function refresh() {
		$this->conditions = get_option( $this->option_name, array() );
	}

	/**
	 * Clear.
	 */
	public function clear() {
		$this->conditions = array();
	}

	/**
	 * Get.
	 *
	 * @param string $type Type.
	 *
	 * @return array
	 */
	public function get( $type ) {
		if ( isset( $this->conditions[ $type ] ) ) {
			return $this->conditions[ $type ];
		}

		return array();
	}

	/**
	 * Regenerate.
	 */
	public function regenerate() {
		$this->clear();

		$query = new WP_Query(
			array(
				'posts_per_page'   => - 1,
				'post_type'        => $this->post_type,
				'fields'           => 'ids',
				'meta_key'         => $this->conditions_meta_key, // phpcs:ignore
				'suppress_filters' => true
			)
		);

		foreach ( $query->posts as $post_id ) {
			$conditions = get_post_meta( $post_id, $this->conditions_meta_key, true );
			$type       = get_post_meta( $post_id, $this->type_meta_key, true );

			$this->add( $type, $conditions, $post_id );
		}

		$this->save();

		return $this;
	}
}
