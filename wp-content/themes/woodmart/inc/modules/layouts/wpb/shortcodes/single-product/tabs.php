<?php
/**
 * Tabs shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_tabs' ) ) {
	/**
	 * Single product tabs shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_tabs( $settings ) {
		$default_settings = array(
			'layout'                            => 'tabs',
			'enable_additional_info'            => 'yes',
			'enable_reviews'                    => 'yes',
			'enable_description'                => 'yes',
			'additional_info_style'             => 'bordered',
			'additional_info_layout'            => 'list',
			'reviews_layout'                    => 'one-column',
			'css'                               => '',

			/**
			 * Tabs Settings.
			 */
			'tabs_style'                        => 'default',
			'tabs_title_text_color_scheme'      => 'inherit',
			'tabs_alignment'                    => 'center',
			'tabs_content_text_color_scheme'    => 'inherit',

			/**
			 * Accordion Settings.
			 */
			'accordion_state'                   => 'first',
			'accordion_style'                   => 'default',
			'accordion_title_text_color_scheme' => 'inherit',
			'accordion_alignment'               => 'left',

			/**
			 * Opener Settings.
			 */
			'accordion_opener_alignment'        => 'left',
			'accordion_opener_style'            => 'arrow',
			'all_open_style'                    => 'default',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		if ( 'all-open' === $settings['layout'] ) {
			$wrapper_classes .= ' tabs-layout-all-open';
			$wrapper_classes .= ' wd-title-style-' . $settings['all_open_style'];
		}

		$additional_info_classes  = ' wd-layout-' . $settings['additional_info_layout'];
		$additional_info_classes .= ' wd-style-' . $settings['additional_info_style'];
		$reviews_classes          = ' wd-layout-' . woodmart_vc_get_control_data( $settings['reviews_layout'], 'desktop' );
		$args                     = array();
		$title_content_classes    = '';

		if ( 'inherit' !== $settings['tabs_content_text_color_scheme'] ) {
			$title_content_classes .= ' color-scheme-' . $settings['tabs_content_text_color_scheme'];
		}

		$default_args = array(
			'builder_additional_info_classes' => $additional_info_classes,
			'builder_reviews_classes'         => $reviews_classes,
			'builder_content_classes'         => $title_content_classes,
		);

		if ( 'tabs' === $settings['layout'] ) {
			$title_wrapper_classes = ' text-' . woodmart_vc_get_control_data( $settings['tabs_alignment'], 'desktop' );
			$title_classes         = ' wd-style-' . $settings['tabs_style'];

			if ( 'inherit' !== $settings['tabs_title_text_color_scheme'] && 'custom' !== $settings['tabs_title_text_color_scheme'] ) {
				$title_wrapper_classes .= ' color-scheme-' . $settings['tabs_title_text_color_scheme'];
			}

			$args = array(
				'builder_tabs_classes'             => $title_classes,
				'builder_nav_tabs_wrapper_classes' => $title_wrapper_classes,
			);
		} elseif ( 'accordion' === $settings['layout'] ) {
			$accordion_classes = ' wd-style-' . $settings['accordion_style'];
			$accordion_state   = $settings['accordion_state'];
			$opener_classes    = ' wd-opener-style-' . $settings['accordion_opener_style'];
			$title_classes     = ' text-' . woodmart_vc_get_control_data( $settings['accordion_alignment'], 'desktop' );
			$title_classes    .= ' wd-opener-pos-' . woodmart_vc_get_control_data( $settings['accordion_opener_alignment'], 'desktop' );

			if ( 'inherit' !== $settings['accordion_title_text_color_scheme'] && 'custom' !== $settings['accordion_title_text_color_scheme'] ) {
				$title_classes .= ' color-scheme-' . $settings['accordion_title_text_color_scheme'];
			}

			$args = array(
				'builder_accordion_classes' => $accordion_classes,
				'builder_state'             => $accordion_state,
				'builder_opener_classes'    => $opener_classes,
				'builder_title_classes'     => $title_classes,
			);
		}

		$args = array_merge( $default_args, $args );

		if ( 'yes' !== $settings['enable_additional_info'] ) {
			add_filter( 'woocommerce_product_tabs', 'woodmart_single_product_remove_additional_information_tab', 98 );
		}

		if ( 'yes' !== $settings['enable_reviews'] ) {
			add_filter( 'woocommerce_product_tabs', 'woodmart_single_product_remove_reviews_tab', 98 );
		}

		if ( 'yes' !== $settings['enable_description'] ) {
			add_filter( 'woocommerce_product_tabs', 'woodmart_single_product_remove_description_tab', 98 );
		}

		ob_start();

		wp_enqueue_script( 'wc-single-product' );

		Main::setup_preview();

		if ( 'yes' === $settings['enable_reviews'] ) {
			woodmart_enqueue_inline_style( 'mod-comments' );
		}

		if ( comments_open() ) {
			woodmart_enqueue_inline_style( 'woo-single-prod-el-reviews' );
			woodmart_enqueue_js_script( 'single-product-tabs-comments-fix' );
			woodmart_enqueue_js_script( 'woocommerce-comments' );
		}

		?>
		<div class="wd-single-tabs wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php
			wc_get_template(
				'single-product/tabs/tabs-' . $settings['layout'] . '.php',
				$args
			);
			?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
