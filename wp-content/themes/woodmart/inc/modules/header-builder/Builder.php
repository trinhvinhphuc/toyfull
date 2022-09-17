<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Include all required files, define constants
 * ------------------------------------------------------------------------------------------------
 */

if( ! class_exists( 'WOODMART_Header_Builder' ) ) {
	class WOODMART_Header_Builder {

		protected static $_instance = null;

		public $elements = null;
		public $list = null;
		public $factory = null;
		public $manager = null;

		protected function __construct() {
			$this->_define_constants();
			$this->_include_files();
			$this->_init_classes();
		}

		protected function __clone() {}

		static public function get_instance() {

			if( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		private function _define_constants() {
			define('WOODMART_HB_DEFAULT_ID', 'default_header');
			define('WOODMART_HB_DEFAULT_NAME', __('Default header layout', 'woodmart'));
			define('WOODMART_HB_DIR', get_template_directory() . '/inc/modules/header-builder/');
			define('WOODMART_HB_TEMPLATES', get_template_directory() . '/header-elements/');
		}

		private function _include_files() {
			$classes = array(
				'Manager',
				'HeaderFactory',
				'HeadersList',
				'Header',
				'Elements',
				'Styles',
			);

			foreach ( $classes as $class ) {
				require_once WOODMART_HB_DIR . $class . '.php';
			}
		}

		private function _init_classes() {
			$this->elements = new WOODMART_HB_Elements();
			$this->list = new WOODMART_HB_HeadersList();
			$this->factory = new WOODMART_HB_HeaderFactory( $this->elements, $this->list );
			$this->manager = new WOODMART_HB_Manager( $this->factory, $this->list );
		}

	}
}
