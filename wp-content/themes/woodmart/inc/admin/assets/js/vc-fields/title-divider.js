(function($) {

	var $panel = $('#vc_ui-panel-edit-element');

	$panel.on('vcPanel.shown', function() {
		if (typeof tinyMCE !== 'undefined') {
			if (tinyMCE.get('wpb_tinymce_content')) {
				var _formated_content = tinyMCE.get('wpb_tinymce_content').getContent();
				_formated_content = _formated_content.replace(/<\/p><p>\s<\/p>/g, '</p>');
			}
			tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, 'wpb_tinymce_content');
		}

		$('.vc_wrapper-param-type-woodmart_title_divider').each(function() {
			var $divider = $(this);
			var $fields = $divider.nextUntil('.vc_wrapper-param-type-woodmart_title_divider, .vc_shortcode-param.woodmart-vc-no-wrap');
			var $wrapper = $('<div class="woodmart-td-wrapper"></div>');
			var $content = $('<div class="woodmart-td-content"></div>');

			$divider.before($wrapper);
			$wrapper.append($divider);

			if ($fields.length) {
				$content.append($fields);
				$wrapper.append($content);
			}
		});

		// Typography.
		$('.vc_wrapper-param-type-wd_fonts').each(function() {
			var $divider = $(this);
			var $fields = $divider.nextUntil('div[data-vc-shortcode-param-name*="_line_height"]');
			$fields = $fields.add($fields.last().next()).add($fields.first().prev());

			var $wrapper   = $('<div class="wd-typography-wrapper vc_col-xs-6 vc_column"></div>');
			var $content   = $('<div class="wd-typography-content xts-hidden"></div>');
			var $btn       = $('<button class="wd-typography-btn xts-btn">Edit</button>');
			var $title     = $('<div class="wpb_element_label">Typography</div>');
			var $btn_reset = $('<div class="wd-typography-btn-reset woodmart-hint woodmart-hint-right"><div class="woodmart-hint-content">Reset typography</div></div>');

			$divider.before($wrapper);
			$wrapper.append($title);
			$wrapper.append($btn);

			if ( checkIsSelectedTypography( $fields ) ) {
				$btn.addClass('xts-changed');
			}

			if ($fields.length) {
				$content.append($btn_reset);
				$content.append($divider);
				$content.append($fields);
				$wrapper.append($content);
			}

			$btn.on('click', function(){
				var $this = $(this);

				$this.addClass('xts-changed');

				$this.siblings('.wd-typography-content').toggleClass('xts-hidden');

				$(document).on('mouseup', function(e) {
					var $typographyContent = $this.siblings('.wd-typography-content');

					if (!$typographyContent.is(e.target) && $typographyContent.has(e.target).length === 0 && !$this.is(e.target) && !$('.vc_ui-panel-content-container').is(e.target)) {
						$this.siblings('.wd-typography-content').addClass('xts-hidden');
						$(document).off('mouseup');
					}
				})
			});

			$btn_reset.on( 'click', function () {
				var $this = $(this);

				$this.parent().find('.vc_shortcode-param').each( function () {
					var $this = $(this);
					var settings = $this.find('.wpb_vc_param_value').data('settings');
					var wrapperSelect = $this.find('.wd-select-wrapper');
					var wrapperSlider = $this.find('.wd-slider');
					var desktopValue = '';
					var tabletValue = '';
					var mobileValue = '';

					if ( 'undefined' !== typeof settings.default ) {
						var defaultValue = settings.default;

						if ( 'undefined' !== typeof defaultValue.desktop && 'undefined' !== typeof defaultValue.desktop.value ) {
							desktopValue = defaultValue.desktop.value;
						}

						if ( 'undefined' !== typeof defaultValue.tablet && 'undefined' !== typeof defaultValue.tablet.value ) {
							tabletValue = defaultValue.tablet.value;
						}

						if ( 'undefined' !== typeof defaultValue.mobile && 'undefined' !== typeof defaultValue.mobile.value ) {
							mobileValue = defaultValue.mobile.value;
						}
					}

					if ( 0 < wrapperSelect.length ) {
						wrapperSelect.each( function () {
							var $this = $(this);
							var $select = $this.find('.wd-select');
							var device = $this.data('device');

							if ( 'desktop' === device ) {
								$select.val( desktopValue );
							}

							if ( 'tablet' === device ) {
								$select.val( tabletValue );
							}

							if ( 'mobile' === device ) {
								$select.val( mobileValue );
							}
						});
					}

					if ( 0 < wrapperSlider.length ) {
						wrapperSlider.each( function () {
							var $this = $(this);
							var $input = $this.find('.wd-slider-value-preview');
							var device = $this.data('device');

							if ( 'desktop' === device ) {
								$input.val( desktopValue ).trigger('change');
							}

							if ( 'tablet' === device ) {
								$input.val( tabletValue ).trigger('change');
							}

							if ( 'mobile' === device ) {
								$input.val( mobileValue ).trigger('change');
							}
						});
					}

				});

				$(document).trigger('woodmartResetTypography');
				$this.parent().siblings('.wd-typography-btn').removeClass('xts-changed');
				$this.parent().addClass('xts-hidden');
			});
		});

		if (typeof tinyMCE !== 'undefined') {
			tinyMCE.EditorManager.execCommand('mceAddEditor', true, 'wpb_tinymce_content');
			if (typeof _formated_content !== typeof undefined) {
				tinyMCE.get('wpb_tinymce_content').setContent(_formated_content);
			}
		}

		$panel.trigger('woodDivider.added');
	});

	function hideDividerWrapper($divider) {
		var $wrapper = $divider.parent('.woodmart-td-wrapper');
		if ($divider.hasClass('vc_dependent-hidden')) {
			$wrapper.addClass('vc_dependent-hidden');
		} else {
			$wrapper.removeClass('vc_dependent-hidden');
		}
	}

	$panel.on('change', '.wpb_el_type_woodmart_title_divider', function() {
		hideDividerWrapper($(this));
	});

	$panel.on('woodDivider.added', function() {
		$('.wpb_el_type_woodmart_title_divider').each(function() {
			hideDividerWrapper($(this));
		});
	});

	function checkIsSelectedTypography( $elements ) {
		var flag = false;

		$elements.each( function () {
			if ($(this).find('.wpb_vc_param_value').val()) {
				flag = true;
			}
		});

		return flag;
	}

})(jQuery);
