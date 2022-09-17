<?php
/**
 * Mailchimp shortcode file.
 *
 * @package Shortcode.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_mailchimp' ) ) {
	function woodmart_shortcode_mailchimp( $atts ) {
		$mc4wp_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$atts = shortcode_atts(
			array(
				'woodmart_css_id' => uniqid(),
				'alignment'       => 'center',
				'form_id'         => '',
				'color_scheme'    => 'inherit',
				'extra_classes'   => '',
				'css'             => '',
			),
			$atts
		);

		ob_start();

		$woodmart_css_id = '';
		$mc4wp_classes  .= ' text-' . $atts['alignment'];

		if ( ! empty( $atts['woodmart_css_id'] ) ) {
			$woodmart_css_id .= $atts['woodmart_css_id'];
		}

		if ( ! empty( $atts['extra_classes'] ) ) {
			$mc4wp_classes .= ' ' . $atts['extra_classes'];
		}
		if ( 'inherit' !== $atts['color_scheme'] ) {
			$mc4wp_classes .= ' color-scheme-' . $atts['color_scheme'];
		}
		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$mc4wp_classes .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}

		if ( ! $atts['form_id'] || ! defined( 'MC4WP_VERSION' ) ) {
			return false;
		}

		woodmart_enqueue_inline_style( 'mc4wp', true );

		?>

		<div id="<?php echo esc_attr( 'wd-' . $woodmart_css_id ); ?>" class="wd-wpb wd-mc4wp-wrapper<?php echo esc_attr( $mc4wp_classes ); ?>">
			<?php
				echo do_shortcode( '[mc4wp_form id="' . esc_attr( $atts['form_id'] ) . '"]' );
			?>
		</div>

		<?php
		return ob_get_clean();
	}
}
