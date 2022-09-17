<?php
/**
 * Import remove.
 *
 * @package Woodmart
 */

namespace XTS\Import;

use Exception;
use RevSliderFront;
use RevSliderSlider;
use XTS\Presets;
use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import remove.
 */
class Remove extends Singleton {
	/**
	 * Categories.
	 *
	 * @var array
	 */
	private $categories;
	/**
	 * Imported versions.
	 *
	 * @var array
	 */
	private $versions;
	/**
	 * $has_data_to_remove.
	 *
	 * @var array
	 */
	private $has_data_to_remove = false;

	/**
	 * Init.
	 */
	public function init() {
		$this->set_categories();

		$this->set_versions();

		add_action( 'wp_ajax_woodmart_import_remove_action', array( $this, 'remove_action' ) );
	}

	/**
	 * Set versions.
	 */
	private function set_versions() {
		$versions = woodmart_get_config( 'versions' );

		foreach ( $versions as $key => $version ) {
			$this->versions[] = $key;
		}

		$this->versions[] = 'base';
	}

	/**
	 * Remove options in no data to remove.
	 */
	public function remove_options() {
		if ( ! $this->has_data_to_remove ) {
			foreach ( $this->versions as $version ) {
				delete_option( 'wd_imported_data_' . $version );
			}
			delete_option( 'wd_import_imported_versions' );
			delete_option( 'wd_import_replaced_items' );

//			// Reset theme settings.
//			$options           = Options::get_instance();
//			$sanitized_options = $options->sanitize_before_save( array( 'reset-defaults' => true ) );
//			$options->update_options( $sanitized_options );
//
//			delete_option( 'xts-theme_settings_default-file-data' );
//			delete_option( 'xts-theme_settings_default-css-data' );
//			delete_option( 'xts-theme_settings_default-version' );
//			delete_option( 'xts-theme_settings_default-site-url' );
//			delete_option( 'xts-theme_settings_default-status' );
		}
	}

	/**
	 * Remove action.
	 */
	public function remove_action() {
		check_ajax_referer( 'woodmart-import-remove-nonce', 'security' );

		if ( ! isset( $_GET['data'] ) || ( isset( $_GET['data'] ) && ! $_GET['data'] ) ) { // phpcs:ignore
			return;
		}

		$selected_categories_raw = woodmart_clean( wp_unslash( $_GET['data'] ) ); // phpcs:ignore
		$selected_categories     = array();

		foreach ( $selected_categories_raw as $category ) {
			$selected_categories[] = $category['name'];
		}

		foreach ( $this->versions as $version ) {
			$imported_data = get_option( 'wd_imported_data_' . $version );

			if ( in_array( 'page', $selected_categories, true ) ) {
				$imported_data = $this->delete_posts( array( 'page' ), $imported_data );
				delete_option( 'wd_import_imported_versions' );
				update_option( 'wd_import_imported_versions', array( 'base' ) );

				$this->categories['page']['data'] = array();
			}

			if ( in_array( 'attachment', $selected_categories, true ) ) {
				$imported_data = $this->delete_posts( array( 'attachment' ), $imported_data );

				$this->categories['attachment']['data'] = array();
			}

			if ( in_array( 'headers', $selected_categories, true ) ) {
				$imported_data = $this->delete_headers( $imported_data );

				$this->categories['headers']['data'] = array();
			}

			if ( in_array( 'rev_sliders', $selected_categories, true ) ) {
				$imported_data = $this->delete_rev_sliders( $imported_data );

				$this->categories['rev_sliders']['data'] = array();
			}

			if ( in_array( 'woodmart_slider', $selected_categories, true ) ) {
				$imported_data = $this->delete_terms( array( 'woodmart_slider' ), $imported_data );
				$imported_data = $this->delete_posts( array( 'woodmart_slide' ), $imported_data );

				$this->categories['woodmart_slider']['data'] = array();
			}

			if ( in_array( 'post', $selected_categories, true ) ) {
				$imported_data = $this->delete_terms( array( 'category', 'post_tag' ), $imported_data );
				$imported_data = $this->delete_posts( array( 'post' ), $imported_data );

				$this->categories['post']['data'] = array();
			}

			if ( in_array( 'portfolio', $selected_categories, true ) ) {
				$imported_data = $this->delete_terms( array( 'project-cat' ), $imported_data );
				$imported_data = $this->delete_posts( array( 'portfolio' ), $imported_data );

				$this->categories['portfolio']['data'] = array();
			}

			if ( in_array( 'product', $selected_categories, true ) ) {
				$imported_data = $this->delete_terms(
					array(
						'product_cat',
						'pa_brand',
						'pa_color',
						'pa_size',
					),
					$imported_data
				);
				$imported_data = $this->delete_posts(
					array(
						'product',
						'product_variation',
						'woodmart_size_guide',
					),
					$imported_data
				);

				$this->categories['product']['data'] = array();
			}

			if ( in_array( 'cms_block', $selected_categories, true ) ) {
				$imported_data = $this->delete_posts( array( 'cms_block' ), $imported_data );

				$this->categories['cms_block']['data'] = array();
			}

			if ( in_array( 'nav_menu', $selected_categories, true ) ) {
				$imported_data = $this->delete_terms( array( 'nav_menu' ), $imported_data );
				$imported_data = $this->delete_posts( array( 'nav_menu_item' ), $imported_data );

				$this->categories['nav_menu']['data'] = array();
			}

			if ( in_array( 'mc4wp-form', $selected_categories, true ) ) {
				$imported_data = $this->delete_posts( array( 'mc4wp-form' ), $imported_data );

				$this->categories['mc4wp-form']['data'] = array();
			}

			if ( in_array( 'wpcf7_contact_form', $selected_categories, true ) ) {
				$imported_data = $this->delete_posts( array( 'wpcf7_contact_form' ), $imported_data );

				$this->categories['wpcf7_contact_form']['data'] = array();
			}

			if ( in_array( 'presets', $selected_categories, true ) ) {
				$this->delete_presets();

				$this->categories['presets']['data'] = array();
			}

			update_option( 'wd_imported_data_' . $version, $imported_data );
		}

		wp_send_json(
			array(
				'content' => $this->popup_content( true, 'remove' ),
			)
		);
	}

	/**
	 * Delete presets.
	 */
	private function delete_presets() {
		$presets = get_option( 'xts-options-presets' );

		if ( ! $presets ) {
			return;
		}

		foreach ( $presets as $preset ) {
			Presets::get_instance()->remove_preset( $preset['id'] );
		}
	}

	/**
	 * Delete rev sliders.
	 *
	 * @param array $imported_data Data.
	 *
	 * @return array
	 * @throws Exception
	 */
	private function delete_rev_sliders( $imported_data ) {
		if ( ! isset( $imported_data['rev_sliders'] ) ) {
			return $imported_data;
		}

		global $wpdb;

		foreach ( $imported_data['rev_sliders'] as $slider_name => $slider_data ) {
			if ( ! isset( $slider_data['sliderID'] ) ) {
				unset( $imported_data['rev_sliders'][ $slider_name ] );
				continue;
			}

			$slider_id   = $slider_data['sliderID'];
			$slides_data = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . RevSliderFront::TABLE_SLIDES . ' WHERE `slider_id` = %s', $slider_id ), ARRAY_A ); // phpcs:ignore

			$slides_data_static = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES . ' WHERE `slider_id` = %s', $slider_id ), ARRAY_A ); // phpcs:ignore

			if ( $slides_data_static ) {
				$slides_data = array_merge( $slides_data, $slides_data_static );
			}

			foreach ( $slides_data as $slide_data ) {
				$layers = json_decode( $slide_data['layers'], true );
				$params = json_decode( $slide_data['params'], true );

				foreach ( $layers as $layer_data ) {
					if ( isset( $layer_data['media'] ) && isset( $layer_data['media']['imageUrl'] ) ) {
						wp_delete_post( attachment_url_to_postid( $layer_data['media']['imageUrl'] ), true );
					}

					if ( isset( $layer_data['idle'] ) && isset( $layer_data['idle']['backgroundImage'] ) ) {
						wp_delete_post( attachment_url_to_postid( $layer_data['idle']['backgroundImage'] ), true );
					}
				}

				if ( isset( $params['bg'] ) && isset( $params['bg']['image'] ) ) {
					wp_delete_post( attachment_url_to_postid( $params['bg']['image'] ), true );
				}

				if ( isset( $params['thumb'] ) && isset( $params['thumb']['customThumbSrc'] ) ) {
					wp_delete_post( attachment_url_to_postid( $params['thumb']['customThumbSrc'] ), true );
				}
			}

			$revslider = new RevSliderSlider();
			$revslider->init_by_id( $slider_id );
			$revslider->delete_slider();
			unset( $imported_data['rev_sliders'][ $slider_name ] );
		}

		return $imported_data;
	}

	/**
	 * Delete headers.
	 *
	 * @param array $imported_data Data.
	 *
	 * @return array
	 */
	private function delete_headers( $imported_data ) {
		$saved_headers = get_option( 'whb_saved_headers' );

		if ( ! isset( $imported_data['headers'] ) ) {
			return $imported_data;
		}

		foreach ( $imported_data['headers'] as $key => $header_id ) {
			unset( $saved_headers[ $header_id ] );
			unset( $imported_data['headers'][ $key ] );

			delete_option( 'whb_' . $header_id );
			delete_option( 'xts-' . $header_id . '-file-data' );
			delete_option( 'xts-' . $header_id . '-css-data' );
			delete_option( 'xts-' . $header_id . '-version' );
			delete_option( 'xts-' . $header_id . '-site-url' );
			delete_option( 'xts-' . $header_id . '-status' );
			delete_option( 'xts_' . $header_id );
		}

		update_option( 'whb_saved_headers', $saved_headers );
		update_option( 'whb_main_header', 'default_header' );

		return $imported_data;
	}

	/**
	 * Delete posts.
	 *
	 * @param array $post_types    Post types to delete.
	 * @param array $imported_data Data.
	 *
	 * @return array
	 */
	private function delete_posts( $post_types, $imported_data ) {
		foreach ( $post_types as $post_type ) {
			if ( ! isset( $imported_data[ $post_type ] ) ) {
				continue;
			}

			foreach ( $imported_data[ $post_type ] as $key => $post ) {
				unset( $imported_data[ $post_type ][ $key ] );
				wp_delete_post( $post['new'], true );
			}
		}

		if ( isset( $imported_data['all_posts'] ) ) {
			foreach ( $imported_data['all_posts'] as $key => $post ) {
				if ( ! in_array( $post['post_type'], $post_types, true ) ) {
					continue;
				}

				unset( $imported_data['all_posts'][ $key ] );
			}
		}

		return $imported_data;
	}

	/**
	 * Delete terms.
	 *
	 * @param array $taxonomies    Tax to delete.
	 * @param array $imported_data Data.
	 *
	 * @return array
	 */
	private function delete_terms( $taxonomies, $imported_data ) {
		if ( ! isset( $imported_data['term'] ) ) {
			return $imported_data;
		}

		foreach ( $imported_data['term'] as $taxonomy => $data ) {
			if ( ! in_array( $taxonomy, $taxonomies, true ) ) {
				continue;
			}

			foreach ( $data as $term ) {
				unset( $imported_data['term'][ $taxonomy ][ $term['old'] ] );
				wp_delete_term( $term['new'], $taxonomy );
			}
		}

		return $imported_data;
	}

	/**
	 * Interface.
	 */
	public function interface() {
		?>
		<div class="xts-popup-holder wd-import-remove">
			<a href="#" class="xts-popup-opener wd-import-remove-opener xts-bordered-btn xts-color-white dashicons-trash">
				<?php esc_html_e( 'Remove content', 'woodmart' ); ?>
			</a>

			<div class="xts-popup-overlay"></div>

			<div class="xts-popup">
				<div class="xts-popup-inner">
					<div class="xts-popup-header">
						<div class="xts-popup-title">
							<?php esc_html_e( 'Remove content', 'woodmart' ); ?>
						</div>

						<a href="" class="xts-popup-close">
							<?php esc_html_e( 'Close', 'woodmart' ); ?>
						</a>
					</div>

					<div class="xts-popup-content wd-import-remove-content ">
						<div class="xts-import-notices xts-import-remove-notices"></div>

						<div class="wd-import-remove-form-wrap">
							<?php $this->popup_content( false, 'import' ); ?>
						</div>
					</div>

					<div class="xts-popup-actions"></div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Popup content.
	 *
	 * @param bool   $ajax   In AJAX.
	 * @param string $action Action name.
	 *
	 * @return false|string|void
	 */
	public function popup_content( $ajax, $action ) {
		$this->set_categories_data();
		$this->remove_options();

		$attrs = '';

		if ( 'import' === $action ) {
			$attrs .= ' checked';
		}

		if ( $ajax ) {
			ob_start();
		}

		?>
		<form class="wd-import-remove-form" method="post" action="#">
			<div class="wd-import-select-btns">
				<button class="wd-import-remove-select xts-inline-btn dashicons-insert">
					<?php esc_html_e( 'Check all', 'woodmart' ); ?>
				</button>

				<button class="wd-import-remove-deselect xts-inline-btn dashicons-remove">
					<?php esc_html_e( 'Uncheck all', 'woodmart' ); ?>
				</button>
			</div>

			<?php foreach ( $this->categories as $key => $category ) : ?>
				<?php
				$count = (int) count( $category['data'] );

				$loop_attrs = '';

				if ( 0 === $count ) {
					$loop_attrs .= ' disabled';
				} else {
					$loop_attrs .= $attrs;
				}

				?>
				<div class="wd-import-remove-items">
					<input type="checkbox" <?php echo esc_attr( $loop_attrs ); ?> name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>">

					<label for="<?php echo esc_attr( $key ); ?>">
						<?php echo esc_html( $category['title'] ); ?>
						<span><?php echo esc_html( '(' . $count . ')' ); ?></span>
					</label>
				</div>
			<?php endforeach; ?>

			<div class="xts-loader">
				<div class="xts-loader-el"></div>
				<div class="xts-loader-el"></div>
			</div>

			<div class="wd-import-remove-alert">
				<p>
					<?php echo wp_kses( __( '<strong>Warning</strong>. You are going to completely delete the dummy content imported with our theme. This process cannot be undone. Any changes you made in import pages, posts, or products will be lost.', 'woodmart' ), woodmart_get_allowed_html() ); ?>
				</p>

				<button type="submit" class="wd-import-remove-btn xts-btn xts-color-warning dashicons-trash">
					<?php esc_html_e( 'Remove', 'woodmart' ); ?>
				</button>
			</div>
		</form>

		<div class="wd-import-remove-img">
			<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/wd-import-image.jpg' ); ?>" alt="<?php esc_attr_e( 'Remove image', 'woodmart' ); ?>">
		</div>
		<?php
		if ( $ajax ) {
			return ob_get_clean();
		}
	}

	/**
	 * Has data to remove.
	 *
	 * @return array|bool
	 */
	public function has_data_to_remove() {
		$this->set_categories_data();

		return $this->has_data_to_remove;
	}

	/**
	 * Set categories.
	 */
	private function set_categories() {
		$this->categories = array(
			'page'               => array(
				'title' => esc_html__( 'Pages', 'woodmart' ),
				'data'  => array(),
			),
			'rev_sliders'        => array(
				'title' => esc_html__( 'Revolution sliders', 'woodmart' ),
				'data'  => array(),
			),
			'product'            => array(
				'title' => esc_html__( 'Products', 'woodmart' ),
				'data'  => array(),
			),
			'mc4wp-form'         => array(
				'title' => esc_html__( 'Mailchimp forms', 'woodmart' ),
				'data'  => array(),
			),
			'post'               => array(
				'title' => esc_html__( 'Posts', 'woodmart' ),
				'data'  => array(),
			),
			'woodmart_slider'    => array(
				'title' => esc_html__( 'Woodmart sliders', 'woodmart' ),
				'data'  => array(),
			),
			'portfolio'          => array(
				'title' => esc_html__( 'Projects', 'woodmart' ),
				'data'  => array(),
			),
			'presets'            => array(
				'title' => esc_html__( 'Settings presets', 'woodmart' ),
				'data'  => array(),
			),
			'cms_block'          => array(
				'title' => esc_html__( 'HTML blocks', 'woodmart' ),
				'data'  => array(),
			),
			'headers'            => array(
				'title' => esc_html__( 'Headers', 'woodmart' ),
				'data'  => array(),
			),
			'attachment'         => array(
				'title' => esc_html__( 'Images', 'woodmart' ),
				'data'  => array(),
			),
			'nav_menu'           => array(
				'title' => esc_html__( 'Menu', 'woodmart' ),
				'data'  => array(),
			),
			'wpcf7_contact_form' => array(
				'title' => esc_html__( 'Contact forms', 'woodmart' ),
				'data'  => array(),
			),
		);
	}

	/**
	 * Set counts.
	 */
	private function set_categories_data() {
		$presets = get_option( 'xts-options-presets' );
		if ( $presets ) {
			$this->has_data_to_remove            = true;
			$this->categories['presets']['data'] = get_option( 'xts-options-presets' );
		}

		foreach ( $this->versions as $version ) {
			$imported_data = get_option( 'wd_imported_data_' . $version );

			if ( ! empty( $imported_data['term']['nav_menu'] ) ) {
				$this->has_data_to_remove             = true;
				$this->categories['nav_menu']['data'] = $this->categories['nav_menu']['data'] + $imported_data['term']['nav_menu'];
			}

			if ( ! empty( $imported_data['page'] ) ) {
				$this->has_data_to_remove         = true;
				$this->categories['page']['data'] = $this->categories['page']['data'] + $imported_data['page'];
			}

			if ( ! empty( $imported_data['attachment'] ) ) {
				$this->has_data_to_remove               = true;
				$this->categories['attachment']['data'] = $this->categories['attachment']['data'] + $imported_data['attachment'];
			}

			if ( ! empty( $imported_data['headers'] ) ) {
				$this->has_data_to_remove            = true;
				$this->categories['headers']['data'] = $this->categories['headers']['data'] + $imported_data['headers'];
			}

			if ( ! empty( $imported_data['rev_sliders'] ) ) {
				$this->has_data_to_remove                = true;
				$this->categories['rev_sliders']['data'] = $this->categories['rev_sliders']['data'] + $imported_data['rev_sliders'];
			}

			if ( ! empty( $imported_data['term']['woodmart_slider'] ) ) {
				$this->has_data_to_remove                    = true;
				$this->categories['woodmart_slider']['data'] = $this->categories['woodmart_slider']['data'] + $imported_data['term']['woodmart_slider'];
			}

			if ( ! empty( $imported_data['post'] ) ) {
				$this->has_data_to_remove         = true;
				$this->categories['post']['data'] = $this->categories['post']['data'] + $imported_data['post'];
			}

			if ( ! empty( $imported_data['portfolio'] ) ) {
				$this->has_data_to_remove              = true;
				$this->categories['portfolio']['data'] = $this->categories['portfolio']['data'] + $imported_data['portfolio'];
			}

			if ( ! empty( $imported_data['product'] ) ) {
				$this->has_data_to_remove            = true;
				$this->categories['product']['data'] = $this->categories['product']['data'] + $imported_data['product'];
			}

			if ( ! empty( $imported_data['cms_block'] ) ) {
				$this->has_data_to_remove              = true;
				$this->categories['cms_block']['data'] = $this->categories['cms_block']['data'] + $imported_data['cms_block'];
			}

			if ( ! empty( $imported_data['mc4wp-form'] ) ) {
				$this->has_data_to_remove               = true;
				$this->categories['mc4wp-form']['data'] = $this->categories['mc4wp-form']['data'] + $imported_data['mc4wp-form'];
			}

			if ( ! empty( $imported_data['wpcf7_contact_form'] ) ) {
				$this->has_data_to_remove                       = true;
				$this->categories['wpcf7_contact_form']['data'] = $this->categories['wpcf7_contact_form']['data'] + $imported_data['wpcf7_contact_form'];
			}
		}
	}
}

Remove::get_instance();
