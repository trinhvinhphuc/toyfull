<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

Options::add_field(
	array(
		'id'          => 'login_tabs',
		'name'        => esc_html__( 'Login page tabs', 'woodmart' ),
		'description' => esc_html__( 'Enable tabs for login and register forms', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'login_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'reg_title',
		'name'     => esc_html__( 'Registration title', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'default'  => 'Register',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'reg_text',
		'name'        => esc_html__( 'Registration text', 'woodmart' ),
		'description' => esc_html__( 'Show some information about registration on your web-site', 'woodmart' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'login_section',
		'default'     => 'Registering for this site allows you to access your order status and history. Just fill in the fields below, and we\'ll get a new account set up for you in no time. We will only ask you for information necessary to make the purchase process faster and easier.',
		'priority'    => 30,
	)
);


Options::add_field(
	array(
		'id'       => 'login_title',
		'name'     => esc_html__( 'Login title', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'default'  => 'Login',
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'login_text',
		'name'        => esc_html__( 'Login text', 'woodmart' ),
		'description' => esc_html__( 'Show some information about login on your web-site', 'woodmart' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'login_section',
		'default'     => '',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'my_account_links',
		'name'        => esc_html__( 'Dashboard icons menu', 'woodmart' ),
		'description' => esc_html__( 'Adds icons blocks to the my account page as a navigation.', 'woodmart' ),
		'group'       => esc_html__( 'Dashboard', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'login_section',
		'default'     => '1',
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'social_login_tabs',
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'options'  => array(
			'facebook' => array(
				'name'  => esc_html__( 'Facebook', 'woodmart' ),
				'value' => 'facebook',
			),
			'google'   => array(
				'name'  => esc_html__( 'Google', 'woodmart' ),
				'value' => 'google',
			),
			'vk'       => array(
				'name'  => esc_html__( 'VKontakte', 'woodmart' ),
				'value' => 'vk',
			),
		),
		'default'  => 'facebook',
		'tabs'     => 'default',
		'type'     => 'buttons',
		'section'  => 'login_section',
		'priority' => 90,
	)
);

Options::add_field(
	array(
		'id'       => 'fb_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'content'  => wp_kses(
			__(
				'Enable login with Facebook on your web-site.
				To do that you need to create an APP on the Facebook <a href="https://developers.facebook.com/" target="_blank">https://developers.facebook.com/</a>.
				Then go to APP settings and copy App ID and App Secret there. You also need to insert Redirect URI like this example <strong>{{PERMALINK}}facebook/int_callback</strong> More information you can get in our <a href="https://xtemos.com/docs/woodmart/faq-guides/configure-facebook-login/" target="_blank">documentation</a>.',
				'woodmart'
			),
			true
		),
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'facebook',
			),
		),
		'priority' => 100,
	)
);

Options::add_field(
	array(
		'id'       => 'fb_app_id',
		'name'     => esc_html__( 'Facebook App ID', 'woodmart' ),
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'facebook',
			),
		),
		'priority' => 110,
		'class'    => 'xts-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'fb_app_secret',
		'name'     => esc_html__( 'Facebook App Secret', 'woodmart' ),
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'facebook',
			),
		),
		'priority' => 120,
		'class'    => 'xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'goo_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'content'  => wp_kses(
			__(
				'You can enable login with Google on your web-site.
			To do that you need to Create a Google APIs project at <a href="https://console.cloud.google.com/home/dashboard" target="_blank">https://console.developers.google.com/apis/dashboard/</a>.
			Make sure to go to API Access tab and Create an OAuth 2.0 client ID. Choose Web application for Application type. Make sure that redirect URI is set to actual OAuth 2.0 callback URL, usually <strong>{{PERMALINK}}google/oauth2callback </strong> More information you can get in our <a href="https://xtemos.com/docs/woodmart/faq-guides/configure-google-login/" target="_blank">documentation</a>.',
				'woodmart'
			),
			true
		),
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'google',
			),
		),
		'priority' => 130,
	)
);

Options::add_field(
	array(
		'id'       => 'goo_app_id',
		'name'     => esc_html__( 'Google App ID', 'woodmart' ),
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'google',
			),
		),
		'priority' => 140,
		'class'    => 'xts-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'goo_app_secret',
		'name'     => esc_html__( 'Google App Secret', 'woodmart' ),
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'google',
			),
		),
		'priority' => 150,
		'class'    => 'xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'vk_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'content'  => wp_kses(
			__(
				'To enable login with vk.com you need to create an APP here <a href="https://vk.com/dev" target="_blank">https://vk.com/dev</a>.
			Then go to APP settings and copy App ID and App Secret there.
			You also need to insert Redirect URI like this example <strong>{{PERMALINK}}vkontakte/int_callback</strong>',
				'woodmart'
			),
			true
		),
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'vk',
			),
		),
		'priority' => 160,
	)
);

Options::add_field(
	array(
		'id'       => 'vk_app_id',
		'name'     => esc_html__( 'VKontakte App ID', 'woodmart' ),
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'vk',
			),
		),
		'priority' => 170,
		'class'    => 'xts-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'vk_app_secret',
		'name'     => esc_html__( 'VKontakte App Secret', 'woodmart' ),
		'group'    => esc_html__( 'Social login', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'requires' => array(
			array(
				'key'     => 'social_login_tabs',
				'compare' => 'equals',
				'value'   => 'vk',
			),
		),
		'priority' => 180,
		'class'    => 'xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'          => 'alt_auth_method',
		'name'        => esc_html__( 'Alternative login mechanism', 'woodmart' ),
		'description' => esc_html__( 'Enable it if you are redirected to my account page without signing in after click on the social login button.', 'woodmart' ),
		'group'       => esc_html__( 'Social login', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'login_section',
		'default'     => '0',
		'priority'    => 190,
	)
);
