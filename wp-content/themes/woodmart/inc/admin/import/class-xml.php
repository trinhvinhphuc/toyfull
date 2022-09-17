<?php
/**
 * Import XML.
 *
 * @package Woodmart
 */

namespace XTS\Import;

use Elementor\Plugin;
use Exception;
use WOODCORE_Import;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import XML.
 */
class XML {
	/**
	 * Version name.
	 *
	 * @var string
	 */
	private $version;
	/**
	 * File type.
	 *
	 * @var string
	 */
	private $type;
	/**
	 * Imported data.
	 *
	 * @var array
	 */
	private $imported_data;
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
	 * @param string $type    File type.
	 */
	public function __construct( $version, $type ) {
		$this->helpers = Helpers::get_instance();
		$this->version = $version;
		$this->type    = $type;

		$this->import_xml();

		$this->imported_data = $this->helpers->get_imported_data( $version );
		$this->term_replace();
		$this->post_meta_replace();
		$this->wpb_post_content_replace();
		$this->elementor_post_content_replace();
	}

	/**
	 * Get file name.
	 */
	private function get_file_name() {
		$file_name = 'elementor' === woodmart_get_current_page_builder() ? 'content-elementor.xml' : 'content.xml';

		if ( $this->type !== 'posts' ) {
			$file_name = 'elementor' === woodmart_get_current_page_builder() ? 'content-elementor-' . $this->type . '.xml'
			: 'content-' . $this->type . '.xml';
		}

		return $file_name;
	}

	/**
	 * Import XML.
	 */
	private function import_xml() {
		$importer = $this->get_importer();
		$file     = $this->helpers->get_file_path( $this->get_file_name(), $this->version );

		if ( ! $file ) {
			return;
		}

		try {
			ob_start();

			add_filter(
				'intermediate_image_sizes',
				function () {
					return array();
				}
			);

			$importer->fetch_attachments = true;

			$importer->import( $file, $this->version );

			ob_end_clean();
		} catch ( Exception $e ) {
			echo esc_html( '[ERROR] XML import<br>' );
		}
	}

	/**
	 * Load importers.
	 *
	 * @return WOODCORE_Import|bool;
	 */
	private function get_importer() {
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if ( ! function_exists( 'WOODMART_Theme_Plugin' ) ) {
			echo esc_html( '[ERROR] Importer not exists<br>' );

			return false;
		}

		$plugin_dir = WOODMART_Theme_Plugin()->plugin_path();

		if ( file_exists( $plugin_dir . '/importer/compat.php' ) ) {
			/** Functions missing in older WordPress versions. */
			require_once $plugin_dir . '/importer/compat.php';

			/** WXR_Parser class */
			require_once $plugin_dir . '/importer/parsers/class-wxr-parser.php';

			/** WXR_Parser_SimpleXML class */
			require_once $plugin_dir . '/importer/parsers/class-wxr-parser-simplexml.php';

			/** WXR_Parser_XML class */
			require_once $plugin_dir . '/importer/parsers/class-wxr-parser-xml.php';

			/** WXR_Parser_Regex class */
			require_once $plugin_dir . '/importer/parsers/class-wxr-parser-regex.php';

			/** WP_Import class */
			require_once $plugin_dir . '/importer/class-wp-import.php';
		} else {
			echo esc_html( '[ERROR] Importer not exists<br>' );

			return false;
		}

		if ( class_exists( 'WP_Importer' ) && class_exists( 'WOODCORE_Import' ) ) {
			return new WOODCORE_Import();
		} else {
			echo esc_html( '[ERROR] Importer not exists<br>' );

			return false;
		}
	}

	/**
	 * Term replace.
	 */
	private function term_replace() {
		$term_meta_key_list = array(
			'thumbnail_id',
			'category_icon_alt',
			'category_icon',
			'title_image',
			'image',
		);

		if ( ! empty( $this->imported_data['term'] ) ) {
			foreach ( $this->imported_data['term'] as $terms ) {
				foreach ( $terms as $term ) {
					if ( $this->is_replaced( $term['new'], 'term_meta' ) ) {
						continue;
					}

					foreach ( $term_meta_key_list as $meta_key ) {
						$flag      = false;
						$term_meta = get_term_meta( $term['new'], $meta_key, true );

						if ( ! $term_meta ) {
							continue;
						}

						if ( is_numeric( $term_meta ) ) {
							if ( ! isset( $this->imported_data['attachment'][ $term_meta ] ) ) {
								continue;
							}

							$flag      = true;
							$term_meta = $this->imported_data['attachment'][ $term_meta ]['new'];
						} elseif ( is_array( $term_meta ) && ! empty( $term_meta['id'] ) ) {
							if ( ! isset( $this->imported_data['attachment'][ $term_meta['id'] ] ) ) {
								continue;
							}

							$flag      = true;
							$term_meta = array(
								'url' => wp_get_attachment_image_url( $this->imported_data['attachment'][ $term_meta['id'] ]['new'], 'full' ),
								'id'  => $this->imported_data['attachment'][ $term_meta['id'] ]['new'],
							);
						}

						if ( $flag ) {
							$this->add_to_replaced( $term['new'], 'term_meta' );
							update_term_meta( $term['new'], $meta_key, $term_meta );
						}
					}
				}
			}
		}
	}

	/**
	 * Post meta replace.
	 */
	private function post_meta_replace() {
		$post_meta_key_list = array(
			'_woodmart_title_image',
			'_thumbnail_id',
			'bg_image_desktop',
			'bg_image_tablet',
			'bg_image_mobile',
			'_menu_item_block',
			'woodmart_sguide_select',
		);
		if ( ! empty( $this->imported_data['all_posts'] ) ) {
			foreach ( $this->imported_data['all_posts'] as $value ) {
				$data = (array) $this->imported_data['all_posts'];

				if ( isset( $this->imported_data['term'] ) ) {
					$data = (array) $this->imported_data['all_posts'] + (array) $this->imported_data['term']['product_cat'];
				}

				if ( $this->is_replaced( $value['new'], 'post_meta' ) ) {
					continue;
				}

				foreach ( $post_meta_key_list as $meta_key ) {
					$post_meta = get_post_meta( $value['new'], $meta_key, true );

					if ( ! $post_meta ) {
						continue;
					}

					$flag = false;

					if ( is_string( $post_meta ) && strpos( $post_meta, ',' ) ) {
						$output = array();
						$ids    = explode( ',', $post_meta );

						foreach ( $ids as $id ) {
							if ( ! isset( $data[ $id ] ) ) {
								continue;
							}

							$output[] = $data[ $id ]['new'];
						}

						$flag      = true;
						$post_meta = implode( ',', $output );
					} elseif ( is_numeric( $post_meta ) ) {
						if ( ! isset( $data[ $post_meta ] ) ) {
							continue;
						}

						$flag      = true;
						$post_meta = $data[ $post_meta ]['new'];
					} elseif ( is_array( $post_meta ) && ! empty( $post_meta['id'] ) ) {
						if ( ! isset( $this->imported_data['attachment'][ $post_meta['id'] ] ) ) {
							continue;
						}

						$flag      = true;
						$post_meta = array(
							'url' => wp_get_attachment_image_url( $this->imported_data['attachment'][ $post_meta['id'] ]['new'], 'full' ),
							'id'  => $this->imported_data['attachment'][ $post_meta['id'] ]['new'],
						);
					}

					if ( $flag ) {
						$this->add_to_replaced( $value['new'], 'post_meta' );
						update_post_meta( $value['new'], $meta_key, $post_meta );
					}
				}
			}
		}
	}

	/**
	 * Post content replace.
	 */
	private function wpb_post_content_replace() {
		if ( ! empty( $this->imported_data['all_posts'] ) ) {
			foreach ( $this->imported_data['all_posts'] as $value ) {
				if ( isset( $value['type'] ) || $this->is_replaced( $value['new'], 'post_content' ) ) {
					continue;
				}

				$wd_post = get_post( $value['new'] );

				if ( ! $wd_post || ( is_object( $wd_post ) && ! property_exists( $wd_post, 'post_content' ) ) ) {
					continue;
				}

				$wd_post_content = $wd_post->post_content;

				// Terms replace.
				$terms_data = array();

				if ( isset( $this->imported_data['term'] ) ) {
					foreach ( $this->imported_data['term'] as $terms ) {
						foreach ( $terms as $key => $term ) {
							$terms_data[ $key ] = $term;
						}
					}
				}

				$wd_post_content = $this->wpb_post_content_replace_process(
					$terms_data,
					$wd_post_content,
					$value['new'],
					array(
						'/ids="([^"]*)"/i',
					)
				);

				// Post and attachment replace.
				$wd_post_content = $this->wpb_post_content_replace_process(
					$this->imported_data['all_posts'],
					$wd_post_content,
					$value['new'],
					array(
						'/list="([^"]*)"/i',
						'/images="([^"]*)"/i',
						'/image="([^"]*)"/i',
						'/img_id="([^"]*)"/i',
						'/form_id="([^"]*)"/i',
						'/contact-form-7 id="([^"]*)"/i',
						'/html_block id="([^"]*)"/i',
						'/product_id="([^"]*)"/i',
						'/poster_image="([^"]*)"/i',
						'/include="([^"]*)"/i',
						'/sidebar_id="([^"]*)"/i',
						'/html_block_id="([^"]*)"/i',
					)
				);

				$wd_post_content = str_replace( '{/{', '', $wd_post_content );
				$wd_post_content = str_replace( '}/}', '', $wd_post_content );

				wp_update_post(
					array(
						'ID'           => $value['new'],
						'post_content' => $wd_post_content,
					)
				);
			}
		}
	}

	/**
	 * Post content replace.
	 *
	 * @param array   $post_data       Data.
	 * @param string  $wd_post_content Content.
	 * @param integer $post_id         Post id.
	 * @param array   $attrs           Attributes to replace.
	 *
	 * @return array|mixed|string|string[]
	 */
	private function wpb_post_content_replace_process( $post_data, $wd_post_content, $post_id, $attrs ) {
		foreach ( $post_data as $data ) {
			foreach ( $attrs as $attr ) {
				$array = array();
				preg_match_all( $attr, $wd_post_content, $array );

				if ( ! isset( $array[1] ) ) {
					continue;
				}

				$found_values = $array[1];

				foreach ( $found_values as $found_value_key => $found_value ) {
					$flag           = false;
					$replaced_value = $found_value;
					$diff           = array();

					if ( strpos( $found_value, 'list-content' ) ) {
						$data_decoded = json_decode( urldecode( $found_value ), true );
						foreach ( $data_decoded as $key => $list_data ) {
							if ( ! isset( $list_data['image_id'] ) ) {
								continue;
							}

							if ( (int) $data['old'] === (int) $list_data['image_id'] ) {
								$data_decoded[ $key ]['image_id'] = $data['new'];
								$flag                             = true;

								// Diff.
								$diff[ $data['old'] ] = $data['new'];
							}
						}

						$replaced_value = rawurlencode( wp_json_encode( $data_decoded ) );
					} elseif ( strpos( $found_value, 'sidebar' ) ) {
						if ( 'sidebar-' . $data['old'] === $found_value ) {
							$flag           = true;
							$replaced_value = '{/{sidebar-' . $data['new'] . '}/}';

							// Diff.
							$diff[ $data['old'] ] = $data['new'];
						}
					} elseif ( strpos( $found_value, ',' ) ) {
						$ids = explode( ',', $found_value );

						foreach ( $ids as $key => $id ) {
							if ( (int) $data['old'] === (int) $id ) {
								$ids[ $key ] = '{/{' . $data['new'] . '}/}';
								$flag        = true;

								// Diff.
								$diff[ $data['old'] ] = $data['new'];
							}
						}

						$replaced_value = implode( ',', $ids );
					} else {
						if ( (int) $data['old'] === (int) $found_value ) {
							$flag           = true;
							$replaced_value = '{/{' . $data['new'] . '}/}';

							// Diff.
							$diff[ $data['old'] ] = $data['new'];
						}
					}

					if ( $flag ) {
						$this->add_to_replaced( $post_id, 'post_content', $diff );
						// Fix unnecessary replace.
						$old_value       = $array[0][ $found_value_key ];
						$new_value       = str_replace( $found_value, $replaced_value, $old_value );
						$wd_post_content = str_replace( $old_value, $new_value, $wd_post_content );
					}
				}
			}
		}

		return $wd_post_content;
	}

	/**
	 * Elementor content replace.
	 */
	private function elementor_post_content_replace() {
		if ( ! empty( $this->imported_data['all_posts'] ) ) {
			foreach ( $this->imported_data['all_posts'] as $value ) {
				if ( ! isset( $value['type'] ) || ( isset( $value['type'] ) && 'elementor' !== $value['type'] ) || $this->is_replaced( $value['new'], 'post_content' ) ) {
					continue;
				}

				$post_meta = json_decode( get_post_meta( $value['new'], '_elementor_data', true ), true );

				if ( ! $post_meta ) {
					continue;
				}

				$imported_data = $this->imported_data;

				$post_meta = Plugin::$instance->db->iterate_data(
					$post_meta,
					function ( $element_data ) use ( $imported_data ) {
						$element = Plugin::$instance->elements_manager->create_element_instance( $element_data );

						if ( is_null( $element ) ) {
							return $element_data;
						}

						$terms_data = array();

						foreach ( $imported_data['term'] as $terms ) {
							foreach ( $terms as $key => $term ) {
								$terms_data[ $key ] = $term;
							}
						}

						$posts_data = $imported_data['all_posts'];

						foreach ( $posts_data as $data ) {
							foreach ( $element->get_controls() as $control ) {
								if ( ! isset( $element_data['settings'][ $control['name'] ] ) ) {
									continue;
								}

								$settings = $element_data['settings'][ $control['name'] ];

								$repeater_id_fields = array(
									'content_html_block',
									'html_block_id',
									'include',
									'exclude',
									'product_id',
									'include_products',
								);
								if ( 'repeater' === $control['type'] ) {
									foreach ( $repeater_id_fields as $field ) {
										foreach ( $settings as $key => $value ) {
											if ( empty( $value ) || ! isset( $value[ $field ] ) ) {
												continue;
											}

											if ( (int) $value[ $field ] === (int) $data['old'] ) {
												$settings[ $key ][ $field ] = strval( '{/{' . $data['new'] . '}/}' );
											}
										}
									}
								}

								$select_id_fields = array(
									'content',
								);
								if ( 'select' === $control['type'] && in_array( $control['name'], $select_id_fields, true ) ) {
									if ( empty( $settings ) ) {
										continue;
									}

									if ( (int) $settings === (int) $data['old'] ) {
										$settings = strval( '{/{' . $data['new'] . '}/}' );
									}
								}

								$autocomplete_id_fields = array(
									'include',
									'exclude',
									'product_id',
									'include_products',
								);
								if ( 'wd_autocomplete' === $control['type'] && in_array( $control['name'], $autocomplete_id_fields, true ) ) {
									foreach ( $settings as $key => $value ) {
										if ( empty( $value ) ) {
											continue;
										}

										if ( (int) $value === (int) $data['old'] ) {
											$settings[ $key ] = strval( '{/{' . $data['new'] . '}/}' );
										}
									}
								}

								if ( 'media' === $control['type'] ) {
									if ( empty( $settings['url'] ) ) {
										continue;
									}

									if ( (int) $settings['id'] === (int) $data['old'] ) {
										$settings['url'] = wp_get_attachment_image_url( $data['new'], 'full' );
										$settings['id']  = '{/{' . $data['new'] . '}/}';
									}
								}

								if ( 'gallery' === $control['type'] ) {
									foreach ( $settings as $key => $value ) {
										if ( empty( $value['url'] ) ) {
											continue;
										}

										if ( (int) $value['id'] === (int) $data['old'] ) {
											$settings[ $key ]['url'] = wp_get_attachment_image_url( $data['new'], 'full' );
											$settings[ $key ]['id']  = '{/{' . $data['new'] . '}/}';
										}
									}
								}

								$element_data['settings'][ $control['name'] ] = $settings;
							}
						}

						foreach ( $terms_data as $data ) {
							foreach ( $element->get_controls() as $control ) {
								if ( ! isset( $element_data['settings'][ $control['name'] ] ) ) {
									continue;
								}

								$settings = $element_data['settings'][ $control['name'] ];

								$repeater_id_fields = array(
									'taxonomies',
									'ids',
									'categories',
								);
								if ( 'repeater' === $control['type'] ) {
									foreach ( $repeater_id_fields as $field ) {
										foreach ( $settings as $key => $value ) {
											if ( empty( $value ) || ! isset( $value[ $field ] ) ) {
												continue;
											}

											if ( (int) $value[ $field ] === (int) $data['old'] ) {
												$settings[ $key ][ $field ] = strval( '{/{' . $data['new'] . '}/}' );
											}
										}
									}
								}

								$select_id_fields = array(
									'nav_menu',
								);
								if ( 'select' === $control['type'] && in_array( $control['name'], $select_id_fields, true ) ) {
									if ( empty( $settings ) ) {
										continue;
									}

									if ( (int) $settings === (int) $data['old'] ) {
										$settings = strval( '{/{' . $data['new'] . '}/}' );
									}
								}

								$autocomplete_id_fields = array(
									'taxonomies',
									'ids',
									'categories',
								);
								if ( 'wd_autocomplete' === $control['type'] && in_array( $control['name'], $autocomplete_id_fields, true ) ) {
									foreach ( $settings as $key => $value ) {
										if ( empty( $value ) ) {
											continue;
										}

										if ( (int) $value === (int) $data['old'] ) {
											$settings[ $key ] = strval( '{/{' . $data['new'] . '}/}' );
										}
									}
								}

								$element_data['settings'][ $control['name'] ] = $settings;
							}
						}

						return $element_data;
					}
				);

				$post_meta = wp_json_encode( $post_meta );

				$post_meta = str_replace( '{\/{', '', $post_meta );
				$post_meta = str_replace( '}\/}', '', $post_meta );

				$this->add_to_replaced( $value['new'], 'post_content' );

				update_post_meta( $value['new'], '_elementor_data', wp_slash( $post_meta ) );
			}
		}
	}

	/**
	 * Add to replace.
	 *
	 * @param int        $id   Post id.
	 * @param string     $type Data type.
	 * @param bool|array $diff Diff data.
	 */
	private function add_to_replaced( $id, $type, $diff = false ) {
		$data = get_option( 'wd_import_replaced_items', array() );

		$data[ $id ][ $type ] = $type;

		if ( $diff ) {
			$data[ $id ]['diff'][] = $diff;
		}

		update_option( 'wd_import_replaced_items', $data );
	}

	/**
	 * Is replaced.
	 *
	 * @param int    $id   Post id.
	 * @param string $type Data type.
	 *
	 * @return bool
	 */
	private function is_replaced( $id, $type ) {
		$data = get_option( 'wd_import_replaced_items', array() );

		return isset( $data[ $id ] ) && in_array( $type, $data[ $id ], true );
	}
}
