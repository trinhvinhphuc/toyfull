/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_single_product_add_to_cart.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.variationsPrice();
		});
	});

	woodmartThemeModule.variationsPrice = function() {
		if ('no' === woodmart_settings.single_product_variations_price) {
			return;
		}

		$('.variations_form').each(function() {
			var $form = $(this);
			var $price = $form.parents('.site-content').find(' p.price');
			var priceOriginalHtml = $price.html();

			$form.on('show_variation', function(e, variation) {
				if (variation.price_html.length > 1) {
					$price.html(variation.price_html);
				}
			});

			$form.on('hide_variation', function() {
				$price.html(priceOriginalHtml);
			});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.variationsPrice();
	});
})(jQuery);
