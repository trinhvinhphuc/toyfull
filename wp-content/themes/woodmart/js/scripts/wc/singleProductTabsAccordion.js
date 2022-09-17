/* global woodmart_settings */
(function($) {
	woodmartThemeModule.singleProductTabsAccordion = function() {
		var $wcTabs = $('.woocommerce-tabs');

		if ($wcTabs.length <= 0 || $wcTabs.data('layout') === 'accordion' || $('.site-content').hasClass('wd-builder-on')) {
			return;
		}

		if (woodmartThemeModule.$window.width() <= 1024) {
			$wcTabs.removeClass('tabs-layout-tabs wc-tabs-wrapper').addClass('tabs-layout-accordion wd-accordion wd-style-default');
			$wcTabs.find('.wd-accordion-item .entry-content').addClass('wd-accordion-content wd-scroll').find('.wc-tab-inner').addClass('wd-scroll-content');
			$('.single-product-page').removeClass('tabs-type-tabs').addClass('tabs-type-accordion');
		} else {
			$wcTabs.addClass('tabs-layout-tabs wc-tabs-wrapper').removeClass('tabs-layout-accordion wd-accordion wd-style-default');
			$wcTabs.find('.wd-accordion-item .entry-content').removeClass('wd-accordion-content wd-scroll').find('.wc-tab-inner').removeClass('wd-scroll-content');
			$('.single-product-page').addClass('tabs-type-tabs').removeClass('tabs-type-accordion');
		}
	};

	woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
		woodmartThemeModule.singleProductTabsAccordion();
		woodmartThemeModule.accordion();
		woodmartThemeModule.$document.trigger('resize.vcRowBehaviour');
	}, 300));

	$(document).ready(function() {
		woodmartThemeModule.singleProductTabsAccordion();
	});
})(jQuery);
