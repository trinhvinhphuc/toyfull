<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

class WOODMART_Theme {
	private $register_classes;

	public function __construct() {
		$this->register_classes = array(
			'notices',
			'options',
			'layout',
			'vctemplates',
			'api',
			'license',
			'wpbcssgenerator',
			'themesettingscss',
			'pagecssfiles',
		);

		$this->core_plugin_classes();
		$this->general_files_include();
		$this->wpb_files_include();
		$this->register_classes();
		$this->wpb_element_files_include();
		$this->shortcodes_files_include();

		if ( is_admin() ) {
			$this->admin_files_include();
		}

		if ( 'elementor' === woodmart_get_current_page_builder() ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/elementor/class-elementor.php' );
		}
	}

	private function general_files_include() {
		$files = array(
			'helpers',
			'functions',
			'template-tags/template-tags',
			'template-tags/portfolio',
			'theme-setup',
			'enqueue',

			'classes/Singleton',
			'classes/Googlefonts',
			'classes/Config',
			'classes/Stylesstorage',

			'widgets/widgets',

			// Import.
			'admin/import/class-helpers',
			'admin/import/class-process',
			'admin/import/class-widgets',
			'admin/import/class-sliders',
			'admin/import/class-xml',
			'admin/import/class-options',
			'admin/import/class-headers',
			'admin/import/class-after',
			'admin/import/class-remove',
			'admin/import/class-before',
			'admin/import/class-images',
			'admin/import/class-menu',
			'admin/import/class-import',

			// General modules.
			'modules/lazy-loading',
			'modules/search',
			'modules/mobile-optimization',
			'modules/nav-menu-images/nav-menu-images',
			'modules/sticky-toolbar',
			'modules/white-label',
			'modules/layouts/class-main',
			'modules/layouts/class-global-data',
			'modules/patcher/class-main',

			// Header builder.
			'modules/header-builder/Builder',
			'modules/header-builder/Frontend',
			'modules/header-builder/functions',

			// Woocommerce integration.
			'integrations/woocommerce/functions',
			'integrations/woocommerce/helpers',
			'integrations/woocommerce/template-tags',

			// Woocommerce modules.
			'integrations/woocommerce/modules/attributes-meta-boxes',
			'integrations/woocommerce/modules/product-360-view',
			'integrations/woocommerce/modules/size-guide',
			'integrations/woocommerce/modules/swatches',
			'integrations/woocommerce/modules/catalog-mode',
			'integrations/woocommerce/modules/maintenance',
			'integrations/woocommerce/modules/progress-bar',
			'integrations/woocommerce/modules/quick-shop',
			'integrations/woocommerce/modules/quick-view',
			'integrations/woocommerce/modules/brands',
			'integrations/woocommerce/modules/compare',
			'integrations/woocommerce/modules/quantity',
			'integrations/woocommerce/modules/class-adjacent-products',
			'integrations/woocommerce/modules/comment-images/class-wc-comment-images',

			// Plugin integrations.
			'integrations/wcmp',
			'integrations/wpml',
			'integrations/wordfence',
			'integrations/aioseo',
			'integrations/yoast',
			'integrations/wcfm',
			'integrations/wcfmmp',
			'integrations/gutenberg/functions',
			'integrations/imagify',
			'integrations/dokan',
			'integrations/tgm-plugin-activation',

			'admin/options/class-field',
			'admin/options/class-metabox',
			'admin/options/class-metaboxes',
			'admin/options/class-presets',
			'admin/options/class-options',
			'admin/options/class-sanitize',
			'admin/options/class-page',
			'admin/options/controls/background/class-background',
			'admin/options/controls/buttons/class-buttons',
			'admin/options/controls/checkbox/class-checkbox',
			'admin/options/controls/color/class-color',
			'admin/options/controls/custom-fonts/class-custom-fonts',
			'admin/options/controls/editor/class-editor',
			'admin/options/controls/image-dimensions/class-image-dimensions',
			'admin/options/controls/instagram-api/class-instagram-api',
			'admin/options/controls/notice/class-notice',
			'admin/options/controls/import/class-import',
			'admin/options/controls/range/class-range',
			'admin/options/controls/select/class-select',
			'admin/options/controls/switcher/class-switcher',
			'admin/options/controls/text-input/class-text-input',
			'admin/options/controls/textarea/class-textarea',
			'admin/options/controls/typography/google-fonts',
			'admin/options/controls/typography/class-typography',
			'admin/options/controls/upload/class-upload',
			'admin/options/controls/upload-list/class-upload-list',
			'admin/options/controls/color/class-color',
			'admin/options/controls/reset/class-reset',

			'admin/settings/sections',
			'admin/settings/api-integrations',
			'admin/settings/product-archive',
			'admin/settings/general',
			'admin/settings/general-layout',
			'admin/settings/page-title',
			'admin/settings/footer',
			'admin/settings/typography',
			'admin/settings/colors',
			'admin/settings/blog',
			'admin/settings/portfolio',
			'admin/settings/shop',
			'admin/settings/product',
			'admin/settings/login',
			'admin/settings/custom-css',
			'admin/settings/custom-js',
			'admin/settings/social',
			'admin/settings/performance',
			'admin/settings/other',
			'admin/settings/maintenance',
			'admin/settings/white-label',
			'admin/settings/import',
			'admin/settings/wishlist',

			'admin/metaboxes/pages',
			'admin/metaboxes/products',
			'admin/metaboxes/slider',

			'integrations/woocommerce/modules/variation-gallery',
			'integrations/woocommerce/modules/variation-gallery-new',
			'integrations/woocommerce/modules/wishlist/class-wc-wishlist',
			'integrations/woocommerce/modules/shipping-progress-bar/class-main',
		);

		if ( did_action( 'elementor/loaded' ) ) {
			$files[] = 'integrations/elementor/helpers';
		}

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php' );
		}
	}

	private function register_classes() {
		foreach ( $this->register_classes as $class ) {
			WOODMART_Registry::getInstance()->$class;
		}
	}


	private function wpb_files_include() {
		if ( 'wpb' !== woodmart_get_current_page_builder() || ! defined( 'WPB_VC_VERSION' ) ) {
			return;
		}

		$files = array(
			'integrations/visual-composer/functions',
			'integrations/visual-composer/fields/vc-functions',
			'integrations/visual-composer/fields/fields-css',
			'integrations/visual-composer/fields/image-hotspot',
			'integrations/visual-composer/fields/title-divider',
			'integrations/visual-composer/fields/slider',
			'integrations/visual-composer/fields/responsive-size',
			'integrations/visual-composer/fields/responsive-spacing',
			'integrations/visual-composer/fields/image-select',
			'integrations/visual-composer/fields/dropdown',
			'integrations/visual-composer/fields/css-id',
			'integrations/visual-composer/fields/gradient',
			'integrations/visual-composer/fields/colorpicker',
			'integrations/visual-composer/fields/datepicker',
			'integrations/visual-composer/fields/switch',
			'integrations/visual-composer/fields/button-set',
			'integrations/visual-composer/fields/empty-space',

			'integrations/visual-composer/fields/new/slider',
			'integrations/visual-composer/fields/new/colorpicker',
			'integrations/visual-composer/fields/new/box-shadow',
			'integrations/visual-composer/fields/new/number',
			'integrations/visual-composer/fields/new/select',
			'integrations/visual-composer/fields/new/fonts',
			'integrations/visual-composer/fields/new/dimensions',
		);

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php' );
		}
	}

	private function wpb_element_files_include() {
		$files = array(
			'social',
			'info-box',
			'button',
			'author-area',
			'promo-banner',
			'instagram',
			'images-gallery',
			'size-guide',
		);

		$woo_files = array(
			'products-tabs',
			'brands',
			'categories',
			'product-filters',
			'products-widget',
			'products',
		);

		$wpb_files = array(
			'parallax-scroll',
			'3d-view',
			'products-tabs',
			'ajax-search',
			'counter',
			'blog',
			'brands',
			'countdown-timer',
			'extra-menu',
			'google-map',
			'image-hotspot',
			'list',
			'mega-menu',
			'menu-price',
			'popup',
			'portfolio',
			'pricing-tables',
			'categories',
			'product-filters',
			'products',
			'responsive-text-block',
			'text-block',
			'image',
			'mailchimp',
			'title',
			'row-divider',
			'slider',
			'team-member',
			'testimonials',
			'timeline',
			'twitter',
			'video-poster',
			'compare',
			'wishlist',
			'html-block',
			'tabs',
			'accordion',
			'sidebar',
			'products-widget',
			'off-canvas-column-btn',
		);

		if ( 'wpb' === woodmart_get_current_page_builder() && defined( 'WPB_VC_VERSION' ) ) {
			$files = array_merge( $files, $wpb_files );

			if ( ! woodmart_woocommerce_installed() ) {
				$files = array_diff( $files, $woo_files );
			}
		}

		foreach ( $files as $file ) {
			require_once get_template_directory() . '/inc/integrations/visual-composer/maps/' . $file . '.php';
		}
	}

	private function shortcodes_files_include() {
		$files = array(
			'social',
			'html-block',
			'products',
			'info-box',
			'button',
			'author-area',
			'promo-banner',
			'instagram',
			'user-panel',
			'posts-slider',
			'slider',
			'images-gallery',
			'size-guide',
			'blog',
			'gallery',
		);

		$wpb_files = array(
			'3d-view',
			'ajax-search',
			'countdown-timer',
			'counter',
			'extra-menu',
			'google-map',
			'mega-menu',
			'menu-price',
			'popup',
			'portfolio',
			'pricing-tables',
			'responsive-text-block',
			'text-block',
			'image',
			'mailchimp',
			'row-divider',
			'team-member',
			'testimonials',
			'timeline',
			'title',
			'twitter',
			'list',
			'image-hotspot',
			'products-tabs',
			'brands',
			'categories',
			'product-filters',
			'tabs',
			'accordion',
			'sidebar',
			'off-canvas-column-btn',
		);

		$woo_files = array(
			'products-tabs',
			'brands',
			'categories',
			'product-filters',
			'products',
			'size-guide',
		);

		if ( 'wpb' === woodmart_get_current_page_builder() && defined( 'WPB_VC_VERSION' ) ) {
			$files = array_merge( $files, $wpb_files );

			if ( ! woodmart_woocommerce_installed() ) {
				$files = array_diff( $files, $woo_files );
			}
		}

		foreach ( $files as $file ) {
			require_once get_template_directory() . '/inc/shortcodes/' . $file . '.php';
		}
	}

	private function admin_files_include() {
		$files = array(
			'modules/header-builder/Builder',
			'modules/header-builder/Backend',
			'admin/dashboard/dashboard',
			'admin/setup-wizard/class-setup-wizard',
			'admin/setup-wizard/class-install-child-theme',
			'admin/setup-wizard/class-install-plugins',
			'admin/init',
		);

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php' );
		}
	}

	private function core_plugin_classes() {
		if ( class_exists( 'WOODMART_Auth' ) ) {
			$files = array(
				'vendor/opauth/twitteroauth/twitteroauth',
				'vendor/autoload',
			);

			foreach ( $files as $file ) {
				require_once apply_filters( 'woodmart_require', WOODMART_PT_3D . $file . '.php' );
			}

			$this->register_classes[] = 'auth';
		}
	}
}
