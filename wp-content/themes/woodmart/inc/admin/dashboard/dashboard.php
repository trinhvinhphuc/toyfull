<?php

use XTS\Modules\Patcher\Client;
use XTS\Setup_Wizard;

if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Theme dashbaord
 * ------------------------------------------------------------------------------------------------
 */
if( ! class_exists( 'WOODMART_Dashboard' ) ) {
	class WOODMART_Dashboard {

		public $page_name = 'woodmart_dashboard';

		public $tabs;

		public $current_tab = 'home';

		private $_notices = null;

		public function __construct() {
			$this->tabs = array(
				'home' => esc_html__( 'Dummy content', 'woodmart' ),
				'builder' => esc_html__( 'Header builder', 'woodmart' ),
				'license' => esc_html__( 'Theme license', 'woodmart' ),
			);

			if ( 'done' !== get_option( 'woodmart_setup_status' ) ) {
				$this->tabs['wizard'] = esc_html__( 'Setup wizard', 'woodmart' );
			}

			if ( 'wpb' === woodmart_get_current_page_builder() ) {
				$this->tabs['wpbakery_css'] = esc_html__( 'WPBakery CSS generator', 'woodmart' );
			}

			$this->tabs['patcher'] = esc_html__( 'Patcher', 'woodmart' );

			add_action( 'admin_menu', array( $this, 'menu_page' ) );

			add_action( 'admin_notices', array( $this, 'add_notices' ), 40 );

			$this->_notices = WOODMART_Registry()->notices;
		}
		public function menu_page() {

			if ( ! current_user_can( apply_filters( 'woodmart_dashboard_theme_links_access', 'administrator' ) ) ) {
				return;
			}

			if ( ! woodmart_get_opt( 'dummy_import', '1' ) ) {
				unset( $this->tabs['home'] );
				unset( $this->tabs['additional'] );
			}

			if ( ! woodmart_get_opt( 'white_label_theme_license_tab', '1' ) ) {
				unset( $this->tabs['license'] );
			}

			$theme_name = esc_html__( 'WoodMart', 'woodmart' );
			$logo       = WOODMART_ASSETS . '/images/theme-admin-icon.svg';

			if ( woodmart_get_opt( 'white_label' ) ) {
				if ( woodmart_get_opt( 'white_label_theme_name' ) ) {
					$theme_name = woodmart_get_opt( 'white_label_theme_name' );
				}

				if ( woodmart_get_opt( 'white_label_sidebar_icon_logo' ) ) {
					$image_data = woodmart_get_opt( 'white_label_sidebar_icon_logo' );

					if ( isset( $image_data['url'] ) && $image_data['url'] ) {
						$logo = wp_get_attachment_image_url( $image_data['id'] );
					}
				}
			}

			$addMenuPage = 'add_me' . 'nu_page';
			$addMenuPage(
				$theme_name,
				$theme_name,
				'manage_options',
				$this->page_name,
				array( $this, 'dashboard' ),
				$logo,
				62
			);

			if ( woodmart_get_opt( 'dummy_import', '1' ) ) {
				add_submenu_page(
					$this->page_name,
					esc_html__( 'Dummy content', 'woodmart' ),
					esc_html__( 'Dummy content', 'woodmart' ),
					'edit_posts',
					'admin.php?page=' . $this->page_name . '&tab=home',
					''
				);
			}

			add_submenu_page(
				$this->page_name,
				esc_html__( 'Header builder', 'woodmart' ),
				esc_html__( 'Header builder', 'woodmart' ),
				'edit_posts',
				'admin.php?page=' . $this->page_name . '&tab=builder',
				''
			);

			if ( woodmart_get_opt( 'white_label_theme_license_tab', '1' ) ) {
				add_submenu_page(
					$this->page_name,
					esc_html__( 'Theme license', 'woodmart' ),
					esc_html__( 'Theme license', 'woodmart' ),
					'edit_posts',
					'admin.php?page=' . $this->page_name . '&tab=license',
					''
				);
			}

			if ( 'wpb' === woodmart_get_current_page_builder() ) {
				add_submenu_page(
					$this->page_name,
					esc_html__( 'WPBakery CSS Generator', 'woodmart' ),
					esc_html__( 'WPBakery CSS Generator', 'woodmart' ),
					'edit_posts',
					'admin.php?page=' . $this->page_name . '&tab=wpbakery_css',
					''
				);
			}

			$patcher_count = class_exists( 'XTS\Modules\Patcher\Client' ) ? Client::get_instance()->get_count_pacthes_map() : '';

			add_submenu_page(
				$this->page_name,
				esc_html__( 'Patcher', 'woodmart' ),
				esc_html__( 'Patcher', 'woodmart' ) . $patcher_count,
				'edit_posts',
				'admin.php?page=' . $this->page_name . '&tab=patcher',
				''
			);

			remove_submenu_page($this->page_name, $this->page_name);
		}

		public function get_tabs() {
			return $this->tabs;
		}

		public function get_current_tab() {
			return $this->current_tab;
		}

		public function set_current_tab( $tab ) {
			$this->current_tab = $tab;
		}

		public function dashboard() {
			$tab = 'home';
			if( isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ) {
				$tab = trim( sanitize_text_field( $_GET['tab'] ) );

				if( ! isset( $this->tabs[ $tab ] ) ) $tab = 'home';

				$this->set_current_tab( $tab );
			}

			if ( 'wizard' === $tab ) {
				Setup_Wizard::get_instance()->setup_wizard_template();
			} else {
				$this->show_page( 'tabs/' . $tab );
			}
		}

		public function tab_url( $tab ) {
			if( ! isset( $this->tabs[ $tab ] ) ) $tab = 'home';
			return admin_url( 'admin.php?page=' . $this->page_name . '&tab=' . $tab );
		}

		public function show_page( $name = 'home') {

			$this->show_part( 'header' );
			$this->show_part( $name );
			$this->show_part( 'footer' );

		}

		public function show_part( $name, $data = array() ) {
			include_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/admin/dashboard/views/' . $name . '.php');
		}

		public function get_version() {
			$theme = wp_get_theme();
			$v = $theme->get('Version');
			$v_data = explode('.', $v);
			return $v_data[0].'.'.$v_data[1];
		}

		public function wpb_css_notice() {
			$file = get_option( 'woodmart-generated-wpbcss-file' );
			$theme_version = WOODMART_WPB_CSS_VERSION;

			if ( isset( $file['name'] ) ) {
				$uploads   = wp_upload_dir();
				$file_path = set_url_scheme( $uploads['basedir'] . '/' . $file['name'] );
				$data = file_exists( $file_path ) ? get_file_data( $file_path, array( 'Version' => 'Version' ) ) : array();

				if ( isset( $data['Version'] ) && version_compare( $data['Version'], $theme_version, '<' ) ) {
					$this->_notices->add_msg( 'Your custom WPBakery Custom CSS file is outdated. The current version of the theme is ' . $theme_version . ' so you need to go here and click on "<a href="' . $this->tab_url( 'wpbakery_css' ) . '">Update</a>" button to actualize it.', 'warning', true );
				}
			}
		}

		public function license_notice() {
			if ( ! woodmart_is_license_activated() ) {
				$this->_notices->add_msg( 'Please, activate your purchase code for the WoodMart theme and enable auto updates <a href="' . $this->tab_url( 'license' ) . '">here</a>. <br /> <a target="_blank" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">Where can I get my purchase code?</a>', 'warning', true );
			}
		}

		public function builder_notice() {
			if ( did_action( 'elementor/loaded' ) && defined( 'WPB_VC_VERSION' ) ) {
				$this->_notices->add_msg( 'WARNING! You have both WPBakery and Elementor activated on your website. Our theme works with one builder only so you need to either deactivate WPBakery or Elementor.', 'warning', true );
			}
		}

		public function translation_files_notice() {
			if ( ! get_transient( 'wd_check_translation_files' ) ) {
				$po = glob( WOODMART_THEMEROOT . '/languages/*.po' );
				$mo = glob( WOODMART_THEMEROOT . '/languages/*.mo' );

				$has_files = count( $mo ) > 0 || count( $po ) > 0;

				if ( $has_files ) {
					update_option( 'wd_has_translation_files', 'yes' );
				} else {
					update_option( 'wd_has_translation_files', 'no' );
					set_transient( 'wd_check_translation_files', 'checked', DAY_IN_SECONDS );
				}
			}

			if ( 'yes' === get_option( 'wd_has_translation_files' ) ) {
				$this->_notices->add_msg( 'WARNING! Found translation files in the theme root folder <strong>"woodmart/languages/"</strong>. To avoid deleting these files after the update, you must move them to the folder <strong>"wp-content/languages/themes/"</strong>. If you use Loco Translate, you can move them to that folder in your translations settings.', 'warning', true );
			}
		}

		public function core_notice() {
			if ( defined( 'WOODMART_CORE_PLUGIN_VERSION' ) && version_compare( WOODMART_CORE_VERSION, WOODMART_CORE_PLUGIN_VERSION, '>' ) ) {
				$this->_notices->add_error( '<strong>Woodmart Core</strong> plugin requires an update to make the theme work correctly. To update the core plugin, please, go to <a href="' . esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ) . '" target="_blank"><strong>Appearance -> Install plugins</strong></a> and click on the update button.', true );
			}
		}

		public function add_notices() {
			$this->core_notice();
			$this->license_notice();
			$this->wpb_css_notice();
			$this->builder_notice();
			$this->translation_files_notice();
		}
	}

	$woodmart_dashboard = new WOODMART_Dashboard();
}