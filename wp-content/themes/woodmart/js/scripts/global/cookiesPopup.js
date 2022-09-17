/* global woodmart_settings */
(function($) {
	woodmartThemeModule.cookiesPopup = function() {
		var cookies_version = woodmart_settings.cookies_version;

		if ( typeof Cookies === 'undefined' ) {
			return;
		}

		if (Cookies.get('woodmart_cookies_' + cookies_version) === 'accepted') {
			return;
		}

		var popup = $('.wd-cookies-popup');

		setTimeout(function() {
			popup.addClass('popup-display');
			popup.on('click', '.cookies-accept-btn', function(e) {
				e.preventDefault();
				acceptCookies();
			});
		}, 2500);

		var acceptCookies = function() {
			popup.removeClass('popup-display').addClass('popup-hide');
			Cookies.set('woodmart_cookies_' + cookies_version, 'accepted', {
				expires: 60,
				path   : '/',
				secure : woodmart_settings.cookie_secure_param
			});
		};
	};

	$(document).ready(function() {
		woodmartThemeModule.cookiesPopup();
	});
})(jQuery);
