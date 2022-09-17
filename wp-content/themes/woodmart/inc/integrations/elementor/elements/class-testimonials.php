<?php
/**
 * Testimonials map.
 *
 * @package woodmart
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
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
class Testimonials extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_testimonials';
	}

	/**
	 * Get widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Testimonials', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-testimonials';
	}

	/**
	 * Get widget categories.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'wd-elements' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * @since  1.0.0
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
			[
				'label' => esc_html__( 'General', 'woodmart' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose image', 'woodmart' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'name',
			[
				'label'   => esc_html__( 'Name', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Eric Watson',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Web Developer',
			]
		);

		$repeater->add_control(
			'content',
			[
				'label' => esc_html__( 'Text', 'woodmart' ),
				'type'  => Controls_Manager::WYSIWYG,
			]
		);

		$this->add_control(
			'items_repeater',
			[
				'type'        => Controls_Manager::REPEATER,
				'label'       => esc_html__( 'Items', 'woodmart' ),
				'separator'   => 'before',
				'title_field' => '{{{ name }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'   => 'Environmental Economist',
						'name'    => 'Kingsley Chandler',
						'content' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.',
					],
					[
						'title'   => 'Healthcare Social Worker',
						'name'    => 'Orson Lancaster',
						'content' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.',
					],
					[
						'title'   => 'Logistician',
						'name'    => 'Harleigh Dodson',
						'content' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.',
					],
					[
						'title'   => 'Floor Refinisher',
						'name'    => 'Darin Coulson',
						'content' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.',
					],
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_style_section',
			[
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'woodmart_color_scheme',
			[
				'label'   => esc_html__( 'Color Scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'standard' => esc_html__( 'Standard', 'woodmart' ),
					'boxed'    => esc_html__( 'Boxed', 'woodmart' ),
					'info-top' => esc_html__( 'Information top', 'woodmart' ),
				],
				'default' => 'standard',
			]
		);

		$this->add_control(
			'text_color_normal',
			[
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wd-testimon .wd-testimon-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_background_color_normal',
			[
				'label'     => esc_html__( 'Text background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wd-testimon .wd-testimon-text'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .wd-testimon .wd-testimon-text:before' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_size',
			[
				'label'   => esc_html__( 'Text size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''       => esc_html__( 'Default', 'woodmart' ),
					'small'  => esc_html__( 'Small (14px)', 'woodmart' ),
					'medium' => esc_html__( 'Medium (16px)', 'woodmart' ),
					'large'  => esc_html__( 'Large (18px)', 'woodmart' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'align',
			[
				'label'     => esc_html__( 'Align', 'woodmart' ),
				'type'      => 'wd_buttons',
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					],
				],
				'condition' => [
					'style!' => 'info-top',
				],
				'default'   => 'center',
			]
		);

		$this->add_control(
			'stars_rating',
			[
				'label'        => esc_html__( 'Display stars rating', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Layout settings.
		 */
		$this->start_controls_section(
			'layout_style_section',
			[
				'label' => esc_html__( 'Layout', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'slider' => esc_html__( 'Slider', 'woodmart' ),
					'grid'   => esc_html__( 'Grid', 'woodmart' ),
				],
				'default' => 'slider',
			]
		);

		$this->add_control(
			'columns',
			[
				'label'       => esc_html__( 'Columns', 'woodmart' ),
				'description' => esc_html__( 'Number of columns in the grid.', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 3,
				],
				'size_units'  => '',
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
					],
				],
				'condition'   => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'spacing',
			[
				'label'   => esc_html__( 'Space between', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					0  => esc_html__( '0 px', 'woodmart' ),
					2  => esc_html__( '2 px', 'woodmart' ),
					6  => esc_html__( '6 px', 'woodmart' ),
					10 => esc_html__( '10 px', 'woodmart' ),
					20 => esc_html__( '20 px', 'woodmart' ),
					30 => esc_html__( '30 px', 'woodmart' ),
				],
				'default' => 30,
			]
		);

		$this->end_controls_section();

		/**
		 * Carousel settings.
		 */
		$this->start_controls_section(
			'carousel_style_section',
			[
				'label'     => esc_html__( 'Carousel', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'slider',
				],
			]
		);

		$this->add_control(
			'slides_per_view',
			[
				'label'       => esc_html__( 'Slides per view', 'woodmart' ),
				'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 3,
				],
				'size_units'  => '',
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 8,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'scroll_per_page',
			[
				'label'        => esc_html__( 'Scroll per page', 'woodmart' ),
				'description'  => esc_html__( 'Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_pagination_control',
			[
				'label'        => esc_html__( 'Hide pagination control', 'woodmart' ),
				'description'  => esc_html__( 'If "YES" pagination control will be removed.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_prev_next_buttons',
			[
				'label'        => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
				'description'  => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wrap',
			[
				'label'        => esc_html__( 'Slider loop', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Slider autoplay', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => esc_html__( 'Slider speed', 'woodmart' ),
				'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
				'default'     => '5000',
				'type'        => Controls_Manager::NUMBER,
				'condition'   => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$default_settings = [
			'layout'                => 'slider',
			'woodmart_color_scheme' => '',
			'style'                 => 'standard',
			'align'                 => 'center',
			'text_size'             => '',
			'columns'               => [ 'size' => 3 ],
			'spacing'               => 30,
			'name'                  => '',
			'title'                 => '',
			'stars_rating'          => 'yes',
			'custom_sizes'          => apply_filters( 'woodmart_testimonials_shortcode_custom_sizes', false ),
			'items_repeater'        => [],
		];

		$settings                    = wp_parse_args( $this->get_settings_for_display(), array_merge( woodmart_get_owl_atts(), $default_settings ) );
		$settings['columns']         = isset( $settings['columns']['size'] ) ? $settings['columns']['size'] : 3;
		$settings['slides_per_view'] = isset( $settings['slides_per_view']['size'] ) ? $settings['slides_per_view']['size'] : 3;
		$owl_attributes              = '';
		$carousel_id                 = 'carousel-' . wp_rand( 1000, 10000 );

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class' => [
						'testimonials',
						'testimonials-wrapper',
						'testimonials-' . $settings['layout'],
						'testimon-style-' . $settings['style'],
						woodmart_get_new_size_classes( 'testimonials', $settings['text_size'], 'text' ),
						'color-scheme-' . $settings['woodmart_color_scheme'],
					],
					'id'    => [
						$carousel_id,
					],
				],
				'owl'     => [
					'class' => [],
				],
			]
		);

		if ( 'yes' === $settings['stars_rating'] ) {
			woodmart_enqueue_inline_style( 'mod-star-rating' );

			$this->add_render_attribute( 'wrapper', 'class', 'testimon-with-rating' );
		}

		if ( 'info-top' !== $settings['style'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'testimon-align-' . $settings['align'] );
		}

		if ( 'slider' === $settings['layout'] ) {
			woodmart_enqueue_inline_style( 'owl-carousel' );
			$settings['carousel_id'] = $carousel_id;

			$owl_attributes = woodmart_get_owl_attributes( $settings );
			$this->add_render_attribute( 'owl', 'class', 'owl-carousel ' . woodmart_owl_items_per_slide( $settings['slides_per_view'], array(), false, false, $settings['custom_sizes'] ) );

			$this->add_render_attribute( 'wrapper', 'class', 'wd-carousel-container' );
			$this->add_render_attribute( 'wrapper', 'class', 'wd-carousel-spacing-' . $settings['spacing'] );

			if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
				$this->add_render_attribute( 'wrapper', 'class', 'disable-owl-mobile' );
			}
		} else {
			$this->add_render_attribute( 'owl', 'class', 'row' );
			$this->add_render_attribute( 'owl', 'class', 'wd-spacing-' . $settings['spacing'] );
			$this->add_render_attribute( 'owl', 'class', 'wd-columns-' . $settings['columns'] );
		}

		if ( 'info-top' === $settings['style'] ) {
			woodmart_enqueue_inline_style( 'testimonial' );
		} else {
			woodmart_enqueue_inline_style( 'testimonial-old' );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore ?> <?php echo $owl_attributes; // phpcs:ignore ?>>
			<div <?php echo $this->get_render_attribute_string( 'owl' ); // phpcs:ignore ?>>
				<?php foreach ( $settings['items_repeater'] as $item ) : ?>
					<?php
					$image_output = '';

					if ( isset( $item['image']['id'] ) && $item['image']['id'] ) {
						$image_url    = woodmart_get_image_url( $item['image']['id'], 'image', $item );
						$image_output = apply_filters( 'woodmart_image', '<img src="' . esc_url( $image_url ) . '" class="testimonial-avatar-image">' );
					}

					$template_name = 'default.php';

					if ( 'info-top' === $settings['style'] ) {
						$template_name = 'info-top.php';
					}

					woodmart_get_element_template(
						'testimonials',
						[
							'image'        => $image_output,
							'title'        => $item['title'],
							'name'         => $item['name'],
							'content'      => $item['content'],
							'item_classes' => '',
						],
						$template_name
					);
					?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Testimonials() );
