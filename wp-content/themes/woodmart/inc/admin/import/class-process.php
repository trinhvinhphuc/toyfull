<?php
/**
 * Import process.
 *
 * @package Woodmart
 */

namespace XTS\Import;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import process.
 */
class Process {
	/**
	 * Available versions.
	 *
	 * @var $version_list
	 */
	private $version_list;
	/**
	 * Current version.
	 *
	 * @var $version
	 */
	private $version;
	/**
	 * Current process.
	 *
	 * @var $version
	 */
	private $current_process;
	/**
	 * Is version imported.
	 *
	 * @var bool
	 */
	private $is_version_imported;

	/**
	 * Constructor.
	 *
	 * @param string $version Version slug.
	 */
	public function __construct( $version, $current_process ) {
		$this->version             = $version;
		$this->current_process     = $current_process;
		$this->version_list        = woodmart_get_config( 'versions' );
		$this->is_version_imported = $this->is_version_imported();

		$this->run_import();
	}

	/**
	 * Run import.
	 */
	public function run_import() {
		if ( $this->need_process( 'xml' ) && ! $this->is_version_imported && 'xml' === $this->current_process ) {
			if ( 'base' === $this->version ) {
				Before::get_instance();
			}

			new XML( $this->version, 'posts' );
		}

		if ( $this->need_process( 'xml_images' ) && ! $this->is_version_imported && strpos(
			$this->current_process, 'images' ) !== false ) {
			new XML( $this->version, $this->current_process );
		}

		if ( 'other' === $this->current_process ) {
			if ( $this->need_process( 'widgets' ) ) {
				new Widgets( $this->version );
			}

			if ( $this->need_process( 'sliders' ) && ! $this->is_version_imported ) {
				new Sliders( $this->version );
			}

			if ( $this->need_process( 'options' ) ) {
				new Options( $this->version );
			}

			if ( $this->need_process( 'headers' ) && ! $this->is_version_imported ) {
				new Headers( $this->version );
			}

			if ( $this->need_process( 'home' ) ) {
				new Menu( $this->version );
			}

			if ( $this->need_process( 'images' ) ) {
				new Images( $this->version );
			}

			$import_after = After::get_instance();

			if ( 'base' === $this->version ) {
				$import_after->set_menu_locations();
				$import_after->set_blog_page();
				$import_after->enable_wpb_on_custom_post_types();
				$import_after->enable_elementor_on_custom_post_types();
				$import_after->show_all_fields_menu();
				$import_after->enable_myaccount_registration();
				$import_after->update_product_lookup_tables();
				$import_after->set_pages_sidebar();
				$import_after->wc_remove_uncategorized_cat();
			}

			$import_after->replace_db_urls();

			$imported_versions   = get_option( 'wd_import_imported_versions', array() );
			$imported_versions[] = $this->version;

			update_option( 'wd_import_imported_versions', $imported_versions );
			update_option( 'wd_import_theme_version', woodmart_get_theme_info( 'Version' ) );
			update_option( 'woodmart_setup_status', 'done' );

			if ( 'version' === $this->version_list[ $this->version ]['type'] ) {
				update_option( 'wd_import_current_version', $this->version );
			}

			$import_after->change_header_on_pages();
		}
	}

	/**
	 * Is need process.
	 *
	 * @param string $process Process name.
	 *
	 * @return bool
	 */
	private function need_process( $process ) {
		return in_array( $process, explode( ',', $this->version_list[ $this->version ]['process'] ), true );
	}

	/**
	 * Is version imported.
	 *
	 * @return bool
	 */
	private function is_version_imported() {
		$imported_versions = get_option( 'wd_import_imported_versions', array() );
		$imported_data     = get_option( 'wd_imported_data_' . $this->version );

		return in_array( $this->version, $imported_versions, true ) && ! empty( $imported_data['page'] );
	}
}
