<?php
/**
 * Woodmart slider param.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_slider_param' ) ) {
	/**
	 * Woodmart slider param.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return string
	 */
	function woodmart_get_slider_param( $settings, $value ) {
		$value = $value ? $value : $settings['default'];

		ob_start();

		$param_name = $settings['param_name'];
		$css_args   = isset( $settings['css_args'] ) ? wp_json_encode( $settings['css_args'] ) : '';
		$css_params = isset( $settings['css_params'] ) ? wp_json_encode( $settings['css_params'] ) : '';
		?>
		<div class="woodmart-vc-slider">
			<div class="wd-slider-field"></div>

			<input type="hidden" class="wd-slider-field-value wpb_vc_param_value" name="<?php echo esc_attr( $param_name ); ?>" id="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $value ); ?>" data-min="<?php echo esc_attr( $settings['min'] ); ?>" data-max="<?php echo esc_attr( $settings['max'] ); ?>" data-step="<?php echo esc_attr( $settings['step'] ); ?>" data-css_params="<?php echo esc_attr( $css_params ); ?>" data-css_args="<?php echo esc_attr( $css_args ); ?>">

			<span class="wd-slider-field-value-display">
				<span class="wd-slider-value-preview"></span>
			</span>

			<span class="wd-slider-units">
				<span class="wd-slider-unit-control xts-active"><?php echo esc_attr( $settings['units'] ); ?></span>
			</span>
		</div>
		<?php
		return ob_get_clean();
	}
}
