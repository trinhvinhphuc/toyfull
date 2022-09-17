<?php
/**
 * Yoast.
 *
 * @package woodmart
 */

if ( ! function_exists( 'YoastSEO' ) ) {
	return;
}

add_action( 'category_description', 'woodmart_page_css_files_disable', 9 );
add_action( 'term_description', 'woodmart_page_css_files_disable', 9 );

add_action( 'category_description', 'woodmart_page_css_files_enable', 11 );
add_action( 'term_description', 'woodmart_page_css_files_enable', 11 );
