<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_wpml_js_data' ) ) {
	function woodmart_wpml_js_data() {
		if ( ! woodmart_get_opt( 'ajax_shop' ) || ! defined( 'WCML_VERSION' ) || ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
			return;
		}

		$data = array(
			'languages' => apply_filters( 'wpml_active_languages', null ),
		);

		echo '<script>';
		echo 'var woodmart_wpml_js_data = ' . wp_json_encode( $data );
		echo '</script>';
	}

	add_action( 'woodmart_after_header', 'woodmart_wpml_js_data' );
}

if ( ! function_exists( 'woodmart_wpml_compatibility' ) ) {
	function woodmart_wpml_compatibility( $ajax_actions ) {
		$ajax_actions[] = 'woodmart_ajax_add_to_cart';
		$ajax_actions[] = 'woodmart_quick_view';
		$ajax_actions[] = 'woodmart_ajax_search';
		$ajax_actions[] = 'woodmart_get_products_shortcode';
		$ajax_actions[] = 'woodmart_get_products_tab_shortcode';
		$ajax_actions[] = 'woodmart_update_cart_item';
		$ajax_actions[] = 'woodmart_load_html_dropdowns';
		$ajax_actions[] = 'woodmart_quick_shop';

		return $ajax_actions;
	}

	add_filter( 'wcml_multi_currency_ajax_actions', 'woodmart_wpml_compatibility', 10, 1 );
}

if ( ! function_exists( 'woodmart_wpml_variation_gallery_data' ) ) {
	function woodmart_wpml_variation_gallery_data( $post_id_from, $post_id_to, $meta_key ) {
		if ( 'woodmart_variation_gallery_data' === $meta_key ) {
			$translated_lang  = apply_filters( 'wpml_post_language_details', '', $post_id_to );
			$translated_lang  = isset( $translated_lang['language_code'] ) ? $translated_lang['language_code'] : '';
			$original_value   = get_post_meta( $post_id_from, 'woodmart_variation_gallery_data', true );
			$translated_value = $original_value;
			if ( ! empty( $original_value ) && is_array( $original_value ) ) {
				foreach ( $original_value as $key => $value ) {
					$translated_variation_id = apply_filters( 'wpml_object_id', $key, 'product_variation', false, $translated_lang );

					$translated_value[ $translated_variation_id ] = $value;
					unset( $translated_value[ $key ] );
				}
				update_post_meta( $post_id_to, 'woodmart_variation_gallery_data', $translated_value );
			}
		}
	}

	add_action( 'wpml_after_copy_custom_field', 'woodmart_wpml_variation_gallery_data', 10, 3 );
}

if ( ! function_exists( 'woodmart_wpml_register_header_builder_strings' ) ) {
	function woodmart_wpml_register_header_builder_strings( $file ) {
		global $wpdb;

		if ( is_string( $file ) && 'woodmart' === basename( dirname( $file ) ) && class_exists( 'WPML_Admin_Text_Configuration' ) ) {
			$file       .= ':whb';
			$admin_texts = array();
			$headers     = get_option( 'whb_saved_headers', [] );
			foreach ( $headers as $key => $header ) {
				$admin_texts[] = array(
					'value' => '',
					'attr'  => array( 'name' => 'whb_' . $key ),
					'key'   => array(
						array(
							'value' => '',
							'attr'  => array( 'name' => 'structure' ),
							'key'   => array(
								array(
									'value' => '',
									'attr'  => array( 'name' => 'content' ),
									'key'   => array(
										array(
											'value' => '',
											'attr'  => array( 'name' => '*' ),
											'key'   => array(
												array(
													'value' => '',
													'attr' => array( 'name' => 'content' ),
													'key'  => array(
														array(
															'value' => '',
															'attr' => array( 'name' => '*' ),
															'key' => array(
																array(
																	'value' => '',
																	'attr' => array( 'name' => 'content' ),
																	'key' => array(
																		array(
																			'value' => '',
																			'attr' => array( 'name' => '*' ),
																			'key' => array(
																				array(
																					'value' => '',
																					'attr' => array( 'name' => 'params' ),
																					'key' => array(
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'content' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'title' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'subtitle' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'image' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'link' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																					),
																				),
																			),
																		),
																	),
																),
															),
														),
													),
												),
											),
										),
									),
								),
							),
						),
					),
				);
			}

			$object = (object) array(
				'config'             => array(
					'wpml-config' => array(
						'admin-texts' => array(
							'value' => '',
							'key'   => $admin_texts,
						),
					),
				),
				'type'               => 'theme',
				'admin_text_context' => 'woodmart-header-builder',
			);

			$config       = new WPML_Admin_Text_Configuration( $object );
			$config_array = $config->get_config_array();

			if ( ! empty( $config_array ) ) {
				$st_records          = new WPML_ST_Records( $wpdb );
				$import              = new WPML_Admin_Text_Import( $st_records, new WPML_WP_API() );
				$config_handler_hash = md5( serialize( 'whb' ) );
				$import->parse_config( $config_array, $config_handler_hash );
			}
		}
	}

	add_filter( 'wpml_parse_config_file', 'woodmart_wpml_register_header_builder_strings' );
}
