<?php
/**
 * Enqueue script and styles for child theme
 */
function woodmart_child_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'woodmart-style' ), woodmart_get_theme_info( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010 );

function hide_admin() {
	?>
		<style>
			#update-nag, .update-nag, .notice.e-notice.e-notice--dismissible.e-notice--extended, #setting-error-tgmpa, .error.fade, .updated {
				display: none !important;
			}
			
		</style>
	<?php
}
add_action( 'admin_head', 'hide_admin');

/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );

function css_script() {
	?>
		<style>
			li#tab-title-additional_information {
				display: none !important;
			}
			.product-element-top.wd-quick-shop{
				border-radius: 14px;
			}
			.wrapp-buttons>.wd-buttons{
				background: #3bb5e8;
    			border-radius: 10px;
			}
			img.attachment-woocommerce_thumbnail.size-woocommerce_thumbnail{
				border-radius: 5px;
			}
		</style>
	<?php
}
add_action( 'wp_footer', 'css_script' );

add_filter( 'woocommerce_checkout_fields' , 'avada_remove_checkout_fields' );
function avada_remove_checkout_fields( $fields ) {
	// Billing fields
    unset( $fields['billing']['billing_company'] );
    // unset( $fields['billing']['billing_email'] );
    // unset( $fields['billing']['billing_phone'] );
	unset($fields['billing']['billing_country']);
    unset( $fields['billing']['billing_state'] );
    // unset( $fields['billing']['billing_first_name'] );
    // unset( $fields['billing']['billing_last_name'] );
    // unset( $fields['billing']['billing_address_1'] );
    // unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_address_2'] );
    // unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_postcode'] );
    return $fields;
}

add_action( 'login_form', 'hide_wordpress_logo' );
function hide_wordpress_logo() {
	?>
	<style>
		#login>h1>a {
			display: none !important;
		}
		.language-switcher {
			display: none !important;
		}
	</style>
	<?php
}

add_action( 'admin_init', 'hide_admin_logo' );
function hide_admin_logo() {
	?>
	<style>
		#wp-admin-bar-wp-logo {
			display: none !important;
		}
		.wrap.woocommerce>#message {
			display: none !important;
		}
	</style>
	<?php
}

add_filter('login_redirect', 'custom_login_redirect');
function custom_login_redirect() {
	$user = wp_get_current_user();	 
	$roles = ( array ) $user->roles;
	if (in_array("shop_manager", $roles)) {
		return get_site_url().'/wp-admin/edit.php?post_type=shop_order';
	}
	if (in_array("administrator", $roles)) {
		return get_site_url().'/wp-admin/admin.php?page=wc-reports';
	}
}
