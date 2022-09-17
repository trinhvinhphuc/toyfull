<?php
/**
 * Text block map.
 *
 * @package xts
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Text_Block extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_text_block';
	}

	/**
	 * Get widget Text block.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget Text block.
	 */
	public function get_title() {
		return esc_html__( 'Text block', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-text-bock';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-elements' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
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
			)
		);

		$this->add_control(
			'text',
			array(
				'label'   => esc_html__( 'Text', 'woodmart' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_general_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->add_control(
			'text_alignment',
			array(
				'label'   => esc_html__( 'Text alignment', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
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
				'default' => 'left',
			)
		);

		$this->add_responsive_control(
			'width',
			array(
				'label'          => esc_html__( 'Width', 'woodmart' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => 'px',
				),
				'tablet_default' => array(
					'unit' => 'px',
				),
				'mobile_default' => array(
					'unit' => 'px',
				),
				'size_units'     => array( '%', 'px' ),
				'range'          => array(
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} .wd-text-block' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_paragraph_content_section',
			array(
				'label' => esc_html__( 'Paragraph', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'label'    => esc_html__( 'Custom typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-text-block',
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'   => esc_html__( 'Text color', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'title'   => esc_html__( 'Title', 'woodmart' ),
					'primary' => esc_html__( 'Primary', 'woodmart' ),
					'alt'     => esc_html__( 'Alternative', 'woodmart' ),
					'custom'  => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'custom_text_color',
			array(
				'label'     => esc_html__( 'Custom color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-text-block' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'text_color' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$default_settings = array(
			'text_color'        => 'default',
			'text_color_scheme' => '',
			'text_alignment'    => 'left',
			'width'             => '',
		);

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		$this->add_render_attribute(
			array(
				'wrapper' => array(
					'class' => array(
						'wd-text-block reset-last-child',
						'text-' . $settings['text_alignment'],
					),
				),
			)
		);

		if ( 'default' !== $settings['text_color'] && 'custom' !== $settings['text_color'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'color-' . $settings['text_color'] );
		}

		if ( 'inherit' !== $settings['text_color_scheme'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'color-scheme-' . $settings['text_color_scheme'] );
		}

		$this->add_inline_editing_attributes( 'wrapper' );
		$this->add_inline_editing_attributes( 'text' );

		woodmart_enqueue_inline_style( 'text-block' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
			<?php if ( woodmart_elementor_is_edit_mode() ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'text' ); // phpcs:ignore ?>>
			<?php endif; ?>

			<?php echo do_shortcode( shortcode_unautop( $settings['text'] ) ); ?>

			<?php if ( woodmart_elementor_is_edit_mode() ) : ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Text_Block() );
