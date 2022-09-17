<?php

/**
 * ------------------------------------------------------------------------------------------------
 * Returns the current header instance (on frontend)
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'whb_get_header' ) ) {
	function whb_get_header() {
		return WOODMART_HB_Frontend::get_instance()->header;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Generate current header HTML structure
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'whb_generate_header' ) ) {
	function whb_generate_header() {
		woodmart_enqueue_inline_style( 'header-base' );
		WOODMART_HB_Frontend::get_instance()->generate_header();
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get main builder class instance
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'whb_get_builder' ) ) {
	function whb_get_builder() {
		return WOODMART_HB_Frontend::get_instance()->builder;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Is full screen search enabled
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'whb_is_full_screen_search' ) ) {
	function whb_is_full_screen_search() {
		$settings = whb_get_settings();
		$desktop  = isset( $settings['search'] ) && 'full-screen' === $settings['search']['display'];
		$mobile   = isset( $settings['mobilesearch'] ) && isset( $settings['mobilesearch']['display'] ) && 'full-screen' === $settings['mobilesearch']['display'];
		return $desktop || $mobile;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Is full screen menu enabled
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'whb_is_full_screen_menu' ) ) {
	function whb_is_full_screen_menu() {
		$settings = whb_get_settings();
		return isset( $settings['mainmenu'] ) && $settings['mainmenu']['full_screen'];
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Is full screen search enabled
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'whb_is_side_cart' ) ) {
	function whb_is_side_cart() {
		$settings = whb_get_settings();
		return isset( $settings['cart'] ) && $settings['cart']['position'] == 'side';
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get header settings and key elements params (search, cart widget, menu)
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'whb_get_settings' ) ) {
	function whb_get_settings() {
		// Fix yoast php error
		if ( ! is_object( whb_get_header() ) ) {
			return array();
		}
		return whb_get_header()->get_options();
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get dropdowns color
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'whb_get_dropdowns_color' ) ) {
	function whb_get_dropdowns_color() {
		if ( woodmart_get_opt( 'dark_version' ) ) {
			return 'light';
		}

		$settings = whb_get_settings();

		if ( isset( $settings['dropdowns_dark'] ) ) {
			return $settings['dropdowns_dark'] ? 'light' : 'dark';
		}
	}
}

if ( ! function_exists( 'whb_get_custom_icon' ) ) {
	/**
	 * Get custom icon.
	 *
	 * @param array $params List icon parameters.
	 * @return string html tag <img> or ''.
	 */
	function whb_get_custom_icon( $params ) {
		$params = wp_parse_args(
			$params,
			array(
				'id'     => '',
				'url'    => '',
				'width'  => '40',
				'height' => '40',
			)
		);

		if ( ! empty( $params['id'] ) ) {
			return wp_get_attachment_image(
				$params['id'],
				array(
					$params['width'],
					$params['height'],
				),
				false,
				array(
					'class' => 'wd-custom-icon',
				)
			);
		} elseif ( ! empty( $params['url'] ) ) {
			return '<img class="wd-custom-icon" src="' . esc_url( $params['url'] ) . '" alt="custom-icon" width="' . esc_attr( $params['width'] ) . '" height="' . esc_attr( $params['height'] ) . '">';
		}

		return '';
	}
}
