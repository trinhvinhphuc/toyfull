<?php
/**
 * Woodmart slider responsive param.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_slider_responsive_param' ) ) {
	/**
	 * Woodmart slider param.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return string
	 */
	function woodmart_get_slider_responsive_param( $settings, $value ) {
		$param_name = $settings['param_name'];

		$data = json_decode( woodmart_decompress( $value ), true );

		if ( isset( $data['devices'] ) ) {
			$settings['default'] = $settings['devices'];

			foreach ( $data['devices'] as $device => $device_settings ) {
				$settings['devices'][ $device ] = $data['devices'][ $device ];
			}
		}

		ob_start();
		?>
		<div class="wd-sliders">
			<?php if ( 1 < count( $settings['devices'] ) ) : ?>
				<div class="wd-field-devices">
					<?php foreach ( $settings['devices'] as $device => $device_settings ) : ?>
						<?php
						$device_classes = ' wd-' . $device;

						if ( array_key_first( $settings['devices'] ) === $device ) {
							$device_classes .= ' xts-active';
						}
						?>

						<span class="wd-device<?php echo esc_attr( $device_classes ); ?>" data-value="<?php echo esc_attr( $device ); ?>">
							<span><?php echo esc_attr( $device ); ?></span>
						</span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php foreach ( $settings['devices'] as $device => $device_settings ) : ?>
				<?php echo woodmart_render_slider_responsive( $device, $settings, $device_settings ); // phpcs:ignore ?>
			<?php endforeach; ?>

			<input type="hidden" class="wpb_vc_param_value" name="<?php echo esc_attr( $param_name ); ?>" id="<?php echo esc_attr( $param_name ); ?>" value="<?php echo esc_attr( $value ); ?>" data-settings="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>">
		</div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_render_slider_responsive' ) ) {
	/**
	 * This function render slider responsive.
	 *
	 * @param string $device          Device name ( 'desktop', 'tablet', 'mobile' ).
	 * @param array  $settings        All slider responsive settings.
	 * @param array  $device_settings Device settings.
	 *
	 * @return false|string
	 */
	function woodmart_render_slider_responsive( $device, $settings, $device_settings ) {
		ob_start();

		$slider_classes = '';

		if ( array_key_first( $settings['devices'] ) === $device ) {
			$slider_classes .= ' xts-active';
		}

		$value = isset( $device_settings['value'] ) ? $device_settings['value'] : '';

		?>
		<div class="wd-slider<?php echo esc_attr( $slider_classes ); ?>" data-device="<?php echo esc_attr( $device ); ?>" data-value="<?php echo esc_attr( $value ); ?>" data-unit="<?php echo esc_attr( $device_settings['unit'] ); ?>">

			<div class="wd-slider-field"></div>

			<span class="wd-slider-field-value-display">
				<input type="number" class="wd-slider-value-preview" aria-label="<?php esc_attr_e( 'Preview', 'woodmart' ); ?>">
			</span>

			<span class="wd-slider-units">
				<?php foreach ( $settings['range'] as $unit => $value ) : ?>
					<?php if ( '-' !== $unit ) : ?>
							<?php

						$unit_classes = '';

						if ( $unit === $settings['devices'][ $device ]['unit'] ) {
							$unit_classes .= ' xts-active';
						}
						?>
						<span class="wd-slider-unit-control<?php echo esc_attr( $unit_classes ); ?>" data-unit="<?php echo esc_attr( $unit ); ?>">
							<?php echo esc_html( $unit ); ?>
						</span>
					<?php endif; ?>
				<?php endforeach; ?>
			</span>
		</div>
		<?php
		return ob_get_clean();
	}
}
