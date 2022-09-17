<?php
/**
 * Patch apply.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Patcher;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Patch apply.
 */
class Patch {
	/**
	 * Patch ID.
	 *
	 * @var $patcher_id
	 */
	public $patch_id;

	/**
	 * Server uri.
	 *
	 * @var $server_api
	 */
	private $remote_file_uri = 'https://xtemos.com/wp-json/xts/v1/file/';

	/**
	 * Flag successfully write files.
	 *
	 * @var $successful_write_files
	 */
	private $successful_write_files = true;

	/**
	 * Constructor.
	 *
	 * @param string $patch_id Patch id.
	 */
	public function __construct( $patch_id ) {
		$this->patch_id = $patch_id;

		$this->apply();
	}

	/**
	 * Apply patch.
	 */
	public function apply() {
		$patches_map = Client::get_instance()->get_patches_maps();

		if ( ! isset( $patches_map[ $this->patch_id ] ) ) {
			wp_send_json(
				array(
					'message' => esc_html__( 'Patch with this ID does\'t exist.', 'woodmart' ),
					'status'  => 'error',
				)
			);
		}

		$patch = $patches_map[ $this->patch_id ];

		foreach ( $patch['files'] as $key => $file_dir ) {
			$content = $this->get_patch_file_from_server( $key );

			if ( ! $content ) {
				$this->successful_write_files = false;
				continue;
			}

			$this->write_file( $file_dir, $content );
		}

		if ( $this->successful_write_files ) {
			$patch_success = get_option( 'xts_successfully_installed_patches' );

			$patch_success[ WOODMART_VERSION ][ $this->patch_id ] = true;

			update_option( 'xts_successfully_installed_patches', $patch_success );

			wp_send_json(
				array(
					'message' => esc_html__( 'Patch has been successfully applied.', 'woodmart' ),
					'status'  => 'success',
				)
			);
		}

		wp_send_json(
			array(
				'message' => esc_html__( 'Something went wrong during patch installation. Patch can\'t be applied. Please, try again later.', 'woodmart' ),
				'status'  => 'error',
			)
		);
	}

	/**
	 * Write file.
	 *
	 * @param string $file_dir File directory.
	 * @param string $content  File content.
	 */
	public function write_file( $file_dir, $content ) {
		global $wp_filesystem;

		if ( function_exists( 'WP_Filesystem' ) ) {
			WP_Filesystem();
		}

		$target = get_template_directory() . wp_normalize_path( '/' . $file_dir );

		$status_write_file = $wp_filesystem->put_contents( $target, $content );

		if ( ! $status_write_file ) {
			$this->successful_write_files = false;
		}
	}

	/**
	 * Queries the patches server for a list of patches.
	 *
	 * @param int $key Key file.
	 *
	 * @return string
	 */
	private function get_patch_file_from_server( $key ) {
		$url = add_query_arg(
			array(
				'patch' => $this->patch_id,
				'file'  => $key,
			),
			$this->remote_file_uri
		);

		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			wp_send_json(
				array(
					'message' => $response->get_error_message(),
					'status'  => 'error',
				)
			);
		}

		if ( ! isset( $response['body'] ) ) {
			wp_send_json(
				array(
					'message' => $response['response']['code'] . ': ' . $response['response']['message'],
					'status'  => 'error',
				)
			);
		}

		$response = json_decode( $response['body'], true );

		if ( isset( $response_body['code'] ) && isset( $response_body['message'] ) ) {
			wp_send_json(
				array(
					'message' => $response_body['message'],
					'status'  => 'error',
				)
			);
		}

		if ( isset( $response_body['type'] ) && isset( $response_body['message'] ) ) {
			wp_send_json(
				array(
					'message' => $response_body['message'],
					'status'  => $response_body['type'],
				)
			);
		}

		if ( ! isset( $response['content'] ) ) {
			return '';
		}

		return $response['content'];
	}
}
