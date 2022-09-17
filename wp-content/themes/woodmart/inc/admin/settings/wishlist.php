<?php
/**
 * This is Wishlist options file for Theme settings.
 *
 * @package Woodmart.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options;

Options::add_field(
	array(
		'id'          => 'wishlist',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Wishlist', 'woodmart' ),
		'description' => wp_kses( __( 'Enable wishlist functionality built in with the theme. Read more information in our <a href="https://xtemos.com/docs/woodmart/woodmart-wishlist/">documentation</a>.', 'woodmart' ), 'default' ),
		'section'     => 'wishlist_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'           => 'wishlist_page',
		'type'         => 'select',
		'name'         => esc_html__( 'Wishlist page', 'woodmart' ),
		'description'  => esc_html__( 'Select a page for the wishlist table. It should contain the shortcode: [woodmart_wishlist]', 'woodmart' ),
		'section'      => 'wishlist_section',
		'empty_option' => true,
		'select2'      => true,
		'options'      => '',
		'callback'     => 'woodmart_get_pages_array',
		'default'      => 267,
		'priority'     => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'wishlist_logged',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Only for logged in', 'woodmart' ),
		'description' => esc_html__( 'Disable wishlist for guests customers.', 'woodmart' ),
		'section'     => 'wishlist_section',
		'default'     => '0',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'product_loop_wishlist',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Show button on products in loop', 'woodmart' ),
		'description' => esc_html__( 'Display wishlist product button on all products grids and lists.', 'woodmart' ),
		'section'     => 'wishlist_section',
		'default'     => '1',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'wishlist_save_button_state',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Save button state after adding to the list', 'woodmart' ),
		'description' => esc_html__( 'You can enable this option to show the "Browse wishlist" button when you visit the product that has been already added to the wishlist.  IMPORTANT: It will not work if you use some full-page cache like WP Rocket or WP Total Cache.', 'woodmart' ),
		'section'     => 'wishlist_section',
		'default'     => '0',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'wishlist_empty_text',
		'type'        => 'textarea',
		'name'        => esc_html__( 'Empty wishlist text', 'woodmart' ),
		'description' => esc_html__( 'Text will be displayed if user don\'t add any products to wishlist.', 'woodmart' ),
		'section'     => 'wishlist_section',
		'wysiwyg'     => false,
		'default'     => 'You don\'t have any products in the wishlist yet. <br> You will find a lot of interesting products on our "Shop" page.',
		'priority'    => 60,
	)
);
