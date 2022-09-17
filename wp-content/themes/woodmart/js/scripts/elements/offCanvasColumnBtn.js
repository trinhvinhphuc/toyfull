(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function () {
		woodmartThemeModule.offCanvasColumnBtn();
	});

	$.each([
		'frontend/element_ready/column',
		'frontend/element_ready/wd_builder_off_canvas_column_btn.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.offCanvasColumnBtn();
		});
	});

	woodmartThemeModule.offCanvasColumnBtn = function() {
		var $closeSide = $('.wd-close-side');
		var $colOffCanvas = $('[class*="wd-col-offcanvas"]');
		var alignment = $colOffCanvas.hasClass('wd-alignment-left') ? 'left' : 'right';
		var $openButton = $('.wd-off-canvas-btn, .wd-off-canvas-btn + .wd-sidebar-opener, .wd-sidebar-opener.wd-on-toolbar');
		var innerWidth = woodmartThemeModule.$window.width();

		var offCanvassInit = function() {
			$colOffCanvas.removeClass('wd-left wd-right').addClass('wd-side-hidden wd-' + alignment + ' wd-inited');

			if (0 === $colOffCanvas.find('.wd-heading').length) {
				$colOffCanvas.prepend(
					'<div class="wd-heading"><div class="close-side-widget wd-action-btn wd-style-text wd-cross-icon"><a href="#" rel="nofollow">' + woodmart_settings.off_canvas_column_close_btn_text + '</a></div></div>'
				);
			}

			$openButton.on('click', function(e) {
				e.preventDefault();

				$colOffCanvas.addClass('wd-scroll wd-opened');
				$closeSide.addClass('wd-close-side-opened');

				$colOffCanvas.find(' .elementor-widget-wrap').first().addClass('wd-scroll-content');
			});
		};

		if ('elementor' === woodmart_settings.current_page_builder && (($colOffCanvas.hasClass('wd-col-offcanvas-lg') && innerWidth >= 1024) || ($colOffCanvas.hasClass('wd-col-offcanvas-md-sm') && 768 <= innerWidth && innerWidth <= 1024) || ($colOffCanvas.hasClass('wd-col-offcanvas-sm') && innerWidth <= 767))) {
			offCanvassInit();
		} else if ('wpb' === woodmart_settings.current_page_builder && (($colOffCanvas.hasClass('wd-col-offcanvas-lg') && innerWidth >= 1200) || ($colOffCanvas.hasClass('wd-col-offcanvas-md-sm') && 769 <= innerWidth && innerWidth <= 1199) || ($colOffCanvas.hasClass('wd-col-offcanvas-sm') && innerWidth <= 768))) {
			offCanvassInit();
		} else {
			$openButton.off('click');
			$('.elementor-column').removeClass('wd-side-hidden wd-inited wd-scroll wd-opened wd-left wd-right');
			$('.wpb_column').removeClass('wd-side-hidden wd-inited wd-scroll wd-opened wd-left wd-right');
			$closeSide.trigger('click');
			$colOffCanvas.find(' .elementor-widget-wrap').first().removeClass('wd-scroll-content');
			$colOffCanvas.find('.wd-heading').remove();
		}

		$openButton.on('click', function(e) {
			e.preventDefault();
		});

		woodmartThemeModule.$body.on('pjax:beforeSend', function() {
			$('.wd-close-side, .close-side-widget').trigger('click');
		});

		woodmartThemeModule.$body.on('click touchstart', '.wd-close-side, .close-side-widget', function() {
			$colOffCanvas.removeClass('wd-opened');
			$closeSide.removeClass('wd-close-side-opened');
		});
	};

	woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
		woodmartThemeModule.offCanvasColumnBtn();
	}, 300));

	$(document).ready(function() {
		woodmartThemeModule.offCanvasColumnBtn();
	});
})(jQuery);