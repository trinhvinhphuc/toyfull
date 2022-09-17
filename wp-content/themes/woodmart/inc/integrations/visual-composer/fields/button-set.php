<?php
/**
 * Button set param.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_button_set_param' ) ) {
	/**
	 * Button set param.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return string
	 */
	function woodmart_get_button_set_param( $settings, $value ) {
		if ( ! $value && isset( $settings['default'] ) ) {
			$current_value = $settings['default'];
		} else {
			$current_value = $value;
		}

		$wrapper_classes = '';

		if ( isset( $settings['tabs'] ) ) {
			$current_value    = array_values( $settings['value'] )[0];
			$wrapper_classes .= ' wd-tabs';
		}

		ob_start();
		?>
		<div class="wd-select-fields wd-style-buttons woodmart-vc-button-set<?php echo esc_attr( $wrapper_classes ); ?>">
			<input type="hidden" class="woodmart-vc-button-set-value wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $current_value ); ?>">
		
			<ul class="wd-select-buttons woodmart-vc-button-set-list">
				<?php foreach ( $settings['value'] as $title => $value ) : ?>
					<?php
					$classes = '';

					if ( $current_value === $value ) {
						$classes .= ' xts-active';
					}
					?>

					<li class="wd-buttons-item vc-button-set-item<?php echo esc_attr( $classes ); ?>" data-value="<?php echo esc_html( $value ); ?>">
						<span>
							<?php echo esc_html( $title ); ?>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}
}
