<?php
/**
 * Elementor module file.
 *
 * @package Woodmart
 */

namespace XTS\Elementor;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use XTS\Elementor\Controls\Autocomplete;
use XTS\Elementor\Controls\CSS_Class;
use XTS\Elementor\Controls\Google_Json;
use XTS\Elementor\Controls\Buttons;
use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor module.
 *
 * @package Woodmart
 */
class Elementor extends Singleton {
	/**
	 * Register new controls.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/controls/register', array( $this, 'register_controls' ) );
		add_action( 'init', array( $this, 'files_include' ), 20 );
	}

	/**
	 * Register new controls.
	 *
	 * @since 1.0.0
	 */
	function files_include() {
		$files = array(
			'integrations/elementor/template-library/class-xts-library-source',
			'integrations/elementor/template-library/class-xts-library',
		);

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php' );
		}
	}

	/**
	 * Register new controls.
	 *
	 * @since 1.0.0
	 */
	function register_controls( Controls_Manager $controls_manager ) {
		$files = array(
			'integrations/elementor/controls/class-autocomplete',
			'integrations/elementor/controls/class-buttons',
			'integrations/elementor/controls/class-css-class',
			'integrations/elementor/controls/class-google-json',
		);

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php' );
		}

		$controls_manager->register( new Autocomplete() );
		$controls_manager->register( new Buttons() );
		$controls_manager->register( new Google_Json() );
		$controls_manager->register( new CSS_Class() );
	}

	/**
	 * Register new controls.
	 *
	 * @since 1.0.0
	 */
	public function register_widgets() {
		$files = array(
			'integrations/elementor/functions',
			'integrations/elementor/global-maps',
			'integrations/elementor/elements/class-text-block',
			'integrations/elementor/elements/class-image',
			'integrations/elementor/elements/class-title',
			'integrations/elementor/elements/class-images-gallery',
			'integrations/elementor/elements/class-slider',
			'integrations/elementor/elements/class-extra-menu-list',
			'integrations/elementor/elements/class-3d-view',
			'integrations/elementor/elements/class-search',
			'integrations/elementor/elements/class-sidebar',
			'integrations/elementor/elements/class-counter',
			'integrations/elementor/elements/class-author-area',
			'integrations/elementor/elements/class-countdown',
			'integrations/elementor/elements/class-list',
			'integrations/elementor/elements/class-twitter',
			'integrations/elementor/elements/class-social',
			'integrations/elementor/elements/class-team-member',
			'integrations/elementor/elements/class-mega-menu',
			'integrations/elementor/elements/class-menu-price',
			'integrations/elementor/elements/class-menu-anchor',
			'integrations/elementor/elements/class-popup',
			'integrations/elementor/elements/class-pricing-tables',
			'integrations/elementor/elements/class-timeline',
			'integrations/elementor/elements/class-google-map',
			'integrations/elementor/elements/class-image-hotspot',
			'integrations/elementor/elements/class-contact-form-7',
			'integrations/elementor/elements/class-mailchimp',
			'integrations/elementor/elements/class-testimonials',
			'integrations/elementor/elements/button/class-button',
			'integrations/elementor/elements/button/button',
			'integrations/elementor/elements/button/global-button',
			'integrations/elementor/elements/blog/class-blog',
			'integrations/elementor/elements/blog/blog',
			'integrations/elementor/elements/banner/banner',
			'integrations/elementor/elements/banner/class-banner',
			'integrations/elementor/elements/banner/class-banner-carousel',
			'integrations/elementor/elements/infobox/infobox',
			'integrations/elementor/elements/infobox/class-infobox',
			'integrations/elementor/elements/infobox/class-infobox-carousel',
			'integrations/elementor/elements/instagram/class-instagram',
			'integrations/elementor/elements/instagram/instagram',
			'integrations/elementor/elements/portfolio/class-portfolio',
			'integrations/elementor/elements/portfolio/portfolio',
			'integrations/elementor/elements/class-tabs',
			'integrations/elementor/elements/class-accordion',
			'integrations/elementor/elements/class-off-canvas-column-btn',

			'integrations/elementor/default-elements/column',
			'integrations/elementor/default-elements/common',
			'integrations/elementor/default-elements/section',
			'integrations/elementor/default-elements/text-editor',
			'integrations/elementor/default-elements/accordion',
			'integrations/elementor/default-elements/video',
		);

		$woo_files = array(
			'integrations/elementor/elements/class-size-guide',
			'integrations/elementor/elements/products/class-products',
			'integrations/elementor/elements/products/products',
			'integrations/elementor/elements/products-tabs/class-products-tabs',
			'integrations/elementor/elements/products-tabs/products-tabs',
			'integrations/elementor/elements/class-product-filters',
			'integrations/elementor/elements/class-wishlist',
			'integrations/elementor/elements/class-compare',
			'integrations/elementor/elements/class-product-categories',
			'integrations/elementor/elements/class-products-brands',
			'integrations/elementor/elements/class-widget-products',
		);

		if ( woodmart_woocommerce_installed() ) {
			$files = array_merge( $files, $woo_files );
		}

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php' );
		}
	}
}

Elementor::get_instance();
