<?php
/**
 * Import widgets.
 *
 * @package Woodmart
 */

namespace XTS\Import;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import widgets.
 */
class Widgets {
	/**
	 * Active widgets.
	 *
	 * @var array
	 */
	private $active_widgets;
	/**
	 * Widgets counter.
	 *
	 * @var int
	 */
	private $widgets_counter = 1;
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
	 * Constructor.
	 *
	 * @param string $version Version name.
	 */
	public function __construct( $version ) {
		$this->helpers = Helpers::get_instance();
		$this->version = $version;

		$this->import_widgets();
	}

	/**
	 * Import widgets.
	 */
	private function import_widgets() {
		$file_path = $this->helpers->get_file_path( 'widgets.json', $this->version );

		if ( 'elementor' === woodmart_get_current_page_builder() && file_exists( $this->helpers->get_version_folder_path( $this->version ) . 'widgets-elementor.json' ) ) {
			$file_path = $this->helpers->get_file_path( 'widgets-elementor.json', $this->version );
		}

		if ( ! $file_path ) {
			return;
		}

		$widgets_data = $this->helpers->get_local_file_content( $file_path );
		$widgets_data = $this->helpers->links_replace( $widgets_data );
		$widgets_data = $this->widgets_replace_html_block_and_menu_ids( $widgets_data );

		$widgets_data = json_decode( $widgets_data, true );

		$this->active_widgets = get_option( 'sidebars_widgets' );

		foreach ( $widgets_data as $area => $params ) {
			$this->clear_widget_area( $area );

			foreach ( $params['widgets'] as $widget => $args ) {
				$widget = preg_replace( '/-[0-9]+$/', '', $widget );

				$this->add_widget( $area, $widget, $args );
			}
		}

		update_option( 'sidebars_widgets', $this->active_widgets );
	}

	/**
	 * Add widget to area.
	 *
	 * @param string $sidebar Sidebar area name.
	 * @param string $widget  Widget name.
	 * @param array  $options Widget options.
	 */
	private function add_widget( $sidebar, $widget, $options = array() ) {
		$this->active_widgets[ $sidebar ][] = $widget . '-' . $this->widgets_counter;

		$widget_content = get_option( 'widget_' . $widget );

		$widget_content[ $this->widgets_counter ] = $options;

		update_option( 'widget_' . $widget, $widget_content );

		$this->widgets_counter ++;
	}

	/**
	 * Clear widget area.
	 *
	 * @param string $area Sidebar area name.
	 */
	private function clear_widget_area( $area ) {
		unset( $this->active_widgets[ $area ] );
	}

	/**
	 * Widgets replace html block and menu ids.
	 *
	 * @param string $widgets_data Widgets data.
	 */
	private function widgets_replace_html_block_and_menu_ids( $widgets_data ) {
		$widgets_data  = json_decode( $widgets_data, true );
		$imported_data = $this->helpers->get_imported_data( $this->version );

		foreach ( $widgets_data as $area_name => $area_settings ) {
			foreach ( $area_settings['widgets'] as $widget_name => $widget_settings ) {
				if ( strstr( $widget_name, 'woodmart-html-block' ) ) {
					$current_id = $widget_settings['id'];
					$new_id     = '';

					if ( isset( $imported_data['all_posts'][ $current_id ]['new'] ) && $imported_data['all_posts'][ $current_id ]['new'] ) {
						$new_id = $imported_data['all_posts'][ $current_id ]['new'];
					}

					if ( $new_id ) {
						$widgets_data[ $area_name ]['widgets'][ $widget_name ]['id'] = $new_id;
					}
				}

				if ( strstr( $widget_name, 'woodmart-author-information' ) || strstr( $widget_name, 'woodmart-banner' ) ) {
					$current_id = $widget_settings['image'];
					$new_id     = '';

					if ( isset( $imported_data['attachment'][ $current_id ]['new'] ) && $imported_data['attachment'][ $current_id ]['new'] ) {
						$new_id = $imported_data['attachment'][ $current_id ]['new'];
					}

					if ( $new_id ) {
						$widgets_data[ $area_name ]['widgets'][ $widget_name ]['image'] = $new_id;
					}
				}

				if ( strstr( $widget_name, 'nav_menu' ) ) {
					$current_id = $widget_settings['nav_menu'];
					$new_id     = '';

					if ( isset( $imported_data['term']['nav_menu'][ $current_id ]['new'] ) && $imported_data['term']['nav_menu'][ $current_id ]['new'] ) {
						$new_id = $imported_data['term']['nav_menu'][ $current_id ]['new'];
					}

					if ( $new_id ) {
						$widgets_data[ $area_name ]['widgets'][ $widget_name ]['nav_menu'] = $new_id;
					}
				}

				if ( strstr( $widget_name, 'woodmart-instagram' ) ) {
					$images        = explode( ',', $widget_settings['images'] );
					$images_output = array();

					foreach ( $images as $image_id ) {
						if ( ! $image_id ) {
							continue;
						}

						if ( isset( $imported_data['attachment'][ $image_id ]['new'] ) && $imported_data['attachment'][ $image_id ]['new'] ) {
							$images_output[] = $imported_data['attachment'][ $image_id ]['new'];
						} else {
							$images_output[] = $image_id;
						}
					}

					$widgets_data[ $area_name ]['widgets'][ $widget_name ]['images'] = implode( ',', $images_output );
				}
			}
		}

		return wp_json_encode( $widgets_data );
	}
}
