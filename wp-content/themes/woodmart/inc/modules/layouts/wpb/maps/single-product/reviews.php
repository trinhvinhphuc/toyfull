<?php
/**
 * Reviews map.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_vc_map_single_product_reviews' ) ) {
	/**
	 * Reviews map.
	 */
	function woodmart_vc_map_single_product_reviews() {
		if ( ! shortcode_exists( 'woodmart_single_product_reviews' ) || ! Main::is_layout_type( 'single_product' ) ) {
			return;
		}

		vc_map(
			array(
				'base'        => 'woodmart_single_product_reviews',
				'name'        => esc_html__( 'Product reviews', 'woodmart' ),
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
				'description' => esc_html__( 'Reviews and review form', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-reviews.svg',
				'params'      => array(
					array(
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'heading'          => esc_html__( 'Layout', 'woodmart' ),
						'type'             => 'wd_select',
						'param_name'       => 'layout',
						'style'            => 'select',
						'selectors'        => array(),
						'devices'          => array(
							'desktop' => array(
								'value' => 'one-column',
							),
						),
						'value'            => array(
							esc_html__( 'One column', 'woodmart' ) => 'one-column',
							esc_html__( 'Two columns', 'woodmart' ) => 'two-column',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
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
	add_action( 'vc_before_init', 'woodmart_vc_map_single_product_reviews' );
}
