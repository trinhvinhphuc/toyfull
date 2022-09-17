<?php
/***
 * Tabs & tab shortcodes file.
 *
 * @package Shortcode.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_tabs' ) ) {
	/***
	 * Render tabs shortcode.
	 *
	 * @param array  $attr Shortcode attributes.
	 * @param string $content Inner shortcode.
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_tabs( $attr, $content ) {
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $attr );

		$attr = shortcode_atts(
			array(
				'woodmart_css_id'           => '',
				'css'                       => '',
				'tabs_style'                => 'default',

				/**
				 * Tabs Titles.
				 */
				'icon_position'             => 'left',
				'tabs_title_font_family'    => 'primary',
				'tabs_title_font_size'      => 's',
				'tabs_title_font_weight'    => 600,
				'tabs_title_color_scheme'   => 'inherit',
				'tabs_title_alignment'      => 'center',

				/**
				 * Content Settings.
				 */
				'content_font_family'       => '',
				'content_font_size'         => '',
				'content_font_weight'       => '',
				'content_text_color_scheme' => 'inherit',

			),
			$attr
		);

		woodmart_enqueue_js_script( 'tabs-element' );

		$title_id = 'wd-' . $attr['woodmart_css_id'];

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $attr['css'] );
		}

		$nav_tabs_wrapper_classes = ' text-' . $attr['tabs_title_alignment'];

		if ( 'inherit' !== $attr['tabs_title_color_scheme'] && 'custom' !== $attr['tabs_title_color_scheme'] ) {
			$nav_tabs_wrapper_classes .= ' color-scheme-' . $attr['tabs_title_color_scheme'];
		}

		$nav_tabs_classes  = ' wd-icon-pos-' . $attr['icon_position'];
		$nav_tabs_classes .= ' wd-style-' . $attr['tabs_style'];
		$nav_tabs_classes .= ' font-' . $attr['tabs_title_font_family'];
		$nav_tabs_classes .= ' wd-fontsize-' . $attr['tabs_title_font_size'];
		$nav_tabs_classes .= $attr['tabs_title_font_weight'] ? ' wd-font-weight-' . $attr['tabs_title_font_weight'] : '';

		$tabs_data = woodmart_get_tabs_title_from_shortcode( $content );

		$content_classes = '';

		if ( ! empty( $attr['content_font_family'] ) ) {
			$content_classes = ' font-' . $attr['content_font_family'];
		}

		if ( ! empty( $attr['content_font_size'] ) ) {
			$content_classes .= ' wd-fontsize-' . $attr['content_font_size'];
		}

		if ( ! empty( $attr['content_font_weight'] ) ) {
			$content_classes .= ' wd-font-weight-' . $attr['content_font_weight'];
		}

		if ( 'inherit' !== $attr['content_text_color_scheme'] && 'custom' !== $attr['content_text_color_scheme'] ) {
			$content_classes .= ' color-scheme-' . $attr['content_text_color_scheme'];
		}

		ob_start();

		woodmart_enqueue_inline_style( 'tabs' );
		?>

		<div id="<?php echo esc_attr( $title_id ); ?>" class="wd-tabs wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-nav-wrapper wd-nav-tabs-wrapper<?php echo esc_attr( $nav_tabs_wrapper_classes ); ?>">
				<ul class="wd-nav wd-nav-tabs<?php echo esc_attr( $nav_tabs_classes ); ?>">
					<?php foreach ( $tabs_data as $data ) : ?>
						<?php
						$data = shortcode_atts(
							array(
								/**
								 * Tab Title.
								 */
								'title'               => '',

								/**
								 * Content.
								 */
								'content_type'        => '',
								'content'             => '',
								'html_block_id'       => '',

								/***
								 * Tab Icon.
								 */
								'tabs_icon_libraries' => 'fontawesome',
								'icon_position'       => 'top',
								'tabs_image'          => '',
								'tabs_image_size'     => '30x30',

								/***
								 * Icon libraries.
								 */
								'icon_fontawesome'    => '',
								'icon_openiconic'     => '',
								'icon_typicons'       => '',
								'icon_entypo'         => '',
								'icon_linecons'       => '',
								'icon_monosocial'     => '',
								'icon_material'       => '',
							),
							$data
						);

						$tabs_icon_library = '';

						if ( ! empty( $data['tabs_icon_libraries'] ) ) {
							$tabs_icon_library = $data[ 'icon_' . $data['tabs_icon_libraries'] ];
							vc_icon_element_fonts_enqueue( $data['tabs_icon_libraries'] );
						}

						$icon_output = '';

						if ( ! empty( $data['tabs_image'] ) ) {
							$icon_output = woodmart_display_icon( $data['tabs_image'], $data['tabs_image_size'], 128 ); // phpcs:ignore

							if ( woodmart_is_svg( wp_get_attachment_image_src( $data['tabs_image'] )[0] ) ) {
								$icon_output = '<div class="img-wrapper">' . woodmart_get_svg_html( $data['tabs_image'], $data['tabs_image_size'] ) . '</div>';
							}
						} elseif ( ! empty( $tabs_icon_library ) ) {
							$icon_output = '<div class="img-wrapper"><i class="' . esc_attr( $tabs_icon_library ) . '"></i></div>';
						}
						?>

						<li>
							<a href="#" class="wd-nav-link">
								<?php if ( ! empty( $icon_output ) ) : ?>
									<?php echo $icon_output; // phpcs:ignore ?>
								<?php endif; ?>
								<span class="nav-link-text wd-tabs-title">
									<?php echo esc_html( $data['title'] ); ?>
								</span>
							</a>
						</li>

					<?php endforeach; ?>

				</ul>
			</div>

			<div class="wd-tab-content-wrapper<?php echo esc_attr( $content_classes ); ?>">
				<?php echo do_shortcode( $content ); ?>
			</div>
		</div>

		<?php
		return apply_filters( 'vc_shortcode_output', ob_get_clean(), new WD_WPBakeryShortCodeFix(), $attr, 'woodmart_tabs' );
	}
}

if ( ! function_exists( 'woodmart_shortcode_tab' ) ) {
	/**
	 * Render tab shortcode.
	 *
	 * @param array  $attr Shortcode attributes.
	 * @param string $content Inner shortcode.
	 * @return false|string
	 */
	function woodmart_shortcode_tab( $attr, $content ) {
		$content_type = isset( $attr['content_type'] ) ? 'html_block' : 'text';
		ob_start();
		?>

		<div class="wd-tab-content">
			<?php if ( 'html_block' === $content_type ) : ?>
				<?php echo woodmart_get_html_block( $attr['html_block_id'] ); // phpcs:ignore ?>
			<?php elseif ( 'text' === $content_type ) : ?>
				<?php echo do_shortcode( $content ); ?>
			<?php endif; ?>
		</div>

		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_get_tabs_title_from_shortcode' ) ) {
	/**
	 * This function get tabs shortcodes ( string $content ), and return tabs data list ( array ).
	 *
	 * @param string $content Tabs Shortcodes.
	 * @return array Tabs titles list.
	 */
	function woodmart_get_tabs_title_from_shortcode( $content ) {
		preg_match_all( '/woodmart_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );

		$tabs = isset( $matches[1] ) ? $matches[1] : array();
		$out  = array();

		foreach ( $tabs as $tab ) {
			$out[] = shortcode_parse_atts( $tab[0] );
		}

		return $out;
	}
}
