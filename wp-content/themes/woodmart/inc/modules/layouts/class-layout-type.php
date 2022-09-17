<?php
/**
 * Layout type.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Plugin;
use XTS\Singleton;

/**
 * Single product builder class.
 */
abstract class Layout_Type extends Singleton {
	/**
	 * Constructor.
	 */
	public function init() {
		add_filter( 'template_include', array( $this, 'override_template' ), 20 );
	}

	/**
	 * Check.
	 *
	 * @param array  $condition Condition.
	 * @param string $type      Layout type.
	 */
	public function check( $condition, $type = '' ) {
	}

	/**
	 * Override templates.
	 *
	 * @param string $template Template.
	 */
	public function override_template( $template ) {
	}

	/**
	 * Display template.
	 */
	private function display_template() {
	}

	/**
	 * Before template content.
	 */
	public function before_template_content() {
		get_header();
		do_action( 'woocommerce_before_main_content' );
	}

	/**
	 * After template content.
	 */
	public function after_template_content() {
		do_action( 'woocommerce_after_main_content' );
		get_footer();
	}

	/**
	 * Template content.
	 *
	 * @param string $type Template type.
	 */
	public function template_content( $type ) {
		$id   = Main::get_instance()->get_layout_id( $type );
		$post = get_post( $id );

		if ( ! $post || 'woodmart_layout' !== $post->post_type || ! $id ) {
			return;
		}

		if ( woodmart_is_elementor_installed() && Plugin::$instance->documents->get( $id )->is_built_with_elementor() ) {
			$content  = woodmart_elementor_get_content_css( $id );
			$content .= woodmart_elementor_get_content( $id );
		} else {
			$shortcodes_custom_css          = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
			$woodmart_shortcodes_custom_css = get_post_meta( $id, 'woodmart_shortcodes_custom_css', true );

			$content = '<style data-type="vc_shortcodes-custom-css">';
			if ( ! empty( $shortcodes_custom_css ) ) {
				$content .= $shortcodes_custom_css;
			}

			if ( ! empty( $woodmart_shortcodes_custom_css ) ) {
				$content .= $woodmart_shortcodes_custom_css;
			}
			$content .= '</style>';

			$content .= do_shortcode( apply_filters( 'the_content',
				$post->post_content ) );
		}

		echo $content; // phpcs:ignore
	}
}

