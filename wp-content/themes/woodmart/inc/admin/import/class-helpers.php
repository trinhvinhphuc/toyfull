<?php
/**
 * Import helpers.
 *
 * @package Woodmart
 */

namespace XTS\Import;

use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import helpers.
 */
class Helpers extends Singleton {
	/**
	 * Links to replace.
	 *
	 * @var array
	 */
	public $links = array(
		'uploads' => array(
			'http://dummy.xtemos.com/woodmart2/wp-content/uploads/',
			'https://dummy.xtemos.com/woodmart2/wp-content/uploads/',
			'http://woodmart.xtemos.com/wp-content/uploads/',
			'https://woodmart.xtemos.com/wp-content/uploads/',
			'http://dummy.xtemos.com/woodmart2/elementor/wp-content/uploads/sites/2/',
			'https://dummy.xtemos.com/woodmart2/elementor/wp-content/uploads/sites/2/',
		),
		'simple'  => array(
			'http://dummy.xtemos.com/woodmart2/elementor/',
			'https://dummy.xtemos.com/woodmart2/elementor/',
			'http://dummy.xtemos.com/woodmart2/',
			'https://dummy.xtemos.com/woodmart2/',
			'https://woodmart.xtemos.com/',
			'http://woodmart.xtemos.com/',
		),
	);

	/**
	 * Init.
	 */
	public function init() {
	}

	/**
	 * Send error.
	 *
	 * @param string $message Message.
	 */
	public function send_error_message( $message ) {
		$this->send_message( 'error', $message );
	}

	/**
	 * Send success.
	 *
	 * @param string $message Message.
	 */
	public function send_success_message( $message ) {
		$this->send_message( 'success', $message );
	}

	/**
	 * Send message.
	 *
	 * @param string $status  Status.
	 * @param string $message Message.
	 */
	public function send_message( $status, $message ) {
		echo wp_json_encode(
			array(
				'status'  => $status,
				'message' => $message,
			)
		);
	}

	/**
	 * Get file data.
	 *
	 * @param string $path File path.
	 *
	 * @return false|string
	 */
	public function get_local_file_content( $path ) {
		ob_start();
		include $path;

		return ob_get_clean();
	}

	/**
	 * Get file path.
	 *
	 * @param string $file_name File name.
	 * @param string $version   Version name.
	 *
	 * @return false|string
	 */
	public function get_file_path( $file_name, $version ) {
		$file = $this->get_version_folder_path( $version ) . $file_name;

		if ( ! file_exists( $file ) ) {
			return false;
		}

		return $file;
	}

	/**
	 * Get version folder path.
	 *
	 * @param string $version Version name.
	 *
	 * @return string
	 */
	public function get_version_folder_path( $version ) {
		return WOODMART_THEMEROOT . '/inc/admin/import/dummy-data/' . $version . '/';
	}

	/**
	 * Replace link.
	 *
	 * @since 1.0.0
	 *
	 * @param string $data    Data.
	 * @param string $replace Replace.
	 *
	 * @return string|string[]
	 */
	public function links_replace( $data, $replace = '\/' ) {
		$links = $this->links;

		foreach ( $links as $key => $value ) {
			if ( 'uploads' === $key ) {
				foreach ( $value as $link ) {
					$url_data = wp_upload_dir();
					$data     = str_replace( str_replace( '/', $replace, $link ), str_replace( '/', $replace, $url_data['baseurl'] . '/' ), $data );
				}
			}

			if ( 'simple' === $key ) {
				foreach ( $value as $link ) {
					$data = str_replace( str_replace( '/', $replace, $link ), str_replace( '/', $replace, get_home_url() . '/' ), $data );
				}
			}
		}

		return $data;
	}

	/**
	 * Get imported data.
	 *
	 * @since 1.0.0
	 *
	 * @param string $version Version name.
	 *
	 * @return array
	 */
	public function get_imported_data( $version ) {
		$base = get_option( 'wd_imported_data_base' );

		if ( 'base' === $version ) {
			return $base;
		}

		$demo = get_option( 'wd_imported_data_' . $version );

		if ( $demo && $base ) {
			return array_replace_recursive( $base, $demo );
		} else {
			return array();
		}
	}
}
