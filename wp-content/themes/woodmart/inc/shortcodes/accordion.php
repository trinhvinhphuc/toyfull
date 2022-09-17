<?php
/***
 * Accordion shortcodes file.
 *
 * @package Shortcode.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_accordion' ) ) {
	/***
	 * Render accordion shortcode.
	 *
	 * @param array  $args Shortcode attributes.
	 * @param string $content Inner shortcode.
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_accordion( $args, $content ) {
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $args );

		$args = shortcode_atts(
			array(
				/**
				 * General Settings.
				 */
				'woodmart_css_id'           => '',
				'css'                       => '',
				'style'                     => 'default',
				'state'                     => 'first',
				'box_shadow'                => '',

				/**
				 * Title Settings.
				 */
				'title_font_family'         => 'primary',
				'title_font_size'           => 's',
				'title_font_weight'         => 600,
				'title_text_alignment'      => 'left',
				'title_text_color_scheme'   => 'inherit',

				/**
				 * Content Settings.
				 */
				'content_font_family'       => '',
				'content_font_size'         => '',
				'content_font_weight'       => '',
				'content_text_color_scheme' => 'inherit',
				'content'                   => '',
				'html_block_id'             => '',

				/**
				 * Icon Settings.
				 */
				'opener_alignment'          => 'left',
				'opener_style'              => 'arrow',
			),
			$args
		);

		$id = 'wd-' . $args['woodmart_css_id'];

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $args['css'] );
		}

		$wrapper_classes .= ' wd-style-' . $args['style'];

		$title_classes  = ' font-' . $args['title_font_family'];
		$title_classes .= ' wd-fontsize-' . $args['title_font_size'];
		$title_classes .= ' text-' . $args['title_text_alignment'];
		$title_classes .= ' wd-opener-pos-' . $args['opener_alignment'];

		if ( 'inherit' !== $args['title_text_color_scheme'] && 'custom' !== $args['title_text_color_scheme'] ) {
			$title_classes .= ' color-scheme-' . $args['title_text_color_scheme'];
		}

		$opener_classes = ' wd-opener-style-' . $args['opener_style'];

		if ( ! empty( $args['title_font_weight'] ) ) {
			$title_classes .= ' wd-font-weight-' . $args['title_font_weight'];
		}

		$content_classes = '';

		if ( ! empty( $args['content_font_family'] ) ) {
			$content_classes = ' font-' . $args['content_font_family'];
		}

		if ( 'inherit' !== $args['content_text_color_scheme'] && 'custom' !== $args['content_text_color_scheme'] ) {
			$content_classes .= ' color-scheme-' . $args['content_text_color_scheme'];
		}

		if ( ! empty( $args['content_font_size'] ) ) {
			$content_classes .= ' wd-fontsize-' . $args['content_font_size'];
		}

		if ( ! empty( $args['content_font_weight'] ) ) {
			$content_classes .= ' wd-font-weight-' . $args['content_font_weight'];
		}

		$content_data = explode( '[/woodmart_accordion_item]', $content );

		ob_start();

		woodmart_enqueue_js_script( 'accordion-element' );
		woodmart_enqueue_inline_style( 'accordion' );

		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="wd-accordion wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>" data-state="<?php echo esc_attr( $args['state'] ); ?>">
			<?php foreach ( $content_data as $index => $data ) : ?>
				<?php if ( empty( $data ) ) : ?>
					<?php continue; ?>
				<?php endif; // phpcs:ignore ?>

				<?php
				$shortcode         = $data . '[/woodmart_accordion_item]';
				$shortcode_data    = woodmart_get_accordion_data( $shortcode );
				$shortcode_data[0] = shortcode_atts(
					array(
						/**
						 * Title.
						 */
						'title'            => '',

						/**
						 * Content.
						 */
						'content_type'     => 'text',
						'content'          => '',
						'html_block_id'    => '',

						/***
						 * Tab Icon.
						 */
						'icon_libraries'   => 'fontawesome',
						'icon_position'    => 'top',
						'image'            => '',
						'image_size'       => '30x30',

						/***
						 * Icon libraries.
						 */
						'icon_fontawesome' => '',
						'icon_openiconic'  => '',
						'icon_typicons'    => '',
						'icon_entypo'      => '',
						'icon_linecons'    => '',
						'icon_monosocial'  => '',
						'icon_material'    => '',
					),
					$shortcode_data[0]
				);

				$content_type = $shortcode_data[0]['content_type'];

				$loop_title_classes_wrapper   = '';
				$loop_content_classes_wrapper = '';

				if ( 0 === $index && 'first' === $args['state'] ) {
					$loop_title_classes_wrapper   .= ' wd-active';
					$loop_content_classes_wrapper .= ' wd-active';
				}

				$loop_title_classes_wrapper   .= $title_classes;
				$loop_content_classes_wrapper .= $content_classes;

				$icon_library = '';

				if ( ! empty( $shortcode_data[0]['icon_libraries'] ) ) {
					$icon_library = $shortcode_data[0][ 'icon_' . $shortcode_data[0]['icon_libraries'] ];
					vc_icon_element_fonts_enqueue( $shortcode_data[0]['icon_libraries'] );
				}

				$icon_output = '';

				if ( ! empty( $shortcode_data[0]['image'] ) ) {
					$icon_output = woodmart_display_icon( $shortcode_data[0]['image'], $shortcode_data[0]['image_size'], 128 ); // phpcs:ignore

					if ( woodmart_is_svg( wp_get_attachment_image_src( $shortcode_data[0]['image'] )[0] ) ) {
						$icon_output = woodmart_get_svg_html( $shortcode_data[0]['image'], $shortcode_data[0]['image_size'] );
					}
				} elseif ( ! empty( $icon_library ) ) {
					$icon_output = '<div class="img-wrapper"><i class="' . esc_attr( $icon_library ) . '"></i></div>';
				}
				?>

				<div class="wd-accordion-item">
					<div class="wd-accordion-title<?php echo esc_attr( $loop_title_classes_wrapper ); ?>" data-accordion-index="<?php echo esc_attr( $index ); ?>">
						<div class="wd-accordion-title-text">
							<?php if ( ! empty( $icon_output ) ) : ?>
								<?php echo $icon_output; // phpcs:ignore ?>
							<?php endif; ?>
							<span>
								<?php echo esc_html( $shortcode_data[0]['title'] ); ?>
							</span>
						</div>
						<span class="wd-accordion-opener<?php echo esc_attr( $opener_classes ); ?>"></span>
					</div>

					<div class="wd-accordion-content reset-last-child<?php echo esc_attr( $loop_content_classes_wrapper ); ?>" data-accordion-index="<?php echo esc_attr( $index ); ?>">
						<?php if ( 'html_block' === $content_type ) : ?>
							<?php echo woodmart_get_html_block( $shortcode_data[0]['html_block_id'] ); // phpcs:ignore ?>
						<?php elseif ( 'text' === $content_type ) : ?>
							<?php echo wpb_js_remove_wpautop( $data, true ); // phpcs:ignore ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_shortcode_accordion_item' ) ) {
	/**
	 * Render accordion item shortcode.
	 *
	 * @param array  $args Shortcode arguments.
	 * @param string $content Inner shortcode.
	 * @return false|string
	 */
	function woodmart_shortcode_accordion_item( $args, $content ) {
		ob_start();

		echo do_shortcode( $content );

		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_get_accordion_data' ) ) {
	/**
	 * This function get accordion shortcodes ( string $content ), and return accordion data list ( array ).
	 *
	 * @param string $content accordion Shortcodes.
	 * @return array accordion titles list.
	 */
	function woodmart_get_accordion_data( $content ) {
		preg_match_all( '/woodmart_accordion([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );

		$items = isset( $matches[0] ) ? $matches[0] : array();
		$out   = array();

		foreach ( $items as $item ) {
			$out[] = shortcode_parse_atts( $item[0] );
		}

		return $out;
	}
}
