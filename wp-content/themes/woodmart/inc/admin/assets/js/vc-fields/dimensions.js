(function($) {
	$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
		$('.wd-dimensions').each(function() {
			let $wrapper = $(this);
			let $valueInput = $wrapper.find('.wpb_vc_param_value');
			let settings = $valueInput.data('settings');

			$wrapper.find('.wd-device').on( 'click', function() {
				let $this = $(this);
				let device = $this.data('value');

				updateActiveClass($this);
				updateActiveClass($wrapper.find('.wd-dimension[data-device="'+ device +'"]'));
			});

			$wrapper.find('.wd-dimension').each(function() {
				let $this = $(this);

				setMainValue();

				$this.find('.wd-dimension-field-value').each(function() {
					let $thisValue = $(this).find('.wd-dimension-field-value-display');

					$thisValue.on('change', function(){
						setMainValue();
					});
				});

				$this.find('.wd-dimension-unit-control').on( 'click', function() {
					let count_unit = [];

					$.each( settings.range, function(key) {
						count_unit.push(key);
					});

					if ( 1 === count_unit.length ) {
						return;
					}

					let $this = $(this);

					updateActiveClass($this);
					$this.parents('.wd-dimension').data('unit', $this.data('unit'));
					$this.parent().siblings().find('input').val('');
					setMainValue();
				});

				function setMainValue() {
					if ('undefined' === typeof settings.selectors) {
						return;
					}

					let $results = {
						devices: {},
					};

					var flag = false;

					$wrapper.find('.wd-dimension').each(function() {
						let $this = $(this);

						if ($this.find('input[data-id="top"]').val() || $this.find('input[data-id="right"]').val() || $this.find('input[data-id="bottom"]').val() || $this.find('input[data-id="left"]').val()) {
							flag = true;
						}

						$results.devices[$this.data('device')] = {
							top   : $this.find('input[data-id="top"]').val(),
							right : $this.find('input[data-id="right"]').val(),
							bottom: $this.find('input[data-id="bottom"]').val(),
							left  : $this.find('input[data-id="left"]').val(),
							unit  : $this.data('unit'),
						};
					});

					if (flag) {
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
