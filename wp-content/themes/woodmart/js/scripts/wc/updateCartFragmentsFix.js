(function($) {
	// WooCommerce update fragments fix.
	$(document).ready(function() {
		$('body').on('added_to_cart removed_from_cart', function(e, fragments) {
			if (fragments) {
				$.each(fragments, function(key, value) {
					$(key.replace('_wd', '')).replaceWith(value);
				});
			}
		});
	});

	$('body').on('wc_fragments_refreshed wc_fragments_loaded', function() {
		if (typeof wd_cart_fragments_params !== 'undefined') {
			var wc_fragments  = JSON.parse(sessionStorage.getItem(wd_cart_fragments_params.fragment_name)),
			    cart_hash_key = wd_cart_fragments_params.cart_hash_key,
			    cart_hash     = sessionStorage.getItem(cart_hash_key),
			    cookie_hash   = Cookies.get('woocommerce_cart_hash'),
			    cart_created  = sessionStorage.getItem('wc_cart_created'),
			    day_in_ms    = ( 24 * 60 * 60 * 1000 );

			if (cart_hash === null || cart_hash === undefined || cart_hash === '') {
				cart_hash = '';
			}

			if (cookie_hash === null || cookie_hash === undefined || cookie_hash === '') {
				cookie_hash = '';
			}

			if (cart_hash && (cart_created === null || cart_created === undefined || cart_created === '')) {
				throw 'No cart_created';
			}

			if (cart_created) {
				var cart_expiration = ((1 * cart_created) + day_in_ms),
				    timestamp_now   = (new Date()).getTime();
				if (cart_expiration < timestamp_now) {
					throw 'Fragment expired';
				}
			}

			if (wc_fragments && wc_fragments['div.widget_shopping_cart_content'] && cart_hash === cookie_hash) {
				$.each(wc_fragments, function(key, value) {
					$(key.replace('_wd', '')).replaceWith(value);
				});
			}
		}
	});
})(jQuery);