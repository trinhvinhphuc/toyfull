<?php
/**
 * Wordfence.
 *
 * @package woodmart
 */

if ( ! defined( 'WORDFENCE_VERSION' ) ) {
	return;
}

add_action( 'woocommerce_login_form_start', [ WordfenceLS\Controller_WordfenceLS::shared(), '_woocommerce_login_enqueue_scripts' ] );
