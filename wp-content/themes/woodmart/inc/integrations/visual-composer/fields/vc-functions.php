<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * Shortcodes css formatter
 */
if ( ! function_exists( 'woodmart_parse_shortcodes_css_data' ) ) {
	function woodmart_parse_shortcodes_css_data( $content ) {
		if ( ! class_exists( 'WPBMap' ) ) {
			return;
		}
		$css_data = '';

		WPBMap::addAllMappedShortcodes();
		preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );

		foreach ( $shortcodes[2] as $index => $tag ) {
			$shortcode       = WPBMap::getShortCode( $tag );
			$attr_array      = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
			$woodmart_fields = array(
				'woodmart_responsive_size',
				'woodmart_responsive_spacing',
				'woodmart_colorpicker',
				'woodmart_slider',
			);

			if ( isset( $shortcode['params'] ) && ! empty( $shortcode['params'] ) ) {
				foreach ( $shortcode['params'] as $param ) {
					if ( isset( $param['type'] ) && in_array( $param['type'], $woodmart_fields ) && isset( $attr_array[ $param['param_name'] ] ) ) {
						$css_data .= $attr_array[ $param['param_name'] ] . '[|]';
					}
				}
			}
		}

		foreach ( $shortcodes[5] as $shortcode_content ) {
			$css_data .= woodmart_parse_shortcodes_css_data( $shortcode_content );
		}

		return $css_data;
	}
}


if ( ! function_exists( 'woodmart_get_fields_css_old' ) ) {
	/**
	 * This function return old field css.
	 *
	 * @param int $post_id Post id.
	 * @throws Exception .
	 */
	function woodmart_get_fields_css_old( $post_id ) {
		$post       = get_post( $post_id );
		$css_data   = woodmart_parse_shortcodes_css_data( $post->post_content );
		$data_array = explode( '[|]', $css_data );
		return woodmart_shortcodes_css_data_to_css( $data_array );
	}
}

if ( ! function_exists( 'woodmart_print_shortcodes_css' ) ) {
	function woodmart_print_shortcodes_css( $id = null ) {
		if ( function_exists( 'is_shop' ) && is_shop() ) {
			$id = wc_get_page_id( 'shop' );
		}

		if ( ! $id ) {
			$id = get_the_ID();
		}

		if ( $id ) {
			$css = get_post_meta( $id, 'woodmart_shortcodes_custom_css', true );
			if ( ! empty( $css ) ) {
				echo '<style data-type="woodmart_shortcodes-custom-css">' . $css . '</style>';
			}
		}
	}

	add_action( 'wp_head', 'woodmart_print_shortcodes_css', 1000 );
}


if ( ! function_exists( 'woodmart_shortcodes_css_data_to_css' ) ) {
	function woodmart_shortcodes_css_data_to_css( $css_data ) {
		$results         = '';
		$sorted_css_data = array();
		$css             = array(
			'desktop' => '',
			'tablet'  => '',
			'mobile'  => '',
		);

		foreach ( $css_data as $value ) {
			$decompressed_data = function_exists( 'woodmart_decompress' ) ? json_decode( woodmart_decompress( $value ) ) : '';

			if ( is_object( $decompressed_data ) ) {
				foreach ( $decompressed_data->data as $size => $css_value ) {
					if ( property_exists( $decompressed_data, 'css_args' ) ) {
						foreach ( $decompressed_data->css_args as $css_prop => $classes_array ) {
							foreach ( $classes_array as $css_class ) {
								$selector = '#wd-' . $decompressed_data->selector_id . $css_class;
								if ( 'font-size' === $css_prop ) {
									$sorted_css_data[ $size ][ $selector ]['line-height'] = str_replace( 'px', '', $css_value ) + 10 . 'px';
								}
								if ( 'line-height' === $css_prop ) {
									unset( $sorted_css_data[ $size ][ $selector ]['line-height'] );
								}
								if ( 'border-color' === $css_prop ) {
									$css_value = $css_value . ' !important';
								}
								if ( strstr( $css_prop, '--' ) ) {
									$css_value = $css_value . 'px';
								}
								if ( strstr( $css_prop, 'margin' ) ) {
									$css_value = $css_value . 'px';
								}
								$sorted_css_data[ $size ][ $selector ][ $css_prop ] = $css_value;
							}
						}
					} else {
						$selector = '.website-wrapper .wd-rs-' . $decompressed_data->selector_id;
						if ( 'vc_column' === $decompressed_data->shortcode || 'vc_column_inner' === $decompressed_data->shortcode ) {
							$selector .= ' > .vc_column-inner';
						}

						foreach ( $css_value as $key => $value ) {
							if ( empty( $value ) && 0 != $value ) {
								continue;
							}

							if ( ! preg_match( '/^-?\d*(\.\d+){0,1}(%|in|cm|mm|em|rem|ex|pt|pc|px|vw|vh|vmin|vmax)$/', $value ) ) {
								$value = $value . 'px';
							}

							$sorted_css_data[ $size ][ $selector ][ $key ] = $value . ' !important';
						}
					}
				}
			}
		}

		foreach ( $sorted_css_data as $size => $selectors ) {
			foreach ( $selectors as $selector => $css_data ) {
				$css[ $size ] .= $selector . '{';
				foreach ( $css_data as $css_prop => $css_value ) {
					$css[ $size ] .= $css_prop . ':' . $css_value . ';';
				}
				$css[ $size ] .= '}';
			}
		}

		foreach ( $css as $size => $css_value ) {
			if ( $size == 'desktop' && $css_value ) {
				$results .= $css_value;
			} elseif ( $size == 'tablet' && $css_value ) {
				$results .= '@media (max-width: 1199px) {' . $css_value . '}';
			} elseif ( $size == 'mobile' && $css_value ) {
				$results .= '@media (max-width: 767px) {' . $css_value . '}';
			}
		}

		return $results;
	}
}
