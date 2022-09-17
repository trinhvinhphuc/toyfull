<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Options;

Options::add_field(
	array(
		'id'          => 'page-title-design',
		'name'        => esc_html__( 'Page title design', 'woodmart' ),
		'description' => esc_html__( 'Select page title section design or disable it completely on all pages.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'page_title_section',
		'options'     => array(
			'default'  => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/page-heading/default.jpg',
			),
			'centered' => array(
				'name'  => esc_html__( 'Centered', 'woodmart' ),
				'value' => 'centered',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/page-heading/centered.jpg',
			),
			'disable'  => array(
				'name'  => esc_html__( 'Disable', 'woodmart' ),
				'value' => 'disable',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/page-heading/disable.jpg',
			),
		),
		'default'     => 'centered',
		'tags'        => 'page heading title design',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'page-title-size',
		'name'        => esc_html__( 'Page title size', 'woodmart' ),
		'description' => esc_html__( 'You can set different sizes for your page titles.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'page_title_section',
		'options'     => array(
			'default' => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
			),
			'small'   => array(
				'name'  => esc_html__( 'Small', 'woodmart' ),
				'value' => 'small',
			),
			'large'   => array(
				'name'  => esc_html__( 'Large', 'woodmart' ),
				'value' => 'large',
			),
		),
		'default'     => 'default',
		'tags'        => 'page heading title size breadcrumbs size',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'title-background',
		'name'        => esc_html__( 'Pages title background', 'woodmart' ),
		'description' => esc_html__( 'Set background image or color, that will be used as a default for all page titles, shop page and blog.', 'woodmart' ),
		'group'       => esc_html__( 'Color and background', 'woodmart' ),
		'type'        => 'background',
		'default'     => array(
			'color'    => '#0a0a0a',
			'position' => 'center center',
			'size'     => 'cover',
		),
		'section'     => 'page_title_section',
		'selector'    => '.page-title-default',
		'tags'        => 'page title color page title background',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'page-title-color',
		'name'        => esc_html__( 'Text color for page title', 'woodmart' ),
		'description' => esc_html__( 'You can set text different color depending on its background. It can be light or dark.', 'woodmart' ),
		'group'       => esc_html__( 'Color and background', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'page_title_section',
		'options'     => array(
			'default' => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
			),
			'light'   => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
			),
			'dark'    => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
			),
		),
		'default'     => 'light',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'page_title_tag',
		'name'        => esc_html__( 'Title tag', 'woodmart' ),
		'description' => esc_html__( 'Choose which HTML tag to use for the page title.', 'woodmart' ),
		'group'       => esc_html__( 'Breadcrumbs & SEO options', 'woodmart' ),
		'type'        => 'select',
		'section'     => 'page_title_section',
		'default'     => 'default',
		'options'     => array(
			'default' => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
			),
			'h1'      => array(
				'name'  => 'h1',
				'value' => 'h1',
			),
			'h2'      => array(
				'name'  => 'h2',
				'value' => 'h2',
			),
			'h3'      => array(
				'name'  => 'h3',
				'value' => 'h3',
			),
			'h4'      => array(
				'name'  => 'h4',
				'value' => 'h4',
			),
			'h5'      => array(
				'name'  => 'h5',
				'value' => 'h5',
			),
			'h6'      => array(
				'name'  => 'h6',
				'value' => 'h6',
			),
			'p'       => array(
				'name'  => 'p',
				'value' => 'p',
			),
			'div'     => array(
				'name'  => 'div',
				'value' => 'div',
			),
			'span'    => array(
				'name'  => 'span',
				'value' => 'span',
			),
		),
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'breadcrumbs',
		'section'     => 'page_title_section',
		'name'        => esc_html__( 'Show breadcrumbs', 'woodmart' ),
		'description' => esc_html__( 'Displays a full chain of links to the current page.', 'woodmart' ),
		'group'       => esc_html__( 'Breadcrumbs & SEO options', 'woodmart' ),
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'type'        => 'switcher',
		'default'     => '1',
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'yoast_shop_breadcrumbs',
		'section'     => 'page_title_section',
		'name'        => esc_html__( 'Yoast breadcrumbs for shop', 'woodmart' ),
		'description' => esc_html__( 'Requires Yoast SEO plugin to be installed. Replaces standard WooCommerce breadcrumbs with the custom one that comes with the plugin. You need to enable and configure it in Dashboard -> SEO -> Search Appearance -> Breadcrumbs.', 'woodmart' ),
		'group'       => esc_html__( 'Breadcrumbs & SEO options', 'woodmart' ),
		'type'        => 'switcher',
		'default'     => false,
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'yoast_pages_breadcrumbs',
		'section'     => 'page_title_section',
		'name'        => esc_html__( 'Yoast breadcrumbs for pages', 'woodmart' ),
		'description' => esc_html__( 'Requires Yoast SEO plugin to be installed. Replaces standard breadcrumbs with the custom one that comes with the plugin. You need to enable and configure it in Dashboard -> SEO -> Search Appearance -> Breadcrumbs.', 'woodmart' ),
		'group'       => esc_html__( 'Breadcrumbs & SEO options', 'woodmart' ),
		'type'        => 'switcher',
		'default'     => false,
		'priority'    => 80,
	)
);
