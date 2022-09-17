(function($) {
	$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
		$('.wd-colorpicker').each(function() {
			let $wrapper = $(this);
			let $valueInput = $wrapper.find('.wpb_vc_param_value');
			let settings = $valueInput.data('settings');

			setMainValue($wrapper.find('.wd-vc-colorpicker-input').val());

			$wrapper.find('.wd-vc-colorpicker-input').wpColorPicker({
				change: function(event, ui) {
					setMainValue(ui.color.toString());
				},
				clear : function() {
					setMainValue('');
				}
			});

			function setMainValue(color) {
				if ('undefined' === typeof settings.selectors) {
					return;
				}

				let $results = {
					devices : {
						desktop: {
							value: color
						}
					}
				};

				if (color) {
					$valueInput.attr('value', window.btoa(JSON.stringify($results)));
				} else {
					$valueInput.attr('value', '');
				}
			}
		});
	});
})(jQuery);
