(function($) {
	$.each([
		'frontend/element_ready/wd_tabs.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.tabs();
		});
	});

	woodmartThemeModule.tabs = function () {
		$('.wd-tabs').each(function() {
			var $tabsElement = $(this);
			var $tabsList = $tabsElement.find('.wd-nav-tabs > li');
			var $content =  $tabsElement.find('.wd-tab-content-wrapper > .wd-tab-content');
			var animationClass = 'wd-in';
			var animationTime = 100;

			$tabsList.on('click', function(e) {
				e.preventDefault();
				var $thisTab = $(this);
				var $tabsIndex = $thisTab.index();
				var $activeContent = $content.eq( $tabsIndex );

				$activeContent.siblings().removeClass(animationClass);

				setTimeout(function() {
					$thisTab.siblings().removeClass('wd-active');

					$activeContent.siblings().removeClass('wd-active');
				}, animationTime);

				setTimeout(function() {
					$thisTab.addClass('wd-active');

					$activeContent.siblings().removeClass('wd-active');
					$activeContent.addClass('wd-active');
				}, animationTime);

				setTimeout(function() {
					$activeContent.addClass(animationClass);

					woodmartThemeModule.$document.trigger('resize.vcRowBehaviour');
					woodmartThemeModule.$document.trigger('wood-images-loaded');
				}, animationTime * 2);
			});

			if ( !$($tabsList[0]).hasClass( 'wd-active' ) ) {
				$($tabsList[0]).trigger( 'click' );
			}

			setTimeout(function() {
				$tabsElement.addClass( 'wd-inited' );
			}, animationTime * 2);

		});
	}

	$(document).ready(function() {
		woodmartThemeModule.tabs();
	});
})(jQuery);