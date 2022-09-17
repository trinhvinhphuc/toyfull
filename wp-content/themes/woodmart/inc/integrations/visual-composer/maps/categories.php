<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* Categories element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_vc_shortcode_categories' ) ) {
	function woodmart_vc_shortcode_categories() {
		if ( ! shortcode_exists( 'woodmart_categories' ) ) {
			return;
		}

		$order_by_values = array(
			'',
			esc_html__( 'Date', 'woodmart' ) => 'date',
			esc_html__( 'ID', 'woodmart' ) => 'ID',
			esc_html__( 'Title', 'woodmart' ) => 'title',
			esc_html__( 'Modified', 'woodmart' ) => 'modified',
			esc_html__( 'Menu order', 'woodmart' ) => 'menu_order',
			esc_html__( 'As IDs or slugs provided order', 'woodmart' ) => 'include',
		);

		$order_way_values = array(
			esc_html__( 'Inherit', 'woodmart' ) => '',
			esc_html__( 'Descending', 'woodmart' ) => 'DESC',
			esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
		);

		$title_typography = woodmart_get_typography_map(
			array(
				'key'      => 'title_typography',
				'selector' => '{{WRAPPER}} .wd-nav > li > a',
				'group'    => esc_html__( 'Style', 'woodmart' ),
			)
		);

		vc_map(
			array(
				'name'        => esc_html__( 'Product categories', 'woodmart' ),
				'base'        => 'woodmart_categories',
				'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
				'description' => esc_html__( 'Product categories grid', 'woodmart' ),
				'icon'        => WOODMART_ASSETS . '/images/vc-icon/product-categories.svg',
				'params'      => array(
					/**
					* Data settings
					*/
					array(
						'group'      => esc_html__( 'Content', 'woodmart' ),
						'type'       => 'woodmart_css_id',
						'param_name' => 'woodmart_css_id',
					),

					array(
						'title'      => esc_html__( 'General', 'woodmart' ),
						'group'      => esc_html__( 'Content', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'data_divider',
					),

					array(
						'heading'          => esc_html__( 'Data source', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'hint'             => esc_html__( 'Use WooCommerce query when you display this element as a part of the shop page in WoodMart Layouts builder.', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'data_source',
						'value'            => array(
							esc_html__( 'Custom query', 'woodmart' ) => 'custom_query',
							esc_html__( 'WooCommerce query', 'woodmart' ) => 'wc_query',
						),
						'std'              => 'custom_query',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Type', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'type',
						'value'            => array(
							esc_html__( 'Navigation', 'woodmart' ) => 'navigation',
							esc_html__( 'Grid', 'woodmart' ) => 'grid',
						),
						'std'              => 'grid',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Enable images', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'images',
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'yes',
						'dependency'       => array(
							'element' => 'type',
							'value'   => array( 'navigation' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Enable product count', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'product_count',
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'yes',
						'dependency'       => array(
							'element' => 'type',
							'value'   => array( 'navigation' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Mobile accordion', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'mobile_accordion',
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'yes',
						'hint'             => esc_html__( 'Turn categories navigation into accordion on mobile devices', 'woodmart' ),
						'dependency'       => array(
							'element' => 'type',
							'value'   => array( 'navigation' ),
						),
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Show current category ancestors', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'descriptions'     => esc_html__( 'This option works with WooCommerce query Data source only. They are dedicated to the shop page layout.', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'shop_categories_ancestors',
						'hint'             => esc_html__( 'If you visit category Man, for example, only man\'s subcategories will be shown in the page title like T-shirts, Coats, Shoes etc.', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'dependency'       => array(
							'element' => 'type',
							'value'   => array( 'navigation' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Show category neighbors if there is no children', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'descriptions'     => esc_html__( 'This option works with WooCommerce query Data source only. They are dedicated to the shop page layout.', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'show_categories_neighbors',
						'hint'             => esc_html__( 'If the category you visit doesn\'t contain any subcategories, the page title menu will display this category\'s neighbors categories.', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'dependency'       => array(
							'element' => 'type',
							'value'   => array( 'navigation' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Number', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'textfield',
						'param_name'       => 'number',
						'hint'             => esc_html__( 'Enter the number of categories to display for this element.', 'woodmart' ),
						'dependency'       => array(
							'element' => 'data_source',
							'value'   => array( 'custom_query' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					array(
						'heading'          => esc_html__( 'Order by', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'orderby',
						'value'            => $order_by_values,
						'save_always'      => true,
						'hint'             => sprintf( wp_kses(  __( 'Select how to sort retrieved categories. More at %s.', 'woodmart' ), array(
								'a' => array(
									'href'   => array(),
									'target' => array()
								)
							)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						'dependency'       => array(
							'element' => 'data_source',
							'value'   => array( 'custom_query' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Sort order', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'woodmart_button_set',
						'param_name'       => 'order',
						'value'            => $order_way_values,
						'save_always'      => true,
						'hint'             => sprintf( wp_kses(  __( 'Designates the ascending or descending order. More at %s.', 'woodmart' ), array(
								'a' => array(
									'href' => array(),
									'target' => array()
								)
							)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						'dependency'       => array(
							'element' => 'data_source',
							'value'   => array( 'custom_query' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Categories', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'autocomplete',
						'param_name'       => 'ids',
						'settings'         => array(
							'multiple' => true,
							'sortable' => true,
						),
						'save_always'      => true,
						'hint'             => esc_html__( 'List of product categories', 'woodmart' ),
						'dependency'       => array(
							'element' => 'data_source',
							'value'   => array( 'custom_query' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Hide empty', 'woodmart' ),
						'group'            => esc_html__( 'Content', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'hide_empty',
						'hint'             => esc_html__( 'Don’t display categories that don’t have any products assigned.', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'yes',
						'dependency'       => array(
							'element' => 'data_source',
							'value'   => array( 'custom_query' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),

					/**
					 * Design
					 */
					array(
						'title'      => esc_html__( 'Design', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'design_divider',
						'dependency' => array(
							'element' => 'type',
							'value'   => array( 'grid' ),
						),
					),
					array(
						'heading'      => esc_html__( 'Categories design', 'woodmart' ),
						'group'        => esc_html__( 'Style', 'woodmart' ),
						'type'         => 'woodmart_image_select',
						'param_name'   => 'categories_design',
						'value'        => array(
							esc_html__( 'Inherit from Theme Settings', 'woodmart' ) => 'inherit',
							esc_html__( 'Default', 'woodmart' ) => 'default',
							esc_html__( 'Alternative', 'woodmart' ) => 'alt',
							esc_html__( 'Center title', 'woodmart' ) => 'center',
							esc_html__( 'Replace title', 'woodmart' ) => 'replace-title',
							esc_html__( 'Mask with subcategories', 'woodmart' ) => 'mask-subcat',
						),
						'images_value' => array(
							'inherit'       => WOODMART_ASSETS_IMAGES . '/settings/empty.jpg',
							'default'       => WOODMART_ASSETS_IMAGES . '/settings/categories/default.jpg',
							'alt'           => WOODMART_ASSETS_IMAGES . '/settings/categories/alt.jpg',
							'center'        => WOODMART_ASSETS_IMAGES . '/settings/categories/center.jpg',
							'replace-title' => WOODMART_ASSETS_IMAGES . '/settings/categories/replace-title.jpg',
							'mask-subcat'   => WOODMART_ASSETS_IMAGES . '/settings/categories/subcat.jpg',
						),
						'hint'         => esc_html__( 'Overrides option from Theme Settings -> Shop', 'woodmart' ),
						'dependency'   => array(
							'element' => 'type',
							'value'   => array( 'grid' ),
						),
					),
					array(
						'heading'    => esc_html__( 'Image size', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'textfield',
						'param_name' => 'img_size',
						'hint'       => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					),
					array(
						'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'woodmart_dropdown',
						'param_name'       => 'color_scheme',
						'value'            => array(
							esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
							esc_html__( 'Dark', 'woodmart' )  => 'dark',
							esc_html__( 'Light', 'woodmart' ) => 'light',
						),
						'style'            => array(
							'dark' => '#2d2a2a',
						),
						'std'              => '',
						'dependency'       => array(
							'element' => 'categories_design',
							'value'   => array( 'default', 'mask-subcat' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'    => esc_html__( 'Categories with shadow', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_button_set',
						'param_name' => 'categories_with_shadow',
						'value'      => array(
							esc_html__( 'Inherit from Theme Settings', 'woodmart' ) => '',
							esc_html__( 'Enable', 'woodmart' ) => 'enable',
							esc_html__( 'Disable', 'woodmart' ) => 'disable',
						),
						'dependency' => array(
							'element' => 'categories_design',
							'value'   => array( 'alt', 'default' ),
						),
					),

					/**
					 * Design navigation.
					 */
					array(
						'title'      => esc_html__( 'Design', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'nav_design_divider',
						'dependency' => array(
							'element' => 'type',
							'value'   => array( 'navigation' ),
						),
					),

					array(
						'heading'          => esc_html__( 'Alignment', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'wd_select',
						'param_name'       => 'nav_alignment',
						'style'            => 'images',
						'selectors'        => array(),
						'devices'          => array(
							'desktop' => array(
								'value' => 'left',
							),
						),
						'value'            => array(
							esc_html__( 'Left', 'woodmart' )   => 'left',
							esc_html__( 'Center', 'woodmart' ) => 'center',
							esc_html__( 'Right', 'woodmart' )  => 'right',
						),
						'images'           => array(
							'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
							'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
							'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
						),
						'dependency'       => array(
							'element' => 'type',
							'value'   => array( 'navigation' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'woodmart_dropdown',
						'param_name'       => 'nav_color_scheme',
						'value'            => array(
							esc_html__( 'Inherit from Theme Settings', 'woodmart' ) => 'inherit',
							esc_html__( 'Dark', 'woodmart' )  => 'dark',
							esc_html__( 'Light', 'woodmart' ) => 'light',
							esc_html__( 'Custom', 'woodmart' ) => 'custom',
						),
						'dependency'       => array(
							'element' => 'type',
							'value'   => array( 'navigation' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					/**
					 * Title
					 */
					array(
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Title', 'woodmart' ),
						'param_name' => 'title_divider',
						'group'      => esc_html__( 'Style', 'woodmart' ),
					),
					array(
						'type'             => 'wd_colorpicker',
						'heading'          => esc_html__( 'Idle color', 'woodmart' ),
						'param_name'       => 'title_idle_color',
						'selectors'        => array(
							'{{WRAPPER}} .wd-nav[class*=wd-style-] > li > a' => array(
								'color: {{VALUE}};',
							),
						),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'dependency'       => array(
							'element' => 'nav_color_scheme',
							'value'   => array( 'custom' ),
						),
					),
					array(
						'type'             => 'wd_colorpicker',
						'heading'          => esc_html__( 'Hover color', 'woodmart' ),
						'param_name'       => 'title_hover_color',
						'selectors'        => array(
							'{{WRAPPER}} .wd-nav[class*=wd-style-] > li:hover > a' => array(
								'color: {{VALUE}};',
							),
						),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'dependency'       => array(
							'element' => 'nav_color_scheme',
							'value'   => array( 'custom' ),
						),
					),
					$title_typography['font_family'],
					$title_typography['font_size'],
					$title_typography['font_weight'],
					$title_typography['text_transform'],
					$title_typography['font_style'],
					$title_typography['line_height'],

					/**
					* Layout
					*/
					array(
						'title'      => esc_html__( 'Layout', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'layout_divider',
						'holder'     => 'div',
						'dependency' => array(
							'element' => 'type',
							'value'   => array( 'grid' ),
						),
					),
					array(
						'heading'          => esc_html__( 'Layout', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'style',
						'save_always'      => true,
						'hint'             => esc_html__( 'Try out our creative styles for categories block', 'woodmart' ),
						'value'            => array(
							esc_html__( 'Default', 'woodmart' )                   => 'default',
							esc_html__( 'Masonry', 'woodmart' )                   => 'masonry',
							esc_html__( 'Masonry (with first wide)', 'woodmart' ) => 'masonry-first',
							esc_html__( 'Carousel', 'woodmart' )                  => 'carousel',
						),
						'dependency'       => array(
							'element' => 'type',
							'value'   => array( 'grid' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Columns', 'woodmart' ),
						'hint'             => esc_html__( 'Number of columns in the grid.', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'wd_slider',
						'param_name'       => 'columns',
						'devices'          => array(
							'desktop' => array(
								'unit'  => '-',
								'value' => 4,
							),
							'tablet'  => array(
								'unit'  => '-',
								'value' => '',
							),
							'mobile'  => array(
								'unit'  => '-',
								'value' => '',
							),
						),
						'range'            => array(
							'-' => array(
								'min'  => 1,
								'max'  => 6,
								'step' => 1,
							),
						),
						'selectors'        => array(),
						'dependency'       => array(
							'element' => 'style',
							'value'   => array( 'masonry', 'default' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Space between categories', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'dropdown',
						'param_name'       => 'spacing',
						'value'            => array( 30, 20, 10, 6, 2, 0 ),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					/**
					* Carousel
					*/
					array(
						'title'      => esc_html__( 'Carousel', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'holder'     => 'div',
						'param_name' => 'carousel_divider',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( 'carousel' ),
						),
					),
					array(
						'type'             => 'woodmart_button_set',
						'heading'          => esc_html__( 'Slides per view', 'woodmart' ),
						'hint'             => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'param_name'       => 'slides_per_view_tabs',
						'tabs'             => true,
						'value'            => array(
							esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
							esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
							esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
						),
						'dependency'  => array(
							'element' => 'style',
							'value' => array( 'carousel' )
						),
						'default'          => 'desktop',
						'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'slides_per_view',
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'value' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
						),
						'std' => '3',
						'dependency' => array(
							'element' => 'style',
							'value' => array( 'carousel' )
						),
						'wd_dependency'    => array(
							'element' => 'slides_per_view_tabs',
							'value'   => array( 'desktop' ),
						),
						'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'slides_per_view_tablet',
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'value' => array(
							esc_html__( 'Auto', 'woodmart' ) => 'auto',
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
						),
						'std' => 'auto',
						'dependency' => array(
							'element' => 'style',
							'value' => array( 'carousel' )
						),
						'wd_dependency'    => array(
							'element' => 'slides_per_view_tabs',
							'value'   => array( 'tablet' ),
						),
						'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'slides_per_view_mobile',
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'value' => array(
							esc_html__( 'Auto', 'woodmart' ) => 'auto',
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
						),
						'std' => 'auto',
						'dependency' => array(
							'element' => 'style',
							'value' => array( 'carousel' )
						),
						'wd_dependency'    => array(
							'element' => 'slides_per_view_tabs',
							'value'   => array( 'mobile' ),
						),
						'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Hide pagination control', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'hide_pagination_control',
						'hint'             => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'dependency'       => array(
							'element' => 'style',
							'value'   => array( 'carousel' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'hide_prev_next_buttons',
						'hint'             => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'dependency'       => array(
							'element' => 'style',
							'value'   => array( 'carousel' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Slider loop', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'wrap',
						'hint'             => esc_html__( 'Enables loop mode.', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'dependency'       => array(
							'element' => 'style',
							'value'   => array( 'carousel' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'             => 'woodmart_switch',
						'heading'          => esc_html__( 'Slider autoplay', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'param_name'       => 'autoplay',
						'hint'             => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'dependency'       => array(
							'element' => 'view',
							'value'   => array( 'carousel' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					/**
					* Extra
					*/
					array(
						'title'      => esc_html__( 'Extra options', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'woodmart_title_divider',
						'param_name' => 'extra_divider',
					),
					array(
						'heading'          => esc_html__( 'Lazy loading for images', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'lazy_loading',
						'hint'             => esc_html__( 'Enable lazy loading for images for this element.', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'heading'          => esc_html__( 'Init carousel on scroll', 'woodmart' ),
						'group'            => esc_html__( 'Style', 'woodmart' ),
						'type'             => 'woodmart_switch',
						'param_name'       => 'scroll_carousel_init',
						'hint'             => esc_html__( 'This option allows you to init carousel script only when visitor scroll the page to the slider. Useful for performance optimization.', 'woodmart' ),
						'true_state'       => 'yes',
						'false_state'      => 'no',
						'default'          => 'no',
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'dependency'       => array(
							'element' => 'style',
							'value'   => array( 'carousel' ),
						),
					),
					array(
						'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
						'group'      => esc_html__( 'Style', 'woodmart' ),
						'type'       => 'textfield',
						'param_name' => 'el_class',
						'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
					),
					array(
						'heading'    => esc_html__( 'CSS box', 'woodmart' ),
						'group'      => esc_html__( 'Design Options', 'js_composer' ),
						'type'       => 'css_editor',
						'param_name' => 'css',
					),
					woodmart_get_vc_responsive_spacing_map(),

					// Width option (with dependency Columns option, responsive).
					woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
					woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
					woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
					woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
					woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
					woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
					woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),
				)
			)
		);
	}
	add_action( 'vc_before_init', 'woodmart_vc_shortcode_categories' );
}

//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_woodmart_categories_ids_callback', 'woodmart_productCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_woodmart_categories_ids_render', 'woodmart_productCategoryCategoryRenderByIdExact', 10, 1 );

if( ! function_exists( 'woodmart_productCategoryCategoryAutocompleteSuggester' ) ) {
	function woodmart_productCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
		global $wpdb;
		$cat_id = (int) $query;
		$query = trim( $query );
		$post_meta_infos = $wpdb->get_results(
			$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
				$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = esc_html__( 'Id', 'woodmart' ) . ': ' .
				                 $value['id'] .
				                 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'woodmart' ) . ': ' .
				                                                      $value['name'] : '' ) .
				                 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'woodmart' ) . ': ' .
				                                                      $value['slug'] : '' );
				$result[] = $data;
			}
		}

		return $result;
	}
}
if( ! function_exists( 'woodmart_productCategoryCategoryRenderByIdExact' ) ) {
	function woodmart_productCategoryCategoryRenderByIdExact( $query ) {
		global $wpdb;
		$query = $query['value'];
		$cat_id = (int) $query;
		$term = get_term( $cat_id, 'product_cat' );

		return woodmart_productCategoryTermOutput( $term );
	}
}

if( ! function_exists( 'woodmart_productCategoryTermOutput' ) ) {
	function woodmart_productCategoryTermOutput( $term ) {
		if ( !$term || !is_object( $term ) ) {
			return false;
		}

		$term_slug = $term->slug;
		$term_title = $term->name;
		$term_id = $term->term_id;

		$term_slug_display = '';
		if ( ! empty( $term_slug ) ) {
			$term_slug_display = ' - ' . esc_html__( 'Slug', 'woodmart' ) . ': ' . $term_slug;
		}

		$term_title_display = '';
		if ( ! empty( $term_title ) ) {
			$term_title_display = ' - ' . esc_html__( 'Name', 'woodmart' ) . ': ' . $term_title;
		}

		$term_id_display = esc_html__( 'Id', 'woodmart' ) . ': ' . $term_id;

		$data = array();
		$data['value'] = $term_id;
		$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

		return ! empty( $data ) ? $data : false;
	}
}
