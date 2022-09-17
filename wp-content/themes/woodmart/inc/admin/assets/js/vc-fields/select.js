(function($) {
	$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
		initSelect();
	});

	$(document).on('woodmartResetTypography', function() {
		initSelect();
	});

	function initSelect() {
		$('.wd-select-fields').each(function() {
			let $wrapper = $(this);
			let $valueInput = $wrapper.find('.wpb_vc_param_value');
			let responsiveInherit = $wrapper.hasClass('wd-responsive-inherit');
			let settings = $valueInput.data('settings');

			$wrapper.find('.wd-device').on('click', function() {
				let $this = $(this);
				let device = $this.data('value');

				updateActiveClass($this);
				updateActiveClass($wrapper.find('.wd-select-wrapper[data-device="' + device + '"]'));
			});

			$wrapper.find('.wd-select-wrapper').each(function() {
				let $selectWrapper = $(this);
				let $select = $selectWrapper.find('.wd-select');

				if ($wrapper.hasClass('wd-style-select2')) {
					$select.select2({
						width      : '100%',
						allowClear : false,
						theme      : 'xts',
						tags       : true,
						placeholder: 'Select'
					});
				}

				setMainValue();

				$selectWrapper.find('.wd-select').on('change', function() {
					var $this = $(this);

					if ($this.hasClass('wd-select-placeholder')) {
						$this.removeClass('wd-select-placeholder');
					}

					setMainValue();
				});

				$selectWrapper.find('.wd-buttons-item').on('click', function() {
					let $this = $(this);

					if ($this.hasClass('xts-active') && responsiveInherit && $selectWrapper.data('device') !== 'desktop') {
						$this.removeClass('xts-active');
						$selectWrapper.find('.wd-select').val('');
					} else {
						$this.addClass('xts-active');
						$this.siblings().removeClass('xts-active');
						$selectWrapper.find('.wd-select').val($this.data('value'));
					}

					setMainValue();
				});

				function setMainValue() {
					if ('undefined' === typeof settings.selectors) {
						return;
					}

					let $results = {
						devices : {}
					};

					var flag = false;
					var currentOptionText = '';

					$wrapper.find('.wd-select-wrapper').each(function() {
						let $this = $(this);
						let $select = $this.find('.wd-select');
						var $optionPlaceholder = $select.find('.wd-option-placeholder');

						if (!flag && $optionPlaceholder.length) {
							$select.removeClass('wd-select-placeholder');
							$optionPlaceholder.remove();
						}

						if ($select.val()) {
							flag = true;
							currentOptionText = $select.find('option:selected').text();
						} else if (currentOptionText) {
							$select.addClass('wd-select-placeholder');
							$select.prepend(`<option class="wd-option-placeholder" value="" selected>${currentOptionText}</option>`);
						}

						$results.devices[$this.attr('data-device')] = {
							value: $select.val()
						};
					});

					if (flag) {
						$valueInput.attr('value', window.btoa(JSON.stringify($results)));
					} else {
						$valueInput.attr('value', '');
					}
					$valueInput.trigger('change');
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
	}
})(jQuery);
