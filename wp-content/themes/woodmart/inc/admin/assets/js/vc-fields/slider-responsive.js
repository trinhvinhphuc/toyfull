(function($) {
	$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
		$('.wd-sliders').each(function() {
			let $wrapper = $(this);
			let $valueInput = $wrapper.find('.wpb_vc_param_value')
			let settings = $valueInput.data('settings');

			$wrapper.find('.wd-device').on( 'click', function() {
				let $this = $(this);
				let device = $this.data('value');

				updateActiveClass($this);
				updateActiveClass($wrapper.find('.wd-slider[data-device="'+ device +'"]'));
			});

			$wrapper.find('.wd-slider').each(function() {
				let $this = $(this);
				let $slider = $this.find('.wd-slider-field');
				let $valuePreview = $this.find('.wd-slider-value-preview');
				let device = $this.data('device');
				let unit = settings.devices[device].unit;

				initSlider(device, unit);
				setMainValue();

				$valuePreview.on('change', function(){
					$this.attr('data-value', $valuePreview.val());
					initSlider( device, $this.attr('data-unit'), $valuePreview.val() );
					setMainValue();
				});

				$this.find('.wd-slider-unit-control').on( 'click', function() {
					let count_unit = [];

					$.each( settings.range, function(key) {
						count_unit.push(key)
					});

					if ( 1 === count_unit.length ) {
						return;
					}

					let $this = $(this);
					let device = $this.parents('.wd-slider').data('device');

					updateActiveClass($this);
					initSlider( device, $this.data('unit') );
					$this.parents('.wd-slider').attr('data-unit', $this.data('unit'));
				});

				/**
				 * Change Unit.
				 */
				function initSlider( device, unit, value = 0 ) {
					if ( 'undefined' !== typeof $slider.slider() ) {
						$slider.slider('destroy');
					}

					let deviceData = settings.devices[device];

					if ( deviceData.unit === unit && value === 0 ) {
						value = deviceData.value;
					}

					$valuePreview.val(value);

					$slider.slider({
						range: 'min',
						value: value,
						min  : settings.range[unit].min,
						max  : settings.range[unit].max,
						step : settings.range[unit].step,
						slide: function(event, ui) {
							$this.attr('data-value', ui.value);
							$valuePreview.val(ui.value);
							setMainValue();
						}
					});
				}

				function setMainValue() {
					let settings = $valueInput.data('settings');

					if ( 'undefined' === typeof settings.selectors) {
						return;
					}

					let $results = {
						devices: {}
					};

					var flag = false;

					$wrapper.find('.wd-slider').each(function() {
						let $this = $(this);

						if ( $this.attr('data-value') ) {
							flag = true;
						}

						$results.devices[$this.attr('data-device')] = {
							unit: $this.attr('data-unit'),
							value: $this.attr('data-value'),
						};
					});


					if ( flag ) {
						$valueInput.attr('value', window.btoa(JSON.stringify($results)));
					} else {
						$valueInput.attr('value', '');
					}
				}
			});
		});

		/**
		 * Update Active Class.
		 */
		function updateActiveClass($this) {
			$this.siblings().removeClass('xts-active');
			$this.addClass('xts-active');
		}
	});
})(jQuery);
