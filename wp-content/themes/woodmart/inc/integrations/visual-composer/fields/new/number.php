<?php
/**
 * This file has function for rendering Number field.
 *
 * @package Woodmart.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_number_param' ) ) {
	/**
	 * This function rendering Number field.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return false|string
	 */
	function woodmart_get_number_param( $settings, $value ) {
		$data = json_decode( woodmart_decompress( $value ), true );

		if ( isset( $data['devices'] ) ) {
			$settings['devices'] = $data['devices'];
		}

		ob_start();
		?>
		<div class="wd-numbers">
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
				<?php
				$classes = '';

				if ( array_key_first( $settings['devices'] ) === $device ) {
					$classes .= ' xts-active';
				}
				?>

				<input aria-label="<?php esc_attr_e( 'Number', 'woodmart' ); ?>" type="number" class="wd-number<?php echo esc_attr( $classes ); ?>" min="<?php echo esc_attr( $settings['min'] ); ?>" max="<?php echo esc_attr( $settings['max'] ); ?>" step="<?php echo esc_attr( $settings['step'] ); ?>" data-device="<?php echo esc_attr( $device ); ?>" value="<?php echo esc_attr( $device_settings['value'] ); ?>">

			<?php endforeach; ?>

			<input type="hidden" class="wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>" data-settings="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>">
		</div>
		<?php
		return ob_get_clean();
	}
}
