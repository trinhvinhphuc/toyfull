<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 *	WPBakery Social buttons element
 * ------------------------------------------------------------------------------------------------
 */

if( ! class_exists( 'WOODMART_HB_Social' ) ) {
	class WOODMART_HB_Social extends WOODMART_HB_Element {

		public function __construct() {

			$this->args = array(
				'text' => esc_html__( 'Social links icons', 'woodmart' ),
				'icon' => WOODMART_ASSETS_IMAGES . '/header-builder/icons/hb-ico-social.svg',
			);

			$this->exclude_list = array(
				'show_label',
				'label_text',
				'layout',
				'css',
				'responsive_spacing',
				'responsive_tabs',
				'width_desktop',
				'custom_width_desktop',
				'width_tablet',
				'custom_width_tablet',
				'width_mobile',
				'custom_width_mobile',
			);

			$this->vc_element = 'social_buttons';
			parent::__construct();
			$this->template_name = 'social';
		}

		public function map() {}

	}
}
