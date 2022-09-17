/* global woodmartConfig */
(function($) {
	'use strict';

	var $importWrapper = $('.wd-import');
	var $boxContent = $('.woodmart-box-content');
	var $noticesArea = $boxContent.find('.xts-import-notices');
	var $noticesAreaRemove = $('.xts-popup').find('.xts-import-remove-notices');
	var $wizardFooter = $('.xts-wizard-footer');
	var $wizardWrapper = $('.xts-wizard-dummy');

	// Lazy loading.
	$boxContent.on('scroll', function() {
		$(document).trigger('wood-images-loaded');
	});

	// Import.
	$('.wd-import-item').each(function() {
		var $this = $(this);
		var clickVersion = $this.data('version');
		var clickType = $this.data('type');
		var $importBtn = $this.find('.wd-import-item-btn');
		var $progressBar = $this.find('.wd-import-progress-bar');
		var $progressBarPercent = $this.find('.wd-import-progress-bar-percent');
		var $wrapper = $('.wd-import-items');

		var progress1;
		var progress2;
		var progress3;
		var progress4;
		var progress5;
		var noticeTimeout;
		var errorTimeout;
		var interval;

		$importBtn.on('click', function(e) {
			e.preventDefault();

			var version;
			var type;
			var action = $(this).hasClass('xts-color-alt') ? 'activate' : 'import';


			$this.addClass('wd-loading-item');
			$wrapper.addClass('xts-loading');
			$wizardFooter.addClass('xts-disabled');

			clearNotices();

			if (!$importWrapper.hasClass('wd-base-imported') && 'version' === clickType) {
				startProgressBar('base');
				version = 'base';
				type = 'version';
			} else {
				startProgressBar('version');
				version = clickVersion;
				type = clickType;
			}

			runImport();

			function runImport() {
				var requests = [
					'xml',
					'images1',
					'images2',
					'images3',
					'images4',
					'other',
				];

				runRequest();

				function runRequest() {
					if (requests.length) {
						var process = requests.shift();

						if ( process.includes('images') && 'base' !== version ) {
							runRequest();

							return;
						}

						$.ajax({
							url    : woodmartConfig.ajaxUrl,
							data   : {
								action  : 'woodmart_import_action',
								version : version,
								type    : type,
								process : process,
								security: woodmartConfig.import_nonce,
							},
							timeout: 1000000,
							error  : function() {
								$this.removeClass('wd-loading-item');
								$wrapper.removeClass('xts-loading');
								$wizardFooter.removeClass('xts-disabled');

								endProgress();
								clearProgressBar();
								clearNotices();
								printNotice('error', 'AJAX import error. Try to disable all external plugins and run the import again. If it doesn\'t help, contact our support center for further assistance.');
							},
							success: function(response) {
								if (process === 'other') {
									$this.find('.wd-view-item-btn').attr('href', response.preview_url);
									$('.wd-import-remove-form-wrap').html(response.remove_html);
								}
							}
						}).then(runRequest);
					} else {
						initRemove();
						afterRemove();

						if ('base' === version) {
							version = clickVersion;
							type = clickType;
							runImport();

							$importWrapper.addClass('wd-base-imported');
							$wizardWrapper.addClass('imported-base');
						} else {
							updateProgress(100);
							clearNotices();

							if ('activate' === action) {
								printNotice('success', 'Demo version has been successfully activated!');
							} else {
								printNotice('success', 'Dummy content has been successfully imported!');
							}

							$this.addClass('wd-imported');
							$this.addClass('wd-view-page');
							$this.siblings().removeClass('wd-view-page');
							$wrapper.removeClass('xts-loading');
							$wizardFooter.removeClass('xts-disabled');

							setTimeout(function() {
								endProgress();
								clearProgressBar();
								$this.removeClass('wd-loading-item');
							}, 1000);
						}

						$importWrapper.addClass('wd-has-data');
					}
				}
			}
		});

		function startProgressBar(type) {
			var multiplier = 1;
			var multiplier2 = 1;

			if ('base' === type) {
				multiplier = 10;
				multiplier2 = 2;
			}

			progress1 = setTimeout(function() {
				updateProgress(10);
			}, 500 * multiplier2);

			progress2 = setTimeout(function() {
				updateProgress(25);
			}, 1000 * multiplier);

			progress3 = setTimeout(function() {
				updateProgress(50);
			}, 2000 * multiplier);

			progress4 = setTimeout(function() {
				updateProgress(70);
			}, 3500 * multiplier);

			progress5 = setTimeout(function() {
				updateProgress(80);
			}, 7500 * multiplier);

			noticeTimeout = setTimeout(function() {
				updateProgress(90);
				printNotice('info', 'Please, wait. The theme needs a bit more time than expected to import all the attachments.');
			}, 150000);

			errorTimeout = setTimeout(function() {
				clearNotices();
				printNotice('error', 'Something is wrong with the import and it can\'t be complete. Try to disable all external plugins and run the import again. If it doesn\'t help, contact our support center for further assistance.');
			}, 300000);
		}

		function updateProgress(progress) {
			var timeout = 100;

			function update(value) {
				$progressBar.attr('data-progress', value);
				$progressBar.css('width', value + '%');
				$progressBarPercent.text(value + '%');
			}

			if (progress === 100) {
				clearTimeout(progress1);
				clearTimeout(progress2);
				clearTimeout(progress3);
				clearTimeout(progress4);
				clearTimeout(progress5);
				timeout = 5;
			}

			var from = $progressBar.attr('data-progress');

			clearInterval(interval);

			interval = setInterval(function() {
				from++;

				update(from);

				if (from >= progress) {
					clearInterval(interval);
				}
			}, timeout);
		}

		function endProgress() {
			clearTimeout(progress1);
			clearTimeout(progress2);
			clearTimeout(progress3);
			clearTimeout(progress4);
			clearTimeout(progress5);
			clearTimeout(noticeTimeout);
			clearTimeout(errorTimeout);
			clearInterval(interval);
		}

		function clearProgressBar() {
			$progressBar.attr('data-progress', '0');
			$progressBar.css('width', '0%');
			$progressBarPercent.text('0%');
		}
	});

	// Search.
	$('.wd-import-search input').on('keyup', function() {
		var val = $(this).val().toLowerCase();

		$('.wd-import-item.wd-active').each(function() {
			var $this = $(this);
			var $data = $this.find('.wd-import-item-title').text().toLowerCase();

			if ($data.indexOf(val) > -1 || $this.data('tags').indexOf(val) > -1) {
				$this.removeClass('wd-search-hide').addClass('wd-search-show');
			} else {
				$this.addClass('wd-search-hide').removeClass('wd-search-show');
			}
		});

		$(document).trigger('wood-images-loaded');

		if (0 === $('.wd-search-show').length) {
			clearNotices();
			printNotice('info', 'Apologies, but no results were found.');
		} else {
			clearNotices();
		}
	});

	// Filters.
	$('.wd-import-cats .xts-set-item').on('click', function() {
		var $catItem = $(this);
		var type = $catItem.data('type');
		var $items = $('.wd-import-item');
		var $input = $('.wd-import-search input');

		$catItem.addClass('xts-active');
		$catItem.siblings().removeClass('xts-active');

		$(document).trigger('wood-images-loaded');

		// Reset.
		$input.val('');
		clearNotices();
		$items.removeClass('wd-search-hide').removeClass('wd-search-show');

		$items.each(function() {
			var $item = $(this);
			var itemType = $(this).data('type');

			if (type === itemType || (type === 'page' && itemType === 'element')) {
				$item.addClass('wd-active');
			} else {
				$item.removeClass('wd-active');
			}
		});
	});

	// Remove.
	function initRemove() {
		$('.wd-import-remove input').off('change').on('change', function() {
			var flag = false;
			$('.wd-import-remove input').each(function() {
				if ($(this).prop('checked')) {
					flag = true;
				}
			});
			if (flag) {
				$('.wd-import-remove-btn').removeClass('xts-disabled');
			} else {
				$('.wd-import-remove-btn').addClass('xts-disabled');
			}
		});
		$('.wd-import-remove-select').off('click').on('click', function(e) {
			e.preventDefault();

			$('.wd-import-remove input').each(function() {
				var $input = $(this);
				if ('disabled' !== $input.attr('disabled')) {
					$input.prop('checked', true);
				}
			});
			$('.wd-import-remove-btn').removeClass('xts-disabled');
		});
		$('.wd-import-remove-deselect').off('click').on('click', function(e) {
			e.preventDefault();

			$('.wd-import-remove input').prop('checked', false);
			$('.wd-import-remove-btn').addClass('xts-disabled');
		});
		$('.wd-import-remove-opener').off('click').on('click', function(e) {
			e.preventDefault();

			$('.wd-import-remove').addClass('xts-opened');
		});
		$('.xts-popup-close, .xts-popup-overlay').off('click').on('click', function(e) {
			e.preventDefault();

			$('.wd-import-remove').removeClass('xts-opened');
		});
		$('.wd-import-remove-btn').off('click').on('click', function(e) {
			e.preventDefault();
			var $holder = $('.xts-popup-holder');
			var data = $('.wd-import-remove-form').serializeArray();

			if (!data.length) {
				clearNotices();
				printNotice('info', 'Please, select what exactly do you want to remove from the dummy content.', 'remove');
				return;
			}

			var choice = confirm('Are you sure you want to remove the dummy content? All the changes you made in pages, products, posts, etc. will be lost.');

			if (!choice) {
				return;
			}

			clearNotices();
			$holder.addClass('xts-loading');

			$.ajax({
				url    : woodmartConfig.ajaxUrl,
				data   : {
					action  : 'woodmart_import_remove_action',
					security: woodmartConfig.import_remove_nonce,
					data    : data
				},
				timeout: 1000000,
				error  : function() {
					clearNotices();
					printNotice('error', 'Something wrong with removing data. Please, try to remove data manually or contact our support center for further assistance.', 'remove');
					$holder.removeClass('xts-loading');
				},
				success: function(response) {
					clearNotices();
					printNotice('success', 'Dummy content has been successfully removed!', 'remove');
					$('.wd-import-remove-form-wrap').html(response.content);
					$holder.removeClass('xts-loading');
					initRemove();
					afterRemove();
				}
			});
		});
	}

	initRemove();

	function afterRemove() {
		var flag = false;

		$('.wd-import-remove input').each(function() {
			var $input = $(this);
			var name = $input.attr('name');

			if ('page' === name && 'disabled' === $input.attr('disabled')) {
				$('.wd-imported').removeClass('wd-imported');
				$('.wd-view-page').removeClass('wd-view-page');
			}

			if ('disabled' !== $input.attr('disabled')) {
				flag = true;
			}
		});

		if (!flag) {
			$('.wd-base-imported').removeClass('wd-base-imported');
			$('.wd-has-data').removeClass('wd-has-data');
		}
	}

	// Wizard.
	function wizardDone() {
		var $dummy = $('.xts-setup-wizard').find('.xts-wizard-dummy');

		if ($dummy.length === 0) {
			return;
		}

		$('.xts-next, .xts-skip').on('click', function(e) {
			e.preventDefault();

			$('.xts-setup-wizard').addClass('xts-done');
			$('.xts-wizard-nav li[data-slug="done"]').removeClass('xts-disabled').addClass('xts-active');
			$('.xts-wizard-nav li[data-slug="dummy-content"]').removeClass('xts-active');
		});
	}

	wizardDone();

	// Helpers.
	function printNotice(type, text, location = 'import') {
		if ('remove' === location) {
			$noticesAreaRemove.append('<div class="xts-notice xts-' + type + '">' + text + '</div>');
		} else {
			$noticesArea.append('<div class="xts-notice xts-' + type + '">' + text + '</div>');
		}
	}

	function clearNotices() {
		$noticesArea.text('');
		$noticesAreaRemove.text('');
	}
})(jQuery);