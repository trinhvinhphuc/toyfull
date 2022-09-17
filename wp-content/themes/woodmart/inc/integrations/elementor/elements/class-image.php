<?php
/**
 * Image map.
 *
 * @package xts
 */

namespace XTS\Elementor;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Image extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_image_or_svg';
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
		return esc_html__( 'Image or SVG', 'woodmart' );
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
		return 'wd-icon-image-or-svg';
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
			'image',
			array(
				'label'   => esc_html__( 'Choose image', 'woodmart' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'woodmart' ),
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

		$this->add_control(
			'on_click_action',
			array(
				'label'   => esc_html__( 'Click action', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'     => esc_html__( 'None', 'woodmart' ),
					'lightbox' => esc_html__( 'Lightbox', 'woodmart' ),
					'link'     => esc_html__( 'Custom link', 'woodmart' ),
				),
				'default' => 'none',
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'woodmart' ),
				'description' => esc_html__( 'Enter URL if you want this image to have a link.', 'woodmart' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
				'condition'   => array(
					'on_click_action' => array( 'link' ),
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
			'image'           => array(),
			'alignment'       => 'left',
			'on_click_action' => 'none',
			'link'            => array(),
		);
		$settings         = wp_parse_args( $this->get_settings_for_display(), $default_settings );
		$link_attrs       = woodmart_get_link_attrs( $settings['link'] );

		$this->add_render_attribute(
			array(
				'wrapper' => array(
					'class' => array(
						'wd-image',
						'text-' . $settings['alignment'],
					),
				),
			)
		);

		if ( 'lightbox' === $settings['on_click_action'] ) {
			$image_data = wp_get_attachment_image_src( $settings['image']['id'], 'full' );

			woodmart_enqueue_js_library( 'photoswipe-bundle' );
			woodmart_enqueue_inline_style( 'photoswipe' );
			woodmart_enqueue_js_script( 'photoswipe-images' );

			$this->add_render_attribute( 'wrapper', 'class', 'photoswipe-images' );

			$link_attrs = woodmart_get_link_attrs(
				array(
					'url'  => $settings['image']['url'],
					'data' => 'data-width="' . esc_attr( $image_data[1] ) . '" data-height="' . esc_attr( $image_data[2] ) . '" data-elementor-open-lightbox="no"',
				)
			);
		}

		$icon_output = '';

		if ( 'custom' !== $settings['image_size'] ) {
			$image_size = $settings['image_size'];
		} elseif ( ! empty( $settings['image_custom_dimension']['width'] ) ) {
			$image_size = $settings['image_custom_dimension'];
		} else {
			$image_size = array(
				'width'  => 128,
				'height' => 128,
			);
		}

		if ( isset( $settings['image']['id'] ) && $settings['image']['id'] ) {
			$icon_output = woodmart_get_image_html(
				$settings,
				'image'
			);

			if ( woodmart_is_svg( woodmart_get_image_url( $settings['image']['id'], 'image', $settings ) ) ) {
				$icon_output = woodmart_get_svg_html(
					$settings['image']['id'],
					$image_size
				);
			}
		}
		?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
			<?php if ( 'none' !== $settings['on_click_action'] ) : ?>
				<a <?php echo $link_attrs; // phpcs:ignore ?>>
			<?php endif; ?>
					<?php echo $icon_output; // phpcs:ignore  ?>
			<?php if ( 'none' !== $settings['on_click_action'] ) : ?>
				</a>
			<?php endif; ?>
		</div>

		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Image() );
