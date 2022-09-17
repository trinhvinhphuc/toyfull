(function($) {
	$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
		$('.woodmart-vc-slider').each(function() {
			var $this = $(this);
			var $value = $this.find('.wd-slider-field-value');
			var $slider = $this.find('.wd-slider-field');
			var $text = $this.find('.wd-slider-value-preview');
			var sliderData = $value.data();
			var mainInputVal = $value.val();

			if (mainInputVal && isBase64(mainInputVal) && sliderData.css_args) {
				var parseVal = JSON.parse(window.atob(mainInputVal));
				mainInputVal = parseVal.data[sliderData.css_params.device];
			}

			$slider.slider({
				range: 'min',
				value: mainInputVal,
				min  : sliderData.min,
				max  : sliderData.max,
				step : sliderData.step,
				slide: function(event, ui) {
					setMainValue($this, ui.value);
					$text.text(ui.value);
				}
			});

			$text.text($slider.slider('value'));
			setMainValue($this, mainInputVal);
		});

		function setMainValue($this, value) {
			var $mainInput = $this.find('.wd-slider-field-value');

			var results = {
				param_type : 'woodmart_slider',
				css_args   : $mainInput.data('css_args'),
				css_params : $mainInput.data('css_params'),
				selector_id: $('.woodmart-css-id').val(),
				data       : {}
			};

			results.data[$mainInput.data('css_params').device] = value;

			results = window.btoa(JSON.stringify(results));

			if (0 === parseInt(value)) {
				results = '';
			}

			if (!$mainInput.data('css_args')) {
				results = value;
			}

			$mainInput.val(results).trigger('change');
		}

		function isBase64(str) {
			try {
				return btoa(atob(str)) === str;
			}
			catch (err) {
				return false;
			}
		}
	});
})(jQuery);
