<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 *	WPBakery Button element
 * ------------------------------------------------------------------------------------------------
 */

if( ! class_exists( 'WOODMART_HB_Infobox' ) ) {
	class WOODMART_HB_Infobox extends WOODMART_HB_Element {

		public function __construct() {

			$this->args = array(
				'text' => esc_html__( 'Text with icon', 'woodmart' ),
				'icon' => WOODMART_ASSETS_IMAGES . '/header-builder/icons/hb-ico-infobox.svg',
			);

			$this->exclude_list = array(
				'wd_animation',
				'wd_animation_delay',
				'wd_animation_duration',
				'wd_z_index',
				'wd_z_index_custom',
				'responsive_tabs_hide',
				'wd_hide_on_desktop',
				'wd_hide_on_tablet',
				'wd_hide_on_mobile',
			);

			$this->vc_element = 'woodmart_info_box';
			parent::__construct();
			$this->template_name = 'info-box';
		}

		public function map() { }
	}
}
