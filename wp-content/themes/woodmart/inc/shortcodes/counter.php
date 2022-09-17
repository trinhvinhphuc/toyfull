<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Counter shortcode
* ------------------------------------------------------------------------------------------------
*/
if ( ! function_exists( 'woodmart_shortcode_animated_counter' ) ) {
	function woodmart_shortcode_animated_counter( $atts ) {
		$output   = '';
		$el_class = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$atts = shortcode_atts(
			array(
				'label'           => '',
				'value'           => 100,
				'time'            => 1000,
				'color_scheme'    => '',
				'color'           => '',
				'size'            => 'default',
				'font_weight'     => 600,
				'align'           => 'center',
				'css'             => '',
				'css_animation'   => 'none',
				'el_class'        => '',
				'woodmart_css_id' => '',
			),
			$atts
		);

		if ( ! $atts['woodmart_css_id'] ) {
			$atts['woodmart_css_id'] = uniqid();
		}
		$counter_id = 'wd-' . $atts['woodmart_css_id'];

		$el_class .= ! empty( $atts['el_class'] ) ? ' ' . $atts['el_class'] : '';
		$el_class .= ' counter-' . $atts['size'];
		$el_class .= ' text-' . $atts['align'];
		$el_class .= ' color-scheme-' . $atts['color_scheme'];
		$el_class .= woodmart_get_css_animation( $atts['css_animation'] );

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$el_class .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}

		ob_start();

		woodmart_enqueue_js_library( 'waypoints' );
		woodmart_enqueue_js_script( 'counter-element' );
		woodmart_enqueue_inline_style( 'counter' );

		?>
			<div class="woodmart-counter wd-wpb <?php echo esc_attr( $el_class ); ?>" id="<?php echo esc_attr( $counter_id ); ?>">
				<div class="counter-value wd-font-weight-<?php echo esc_attr( $atts['font_weight'] ); ?>" data-state="new" data-final="<?php echo esc_attr( $atts['value'] ); ?>"><?php echo esc_attr( $atts['value'] ); ?></div>
				<?php if ( '' !== $atts['label'] ) : ?>
					<div class="counter-label"><?php echo esc_html( $atts['label'] ); ?></div>
				<?php endif ?>
				<?php
				if ( 'custom' === $atts['color_scheme'] && $atts['color'] && ! woodmart_is_css_encode( $atts['color'] ) ) {
					$atts['css']  = '.woodmart-counter#' . esc_attr( $counter_id ) . '{';
					$atts['css'] .= 'color: ' . esc_attr( $atts['color'] ) . ';';
					$atts['css'] .= '}';
					wp_add_inline_style( 'woodmart-inline-css', $atts['css'] );
				}
				?>
			</div>

		<?php
		$output .= ob_get_clean();

		return $output;
	}
}
