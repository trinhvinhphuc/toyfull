<?php
/***
 * Off canvas button shortcodes file.
 *
 * @package Shortcode.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_off_canvas_btn' ) ) {
	/***
	 * Render off canvas button shortcode.
	 *
	 * @param array  $attr Shortcode attributes.
	 * @param string $content Inner shortcode.
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_off_canvas_btn( $attr, $content ) {
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', 'woodmart_off_canvas_btn', $attr );

		$settings = shortcode_atts(
			array(
				'woodmart_css_id' => '',
				'css'             => '',
				'button_text'     => 'Show column',
				'icon_type'       => 'default',
				'img_id'          => '',
				'img_size'        => '20x20',
				'sticky'          => '',
			),
			$attr
		);

		$off_canvas_classes        = '';
		$sticky_off_canvas_classes = '';

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		woodmart_enqueue_js_script( 'off-canvas-colum-btn' );
		woodmart_enqueue_inline_style( 'el-off-canvas-column-btn' );

		// Icon settings.

		if ( 'default' === $settings['icon_type'] ) {
			$off_canvas_classes        .= ' wd-burger-icon';
			$sticky_off_canvas_classes .= ' wd-burger-icon';
		} elseif ( 'custom' === $settings['icon_type'] ) {
			$off_canvas_classes        .= ' wd-action-custom-icon';
			$sticky_off_canvas_classes .= ' wd-action-custom-icon';
		}

		$image_data = wpb_getImageBySize(
			array(
				'attach_id'  => $settings['img_id'],
				'thumb_size' => $settings['img_size'],
			)
		);

		$icon_output = isset( $image_data['thumbnail'] ) ? $image_data['thumbnail'] : '';

		if ( isset( $image_data['p_img_large'] ) && woodmart_is_svg( $image_data['p_img_large'][0] ) ) {
			$icon_output = woodmart_get_svg_html(
				$settings['img_id'],
				$settings['img_size']
			);
		}

		ob_start();
		?>

		<div class="wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-off-canvas-btn wd-action-btn wd-style-text<?php echo esc_html( $off_canvas_classes ); ?>">
				<a href="#" rel="nofollow">
					<?php if ( ! empty( $icon_output ) ) : ?>
						<span class="wd-action-icon">
							<?php echo $icon_output; //phpcs:ignore; ?>
						</span>
					<?php endif; ?>
					<?php echo esc_html( $settings['button_text'] ); ?>
				</a>
			</div>
			<?php if ( 'yes' === $settings['sticky'] ) : ?>
				<?php woodmart_enqueue_inline_style( 'mod-sticky-sidebar-opener' ); ?>
				<div class="wd-sidebar-opener wd-action-btn wd-style-icon<?php echo esc_html( $sticky_off_canvas_classes ); ?>">
					<a href="#" rel="nofollow">
						<?php if ( ! empty( $icon_output ) ) : ?>
							<span class="wd-action-icon">
								<?php echo $icon_output; //phpcs:ignore; ?>
							</span>
						<?php endif; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<?php
		return apply_filters( 'vc_shortcode_output', ob_get_clean(), new WD_WPBakeryShortCodeFix(), $attr, 'woodmart_shortcode_off_canvas_btn' );
	}
}
