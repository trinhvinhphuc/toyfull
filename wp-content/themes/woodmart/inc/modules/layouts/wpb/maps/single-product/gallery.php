<?php
/**
 * Gallery map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_product_gallery' ) ) {
	/**
	 * Gallery map.
	 */
	function woodmart_vc_map_single_product_gallery() {
		if ( ! shortcode_exists( 'woodmart_single_product_gallery' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_single_product_gallery',
				'name'        => esc_html__( 'Product gallery', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'Featured image and product gallery', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-gallery.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'     => esc_html__( 'Thumbnails position', 'woodmart' ),
						'type'        => 'dropdown',
						'param_name'  => 'thumbnails_position',
						'description' => esc_html__( 'Set your thumbnails display or leave default set from Theme Settings.', 'woodmart' ),
						'value'       => array(
							esc_html__( 'Inherit from Theme Settings', 'woodmart' )  => 'inherit',
							esc_html__( 'Left (vertical position)', 'woodmart' )     => 'left',
							esc_html__( 'Bottom (horizontal carousel)', 'woodmart' ) => 'bottom',
							esc_html__( 'Bottom (1 column)', 'woodmart' )            => 'bottom_column',
							esc_html__( 'Bottom (2 columns)', 'woodmart' )           => 'bottom_grid',
							esc_html__( 'Carousel (2 columns)', 'woodmart' )         => 'carousel_two_columns',
							esc_html__( 'Combined grid', 'woodmart' )                => 'bottom_combined',
							esc_html__( 'Centered', 'woodmart' )                     => 'centered',
							esc_html__( 'Without', 'woodmart' )                      => 'without',
						),
					),

					array(
						'heading'    => esc_html__( 'CSS box', 'woodmart' ),
						'group'      => esc_html__( 'Design Options', 'js_composer' ),
						'type'       => 'css_editor',
						'param_name' => 'css',
					),
					woodmart_get_vc_responsive_spacing_map(),
				),
			)
		);

	}
	add_action( 'vc_before_init', 'woodmart_vc_map_single_product_gallery' );
}
