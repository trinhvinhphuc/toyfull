<?php
/**
 * List map.
 *
 * @package Woodmart
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
class Icon_List extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_list';
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
		return esc_html__( 'List', 'woodmart' );
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
		return 'wd-icon-list';
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
		return array( 'wd-elements' );
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
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list_content',
			array(
				'label'   => esc_html__( 'Content', 'woodmart' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Far far away there live the blind live in Bookmarksgrove right.',
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'woodmart' ),
				'description' => esc_html__( 'Enter URL if you want this banner to have a link.', 'woodmart' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$repeater->add_control(
			'item_type',
			array(
				'label'   => esc_html__( 'Icon type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'image'   => esc_html__( 'With image', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Choose image', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'item_type' => array( 'image' ),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'condition' => array(
					'item_type' => array( 'image' ),
				),
			)
		);

		$this->add_control(
			'list_items',
			array(
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ list_content }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'list_content' => 'Far far away, behind the word mountains, far las.',
					),
					array(
						'list_content' => 'Vokalia and Consonantia, there live the blind tex.',
					),
					array(
						'list_content' => 'Separated they live in Bookmarksgrove right attr.',
					),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Icon settings.
		 */
		$this->start_controls_section(
			'icon_content_section',
			array(
				'label' => esc_html__( 'Icon', 'woodmart' ),
			)
		);

		$this->add_control(
			'list_type',
			array(
				'label'   => esc_html__( 'Type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'icon'      => esc_html__( 'With icon', 'woodmart' ),
					'image'     => esc_html__( 'With image', 'woodmart' ),
					'ordered'   => esc_html__( 'Ordered', 'woodmart' ),
					'unordered' => esc_html__( 'Unordered', 'woodmart' ),
					'without'   => esc_html__( 'Without icon', 'woodmart' ),
				),
				'default' => 'icon',
			)
		);

		$this->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Choose image', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'list_type' => array( 'image' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'condition' => array(
					'list_type' => array( 'image' ),
				),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'     => esc_html__( 'Icon', 'woodmart' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'list_type' => array( 'icon' ),
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
			'size',
			array(
				'label'   => esc_html__( 'Predefined size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default'     => esc_html__( 'Default (14px)', 'woodmart' ),
					'medium'      => esc_html__( 'Medium (16px)', 'woodmart' ),
					'large'       => esc_html__( 'Large (18px)', 'woodmart' ),
					'extra-large' => esc_html__( 'Extra Large (22px)', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''       => esc_html__( 'Inherit', 'woodmart' ),
					'light'  => esc_html__( 'Light', 'woodmart' ),
					'dark'   => esc_html__( 'Dark', 'woodmart' ),
					'custom' => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} li' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'color_scheme' => array( 'custom' ),
				),
			)
		);

		$this->add_control(
			'text_color_hover',
			array(
				'label'     => esc_html__( 'Text color hover', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} li:hover' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'color_scheme' => array( 'custom' ),
				),
			)
		);

		$this->add_control(
			'align',
			array(
				'label'   => esc_html__( 'Align', 'woodmart' ),
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
			'list_items_gap',
			array(
				'label'          => esc_html__( 'List items gap', 'woodmart' ),
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
				'size_units'     => array( 'px' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} li:not(:last-child) ' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Icon settings.
		 */
		$this->start_controls_section(
			'icon_style_section',
			array(
				'label'     => esc_html__( 'Icon', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'list_type!' => array( 'without', 'image' ),
				),
			)
		);

		$this->add_control(
			'list_style',
			array(
				'label'     => esc_html__( 'Style', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'rounded' => esc_html__( 'Rounded', 'woodmart' ),
					'square'  => esc_html__( 'Square', 'woodmart' ),
				),
				'default'   => 'default',
				'condition' => array(
					'list_type' => array( 'icon', 'ordered', 'unordered' ),
				),
			)
		);

		$this->add_control(
			'icons_color',
			array(
				'label'     => esc_html__( 'Icons color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2C2C2C',
				'selectors' => array(
					'{{WRAPPER}} .list-icon' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'list_type' => array( 'icon', 'ordered', 'unordered' ),
				),
			)
		);

		$this->add_control(
			'icons_color_hover',
			array(
				'label'     => esc_html__( 'Icons color hover', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} li:hover .list-icon' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'list_type' => array( 'icon', 'ordered', 'unordered' ),
				),
			)
		);

		$this->add_control(
			'icons_bg_color',
			array(
				'label'     => esc_html__( 'Icons background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#EAEAEA',
				'selectors' => array(
					'{{WRAPPER}} .list-icon' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'list_style' => array( 'rounded', 'square' ),
				),
			)
		);

		$this->add_control(
			'icons_bg_color_hover',
			array(
				'label'     => esc_html__( 'Icons background color hover', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} li:hover .list-icon' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'list_style' => array( 'rounded', 'square' ),
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Icon size', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-list .list-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'list_type!' => array( 'image' ),
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
	 * @since  1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$default_settings = array(
			'icon'         => '',
			'image'        => '',

			'color_scheme' => '',
			'size'         => 'default',
			'align'        => 'left',

			'list'         => '',
			'list_type'    => 'icon',
			'list_style'   => 'default',
			'list_items'   => '',
		);

		$settings    = wp_parse_args( $this->get_settings_for_display(), $default_settings );
		$icon_output = '<span class="list-icon"></span>';

		if ( ! $settings['list_items'] ) {
			return;
		}

		$this->add_render_attribute(
			array(
				'list' => array(
					'class' => array(
						'wd-list',
						'color-scheme-' . $settings['color_scheme'],
						woodmart_get_new_size_classes( 'list', $settings['size'], 'text' ),
						'wd-list-type-' . $settings['list_type'],
						'wd-list-style-' . $settings['list_style'],
						'wd-justify-' . $settings['align'],
					),
				),
			)
		);

		if ( 'rounded' === $settings['list_style'] || 'square' === $settings['list_style'] ) {
			$this->add_render_attribute( 'list', 'class', 'wd-list-shape-icon' );
		}

		if ( 'image' === $settings['list_type'] && isset( $settings['image']['id'] ) && $settings['image']['id'] ) {
			$icon_output = woodmart_get_image_html( $settings, 'image' );

			if ( woodmart_is_svg( woodmart_get_image_url( $settings['image']['id'], 'image', $settings ) ) ) {
				if ( 'custom' === $settings['image_size'] && ! empty( $settings['image_custom_dimension'] ) ) {
					$icon_output = woodmart_get_svg_html( $settings['image']['id'], $settings['image_custom_dimension'] );
				} else {
					$icon_output = woodmart_get_svg_html( $settings['image']['id'], $settings['image_size'] );
				}
			}
		} elseif ( 'icon' === $settings['list_type'] && $settings['icon'] ) {
			$icon_output = woodmart_elementor_get_render_icon( $settings['icon'], array( 'class' => 'list-icon' ), 'span' );
		}

		// Icon settings.
		$custom_image_size = isset( $settings['image_custom_dimension']['width'] ) && $settings['image_custom_dimension']['width'] ? $settings['image_custom_dimension'] : array(
			'width'  => 128,
			'height' => 128,
		);

		woodmart_enqueue_inline_style( 'list' );
		?>
		<ul <?php echo $this->get_render_attribute_string( 'list' ); ?>>
			<?php foreach ( $settings['list_items'] as $index => $item ) : ?>
				<?php
				$repeater_label_key = $this->get_repeater_setting_key( 'list_content', 'list_items', $index );
				$this->add_render_attribute(
					array(
						$repeater_label_key => array(
							'class' => array(
								'list-content',
							),
						),
					)
				);

				$this->add_inline_editing_attributes( $repeater_label_key );

				// Link settings.
				$item['link']['class'] = 'wd-fill';
				$item['image_size']    = ! empty( $item['image_size'] ) ? $item['image_size'] : 'thumbnail';
				$link_attrs            = woodmart_get_link_attrs( $item['link'] );
				$item_icon_output      = $icon_output;

				if ( empty( $item['image_custom_dimension']['width'] ) ) {
					$item['image_custom_dimension'] = $custom_image_size;
				}

				if ( 'image' === $item['item_type'] && isset( $item['image']['id'] ) && $item['image']['id'] ) {

					$item_icon_output = woodmart_get_image_html( $item, 'image' );

					if ( woodmart_is_svg( woodmart_get_image_url( $item['image']['id'], 'image', $settings ) ) ) {
						if ( 'custom' === $item['image_size'] && ! empty( $item['image_custom_dimension'] ) ) {
							$item_icon_output = woodmart_get_svg_html( $item['image']['id'], $item['image_custom_dimension'] );
						} else {
							$item_icon_output = woodmart_get_svg_html( $item['image']['id'], $item['image_size'] );
						}
					}
				}
				?>
				<li class="elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
					<?php if ( 'without' !== $settings['list_type'] ) : ?>
						<?php echo ! empty( $item_icon_output ) ? $item_icon_output : $icon_output; ?>
					<?php endif ?>

					<span <?php echo $this->get_render_attribute_string( $repeater_label_key ); ?>>
						<?php echo $item['list_content']; ?>
					</span>

					<?php if ( isset( $item['link']['url'] ) && $item['link']['url'] ) : ?>

						<a <?php echo $link_attrs ?> aria-label="<?php esc_attr_e( 'List item link', 'woodmart' ); ?>"></a>
					<?php endif; ?>
				</li>
			<?php endforeach ?>
		</ul>

		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Icon_List() );
