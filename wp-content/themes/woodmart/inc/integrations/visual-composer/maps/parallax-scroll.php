<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_parallax_scroll_map' ) ) {
	function woodmart_parallax_scroll_map( $key ) {
		$map = array(
			'parallax_scroll' => array(
				'type'             => 'woodmart_switch',
				'heading'          => esc_html__( 'Enable parallax on mouse scroll', 'woodmart' ),
				'param_name'       => 'parallax_scroll',
				'true_state'       => 'yes',
				'false_state'      => 'no',
				'default'          => 'no',
				'dependency'       => array(
					'element' => 'wd_column_role',
					'value'   => array( '' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			'scroll_x'        => array(
				'heading'          => esc_html__( 'X axis translation', 'woodmart' ),
				'hint'             => esc_html__( 'Recommended -200 to 200', 'woodmart' ),
				'type'             => 'textfield',
				'param_name'       => 'scroll_x',
				'value'            => 0,
				'dependency'       => array(
					'element' => 'parallax_scroll',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			'scroll_y'        => array(
				'heading'          => esc_html__( 'Y axis translation', 'woodmart' ),
				'hint'             => esc_html__( 'Recommended -200 to 200', 'woodmart' ),
				'type'             => 'textfield',
				'param_name'       => 'scroll_y',
				'value'            => -80,
				'dependency'       => array(
					'element' => 'parallax_scroll',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			'scroll_z'        => array(
				'heading'          => esc_html__( 'Z axis translation', 'woodmart' ),
				'hint'             => esc_html__( 'Recommended -200 to 200', 'woodmart' ),
				'type'             => 'textfield',
				'param_name'       => 'scroll_z',
				'value'            => 0,
				'dependency'       => array(
					'element' => 'parallax_scroll',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			'scroll_smooth'   => array(
				'heading'          => esc_html__( 'Parallax speed', 'woodmart' ),
				'hint'             => esc_html__( 'Define the parallax speed on mouse scroll. By default - 30', 'woodmart' ),
				'type'             => 'dropdown',
				'param_name'       => 'scroll_smooth',
				'value'            => array( '', 10, 20, 30, 40, 50, 60, 70, 80, 90, 100 ),
				'dependency'       => array(
					'element' => 'parallax_scroll',
					'value'   => array( 'yes' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
		);

		return array_key_exists( $key, $map ) ? $map[ $key ] : array();
	}
}

if ( ! function_exists( 'woodmart_parallax_scroll_data' ) ) {
	function woodmart_parallax_scroll_data( $x, $y, $z, $smooth ) {
		$data = array();

		woodmart_enqueue_js_library( 'parallax-scroll-bundle' );

		if ( $x ) {
			$data[] = '"x":"' . $x . '"';
		}
		if ( $y ) {
			$data[] = '"y":"' . $y . '"';
		}
		if ( $z ) {
			$data[] = '"z":"' . $z . '"';
		}
		if ( $smooth ) {
			$data[] = '"smoothness":"' . $smooth . '"';
		}

		return 'data-parallax=\'{' . implode( ',', $data ) . '}\' ';
	}
}

if ( ! function_exists( 'woodmart_parallax_scroll' ) ) {
	function woodmart_parallax_scroll( $output, $obj, $attr, $shortcode ) {
		if ( isset( $attr['parallax_scroll'] ) && $attr['parallax_scroll'] == 'yes' ) {
			$x      = $attr['scroll_x'] ? $attr['scroll_x'] : 0;
			$y      = $attr['scroll_y'] ? $attr['scroll_y'] : -80;
			$z      = $attr['scroll_z'] ? $attr['scroll_z'] : 0;
			$smooth = isset( $attr['scroll_smooth'] ) && $attr['scroll_smooth'] ? $attr['scroll_smooth'] : 30;

			$parallax = woodmart_parallax_scroll_data( $x, $y, $z, $smooth );
			$element  = '';

			if ( strpos( $output, 'wpb_single_image' ) !== false ) {
				$element = 'wpb_single_image';
			} elseif ( strpos( $output, 'wpb_column' ) !== false ) {
				$element = 'wpb_column';
			} elseif ( strpos( $output, 'wd-image' ) !== false ) {
				$element = 'wd-image';
			} elseif ( strpos( $output, 'wd-text-block' ) !== false ) {
				$element = 'wd-text-block';
			}

			$output = preg_replace( '/<div(.*?)class="' . $element . '/is', '<div$1' . $parallax . 'class="' . $element, $output, 1 );
		}
		return $output;
	}
}

add_filter( 'vc_shortcode_output', 'woodmart_parallax_scroll', 10, 4 );

// Fixed problem with custom class and parallax scroll for wpb column
if ( ! function_exists( 'woodmart_wpb_class_sorting' ) ) {
	function woodmart_wpb_class_sorting( $css_classes ) {
		$css_classes = array_filter( explode( ' ', $css_classes ) );
		if ( in_array( 'wpb_column', $css_classes ) ) {
			array_unshift( $css_classes, 'wpb_column' );
		}
		$css_classes = implode( ' ', array_unique( $css_classes ) );
		return $css_classes;
	}
}

add_filter( 'vc_shortcodes_css_class', 'woodmart_wpb_class_sorting' );
