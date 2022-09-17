<?php
/**
 * WooCommerce hook shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;
use XTS\WC_Wishlist\Ui;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_woocommerce_hook' ) ) {
	/**
	 * WooCommerce hook shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_woocommerce_hook( $settings ) {
		$default_settings = array(
			'clean_actions' => 'yes',
			'css'           => '',
			'hook'          => '0',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$settings['hook'] = woodmart_vc_get_control_data( $settings['hook'], 'desktop' );

		if ( '0' === $settings['hook'] ) {
			return '';
		}

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		Main::setup_preview();

		if ( 'yes' === $settings['clean_actions'] ) {
			if ( 'woocommerce_checkout_billing' === $settings['hook'] ) {
				remove_action( 'woocommerce_checkout_billing', array( WC()->checkout(), 'checkout_form_billing' ) );
			} elseif ( 'woocommerce_checkout_shipping' === $settings['hook'] ) {
				remove_action( 'woocommerce_checkout_shipping', array( WC()->checkout(), 'checkout_form_shipping' ) );
			} elseif ( 'woocommerce_checkout_before_customer_details' === $settings['hook'] ) {
				remove_action( 'woocommerce_checkout_before_customer_details', 'wc_get_pay_buttons', 30 );
			} elseif ( 'woocommerce_before_checkout_form' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
			} elseif ( 'woocommerce_cart_collaterals' === $settings['hook'] ) {
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
			} elseif ( 'woocommerce_before_cart' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
			} elseif ( 'woocommerce_before_single_product' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices' );
				remove_action( 'woocommerce_before_single_product', 'wc_print_notices' );
				remove_action( 'woocommerce_before_single_product', 'woodmart_product_extra_content', 20 );
			} elseif ( 'woocommerce_before_single_product_summary' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			} elseif ( 'woocommerce_product_thumbnails' === $settings['hook'] ) {
				remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			} elseif ( 'woocommerce_single_product_summary' === $settings['hook'] ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 3 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 8 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_share_buttons', 62 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_display_product_attributes', 21 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_add_to_cart', 30 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_sguide_display', 38 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_before_add_to_cart_area', 25 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_after_add_to_cart_area', 31 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_add_to_compare_single_btn', 33 );

				if ( woodmart_get_opt( 'wishlist' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( UI::get_instance(), 'add_to_wishlist_single_btn' ), 33 );
				}
			} elseif ( 'woocommerce_before_add_to_cart_form' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_add_to_cart_form', 'woodmart_single_product_add_to_cart_scripts' );
			} elseif ( 'woocommerce_before_variations_form' === $settings['hook'] ) {
				remove_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation' );
			} elseif ( 'woocommerce_single_variation' === $settings['hook'] ) {
				remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation' );
				remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
				remove_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation' );
			} elseif ( 'woocommerce_after_single_product_summary' === $settings['hook'] ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
				remove_action( 'woocommerce_after_single_product_summary', 'woodmart_wc_comments_template', 50 );
			}
		}

		?>
		<div class="wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php if ( 'woocommerce_before_checkout_form' === $settings['hook'] || 'woocommerce_after_checkout_form' === $settings['hook'] ) : ?>
				<?php do_action( $settings['hook'], WC()->checkout() ); ?>
			<?php else : ?>
				<?php do_action( $settings['hook'] ); ?>
			<?php endif; ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
