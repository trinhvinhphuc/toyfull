<?php
/**
 * Accordion map.
 *
 * @package Woodmart.
 */

namespace XTS\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

/**
 * Elementor widget that adds accordion.
 */
class Accordion extends Widget_Base {
	/***
	 * This method return a widget name that will be used in the code.
	 *
	 * @return string widget name.
	 */
	public function get_name() {
		return 'wd_accordion';
	}

	/***
	 * This method return the widget title that will be displayed as the widget label.
	 *
	 * @return string widget title.
	 */
	public function get_title() {
		return esc_html__( 'Accordion', 'woodmart' );
	}

	/***
	 * This method set the widget icon.
	 *
	 * @return string widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-accordion';
	}

	/***
	 * This method lets you set the category of the widget.
	 *
	 * @return array the category name.
	 */
	public function get_categories() {
		return array( 'wd-elements' );
	}

	/**
	 * This method lets you define which controls (setting fields) your widget will have.
	 */
	protected function register_controls() {
		/**
		 * Content tab
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'accordion_items' );

		$repeater->start_controls_tab(
			'content_tab',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater->add_control(
			'item_title',
			array(
				'label'   => esc_html__( 'Title', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Accordion title. Click here to edit',
			)
		);

		$repeater->add_control(
			'content_type',
			array(
				'label'       => esc_html__( 'Content type', 'woodmart' ),
				'description' => esc_html__( 'You can display content as a simple text or if you need more complex structure you can create an HTML Block with Elementor builder and place it here.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'text'       => esc_html__( 'Text', 'woodmart' ),
					'html_block' => esc_html__( 'HTML Block', 'woodmart' ),
				),
				'default'     => 'text',
			)
		);

		$repeater->add_control(
			'item_content',
			array(
				'label'     => esc_html__( 'Content', 'woodmart' ),
				'type'      => Controls_Manager::WYSIWYG,
				'default'   => '<i>Click here to change this text</i>. Ac non ac hac ullamcorper rhoncus velit maecenas convallis torquent elit accumsan eu est pulvinar pretium congue a vestibulum suspendisse scelerisque condimentum parturient quam.Aliquet faucibus condimentum amet nam a nascetur suspendisse habitant a mollis senectus suscipit a vestibulum primis molestie parturient aptent nisi aenean.A scelerisque quam consectetur condimentum risus lobortis cum dignissim mi fusce primis rhoncus a rhoncus bibendum parturient condimentum odio a justo a et mollis pulvinar venenatis metus sodales elementum.Parturient ullamcorper natoque mi sagittis a nibh nisi a suspendisse a.',
				'condition' => array(
					'content_type' => array( 'text' ),
				),
			)
		);

		$repeater->add_control(
			'html_block_id',
			array(
				'label'     => esc_html__( 'HTML Block', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => woodmart_get_elementor_html_blocks_array(),
				'default'   => '0',
				'condition' => array(
					'content_type' => array( 'html_block' ),
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'icon_tab',
			array(
				'label' => esc_html__( 'Icon', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater->add_control(
			'icon_type',
			array(
				'label'   => esc_html__( 'Icon type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'icon'  => esc_html__( 'With icon', 'woodmart' ),
					'image' => esc_html__( 'With image', 'woodmart' ),
				),
				'default' => 'icon',
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label'     => esc_html__( 'Icon', 'woodmart' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => array(
					'icon_type' => array( 'icon' ),
				),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Image', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'icon_type' => array( 'image' ),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'separator' => 'none',
				'default'   => 'thumbnail',
				'condition' => array(
					'icon_type' => array( 'image' ),
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'items',
			array(
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ item_title }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_title'   => 'Accordion title',
						'item_content' => 'Ac non ac hac ullamcorper rhoncus velit maecenas convallis torquent elit accumsan eu est pulvinar pretium congue a vestibulum suspendisse scelerisque condimentum parturient quam.Aliquet faucibus condimentum amet nam a nascetur suspendisse habitant a mollis senectus suscipit a vestibulum primis molestie parturient aptent nisi aenean.A scelerisque quam consectetur condimentum risus lobortis cum dignissim mi fusce primis rhoncus a rhoncus bibendum parturient condimentum odio a justo a et mollis pulvinar venenatis metus sodales elementum.Parturient ullamcorper natoque mi sagittis a nibh nisi a suspendisse a.',
					),
					array(
						'item_title'   => 'Accordion title',
						'item_content' => 'Ac non ac hac ullamcorper rhoncus velit maecenas convallis torquent elit accumsan eu est pulvinar pretium congue a vestibulum suspendisse scelerisque condimentum parturient quam.Aliquet faucibus condimentum amet nam a nascetur suspendisse habitant a mollis senectus suscipit a vestibulum primis molestie parturient aptent nisi aenean.A scelerisque quam consectetur condimentum risus lobortis cum dignissim mi fusce primis rhoncus a rhoncus bibendum parturient condimentum odio a justo a et mollis pulvinar venenatis metus sodales elementum.Parturient ullamcorper natoque mi sagittis a nibh nisi a suspendisse a.',
					),
					array(
						'item_title'   => 'Accordion title',
						'item_content' => 'Ac non ac hac ullamcorper rhoncus velit maecenas convallis torquent elit accumsan eu est pulvinar pretium congue a vestibulum suspendisse scelerisque condimentum parturient quam.Aliquet faucibus condimentum amet nam a nascetur suspendisse habitant a mollis senectus suscipit a vestibulum primis molestie parturient aptent nisi aenean.A scelerisque quam consectetur condimentum risus lobortis cum dignissim mi fusce primis rhoncus a rhoncus bibendum parturient condimentum odio a justo a et mollis pulvinar venenatis metus sodales elementum.Parturient ullamcorper natoque mi sagittis a nibh nisi a suspendisse a.',
					),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style tab
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
			'state',
			array(
				'label'   => esc_html__( 'Items state', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'first'      => esc_html__( 'First opened', 'woodmart' ),
					'all_closed' => esc_html__( 'All closed', 'woodmart' ),
				),
				'default' => 'first',
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'shadow'  => esc_html__( 'Shadow', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'shadow',
				'selector'  => '{{WRAPPER}} .wd-accordion.wd-style-shadow > .wd-accordion-item',
				'condition' => array(
					'style' => array( 'shadow' ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Title settings
		 */
		$this->start_controls_section(
			'title_style_section',
			array(
				'label' => esc_html__( 'Title', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_text_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'style' => 'col-2',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
				),
				'default' => 'left',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-accordion-title-text',
			)
		);

		$this->add_control(
			'title_text_color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'custom'  => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->start_controls_tabs(
			'title_text_color_tabs',
			array(
				'condition' => array(
					'title_text_color_scheme' => 'custom',
				),
			)
		);

		$this->start_controls_tab(
			'title_text_color_tab',
			array(
				'label' => esc_html__( 'Idle', 'woodmart' ),
			)
		);

		$this->add_control(
			'title_text_idle_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-accordion-title-text' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'title_text_color_scheme' => 'custom',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_text_hover_color_tab',
			array(
				'label' => esc_html__( 'Hover', 'woodmart' ),
			)
		);

		$this->add_control(
			'title_text_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-accordion-title:hover .wd-accordion-title-text' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'title_text_color_scheme' => 'custom',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_text_active_color_tab',
			array(
				'label' => esc_html__( 'Active', 'woodmart' ),
			)
		);

		$this->add_control(
			'title_text_active_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-accordion-title.wd-active .wd-accordion-title-text, {{WRAPPER}} .wd-accordion:not(.wd-inited) .wd-accordion-item:first-child .wd-accordion-title-text' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'title_text_color_scheme' => 'custom',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Content settings
		 */
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_custom_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-accordion-content',
			)
		);

		$this->add_control(
			'content_text_color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'custom'  => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->add_control(
			'content_custom_text_color',
			array(
				'label'     => esc_html__( 'Custom color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-accordion-content' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'content_text_color_scheme' => 'custom',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Opener settings.
		 */
		$this->start_controls_section(
			'icon_section',
			array(
				'label' => esc_html__( 'Opener', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'opener_style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'arrow' => esc_html__( 'Arrow', 'woodmart' ),
					'plus'  => esc_html__( 'Plus', 'woodmart' ),
				),
				'default' => 'arrow',
			)
		);

		$this->add_control(
			'opener_alignment',
			array(
				'label'   => esc_html__( 'Position', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/left.png',
						'style' => 'col-2',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/right.png',
					),
				),
				'default' => 'left',
			)
		);
	}

	/***
	 * This method render the code and generate the final HTML on the frontend using PHP.
	 */
	protected function render() {
		$default_settings = array(
			/**
			 * General Settings.
			 */
			'style'                     => 'default',
			'state'                     => 'first',

			/**
			 * Title Settings.
			 */
			'title_text_alignment'      => 'left',

			/**
			 * Content Settings.
			 */
			'content_text_color_scheme' => 'inherit',

			/**
			 * Icon Settings.
			 */
			'opener_alignment'          => 'left',
			'opener_style'              => 'arrow',
		);

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		woodmart_enqueue_js_script( 'accordion-element' );
		woodmart_enqueue_inline_style( 'accordion' );

		$wrapper_classes = ' wd-style-' . $settings['style'];

		$title_classes_wrapper  = ' text-' . $settings['title_text_alignment'];
		$title_classes_wrapper .= ' wd-opener-pos-' . $settings['opener_alignment'];

		$title_classes = '';

		if ( 'inherit' !== $settings['title_text_color_scheme'] && 'custom' !== $settings['title_text_color_scheme'] ) {
			$title_classes .= ' color-scheme-' . $settings['title_text_color_scheme'];
		}

		$opener_classes = ' wd-opener-style-' . $settings['opener_style'];

		$content_classes = '';

		if ( 'inherit' !== $settings['content_text_color_scheme'] && 'custom' !== $settings['content_text_color_scheme'] ) {
			$content_classes .= ' color-scheme-' . $settings['content_text_color_scheme'];
		}
		?>

		<div class="wd-accordion<?php echo esc_attr( $wrapper_classes ); ?>" data-state="<?php echo esc_attr( $settings['state'] ); ?>">
			<?php foreach ( $settings['items'] as $index => $item ) : ?>
				<?php
				$content_setting_key = $this->get_repeater_setting_key( 'item_content', 'items', $index );

				$this->add_inline_editing_attributes( $content_setting_key );

				$loop_title_classes_wrapper   = '';
				$loop_content_classes_wrapper = '';

				if ( 0 === $index && 'first' === $settings['state'] ) {
					$loop_title_classes_wrapper   .= ' wd-active';
					$loop_content_classes_wrapper .= ' wd-active';
				}

				$loop_title_classes_wrapper   .= $title_classes_wrapper;
				$loop_content_classes_wrapper .= $content_classes;

				// Icon settings.

				$image_size = array(
					'width'  => 128,
					'height' => 128,
				);

				if ( isset( $item['image_size'] ) && ! empty( $item['image_size'] ) && 'custom' !== $item['image_size'] ) {
					$image_size = $item['image_size'];
				} elseif ( 'custom' === $item['image_size'] && isset( $item['image_custom_dimension']['width'] ) && ! empty( $item['image_custom_dimension']['width'] ) ) {
					$image_size = $item['image_custom_dimension'];
				}

				$icon_output = '';

				if ( 'image' === $item['icon_type'] && isset( $item['image']['id'] ) && $item['image']['id'] ) {
					$icon_output = woodmart_get_image_html( $item, 'image' );

					if ( woodmart_is_svg( woodmart_get_image_url( $item['image']['id'], 'image', $item ) ) ) {
						$icon_output = woodmart_get_svg_html( $item['image']['id'], $image_size );
					}
				} elseif ( 'icon' === $item['icon_type'] && $item['icon'] ) {
					$icon_output = woodmart_elementor_get_render_icon( $item['icon'] );
				}
				?>

				<div class="wd-accordion-item">
					<div class="wd-accordion-title<?php echo esc_attr( $loop_title_classes_wrapper ); ?>" data-accordion-index="<?php echo esc_attr( $index ); ?>">
						<div class="wd-accordion-title-text<?php echo esc_attr( $title_classes ); ?>">
							<?php if ( ! empty( $icon_output ) ) : ?>
								<div class="img-wrapper">
									<?php echo $icon_output; // phpcs:ignore ?>
								</div>
							<?php endif; ?>
							<span>
								<?php echo esc_html( $item['item_title'] ); ?>
							</span>
						</div>
						<span class="wd-accordion-opener<?php echo esc_attr( $opener_classes ); ?>"></span>
					</div>

					<div class="wd-accordion-content reset-last-child<?php echo esc_attr( $loop_content_classes_wrapper ); ?>" data-accordion-index="<?php echo esc_attr( $index ); ?>">
						<?php if ( 'html_block' === $item['content_type'] ) : ?>
							<?php echo woodmart_get_html_block( $item['html_block_id'] ); // phpcs:ignore ?>
						<?php elseif ( 'text' === $item['content_type'] ) : ?>
							<?php if ( woodmart_elementor_is_edit_mode() ) : ?>
								<div <?php echo $this->get_render_attribute_string( $content_setting_key ); ?>>
							<?php endif; ?>

							<?php echo do_shortcode( $item['item_content'] ); ?>

							<?php if ( woodmart_elementor_is_edit_mode() ) : ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Accordion() );
