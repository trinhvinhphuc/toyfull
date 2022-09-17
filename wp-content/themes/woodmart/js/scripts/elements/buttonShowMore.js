(function($) {
	$.each([
		'frontend/element_ready/wd_button.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.buttonShowMore();
		});
	});

	woodmartThemeModule.buttonShowMore = function () {
		$('.wd-collapsible-content').each(function() {
			var $this = $(this);
			var $button = $this.find('.wd-collapsible-button');


			$button.on('click', function(e) {
				e.preventDefault();

				$this.toggleClass('wd-opened');
			});
		});
	}

	$(document).ready(function() {
		woodmartThemeModule.buttonShowMore();
	});
})(jQuery);