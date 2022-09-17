/* global woodmart_settings */
(function($) {
	woodmartThemeModule.mobileSearchIcon = function() {
		woodmartThemeModule.$body.on('click', '.wd-header-search-mobile:not(.wd-display-full-screen)', function(e) {
			e.preventDefault();
			var $nav = $('.mobile-nav');

			if (!$nav.hasClass('wd-opened')) {
				$nav.addClass('wd-opened');
				$('.wd-close-side').addClass('wd-close-side-opened');
				$('.mobile-nav .searchform').find('input[type="text"]').trigger('focus');
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.mobileSearchIcon();
	});
})(jQuery);
