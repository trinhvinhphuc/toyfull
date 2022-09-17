<?php
/**
 * Gallery map.
 *
 * @package xts
 */

namespace XTS\Modules\Layouts;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Gallery extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_single_product_gallery';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product gallery', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-gallery';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-single-product-elements' );
	}

	/**
	 * Show in panel.
	 *
	 * @return bool Whether to show the widget in the panel or not.
	 */
	public function show_in_panel() {
		return Main::is_layout_type( 'single_product' );
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'zoom', 'wc-single-product' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {

		/**
		 * Content tab.
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-single-gallery elementor-widget-theme-post-content',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'thumbnails_position',
			array(
				'label'       => esc_html__( 'Thumbnails position', 'woodmart' ),
				'description' => esc_html__( 'Set your thumbnails display or leave default set from Theme Settings.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'inherit'              => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'left'                 => esc_html__( 'Left (vertical position)', 'woodmart' ),
					'bottom'               => esc_html__( 'Bottom (horizontal carousel)', 'woodmart' ),
					'bottom_column'        => esc_html__( 'Bottom (1 column)', 'woodmart' ),
					'bottom_grid'          => esc_html__( 'Bottom (2 columns)', 'woodmart' ),
					'carousel_two_columns' => esc_html__( 'Carousel (2 columns)', 'woodmart' ),
					'bottom_combined'      => esc_html__( 'Combined grid', 'woodmart' ),
					'centered'             => esc_html__( 'Centered', 'woodmart' ),
					'without'              => esc_html__( 'Without', 'woodmart' ),
				),
				'default'     => 'inherit',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings = wp_parse_args(
			$this->get_settings_for_display(),
			array(
				'thumbnails_position' => 'left',
			)
		);

		wp_enqueue_script( 'zoom' );

		wp_enqueue_script( 'wc-single-product' );

		Main::setup_preview();

		wc_get_template(
			'single-product/product-image.php',
			array(
				'builder_thumbnails_position' => $settings['thumbnails_position'],
			)
		);

		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Gallery() );
