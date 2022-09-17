<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Elements selectors for advanced typography options
 * ------------------------------------------------------------------------------------------------
 */

return apply_filters(
	'woodmart_typography_selectors',
	array(
		'main_nav'                           => array(
			'title' => 'Main navigation',
		),
		'main_navigation'                    => array(
			'title'          => 'Main navigation links',
			'selector'       => 'html .wd-nav.wd-nav-main > li > a',
			'selector-hover' => 'html .wd-nav.wd-nav-main > li:hover > a, html .wd-nav.wd-nav-main > li.current-menu-item > a',
		),
		'mega_menu_drop_first_level'         => array(
			'title'          => 'Menu dropdowns first level',
			'selector'       => 'html .wd-dropdown-menu.wd-design-sized .wd-sub-menu > li > a, body .wd-dropdown-menu.wd-design-full-width .wd-sub-menu > li > a',
			'selector-hover' => 'html .wd-dropdown-menu.wd-design-sized .wd-sub-menu > li > a:hover, body .wd-dropdown-menu.wd-design-full-width .wd-sub-menu > li > a:hover',
		),
		'mega_menu_drop_second_level'        => array(
			'title'          => 'Menu dropdowns second level',
			'selector'       => 'html .wd-dropdown-menu.wd-design-sized .wd-sub-menu li a, html .wd-dropdown-menu.wd-design-full-width .wd-sub-menu li a',
			'selector-hover' => 'html .wd-dropdown-menu.wd-design-sized .wd-sub-menu li a:hover, html .wd-dropdown-menu.wd-design-full-width .wd-sub-menu li a:hover',
		),
		'simple_dropdown'                    => array(
			'title'          => 'Menu links on simple dropdowns',
			'selector'       => 'html .wd-dropdown-menu.wd-design-default .wd-sub-menu li a',
			'selector-hover' => 'html .wd-dropdown-menu.wd-design-default .wd-sub-menu li a:hover',
		),
		'secondary_nav'                      => array(
			'title' => 'Other navigations',
		),
		'secondary_navigation'               => array(
			'title'          => 'Secondary navigation links',
			'selector'       => 'html .wd-nav.wd-nav-secondary > li > a',
			'selector-hover' => 'html .wd-nav.wd-nav-secondary > li:hover > a, html .wd-nav.wd-nav-secondary > li.current-menu-item > a',
		),
		'browse_categories'                  => array(
			'title'          => '"Browse categories" title',
			'selector'       => 'html .wd-header-cats .menu-opener',
			'selector-hover' => 'html .wd-header-cats .menu-opener:hover',
		),
		'category_navigation'                => array(
			'title'          => 'Categories navigation links',
			'selector'       => 'html .wd-dropdown-cats .wd-nav.wd-nav-vertical > li > a',
			'selector-hover' => 'html .wd-dropdown-cats .wd-nav.wd-nav-vertical > li:hover > a',
		),
		'my_account'                         => array(
			'title'          => 'My account links in the header',
			'selector'       => 'html .wd-dropdown-my-account .wd-sub-menu li a',
			'selector-hover' => 'html .wd-dropdown-my-account .wd-sub-menu li a:hover',
		),
		'mobile_nav'                         => array(
			'title' => 'Mobile menu',
		),
		'mobile_menu_first_level'            => array(
			'title'          => 'Mobile menu first level',
			'selector'       => 'html .wd-nav-mobile > li > a',
			'selector-hover' => 'html .wd-nav-mobile > li > a:hover, html .wd-nav-mobile > li.current-menu-item > a',
		),
		'mobile_menu_second_level'           => array(
			'title'          => 'Mobile menu second level',
			'selector'       => 'html .wd-nav-mobile .wd-sub-menu li a',
			'selector-hover' => 'html .wd-nav-mobile .wd-sub-menu li a:hover, html .wd-nav-mobile .wd-sub-menu li.current-menu-item > a',
		),
		'page_header'                        => array(
			'title' => 'Page heading',
		),
		'page_title'                         => array(
			'title'    => 'Page title',
			'selector' => 'html .page-title > .container > .title',
			'selector-hover' => 'html .page-title > .container > .title:hover',
		),
		'page_title_bredcrumps'              => array(
			'title'          => 'Breadcrumbs links',
			'selector'       => 'html .page-title .breadcrumbs a, html .page-title .breadcrumbs span, html .page-title .yoast-breadcrumb a, html .page-title .yoast-breadcrumb span',
			'selector-hover' => 'html .page-title .breadcrumbs a:hover, html .page-title .yoast-breadcrumb a:hover',
		),
		'products_categories'                => array(
			'title' => 'Products and categories',
		),
		'product_title'                      => array(
			'title'          => 'Product grid title',
			'selector'       => 'html .product-grid-item .wd-entities-title',
			'selector-hover' => 'html .product-grid-item .wd-entities-title a:hover',
		),
		'product_price'                      => array(
			'title'    => 'Product grid price',
			'selector' => 'html .product-grid-item .price > .amount, html .product-grid-item .price ins > .amount',
			'selector-hover' => 'html .product-grid-item .price > .amount:hover, html .product-grid-item .price ins > .amount:hover',
		),
		'product_old_price'                  => array(
			'title'    => 'Product old price',
			'selector' => 'html .product.product-grid-item del, html .product.product-grid-item del .amount',
			'selector-hover' => 'html .product.product-grid-item del:hover, html .product.product-grid-item del .amount:hover',
		),
		'product_category_title'             => array(
			'title'    => 'Category title',
			'selector' => 'html .product.category-grid-item .wd-entities-title, html .product.category-grid-item.cat-design-replace-title .wd-entities-title, html .categories-style-masonry-first .category-grid-item:first-child .wd-entities-title, html .product.wd-cat .wd-entities-title',
			'selector-hover' => 'html .product.category-grid-item .wd-entities-title:hover, html .product.category-grid-item.cat-design-replace-title .wd-entities-title:hover, html .categories-style-masonry-first .category-grid-item:first-child .wd-entities-title:hover, html .product.wd-cat .wd-entities-title a:hover',
		),
		'product_category_count'             => array(
			'title'          => 'Category products count',
			'selector'       => 'html .product.category-grid-item .more-products, html .product.category-grid-item.cat-design-replace-title .more-products, html .product.wd-cat .wd-cat-count',
			'selector-hover' => 'html .product.category-grid-item .more-products a:hover',
		),
		'single_product'                     => array(
			'title' => 'Single product',
		),
		'product_title_single_page'          => array(
			'title'    => 'Single product title',
			'selector' => 'html .product-image-summary-wrap .product_title, html .wd-single-title .product_title',
			'selector-hover' => 'html .product-image-summary-wrap .product_title:hover, html .wd-single-title .product_title:hover',
		),
		'product_price_single_page'          => array(
			'title'    => 'Single product price',
			'selector' => 'html .product-image-summary-wrap .summary-inner > .price > .amount, html .product-image-summary-wrap .summary-inner > .price > ins .amount, html .wd-single-price .price > .amount, html .wd-single-price .price > ins .amount',
			'selector-hover' => 'html .product-image-summary-wrap .summary-inner > .price > .amount:hover, html .product-image-summary-wrap .summary-inner > .price > ins .amount:hover, html .wd-single-price .price > .amount:hover, html .wd-single-price .price > ins .amount:hover',
		),
		'product_price_old_single_page'      => array(
			'title'    => 'Single product old price',
			'selector' => 'html .product-image-summary-wrap .summary-inner > .price del, html .product-image-summary-wrap .summary-inner > .price del .amount, html .wd-single-price .price del .amount',
			'selector-hover' => 'html .product-image-summary-wrap .summary-inner > .price del:hover, html .product-image-summary-wrap .summary-inner > .price del .amount:hover, html .wd-single-price .price del .amount:hover',
		),
		'product_variable_price_single_page' => array(
			'title'    => 'Single product variation price',
			'selector' => 'html .product-image-summary-wrap .variations_form .woocommerce-variation-price .price > .amount, html .product-image-summary-wrap .variations_form .woocommerce-variation-price .price > ins .amount, html .wd-single-add-cart .variations_form .woocommerce-variation-price .price > .amount, html .wd-single-add-cart .variations_form .woocommerce-variation-price .price > ins .amount',
			'selector-hover' => 'html .product-image-summary-wrap .variations_form .woocommerce-variation-price .price > .amount:hover, html .product-image-summary-wrap .variations_form .woocommerce-variation-price .price > ins .amount:hover, html .wd-single-add-cart .variations_form .woocommerce-variation-price .price > .amount:hover, html .wd-single-add-cart .variations_form .woocommerce-variation-price .price > ins .amount:hover',
		),
		'product_variable_price_old_single_page' => array(
			'title'    => 'Single product variation old price',
			'selector' => 'html .product-image-summary-wrap .variations_form .woocommerce-variation-price > .price del, html .product-image-summary-wrap .variations_form .woocommerce-variation-price > .price del .amount, html .wd-single-add-cart .variations_form .woocommerce-variation-price > .price del, html .wd-single-add-cart .variations_form .woocommerce-variation-price > .price del .amount',
			'selector-hover' => 'html .product-image-summary-wrap .variations_form .woocommerce-variation-price > .price del:hover, html .product-image-summary-wrap .variations_form .woocommerce-variation-price > .price del .amount:hover, html .wd-single-add-cart .variations_form .woocommerce-variation-price > .price del:hover, html .wd-single-add-cart .variations_form .woocommerce-variation-price > .price del .amount:hover',
		),
		'product_nav_price_single_page'          => array(
			'title'    => 'Single product navigation price',
			'selector' => 'html .wd-product-nav-desc .price > .amount, html .wd-product-nav-desc .price > ins .amount, html .wd-product-nav-desc .price > ins .amount',
			'selector-hover' => 'html .wd-product-nav-desc .price > .amount:hover, html .wd-product-nav-desc .price > ins .amount:hover, html .wd-product-nav-desc .price > ins .amount:hover',
		),
		'quick_view'                               => array(
			'title' => 'Quick view',
		),
		'product_title_quick_view'          => array(
			'title'    => 'Quick view title',
			'selector' => 'html .product-quick-view .product_title',
			'selector-hover' => 'html .product-quick-view .product_title:hover',
		),
		'product_price_quick_view'          => array(
			'title'    => 'Quick view price',
			'selector' => 'html .product-quick-view  .summary-inner > .price > .amount, html .product-quick-view .summary-inner > .price > ins .amount',
			'selector-hover' => 'html .product-quick-view  .summary-inner > .price > .amount:hover, html .product-quick-view .summary-inner > .price > ins .amount:hover',
		),
		'product_price_old_quick_view'      => array(
			'title'    => 'Quick view old price',
			'selector' => 'html .product-quick-view  .summary-inner > .price del, html .product-quick-view  .summary-inner > .price del .amount',
			'selector-hover' => 'html .product-quick-view  .summary-inner > .price del:hover, html .product-quick-view  .summary-inner > .price del .amount:hover',
		),
		'product_variable_price_quick_view' => array(
			'title'    => 'Quick view variation price',
			'selector' => 'html .product-quick-view  .variations_form .woocommerce-variation-price .price > .amount, html .product-quick-view .variations_form .woocommerce-variation-price .price > ins .amount',
			'selector-hover' => 'html .product-quick-view  .variations_form .woocommerce-variation-price .price > .amount:hover, html .product-quick-view .variations_form .woocommerce-variation-price .price > ins .amount:hover',
		),
		'product_variable_price_old_quick_view' => array(
			'title'    => 'Quick view variation old price',
			'selector' => 'html .product-quick-view  .variations_form .woocommerce-variation-price > .price del, html .product-quick-view .variations_form .woocommerce-variation-price > .price del .amount',
			'selector-hover' => 'html .product-quick-view  .variations_form .woocommerce-variation-price > .price del:hover, html .product-quick-view .variations_form .woocommerce-variation-price > .price del .amount:hover',
		),
		'blog'                               => array(
			'title' => 'Blog',
		),
		'blog_title'                         => array(
			'title'          => 'Blog post title',
			'selector'       => 'html .post.blog-post-loop .post-title',
			'selector-hover' => 'html .post.blog-post-loop .post-title a:hover',
		),
		'blog_title_shortcode'               => array(
			'title'          => 'Blog title on WPBakery element',
			'selector'       => 'html .blog-shortcode .post.blog-post-loop .post-title',
			'selector-hover' => 'html .blog-shortcode .post.blog-post-loop .post-title a:hover',
		),
		'blog_title_carousel'                => array(
			'title'          => 'Blog title on carousel',
			'selector'       => 'html .slider-type-post .post.blog-post-loop .post-title',
			'selector-hover' => 'html .slider-type-post .post.blog-post-loop .post-title a:hover',
		),
		'blog_title_sinle_post'              => array(
			'title'    => 'Blog title on single post',
			'selector' => 'html .post-single-page .post-title',
			'selector-hover' => 'html .post-single-page .post-title:hover',
		),
		'widgets'                               => array(
			'title' => 'Widgets',
		),
		'widgets_price'          => array(
			'title'    => 'Widgets prices',
			'selector' => 'html .widget-area .widget .price > .amount, html .widget-area .widget .price > ins .amount, html .widget-area .widget .price > ins .amount',
			'selector-hover' => 'html .widget-area .widget .price > .amount:hover, html .widget-area .widget .price > ins .amount:hover, html .widget-area .widget .price > ins .amount:hover',
		),
		'product_categories_first_level'            => array(
			'title'          => 'Product categories first level',
			'selector'       => 'html .widget_product_categories .product-categories > li > a',
			'selector-hover' => '.widget_product_categories .product-categories > li > a:hover, html .widget_product_categories .product-categories > li.current-cat > a',
		),
		'product_categories_second_level'           => array(
			'title'          => 'Product categories second level',
			'selector'       => 'html .widget_product_categories .product-categories > li > .children > li > a',
			'selector-hover' => 'html .widget_product_categories .product-categories > li > .children > li > a:hover, html html .widget_product_categories .product-categories > li > .children > li.current-menu-item > a',
		),
		'product_categories_all_level'           => array(
			'title'          => 'Product categories all level',
			'selector'       => 'html .widget_product_categories .product-categories li a',
			'selector-hover' => '.widget_product_categories .product-categories li a:hover, .widget_product_categories .product-categories li.current-menu-item a',
		),
		'custom_selector'                    => array(
			'title' => 'Write your own selector',
		),
		'custom'                             => array(
			'title'    => 'Custom selector',
			'selector' => 'custom',
		),
	)
);
