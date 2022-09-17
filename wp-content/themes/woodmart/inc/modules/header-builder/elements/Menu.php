<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 *	Secondary menu element
 * ------------------------------------------------------------------------------------------------
 */

if( ! class_exists( 'WOODMART_HB_Menu' ) ) {
	class WOODMART_HB_Menu extends WOODMART_HB_Element {

		public function __construct() {
			parent::__construct();
			$this->template_name = 'menu';
		}

		public function map() {
			$this->args = array(
				'type' => 'menu',
				'title' => esc_html__( 'Menu', 'woodmart' ),
				'text' => esc_html__( 'Secondary menu', 'woodmart' ),
				'icon' => WOODMART_ASSETS_IMAGES . '/header-builder/icons/hb-ico-menu.svg',
				'editable' => true,
				'container' => false,
				'drg' => false,
				'drag_target_for' => array(),
				'drag_source' => 'content_element',
				'edit_on_create' => true,
				'removable' => true,
				'addable' => true,
				'params' => array(
					'menu_id' => array(
						'id' => 'menu_id',
						'title' => esc_html__( 'Choose menu', 'woodmart' ),
						'type' => 'select',
						'tab' => esc_html__( 'General', 'woodmart' ),
						'value' => '',
						'callback' => 'get_menu_options',
						'description' => esc_html__( 'Choose which menu to dislay in the header.', 'woodmart' ),
					),
					'menu_style' => array(
						'id' => 'menu_style',
						'title' => esc_html__( 'Style', 'woodmart' ),
						'type' => 'selector',
						'tab' => esc_html__( 'General', 'woodmart' ),
						'value' => 'default',
						'options' => array(
							'default' => array(
								'value' => 'default',
								'label' => esc_html__( 'Default', 'woodmart' ),
							),
							'underline' => array(
								'value' => 'underline',
								'label' => esc_html__( 'Underline', 'woodmart' ),
							),
							'bordered' => array(
								'value' => 'bordered',
								'label' => esc_html__( 'Bordered', 'woodmart' ),
							),
							'separated' => array(
								'value' => 'separated',
								'label' => esc_html__( 'Separated', 'woodmart' ),
							),
						),
						'description' => esc_html__( 'You can change menu style in the header.', 'woodmart' ),
					),
					'menu_align' => array(
						'id' => 'menu_align',
						'title' => esc_html__( 'Menu align', 'woodmart' ),
						'type' => 'selector',
						'tab' => esc_html__( 'General', 'woodmart' ),
						'value' => 'left',
						'options' => array(
							'left' => array(
								'value' => 'left',
								'label' => esc_html__( 'Left', 'woodmart' ),
							),
							'center' => array(
								'value' => 'center',
								'label' => esc_html__( 'Center', 'woodmart' ),
							),
							'right' => array(
								'value' => 'right',
								'label' => esc_html__( 'Right', 'woodmart' ),
							),
						),
						'description' => esc_html__( 'Set the menu items text align.', 'woodmart' ),
					),
					'items_gap' => array(
						'id'    => 'items_gap',
						'title' => esc_html__( 'Items gap', 'woodmart' ),
						'type' => 'selector',
						'tab' => esc_html__( 'General', 'woodmart' ),
						'value' => 's',
						'options' => array(
							's' => array(
								'value' => 's',
								'label' => esc_html__( 'Small', 'woodmart' ),
							),
							'm' => array(
								'value' => 'm',
								'label' => esc_html__( 'Medium', 'woodmart' ),
							),
							'l' => array(
								'value' => 'l',
								'label' => esc_html__( 'Large', 'woodmart' ),
							),
						),
						'description' => esc_html__( 'Set the items gap.', 'woodmart' ),
					),
				)
			);
		}

	}

}
