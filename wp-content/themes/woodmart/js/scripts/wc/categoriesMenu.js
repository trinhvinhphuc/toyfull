/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function() {
		woodmartThemeModule.categoriesMenuBtns();
		woodmartThemeModule.categoriesMenu();
	});

	woodmartThemeModule.categoriesMenu = function() {
		var $categories = $('.wd-nav-product-cat');

		if (woodmartThemeModule.$window.width() > 1024) {
			$categories.stop().attr('style', '');
		}

		var time = 200;

		$categories.each(function() {
			var $productCat = $(this);
			var $thisCategories = $productCat.parents('.wd-nav-accordion-mb-on');
			var $showCat = $thisCategories.find('wd-btn-show-cat');
			var isAccordionOnMobile = $thisCategories.hasClass('wd-nav-accordion-mb-on');

			var isOpened = function() {
				return $productCat.hasClass('categories-opened');
			};

			var openCats = function() {
				$showCat.addClass('wd-active');
				$productCat.addClass('categories-opened').stop().slideDown(time);
				woodmartThemeModule.$document.trigger('wood-images-loaded');
			};

			var closeCats = function() {
				$showCat.removeClass('wd-active');
				$productCat.removeClass('categories-opened').stop().slideUp(time);
			};

			$thisCategories.find('.wd-nav-opener').off('click').on('click', function(e) {
				var $this = $(this);
				e.preventDefault();

				if ($this.closest('.has-sub').find('> ul').hasClass('child-open')) {
					$this.removeClass('wd-active').closest('.has-sub').find('> ul').slideUp(time).removeClass('child-open');
				} else {
					$this.addClass('wd-active').closest('.has-sub').find('> ul').slideDown(time).addClass('child-open');
				}

				woodmartThemeModule.$document.trigger('wood-images-loaded');
			});

			$thisCategories.find('.wd-btn-show-cat > a').off('click').on('click', function(e) {
				e.preventDefault();

				if (isAccordionOnMobile) {
					if (isOpened($productCat)) {
						closeCats();
					} else {
						openCats();
						woodmartThemeModule.$document.trigger('wood-images-loaded');
					}
				}
			});

			$thisCategories.find('.wd-nav-product-cat a').off('click').on('click', function(e) {
				if (!$(e.target).hasClass('wd-nav-opener')) {
					closeCats();
					$productCat.stop().attr('style', '');
				}
			});
		});
	};

	woodmartThemeModule.categoriesMenuBtns = function() {
		$('.wd-nav-product-cat.wd-mobile-accordion').each(function() {
			if (woodmartThemeModule.windowWidth > 1024) {
				return;
			}

			var $this = $(this);
			var iconDropdown = '<span class="wd-nav-opener"></span>';

			$this.find('li > ul').parent().find('.wd-nav-opener').remove();
			$this.find('li > ul').parent().addClass('has-sub').append(iconDropdown);
		});
	};

	woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
		woodmartThemeModule.categoriesMenuBtns();
		woodmartThemeModule.categoriesMenu();
	}, 300));

	$(document).ready(function() {
		woodmartThemeModule.categoriesMenuBtns();
		woodmartThemeModule.categoriesMenu();
	});
})(jQuery);
