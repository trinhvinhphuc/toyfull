<?php
/**
 * This file has function for rendering dropdown field.
 *
 * @package Woodmart.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_select_param' ) ) {
	/**
	 * This function rendering dropdown field.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return false|string
	 */
	function woodmart_get_select_param( $settings, $value ) {
		$devices = $settings['devices'];
		$data    = json_decode( woodmart_decompress( $value ), true );
		if ( isset( $data['devices'] ) ) {
			$settings['default'] = $settings['devices'];
			$settings['devices'] = $data['devices'];
		}

		$wrapper_classes = ' wd-style-' . $settings['style'];

		if ( isset( $settings['responsive_inherit'] ) ) {
			$wrapper_classes .= ' wd-responsive-inherit';
		}

		ob_start();
		?>
		<div class="wd-select-fields<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php if ( 1 < count( $devices ) ) : ?>
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
				$select_classes = '';

				if ( array_key_first( $settings['devices'] ) === $device ) {
					$select_classes .= ' xts-active';
				}
				?>

				<div class="wd-select-wrapper<?php echo esc_attr( $select_classes ); ?>" data-device="<?php echo esc_attr( $device ); ?>">
					<?php if ( 'images' === $settings['style'] || 'buttons' === $settings['style'] ) : ?>
						<ul class="wd-select-buttons">
							<?php foreach ( $settings['value'] as $label => $buttons_value ) : ?>
								<?php
								$buttons_classes = '';

								if ( $device_settings['value'] === $buttons_value ) {
									$buttons_classes .= ' xts-active';
								}

								if ( 'images' === $settings['style'] ) {
									$buttons_classes .= ' woodmart-css-tooltip';
								}
								?>

								<li class="wd-buttons-item<?php echo esc_attr( $buttons_classes ); ?>" data-value="<?php echo esc_html( $buttons_value ); ?>" data-text="<?php echo esc_html( $label ); ?>">
									<?php if ( 'images' === $settings['style'] ) : ?>
										<img src="<?php echo esc_url( $settings['images'][ $buttons_value ] ); ?>" alt="<?php echo esc_attr( $buttons_value ); ?>">
									<?php else : ?>
										<span>
											<?php echo esc_html( $label ); ?>
										</span>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<select class="wd-select" aria-label="<?php esc_attr_e( 'Dropdown', 'woodmart' ); ?>" <?php echo isset( $settings['multiple'] ) ? 'multiple' : ''; ?>>
						<?php if ( isset( $settings['responsive_inherit'] ) && 'desktop' !== $device ) : ?>
							<option value="">
								<?php esc_html_e( 'Inherit', 'woodmart' ); ?>
							</option>
						<?php endif; ?>

						<?php foreach ( $settings['value'] as $label => $option_value ) : ?>
							<?php
							$selected = false;

							if ( is_array( $device_settings['value'] ) && in_array( $option_value, $device_settings['value'], false ) ) { // phpcs:ignore
								$selected = true;
							} elseif ( ! is_array( $device_settings['value'] ) && strval( $option_value ) === strval( $device_settings['value'] ) ) {
								$selected = true;
							}

							?>
							<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( true, $selected ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>

						<?php if ( isset( $settings['options_group'] ) ) : ?>
							<?php foreach ( $settings['options_group'] as $group => $values ) : ?>
								<optgroup label="<?php echo esc_attr( $group ); ?>">
									<?php foreach ( $values as $label => $group_value ) : ?>
										<option value="<?php echo esc_attr( $group_value ); ?>" <?php selected( $group_value, $device_settings['value'] ); ?>>
											<?php echo esc_html( $label ); ?>
										</option>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			<?php endforeach; ?>

			<input type="hidden" class="wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>" data-settings="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>">
		</div>
		<?php
		return ob_get_clean();
	}
}
