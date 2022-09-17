<?php
/**
 * Box shadow.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_box_shadow_param' ) ) {
	/**
	 * Box shadow.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return string
	 */
	function woodmart_get_box_shadow_param( $settings, $value ) {
		$data = json_decode( woodmart_decompress( $value ), true );

		if ( ! isset( $data['devices']['desktop'] ) ) {
			$data['devices']['desktop'] = $settings['default'];
		}

		$desktop = wp_parse_args(
			$data['devices']['desktop'],
			array(
				'horizontal' => '0',
				'vertical'   => '0',
				'blur'       => '9',
				'spread'     => '0',
				'color'      => 'rgba(0, 0, 0, .15)',
			)
		);

		ob_start();
		?>
		<div class="wd-box-shadow">
			<div class="wd-box-shadow-item">
				<label for="horizontal">
					<?php esc_html_e( 'Horizontal', 'woodmart' ); ?>
				</label>

				<div class="xts-input-append">
					<input name="horizontal" id="horizontal" type="number" class="wd-text-input" value="<?php echo esc_attr( $desktop['horizontal'] ); ?>" aria-label="<?php esc_attr_e( 'Horizontal', 'woodmart' ); ?>">

					<span class="add-on">px</span>
				</div>
			</div>

			<div class="wd-box-shadow-item">
				<label for="vertical">
					<?php esc_html_e( 'Vertical', 'woodmart' ); ?>
				</label>

				<div class="xts-input-append">
					<input name="vertical" id="vertical" type="number" class="wd-text-input" value="<?php echo esc_attr( $desktop['vertical'] ); ?>" aria-label="<?php esc_attr_e( 'Vertical', 'woodmart' ); ?>">

					<span class="add-on">px</span>
				</div>
			</div>

			<div class="wd-box-shadow-item">
				<label for="blur_radius">
					<?php esc_html_e( 'Blur radius', 'woodmart' ); ?>
				</label>

				<div class="xts-input-append">
					<input name="blur_radius" id="blur" type="number" class="wd-text-input" value="<?php echo esc_attr( $desktop['blur'] ); ?>" aria-label="<?php esc_attr_e( 'Blur radius', 'woodmart' ); ?>">

					<span class="add-on">px</span>
				</div>
			</div>

			<div class="wd-box-shadow-item">
				<label for="spread_radius">
					<?php esc_html_e( 'Spread radius', 'woodmart' ); ?>
				</label>

				<div class="xts-input-append">
					<input name="spread_radius" id="spread" type="number" class="wd-text-input" value="<?php echo esc_attr( $desktop['spread'] ); ?>" aria-label="<?php esc_attr_e( 'Spread radius', 'woodmart' ); ?>">

					<span class="add-on">px</span>
				</div>
			</div>

			<div class="wd-box-shadow-item wd-color">
				<label for="color">
					<?php esc_html_e( 'Color', 'woodmart' ); ?>
				</label>

				<input name="color" id="color" type="text" data-alpha-enabled="true" class="wd-color-input" value="<?php echo esc_attr( $desktop['color'] ); ?>">
			</div>

			<input type="hidden" class="wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>" data-settings="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>">
		</div>
		<?php

		return ob_get_clean();
	}
}
