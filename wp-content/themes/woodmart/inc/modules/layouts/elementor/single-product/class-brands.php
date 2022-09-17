<?php
/**
 * Brands map.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;
use XTS\Modules\Layouts\Global_Data as Builder_Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Brands extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_single_product_brands';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product brands', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-brands';
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
	 * Register the widget controls.
	 */
	protected function register_controls() {
		/**
		 * Content tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_label',
			array(
				'label'        => esc_html__( 'Label', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'On', 'woodmart' ),
				'label_off'    => esc_html__( 'Off', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'label_text',
			array(
				'label'     => esc_html__( 'Label text', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Brands:',
				'condition' => array(
					'show_label' => array( 'yes' ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * General settings.
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
				'default'      => 'wd-single-brands',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'        => esc_html__( 'Layout', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					''        => esc_html__( 'Default', 'woodmart' ),
					'justify' => esc_html__( 'Justify', 'woodmart' ),
					'inline'  => esc_html__( 'Inline', 'woodmart' ),
				),
				'prefix_class' => 'wd-layout-',
				'default'      => '',
				'condition'    => array(
					'show_label' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'        => esc_html__( 'Alignment', 'woodmart' ),
				'type'         => 'wd_buttons',
				'options'      => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
				),
				'prefix_class' => 'text-',
				'default'      => 'left',
				'condition'    => array(
					'layout!' => array( 'justify' ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Title settings.
		 */
		$this->start_controls_section(
			'label_style_section',
			array(
				'label'     => esc_html__( 'Label', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_label' => array( 'yes' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .wd-label',
			)
		);

		$this->add_control(
			'label_text_color',
			array(
				'label'     => esc_html__( 'Label color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Image settings.
		 */
		$this->start_controls_section(
			'image_style_section',
			array(
				'label' => esc_html__( 'Image', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'style',
			array(
				'label'        => esc_html__( 'Style', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					''       => esc_html__( 'Default', 'woodmart' ),
					'shadow' => esc_html__( 'Shadow', 'woodmart' ),
				),
				'prefix_class' => 'wd-style-',
				'default'      => '',
			)
		);

		$this->add_responsive_control(
			'max_width',
			array(
				'label'     => esc_html__( 'Width', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				),
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
				'label_text' => '',
			)
		);

		Builder_Data::get_instance()->set_data( 'builder_label', $settings['label_text'] );

		Main::setup_preview();
		woodmart_product_brand();
		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Brands() );
