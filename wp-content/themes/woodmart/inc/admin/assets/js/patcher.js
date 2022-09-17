/* global woodmartConfig */

(function($) {
	'use strict';

	$(document).on('click', '.xts-patch-apply', function (e) {
		e.preventDefault();

		var $this = $(this);
		var patchesMap = $this.data('patches-map');
		var fileMap = [];

		for(var i = 0; i < patchesMap.length; i++) {
			fileMap[i] = 'woodmart/' + patchesMap[i];
		}

		var confirmation = confirm( 'These files will be updated: \r\r\n' + fileMap.join('\r\n') );

		if ( ! confirmation ) {
			return;
		}

		addLoading();
		cleanNotice();

		$.ajax({
			url    : woodmartConfig.ajaxUrl,
			data   : {
				action   : 'woodmart_patch_action',
				security : woodmartConfig.patcher_nonce,
				id       : $this.data('id'),
			},
			timeout: 1000000,
			error  : function() {
				printNotice('error', 'Something wrong with removing data. Please, try to remove data manually or contact our support center for further assistance.');
			},
			success: function(response) {
				if ( 'undefined' !== typeof response.message ) {
					printNotice(response.status, response.message);
				}

				if ( 'undefined' !== typeof response.status && 'success' === response.status ) {
					$this.parents('.xts-patch-item').addClass('xts-applied');
					updatePatcherCounter();
				}

				removeLoading();
			}
		});
	});

	// Helpers.
	function printNotice(type, message) {
		$('.xts-notices-wrapper').append(`
			<div class="xts-notice xts-${type}">
				${message}
			</div>
		`);

		setTimeout(function(){
			$('.xts-notice').addClass('xts-hidden');
		}, 7000);
	}

	function cleanNotice() {
		$('.xts-notices-wrapper').text('');
	}

	function addLoading() {
		$('.woodmart-box-content').addClass('xts-loading');
	}

	function removeLoading() {
		$('.woodmart-box-content').removeClass('xts-loading');
	}

	function updatePatcherCounter() {
		var $counter = $('.xts-patcher-counter');

		if ($counter.length) {
			var $count = parseInt($counter.find('.patcher-count').text());

			if ( 1 === $count ) {
				$counter.hide();
			} else {
				$counter.find('.patcher-count').text(--$count);
			}
		}
	}

})(jQuery);