<?php
/**
 * This file enqueue scripts and styles for admin.
 *
 * @package Woodmart
 */

use XTS\Google_Fonts;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_theme_settings_search_data' ) ) {
	/**
	 * Get theme settings search data.
	 */
	function woodmart_get_theme_settings_search_data() {
		check_ajax_referer( 'woodmart-get-theme-settings-data-nonce', 'security' );

		$all_fields   = XTS\Options::get_fields();
		$all_sections = XTS\Options::get_sections();

		$options_data = array();
		foreach ( $all_fields as $field ) {
			$section_id = $field->args['section'];
			$section    = $all_sections[ $section_id ];

			if ( isset( $section['parent'] ) ) {
				$path = $all_sections[ $section['parent'] ]['name'] . ' -> ' . $section['name'];
			} else {
				$path = $section['name'];
			}

			$text = isset( $field->args['name'] ) ? $field->args['name'] : '';
			if ( isset( $field->args['description'] ) ) {
				$text .= ' ' . $field->args['description'];
			}
			if ( isset( $field->args['tags'] ) ) {
				$text .= ' ' . $field->args['tags'];
			}

			$options_data[] = array(
				'id'         => $field->args['id'],
				'title'      => isset( $field->args['name'] ) ? $field->args['name'] : '',
				'text'       => $text,
				'section_id' => $section['id'],
				'icon'       => isset( $section['icon'] ) ? $section['icon'] : $all_sections[ $section['parent'] ]['icon'],
				'path'       => $path,
			);
		}

		wp_send_json(
			array(
				'theme_settings' => $options_data,
			)
		);
	}

	add_action( 'wp_ajax_woodmart_get_theme_settings_search_data', 'woodmart_get_theme_settings_search_data' );
}

if ( ! function_exists( 'woodmart_get_theme_settings_typography_data' ) ) {
	/**
	 * Get theme settings typography data.
	 */
	function woodmart_get_theme_settings_typography_data() {
		check_ajax_referer( 'woodmart-get-theme-settings-data-nonce', 'security' );

		$custom_fonts_data = woodmart_get_opt( 'multi_custom_fonts' );
		$custom_fonts      = array();
		if ( isset( $custom_fonts_data['{{index}}'] ) ) {
			unset( $custom_fonts_data['{{index}}'] );
		}

		if ( is_array( $custom_fonts_data ) ) {
			foreach ( $custom_fonts_data as $font ) {
				if ( ! $font['font-name'] ) {
					continue;
				}

				$custom_fonts[ $font['font-name'] ] = $font['font-name'];
			}
		}

		$typekit_fonts = woodmart_get_opt( 'typekit_fonts' );

		if ( $typekit_fonts ) {
			$typekit = explode( ',', $typekit_fonts );
			foreach ( $typekit as $font ) {
				$custom_fonts[ ucfirst( trim( $font ) ) ] = trim( $font );
			}
		}

		wp_send_json(
			array(
				'typography' => array(
					'stdfonts'    => woodmart_get_config( 'standard-fonts' ),
					'googlefonts' => Google_Fonts::$all_google_fonts,
					'customFonts' => $custom_fonts,
				),
			)
		);
	}

	add_action( 'wp_ajax_woodmart_get_theme_settings_typography_data', 'woodmart_get_theme_settings_typography_data' );
}

if ( ! function_exists( 'woodmart_admin_wpb_scripts' ) ) {
	/**
	 * Add scripts for WPB fields.
	 */
	function woodmart_admin_wpb_scripts() {
		if ( 'wpb' !== woodmart_get_current_page_builder() ) {
			return;
		}

		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			wp_enqueue_script( 'wd-wpb-colorpicker-gradient', WOODMART_ASSETS . '/js/colorpicker.min.js', array(), WOODMART_VERSION, true );
			wp_enqueue_script( 'wd-wpb-gradient', WOODMART_ASSETS . '/js/gradX.min.js', array(), WOODMART_VERSION, true );
		}

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-datetimepicker', WOODMART_ASSETS . '/js/datetimepicker.min.js', array(), WOODMART_VERSION, true );

		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'wd-wpb-slider', WOODMART_ASSETS . '/js/vc-fields/slider.js', array(), WOODMART_VERSION, true );

		wp_enqueue_script( 'wd-wpb-image-hotspot', WOODMART_ASSETS . '/js/vc-fields/image-hotspot.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-title-divider', WOODMART_ASSETS . '/js/vc-fields/title-divider.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-responsive-size', WOODMART_ASSETS . '/js/vc-fields/responsive-size.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-responsive-spacing', WOODMART_ASSETS . '/js/vc-fields/responsive-spacing.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-image-select', WOODMART_ASSETS . '/js/vc-fields/image-select.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-colorpicker', WOODMART_ASSETS . '/js/vc-fields/colorpicker.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-datepicker', WOODMART_ASSETS . '/js/vc-fields/datepicker.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-switch', WOODMART_ASSETS . '/js/vc-fields/switch.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-button-set', WOODMART_ASSETS . '/js/vc-fields/button-set.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-functions', WOODMART_ASSETS . '/js/vc-fields/vc-functions.js', array(), WOODMART_VERSION, true );

		wp_enqueue_script( 'wd-wpb-slider-responsive', WOODMART_ASSETS . '/js/vc-fields/slider-responsive.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-number', WOODMART_ASSETS . '/js/vc-fields/number.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-colorpicker-new', WOODMART_ASSETS . '/js/vc-fields/wd-colorpicker.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-box-shadow', WOODMART_ASSETS . '/js/vc-fields/box-shadow.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-select', WOODMART_ASSETS . '/js/vc-fields/select.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-dimensions', WOODMART_ASSETS . '/js/vc-fields/dimensions.js', array(), WOODMART_VERSION, true );
	}

	add_action( 'vc_backend_editor_render', 'woodmart_admin_wpb_scripts' );
	add_action( 'vc_frontend_editor_render', 'woodmart_admin_wpb_scripts' );
}

if ( ! function_exists( 'woodmart_admin_wpb_styles' ) ) {
	/**
	 * Add styles for WPB fields.
	 */
	function woodmart_admin_wpb_styles() {
		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			wp_enqueue_style( 'wd-wpb-colorpicker-gradient', WOODMART_ASSETS . '/css/colorpicker.css', array(), WOODMART_VERSION );
			wp_enqueue_style( 'wd-wpb-gradient', WOODMART_ASSETS . '/css/gradX.css', array(), WOODMART_VERSION );
		}

		wp_enqueue_style( 'wd-jquery-ui', WOODMART_ASSETS . '/css/jquery-ui.css', array(), WOODMART_VERSION );
	}

	add_action( 'vc_backend_editor_render', 'woodmart_admin_wpb_styles' );
	add_action( 'vc_frontend_editor_render', 'woodmart_admin_wpb_styles' );
}


if ( ! function_exists( 'woodmart_wpb_frontend_editor_enqueue_scripts' ) ) {
	/**
	 * WPB frontend editor scripts.
	 */
	function woodmart_wpb_frontend_editor_enqueue_scripts() {
		woodmart_enqueue_js_library( 'cookie' );
		wp_enqueue_script( 'wd-wpb-frontend-editor', WOODMART_ASSETS . '/js/vc-fields/frontend-editor-functions.js', array(), WOODMART_VERSION, true );
	}

	add_action( 'vc_frontend_editor_enqueue_js_css', 'woodmart_wpb_frontend_editor_enqueue_scripts' );
}

if ( ! function_exists( 'woodmart_enqueue_widgets_admin_scripts' ) ) {
	/**
	 * Enqueue a scripts.
	 */
	function woodmart_enqueue_widgets_admin_scripts() {
		wp_enqueue_script( 'select2', WOODMART_ASSETS . '/js/select2.full.min.js', array(), woodmart_get_theme_info( 'Version' ), true );
		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );
	}

	add_action( 'widgets_admin_page', 'woodmart_enqueue_widgets_admin_scripts' );
}

if ( ! function_exists( 'woodmart_enqueue_admin_scripts' ) ) {
	/**
	 * Enqueue a scripts.
	 */
	function woodmart_enqueue_admin_scripts() {
		global $pagenow;

		wp_enqueue_script( 'woodmart-admin-scripts', WOODMART_ASSETS . '/js/admin.js', array(), WOODMART_VERSION, true );

		$localize_data = array(
			'deactivate_plugin_nonce'            => wp_create_nonce( 'woodmart_deactivate_plugin_nonce' ),
			'check_plugins_nonce'                => wp_create_nonce( 'woodmart_check_plugins_nonce' ),
			'install_child_theme_nonce'          => wp_create_nonce( 'woodmart_install_child_theme_nonce' ),
			'get_builder_elements_nonce'         => wp_create_nonce( 'woodmart-get-builder-elements-nonce' ),
			'get_builder_element_nonce'          => wp_create_nonce( 'woodmart-get-builder-element-nonce' ),
			'builder_load_header_nonce'          => wp_create_nonce( 'woodmart-builder-load-header-nonce' ),
			'builder_save_header_nonce'          => wp_create_nonce( 'woodmart-builder-save-header-nonce' ),
			'builder_remove_header_nonce'        => wp_create_nonce( 'woodmart-builder-remove-header-nonce' ),
			'builder_set_default_header_nonce'   => wp_create_nonce( 'woodmart-builder-set-default-header-nonce' ),
			'import_nonce'                       => wp_create_nonce( 'woodmart-import-nonce' ),
			'import_remove_nonce'                => wp_create_nonce( 'woodmart-import-remove-nonce' ),
			'mega_menu_added_thumbnail_nonce'    => wp_create_nonce( 'woodmart-mega-menu-added-thumbnail-nonce' ),
			'get_hotspot_image_nonce'            => wp_create_nonce( 'woodmart-get-hotspot-image-nonce' ),
			'get_theme_settings_data_nonce'      => wp_create_nonce( 'woodmart-get-theme-settings-data-nonce' ),
			'get_new_template_nonce'             => wp_create_nonce( 'wd-new-template-nonce' ),
			'searchOptionsPlaceholder'           => esc_js( __( 'Search for options', 'woodmart' ) ),
			'ajaxUrl'                            => admin_url( 'admin-ajax.php' ),
			'demoAjaxUrl'                        => WOODMART_DEMO_URL . 'wp-admin/admin-ajax.php',
			'activate_plugin_btn_text'           => esc_html__( 'Activate', 'woodmart' ),
			'update_plugin_btn_text'             => esc_html__( 'Update', 'woodmart' ),
			'deactivate_plugin_btn_text'         => esc_html__( 'Deactivate', 'woodmart' ),
			'install_plugin_btn_text'            => esc_html__( 'Install', 'woodmart' ),
			'activate_process_plugin_btn_text'   => esc_html__( 'Activating', 'woodmart' ),
			'update_process_plugin_btn_text'     => esc_html__( 'Updating', 'woodmart' ),
			'deactivate_process_plugin_btn_text' => esc_html__( 'Deactivating', 'woodmart' ),
			'install_process_plugin_btn_text'    => esc_html__( 'Installing', 'woodmart' ),
			'patcher_nonce'                      => wp_create_nonce( 'patcher_nonce' ),
			'wd_layout_type'                     => 'post.php' === $pagenow && isset( $_GET['post'] ) ? get_post_meta( woodmart_clean( $_GET['post'] ),'wd_layout_type', true ) : '', // phpcs:ignore
		);

		wp_localize_script( 'woodmart-admin-scripts', 'woodmartConfig', $localize_data );
	}

	add_action( 'admin_init', 'woodmart_enqueue_admin_scripts', 100 );
}

if ( ! function_exists( 'woodmart_enqueue_admin_styles' ) ) {
	/**
	 * Enqueue a CSS stylesheets.
	 */
	function woodmart_enqueue_admin_styles() {
		wp_enqueue_style( 'woodmart-admin-style', WOODMART_ASSETS . '/css/theme-admin.css', array(), WOODMART_VERSION );
	}

	add_action( 'admin_enqueue_scripts', 'woodmart_enqueue_admin_styles' );
}

