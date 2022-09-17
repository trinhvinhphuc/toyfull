<?php
/**
 * Import headers.
 *
 * @package Woodmart
 */

namespace XTS\Import;

use Exception;
use WOODMART_Header_Builder;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import headers.
 */
class Headers {
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

		$this->import_headers();
	}

	/**
	 * Import rev sliders.
	 */
	private function import_headers() {
		try {
			for ( $i = 1; $i <= 5; $i ++ ) {
				$header = $this->helpers->get_file_path( 'header-' . $i . '.json', $this->version );

				if ( 'elementor' === woodmart_get_current_page_builder() && file_exists( $this->helpers->get_version_folder_path( $this->version ) . 'header-' . $i . '-elementor.json' ) ) {
					$header = $this->helpers->get_file_path( 'header-' . $i . '-elementor.json', $this->version );
				}

				if ( $header ) {
					$this->create_new_header( $header, 1 === $i );
				}
			}
		} catch ( Exception $e ) {
			echo esc_html( '[ERROR] Header import<br>' );
		}
	}

	/**
	 * Create new header.
	 *
	 * @param string $file    File.
	 * @param bool   $default Default header.
	 */
	private function create_new_header( $file, $default = false ) {
		$builder       = WOODMART_Header_Builder::get_instance();
		$imported_data = get_option( 'wd_imported_data_' . $this->version );

		$header_data = $this->helpers->links_replace( $this->helpers->get_local_file_content( $file ), '/' );
		$header_data = $this->update_html_block_id( $header_data );

		$header_data = json_decode( $header_data, true );

		$builder->list->add_header( $header_data['id'], $header_data['name'] );
		$builder->factory->create_new( $header_data['id'], $header_data['name'], $header_data['structure'], $header_data['settings'] );

		$imported_data['headers'][ $header_data['id'] ] = $header_data['id'];

		update_option( 'wd_imported_data_' . $this->version, $imported_data );

		if ( $default ) {
			update_option( 'whb_main_header', $header_data['id'] );
		}
	}

	/**
	 * Update html block id in header.
	 *
	 * @param string $header_data Header data.
	 *
	 * @return string
	 */
	private function update_html_block_id( $header_data ) {
		$header_data_decoded = json_decode( $header_data, true );
		$imported_data       = $this->helpers->get_imported_data( $this->version );

		foreach ( $header_data_decoded['structure']['content'] as $row ) {
			foreach ( $row['content'] as $column ) {
				foreach ( $column['content'] as $element ) {
					if ( 'HTMLBlock' === $element['type'] ) {
						$current_id = $element['params']['block_id']['value'];
						$new_id     = '';

						if ( isset( $imported_data['all_posts'][ $current_id ]['new'] ) ) {
							$new_id = $imported_data['all_posts'][ $current_id ]['new'];
						}

						if ( $new_id ) {
							$header_data = str_replace( '"value": "' . $current_id . '"', '"value": "' . $new_id . '"', $header_data );
						}
					}

					if ( ( 'logo' === $element['type'] || 'infobox' === $element['type'] ) && ! empty( $element['params']['image']['value'] ) ) {
						$current_id = $element['params']['image']['value']['id'];
						$new_id     = '';

						if ( isset( $imported_data['all_posts'][ $current_id ]['new'] ) ) {
							$new_id = $imported_data['all_posts'][ $current_id ]['new'];
						}

						if ( $new_id ) {
							$header_data = str_replace( '"id": ' . $current_id, '"id": ' . $new_id, $header_data );
						}
					}
				}
			}
		}

		return $header_data;
	}
}
