<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Mega Menu widget
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_shortcode_mega_menu' ) ) {
	function woodmart_shortcode_mega_menu( $atts, $content ) {
		$output = $title_html = '';
		$class  = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$atts = shortcode_atts(
			array(
				'title'                 => '',
				'nav_menu'              => '',
				'style'                 => 'default',
				'design'                => 'vertical',
				'items_gap'             => 's',
				'alignment'             => 'left',
				'color'                 => '',
				'woodmart_color_scheme' => 'light',
				'el_class'              => '',
				'woodmart_css_id'       => '',
				'css'                   => '',
			),
			$atts
		);

		$title_classes = ' color-scheme-' . esc_attr( $atts['woodmart_color_scheme'] );

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}
		if ( ! empty( $atts['el_class'] ) ) {
			$class .= ' ' . $atts['el_class'];
		}

		$widget_id = 'wd-' . $atts['woodmart_css_id'];

		$menu_classes  = ' wd-nav-' . $atts['design'];
		$menu_classes .= ' wd-style-' . $atts['style'];
		$menu_classes .= woodmart_get_old_classes( ' ' . $atts['design'] . '-navigation' );
		$menu_classes .= woodmart_get_old_classes( ' navigation-style-' . $atts['style'] );

		if ( 'horizontal' === $atts['design'] ) {
			$class        .= ' text-' . $atts['alignment'];
			$menu_classes .= ' wd-gap-' . $atts['items_gap'];
		}

		ob_start();

		woodmart_enqueue_inline_style( 'widget-nav-mega-menu' );

		if ( 'vertical' === $atts['design'] ) {
			woodmart_enqueue_inline_style( 'mod-nav-vertical' );
		}
		?>

			<div id="<?php echo esc_attr( $widget_id ); ?>" class="widget_nav_mega_menu <?php echo esc_attr( $class ); ?>">

				<?php if ( $atts['title'] ) : ?>
					<h5 class="widget-title<?php echo esc_attr( $title_classes ); ?>">
						<?php echo wp_kses( $atts['title'], woodmart_get_allowed_html() ); ?>
					</h5>
				<?php endif; ?>

				<?php
					wp_nav_menu(
						array(
							'fallback_cb' => '',
							'container'   => '',
							'menu'        => $atts['nav_menu'],
							'menu_class'  => 'menu wd-nav' . $menu_classes,
							'walker'      => new WOODMART_Mega_Menu_Walker(),
						)
					);
				?>

				<?php
				if ( $atts['color'] && ! woodmart_is_css_encode( $atts['color'] ) ) {
					$atts['css']  = '#' . esc_attr( $widget_id ) . ' .widget-title {';
					$atts['css'] .= 'background-color: ' . esc_attr( $atts['color'] ) . ';';
					$atts['css'] .= '}';

					wp_add_inline_style( 'woodmart-inline-css', $atts['css'] );
				}
				?>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
