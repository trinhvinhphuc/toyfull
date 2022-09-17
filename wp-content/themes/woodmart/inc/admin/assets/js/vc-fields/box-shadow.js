(function($) {
	$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
		$('.wd-box-shadow').each(function() {
			let $this = $(this);
			let $valueInput = $this.find('.wpb_vc_param_value');
			let settings = $valueInput.data('settings');

			if ('undefined' === typeof settings.selectors) {
				return;
			}

			var data = {};

			$this.find('.wd-text-input').each(function() {
				let $this = $(this);
				let id = $this.attr('id');

				$this.on('change', function() {
					data[id] = $this.val();
					setMainValue(data);
				}).trigger('change');
			});

			$this.find('.wd-color-input').wpColorPicker({
				change: function(event, ui) {
					data['color'] = ui.color.toString();
					setMainValue(data);
				},
				clear : function() {
					data['color'] = '';
					setMainValue(data);
				}
			});

			$this.find('.wd-color-input').wpColorPicker('color', $this.find('.wd-color-input').val());
			data['color'] = $this.find('.wd-color-input').val();
			setMainValue(data);

			function setMainValue(data) {
				let $results = {
					devices : {
						desktop: data
					}
				};

				console.log($results);

				$valueInput.attr('value', window.btoa(JSON.stringify($results)));
			}
		});
	});
})(jQuery);
