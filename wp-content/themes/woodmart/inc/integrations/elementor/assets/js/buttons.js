jQuery(window).on('elementor:init', function() {
	var buttons = elementor.modules.controls.BaseData.extend({
		onReady: function() {
			var self = this;
			var $set = self.$el.find('.xts-btns-set');
			$set.on('click', '.xts-set-item', function() {
				var $btn = jQuery(this);
				if ($btn.hasClass('xts-active')) {
					return;
				}
				var val = $btn.data('value');

				$set.find('.xts-active').
					removeClass('xts-active');

				$btn.addClass('xts-active');

				self.ui.input.val(val);
				self.saveValue();
			});

		},

		saveValue: function() {
			this.setValue(this.ui.input.val());
		},

		onBeforeDestroy: function() {
			this.saveValue();
		},
	});
	elementor.addControlView('wd_buttons', buttons);
});
