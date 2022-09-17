/* global woodmart_settings */
(function($) {
	woodmartThemeModule.parallax = function() {
		if (woodmartThemeModule.windowWidth <= 1024) {
			return;
		}

		$('.wd-parallax').each(function() {
			var $this = $(this);

			if ($this.hasClass('wpb_column')) {
				var $vcColumnInner = $this.find('> .vc_column-inner');

				$this.removeClass( 'wd-parallax' );
				$vcColumnInner.addClass( 'wd-parallax' )

				$vcColumnInner.parallax('50%', 0.3);
			} else {
				$this.parallax('50%', 0.3);
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.parallax();
	});
})(jQuery);
