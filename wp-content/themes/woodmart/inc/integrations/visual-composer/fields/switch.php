<?php
/**
 * This file creates html for the woodmart_switch field in WPBakery.
 *
 * @package Woodmart.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
* Woodmart switch param
*/
if ( ! function_exists( 'woodmart_get_switch_param' ) ) {
	/**
	 * This function creates html for the woodmart_switch field in WPBakery.
	 *
	 * @param array $settings .
	 * @param array $value .
	 * @return string
	 */
	function woodmart_get_switch_param( $settings, $value ) {
		if ( '0' === $value ) {
			$value = 0;
		} elseif ( empty( $value ) && isset( $settings['default'] ) ) {
			$value = $settings['default'];
		}

		$settings['true_text']  = isset( $settings['true_text'] ) ? $settings['true_text'] : esc_html__( 'Yes', 'woodmart' );
		$settings['false_text'] = isset( $settings['false_text'] ) ? $settings['false_text'] : esc_html__( 'No', 'woodmart' );

		ob_start();
		?>
			<div class="woodmart-vc-switch">
				<input type="hidden" class="switch-field-value wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>">
				<div class="woodmart-vc-switch-inner">
					<div class="switch-controls switch-active" data-value="<?php echo esc_attr( $settings['true_state'] ); ?>">
						<span>
							<?php echo esc_html( $settings['true_text'] ); ?>
						</span>
					</div>
					<div class="switch-controls switch-inactive" data-value="<?php echo esc_attr( $settings['false_state'] ); ?>">
						<span>
							<?php echo esc_html( $settings['false_text'] ); ?>
						</span>
					</div>
				</div>
			</div>
		<?php

		return ob_get_clean();
	}
}
