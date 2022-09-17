<?php
/**
 * Admin layouts class file.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use WP_Post;
use WP_Query;
use XTS\Singleton;

/**
 * Admin layouts class.
 */
class Admin extends Singleton {
	/**
	 * Layout types.
	 *
	 * @var array
	 */
	private $layout_types = array();
	/**
	 * Post type.
	 *
	 * @var string
	 */
	private $post_type = 'woodmart_layout';
	/**
	 * Type meta key.
	 *
	 * @var string
	 */
	private $type_meta_key = 'wd_layout_type';
	/**
	 * Conditions meta key.
	 *
	 * @var string
	 */
	private $conditions_meta_key = 'wd_layout_conditions';

	/**
	 * Constructor.
	 */
	public function init() {
		$this->layout_types = array(
			'single_product'   => esc_html__( 'Single product', 'woodmart' ),
			'shop_archive'     => esc_html__( 'Products archive', 'woodmart' ),
			'cart'             => esc_html__( 'Cart', 'woodmart' ),
			'checkout_form'    => esc_html__( 'Checkout form', 'woodmart' ),
			'checkout_content' => esc_html__( 'Checkout top content', 'woodmart' ),
		);

		$this->add_actions();
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'wd-layout', WOODMART_THEME_DIR . '/inc/modules/layouts/assets/layouts.js', array( 'jquery' ), WOODMART_VERSION, true );
		wp_enqueue_script( 'select2', WOODMART_ASSETS . '/js/select2.full.min.js', array(), WOODMART_VERSION, true );
	}

	/**
	 * Add actions.
	 */
	public function add_actions() {
		add_filter( 'views_edit-woodmart_layout', array( $this, 'print_interface' ) );
		add_filter( 'parse_query', array( $this, 'filter_layouts_by_type' ) );
		add_action(
			'manage_woodmart_layout_posts_columns',
			array(
				$this,
				'admin_columns_titles',
			)
		);
		add_action(
			'manage_woodmart_layout_posts_custom_column',
			array(
				$this,
				'admin_columns_content',
			),
			10,
			2
		);
		add_action( 'add_meta_boxes', array( $this, 'add_conditions_box' ), 10, 2 );
	}

	/**
	 * Add box.
	 *
	 * @param string  $post_type Post type.
	 * @param WP_Post $post      Post object.
	 */
	public function add_conditions_box( $post_type, $post ) {
		$type = get_post_meta( $post->ID, $this->type_meta_key, true );

		if ( 'cart' === $type || 'checkout_content' === $type || 'checkout_form' === $type ) {
			return;
		}

		add_meta_box(
			'wd-layout-conditions',
			esc_html__( 'Layout conditions', 'woodmart' ),
			array(
				$this,
				'conditions_box_callback',
			),
			'woodmart_layout'
		);
	}

	/**
	 * Box callback.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function conditions_box_callback( $post ) {
		$this->enqueue_scripts();
		$this->print_condition_template();
		echo $this->get_edit_conditions_template( $post->ID ); // phpcs:ignore
	}

	/**
	 * Get template.
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments for template.
	 */
	public function get_template( $template_name, $args = array() ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // phpcs:ignore
		}

		include WOODMART_THEMEROOT . '/inc/modules/layouts/admin/templates/' . $template_name . '.php';
	}

	/**
	 * Is current screen.
	 *
	 * @return bool
	 */
	private function is_current_screen() {
		global $pagenow, $typenow;

		return 'edit.php' === $pagenow && $this->post_type === $typenow;
	}

	/**
	 * Filter layouts by type.
	 *
	 * @param WP_Query $query Query.
	 *
	 * @return void
	 */
	public function filter_layouts_by_type( $query ) {
		if ( ! $this->is_current_screen() || ! isset( $_GET['wd_layout_type_tab'] ) || 'all' === $_GET['wd_layout_type_tab'] ) { // phpcs:ignore
			return;
		}

		$current_tab = sanitize_text_field( $_GET['wd_layout_type_tab'] ); // phpcs:ignore

		if ( 'checkout' === $current_tab ) {
			$current_tab = array( 'checkout_form', 'checkout_content' );
		}

		$query->query_vars['type_meta_key'] = $this->type_meta_key; // phpcs:ignore
		$query->query_vars['meta_value']    = $current_tab; // phpcs:ignore
	}

	/**
	 * Columns content.
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     Post id.
	 */
	public function admin_columns_content( $column_name, $post_id ) {
		if ( 'wd_layout_type' === $column_name ) {
			$type = get_post_meta( $post_id, $this->type_meta_key, true );
			$url  = add_query_arg(
				array(
					'post_type'          => $this->post_type,
					'wd_layout_type_tab' => $type,
				),
				admin_url( 'edit.php' )
			);

			?>
			<?php if ( $type && isset( $this->layout_types[ $type ] ) ) : ?>
				<a href="<?php echo esc_url( $url ); ?>">
					<?php echo esc_html( $this->layout_types[ $type ] ); ?>
				</a>
			<?php endif; ?>
			<?php
		}

		if ( 'wd_layout_conditions' === $column_name ) {
			echo $this->get_edit_conditions_template( $post_id ); // phpcs:ignore
		}
	}

	/**
	 * Columns header.
	 *
	 * @param array $posts_columns Columns.
	 *
	 * @return array
	 */
	public function admin_columns_titles( $posts_columns ) {
		$offset = 2;

		return array_slice( $posts_columns, 0, $offset, true ) + [
			'wd_layout_type'       => esc_html__( 'Type', 'elementor' ),
			'wd_layout_conditions' => esc_html__( 'Conditions', 'elementor' ),
		] + array_slice( $posts_columns, $offset, null, true );
	}

	/**
	 * Get edit conditions template.
	 *
	 * @param int $post_id Post id.
	 *
	 * @return string
	 */
	public function get_edit_conditions_template( $post_id ) {
		ob_start();

		$conditions = get_post_meta( $post_id, $this->conditions_meta_key, true );
		$type       = get_post_meta( $post_id, $this->type_meta_key, true );

		if ( 'cart' === $type || 'checkout_content' === $type || 'checkout_form' === $type ) {
			return ob_get_clean();
		}

		if ( $conditions ) {
			foreach ( $conditions as $key => $condition ) {
				if ( ! empty( $condition['condition_query'] ) ) {
					if ( 'product' === $condition['condition_type'] ) {
						$post = get_post( $condition['condition_query'] );

						$conditions[ $key ]['condition_query_text'] = $post->post_title . ' (ID: ' . $post->ID . ')';
					} elseif ( 'product_attr' === $condition['condition_type'] ) {
						$taxonomy = get_taxonomy( $condition['condition_query'] );

						$conditions[ $key ]['condition_query_text'] = $taxonomy->labels->singular_name . ' (Tax: ' . $taxonomy->name . ')';
					} else {
						$term = get_term( $condition['condition_query'] );

						$conditions[ $key ]['condition_query_text'] = $term->name . ' (ID: ' . $term->term_id . ')';
					}
				}
			}
		}

		$this->get_template(
			'edit-conditions',
			array(
				'admin'      => $this,
				'conditions' => $conditions,
				'type'       => $type,
				'post_id'    => $post_id,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Interface.
	 *
	 * @param mixed $views Default views.
	 *
	 * @return mixed
	 */
	public function print_interface( $views ) {
		$this->enqueue_scripts();

		$this->get_template( 'interface', array( 'admin' => $this ) );

		return $views;
	}

	/**
	 * Print predefined layouts.
	 */
	public function get_predefined_layouts() {
		$layouts = array(
			'shop_archive'   => array(
				'layout-1',
				'layout-2',
				'layout-3',
				'layout-4',
				'layout-5',
				'layout-6',
				'layout-7',
			),
			'single_product' => array(
				'layout-1',
				'layout-2',
				'layout-3',
				'layout-4',
				'layout-5',
				'layout-6',
				'layout-7',
				'layout-8',
				'layout-9',
			),
			'cart' => array(
				'layout-1',
				'layout-3',
			),
			'checkout_form' => array(
				'layout-1',
				'layout-2',
			),
			'checkout_content' => array(
				'layout-2',
			),
		);

		$this->get_template(
			'predefined-layouts',
			array(
				'layouts' => $layouts,
			)
		);
	}

	/**
	 * Print condition template.
	 */
	public function print_condition_template() {
		$this->get_template( 'condition' );
	}

	/**
	 * Print layout form.
	 */
	public function get_form() {
		ob_start();

		$this->get_template(
			'create-form',
			array(
				'layout_types' => $this->layout_types,
				'admin'        => $this,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Print layout tabs.
	 */
	public function print_tabs() {
		$tabs = array(
			'all' => esc_html__( 'All', 'woodmart' ),
		) + $this->layout_types + array(
			'checkout' => esc_html__( 'Checkout', 'woodmart' ),
		);

		unset( $tabs['checkout_content'] );
		unset( $tabs['checkout_form'] );

		$current_tab = 'all';

		if ( ! empty( $_GET['wd_layout_type_tab'] ) ) { // phpcs:ignore
			$current_tab = $_GET['wd_layout_type_tab']; // phpcs:ignore
		}

		if ( 'checkout_content' === $current_tab || 'checkout_form' === $current_tab ) {
			$current_tab = 'checkout';
		}

		$base_url = add_query_arg(
			array(
				'post_type' => $this->post_type,
			),
			admin_url( 'edit.php' )
		);

		$this->get_template(
			'tabs',
			array(
				'tabs'        => $tabs,
				'current_tab' => $current_tab,
				'base_url'    => $base_url,
			)
		);
	}
}

Admin::get_instance();
