<?php
/**
 * This file generates fields css.
 *
 * @package Woodmart.
 */

use XTS\Google_Fonts;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_typography_map' ) ) {
	/**
	 * Get typography map.
	 *
	 * @param array $args Arguments.
	 *
	 * @return array
	 */
	function woodmart_get_typography_map( $args ) {
		$fields = array();

		$fields['font_family'] = array(
			'heading'    => esc_html__( 'Family', 'woodmart' ),
			'type'       => 'wd_fonts',
			'param_name' => $args['key'] . '_font_family',
			'selectors'  => array(
				$args['selector'] => array(
					'font-family: {{VALUE}};',
				),
			),
		);

		$fields['font_size'] = array(
			'heading'    => esc_html__( 'Size', 'woodmart' ),
			'type'       => 'wd_slider',
			'param_name' => $args['key'] . '_font_size',
			'selectors'  => array(
				$args['selector'] => array(
					'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			'devices'    => array(
				'desktop' => array(
					'unit' => 'px',
				),
				'tablet'  => array(
					'unit' => 'px',
				),
				'mobile'  => array(
					'unit' => 'px',
				),
			),
			'range'      => array(
				'vw'  => array(
					'min'  => 0.1,
					'max'  => 10,
					'step' => 0.1,
				),
				'rem' => array(
					'min'  => 0.1,
					'max'  => 10,
					'step' => 0.1,
				),
				'em'  => array(
					'min'  => 0.1,
					'max'  => 10,
					'step' => 0.1,
				),
				'%'   => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				),
				'px'  => array(
					'min'  => 1,
					'max'  => 200,
					'step' => 1,
				),
			),
		);

		$fields['font_weight'] = array(
			'heading'    => esc_html__( 'Weight', 'woodmart' ),
			'type'       => 'wd_select',
			'param_name' => $args['key'] . '_font_weight',
			'style'      => 'select',
			'selectors'  => array(
				$args['selector'] => array(
					'font-weight: {{VALUE}};',
				),
			),
			'devices'    => array(
				'desktop' => array(
					'value' => '',
				),
			),
			'value'      => array(
				esc_html__( 'Default', 'woodmart' )        => '',
				esc_html__( 'Thin 100', 'woodmart' )       => '100',
				esc_html__( 'Light 200', 'woodmart' )      => '200',
				esc_html__( 'Regular 300', 'woodmart' )    => '300',
				esc_html__( 'Normal 400', 'woodmart' )     => '400',
				esc_html__( 'Medium 500', 'woodmart' )     => '500',
				esc_html__( 'Semi Bold 600', 'woodmart' )  => '600',
				esc_html__( 'Bold 700', 'woodmart' )       => '700',
				esc_html__( 'Extra Bold 800', 'woodmart' ) => '800',
				esc_html__( 'Black 900', 'woodmart' )      => '900',
			),
		);

		$fields['text_transform'] = array(
			'heading'    => esc_html__( 'Transform', 'woodmart' ),
			'type'       => 'wd_select',
			'param_name' => $args['key'] . '_text_transform',
			'style'      => 'select',
			'selectors'  => array(
				$args['selector'] => array(
					'text-transform: {{VALUE}};',
				),
			),
			'devices'    => array(
				'desktop' => array(
					'value' => '',
				),
			),
			'value'      => array(
				esc_html__( 'Default', 'woodmart' )    => '',
				esc_html__( 'Uppercase', 'woodmart' )  => 'uppercase',
				esc_html__( 'Lowercase', 'woodmart' )  => 'lowercase',
				esc_html__( 'Capitalize', 'woodmart' ) => 'capitalize',
				esc_html__( 'Normal', 'woodmart' )     => 'none',
			),
		);

		$fields['font_style'] = array(
			'heading'    => esc_html__( 'Style', 'woodmart' ),
			'type'       => 'wd_select',
			'param_name' => $args['key'] . '_font_style',
			'style'      => 'select',
			'selectors'  => array(
				$args['selector'] => array(
					'font-style: {{VALUE}};',
				),
			),
			'devices'    => array(
				'desktop' => array(
					'value' => '',
				),
			),
			'value'      => array(
				esc_html__( 'Default', 'woodmart' ) => '',
				esc_html__( 'Normal', 'woodmart' )  => 'normal',
				esc_html__( 'Italic', 'woodmart' )  => 'italic',
				esc_html__( 'Oblique', 'woodmart' ) => 'oblique',
			),
		);

		$fields['line_height'] = array(
			'heading'    => esc_html__( 'Line height', 'woodmart' ),
			'type'       => 'wd_slider',
			'param_name' => $args['key'] . '_line_height',
			'selectors'  => array(
				$args['selector'] => array(
					'line-height: {{VALUE}}{{UNIT}};',
				),
			),
			'devices'    => array(
				'desktop' => array(
					'unit' => 'px',
				),
				'tablet'  => array(
					'unit' => 'px',
				),
				'mobile'  => array(
					'unit' => 'px',
				),
			),
			'range'      => array(
				'em' => array(
					'min'  => 0.1,
					'max'  => 10,
					'step' => 0.1,
				),
				'px' => array(
					'min'  => 1,
					'max'  => 200,
					'step' => 1,
				),
			),
		);

		if ( isset( $args['group'] ) ) {
			$fields['font_family']['group']    = $args['group'];
			$fields['font_size']['group']      = $args['group'];
			$fields['font_weight']['group']    = $args['group'];
			$fields['text_transform']['group'] = $args['group'];
			$fields['font_style']['group']     = $args['group'];
			$fields['line_height']['group']    = $args['group'];
		}

		if ( isset( $args['dependency'] ) ) {
			$fields['font_family']['dependency']    = $args['dependency'];
			$fields['font_size']['dependency']      = $args['dependency'];
			$fields['font_weight']['dependency']    = $args['dependency'];
			$fields['text_transform']['dependency'] = $args['dependency'];
			$fields['font_style']['dependency']     = $args['dependency'];
			$fields['line_height']['dependency']    = $args['dependency'];
		}

		if ( isset( $args['wd_dependency'] ) ) {
			$fields['font_family']['wd_dependency']    = $args['wd_dependency'];
			$fields['font_size']['wd_dependency']      = $args['wd_dependency'];
			$fields['font_weight']['wd_dependency']    = $args['wd_dependency'];
			$fields['text_transform']['wd_dependency'] = $args['wd_dependency'];
			$fields['font_style']['wd_dependency']     = $args['wd_dependency'];
			$fields['line_height']['wd_dependency']    = $args['wd_dependency'];
		}

		return $fields;
	}
}

if ( ! function_exists( 'woodmart_vc_get_control_data' ) ) {
	/**
	 * Get control data.
	 *
	 * @param mixed  $data   Data.
	 * @param string $device Device name.
	 *
	 * @return string
	 */
	function woodmart_vc_get_control_data( $data, $device ) {
		$data_decoded = json_decode( woodmart_decompress( $data ), true );

		if ( ! is_array( $data_decoded ) ) {
			return $data;
		}

		if ( isset( $data_decoded['devices'][ $device ] ) ) {
			return $data_decoded['devices'][ $device ]['value'];
		}

		return '';
	}
}

if ( ! function_exists( 'woodmart_parse_shortcodes_css_data_new' ) ) {
	/**
	 * This function parse post content data and return fields params.
	 *
	 * @param mixed $content post content.
	 *
	 * @return string|void
	 * @throws Exception .
	 */
	function woodmart_parse_shortcodes_css_data_new( $content ) {
		$css_data = array();

		if ( ! class_exists( 'WPBMap' ) ) {
			return;
		}

		$woodmart_fields = array(
			'wd_slider',
			'wd_number',
			'wd_box_shadow',
			'wd_colorpicker',
			'wd_select',
			'wd_fonts',
			'wd_dimensions',
		);

		WPBMap::addAllMappedShortcodes();
		preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );

		foreach ( $shortcodes[2] as $index => $tag ) {
			$shortcode  = WPBMap::getShortCode( $tag );
			$attr_array = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );

			if ( isset( $shortcode['params'] ) && ! empty( $shortcode['params'] ) ) {
				foreach ( $shortcode['params'] as $param ) {
					if ( isset( $param['type'] ) && in_array( $param['type'], $woodmart_fields, true ) && isset( $attr_array[ $param['param_name'] ] ) ) {
						$css_data[] = array(
							'selector_id' => $attr_array['woodmart_css_id'],
							'tag'         => $tag,
							'param_name'  => $param['param_name'],
							'value'       => $attr_array[ $param['param_name'] ],
						);
					}
				}
			}
		}

		foreach ( $shortcodes[5] as $shortcode_content ) {
			$css_data = array_merge( $css_data, woodmart_parse_shortcodes_css_data_new( $shortcode_content ) );
		}

		return $css_data;
	}
}

if ( ! function_exists( 'woodmart_get_fields_css' ) ) {
	/**
	 * This function return field css.
	 *
	 * @param int $post_id Post id.
	 *
	 * @throws Exception .
	 */
	function woodmart_get_fields_css( $post_id ) {
		$post       = get_post( $post_id );
		$data_array = woodmart_parse_shortcodes_css_data_new( $post->post_content );

		return woodmart_fields_css_data_to_css( $data_array, $post_id );
	}
}

if ( ! function_exists( 'woodmart_save_fields_css' ) ) {
	/**
	 * This function save field css.
	 *
	 * @param int $post_id Post id.
	 *
	 * @throws Exception .
	 */
	function woodmart_save_fields_css( $post_id ) {
		$css  = woodmart_get_fields_css( $post_id );
		$css .= woodmart_get_fields_css_old( $post_id );

		if ( empty( $css ) ) {
			delete_post_meta( $post_id, 'woodmart_shortcodes_custom_css' );
		} else {
			update_post_meta( $post_id, 'woodmart_shortcodes_custom_css', $css );
		}
	}

	add_action( 'save_post', 'woodmart_save_fields_css' );
}

if ( ! function_exists( 'woodmart_fields_css_data_to_css' ) ) {
	/**
	 * This function prepares the css.
	 *
	 * @param array $css_data array with css data in base64.
	 * @param int   $post_id  Post id.
	 *
	 * @return string $result finished css.
	 */
	function woodmart_fields_css_data_to_css( $data_array, $post_id ) {
		$sorted_css_data_raw = array();
		$fonts               = array();

		foreach ( $data_array as $data ) {
			$decompressed_data = function_exists( 'woodmart_decompress' ) ? json_decode( woodmart_decompress( $data['value'] ), true ) : '';
			$params            = WPBMap::getParam( $data['tag'], $data['param_name'] );

			if ( isset( $params['selectors'] ) && $params['selectors'] ) {
				$wrapper = '.wd-rs-' . $data['selector_id'];

				if ( ! isset( $decompressed_data['devices'] ) ) {
					continue;
				}
				foreach ( $decompressed_data['devices'] as $device => $device_value ) {
					foreach ( $params['selectors'] as $selector => $properties ) {
						$selector = str_replace( '{{WRAPPER}}', $wrapper, $selector );

						foreach ( $properties as $property ) {
							$result = '';

							if ( false !== stripos( $property, 'box-shadow' ) ) {
								if ( empty( $device_value['color'] ) ) {
									continue;
								}

								$result = str_replace( '{{HORIZONTAL}}', $device_value['horizontal'], $property );
								$result = str_replace( '{{VERTICAL}}', $device_value['vertical'], $result );
								$result = str_replace( '{{BLUR}}', $device_value['blur'], $result );
								$result = str_replace( '{{SPREAD}}', $device_value['spread'], $result );
								$result = str_replace( '{{COLOR}}', $device_value['color'], $result );
							} elseif ( isset( $params['type'] ) && 'wd_dimensions' === $params['type'] ) {
								if ( false !== stripos( $property, 'top' ) && ( $device_value['top'] || '0' === $device_value['top'] ) ) {
									$result .= str_replace( '{{TOP}}', $device_value['top'], $property );
								}
								if ( false !== stripos( $property, 'right' ) && ( $device_value['right'] || '0' === $device_value['right'] ) ) {
									$result .= str_replace( '{{RIGHT}}', $device_value['right'], $property );
								}
								if ( false !== stripos( $property, 'bottom' ) && ( $device_value['bottom'] || '0' === $device_value['bottom'] ) ) {
									$result .= str_replace( '{{BOTTOM}}', $device_value['bottom'], $property );
								}
								if ( false !== stripos( $property, 'left' ) && ( $device_value['left'] || '0' === $device_value['left'] ) ) {
									$result .= str_replace( '{{LEFT}}', $device_value['left'], $property );
								}

								$result = str_replace( '{{UNIT}}', $device_value['unit'], $result );
							} else {
								if ( empty( $device_value['value'] ) || '-' === $device_value['value'] ) {
									continue;
								}

								if ( false !== stripos( $property, 'font-family' ) ) {
									$standard_fonts = woodmart_get_config( 'standard-fonts' );
									$backup_fonts   = apply_filters( 'woodmart_backup_fonts', ', Arial, Helvetica, sans-serif' );

									$fonts[ $selector ]['font-family'] = $device_value['value'];

									if ( ! array_key_exists( $device_value['value'], $standard_fonts ) ) {
										$fonts[ $selector ]['google'] = true;
										$device_value['value']        = '"' . $device_value['value'] . '"' . $backup_fonts;
									}
								}

								if ( false !== stripos( $property, 'font-weight' ) ) {
									$fonts[ $selector ]['font-weight'] = $device_value['value'];
								}

								if ( false !== stripos( $property, 'font-style' ) ) {
									$fonts[ $selector ]['font-style'] = $device_value['value'];
								}

								$result = str_replace( '{{VALUE}}', $device_value['value'], $property );

								if ( isset( $device_value['unit'] ) ) {
									$result = str_replace( '{{UNIT}}', $device_value['unit'], $result );
								}
							}

							if ( $result ) {
								$sorted_css_data_raw[ $device ][ $selector ][] = $result;
							}
						}
					}
				}
			}
		}

		woodmart_save_fields_fonts( $fonts, $post_id );

		$sorted_css_data = array();

		foreach ( $sorted_css_data_raw as $device => $styles ) {
			foreach ( $styles as $selector => $properties ) {
				$css = $selector . '{';

				foreach ( $properties as $property ) {
					$css .= $property;
				}

				$css .= '}';

				$sorted_css_data[ $device ][] = $css;
			}
		}

		$css_list = array();
		$css      = '';

		foreach ( $sorted_css_data as $device => $styles ) {
			if ( 'desktop' === $device ) {
				$css_list['desktop'] = implode( '', $styles );
			}
			if ( 'tablet' === $device ) {
				$css_list['tablet'] = implode( '', $styles );
			}
			if ( 'mobile' === $device ) {
				$css_list['mobile'] = implode( '', $styles );
			}
		}

		if ( isset( $css_list['desktop'] ) ) {
			$css .= $css_list['desktop'];
		}

		if ( isset( $css_list['tablet'] ) ) {
			$device_styles = $css_list['tablet'];
			$css          .= "@media (max-width: 1199px) { $device_styles }";
		}

		if ( isset( $css_list['mobile'] ) ) {
			$device_styles = $css_list['mobile'];
			$css          .= "@media (max-width: 767px) { $device_styles }";
		}

		return $css;
	}
}

if ( ! function_exists( 'woodmart_save_fields_fonts' ) ) {
	/**
	 * Save shortcodes fonts.
	 *
	 * @param array $fonts   Fonts array.
	 * @param int   $post_id Post id.
	 *
	 * @return void
	 */
	function woodmart_save_fields_fonts( $fonts, $post_id ) {
		if ( empty( $fonts ) ) {
			delete_post_meta( $post_id, 'woodmart_shortcodes_fonts' );
		} else {
			update_post_meta( $post_id, 'woodmart_shortcodes_fonts', $fonts );
		}
	}
}

if ( ! function_exists( 'woodmart_load_fields_fonts' ) ) {
	/**
	 * Load fields fonts.
	 */
	function woodmart_load_fields_fonts() {
		$id = get_the_ID();

		if ( Main::get_instance()->has_custom_layout( 'single_product' ) && ! is_singular( 'woodmart_layout' )
		) {
			$id = Main::get_instance()->get_layout_id( 'single_product' );
		}

		$fonts = get_post_meta( $id, 'woodmart_shortcodes_fonts', true );

		if ( ! $fonts ) {
			return;
		}

		foreach ( $fonts as $i => $typography ) {
			Google_Fonts::add_google_font( $typography );
		}
	}

	add_action( 'wp', 'woodmart_load_fields_fonts' );
}
