var woodmartAdminModule, woodmart_media_init;

(function($) {
	'use strict';

	woodmartAdminModule = (function() {

		var woodmartAdmin = {
			wizardInstallPlugins: function() {
				var checkPlugin = function($link, callback) {
					setTimeout(function() {
						$.ajax({
							url    : woodmartConfig.ajaxUrl,
							method : 'POST',
							data   : {
								action    : 'woodmart_check_plugins',
								xts_plugin: $link.data('plugin'),
								xts_builder: $link.data('builder'),
								security: woodmartConfig.check_plugins_nonce,
							},
							success: function(response) {
								if ('success' === response.status) {
									changeNextButtonStatus(response.data.required_plugins);
									changePageStatus(response.data.is_all_activated);
								} else {
									woodmartAdmin.addNotice($('.xts-plugin-response'), 'warning', response.message);
									removeLinkClasses($link);
									woodmartAdmin.hideNotice();
								}

								callback(response);
							}
						});
					}, 1000);
				};

				var activatePlugin = function($link, callback) {
					$.ajax({
						url    : xtsPluginsData[$link.data('plugin')]['activate_url'].replaceAll('&amp;', '&'),
						method : 'GET',
						success: function() {
							checkPlugin($link, function(response) {
								if ('success' === response.status) {
									if ('activate' === response.data.status) {
										activatePlugin($link, callback);
									} else {
										removeLinkClasses($link);
										changeLinkAction('activate', 'deactivate', $link, response);
										changeLinkAction('install', 'deactivate', $link, response);
										changeLinkAction('update', 'deactivate', $link, response);
										callback();
									}
								}
							});
						}
					});
				};

				var deactivatePlugin = function($link) {
					$.ajax({
						url    : woodmartConfig.ajaxUrl,
						method : 'POST',
						data   : {
							action    : 'woodmart_deactivate_plugin',
							xts_plugin: $link.data('plugin'),
							xts_builder: $link.data('builder'),
							security: woodmartConfig.deactivate_plugin_nonce,
						},
						success: function(response) {
							if ('error' === response.status) {
								woodmartAdmin.addNotice($('.xts-plugin-response'), 'warning', response.message);
								removeLinkClasses($link);
								woodmartAdmin.hideNotice();
								return;
							}

							checkPlugin($link, function(response) {
								if ('success' === response.status) {
									if ('activate' === response.data.status) {
										removeLinkClasses($link);
										changeLinkAction('deactivate', 'activate', $link, response);
									} else {
										deactivatePlugin($link);
									}
								}
							});
						}
					});
				};

				function parsePlugins($link, callback) {
					$.ajax({
						url    : $link.attr('href'),
						method : 'POST',
						success: function() {
							setTimeout(function() {
								checkPlugin($link, function(response) {
									if ('success' === response.status) {
										if ('activate' === response.data.status) {
											activatePlugin($link, callback);
										} else {
											removeLinkClasses($link);
											changeLinkAction('activate', 'deactivate', $link, response);
											callback();
										}
									}
								});
							}, 1000);
						}
					});
				}

				function addLinkClasses($link) {
					$link.parents('.xts-plugin-wrapper').addClass('xts-loading');
					$link.parents('.xts-plugin-wrapper').siblings().addClass('xts-disabled');
					$('.xts-wizard-footer').addClass('xts-disabled');

					$link.text(woodmartConfig[$link.data('action') + '_process_plugin_btn_text']);
				}

				function removeLinkClasses($link) {
					$link.parents('.xts-plugin-wrapper').removeClass('xts-loading');
					$link.parents('.xts-plugin-wrapper').siblings().removeClass('xts-disabled');
					$('.xts-wizard-footer').removeClass('xts-disabled');
				}

				function changeNextButtonStatus(status) {
					var $nextBtn = $('.xts-next');
					if ('has_required' === status) {
						$nextBtn.addClass('xts-disabled');
					} else {
						$nextBtn.removeClass('xts-disabled');
					}
				}

				function changePageStatus(status) {
					var $page = $('.xts-plugins');
					if ('yes' === status) {
						$page.addClass('xts-all-active');
					} else {
						$page.removeClass('xts-all-active');
					}
				}

				function changeLinkAction(actionBefore, actionAfter, $link, response) {
					if (response && response.data.version) {
						$link.parents('.xts-plugin-wrapper').find('.xts-plugin-version span').text(response.data.version);
					}

					$link.removeClass('xts-' + actionBefore + '-now').addClass('xts-' + actionAfter + '-now');
					$link.attr('href', xtsPluginsData[$link.data('plugin')][actionAfter + '_url'].replaceAll('&amp;', '&'));
					$link.data('action', actionAfter);
					$link.text(woodmartConfig[actionAfter + '_plugin_btn_text']);
				}

				$(document).on('click', '.xts-ajax-plugin:not(.xts-deactivate-now)', function(e) {
					e.preventDefault();

					var $link = $(this);
					addLinkClasses($link);
					parsePlugins($link, function() {});
				});

				$(document).on('click', '.xts-deactivate-now', function(e) {
					e.preventDefault();

					var $link = $(this);
					addLinkClasses($link);
					deactivatePlugin($link);
				});

				$(document).on('click', '.xts-wizard-all-plugins', function(e) {
					e.preventDefault();

					var itemQueue = [];

					function activationAction() {
						if (itemQueue.length) {
							var $link = $(itemQueue.shift());

							addLinkClasses($link);

							parsePlugins($link, function() {
								activationAction();
							});
						}
					}

					$('.xts-plugin-wrapper .xts-ajax-plugin:not(.xts-deactivate-now)').each(function() {
						itemQueue.push($(this));
					});

					activationAction();
				});
			},

			wizardBuilderSelect: function() {
				$('.xts-wizard-builder-select > div').on('click', function() {
					var $this = $(this);
					var builder = $(this).data('builder');

					$this.addClass('xts-active');
					$this.siblings().removeClass('xts-active');
					$('.xts-btn.xts-' + builder).removeClass('xts-hidden').addClass('xts-shown').siblings('.xts-next').addClass('xts-hidden').removeClass('xts-shown');
				});
			},

			wizardInstallChildTheme: function() {
				$('.xts-install-child-theme').on('click', function(e) {
					e.preventDefault();
					var $btn = $(this);
					var $responseSelector = $('.xts-child-theme-response');

					$btn.addClass('xts-loading');

					$.ajax({
						url     : woodmartConfig.ajaxUrl,
						method  : 'POST',
						data    : {
							action: 'woodmart_install_child_theme',
							security: woodmartConfig.install_child_theme_nonce,
						},
						dataType: 'json',
						success : function(response) {
							$btn.removeClass('xts-loading');

							if (response && 'success' === response.status) {
								$('.xts-wizard-child-theme').addClass('xts-installed');
							} else if (response && 'dir_not_exists' === response .status) {
								woodmartAdmin.addNotice($responseSelector, 'error', 'The directory can\'t be created on the server. Please, install the child theme manually or contact our support for help.');
							} else {
								woodmartAdmin.addNotice($responseSelector, 'error', 'The child theme can\'t be installed. Skip this step and install the child theme manually via Appearance -> Themes.');
							}
						},
						error   : function() {
							$btn.removeClass('xts-loading');

							woodmartAdmin.addNotice($responseSelector, 'error', 'The child theme can\'t be installed. Skip this step and install the child theme manually via Appearance -> Themes.');
						}
					});
				});
			},

			addNotice: function($selector, $type, $message) {
				$selector.html('<div class="xts-notice xts-' + $type + '">' + $message + '</div>').fadeIn();

				woodmartAdmin.hideNotice();
			},

			hideNotice: function() {
				var $notice = $('.xts-notice:not(.xts-info)');

				$notice.each(function() {
					var $notice = $(this);
					setTimeout(function() {
						$notice.addClass('xts-hidden');
					}, 10000);
				});

				$notice.on('click', function() {
					$(this).addClass('xts-hidden');
				});
			},

			listElement: function() {
				var $editor = $('#vc_ui-panel-edit-element');

				$editor.on('vcPanel.shown', function() {
					if ($editor.attr('data-vc-shortcode') != 'woodmart_list') {
						return;
					}

					var $groupField        = $editor.find('[data-param_type="param_group"]'),
					    $groupFieldOpenBtn = $groupField.find('.column_toggle:first');

					setTimeout(function() {
						$groupFieldOpenBtn.click();
					}, 300);
				});
			},

			sizeGuideInit: function() {
				if ($.fn.editTable) {
					$('.woodmart-sguide-table-edit').each(function() {
						$(this).editTable();
					});
				}
			},

			variationGallery: function() {

				$('#woocommerce-product-data').on('woocommerce_variations_loaded', function() {

					$('.woodmart-variation-gallery-wrapper').each(function() {

						var $this = $(this);
						var $galleryImages = $this.find('.woodmart-variation-gallery-images');
						var $imageGalleryIds = $this.find('.variation-gallery-ids');
						var galleryFrame;

						$this.find('.woodmart-add-variation-gallery-image').on('click', function(event) {
							event.preventDefault();

							// If the media frame already exists, reopen it.
							if (galleryFrame) {
								galleryFrame.open();
								return;
							}

							// Create the media frame.
							galleryFrame = wp.media.frames.product_gallery = wp.media({
								states: [
									new wp.media.controller.Library({
										filterable: 'all',
										multiple  : true
									})
								]
							});

							// When an image is selected, run a callback.
							galleryFrame.on('select', function() {
								var selection = galleryFrame.state().get('selection');
								var attachment_ids = $imageGalleryIds.val();

								selection.map(function(attachment) {
									attachment = attachment.toJSON();

									if (attachment.id) {
										var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
										attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;

										$galleryImages.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '"><a href="#" class="delete woodmart-remove-variation-gallery-image"><span class="dashicons dashicons-dismiss"></span></a></li>');

										$this.trigger('woodmart_variation_gallery_image_added');
									}
								});

								$imageGalleryIds.val(attachment_ids);

								$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
								$('#variable_product_options').find('input').eq(0).trigger('change');

							});

							// Finally, open the modal.
							galleryFrame.open();
						});

						// Image ordering.
						if (typeof $galleryImages.sortable !== 'undefined') {
							$galleryImages.sortable({
								items               : 'li.image',
								cursor              : 'move',
								scrollSensitivity   : 40,
								forcePlaceholderSize: true,
								forceHelperSize     : false,
								helper              : 'clone',
								opacity             : 0.65,
								placeholder         : 'wc-metabox-sortable-placeholder',
								start               : function(event, ui) {
									ui.item.css('background-color', '#f6f6f6');
								},
								stop                : function(event, ui) {
									ui.item.removeAttr('style');
								},
								update              : function() {
									var attachment_ids = '';

									$galleryImages.find('li.image').each(function() {
										var attachment_id = $(this).attr('data-attachment_id');
										attachment_ids = attachment_ids + attachment_id + ',';
									});

									$imageGalleryIds.val(attachment_ids);

									$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
									$('#variable_product_options').find('input').eq(0).trigger('change');
								}
							});
						}

						// Remove images.
						$(document).on('click', '.woodmart-remove-variation-gallery-image', function(event) {
							event.preventDefault();
							$(this).parent().remove();

							var attachment_ids = '';

							$galleryImages.find('li.image').each(function() {
								var attachment_id = $(this).attr('data-attachment_id');
								attachment_ids = attachment_ids + attachment_id + ',';
							});

							$imageGalleryIds.val(attachment_ids);

							$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
							$('#variable_product_options').find('input').eq(0).trigger('change');
						});

					});

				});
			},

			product360ViewGallery: function() {

				// Product gallery file uploads.
				var product_gallery_frame;
				var $image_gallery_ids = $('#product_360_image_gallery');
				var $product_images = $('#product_360_images_container').find('ul.product_360_images');

				$('.add_product_360_images').on('click', 'a', function(event) {
					var $el = $(this);

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if (product_gallery_frame) {
						product_gallery_frame.open();
						return;
					}

					// Create the media frame.
					product_gallery_frame = wp.media.frames.product_gallery = wp.media({
						// Set the title of the modal.
						title : $el.data('choose'),
						button: {
							text: $el.data('update')
						},
						states: [
							new wp.media.controller.Library({
								title     : $el.data('choose'),
								filterable: 'all',
								multiple  : true
							})
						]
					});

					// When an image is selected, run a callback.
					product_gallery_frame.on('select', function() {
						var selection = product_gallery_frame.state().get('selection');
						var attachment_ids = $image_gallery_ids.val();

						selection.map(function(attachment) {
							attachment = attachment.toJSON();

							if (attachment.id) {
								attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
								var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

								$product_images.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>');
							}
						});

						$image_gallery_ids.val(attachment_ids);
					});

					// Finally, open the modal.
					product_gallery_frame.open();
				});

				// Image ordering.
				if (typeof $product_images.sortable !== 'undefined') {
					$product_images.sortable({
						items               : 'li.image',
						cursor              : 'move',
						scrollSensitivity   : 40,
						forcePlaceholderSize: true,
						forceHelperSize     : false,
						helper              : 'clone',
						opacity             : 0.65,
						placeholder         : 'wc-metabox-sortable-placeholder',
						start               : function(event, ui) {
							ui.item.css('background-color', '#f6f6f6');
						},
						stop                : function(event, ui) {
							ui.item.removeAttr('style');
						},
						update              : function() {
							var attachment_ids = '';

							$('#product_360_images_container').find('ul li.image').css('cursor', 'default').each(function() {
								var attachment_id = $(this).attr('data-attachment_id');
								attachment_ids = attachment_ids + attachment_id + ',';
							});

							$image_gallery_ids.val(attachment_ids);
						}
					});
				}

				// Remove images.
				$('#product_360_images_container').on('click', 'a.delete', function() {
					$(this).closest('li.image').remove();

					var attachment_ids = '';

					$('#product_360_images_container').find('ul li.image').css('cursor', 'default').each(function() {
						var attachment_id = $(this).attr('data-attachment_id');
						attachment_ids = attachment_ids + attachment_id + ',';
					});

					$image_gallery_ids.val(attachment_ids);

					// Remove any lingering tooltips.
					$('#tiptip_holder').removeAttr('style');
					$('#tiptip_arrow').removeAttr('style');

					return false;
				});
			},

			imageHotspot: function() {
				$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
					var _this = $(this);
					var shortcode = _this.data('vc-shortcode');

					if (shortcode != 'woodmart_image_hotspot' && shortcode != 'woodmart_hotspot') {
						return;
					}

					var _background_id = vc.shortcodes.findWhere({id: vc.active_panel.model.attributes.parent_id}).attributes.params.img;
					var preview = '.woodmart-image-hotspot-preview';

					$(preview).addClass('loading');
					$.ajax({
						url     : woodmartConfig.ajaxUrl,
						dataType: 'json',
						data    : {
							image_id: _background_id,
							action  : 'woodmart_get_hotspot_image',
							security: woodmartConfig.get_hotspot_image_nonce
						},
						success : function(response) {
							$(preview).removeClass('loading');

							if (response.status == 'success') {
								_this.find('.woodmart-image-hotspot-image').append(response.html).fadeIn(500);
								$(preview).css('min-width', _this.find('.woodmart-hotspot-img').outerWidth());
							} else if (response.status == 'warning') {
								$('.woodmart-image-hotspot-preview').remove();
								$('.woodmart-image-hotspot-position').after(response.html);
							}
						},
						error   : function(response) {
							console.log('ajax error');
						}
					});
				});
			},

			vcTemplatesLibrary: function() {
				var $head   = $('.woodmart-templates-heading'),
				    $list   = $('.woodmart-templates-list'),
				    $search = $head.find('.woodmart-templates-search');

				$search.on('keyup', function(e) {
					var val = $(this).val().toLowerCase();

					$list.find('.woodmart-template-item').each(function() {
						var $this = $(this);

						if (($this.attr('data-template_name') + $this.attr('data-template_title')).toLowerCase().indexOf(val) > -1) {
							$this.removeClass('hide-by-search').addClass('show-by-search');
						} else {
							$this.addClass('hide-by-search').removeClass('show-by-search');
						}
					});
				});

				/* filters */

				$list.on('click', '.woodmart-templates-tags a', function(e) {
					e.preventDefault();

					var slug = $(this).data('slug');

					$(this).parent().parent().find('.active-tag').removeClass('active-tag');
					$(this).parent().addClass('active-tag');

					$list.find('.woodmart-template-item').each(function() {
						var $this = $(this);

						if ($this.hasClass('tag-' + slug)) {
							$this.removeClass('hide-by-tag').addClass('show-by-tag');
						} else {
							$this.addClass('hide-by-tag').removeClass('show-by-tag');
						}
					});

				});

				/* loader function */

				$list.on('click', '[data-template-handler]', function() {
					$list.addClass('xts-loading element-adding');
				});

				var $vcTemplatesBtn = $('#vc_templates-editor-button, #vc_templates-more-layouts'),
				    templatesLoaded = false,
				    templates;

				$vcTemplatesBtn.on('click', function() {

					setTimeout(function() {
						$list.find('.woodmart-template-item').show();

						if ($list.hasClass('element-adding')) {
							$list.removeClass('element-adding xts-loading');
						}

						$search.val('');
						loadTemplates();
					}, 100);

				});

				$('#vc_inline-frame').on('load', function() {
					var iframeBody = $('body', $('#vc_inline-frame')[0].contentWindow.document);

					$(iframeBody).on('click', '#vc_templates-more-layouts', function() {
						$list.find('.woodmart-template-item').show();

						if ($list.hasClass('element-adding')) {
							$list.removeClass('element-adding xts-loading');
						}

						$search.val('');
						loadTemplates();
					});
				});

				function loadTemplates() {
					if (templatesLoaded) {
						return;
					}
					templatesLoaded = true;

					$.ajax({
						url        : woodmartConfig.demoAjaxUrl,
						data       : {
							action: 'woodmart_load_templates'
						},
						dataType   : 'json',
						crossDomain: true,
						method     : 'POST',
						success    : function(data) {
							if (data.count > 0) {
								renderElements(data.elements);
								renderTags(data.tags, data.count);
							}

						},
						error      : function(err) {
							$('.woodmart-templates-list').prepend('Can\'t load templates from the server.').removeClass('xts-loading');
							console.log('can\'t load templates from the server', err);
						}
					});

				}

				function renderTags(tags, count) {
					var html = '';
					Object.keys(tags).map(function(objectKey, index) {
						var tag = tags[objectKey];
						html = html + renderTag(tag);
					});
					html = '<div class="woodmart-templates-tags"><ul><li class="active-tag"><a href="#all" data-slug="all"><span class="tab-preview-name">All</span> <span class="tab-preview-count">' + count + '</span></a></li>' + html + '</ul></div>';
					// console.log(html)
					$('.woodmart-templates-list').prepend(html);
				}

				function renderTag(tag) {
					var html = '';
					html += '<li><a href="#' + tag.slug + '" data-slug="' + tag.slug + '"><span class="tab-preview-name">' + tag.title + '</span> <span class="tab-preview-count">' + tag.count + '</span></a></li>';

					return html;
				}

				function renderElements(elements) {
					var html = '';
					Object.keys(elements).map(function(objectKey, index) {
						var element = elements[objectKey];
						html = renderElement(element) + html;
					});
					// console.log(html)
					$('.woodmart-templates-list').prepend(html).removeClass('xts-loading');
				}

				function renderElement(element) {
					var html = '';
					html += '<div class="woodmart-template-item ' + element.class + '" data-template_id="' + element.id + '" data-template_unique_id="' + element.id + '" data-template_name="' + element.slug + '" data-template_type="woodmart_templates"  data-template_title="' + element.title + '" data-vc-content=".vc_ui-template-content">';
					html += '<div class="woodmart-template-image">';
					html += '<img src="' + element.image + '" title="' + element.title + '" alt="' + element.title + '" />';
					html += '<div class="woodmart-template-actions">';
					html += '<a class="woodmart-template-preview" label="Preview this template" title="Preview this template" href="' + element.link + '" target="_blank">Preview</a>';
					html += '<a class="woodmart-template-add" label="Add this template" title="Add this template" data-template-handler="">Add template</a>';
					html += '</div>';
					html += '</div>';
					html += '<h3 class="woodmart-template-title">' + element.title + '</h3>';
					// html += '<div class="woodmart-template-preview"><a href="' + element.link + '" target="_blank">preview</a></div>';
					// html += '<div class="vc_ui-template-content" data-js-content>';
					// html += '</div>';
					html += '</div>';

					return html;
				}

			},

			cssGenerator: function() {
				// General.
				var $form = $('.woodmart-generator-form');
				$form.on('change', '[type=\"checkbox\"]', prepare);
				prepare();

				// Extra section.
				// var $wcExtraInput = $('input[name="wooComm"]');
				// var $wcExtraSection = $('.woodmart-woo-extra');
				// $wcExtraInput.on('change', function () {
				//     if ($(this).prop('checked')) {
				//         $wcExtraSection.find("[type=\"checkbox\"]").prop('checked', 'checked');
				//     } else {
				//         $wcExtraSection.find("[type=\"checkbox\"]").prop('checked', '');
				//     }
				// });
				//
				// $wcExtraSection.find("[type=\"checkbox\"]").on('change', function () {
				//     if ( ! $wcExtraInput.prop('checked') ) {
				//         $wcExtraInput.prop('checked', 'checked');
				//     }
				//     var checked = false;
				//
				//     setTimeout(function () {
				//         $wcExtraSection.find('.css-checkbox').each(function() {
				//             var $input = $(this).find("[type=\"checkbox\"]");
				//
				//             if ($input.prop('checked') ) {
				//                 checked = true;
				//             }
				//         });
				//
				//         if ( ! checked ) {
				//             $wcExtraInput.prop('checked', '');
				//         }
				//     }, 100);
				// });

				// General.
				function prepare() {
					var fields = {};
					var $this = $(this);
					var id = $this.attr('id');
					var checked = $this.prop('checked');
					var $children = $form.find('[data-parent="' + id + '"] [type=\"checkbox\"]');

					$children.prop('checked', checked);

					var parentChecked = function($this) {
						$form.find('[name="' + $this.parent().data('parent') + '"]').each(function() {
							$(this).prop('checked', 'checked');
							if ('none' !== $(this).parent().data('parent')) {
								parentChecked($(this));
							}
						});
					};

					if ('none' !== $this.parent().data('parent')) {
						parentChecked($(this));
					}

					var uncheckedEmpty = function($this) {
						var id = $this.parent().data('parent');
						var $children = $form.find('[data-parent="' + id + '"]');

						// if ( 'wooComm' === id ) {
						//     Object.assign($children, $('.woodmart-woo-extra').find('.css-checkbox'));
						// }
						// console.log(id);

						if ($children.length > 0) {
							var checked = false;

							$children.each(function() {
								if ($(this).find('[type="checkbox"]').prop('checked')) {
									checked = true;
								}
							});

							if (!checked) {
								$form.find('[name="' + id + '"]').prop('checked', '');
								uncheckedEmpty($form.find('[name="' + id + '"]'));
							}
						}
					};

					uncheckedEmpty($(this));

					$form.find('[type="checkbox"]').each(function() {
						// if ($(this).parents('.woodmart-column').hasClass('woodmart-woo-extra')) {
						//     if ( $('input[name="wooComm"]').prop('checked') ) {
						//         fields[$(this).prop('name')] = $(this).prop('checked') ? true : false;
						//     } else {
						//         fields[$(this).prop('name')] = false;
						//     }
						//     return true;
						// }

						fields[this.name] = $(this).prop('checked') ? true : false;
					});

					var base64 = btoa(JSON.stringify(fields));

					$form.find('[name="css-data"]').val(base64);
				}

				$('.css-update-button').on('click', function(e) {
					e.preventDefault();
					$form.find('[name="generate-css"]').click();
				});

				$form.on('click', '[name="generate-css"]', function() {
					$form.parents('.woodmart-box-content').addClass('xts-loading');
				});
			},

			whiteLabel: function() {
				setTimeout(function() {
					$('.theme').on('click', function() {
						themeClass();
					});
					themeClass();

					function themeClass() {
						var $name = $('.theme-overlay .theme-name');
						if ($name.text().includes('woodmart') || $name.text().includes('Woodmart')) {
							$('.theme-overlay').addClass('wd-woodmart-theme');
						} else {
							$('.theme-overlay').removeClass('wd-woodmart-theme');
						}
					}
				}, 500);
			}
		};

		return {
			init: function() {

				$(document).ready(function() {
					woodmartAdmin.listElement();
					woodmartAdmin.sizeGuideInit();
					woodmartAdmin.product360ViewGallery();
					woodmartAdmin.variationGallery();
					woodmartAdmin.vcTemplatesLibrary();
					woodmartAdmin.cssGenerator();
					woodmartAdmin.whiteLabel();
					woodmartAdmin.wizardInstallChildTheme();
					woodmartAdmin.wizardBuilderSelect();
					woodmartAdmin.wizardInstallPlugins();
				});

			},

			mediaInit: function() {
				var clicked_button = false;
				$('.woodmart-image-upload').each(function(i, input) {
					var button = $(this).parent().find('.woodmart-image-upload-btn');

					if (button.hasClass('wd-inited')) {
						return;
					}

					button.click(function(event) {
						event.preventDefault();
						clicked_button = $(this);

						// check for media manager instance
						// if(wp.media.frames.gk_frame) {
						//     wp.media.frames.gk_frame.open();
						//     return;
						// }
						// configuration of the media manager new instance
						wp.media.frames.gk_frame = wp.media({
							title   : 'Select image',
							multiple: false,
							library : {
								type: 'image'
							},
							button  : {
								text: 'Use selected image'
							}
						});

						// Function used for the image selection and media manager closing
						var gk_media_set_image = function() {
							var selection = wp.media.frames.gk_frame.state().get('selection');

							// no selection
							if (!selection) {
								return;
							}

							// iterate through selected elements
							selection.each(function(attachment) {
								var url = attachment.attributes.url;

								button.parent().find('.woodmart-image-upload').val(attachment.attributes.id);
								button.parent().find('.woodmart-image-src').attr('src', url).show();
							});
						};

						// closing event for media manger
						wp.media.frames.gk_frame.on('close', gk_media_set_image);
						// image selection event
						wp.media.frames.gk_frame.on('select', gk_media_set_image);
						// showing media manager
						wp.media.frames.gk_frame.open();
					});

					button.addClass('wd-inited')
				});
			}

		};

	}());

})(jQuery);

woodmart_media_init = woodmartAdminModule.mediaInit;

jQuery(document).ready(function() {
	woodmartAdminModule.init();
});
