<?php
/**
 * Global map file.
 *
 * @package xts
 */

use Elementor\Controls_Manager;

if ( ! function_exists( 'woodmart_get_animation_map' ) ) {
	/**
	 * Get animation map
	 *
	 * @since 1.0.0
	 *
	 * @param object $element Element object.
	 * @param array  $condition Element condition. Default empty.
	 */
	function woodmart_get_animation_map( $element, $condition = array() ) {
		$wd_animation = [
			'label'        => esc_html__( 'Animations', 'woodmart' ),
			'description'  => esc_html__( 'Use custom theme animations if you want to run them in the slider element.', 'woodmart' ),
			'type'         => Controls_Manager::SELECT2,
			'label_block'  => true,
			'options'      => [
				''                      => esc_html__( 'None', 'woodmart' ),
				'slide-from-top'        => esc_html__( 'Slide from top', 'woodmart' ),
				'slide-from-bottom'     => esc_html__( 'Slide from bottom', 'woodmart' ),
				'slide-from-left'       => esc_html__( 'Slide from left', 'woodmart' ),
				'slide-from-right'      => esc_html__( 'Slide from right', 'woodmart' ),
				'slide-short-from-left' => esc_html__( 'Slide short from left', 'woodmart' ),
				'bottom-flip-x'         => esc_html__( 'Flip X bottom', 'woodmart' ),
				'top-flip-x'            => esc_html__( 'Flip X top', 'woodmart' ),
				'left-flip-y'           => esc_html__( 'Flip Y left', 'woodmart' ),
				'right-flip-y'          => esc_html__( 'Flip Y right', 'woodmart' ),
				'zoom-in'               => esc_html__( 'Zoom in', 'woodmart' ),
			],
			'default'      => '',
			'render_type'  => 'template',
			'prefix_class' => 'wd-animation-',
		];

		if ( ! empty( $condition ) ) {
			$wd_animation['condition'] = $condition;
		}

		$element->add_control(
			'wd_animation',
			$wd_animation
		);

		$element->add_control(
			'wd_animation_duration',
			[
				'label'        => esc_html__( 'Animation duration', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'normal',
				'options'      => [
					'slow'   => esc_html__( 'Slow', 'woodmart' ),
					'normal' => esc_html__( 'Normal', 'woodmart' ),
					'fast'   => esc_html__( 'Fast', 'woodmart' ),
				],
				'condition'    => array_merge(
					array(
						'wd_animation!' => '',
					),
					$condition
				),
				'render_type'  => 'template',
				'prefix_class' => 'wd-animation-',
			]
		);

		$element->add_control(
			'wd_animation_delay',
			[
				'label'        => esc_html__( 'Animation delay', 'woodmart' ) . ' (ms)',
				'type'         => Controls_Manager::NUMBER,
				'default'      => 100,
				'min'          => 0,
				'step'         => 100,
				'condition'    => array_merge(
					array(
						'wd_animation!' => '',
					),
					$condition
				),
				'render_type'  => 'template',
				'prefix_class' => 'wd_delay_',
			]
		);
	}
}
