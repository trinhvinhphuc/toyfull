<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_responsive_spacing_param' ) ) {
	function woodmart_get_responsive_spacing_param( $settings, $value ) {
		ob_start();
		?>
		<div class="vc_css-editor vc_row vc_ui-flex-row wd-responsive-spacing-wrapper">
			<div class="wd-spacing-devices">
				<span class="wd-desktop xts-active" data-value="desktop">
					<span>Desktop</span>
				</span>
				<span class="wd-tablet" data-value="tablet">
					<span>Tablet</span>
				</span>
				<span class="wd-mobile" data-value="mobile">
					<span>Mobile</span>
				</span>
			</div>
			<?php echo woodmart_get_responsive_spacing_template( 'tablet' ); ?>
			<?php echo woodmart_get_responsive_spacing_template( 'mobile' ); ?>

			<input type="hidden" name="<?php echo esc_attr( $settings['param_name'] ); ?>" class="wpb_vc_param_value wd-responsive-spacing-value" value="<?php echo esc_attr( $value ); ?>">
		</div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_get_responsive_spacing_template' ) ) {
	function woodmart_get_responsive_spacing_template( $device ) {
		ob_start();
		?>
		<div class="vc_layout-onion vc_col-xs-7 wd-responsive-spacing" data-device="<?php echo esc_attr( $device ); ?>">
			<div class="vc_margin">
				<label>margin</label>
				<input type="text" name="margin_top" data-name="margin-top" class="vc_top" placeholder="-" data-attribute="margin" value="" aria-label="margin">
				<input type="text" name="margin_right" data-name="margin-right" class="vc_right" placeholder="-" data-attribute="margin" value="" aria-label="margin">
				<input type="text" name="margin_bottom" data-name="margin-bottom" class="vc_bottom" placeholder="-" data-attribute="margin" value="" aria-label="margin">
				<input type="text" name="margin_left" data-name="margin-left" class="vc_left" placeholder="-" data-attribute="margin" value="" aria-label="margin">

				<div class="vc_border">
					<label>border</label>
					<input type="text" name="border_top_width" data-name="border-top-width" class="vc_top" placeholder="-" data-attribute="border" value="" aria-label="border">
					<input type="text" name="border_right_width" data-name="border-right-width" class="vc_right" placeholder="-" data-attribute="border" value="" aria-label="border">
					<input type="text" name="border_bottom_width" data-name="border-bottom-width" class="vc_bottom" placeholder="-" data-attribute="border" value="" aria-label="border">
					<input type="text" name="border_left_width" data-name="border-left-width" class="vc_left" placeholder="-" data-attribute="border" value="" aria-label="border">

					<div class="vc_padding">
						<label>padding</label>
						<input type="text" name="padding_top" data-name="padding-top" class="vc_top" placeholder="-" data-attribute="padding" value="" aria-label="padding">
						<input type="text" name="padding_right" data-name="padding-right" class="vc_right" placeholder="-" data-attribute="padding" value="" aria-label="padding">
						<input type="text" name="padding_bottom" data-name="padding-bottom" class="vc_bottom" placeholder="-" data-attribute="padding" value="" aria-label="padding">
						<input type="text" name="padding_left" data-name="padding-left" class="vc_left" placeholder="-" data-attribute="padding" value="" aria-label="padding">
						<div class="vc_content"><i></i></div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}