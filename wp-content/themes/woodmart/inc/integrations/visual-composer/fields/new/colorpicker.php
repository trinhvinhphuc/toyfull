<?php
/**
 * Woodmart colorpicker.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_wd_colorpicker_param' ) ) {
	/**
	 * Woodmart colorpicker param.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return string
	 */
	function woodmart_get_wd_colorpicker_param( $settings, $value ) {
		$param_name  = $settings['param_name'];
		$data        = json_decode( woodmart_decompress( $value ), true );
		$color_value = '';

		if ( ! empty( $data['devices']['desktop']['value'] ) ) {
			$color_value = $data['devices']['desktop']['value'];
		} elseif ( ! empty( $settings['default']['value'] ) ) {
			$color_value = $settings['default']['value'];
		}

		ob_start();
		?>
		<div class="wd-colorpicker">
			<input name="color" class="color-picker wd-vc-colorpicker-input" type="text" data-alpha-enabled="true" value="<?php echo esc_attr( $color_value ); ?>" aria-label="<?php esc_attr_e( 'Color picker', 'woodmart' ); ?>">
			<input type="hidden" class="wpb_vc_param_value" name="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $value ); ?>" data-settings="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>">
		</div>
		<?php
		return ob_get_clean();
	}
}
