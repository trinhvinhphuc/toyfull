<?php
/**
 * Import sliders.
 *
 * @package Woodmart
 */

namespace XTS\Import;

use Exception;
use RevSliderSliderImport;
use WP_Error;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import sliders.
 */
class Sliders {
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

		$this->import_rev_sliders();
	}

	/**
	 * Import rev sliders.
	 */
	private function import_rev_sliders() {
		if ( ! class_exists( 'RevSliderSlider' ) ) {
			return;
		}

		ob_start();

		$imported_data = get_option( 'wd_imported_data_' . $this->version );

		for ( $i = 1; $i <= 5; $i ++ ) {
			if ( 1 === $i ) {
				$slider_name = 'revslider';
			} else {
				$slider_name = 'revslider' . $i;
			}

			$file = $this->download_slider( $slider_name . '.zip', $this->version );

			if ( ! $file ) {
				continue;
			}

			$rev_api = new RevSliderSliderImport();
			$imported_data['rev_sliders'][ $slider_name . $this->version ] = $rev_api->import_slider( true, $file );
		}

		update_option( 'wd_imported_data_' . $this->version, $imported_data );

		echo ob_get_clean();
	}

	/**
	 * Download slider.
	 *
	 * @param string $filename File name.
	 * @param string $version  Version name.
	 *
	 * @return bool|string|WP_Error
	 */
	private function download_slider( $filename, $version ) {
		$file = WOODMART_DUMMY_URL . $version . '/' . $filename;

		try {
			$zip_file = download_url( $file );
			if ( is_wp_error( $zip_file ) ) {
				return false;
			}
		} catch ( Exception $e ) {
			return false;
		}

		return $zip_file;
	}
}
