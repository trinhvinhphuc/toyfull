<?php
/**
 * 'Order by' element.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use XTS\Modules\Layouts\Global_Data as Builder_Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Orderby extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_shop_archive_orderby';
	}

	/**
	 * Get widget content.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Order by', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sa-order-by';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-shop-archive-elements' );
	}

	/**
	 * Show in panel.
	 *
	 * @return bool Whether to show the widget in the panel or not.
	 */
	public function show_in_panel() {
		return Main::is_layout_type( 'shop_archive' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {
		/**
		 * Style tab
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'style_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-shop-ordering',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default'   => esc_html__( 'Default', 'woodmart' ),
					'underline' => esc_html__( 'Underline', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'mobile_icon',
			array(
				'label'        => esc_html__( 'Icon on mobile', 'woodmart' ),
				'description'  => esc_html__( 'Show an icon button on mobile devices instead of dropdown.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
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
				'style'       => 'default',
				'mobile_icon' => '',
			)
		);

		Main::setup_preview();

		$ordering_classes = ' wd-style-' . $settings['style'];

		if ( ! empty( $settings['mobile_icon'] ) ) {
			$ordering_classes .= ' wd-ordering-mb-icon';
		}

		Builder_Data::get_instance()->set_data( 'builder_ordering_classes', $ordering_classes );

		woodmart_enqueue_inline_style( 'woo-shop-el-order-by' );

		woocommerce_catalog_ordering();

		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Orderby() );
