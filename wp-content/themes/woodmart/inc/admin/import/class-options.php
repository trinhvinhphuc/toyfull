<?php
/**
 * Import options.
 *
 * @package Woodmart
 */

namespace XTS\Import;

use XTS\Options as ThemeSettingsOptions;
use XTS\Presets;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import options.
 */
class Options {
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

		if ( 'base' === $this->version ) {
			$this->import_presets();
			$this->import_options_presets();
		}

		$this->import_options();
	}

	/**
	 * Import options presets.
	 */
	private function import_options_presets() {
		global $xts_woodmart_options;

		$file = $this->helpers->get_file_path( 'options_presets.json', $this->version );

		if ( 'elementor' === woodmart_get_current_page_builder() && file_exists( $this->helpers->get_version_folder_path( $this->version ) . 'options_presets-elementor.json' ) ) {
			$file = $this->helpers->get_file_path( 'options_presets-elementor.json', $this->version );
		}

		if ( ! $file ) {
			return;
		}

		$new_options_json = $this->helpers->links_replace( $this->helpers->get_local_file_content( $file ) );

		$new_options = $xts_woodmart_options + json_decode( $new_options_json, true );

		$options = ThemeSettingsOptions::get_instance();

		$pseudo_post_data = array(
			'import-btn'    => true,
			'import_export' => wp_json_encode( $new_options ),
		);

		$sanitized_options = $options->sanitize_before_save( $pseudo_post_data );

		$options->update_options( $sanitized_options );
	}

	/**
	 * Import presets.
	 */
	private function import_presets() {
		$file = $this->helpers->get_file_path( 'presets.json', $this->version );

		if ( 'elementor' === woodmart_get_current_page_builder() && file_exists( $this->helpers->get_version_folder_path( $this->version ) . 'presets-elementor.json' ) ) {
			$file = $this->helpers->get_file_path( 'presets-elementor.json', $this->version );
		}

		if ( ! $file ) {
			return;
		}

		$presets = json_decode( $this->helpers->get_local_file_content( $file ), true );

		update_option( 'xts-options-presets', $presets );

		Presets::get_instance()->load_presets();
	}

	/**
	 * Import options.
	 */
	private function import_options() {
		global $xts_woodmart_options;

		$version_list = woodmart_get_config( 'versions' );
		$file         = $this->helpers->get_file_path( 'options.json', $this->version );

		if ( 'elementor' === woodmart_get_current_page_builder() && file_exists( $this->helpers->get_version_folder_path( $this->version ) . 'options-elementor.json' ) ) {
			$file = $this->helpers->get_file_path( 'options-elementor.json', $this->version );
		}

		if ( ! $file ) {
			return;
		}

		$new_options_json = $this->helpers->links_replace( $this->helpers->get_local_file_content( $file ) );

		$options = ThemeSettingsOptions::get_instance();

		// Merge new options with new resetting values.
		$version_type = $version_list[ $this->version ]['type'];
		$new_options  = json_decode( $new_options_json, true ) + $this->get_reset_options( $version_type );

		// Set builder to WPB or Elementor.
		$xts_woodmart_options['variation_gallery_storage_method'] = 'new';
		$xts_woodmart_options['old_elements_classes']             = false;

		// Merge new options with other existed ones.
		$new_options = $new_options + $xts_woodmart_options;

		$pseudo_post_data = array(
			'import-btn'    => true,
			'import_export' => wp_json_encode( $new_options ),
		);

		$sanitized_options = $options->sanitize_before_save( $pseudo_post_data );

		$options->update_options( $sanitized_options );

		// Dynamic css options.
		foreach ( Presets::get_all() as $preset ) {
			delete_option( 'xts-theme_settings_' . $preset['id'] . '-file-data' );
			delete_option( 'xts-theme_settings_' . $preset['id'] . '-css-data' );
			delete_option( 'xts-theme_settings_' . $preset['id'] . '-version' );
			delete_option( 'xts-theme_settings_' . $preset['id'] . '-site-url' );
			delete_option( 'xts-theme_settings_' . $preset['id'] . '-status' );
			delete_option( 'xts-theme_settings_' . $preset['id'] . '-credentials' );
		}

		delete_option( 'xts-theme_settings_default-file-data' );
		delete_option( 'xts-theme_settings_default-css-data' );
		delete_option( 'xts-theme_settings_default-version' );
		delete_option( 'xts-theme_settings_default-site-url' );
		delete_option( 'xts-theme_settings_default-status' );
		delete_option( 'xts-theme_settings_default-credentials' );

		$this->theme_settings_replace_post_ids();
	}

	/**
	 * Get reset options.
	 *
	 * @param string $version_type Version type.
	 *
	 * @return array
	 */
	private function get_reset_options( $version_type ) {
		$reset_options      = array();
		$version_type       = 'base' === $version_type ? 'version' : $version_type;
		$reset_options_keys = woodmart_get_config( 'reset-options-' . $version_type );

		foreach ( $reset_options_keys as $opt ) {
			$reset_options[ $opt ] = $this->get_default_option_value( $opt );
		}

		return $reset_options;
	}

	/**
	 * Get default options value.
	 *
	 * @param string $key Opt key.
	 *
	 * @return mixed|string
	 */
	private function get_default_option_value( $key ) {
		$all_fields = ThemeSettingsOptions::get_fields();

		foreach ( $all_fields as $field ) {
			if ( $field->args['id'] === $key ) {
				return isset( $field->args['default'] ) ? $field->args['default'] : '';
			}
		}

		return '';
	}

	/**
	 * Theme settings replace posts ids.
	 */
	private function theme_settings_replace_post_ids() {
		$imported_data = $this->helpers->get_imported_data( $this->version );
		$theme_options = get_option( 'xts-woodmart-options' );

		$theme_options = $this->options_with_attachment( $theme_options, $imported_data );
		$theme_options = $this->options_with_post_id( $theme_options, $imported_data );
		$theme_options = $this->options_with_custom_fonts( $theme_options, $imported_data );

		update_option( 'xts-woodmart-options', $theme_options );
	}

	/**
	 * Replace options with attachment.
	 *
	 * @param array $theme_options Options.
	 * @param array $imported_data Data.
	 */
	private function options_with_attachment( $theme_options, $imported_data ) {
		$options_with_attachment = array(
			'title-background',
			'body-background',
			'pages-background',
			'shop-background',
			'product-background',
			'blog-background',
			'blog-post-background',
			'portfolio-background',
			'portfolio-project-background',
			'footer-bar-bg',
			'age_verify_background',
			'popup-background',
			'header_banner_bg',
			'white_label_options_logo',
			'white_label_sidebar_icon_logo',
			'white_label_dashboard_logo',
			'white_label_appearance_screenshot',
			'link_1_icon',
			'link_2_icon',
			'link_3_icon',
			'link_4_icon',
			'link_5_icon',
			'lazy_custom_placeholder',
			'preloader_image',
		);

		foreach ( $options_with_attachment as $option_name ) {
			if ( isset( $theme_options[ $option_name ]['id'] ) && $theme_options[ $option_name ]['id'] ) {
				$current_id = $theme_options[ $option_name ]['id'];
				$new_id     = '';

				if ( isset( $imported_data['attachment'][ $current_id ]['new'] ) && $imported_data['attachment'][ $current_id ]['new'] ) {
					$new_id = $imported_data['attachment'][ $current_id ]['new'];
				}

				if ( $new_id ) {
					$theme_options[ $option_name ]['id']  = $new_id;
					$theme_options[ $option_name ]['url'] = wp_get_attachment_image_url( $new_id, 'full' );
				}
			}
		}

		return $theme_options;
	}

	/**
	 * Replace options with post id.
	 *
	 * @param array $theme_options Options.
	 * @param array $imported_data Data.
	 */
	private function options_with_post_id( $theme_options, $imported_data ) {
		$options_with_post_id = array(
			'custom_404_page',
			'popup_html_block',
			'footer_html_block',
			'prefooter_html_block',
			'thank_you_page_html_block',
			'before_add_to_cart_html_block',
			'after_add_to_cart_html_block',
			'additional_tab_html_block',
			'additional_tab_2_html_block',
			'additional_tab_3_html_block',
			'cookies_policy_page',
			'compare_page',
			'wishlist_page',
		);

		foreach ( $options_with_post_id as $option_name ) {
			if ( isset( $theme_options[ $option_name ] ) && $theme_options[ $option_name ] ) {
				$current_id = $theme_options[ $option_name ];
				$new_id     = '';

				if ( isset( $imported_data['all_posts'][ $current_id ]['new'] ) && $imported_data['all_posts'][ $current_id ]['new'] ) {
					$new_id = $imported_data['all_posts'][ $current_id ]['new'];
				}

				if ( $new_id ) {
					$theme_options[ $option_name ] = $new_id;
				}
			}
		}

		return $theme_options;
	}

	/**
	 * Replace options with custom fonts.
	 *
	 * @param array $theme_options Options.
	 * @param array $imported_data Data.
	 */
	private function options_with_custom_fonts( $theme_options, $imported_data ) {
		$options_with_custom_fonts = array(
			'multi_custom_fonts',
		);

		foreach ( $options_with_custom_fonts as $option_name ) {
			if ( isset( $theme_options[ $option_name ] ) && $theme_options[ $option_name ] ) {
				foreach ( $theme_options[ $option_name ] as $font_data_key => $font_data ) {
					foreach ( $font_data as $key => $value ) {
						if ( isset( $value['id'] ) && $value['id'] ) {
							$current_id = $value['id'];
							$new_id     = '';

							if ( isset( $imported_data['attachment'][ $current_id ]['new'] ) && $imported_data['attachment'][ $current_id ]['new'] ) {
								$new_id = $imported_data['attachment'][ $current_id ]['new'];
							}

							if ( $new_id ) {
								$theme_options[ $option_name ][ $font_data_key ][ $key ]['id']  = $new_id;
								$theme_options[ $option_name ][ $font_data_key ][ $key ]['url'] = wp_get_attachment_image_url( $new_id, 'full' );
							}
						}
					}
				}
			}
		}

		return $theme_options;
	}
}
