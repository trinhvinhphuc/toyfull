<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* AJAX search shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_ajax_search' ) ) {
	function woodmart_ajax_search( $atts ) {
		$class = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$atts = shortcode_atts(
			array(
				'woodmart_css_id'       => '',
				'css'                   => '',
				'number'                => 3,
				'price'                 => 1,
				'thumbnail'             => 1,
				'category'              => 1,
				'search_post_type'      => 'product',
				'woodmart_color_scheme' => 'dark',
				'el_class'              => '',
			),
			$atts
		);

		$class .= ' wd-color-' . $atts['woodmart_color_scheme'];
		$class .= ' ' . $atts['el_class'];
		if( function_exists( 'vc_shortcode_custom_css_class' ) ) $class .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );

		$class .= woodmart_get_old_classes( ' woodmart-vc-ajax-search' );

		ob_start();
		?>
			<div class="wd-el-search wd-wpb woodmart-ajax-search <?php echo esc_attr( $class ); ?>">
				<?php
					woodmart_search_form(
						array(
							'ajax'            => true,
							'post_type'       => $atts['search_post_type'],
							'count'           => $atts['number'],
							'thumbnail'       => $atts['thumbnail'],
							'price'           => $atts['price'],
							'show_categories' => $atts['category'],
						)
					);
				?>
			</div>
		<?php

		return ob_get_clean();
	}
}
