/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_products_tabs.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.productsTabs();
		});
	});

	woodmartThemeModule.productsTabs = function() {
		var process = false;

		$('.wd-products-tabs').each(function() {
			var $this  = $(this);
			var $inner = $this.find('.wd-tab-content');
			var cache  = [];

			if ($inner.find('.owl-carousel').length < 1) {
				cache[0] = {
					html: $inner.html()
				};
			}

			$this.find('.products-tabs-title li').on('click', function(e) {
				e.preventDefault();

				var $this = $(this),
				    atts  = $this.data('atts'),
				    index = $this.index();

				if (process || $this.hasClass('wd-active')) {
					return;
				}
				process = true;

				loadTab(atts, index, $inner, $this, cache, function(data) {
					if (data.html) {
						woodmartThemeModule.removeDuplicatedStylesFromHTML(data.html, function(html) {
							$inner.html(html);

							$inner.removeClass('loading').parent().removeClass('element-loading');
							$this.removeClass('loading');

							woodmartThemeModule.$document.trigger('wdProductsTabsLoaded');
							woodmartThemeModule.$document.trigger('wood-images-loaded');
						});
					}
				});
			});

			setTimeout(function() {
				$this.addClass( 'wd-inited' );
			}, 200);
		});

		var loadTab = function(atts, index, holder, btn, cache, callback) {
			btn.parent().find('.wd-active').removeClass('wd-active');
			btn.addClass('wd-active');

			if (cache[index]) {
				holder.addClass('loading');
				setTimeout(function() {
					process = false;
					callback(cache[index]);
					holder.removeClass('loading');
				}, 300);
				return;
			}

			holder.addClass('loading').parent().addClass('element-loading');
			btn.addClass('loading');

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					atts  : atts,
					action: 'woodmart_get_products_tab_shortcode'
				},
				dataType: 'json',
				method  : 'POST',
				success : function(data) {
					process = false;
					cache[index] = data;
					callback(data);
				},
				error   : function() {
					console.log('ajax error');
				},
				complete: function() {
					process = false;
				}
			});
		};
	};

	$(document).ready(function() {
		woodmartThemeModule.productsTabs();
	});
})(jQuery);
