<?php
/**
 * Import.
 *
 * @package Woodmart
 */

namespace XTS\Import;

use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import.
 */
class Import extends Singleton {
	/**
	 * Available versions.
	 *
	 * @var array
	 */
	private $version_list = array();

	/**
	 * Constructor.
	 */
	public function init() {
		$this->set_versions_list();

		add_action( 'wp_ajax_woodmart_import_action', array( $this, 'import_action' ) );
	}

	/**
	 * Import action.
	 */
	public function import_action() {
		check_ajax_referer( 'woodmart-import-nonce', 'security' );

		if ( empty( $_GET['version'] ) || empty( $_GET['type'] ) ) {
			return;
		}

		$version = sanitize_text_field( wp_unslash( $_GET['version'] ) );
		$type    = sanitize_text_field( wp_unslash( $_GET['type'] ) );
		$process = sanitize_text_field( wp_unslash( $_GET['process'] ) );

		new Process( $version, $process );

		wp_send_json(
			array(
				'preview_url' => $this->get_preview_url( $version, $type ),
				'remove_html' => Remove::get_instance()->popup_content( true, 'import' ),
			)
		);
	}

	/**
	 * Interface.
	 */
	public function interface() {
		wp_enqueue_script( 'wd-import', WOODMART_ASSETS . '/js/import.js', array(), WOODMART_VERSION, true );

		$wrapper_classes = '';
		$items_classes   = '';

		if ( $this->is_imported( 'base' ) ) {
			$wrapper_classes .= ' wd-base-imported';
		}
		if ( Remove::get_instance()->has_data_to_remove() ) {
			$wrapper_classes .= ' wd-has-data';
		}
		if ( $this->get_required_plugins() || ( defined( 'ELEMENTOR_VERSION' ) && defined( 'WPB_PLUGIN_DIR' ) ) ) {
			$items_classes .= ' xts-disabled';
		}

		$version = woodmart_get_theme_info( 'Version' );

		wp_enqueue_script( 'wd-helpers', WOODMART_SCRIPTS . '/scripts/global/helpers.min.js', array(), $version, true );
		wp_enqueue_script( 'wd-lazy-load', WOODMART_SCRIPTS . '/scripts/global/lazyLoading.min.js', array(), $version, true );
		wp_enqueue_style( 'wd-lazy-load', WOODMART_STYLES . '/parts/opt-lazy-load.min.css', array(), $version );

		?>
		<script>
			var woodmart_settings = {
				product_gallery    : {
					thumbs_slider: {
						position: true
					}
				},
				lazy_loading_offset: 0
			};
		</script>
		<div class="wd-box wd-box-stretch wd-import xts-dashboard<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="woodmart-box-header">
				<div class="woodmart-box-header-col-left">
					<?php if ( ! isset( $_GET['tab'] ) || ( isset( $_GET['tab'] ) && 'wizard' !== $_GET['tab'] ) ) : // phpcs:ignore ?>
						<div class="wd-import-cats xts-btns-set">
							<div class="wd-import-cats-item xts-set-item xts-set-btn xts-active" data-type="version">
								<?php esc_html_e( 'Demo versions', 'woodmart' ); ?>
							</div>

							<div class="wd-import-cats-item xts-set-item xts-set-btn" data-type="page">
								<?php esc_html_e( 'Additional pages', 'woodmart' ); ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="wd-import-search wd-search">
						<input type="text" placeholder="<?php echo esc_attr__( 'Search by name', 'woodmart' ); ?>" aria-label="<?php echo esc_attr__( 'Search by name', 'woodmart' ); ?>">
					</div>
				</div>

				<?php if ( ! isset( $_GET['tab'] ) || ( isset( $_GET['tab'] ) && 'wizard' !== $_GET['tab'] ) ) : // phpcs:ignore ?>
					<?php Remove::get_instance()->interface(); ?>
				<?php endif; ?>
			</div>
			<div class="woodmart-box-content">

				<div class="xts-import-notices"><?php $this->print_notices(); // Must be in one line. ?></div>

				<div class="wd-import-items<?php echo esc_attr( $items_classes ); ?>">
					<?php foreach ( $this->version_list as $slug => $version_data ) : ?>
						<?php
						$item_classes        = '';
						$type                = $version_data['type'];
						$tags                = isset( $version_data['tags'] ) ? $version_data['tags'] : '';
						$is_version_imported = $this->is_imported( $slug );

						if ( 'version' === $type ) {
							$item_classes .= ' wd-active';
						}
						if ( $is_version_imported ) {
							$item_classes .= ' wd-imported';
						}

						?>
						<div class="wd-import-item<?php echo esc_attr( $item_classes ); ?>" data-version="<?php echo esc_attr( $slug ); ?>" data-type="<?php echo esc_attr( $type ); ?>" data-tags="<?php echo esc_attr( $tags ); ?>">
							<div class="wd-import-item-image-wrap">
								<div class="wd-import-item-image">
									<img data-wood-src="<?php echo esc_url( WOODMART_DUMMY_URL . $slug . '/preview.jpg' ); ?>" src="<?php echo esc_url( woodmart_lazy_get_default_preview() ); ?>" class="wd-lazy-load wd-lazy-fade" alt="<?php echo esc_attr__( 'Import preview', 'woodmart' ); ?>">
								</div>

								<div class="woodmart-box-labels">
									<?php if ( 'main' === $slug ) : ?>
										<div class="woodmart-box-label woodmart-label-default">
											<?php echo esc_attr__( 'Default', 'woodmart' ); ?>
										</div>
									<?php endif; ?>

									<div class="woodmart-box-label woodmart-label-warning">
										<?php echo esc_attr__( 'Imported', 'woodmart' ); ?>
									</div>
								</div>

								<a href="<?php echo esc_url( $this->get_demo_preview_url( $slug, $version_data ) ); ?>" class="xts-bordered-btn xts-color-white wd-import-item-preview" target="_blank">
									<?php esc_html_e( 'Live preview', 'woodmart' ); ?>
								</a>

								<div class="wd-import-progress-bar" data-progress="0"></div>
								<div class="wd-import-progress-bar-percent">0%</div>

							</div>

							<footer class="wd-import-item-footer">
								<span class="wd-import-item-title">
									<?php echo esc_html( $version_data['title'] ); ?>
								</span>

								<a href="#" class="wd-import-item-btn xts-btn xts-color-alt">
									<?php esc_html_e( 'Activate', 'woodmart' ); ?>
								</a>
								<a href="#" class="wd-import-item-btn xts-btn xts-color-primary">
									<?php esc_html_e( 'Import', 'woodmart' ); ?>
								</a>
								<a href="<?php echo esc_url( $this->get_preview_url( $slug, $type ) ); ?>" target="_blank" class="wd-view-item-btn xts-btn xts-color-alt">
									<?php esc_html_e( 'View page', 'woodmart' ); ?>
								</a>
							</footer>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="woodmart-box-footer">
				<p>
					<?php esc_html_e( 'Import any of the demo versions that will include a home page, a few products, posts, projects, images and menus. You will be able to switch to any demo at any time. You can also remove all the previously imported dummy content.', 'woodmart' ); ?>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Print notices.
	 */
	private function print_notices() {
		if ( $this->get_required_plugins() ) {
			$this->print_notice( 'warning', sprintf( __( 'You need to install the following plugins to use our import function: <strong><a href="%1$s">%2$s</a></strong>', 'woodmart' ), esc_url( add_query_arg( 'page', rawurlencode( 'tgmpa-install-plugins' ), self_admin_url( 'themes.php' ) ) ), implode( ', ', $this->get_required_plugins() ) ) );
		}

		if ( defined( 'ELEMENTOR_VERSION' ) && defined( 'WPB_PLUGIN_DIR' ) ) {
			$this->print_notice( 'warning', __( 'Please, deactivate one of the builders and leave only ONE plugin either <strong>WPBakery page builder</strong> or <strong>Elementor</strong>.', 'woodmart' ) );
		}
	}

	/**
	 * Get required plugins.
	 */
	private function get_required_plugins() {
		$plugins = array();

		if ( ! class_exists( 'RevSliderSlider' ) ) {
			$plugins[] = 'Slider Revolution';
		}

		if ( ! class_exists( 'WOODMART_Post_Types' ) ) {
			$plugins[] = 'Woodmart Core';
		}

		if ( ! function_exists( 'is_shop' ) ) {
			$plugins[] = 'Woocommerce';
		}

		if ( ! defined( 'ELEMENTOR_VERSION' ) && ! defined( 'WPB_PLUGIN_DIR' ) ) {
			$plugins[] = 'Elementor';
		}

		return $plugins;
	}

	/**
	 * Print notice.
	 *
	 * @param string $type    Type.
	 * @param string $message Message.
	 */
	private function print_notice( $type, $message ) {
		?>
		<div class="xts-notice xts-<?php echo esc_attr( $type ); ?>">
			<?php echo wp_kses( $message, woodmart_get_allowed_html() ); ?>
		</div>
		<?php
	}

	/**
	 * Is version imported.
	 *
	 * @param string $slug Slug.
	 *
	 * @return bool
	 */
	public function is_imported( $slug ) {
		return in_array( $slug, get_option( 'wd_import_imported_versions', array() ), true );
	}

	/**
	 * Get demo preview URL.
	 *
	 * @param string $slug         Slug.
	 * @param array  $version_data Data.
	 *
	 * @return string
	 */
	private function get_demo_preview_url( $slug, $version_data ) {
		$url = WOODMART_DEMO_URL . $slug . '/';

		if ( 'version' === $version_data['type'] ) {
			$url = WOODMART_DEMO_URL . 'demo-' . $slug . '/demo/' . $slug . '/';
		}

		if ( isset( $version_data['link'] ) ) {
			$url = $version_data['link'];
		}

		return $url;
	}

	/**
	 * Get preview URL.
	 *
	 * @param string $slug Slug.
	 * @param string $type Type.
	 *
	 * @return string
	 */
	private function get_preview_url( $slug, $type ) {
		$page = 'version' === $type ? get_page_by_title( 'Home ' . $slug ) : get_page_by_path( $slug, OBJECT, array( 'page' ) );

		if ( ! $page ) {
			$page = get_page_by_title( str_replace( '-', ' ', $slug ) );
		}

		if ( ! $page ) {
			return '';
		}

		return get_permalink( $page->ID );
	}

	/**
	 * Set versions list.
	 */
	private function set_versions_list() {
		$this->version_list = woodmart_get_config( 'versions' );

		unset( $this->version_list['base'] );

		if ( 'elementor' === woodmart_get_current_page_builder() ) {
			foreach ( $this->version_list as $key => $value ) {
				if ( isset( $value['elementor'] ) && ! $value['elementor'] ) {
					unset( $this->version_list[ $key ] );
				}
			}
		}
	}
}

Import::get_instance();
