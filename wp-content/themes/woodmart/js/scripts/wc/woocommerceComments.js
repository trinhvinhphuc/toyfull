/* global woodmart_settings */
(function($) {
	woodmartThemeModule.woocommerceComments = function() {
		var hash = window.location.hash;
		var url = window.location.href;

		if (hash.toLowerCase().indexOf('comment-') >= 0 || hash === '#reviews' || hash === '#tab-reviews' || url.indexOf('comment-page-') > 0 || url.indexOf('cpage=') > 0 || hash === '#tab-wd_additional_tab' || hash === '#tab-wd_custom_tab') {
			setTimeout(function() {
				window.scrollTo(0, 0);
			}, 1);

			setTimeout(function() {
				if ($(hash).length > 0) {
					$('.woocommerce-tabs a[href=' + hash + ']').trigger('click');
					$('html, body').stop().animate({
						scrollTop: $(hash).offset().top - 100
					}, 400);
				}
			}, 10);
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.woocommerceComments();
	});
})(jQuery);
