<?php
/**
 * Helpers.
 *
 * @package Woodmart
 */

use XTS\Config;
use XTS\Modules\Layouts\Main as Builder;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_page_css_files_disable' ) ) {
	/**
	 * Page css files disable.
	 *
	 * @since 1.0.0
	 */
	function woodmart_page_css_files_disable() {
		$GLOBALS['wd_page_css_ignore'] = true;
	}
}

if ( ! function_exists( 'woodmart_page_css_files_enable' ) ) {
	/**
	 * Page css files enable.
	 *
	 * @since 1.0.0
	 */
	function woodmart_page_css_files_enable() {
		unset( $GLOBALS['wd_page_css_ignore'] );
	}
}

if ( ! function_exists( 'woodmart_cookie_secure_param' ) ) {
	/**
	 * Cookie secure param.
	 *
	 * @since 1.0.0
	 */
	function woodmart_cookie_secure_param() {
		return apply_filters( 'woodmart_cookie_secure_param', is_ssl() );
	}
}

if ( ! class_exists( 'WD_WPBakeryShortCodeFix' ) ) {
	/**
	 * Class fix for compatibility with WPB addons plugins.
	 */
	class WD_WPBakeryShortCodeFix {
		/**
		 * Settings.
		 *
		 * @return null
		 */
		public function settings() {
			return null;
		}
	}
}

if ( ! function_exists( 'woodmart_fix_transitions_flicking' ) ) {
	/**
	 * Fix for transitions flicking.
	 *
	 * @since 1.0.0
	 */
	function woodmart_fix_transitions_flicking() {
		echo '<script type="text/javascript" id="wd-flicker-fix">// Flicker fix.</script>';
	}

	add_action( 'wp_body_open', 'woodmart_fix_transitions_flicking', 1 );
}

if ( ! function_exists( 'woodmart_get_theme_settings_selectors_array' ) ) {
	/**
	 * Get selectors array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_selectors_array() {
		return woodmart_get_config( 'typography-selectors' );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_css_files_name_array' ) ) {
	/**
	 * Get css files array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_css_files_name_array() {
		return woodmart_get_theme_settings_css_files_array( 'name' );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_css_files_array' ) ) {
	/**
	 * Get css files array.
	 *
	 * @param string $name_format Result name format.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_css_files_array( $name_format = 'title' ) {
		$config_styles  = woodmart_get_config( 'css-files' );
		$styles_options = array();

		foreach ( $config_styles as $key => $styles ) {
			foreach ( $styles as $style ) {
				if ( isset( $styles_options[ $style['name'] ] ) ) {
					continue;
				}

				$styles_options[ $key ] = array(
					'name'  => $style['title'],
					'value' => $key,
				);

				if ( 'name' === $name_format ) {
					$styles_options[ $key ]['name'] = 'wd-' . $style['name'] . '-css';
				}
			}
		}

		asort( $styles_options );

		return $styles_options;
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_js_scripts_files_array' ) ) {
	/**
	 * Get js files array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_js_scripts_files_array() {
		$config_scripts  = woodmart_get_config( 'js-scripts' );
		$scripts_options = array();

		foreach ( $config_scripts as $key => $scripts ) {
			foreach ( $scripts as $script ) {
				if ( isset( $scripts_options[ $script['name'] ] ) ) {
					continue;
				}

				$scripts_options[ $key ] = array(
					'name'  => $script['title'],
					'value' => $key,
				);
			}
		}

		asort( $scripts_options );

		return $scripts_options;
	}
}

if ( ! function_exists( 'woodmart_get_current_page_builder' ) ) {
	/**
	 * Get current page builder.
	 *
	 * @since 6.1.0
	 */
	function woodmart_get_current_page_builder() {
		$builder                = defined( 'WPB_VC_VERSION' ) ? 'wpb' : '';
		$theme_settings_builder = woodmart_get_opt( 'page_builder', 'auto' );

		if ( did_action( 'elementor/loaded' ) && ( 'auto' === $theme_settings_builder || 'elementor' === $theme_settings_builder ) ) {
			$builder = 'elementor';
		}

		if ( defined( 'WPB_VC_VERSION' ) && ( 'auto' === $theme_settings_builder || 'wpb' === $theme_settings_builder ) ) {
			$builder = 'wpb';
		}

		return $builder;
	}
}

if ( ! function_exists( 'woodmart_is_blog_design_new' ) ) {
	/**
	 * Is blog design new.
	 *
	 * @since 6.1.0
	 *
	 * @param string $design Design.
	 */
	function woodmart_is_blog_design_new( $design ) {
		$old = array(
			'default',
			'default-alt',
			'small-images',
			'chess',
			'masonry',
			'mask',
		);

		return ! in_array( $design, $old, true );
	}
}

if ( ! function_exists( 'woodmart_get_element_template' ) ) {
	/**
	 * Loads a template part into a template.
	 *
	 * @since 6.1.0
	 *
	 * @param string $element_name  Template name.
	 * @param array  $args          Arguments.
	 * @param string $template_name Module name.
	 */
	function woodmart_get_element_template( $element_name, $args, $template_name ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // phpcs:ignore
		}

		include WOODMART_THEMEROOT . '/inc/template-tags/elements/' . $element_name . '/' . $template_name;
	}
}

if ( ! function_exists( 'woodmart_get_old_classes' ) ) {
	/**
	 * Get old classes.
	 *
	 * @since 6.0.0
	 *
	 * @param string $classes Classes.
	 *
	 * @return string
	 */
	function woodmart_get_old_classes( $classes ) {
		if ( ! woodmart_get_opt( 'old_elements_classes', true ) ) {
			$classes = '';
		}

		return esc_html( $classes );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_selectors_array' ) ) {
	/**
	 * Get selectors array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_selectors_array() {
		return woodmart_get_config( 'typography-selectors' );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_headers_array' ) ) {
	/**
	 * Function to get array of HTML Blocks in theme settings array style.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_headers_array() {
		$list = get_option( 'whb_saved_headers' );

		if ( ! $list ) {
			$list = whb_get_builder()->list->get_all();
		}

		$headers = array();

		$headers['none'] = array(
			'name'  => esc_html__( 'None', 'woodmart' ),
			'value' => 'none',
		);

		if ( ! empty( $list ) && is_array( $list ) ) {
			foreach ( $list as $key => $header ) {
				$headers[ $key ] = array(
					'name'  => $header['name'],
					'value' => $key,
				);
			}
		}

		return $headers;
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_js_scripts_files_array' ) ) {
	/**
	 * Get js files array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_js_scripts_files_array() {
		$config_scripts  = woodmart_get_config( 'js-scripts' );
		$scripts_options = array();

		foreach ( $config_scripts as $key => $scripts ) {
			foreach ( $scripts as $script ) {
				if ( isset( $scripts_options[ $script['name'] ] ) ) {
					continue;
				}

				$scripts_options[ $key ] = array(
					'name'  => $script['title'],
					'value' => $key,
				);
			}
		}

		asort( $scripts_options );

		return $scripts_options;
	}
}

if ( ! function_exists( 'woodmart_get_current_url' ) ) {
	/**
	 * Get current url.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function woodmart_get_current_url() {
		global $wp;

		return home_url( $wp->request );
	}
}

if ( ! function_exists( 'woodmart_get_document_title' ) ) {
	/**
	 * Returns document title for the current page.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function woodmart_get_document_title() {
		$title = wp_get_document_title();

		$post_meta = get_post_meta( woodmart_get_the_ID(), '_yoast_wpseo_title', true );
		if ( property_exists( get_queried_object(), 'term_id' ) && function_exists( 'YoastSEO' ) ) {
			$taxonomy_helper = YoastSEO()->helpers->taxonomy;
			$meta            = $taxonomy_helper->get_term_meta( get_queried_object() );

			if ( isset( $meta['wpseo_title'] ) && $meta['wpseo_title'] ) {
				$title = wpseo_replace_vars( $meta['wpseo_title'], get_queried_object() );
			}
		} elseif ( $post_meta && function_exists( 'wpseo_replace_vars' ) ) {
			$title = wpseo_replace_vars( $post_meta, get_post( woodmart_get_the_ID() ) );
		}

		return $title;
	}
}

if ( ! function_exists( 'woodmart_get_new_size_classes' ) ) {
	/**
	 * Get new size classes.
	 *
	 * @param mixed $element Element.
	 * @param mixed $old_key Old key.
	 * @param mixed $selector Selector.
	 *
	 * @return string
	 */
	function woodmart_get_new_size_classes( $element, $old_key, $selector ) {
		$array = array(
			'banner'       => array(
				'small'       => array(
					'subtitle' => 'xs',
					'title'    => 's',
				),
				'default'     => array(
					'subtitle' => 'xs',
					'title'    => 'l',
					'content'  => 'xs',
				),
				'large'       => array(
					'subtitle' => 's',
					'title'    => 'xl',
					'content'  => 'm',
				),
				'extra-large' => array(
					'subtitle' => 'm',
					'title'    => 'xxl',
				),
				'medium'      => array(
					'content' => 's',
				),
			),
			'infobox'      => array(
				'small'       => array(
					'subtitle' => 'xs',
					'title'    => 's',
				),
				'default'     => array(
					'subtitle' => 'xs',
					'title'    => 'm',
				),
				'large'       => array(
					'subtitle' => 's',
					'title'    => 'xl',
				),
				'extra-large' => array(
					'subtitle' => 'm',
					'title'    => 'xxl',
				),
			),
			'title'        => array(
				'small'       => array(
					'subtitle'    => 'xs',
					'title'       => 'm',
					'after_title' => 'xs',
				),
				'default'     => array(
					'subtitle'    => 'xs',
					'title'       => 'l',
					'after_title' => 'xs',
				),
				'medium'      => array(
					'subtitle'    => 'xs',
					'title'       => 'xl',
					'after_title' => 's',
				),
				'large'       => array(
					'subtitle'    => 'xs',
					'title'       => 'xxl',
					'after_title' => 's',
				),
				'extra-large' => array(
					'subtitle'    => 'm',
					'title'       => 'xxxl',
					'after_title' => 's',
				),
			),
			'text'         => array(
				'small'       => array(
					'title' => 'm',
				),
				'default'     => array(
					'title' => 'l',
				),
				'medium'      => array(
					'title' => 'xl',
				),
				'large'       => array(
					'title' => 'xxl',
				),
				'extra-large' => array(
					'title' => 'xxxl',
				),
			),
			'list'         => array(
				'default'     => array(
					'text' => 'xs',
				),
				'medium'      => array(
					'text' => 's',
				),
				'large'       => array(
					'text' => 'm',
				),
				'extra-large' => array(
					'text' => 'l',
				),
			),
			'testimonials' => array(
				'small'  => array(
					'text' => 'xs',
				),
				'medium' => array(
					'text' => 's',
				),
				'large'  => array(
					'text' => 'm',
				),
			),
		);

		return isset( $array[ $element ][ $old_key ][ $selector ] ) ? 'wd-fontsize-' . $array[ $element ][ $old_key ][ $selector ] : '';
	}
}

if ( ! function_exists( 'array_key_first' ) ) {
	function array_key_first( array $arr ) {
		foreach ( $arr as $key => $unused ) {
			return $key;
		}
		return null;
	}
}

if ( ! function_exists( 'woodmart_is_elementor_full_width' ) ) {
	/**
	 * Check if Elementor full width.
	 *
	 * @param bool $negative_gap_ignore Is ignore negative gap option.
	 *
	 * @return boolean
	 */
	function woodmart_is_elementor_full_width( $negative_gap_ignore = false ) {
		$page_template = get_post_meta( woodmart_get_the_ID(), '_wp_page_template', true );

		if ( woodmart_is_elementor_pro_installed() ) {
			$manager = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'theme-builder' )->get_conditions_manager();

			if ( $manager->get_documents_for_location( 'single' ) || $manager->get_documents_for_location( 'archive' ) ) {
				$page_template = 'elementor_header_footer';
			}
		}

		if ( $negative_gap_ignore ) {
			return 'elementor_header_footer' === $page_template;
		}

		return 'elementor_header_footer' === $page_template && 'enabled' !== woodmart_get_opt( 'negative_gap', 'enabled' );
	}
}

if ( ! function_exists( 'woodmart_is_elementor_pro_installed' ) ) {
	/**
	 * Check if Elementor PRO is activated
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	function woodmart_is_elementor_pro_installed() {
		return defined( 'ELEMENTOR_PRO_VERSION' ) && woodmart_is_elementor_installed();
	}
}

if ( ! function_exists( 'woodmart_vc_build_link' ) ) {
	function woodmart_vc_build_link( $value ) {
		return woodmart_vc_parse_multi_attribute(
			$value,
			array(
				'url'    => '',
				'title'  => '',
				'target' => '',
				'rel'    => '',
			)
		);
	}
}

if ( ! function_exists( 'woodmart_vc_parse_multi_attribute' ) ) {
	function woodmart_vc_parse_multi_attribute( $value, $default = array() ) {
		$result       = $default;
		$params_pairs = explode( '|', $value );
		if ( ! empty( $params_pairs ) ) {
			foreach ( $params_pairs as $pair ) {
				$param = preg_split( '/\:/', $pair );
				if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
					$result[ $param[0] ] = rawurldecode( $param[1] );
				}
			}
		}

		return $result;
	}
}
if ( ! function_exists( 'woodmart_get_size_guides_array' ) ) {
	function woodmart_get_size_guides_array( $style = 'default' ) {
		if ( 'default' === $style ) {
			$output = array(
				esc_html__( 'Select', 'woodmart' ) => '',
			);
		} elseif ( 'elementor' === $style ) {
			$output = array(
				'0' => esc_html__( 'Select', 'woodmart' ),
			);
		}

		$posts = get_posts(
			array(
				'posts_per_page' => 200,
				'post_type'      => 'woodmart_size_guide',
			)
		);

		foreach ( $posts as $post ) {
			if ( 'default' === $style ) {
				$output[ $post->post_title ] = $post->ID;
			} elseif ( 'elementor' === $style ) {
				$output[ $post->ID ] = $post->post_title;
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'woodmart_is_elementor_installed' ) ) {
	/**
	 * Check if Elementor is activated
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	function woodmart_is_elementor_installed() {
		return did_action( 'elementor/loaded' ) && 'elementor' === woodmart_get_current_page_builder();
	}
}
// **********************************************************************//
// Remove https
// **********************************************************************//

if ( ! function_exists( 'woodmart_remove_https' ) ) {
	function woodmart_remove_https( $link ) {
		return preg_replace( '#^https?:#', '', $link );
	}
}

// **********************************************************************//
// ! If page needs header
// **********************************************************************//

if ( ! function_exists( 'woodmart_needs_header' ) ) {
	function woodmart_needs_header() {
		return ( ! isset( $GLOBALS['wd_maintenance'] ) && ! is_singular( 'woodmart_slide' ) && ! is_singular( 'cms_block' ) );
	}
}

// **********************************************************************//
// ! If page needs footer
// **********************************************************************//

if ( ! function_exists( 'woodmart_needs_footer' ) ) {
	function woodmart_needs_footer() {
		return ( ! isset( $GLOBALS['wd_maintenance'] ) && ! is_singular( 'woodmart_slide' ) && ! is_singular( 'cms_block' ) );
	}
}


// **********************************************************************//
// ! Conditional tags
// **********************************************************************//

if ( ! function_exists( 'woodmart_is_shop_archive' ) ) {
	function woodmart_is_shop_archive() {
		return ( woodmart_woocommerce_installed() && ( is_shop() || is_product_category() || is_product_tag() || is_singular( 'product' ) || woodmart_is_product_attribute_archive() ) );
	}
}

if ( ! function_exists( 'woodmart_is_blog_archive' ) ) {
	function woodmart_is_blog_archive() {
		return ( is_home() || is_search() || is_tag() || is_category() || is_date() || is_author() );
	}
}

if ( ! function_exists( 'woodmart_is_portfolio_archive' ) ) {
	function woodmart_is_portfolio_archive() {
		return ( is_post_type_archive( 'portfolio' ) || is_tax( 'project-cat' ) );
	}
}

// **********************************************************************//
// ! Is maintenance page
// **********************************************************************//

if ( ! function_exists( 'woodmart_maintenance_page' ) ) {
	function woodmart_maintenance_page() {
		if ( ! woodmart_get_opt( 'maintenance_mode' ) || is_user_logged_in() ) {
			return false;
		}

		$pages_ids = woodmart_pages_ids_from_template( 'maintenance' );

		if ( ! empty( $pages_ids ) && is_page( $pages_ids ) ) {
			return true;
		}

		return false;
	}
}

// **********************************************************************//
// ! Get config file
// **********************************************************************//

if ( ! function_exists( 'woodmart_get_config' ) ) {
	function woodmart_get_config( $name ) {
		return Config::get_instance()->get_config( $name );
	}
}


// **********************************************************************//
// ! Text to one-line string
// **********************************************************************//

if ( ! function_exists( 'woodmart_text2line' ) ) {
	function woodmart_text2line( $str ) {
		return trim( preg_replace( "/('|\"|\r?\n)/", '', $str ) );
	}
}


// **********************************************************************//
// ! Get page ID by it's template name
// **********************************************************************//
if ( ! function_exists( 'woodmart_tpl2id' ) ) {
	function woodmart_tpl2id( $tpl = '' ) {
		$pages = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => $tpl,
			)
		);
		foreach ( $pages as $page ) {
			return $page->ID;
		}
	}
}

if ( ! function_exists( 'woodmart_get_portfolio_page_id' ) ) {
	/**
	 * Get portfolio page id.
	 */
	function woodmart_get_portfolio_page_id() {
		return woodmart_get_opt( 'portfolio_page' ) ? woodmart_get_opt( 'portfolio_page' ) : woodmart_tpl2id( 'portfolio.php' );
	}
}


// **********************************************************************//
// ! Function print array within a pre tags
// **********************************************************************//
if ( ! function_exists( 'ar' ) ) {
	function ar( $array ) {
		echo '<pre>';
			print_r( $array );
		echo '</pre>';
	}
}


// **********************************************************************//
// ! Get protocol (http or https)
// **********************************************************************//
if ( ! function_exists( 'woodmart_http' ) ) {
	function woodmart_http() {
		if ( ! is_ssl() ) {
			return 'http';
		} else {
			return 'https';
		}
	}
}

// **********************************************************************//
// Woodmart get theme info
// **********************************************************************//
if ( ! function_exists( 'woodmart_get_theme_info' ) ) {
	function woodmart_get_theme_info( $parameter ) {
		$theme_info = wp_get_theme();
		if ( is_child_theme() && is_object( $theme_info->parent() ) ) {
			$theme_info = wp_get_theme( $theme_info->parent()->template );
		}
			return $theme_info->get( $parameter );
	}
}

// **********************************************************************//
// Is share button enable
// **********************************************************************//
if ( ! function_exists( 'woodmart_is_social_link_enable' ) ) {
	function woodmart_is_social_link_enable( $type ) {
		$result = false;
		if ( $type == 'share' && ( woodmart_get_opt( 'share_fb' ) || woodmart_get_opt( 'share_twitter' ) || woodmart_get_opt( 'share_linkedin' ) || woodmart_get_opt( 'share_pinterest' ) || woodmart_get_opt( 'share_ok' ) || woodmart_get_opt( 'share_whatsapp' ) || woodmart_get_opt( 'share_email' ) || woodmart_get_opt( 'share_vk' ) || woodmart_get_opt( 'share_tg' ) || woodmart_get_opt( 'share_viber' ) ) ) {
			$result = true;
		}

		if ( $type == 'follow' && ( woodmart_get_opt( 'fb_link' ) || woodmart_get_opt( 'twitter_link' ) || woodmart_get_opt( 'google_link' ) || woodmart_get_opt( 'isntagram_link' ) || woodmart_get_opt( 'pinterest_link' ) || woodmart_get_opt( 'youtube_link' ) || woodmart_get_opt( 'tumblr_link' ) || woodmart_get_opt( 'linkedin_link' ) || woodmart_get_opt( 'vimeo_link' ) || woodmart_get_opt( 'flickr_link' ) || woodmart_get_opt( 'github_link' ) || woodmart_get_opt( 'dribbble_link' ) || woodmart_get_opt( 'behance_link' ) || woodmart_get_opt( 'soundcloud_link' ) || woodmart_get_opt( 'spotify_link' ) || woodmart_get_opt( 'ok_link' ) || woodmart_get_opt( 'whatsapp_link' ) || woodmart_get_opt( 'vk_link' ) || woodmart_get_opt( 'snapchat_link' ) || woodmart_get_opt( 'tg_link' ) || woodmart_get_opt( 'tiktok_link' ) || woodmart_get_opt( 'social_email' ) ) ) {
			$result = true;
		}

		return $result;
	}
}

// **********************************************************************//
// Is compare iframe
// **********************************************************************//
if ( ! function_exists( 'woodmart_is_compare_iframe' ) ) {
	function woodmart_is_compare_iframe() {
		return wp_script_is( 'jquery-fixedheadertable', 'enqueued' );
	}
}

// **********************************************************************//
// Is SVG image
// **********************************************************************//
if ( ! function_exists( 'woodmart_is_svg' ) ) {
	function woodmart_is_svg( $src ) {
		return substr( $src, -3, 3 ) == 'svg';
	}
}

// **********************************************************************//
// Get explode size
// **********************************************************************//
if ( ! function_exists( 'woodmart_get_explode_size' ) ) {
	function woodmart_get_explode_size( $img_size, $default_size ) {
		$sizes = explode( 'x', $img_size );
		if ( count( $sizes ) < 2 ) {
			$sizes[0] = $sizes[1] = $default_size;
		}
		return $sizes;
	}
}

// **********************************************************************//
// Check is theme is activated with a purchase code
// **********************************************************************//

if ( ! function_exists( 'woodmart_is_license_activated' ) ) {
	function woodmart_is_license_activated() {
		return get_option( 'woodmart_is_activated', false );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Is shop on front page
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_is_shop_on_front' ) ) {
	function woodmart_is_shop_on_front() {
		return function_exists( 'wc_get_page_id' ) && 'page' === get_option( 'show_on_front' ) && wc_get_page_id( 'shop' ) == get_option( 'page_on_front' );
	}
}

if ( ! function_exists( 'woodmart_get_allowed_html' ) ) {
	/**
	 * Return allowed html tags
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function woodmart_get_allowed_html() {
		return apply_filters(
			'woodmart_allowed_html',
			array(
				'h1'     => array(),
				'h2'     => array(),
				'h3'     => array(),
				'h4'     => array(),
				'h5'     => array(),
				'h6'     => array(),
				'pre'    => array(),
				'p'      => array(),
				'br'     => array(),
				'i'      => array(),
				'b'      => array(),
				'u'      => array(),
				'em'     => array(),
				'del'    => array(),
				'a'      => array(
					'href'   => true,
					'class'  => true,
					'target' => true,
					'title'  => true,
					'rel'    => true,
				),
				'strong' => array(),
				'span'   => array(
					'style' => true,
					'class' => true,
				),
			)
		);
	}
}


if ( ! function_exists( 'woodmart_clean' ) ) {
	/**
	 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
	 * Non-scalar values are ignored.
	 *
	 * @param string|array $var Data to sanitize.
	 * @return string|array
	 */
	function woodmart_clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'woodmart_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}

if ( ! function_exists( 'woodmart_get_svg_html' ) ) {
	/**
	 * Function to show SVG images.
	 *
	 * @param string|int  $image_id image id.
	 * @param null|string $size Needed image size. Default = thumbnail.
	 * @param null|string $attributes List of attributes. If a whip then the data is taken from $attachment object.
	 * @return string html tag img string.
	 */
	function woodmart_get_svg_html( $image_id, $size = 'thumbnail', $attributes = array() ) {
		$html       = '';
		$thumb_size = array();

		$attributes = wp_parse_args(
			$attributes,
			array(
				'alt'   => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
				'src'   => wp_get_attachment_image_url( $image_id, 'full' ),
				'title' => get_the_title( $image_id ),
			)
		);

		if ( 'string' === gettype( $size ) ) {
			$thumb_size = woodmart_get_image_size( $size );
		} elseif ( is_array( $size ) ) {
			if ( array_key_exists( 'width', $size ) && array_key_exists( 'height', $size ) ) {
				$thumb_size[0] = $size['width'];
				$thumb_size[1] = $size['height'];
			} else {
				$thumb_size = $size;
			}
		}

		if ( isset( $attributes ) ) {
			$attributes['width']  = $thumb_size[0];
			$attributes['height'] = $thumb_size[1];

			$attributes = array_map( 'esc_attr', $attributes );

			foreach ( $attributes as $name => $value ) {
				if ( ! empty( $value ) ) {
					$html .= " $name=" . '"' . $value . '"';
				}
			}
		}
		return '<img ' . $html . '>';
	}
}

if ( ! function_exists( 'woodmart_get_mailchimp_forms' ) ) {
	/**
	 * This function return form list for mailchimp.
	 *
	 * @return array
	 */
	function woodmart_get_mailchimp_forms() {
		$forms = get_posts(
			array(
				'post_type'   => 'mc4wp-form',
				'numberposts' => -1,
			)
		);

		$mailchimp_forms = array();

		if ( $forms ) {
			foreach ( $forms as $form ) {
				$mailchimp_forms[ $form->post_title ] = $form->ID;
			}
		}

		return $mailchimp_forms;
	}
}

if ( ! function_exists( 'woodmart_get_wpb_font_family_options' ) ) {
	/**
	 * This function get theme font options and return array for WPBakery map.
	 *
	 * @return array
	 */
	function woodmart_get_wpb_font_family_options() {
		$secondary_font = woodmart_get_opt( 'secondary-font' );
		$primary_font   = woodmart_get_opt( 'primary-font' );
		$text_font      = woodmart_get_opt( 'text-font' );

		$secondary_font_title = isset( $secondary_font[0] ) ? esc_html__( 'Secondary font', 'woodmart' ) . ' (' . $secondary_font[0]['font-family'] . ')' : esc_html__( 'Secondary font', 'woodmart' );
		$text_font_title      = isset( $text_font[0] ) ? esc_html__( 'Text font', 'woodmart' ) . ' (' . $text_font[0]['font-family'] . ')' : esc_html__( 'Text', 'woodmart' );
		$primary_font_title   = isset( $primary_font[0] ) ? esc_html__( 'Title font', 'woodmart' ) . ' (' . $primary_font[0]['font-family'] . ')' : esc_html__( 'Title font', 'woodmart' );

		return array(
			$primary_font_title   => 'primary',
			$text_font_title      => 'text',
			$secondary_font_title => 'alt',
		);
	}
}

if ( ! function_exists( 'woodmart_get_builder_status_class' ) ) {
	/**
	 * This function return woodmart css class for check builder status (on/off).
	 *
	 * @return string
	 */
	function woodmart_get_builder_status_class() {
		if ( Builder::get_instance()->has_custom_layout( 'single_product' ) || Builder::get_instance()->has_custom_layout( 'shop_archive' ) || Builder::get_instance()->has_custom_layout( 'cart' ) || Builder::get_instance()->has_custom_layout( 'checkout_content' ) || Builder::get_instance()->has_custom_layout( 'checkout_form' ) ) {
			$class = ' wd-builder-on';
		} else {
			$class = ' wd-builder-off';
		}

		return $class;
	}
}

if ( ! function_exists( 'woodmart_get_responsive_dependency_width_map' ) ) {
	/**
	 * Get width map (with responsive dependency tabs).
	 *
	 * @param string $key name needed field.
	 *
	 * @return array
	 */
	function woodmart_get_responsive_dependency_width_map( $key ) {
		if ( ! function_exists( 'woodmart_compress' ) ) {
			return array();
		}

		$fields = array(
			// Desktop.
			'responsive_tabs'      => array(
				'heading'          => esc_html__( 'Width', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'type'             => 'woodmart_button_set',
				'param_name'       => 'responsive_tabs',
				'tabs'             => true,
				'value'            => array(
					esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
					esc_html__( 'Tablet', 'woodmart' )  => 'tablet',
					esc_html__( 'Mobile', 'woodmart' )  => 'mobile',
				),
				'default'          => 'desktop',
				'edit_field_class' => 'wd-custom-width vc_col-sm-12 vc_column',
			),
			'width_desktop'        => array(
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'type'             => 'wd_select',
				'param_name'       => 'width_desktop',
				'style'            => 'select',
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'width: {{VALUE}} !important;',
						'max-width: {{VALUE}} !important;',
					),
				),
				'devices'          => array(
					'desktop' => array(
						'value' => '',
					),
				),
				'value'            => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Full Width (100%)', 'woodmart' ) => '100%',
					esc_html__( 'Inline (auto)', 'woodmart' ) => 'auto',
					esc_html__( 'Custom', 'woodmart' )  => '-',
				),
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'desktop' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			'custom_width_desktop' => array(
				'heading'          => esc_html__( 'Custom width', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'type'             => 'wd_slider',
				'param_name'       => 'custom_width_desktop',
				'devices'          => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
					),
				),
				'range'            => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'width: {{VALUE}}{{UNIT}} !important;',
						'max-width: {{VALUE}}{{UNIT}} !important;',
					),
				),
				'dependency'       => array(
					'element' => 'width_desktop',
					'value'   => woodmart_compress(
						wp_json_encode(
							array(
								'devices' => array(
									'desktop' => array(
										'value' => '-',
									),
								),
							)
						)
					),
				),
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'desktop' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			// Tablet.
			'width_tablet'         => array(
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'type'             => 'wd_select',
				'param_name'       => 'width_tablet',
				'style'            => 'select',
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'width: {{VALUE}} !important;',
						'max-width: {{VALUE}} !important;',
					),
				),
				'devices'          => array(
					'tablet' => array(
						'value' => '',
					),
				),
				'value'            => array(
					esc_html__( 'Inherit', 'woodmart' ) => '',
					esc_html__( 'Full Width (100%)', 'woodmart' ) => '100%',
					esc_html__( 'Inline (auto)', 'woodmart' ) => 'auto',
					esc_html__( 'Custom', 'woodmart' )  => '-',
				),
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'tablet' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			'custom_width_tablet'  => array(
				'heading'          => esc_html__( 'Custom width', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'type'             => 'wd_slider',
				'param_name'       => 'custom_width_tablet',
				'devices'          => array(
					'tablet' => array(
						'unit'  => 'px',
						'value' => 0,
					),
				),
				'range'            => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'width: {{VALUE}}{{UNIT}} !important;',
						'max-width: {{VALUE}}{{UNIT}} !important;',
					),
				),
				'dependency'       => array(
					'element' => 'width_tablet',
					'value'   => woodmart_compress(
						wp_json_encode(
							array(
								'devices' => array(
									'tablet' => array(
										'value' => '-',
									),
								),
							)
						)
					),
				),
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'tablet' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			// Mobile.
			'width_mobile'         => array(
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'type'             => 'wd_select',
				'param_name'       => 'width_mobile',
				'style'            => 'select',
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'width: {{VALUE}} !important;',
						'max-width: {{VALUE}} !important;',
					),
				),
				'devices'          => array(
					'mobile' => array(
						'value' => '',
					),
				),
				'value'            => array(
					esc_html__( 'Inherit', 'woodmart' ) => '',
					esc_html__( 'Full Width (100%)', 'woodmart' ) => '100%',
					esc_html__( 'Inline (auto)', 'woodmart' ) => 'auto',
					esc_html__( 'Custom', 'woodmart' )  => '-',
				),
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'mobile' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			'custom_width_mobile'  => array(
				'heading'          => esc_html__( 'Custom width', 'woodmart' ),
				'group'            => esc_html__( 'Advanced', 'woodmart' ),
				'type'             => 'wd_slider',
				'param_name'       => 'custom_width_mobile',
				'devices'          => array(
					'mobile' => array(
						'unit'  => 'px',
						'value' => 0,
					),
				),
				'range'            => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'        => array(
					'{{WRAPPER}}' => array(
						'width: {{VALUE}}{{UNIT}} !important;',
						'max-width: {{VALUE}}{{UNIT}} !important;',
					),
				),
				'dependency'       => array(
					'element' => 'width_mobile',
					'value'   => woodmart_compress(
						wp_json_encode(
							array(
								'devices' => array(
									'mobile' => array(
										'value' => '-',
									),
								),
							)
						)
					),
				),
				'wd_dependency'    => array(
					'element' => 'responsive_tabs',
					'value'   => array( 'mobile' ),
				),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
		);

		return $fields[ $key ];
	}
}

if ( ! function_exists( 'woodmart_is_compressed_data' ) ) {
	/**
	 * Check $variable to compressed.
	 *
	 * @param string $variable need check data.
	 * @return bool
	 */
	function woodmart_is_compressed_data( $variable ) {
		if ( ! function_exists( 'woodmart_compress' ) || ! function_exists( 'woodmart_decompress' ) ) {
			return '';
		}
		return woodmart_compress( woodmart_decompress( $variable ) ) === $variable;
	}
}
