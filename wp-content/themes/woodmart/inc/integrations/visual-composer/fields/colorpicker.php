<?php
/**
 * Color picker.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_colorpicker_param' ) ) {
	/**
	 * Color picker.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return string
	 */
	function woodmart_get_colorpicker_param( $settings, $value ) {
		ob_start();
		?>
		<div class="woodmart-vc-colorpicker" id="<?php echo esc_attr( uniqid() ); ?>">
			<input name="color" class="woodmart-vc-colorpicker-input" type="text">
			<input type="hidden" class="woodmart-vc-colorpicker-value wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" data-css_args="<?php echo esc_attr( wp_json_encode( $settings['css_args'] ) ); ?>" value="<?php echo esc_attr( $value ); ?>">
		</div>
		<?php
		return ob_get_clean();
	}
}
