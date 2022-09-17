<?php
/**
 * Payment methods map.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Payment_Methods extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_checkout_payment_methods';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Payment methods', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-ch-payment-methods';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-checkout-elements' );
	}

	/**
	 * Show in panel.
	 *
	 * @return bool Whether to show the widget in the panel or not.
	 */
	public function show_in_panel() {
		return Main::is_layout_type( 'checkout_form' );
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'wc-checkout', 'wc-add-payment-method' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {

		/**
		 * Style tab.
		 */

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
				'default'      => 'wd-payment-methods',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'button_alignment',
			array(
				'label'        => esc_html__( 'Button alignment', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'left'       => esc_html__( 'Left', 'woodmart' ),
					'center'     => esc_html__( 'Center', 'woodmart' ),
					'right'      => esc_html__( 'Right', 'woodmart' ),
					'full-width' => esc_html__( 'Full width', 'woodmart' ),
				),
				'prefix_class' => 'wd-btn-align-',
				'default'      => 'left',
			)
		);

		$this->end_controls_section();

		/**
		 * Payment description settings.
		 */
		$this->start_controls_section(
			'payment_description_style_section',
			array(
				'label' => esc_html__( 'Payment description', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'payment_description_background-color',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .payment_box' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .payment_box:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'payment_description_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .payment_box' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Terms and conditions settings.
		 */
		$this->start_controls_section(
			'terms_conditions_style_section',
			array(
				'label' => esc_html__( 'Terms and conditions', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'terms_conditions_background_color',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-terms-and-conditions' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			return;
		}

		woocommerce_checkout_payment();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Payment_Methods() );
