<?php
/**
 * Gutenberg.
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_gutenberg_disable_svg' ) ) {
	/**
	 * Gutenberg disable svg.
	 */
	function woodmart_gutenberg_disable_svg() {
		if ( woodmart_get_opt( 'disable_gutenberg_css' ) ) {
			remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
			remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		}
	}

	add_action( 'init', 'woodmart_gutenberg_disable_svg' );
}

if ( ! function_exists( 'woodmart_gutenberg_show_widgets' ) ) {
	/**
	 * Gutenberg show widgets.
	 *
	 * @return array
	 */
	function woodmart_gutenberg_show_widgets() {
		return array();
	}

	add_action( 'widget_types_to_hide_from_legacy_widget_block', 'woodmart_gutenberg_show_widgets', 100 );
}

if ( ! function_exists( 'woodmart_gutenberg_enqueue_editor_styles' ) ) {
	/**
	 * Gutenberg styles.
	 *
	 * @since 1.0.0
	 */
	function woodmart_gutenberg_enqueue_editor_styles() {
		if ( woodmart_get_opt( 'disable_gutenberg_backend_css' ) ) {
			return;
		}

		$rtl = is_rtl() ? '-rtl' : '';
		wp_enqueue_style( 'wd-gutenberg-editor-style', WOODMART_THEME_DIR . '/css/parts/wp-gutenberg-editor' . $rtl . '.min.css', array(), woodmart_get_theme_info( 'Version' ) );
	}

	add_action( 'admin_print_styles-post.php', 'woodmart_gutenberg_enqueue_editor_styles', 10 );
	add_action( 'admin_print_styles-post-new.php', 'woodmart_gutenberg_enqueue_editor_styles', 10 );
	add_action( 'admin_print_styles-widgets.php', 'woodmart_gutenberg_enqueue_editor_styles', 10 );
}

if ( ! function_exists( 'woodmart_gutenberg_editor_styles' ) ) {
	/**
	 * Gutenberg styles.
	 *
	 * @since 1.0.0
	 */
	function woodmart_gutenberg_editor_styles() {
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style-editor.css' );
		add_theme_support( 'align-wide' );
	}

	add_action( 'after_setup_theme', 'woodmart_gutenberg_editor_styles', 10 );
}

if ( ! function_exists( 'woodmart_gutenberg_editor_custom_styles' ) ) {
	/**
	 * Gutenberg styles.
	 *
	 * @since 1.0.0
	 */
	function woodmart_gutenberg_editor_custom_styles() {
		if ( woodmart_get_opt( 'disable_gutenberg_backend_css' ) ) {
			return;
		}

		$all_pages_bg          = woodmart_get_opt( 'pages-background' );
		$site_custom_width     = woodmart_get_opt( 'site_custom_width' );
		$predefined_site_width = woodmart_get_opt( 'site_width' );

		$site_width = '';

		if ( 'full-width' === $predefined_site_width ) {
			$site_width = 1222;
		} elseif ( 'boxed' === $predefined_site_width ) {
			$site_width = 1160;
		} elseif ( 'boxed-2' === $predefined_site_width ) {
			$site_width = 1160;
		} elseif ( 'wide' === $predefined_site_width ) {
			$site_width = 1600;
		} elseif ( 'custom' === $predefined_site_width ) {
			$site_width = $site_custom_width;
		}

		// Forms.
		$form_style = woodmart_get_opt( 'form_fields_style' );
		$form_width = woodmart_get_opt( 'form_border_width' );

		// Default button.
		$default_btn_style          = woodmart_get_opt( 'btns_default_style' );
		$default_btn_color          = 'light' === woodmart_get_opt( 'btns_default_color_scheme' ) ? '#fff' :
			'#333';
		$default_btn_color_hover    = 'light' === woodmart_get_opt( 'btns_default_color_scheme_hover' ) ? '#fff' : '#333';
		$default_btn_bg_color       = woodmart_get_opt( 'btns_default_bg' );
		$default_btn_bg_color_hover = woodmart_get_opt( 'btns_default_bg_hover' );

		// Shop button.
		$shop_btn_style           = woodmart_get_opt( 'btns_shop_style' );
		$shop_btn_color           = 'light' === woodmart_get_opt( 'btns_shop_color_scheme' ) ? '#fff' : '#333';
		$shop_btn_color_hover     = 'light' === woodmart_get_opt( 'btns_shop_color_scheme_hover' ) ? '#fff' :
			'#333';
		$shop_btn_bg_color       = woodmart_get_opt( 'btns_shop_bg' );
		$shop_btn_bg_color_hover = woodmart_get_opt( 'btns_shop_bg_hover' );

		// Accent button.
		$accent_btn_style       = woodmart_get_opt( 'btns_accent_style' );
		$accent_btn_color       = 'light' === woodmart_get_opt( 'btns_accent_color_scheme' ) ? '#fff' : '#333';
		$accent_btn_color_hover = 'light' === woodmart_get_opt( 'btns_accent_color_scheme_hover' ) ? '#fff' : '#333';
		$accent_btn_bg_color       = woodmart_get_opt( 'btns_accent_bg' );
		$accent_btn_bg_color_hover = woodmart_get_opt( 'btns_accent_bg_hover' );

		// Link.
		$link_color = woodmart_get_opt( 'link-color' );
		$primary_color = woodmart_get_opt( 'primary-color' );
		$alternative_color = woodmart_get_opt( 'secondary-color' );

		// Typography;
		$text_font = woodmart_get_opt( 'text-font' );
		$title_font = woodmart_get_opt( 'primary-font' );
		$entities_font = woodmart_get_opt( 'post-titles-font' );
		$alternative_font = woodmart_get_opt( 'secondary-font' );
		$widget_title_font = woodmart_get_opt( 'widget-titles-font' );
		$header_el_font = woodmart_get_opt( 'navigation-font' );

		?>
		<style>
			:root {
			/* FORMS */

			<?php if ( 'rounded' === $form_style ) : ?>
			--wd-form-brd-radius: 35px;
			<?php endif; ?>

			<?php if ( 'semi-rounded' === $form_style ) : ?>
			--wd-form-brd-radius: 5px;
			<?php endif; ?>

			<?php if ( 'square' === $form_style || 'underlined' === $form_style ) : ?>
			--wd-form-brd-radius: 0px;
			<?php endif; ?>

			--wd-form-brd-width: <?php echo esc_attr( $form_width ); ?>px;

			/* BUTTONS */
			--btn-default-color: <?php echo esc_attr( $default_btn_color ) ?>;
			--btn-default-color-hover: <?php echo esc_attr( $default_btn_color_hover ) ?>;
			<?php if ( ! empty( $default_btn_bg_color['idle'] ) ) : ?>
			--btn-default-bgcolor: <?php echo esc_attr( $default_btn_bg_color['idle'] ) ?>;
			<?php endif; ?>
			<?php if ( ! empty( $default_btn_bg_color_hover['idle'] ) ) : ?>
			--btn-default-bgcolor-hover: <?php echo esc_attr( $default_btn_bg_color_hover['idle'] ) ?>;
			<?php endif; ?>

			--btn-shop-color: <?php echo esc_attr( $shop_btn_color ) ?>;
			--btn-shop-color-hover: <?php echo esc_attr( $shop_btn_color_hover ) ?>;
			<?php if ( ! empty( $accent_btn_bg_color['idle'] ) ) : ?>
			--btn-accent-bgcolor: <?php echo esc_attr( $accent_btn_bg_color['idle'] ) ?>;
			<?php endif; ?>
			<?php if ( ! empty( $accent_btn_bg_color_hover['idle'] ) ) : ?>
			--btn-accent-bgcolor-hover: <?php echo esc_attr( $accent_btn_bg_color_hover['idle'] ) ?>;
			<?php endif; ?>

			--btn-accent-color: <?php echo esc_attr( $accent_btn_color ) ?>;
			--btn-accent-color-hover: <?php echo esc_attr( $accent_btn_color_hover ) ?>;
			<?php if ( ! empty( $shop_btn_bg_color['idle'] ) ) : ?>
			--btn-shop-bgcolor: <?php echo esc_attr( $shop_btn_bg_color['idle'] ) ?>;
			<?php endif; ?>
			<?php if ( ! empty( $shop_btn_bg_color_hover['idle'] ) ) : ?>
			--btn-shop-bgcolor-hover: <?php echo esc_attr( $shop_btn_bg_color_hover['idle'] ) ?>;
			<?php endif; ?>
			<?php if ( 'flat' === $default_btn_style ) : ?>
			--btn-default-brd-radius: 0px;
			--btn-default-box-shadow: none;
			--btn-default-box-shadow-hover: none;
			--btn-default-box-shadow-active: none;
            --btn-default-bottom: 0px;
			<?php endif; ?>

			<?php if ( 'flat' === $shop_btn_style ) : ?>
			--btn-shop-brd-radius: 0.001px;
			--btn-shop-box-shadow: none;
			--btn-shop-box-shadow-hover: none;
			--btn-shop-box-shadow-active: none;
			--btn-shop-bottom: 0px;
			<?php endif; ?>

			<?php if ( 'flat' === $accent_btn_style ) : ?>
			--btn-accent-brd-radius: 0px;
			--btn-accent-box-shadow: none;
			--btn-accent-box-shadow-hover: none;
			--btn-accent-box-shadow-active: none;
			--btn-accent-bottom: 0px;
			<?php endif; ?>

			<?php if ( '3d' === $default_btn_style ) : ?>
			--btn-default-bottom-active: -1px;
			--btn-default-brd-radius: 0px;
			--btn-default-box-shadow: inset 0 -2px 0 rgba(0, 0, 0, .15);
			--btn-default-box-shadow-hover: inset 0 -2px 0 rgba(0, 0, 0, .15);
			<?php endif; ?>

			<?php if ( '3d' === $shop_btn_style ) : ?>
			--btn-shop-bottom-active: -1px;
			--btn-shop-brd-radius: 0.001px;
			--btn-shop-box-shadow: inset 0 -2px 0 rgba(0, 0, 0, .15);
			--btn-shop-box-shadow-hover: inset 0 -2px 0 rgba(0, 0, 0, .15);
			<?php endif; ?>

			<?php if ( '3d' === $accent_btn_style ) : ?>
			--btn-accent-bottom-active: -1px;
			--btn-accent-brd-radius: 0px;
			--btn-accent-box-shadow: inset 0 -2px 0 rgba(0, 0, 0, .15);
			--btn-accent-box-shadow-hover: inset 0 -2px 0 rgba(0, 0, 0, .15);
			<?php endif; ?>

			<?php if ( 'rounded' === $default_btn_style ) : ?>
			--btn-default-brd-radius: 35px;
			--btn-default-box-shadow: none;
			--btn-default-box-shadow-hover: none;
			<?php endif; ?>

			<?php if ( 'rounded' === $shop_btn_style ) : ?>
			--btn-shop-brd-radius: 35px;
			--btn-shop-box-shadow: none;
			--btn-shop-box-shadow-hover: none;
			<?php endif; ?>

			<?php if ( 'rounded' === $accent_btn_style ) : ?>
			--btn-accent-brd-radius: 35px;
			--btn-accent-box-shadow: none;
			--btn-accent-box-shadow-hover: none;
			<?php endif; ?>

			<?php if ( 'semi-rounded' === $default_btn_style ) : ?>
			--btn-default-brd-radius: 5px;
			--btn-default-box-shadow: none;
			--btn-default-box-shadow-hover: none;
			<?php endif; ?>

			<?php if ( 'semi-rounded' === $shop_btn_style ) : ?>
			--btn-shop-brd-radius: 5px;
			--btn-shop-box-shadow: none;
			--btn-shop-box-shadow-hover: none;
			<?php endif; ?>

			<?php if ( 'semi-rounded' === $accent_btn_style ) : ?>
			--btn-accent-brd-radius: 5px;
			--btn-accent-box-shadow: none;
			--btn-accent-box-shadow-hover: none;
			<?php endif; ?>

			/* LINKS */
			<?php if ( ! empty( $link_color['idle'] ) ) : ?>
			--wd-link-color: <?php echo esc_attr( $link_color['idle'] ); ?>;
			--wd-link-color-hover: <?php echo esc_attr( $link_color['hover'] ); ?>;
			<?php endif; ?>

			/* COLORS */
			<?php if ( ! empty( $primary_color['idle'] ) ) : ?>
			--wd-primary-color: <?php echo esc_attr( $primary_color['idle'] ); ?>;
			<?php endif; ?>
			<?php if ( ! empty( $alternative_color['idle'] ) ) : ?>
			--wd-alternative-color: <?php echo esc_attr( $alternative_color['idle'] ); ?>;
			<?php endif; ?>

			/* TYPOGRAPHY */
			<?php if ( isset( $text_font[0] ) && ! empty( $text_font[0]['font-family'] ) ) : ?>
			--wd-text-font: "<?php echo esc_attr( $text_font[0]['font-family'] ); ?>", Arial, Helvetica,
			sans-serif;
			--wd-text-font-size: <?php echo esc_attr( $text_font[0]['font-size'] ); ?>px;
			--wd-text-font-style: <?php echo esc_attr( $text_font[0]['font-style'] ); ?>;
			--wd-text-font-weight: <?php echo esc_attr( $text_font[0]['font-weight'] ); ?>;
			--wd-text-color: <?php echo esc_attr( $text_font[0]['color'] ); ?>;
			<?php endif; ?>
			<?php if ( isset( $title_font[0] ) && ! empty( $title_font[0]['font-family'] ) ) : ?>
			--wd-title-font:"<?php echo esc_attr( $title_font[0]['font-family'] ); ?>", Arial, Helvetica,
			sans-serif;
			--wd-title-font-style: <?php echo esc_attr( $title_font[0]['font-style'] ); ?>;
			--wd-title-font-weight: <?php echo esc_attr( $title_font[0]['font-weight'] ); ?>;
			--wd-title-transform: <?php echo esc_attr( $title_font[0]['text-transform'] ); ?>;
			--wd-title-color: <?php echo esc_attr( $title_font[0]['color'] ); ?>;
			<?php endif; ?>
			<?php if ( isset( $entities_font[0] ) && ! empty( $entities_font[0]['font-family'] ) ) : ?>
			--wd-entities-title-font:"<?php echo esc_attr( $entities_font[0]['font-family'] ); ?>", Arial, Helvetica, sans-serif;
			--wd-entities-title-font-style: <?php echo esc_attr( $entities_font[0]['font-style'] ); ?>;
			--wd-entities-title-font-weight: <?php echo esc_attr( $entities_font[0]['font-weight'] ); ?>;
			--wd-entities-title-color: <?php echo esc_attr( $entities_font[0]['color'] ); ?>;
			--wd-entities-title-color-hover: <?php echo esc_attr( $entities_font[0]['hover']['color'] ); ?>;
			--wd-entities-title-transform: <?php echo esc_attr( $entities_font[0]['text-transform'] ); ?>;
			<?php endif; ?>
			<?php if ( isset( $alternative_font[0] ) && ! empty( $alternative_font[0]['font-family'] ) ) : ?>
			--wd-alternative-font:"<?php echo esc_attr( $alternative_font[0]['font-family'] ); ?>", Arial, Helvetica, sans-serif;
			--wd-alternative-font-style: <?php echo esc_attr( $alternative_font[0]['font-style'] ); ?>;
			<?php endif; ?>
			<?php if ( isset( $widget_title_font[0] ) && ! empty( $widget_title_font[0]['font-family'] ) ) : ?>
			--wd-widget-title-font:"<?php echo esc_attr( $widget_title_font[0]['font-family'] ); ?>", Arial, Helvetica, sans-serif;
			--wd-widget-title-font-size: <?php echo esc_attr( $widget_title_font[0]['font-size'] ); ?>px;
			--wd-widget-title-font-style: <?php echo esc_attr( $widget_title_font[0]['font-style'] ); ?>;
			--wd-widget-title-font-weight: <?php echo esc_attr( $widget_title_font[0]['font-weight'] ); ?>;
			--wd-widget-title-transform: <?php echo esc_attr( $widget_title_font[0]['text-transform'] ); ?>;
			--wd-widget-title-color: <?php echo esc_attr( $widget_title_font[0]['color'] ); ?>;
			<?php endif; ?>
			<?php if ( isset( $header_el_font[0] ) && ! empty( $header_el_font[0]['font-family'] ) ) : ?>
			--wd-header-el-font:"<?php echo esc_attr( $header_el_font[0]['font-family'] ); ?>", Arial, Helvetica, sans-serif;
			--wd-header-el-font-size: <?php echo esc_attr( $header_el_font[0]['font-size'] ); ?>px;
			--wd-header-el-font-weight: <?php echo esc_attr( $header_el_font[0]['font-weight'] ); ?>;
			--wd-header-el-transform: <?php echo esc_attr( $header_el_font[0]['text-transform'] ); ?>;
			<?php endif; ?>
			}

			div.block-editor-writing-flow {
				<?php if ( ! empty( $all_pages_bg['color'] ) ) : ?>
					background-color: <?php echo esc_attr( $all_pages_bg['color'] ); ?>;
				<?php endif; ?>
			}

			<?php if ( 'full-width-content' === $predefined_site_width ) : ?>
				div.block-editor .editor-styles-wrapper .wp-block:not([data-align="full"]), div.block-editor .editor-styles-wrapper .wp-block[data-align="wide"] {
					 max-width: 100%;
				}
			<?php endif; ?>

			<?php if ( $site_width ) : ?>
				div.block-editor .editor-styles-wrapper .wp-block:not([data-align="full"]) {
					max-width: <?php echo esc_attr( $site_width ); ?>px;
				}

				div.block-editor .editor-styles-wrapper .wp-block[data-align="wide"] {
					max-width: <?php echo esc_attr( $site_width + 150 ); ?>px;
				}
			<?php endif; ?>
		</style>
		<?php
	}

	add_action( 'admin_print_styles-post.php', 'woodmart_gutenberg_editor_custom_styles', 10 );
	add_action( 'admin_print_styles-post-new.php', 'woodmart_gutenberg_editor_custom_styles', 10 );
	add_action( 'admin_print_styles-widgets.php', 'woodmart_gutenberg_editor_custom_styles', 10 );
}
