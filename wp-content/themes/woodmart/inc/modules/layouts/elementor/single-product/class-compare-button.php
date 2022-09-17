<?php
/**
 * Compare button map.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Compare_Button extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_single_product_compare_button';
	}

	/**
	 * Get widget content.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Add to compare button', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-add-to-compare-button';
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
				'default'      => 'wd-single-action-btn wd-single-compare-btn',
				'prefix_class' => '',
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
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'text' => array(
						'title' => esc_html__( 'Icon with text', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/icon-style/icon-with-text.jpg',
						'style' => 'col-2',
					),
					'icon' => array(
						'title' => esc_html__( 'Icon only', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/icon-style/only-icon.jpg',
					),
				),
				'default' => 'text',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'     => esc_html__( 'Typography', 'woodmart' ),
				'name'      => 'typography',
				'selector'  => '{{WRAPPER}} .wd-compare-btn > a span',
				'condition' => array(
					'style' => array( 'text' ),
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Icon size', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-compare-btn[class*="wd-style-"] > a:before, {{WRAPPER}} .wd-compare-btn[class*="wd-style-"] > a:after' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->start_controls_tabs( 'color_tabs' );
		$this->start_controls_tab(
			'color_tab',
			array(
				'label' => esc_html__( 'Idle', 'woodmart' ),
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-compare-btn > a span' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'style' => array( 'text' ),
				),
			)
		);
		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-compare-btn > a:before' => 'color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'hover_color_tab',
			array(
				'label' => esc_html__( 'Hover', 'woodmart' ),
			)
		);
		$this->add_control(
			'text_color_hover',
			array(
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-compare-btn > a:hover span' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'style' => array( 'text' ),
				),
			)
		);
		$this->add_control(
			'icon_color_hover',
			array(
				'label'     => esc_html__( 'Icon color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-compare-btn > a:hover:before' => 'color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings = wp_parse_args(
			$this->get_settings_for_display(),
			array(
				'style' => 'text',
			)
		);

		$classes  = 'wd-action-btn wd-compare-icon';
		$classes .= ' wd-style-' . $settings['style'];

		Main::setup_preview();

		if ( 'icon' === $settings['style'] ) {
			woodmart_enqueue_js_library( 'tooltips' );
			woodmart_enqueue_js_script( 'btns-tooltips' );
		}

		woodmart_add_to_compare_btn( $classes );

		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Compare_Button() );
