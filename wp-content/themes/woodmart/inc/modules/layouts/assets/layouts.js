/* global woodmartConfig */
(function($) {
	'use strict';

	var $wrapper = $('.wd-layout, #wd-layout-conditions');
	var $template = $wrapper.find('.xts-layout-condition-template');
	var $form = $wrapper.find('form');
	var $popup = $wrapper.find('.xts-popup');
	var allowSubmit = true;

	// Form.
	$form.on('submit', function(e) {
		e.preventDefault();

		if ( allowSubmit ) {
			allowSubmit = false;
		} else {
			return false;
		}

		var data = [];
		var layoutType = $form.find('.xts-layout-type').val();
		var layoutName = $form.find('.xts-layout-name').val();

		$form.find('.xts-layout-condition').each(function() {
			var $condition = $(this);
			data.push({
				condition_comparison: $condition.find('.xts-layout-condition-comparison').val(),
				condition_type      : $condition.find('.xts-layout-condition-type').val(),
				condition_query     : $condition.find('.xts-layout-condition-query').val()
			});
		});

		$popup.addClass('xts-loading');

		$.ajax({
			url     : woodmartConfig.ajaxUrl,
			method  : 'POST',
			data    : {
				action         : 'wd_layout_create',
				data           : data,
				type           : layoutType,
				name           : layoutName,
				predefined_name: $form.find('.xts-layout-predefined-layout.xts-active').data('name'),
				security       : woodmartConfig.get_new_template_nonce
			},
			dataType: 'json',
			success : function(response) {
				window.location.href = response.redirect_url;
			},
			error: function() {
				$popup.find('.xts-layout-popup-notices').text('');
				$popup.find('.xts-layout-popup-notices').append('<div class="xts-notice xts-error">Something went wrong with the creation of the layout!</div>');
				$popup.removeClass('xts-loading');
			}
		});
	});

	// Change layout type.
	$form.find('.xts-layout-type').on('change', function() {
		var layoutType = $(this).val();

		$form.find('.xts-layout-condition').remove();

		$('.xts-layout-predefined-layouts').addClass('xts-hidden');
		$('.xts-layout-predefined-layout').removeClass('xts-active');

		if (!layoutType) {
			$wrapper.find('.xts-layout-condition-add').addClass('xts-hidden');
			$wrapper.find('.xts-layout-submit').addClass('xts-disabled');
			$wrapper.find('.xts-layout-conditions-title').addClass('xts-hidden');
		} else {
			$wrapper.find('.xts-layout-condition-add').removeClass('xts-hidden');
			$wrapper.find('.xts-layout-conditions-title').removeClass('xts-hidden');
			$wrapper.find('.xts-layout-submit').removeClass('xts-disabled');
			$wrapper.find('.xts-layout-condition-add').trigger('click');

			$('.xts-layout-predefined-layouts[data-type="' + layoutType + '"]').removeClass('xts-hidden');
		}

		if ( 'cart' === layoutType || 'checkout_form' === layoutType || 'checkout_content' === layoutType ) {
			$wrapper.find('.xts-layout-condition-add').addClass('xts-hidden');
			$wrapper.find('.xts-layout-conditions-title').addClass('xts-hidden');
			$form.find('.xts-layout-condition').addClass('xts-hidden');
		}
	});

	// Change condition type.
	$(document).on('change', '.xts-layout-condition-type', function() {
		var $this = $(this);
		var conditionType = $this.val();
		var $querySelect = $this.siblings('.xts-layout-condition-query');

		if ($querySelect.data('select2')) {
			$querySelect.val('');
			$querySelect.select2('destroy');
		}

		if ('all' === conditionType || 'shop_page' === conditionType || 'product_search' === conditionType || 'product_cats' === conditionType || 'product_tags' === conditionType || 'checkout_form' === conditionType || 'checkout_content' === conditionType || 'cart' === conditionType) {
			$querySelect.addClass('xts-hidden');
			$querySelect.removeAttr('data-query-type');
		} else {
			$querySelect.removeClass('xts-hidden');
			$querySelect.attr('data-query-type', conditionType);
			conditionQuerySelect2($querySelect);
		}
	});

	// Condition query select2.
	function conditionQuerySelect2($field) {
		$field.select2({
			ajax             : {
				url     : woodmartConfig.ajaxUrl,
				data    : function(params) {
					return {
						action    : 'wd_layout_conditions_query',
						security  : woodmartConfig.get_new_template_nonce,
						query_type: $field.attr('data-query-type'),
						search    : params.term
					};
				},
				method  : 'POST',
				dataType: 'json'
			},
			theme            : 'xts',
			dropdownAutoWidth: false,
			width            : 'resolve'
		});
	}

	// Condition add.
	$wrapper.find('.xts-layout-condition-add').on('click', function() {
		var layoutType = $form.find('.xts-layout-type').val();
		var $templateClone = $template.clone();

		$templateClone.find('.xts-layout-condition-type[data-type="' + layoutType + '"]').siblings('.xts-layout-condition-type').remove();

		$wrapper.find('.xts-layout-conditions .xts-layout-conditions-title').after($templateClone.html());
	});

	// Conditions edit add.
	$(document).on('click', '.xts-layout-conditions-edit-add', function() {
		var $this = $(this);
		var $wrapper = $this.parent();
		var layoutType = $wrapper.data('type');
		var $templateClone = $template.clone();

		$templateClone.find('.xts-layout-condition-type[data-type="' + layoutType + '"]').siblings('.xts-layout-condition-type').remove();

		$this.before($templateClone.html());
	});

	// Conditions edit.
	$(document).on('click', '.xts-layout-conditions-edit', function() {
		var $this = $(this);
		var $wrapper = $this.parents('.xts-popup-holder').find('.xts-layout-conditions');

		$this.parents('.xts-popup-holder').find('.xts-layout-popup-notices').text('');

		if ($wrapper.hasClass('xts-inited')) {
			return;
		}

		var conditions = $wrapper.data('conditions');
		var layoutType = $wrapper.data('type');

		if (conditions) {
			conditions.forEach(function(condition) {
				var $templateClone = $template.clone();

				$templateClone.find('.xts-layout-condition-type[data-type="' + layoutType + '"]').siblings('.xts-layout-condition-type').remove();

				$templateClone.find('.xts-layout-condition').attr('data-condition', JSON.stringify(condition));

				$wrapper.find('.xts-layout-conditions-edit-add').before($templateClone.html());
			});
		}

		$wrapper.find('.xts-layout-condition').each(function() {
			var $this = $(this);
			var condition = $this.data('condition');

			if (condition) {
				$this.find('.xts-layout-condition-comparison').val(condition.condition_comparison).trigger('change');
				$this.find('.xts-layout-condition-type').val(condition.condition_type).trigger('change');

				if (condition.condition_query_text) {
					$this.find('.xts-layout-condition-query').append('<option value="' + condition.condition_query + '">' + condition.condition_query_text + '</option>').val(condition.condition_query).trigger('change');
				}
			}
		});

		$wrapper.find('.xts-layout-conditions-edit-save').removeClass('xts-hidden');
		$wrapper.find('.xts-layout-conditions-edit-add').removeClass('xts-hidden');
		$wrapper.addClass('xts-inited');
	});

	// Conditions save.
	$(document).on('click', '.xts-layout-conditions-edit-save', function() {
		var $this = $(this);
		var $wrapper = $this.parents('.wd_layout_conditions, #wd-layout-conditions');
		var $popup = $wrapper.find('.xts-popup');
		var $conditionsWrapper = $wrapper.find('.xts-layout-conditions');

		var data = [];

		$wrapper.find('.xts-popup-holder .xts-layout-condition').each(function() {
			var $condition = $(this);
			data.push({
				condition_comparison: $condition.find('.xts-layout-condition-comparison').val(),
				condition_type      : $condition.find('.xts-layout-condition-type').val(),
				condition_query     : $condition.find('.xts-layout-condition-query').val()
			});
		});

		$popup.addClass('xts-loading');

		$.ajax({
			url     : woodmartConfig.ajaxUrl,
			method  : 'POST',
			data    : {
				action  : 'wd_layout_edit',
				data    : data,
				id      : $conditionsWrapper.data('id'),
				security: woodmartConfig.get_new_template_nonce
			},
			dataType: 'json',
			success : function() {
				$popup.find('.xts-layout-popup-notices').text('');
				$popup.find('.xts-layout-popup-notices').append('<div class="xts-notice xts-success">Conditions has been successfully saved!</div>');
				$popup.removeClass('xts-loading');
			},
			error: function() {
				$popup.find('.xts-layout-popup-notices').text('');
				$popup.find('.xts-layout-popup-notices').append('<div class="xts-notice xts-error">Something went wrong with editing the layout!</div>');
				$popup.removeClass('xts-loading');
			}
		});
	});

	// Condition remove.
	$(document).on('click', '.xts-layout-condition-remove', function() {
		$(this).parent().remove();
	});

	// Predefined.
	$('.xts-layout-predefined-layout').on('click', function() {
		var $this = $(this);
		$this.siblings().removeClass('xts-active');
		$this.toggleClass('xts-active');
	});

	// Popup.
	$('.page-title-action, .menu-icon-woodmart_layout li:not(.current) a').on('click', function(event) {
		event.preventDefault();
		$wrapper.find('.xts-popup-holder').addClass('xts-opened');
		$form.find('.xts-layout-type').trigger('change');

		setTimeout(function(){
			var $input = $form.find('.xts-layout-name');
			var strLength= $input.val().length;
			$input.trigger('focus');
			$input[0].setSelectionRange(strLength, strLength);
		}, 100);
	});
	$(document).on('click', '.xts-popup-opener', function() {
		$(this).parent().addClass('xts-opened');
	});
	$(document).on('click', '.xts-popup-close, .xts-popup-overlay', function() {
		$('.xts-popup-holder').removeClass('xts-opened');
	});
})(jQuery);