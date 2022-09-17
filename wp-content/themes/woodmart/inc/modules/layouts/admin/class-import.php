<?php
/**
 * Import class file.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Plugin;
use WOODMART_Vctemplates;
use XTS\Elementor\Elementor;
use XTS\Elementor\XTS_Library_Source;

/**
 * Import class.
 */
class Import {
	/**
	 * Post ID.
	 */
	private $post_id;
	/**
	 * Layout type.
	 */
	private $layout_type;
	/**
	 * Predefined name.
	 */
	private $predefined_name;
	/**
	 * Current page builder.
	 */
	private $current_builder;

	/**
	 * Construct.
	 */
	public function __construct( $post_id, $layout_type, $predefined_name ) {
		$this->post_id         = $post_id;
		$this->layout_type     = $layout_type;
		$this->predefined_name = $predefined_name;
		$this->current_builder = woodmart_get_current_page_builder();

		if ( 'wpb' === $this->current_builder ) {
			$this->run_wpb();
		} else {
			$this->run_elementor();
		}
	}

	/**
	 * Run Elementor import.
	 */
	private function run_elementor() {
		Elementor::get_instance()->files_include();

		$elementor_library = new XTS_Library_Source();

		add_filter( 'elementor/files/allow_unfiltered_upload', '__return_true' );

		$data = json_decode( $this->get_data(), true );

		$data = $elementor_library->replace_elements_ids_public( $data );
		$data = $elementor_library->process_export_import_content_public( $data, 'on_import' );

		$document = Plugin::$instance->documents->get( $this->post_id );

		if ( $document ) {
			$data = $document->get_elements_raw_data( $data, true );
		}

		update_post_meta( $this->post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
		update_post_meta( $this->post_id, '_elementor_edit_mode', 'builder' );
		update_post_meta( $this->post_id, '_elementor_template_layout_type', 'wp-post' );
		update_post_meta( $this->post_id, '_elementor_version', '3.5.5' );
	}

	/**
	 * Run WPB import.
	 */
	private function run_wpb() {
		$vc_templates = new WOODMART_Vctemplates();
		$data         = json_decode( $this->get_data(), true );
		$config       = json_decode( $this->get_config(), true );

		$new_data = $vc_templates->get_content( $data[0], $config );

		wp_update_post( [
			'ID'           => $this->post_id,
			'post_content' => $new_data,
		] );
	}

	/**
	 * Get images config.
	 */
	public function get_config() {
		ob_start();

		$path = WOODMART_THEMEROOT . '/inc/modules/layouts/admin/predefined/' . $this->layout_type . '/' . $this->predefined_name . '/' . $this->current_builder . '/config.json';

		if ( file_exists( $path ) ) {
			include_once $path;
		}

		return ob_get_clean();
	}

	/**
	 * Get layout data.
	 */
	public function get_data() {
		ob_start();

		include_once WOODMART_THEMEROOT . '/inc/modules/layouts/admin/predefined/' . $this->layout_type . '/' . $this->predefined_name . '/' . $this->current_builder . '/data.json';

		return ob_get_clean();
	}
}
