<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * ------------------------------------------------------------------------------------------------
 * Products widget shortcode
 * ------------------------------------------------------------------------------------------------
 */
class WOODMART_ShortcodeProductsWidget {

	function __construct() {
		add_shortcode( 'woodmart_shortcode_products_widget', array( $this, 'woodmart_shortcode_products_widget' ) );
	}

	public function add_category_order( $query_args ) {
		$ids = explode( ',', $this->ids );
		if ( ! empty( $ids[0] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => $ids,
			);
		}
		return $query_args;
	}

	public function add_product_order( $query_args ) {
		$ids = explode( ',', $this->include_products );

		if ( ! empty( $ids[0] ) ) {
			$query_args['post__in']       = $ids;
			$query_args['orderby']        = 'post__in';
			$query_args['posts_per_page'] = -1;
		}

		return $query_args;
	}

	public function woodmart_shortcode_products_widget( $atts ) {
		global $woodmart_widget_product_img_size;
		$output = $title = $el_class = '';
		$atts   = shortcode_atts(
			array(
				'title'            => '',
				'show'             => '',
				'number'           => 3,
				'include_products' => '',
				'orderby'          => 'date',
				'order'            => 'asc',
				'ids'              => '',
				'hide_free'        => 0,
				'show_hidden'      => 0,
				'images_size'      => 'woocommerce_thumbnail',
				'el_class'         => '',
			),
			$atts
		);
		extract( $atts );

		$woodmart_widget_product_img_size = $images_size;
		$this->ids                        = $ids;
		$this->include_products           = $include_products;
		$output                           = '<div class="widget_products' . $el_class . '">';
		$type                             = 'WC_Widget_Products';

		$args = array( 'widget_id' => uniqid() );

		ob_start();

		add_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_category_order' ), 10 );
		add_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_product_order' ), 20 );

		if ( function_exists( 'woodmart_woocommerce_installed' ) && woodmart_woocommerce_installed() ) {
			the_widget( $type, $atts, $args );
		}

		remove_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_category_order' ), 10 );
		remove_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_product_order' ), 20 );

		$output .= ob_get_clean();

		$output .= '</div>';

		unset( $woodmart_widget_product_img_size );

		return $output;

	}
}
$woodmart_shortcode_products_widget = new WOODMART_ShortcodeProductsWidget();

function woodmart_add_shortcodes() {
	// Single product.
	add_shortcode( 'woodmart_single_product_add_to_cart', 'woodmart_shortcode_single_product_add_to_cart' );
	add_shortcode( 'woodmart_single_product_additional_info_table', 'woodmart_shortcode_single_product_additional_info_table' );
	add_shortcode( 'woodmart_single_product_brand_information', 'woodmart_shortcode_single_product_brand_information' );
	add_shortcode( 'woodmart_single_product_brands', 'woodmart_shortcode_single_product_brands' );
	add_shortcode( 'woodmart_single_product_compare_button', 'woodmart_shortcode_single_product_compare_button' );
	add_shortcode( 'woodmart_single_product_content', 'woodmart_shortcode_single_product_content' );
	add_shortcode( 'woodmart_single_product_countdown', 'woodmart_shortcode_single_product_countdown' );
	add_shortcode( 'woodmart_single_product_extra_content', 'woodmart_shortcode_single_product_extra_content' );
	add_shortcode( 'woodmart_single_product_gallery', 'woodmart_shortcode_single_product_gallery' );
	add_shortcode( 'woodmart_single_product_meta', 'woodmart_shortcode_single_product_meta' );
	add_shortcode( 'woodmart_single_product_meta_value', 'woodmart_shortcode_single_product_meta_value' );
	add_shortcode( 'woodmart_single_product_nav', 'woodmart_shortcode_single_product_nav' );
	add_shortcode( 'woodmart_single_product_price', 'woodmart_shortcode_single_product_price' );
	add_shortcode( 'woodmart_single_product_rating', 'woodmart_shortcode_single_product_rating' );
	add_shortcode( 'woodmart_single_product_reviews', 'woodmart_shortcode_single_product_reviews' );
	add_shortcode( 'woodmart_single_product_short_description', 'woodmart_shortcode_single_product_short_description' );
	add_shortcode( 'woodmart_single_product_size_guide_button', 'woodmart_shortcode_single_product_size_guide_button' );
	add_shortcode( 'woodmart_single_product_stock_progress_bar', 'woodmart_shortcode_single_product_stock_progress_bar' );
	add_shortcode( 'woodmart_single_product_tabs', 'woodmart_shortcode_single_product_tabs' );
	add_shortcode( 'woodmart_single_product_title', 'woodmart_shortcode_single_product_title' );
	add_shortcode( 'woodmart_single_product_wishlist_button', 'woodmart_shortcode_single_product_wishlist_button' );

	// Shop archive.
	add_shortcode( 'woodmart_shop_archive_active_filters', 'woodmart_shortcode_shop_archive_active_filters' );
	add_shortcode( 'woodmart_shop_archive_description', 'woodmart_shortcode_shop_archive_description' );
	add_shortcode( 'woodmart_shop_archive_products', 'woodmart_shortcode_shop_archive_products' );
	add_shortcode( 'woodmart_shop_archive_filters_area', 'woodmart_shortcode_shop_archive_filters_area' );
	add_shortcode( 'woodmart_shop_archive_filters_area_btn', 'woodmart_shortcode_shop_archive_filters_area_btn' );
	add_shortcode( 'woodmart_shop_archive_orderby', 'woodmart_shortcode_shop_archive_orderby' );
	add_shortcode( 'woodmart_shop_archive_orderby', 'woodmart_shortcode_shop_archive_orderby' );
	add_shortcode( 'woodmart_shop_archive_per_page', 'woodmart_shortcode_shop_archive_per_page' );
	add_shortcode( 'woodmart_shop_archive_result_count', 'woodmart_shortcode_shop_archive_result_count' );
	add_shortcode( 'woodmart_sidebar', 'woodmart_shortcode_sidebar' );
	add_shortcode( 'woodmart_shop_archive_view', 'woodmart_shortcode_shop_archive_view' );
	add_shortcode( 'woodmart_shop_archive_woocommerce_title', 'woodmart_shortcode_shop_archive_woocommerce_title' );

	// Cart.
	add_shortcode( 'woodmart_cart_table', 'woodmart_shortcode_cart_table' );
	add_shortcode( 'woodmart_cart_totals', 'woodmart_shortcode_cart_totals' );

	// Checkout.
	add_shortcode( 'woodmart_checkout_billing_details_form', 'woodmart_shortcode_checkout_billing_details_form' );
	add_shortcode( 'woodmart_checkout_coupon_form', 'woodmart_shortcode_checkout_coupon_form' );
	add_shortcode( 'woodmart_checkout_login_form', 'woodmart_shortcode_checkout_login_form' );
	add_shortcode( 'woodmart_checkout_order_review', 'woodmart_shortcode_checkout_order_review' );
	add_shortcode( 'woodmart_checkout_payment_methods', 'woodmart_shortcode_checkout_payment_methods' );
	add_shortcode( 'woodmart_checkout_shipping_details_form', 'woodmart_shortcode_checkout_shipping_details_form' );

	// WooCommerce.
	add_shortcode( 'woodmart_woocommerce_breadcrumb', 'woodmart_shortcode_woocommerce_breadcrumb' );
	add_shortcode( 'woodmart_woocommerce_checkout_steps', 'woodmart_shortcode_woocommerce_checkout_steps' );
	add_shortcode( 'woodmart_woocommerce_hook', 'woodmart_shortcode_woocommerce_hook' );
	add_shortcode( 'woodmart_woocommerce_notices', 'woodmart_shortcode_woocommerce_notices' );
	add_shortcode( 'woodmart_page_title', 'woodmart_shortcode_page_title' );
	add_shortcode( 'woodmart_shipping_progress_bar', 'woodmart_shortcode_shipping_progress_bar' );

	add_shortcode( 'html_block', 'woodmart_html_block_shortcode' );
	add_shortcode( 'social_buttons', 'woodmart_shortcode_social' );
	add_shortcode( 'woodmart_info_box', 'woodmart_shortcode_info_box' );
	add_shortcode( 'woodmart_info_box_carousel', 'woodmart_shortcode_info_box_carousel' );
	add_shortcode( 'woodmart_button', 'woodmart_shortcode_button' );
	add_shortcode( 'author_area', 'woodmart_shortcode_author_area' );
	add_shortcode( 'promo_banner', 'woodmart_shortcode_promo_banner' );
	add_shortcode( 'banners_carousel', 'woodmart_shortcode_banners_carousel' );
	add_shortcode( 'woodmart_instagram', 'woodmart_shortcode_instagram' );
	add_shortcode( 'user_panel', 'woodmart_shortcode_user_panel' );
	add_shortcode( 'woodmart_compare', 'woodmart_compare_shortcode' );
	add_shortcode( 'woodmart_size_guide', 'woodmart_size_guide_shortcode' );
	add_shortcode( 'woodmart_gallery', 'woodmart_images_gallery_shortcode' );
	add_shortcode( 'woodmart_blog', 'woodmart_shortcode_blog' );

	if ( function_exists( 'woodmart_get_current_page_builder' ) && 'wpb' === woodmart_get_current_page_builder() ) {
		add_shortcode( 'woodmart_3d_view', 'woodmart_shortcode_3d_view' );
		add_shortcode( 'woodmart_ajax_search', 'woodmart_ajax_search' );
		add_shortcode( 'woodmart_countdown_timer', 'woodmart_shortcode_countdown_timer' );
		add_shortcode( 'woodmart_counter', 'woodmart_shortcode_animated_counter' );
		add_shortcode( 'extra_menu', 'woodmart_shortcode_extra_menu' );
		add_shortcode( 'extra_menu_list', 'woodmart_shortcode_extra_menu_list' );
		add_shortcode( 'woodmart_google_map', 'woodmart_shortcode_google_map' );
		add_shortcode( 'woodmart_image_hotspot', 'woodmart_image_hotspot_shortcode' );
		add_shortcode( 'woodmart_hotspot', 'woodmart_hotspot_shortcode' );
		add_shortcode( 'woodmart_list', 'woodmart_list_shortcode' );
		add_shortcode( 'woodmart_mega_menu', 'woodmart_shortcode_mega_menu' );
		add_shortcode( 'woodmart_menu_price', 'woodmart_shortcode_menu_price' );
		add_shortcode( 'woodmart_popup', 'woodmart_shortcode_popup' );
		add_shortcode( 'woodmart_portfolio', 'woodmart_shortcode_portfolio' );
		add_shortcode( 'pricing_tables', 'woodmart_shortcode_pricing_tables' );
		add_shortcode( 'pricing_plan', 'woodmart_shortcode_pricing_plan' );
		add_shortcode( 'woodmart_responsive_text_block', 'woodmart_shortcode_responsive_text_block' );
		add_shortcode( 'woodmart_text_block', 'woodmart_shortcode_text_block' );
		add_shortcode( 'woodmart_image', 'woodmart_shortcode_image' );
		add_shortcode( 'woodmart_mailchimp', 'woodmart_shortcode_mailchimp' );
		add_shortcode( 'woodmart_row_divider', 'woodmart_row_divider' );
		add_shortcode( 'woodmart_slider', 'woodmart_shortcode_slider' );
		add_shortcode( 'team_member', 'woodmart_shortcode_team_member' );
		add_shortcode( 'testimonials', 'woodmart_shortcode_testimonials' );
		add_shortcode( 'testimonial', 'woodmart_shortcode_testimonial' );
		add_shortcode( 'woodmart_timeline', 'woodmart_timeline_shortcode' );
		add_shortcode( 'woodmart_timeline_item', 'woodmart_timeline_item_shortcode' );
		add_shortcode( 'woodmart_timeline_breakpoint', 'woodmart_timeline_breakpoint_shortcode' );
		add_shortcode( 'woodmart_title', 'woodmart_shortcode_title' );
		add_shortcode( 'woodmart_twitter', 'woodmart_twitter' );
		add_shortcode( 'woodmart_tabs', 'woodmart_shortcode_tabs' );
		add_shortcode( 'woodmart_tab', 'woodmart_shortcode_tab' );
		add_shortcode( 'woodmart_accordion', 'woodmart_shortcode_accordion' );
		add_shortcode( 'woodmart_accordion_item', 'woodmart_shortcode_accordion_item' );
		add_shortcode( 'woodmart_off_canvas_btn', 'woodmart_shortcode_off_canvas_btn' );

		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			add_shortcode( 'products_tabs', 'woodmart_shortcode_products_tabs' );
			add_shortcode( 'products_tab', 'woodmart_shortcode_products_tab' );
			add_shortcode( 'woodmart_brands', 'woodmart_shortcode_brands' );
			add_shortcode( 'woodmart_categories', 'woodmart_shortcode_categories' );
			add_shortcode( 'woodmart_product_filters', 'woodmart_product_filters_shortcode' );
			add_shortcode( 'woodmart_filter_categories', 'woodmart_filters_categories_shortcode' );
			add_shortcode( 'woodmart_filters_attribute', 'woodmart_filters_attribute_shortcode' );
			add_shortcode( 'woodmart_filters_orderby', 'woodmart_orderby_filter_template' );
			add_shortcode( 'woodmart_filters_price_slider', 'woodmart_filters_price_slider_shortcode' );
			add_shortcode( 'woodmart_stock_status', 'woodmart_stock_status_shortcode' );
			add_shortcode( 'woodmart_products', 'woodmart_shortcode_products' );
		}

		if ( function_exists( 'vc_add_shortcode_param' ) ) {
			vc_add_shortcode_param( 'woodmart_datepicker', 'woodmart_get_datepicker_param' );
			vc_add_shortcode_param( 'woodmart_button_set', 'woodmart_get_button_set_param' );
			vc_add_shortcode_param( 'woodmart_colorpicker', 'woodmart_get_colorpicker_param' );
			vc_add_shortcode_param( 'woodmart_css_id', 'woodmart_get_css_id_param' );
			vc_add_shortcode_param( 'woodmart_dropdown', 'woodmart_get_dropdown_param' );
			vc_add_shortcode_param( 'woodmart_empty_space', 'woodmart_get_empty_space_param' );
			vc_add_shortcode_param( 'woodmart_gradient', 'woodmart_add_gradient_type' );
			vc_add_shortcode_param( 'woodmart_image_hotspot', 'woodmart_image_hotspot' );
			vc_add_shortcode_param( 'woodmart_image_select', 'woodmart_add_image_select_type' );
			vc_add_shortcode_param( 'woodmart_responsive_size', 'woodmart_get_responsive_size_param' );
			vc_add_shortcode_param( 'woodmart_responsive_spacing', 'woodmart_get_responsive_spacing_param' );
			vc_add_shortcode_param( 'woodmart_slider', 'woodmart_get_slider_param' );
			vc_add_shortcode_param( 'woodmart_switch', 'woodmart_get_switch_param' );
			vc_add_shortcode_param( 'woodmart_title_divider', 'woodmart_get_title_divider_param' );

			vc_add_shortcode_param( 'wd_slider', 'woodmart_get_slider_responsive_param' );
			vc_add_shortcode_param( 'wd_number', 'woodmart_get_number_param' );
			vc_add_shortcode_param( 'wd_colorpicker', 'woodmart_get_wd_colorpicker_param' );
			vc_add_shortcode_param( 'wd_box_shadow', 'woodmart_get_box_shadow_param' );
			vc_add_shortcode_param( 'wd_select', 'woodmart_get_select_param' );
			vc_add_shortcode_param( 'wd_notice', 'woodmart_get_notice_param' );
			vc_add_shortcode_param( 'wd_dimensions', 'woodmart_get_dimensions_responsive_param' );
			vc_add_shortcode_param( 'wd_fonts', 'woodmart_get_fonts_param' );
		}
	}

	if ( function_exists( 'woodmart_get_opt' ) && woodmart_get_opt( 'single_post_justified_gallery' ) ) {
		remove_shortcode( 'gallery' );
		add_shortcode( 'gallery', 'woodmart_gallery_shortcode' );
	}
}
add_action( 'init', 'woodmart_add_shortcodes' );

/**
 * ------------------------------------------------------------------------------------------------
 * Add metaboxes to the product
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_product_360_view_meta' ) ) {
	function woodmart_product_360_view_meta() {
		if ( ! function_exists( 'woodmart_get_opt' ) ) {
			return;
		}

		add_meta_box( 'woocommerce-product-360-images', esc_html__( 'Product 360 View Gallery (optional)', 'woodmart' ), 'woodmart_360_metabox_output', 'product', 'side', 'low' );
	}
	add_action( 'add_meta_boxes', 'woodmart_product_360_view_meta', 50 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Add metaboxes
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_sguide_add_metaboxes' ) ) {
	function woodmart_sguide_add_metaboxes() {
		if ( ! function_exists( 'woodmart_get_opt' ) || ! woodmart_get_opt( 'size_guides' ) ) {
			return;
		}

		// Add table metaboxes to size guide
		add_meta_box( 'woodmart_sguide_metaboxes', esc_html__( 'Create/modify size guide table', 'woodmart' ), 'woodmart_sguide_metaboxes', 'woodmart_size_guide', 'normal', 'default' );
		// Add metaboxes to product
		add_meta_box( 'woodmart_sguide_dropdown_template', esc_html__( 'Choose size guide', 'woodmart' ), 'woodmart_sguide_dropdown_template', 'product', 'side' );
		// Add category metaboxes to size guide
		add_meta_box( 'woodmart_sguide_category_template', esc_html__( 'Choose product categories', 'woodmart' ), 'woodmart_sguide_category_template', 'woodmart_size_guide', 'side' );
		// Add hide table checkbox to size guide
		add_meta_box( 'woodmart_sguide_hide_table_template', esc_html__( 'Hide size guide table', 'woodmart' ), 'woodmart_sguide_hide_table_template', 'woodmart_size_guide', 'side' );
	}
	add_action( 'add_meta_boxes', 'woodmart_sguide_add_metaboxes' );
}

if ( ! function_exists( 'woodmart_widgets_init' ) ) {
	function woodmart_widgets_init() {
		if ( ! is_blog_installed() || ! class_exists( 'WOODMART_WP_Nav_Menu_Widget' ) ) {
			return;
		}

		register_widget( 'WOODMART_WP_Nav_Menu_Widget' );
		register_widget( 'WOODMART_Banner_Widget' );
		register_widget( 'WOODMART_Author_Area_Widget' );
		register_widget( 'WOODMART_Instagram_Widget' );
		register_widget( 'WOODMART_Static_Block_Widget' );
		register_widget( 'WOODMART_Recent_Posts' );
		register_widget( 'WOODMART_Twitter' );
		register_widget( 'WOODMART_Widget_Mailchimp' );

		if ( woodmart_woocommerce_installed() ) {
			register_widget( 'WOODMART_User_Panel_Widget' );
			register_widget( 'WOODMART_Widget_Layered_Nav' );
			register_widget( 'WOODMART_Widget_Sorting' );
			register_widget( 'WOODMART_Widget_Price_Filter' );
			register_widget( 'WOODMART_Widget_Search' );
			register_widget( 'WOODMART_Stock_Status' );
		}

	}

	add_action( 'widgets_init', 'woodmart_widgets_init' );
}

