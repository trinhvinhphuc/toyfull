/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdReplaceMainGallery', function() {
		woodmartThemeModule.productImagesGallery();
	});

	$.each([
		'frontend/element_ready/wd_single_product_gallery.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
			woodmartThemeModule.productImagesGallery();

			$wrapper.find('.woocommerce-product-gallery').css('opacity', '1');
		});
	});

	woodmartThemeModule.productImagesGallery = function() {
		woodmartThemeModule.setupMainCarouselArg();

		$('.woocommerce-product-gallery').each(function() {
			var $galleryWrapper = $(this);
			var $gallery = $galleryWrapper.find('.woocommerce-product-gallery__wrapper:not(.quick-view-gallery)');
			var $thumbnails = $galleryWrapper.find('.thumbnails');

			$thumbnails.addClass('thumbnails-ready');

			if ($galleryWrapper.hasClass('thumbs-position-without') || $galleryWrapper.hasClass('thumbs-position-centered') || $galleryWrapper.hasClass('thumbs-position-bottom') || $galleryWrapper.hasClass('thumbs-position-left') || $galleryWrapper.hasClass('thumbs-position-carousel_two_columns')) {
				if ('yes' === woodmart_settings.product_slider_auto_height) {
					$galleryWrapper.imagesLoaded(function() {
						initGallery();
					});
				} else {
					initGallery();
				}
			}

			if (woodmartThemeModule.$window.width() <= 1024 && ($galleryWrapper.hasClass('thumbs-position-bottom_combined') || $galleryWrapper.hasClass('thumbs-position-bottom_column') || $galleryWrapper.hasClass('thumbs-position-bottom_grid'))) {
				initGallery();
			}

			if ($thumbnails.length !== 0) {
				createThumbnails();

				if ($galleryWrapper.hasClass('thumbs-position-left') && woodmartThemeModule.$body.width() > 1024 && typeof ($.fn.slick) != 'undefined') {
					initThumbnailsVertical();
				} else {
					initThumbnailsHorizontal();
				}
			}

			function initGallery() {
				if ('undefined' === typeof $.fn.owlCarousel) {
					return;
				}

				$gallery.trigger('destroy.owl.carousel');
				$gallery.addClass('owl-carousel').owlCarousel(woodmartThemeModule.mainCarouselArg);
				woodmartThemeModule.$document.trigger('wood-images-loaded');
			}

			function createThumbnails() {
				var html = '';

				$gallery.find('.woocommerce-product-gallery__image').each(function() {
					var $this = $(this);
					var image = $this.data('thumb'),
					    alt   = $this.find('a img').attr('alt'),
					    title = $this.find('a img').attr('title');

					if (!title) {
						title = $this.find('a picture').attr('title');
					}

					html += '<div class="product-image-thumbnail"><img alt="' + alt + '" title="' + title + '" src="' + image + '" /></div>';
				});

				if ($thumbnails.hasClass('slick-slider')) {
					$thumbnails.slick('unslick');
				} else if ($thumbnails.hasClass('owl-carousel')) {
					$thumbnails.trigger('destroy.owl.carousel');
				}

				$thumbnails.empty();
				$thumbnails.append(html);
			}

			function initThumbnailsVertical() {
				$thumbnails.slick({
					slidesToShow   : woodmart_settings.product_gallery.thumbs_slider.items.vertical_items,
					slidesToScroll : woodmart_settings.product_gallery.thumbs_slider.items.vertical_items,
					vertical       : true,
					verticalSwiping: true,
					infinite       : false
				});

				$thumbnails.on('click', '.product-image-thumbnail', function() {
					$gallery.trigger('to.owl.carousel', $(this).index());
				});

				$gallery.on('changed.owl.carousel', function(e) {
					var i = e.item.index;

					$thumbnails.slick('slickGoTo', i);
					$thumbnails.find('.active-thumb').removeClass('active-thumb');
					$thumbnails.find('.product-image-thumbnail').eq(i).addClass('active-thumb');
				});

				$thumbnails.find('.product-image-thumbnail').eq(0).addClass('active-thumb');

				$thumbnails.imagesLoaded(function() {
					$thumbnails.slick('setPosition');
				});
			}

			function initThumbnailsHorizontal() {
				if ('undefined' === typeof $.fn.owlCarousel) {
					return;
				}

				$thumbnails.addClass('owl-carousel').owlCarousel({
					rtl       : woodmartThemeModule.$body.hasClass('rtl'),
					items     : woodmart_settings.product_gallery.thumbs_slider.items.desktop,
					responsive: {
						1025: {
							items: woodmart_settings.product_gallery.thumbs_slider.items.desktop
						},
						769 : {
							items: woodmart_settings.product_gallery.thumbs_slider.items.tablet_landscape
						},
						577 : {
							items: woodmart_settings.product_gallery.thumbs_slider.items.tablet
						},
						0   : {
							items: woodmart_settings.product_gallery.thumbs_slider.items.mobile
						}
					},
					dots      : false,
					nav       : true,
					navText   : false,
					navClass  : [
						'owl-prev wd-btn-arrow',
						'owl-next wd-btn-arrow'
					]
				});

				var $thumbnailsOwl = $thumbnails.owlCarousel();

				$thumbnails.on('mouseup', '.owl-item', function() {
					var i = $(this).index();

					$thumbnailsOwl.trigger('to.owl.carousel', i);
					$gallery.trigger('to.owl.carousel', i);
				});

				$gallery.on('changed.owl.carousel', function(e) {
					var i = e.item.index;

					$thumbnailsOwl.trigger('to.owl.carousel', i);
					$thumbnails.find('.active-thumb').removeClass('active-thumb');
					$thumbnails.find('.product-image-thumbnail').eq(i).addClass('active-thumb');
				});

				$thumbnails.find('.product-image-thumbnail').eq(0).addClass('active-thumb');
			}
		});
	};

	woodmartThemeModule.$window.on('elementor/frontend/init', function() {
		if (!elementorFrontend.isEditMode()) {
			return;
		}

		woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
			woodmartThemeModule.productImagesGallery();
		}, 300));
	});

	$(document).ready(function() {
		woodmartThemeModule.productImagesGallery();
	});
})(jQuery);
