jQuery(document).ready(function ($) {
	$(window).load(function () {
		$('.cpm-preloader').fadeOut('slow', function () {});
	});
	$('.modal_popup').on('click touchend', function (e) {
		e.preventDefault();
		var _this = $(this),
		post = _this.data('post'),
		term = _this.data('term'),
		href = _this.data('href'),
		taxonomy = _this.data('taxonomy'),
		is_page = _this.data('page'),
		index = _this.closest('fieldset').data('index');
		$('#page-modal-popup').modal('show');
		var mouseEvent = "mousewheel DOMMouseScroll";
		if ($('body').hasClass('onepage-scroll')) {

			if ($('body').hasClass('mozilla')) {
				mouseEvent = "mousewheel DOMMouseScroll";
			}
		}
		$(window).unbind(mouseEvent);
		$.ajax({
			url : filter_modal.ajax_url + '?action=filter_popup_cpt',
			type : 'POST',
			data : {
				post_id : post,
				term : term,
				taxonomy : taxonomy,
				is_page : is_page
			},
			dataType : 'html',
			beforeSend : function () {
				var text = "loading",
				new_text = text,
				prefix = '<div class="cc-loader"> <div class="loader">',
				suffix = '</div></div>';
				$('#post-popup').html(prefix + text + suffix);
				$('.smart-page-loader').each(function () {
					$(this).remove();
				});
			},
			success : function (response) {
				$('#post-popup').html(response);
				$('.smart-page-loader').hide();
				jQuery('.vc_tta-tab a').each(function () {
					$(this).attr('target', $(this).attr('href'));
				});
				jQuery('body').on('click', '.vc_tta-tab a', function (event) {
					event.preventDefault();
					var thisAnchorHref = jQuery(this).attr('href');
					jQuery('.vc_tta-tab').each(function () {
						$(this).removeClass('vc_active');
					});
					jQuery(this).parent('li').addClass('vc_active');
					jQuery('.vc_tta-panels-container .vc_tta-panel').each(function () {
						jQuery(this).removeClass('vc_active');
						if (thisAnchorHref === '#' + jQuery(this).attr('id')) {
							jQuery(this).addClass('vc_active');
						}
					});
				});
				$("a[rel^='prettyPhoto']").prettyPhoto({
					autoplay : false,
					social_tools : false,
					deeplinking : false
				});
				var slider_bxx = $('.modal-body .list-product-wrap').addClass('model-list-product-wrap').bxSlider({
						mode : 'vertical',
						infiniteLoop : true,
						controls : true,
						auto : false,
						pager : false,
						nextText : '<i class="fa fa-2x fa-angle-right"></i>',
						prevText : '<i class="fa fa-2x fa-angle-left"></i>',
						minSlides : 1,
						maxSlides : 1,
						auto : true,
					});
				$(".cc-gallery-img a[rel^='prettyPhoto']").prettyPhoto({
					autoplay : false,
					social_tools : false,
					deeplinking : false
				});
				$('body').on('click', '.vc_tta-panel a', function (event) {
					event.preventDefault();
					var thisAnchorHref = $(this).attr('href');
					$('.vc_tta-tab').each(function () {
						$(this).removeClass('vc_active');
					});
					$(this).parent('li').addClass('vc_active');
					$('.vc_tta-panels-container .vc_tta-panel').each(function () {
						$(this).removeClass('vc_active');
						if (thisAnchorHref === '#' + $(this).attr('id')) {
							$(this).addClass('vc_active');
						}
					});
				});
				var container = jQuery('.cpm-isotope-list');
				var griddd = container.isotope({
						itemSelector : '.isotope-item',
						resizable : false,
						masonry : {
							gutterWidth : 20,
							columnWidth : 1
						}
					});
				griddd.imagesLoaded().progress(function () {
					griddd.isotope('layout');
				});
				$('.smart-page-loader').each(function () {
					$(this).remove();
				});
				if ($('body').hasClass('onepage-scroll')) {
					$('#page-modal-popup').on('hidden.bs.modal', function (e) {
						var mouseEvent = "mousewheel";
						if ($('body').hasClass('mozilla')) {
							mouseEvent = "DOMMouseScroll";
						}
						var isDoingStuff = false;
						$(window).bind(mouseEvent, function (event) {
							$('body').find('.scroll-sec').show();
							var windowWidth = $(window).width();
							if (windowWidth > 767) {
								var headerHeight = parseInt($('#cc-navbar').outerHeight()) || 0;
								if ($('body').hasClass('onepage-scroll')) {
									event.preventDefault();
									var currentdiv = $('body').find('.scroll-sec.active');
									var current_id = $('body').find('.scroll-sec.active').attr('id');
									var id_num = parseInt(current_id.split(/[-]+/).pop());
									if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
										//scrolled up
										if ($('.site-footer').hasClass('at-bottom')) {
											if (isDoingStuff) {
												return;
											}
											isDoingStuff = true;
											currentdiv.removeClass('active');
											// currentdiv.prev('.scroll-sec').addClass('active');
											$('body').find('.site-footer').removeClass('at-bottom');
											$('body').find('.slier-menu-right a').removeClass('active');
											id_num -= 1;
											$('body').find('.slier-menu-right').find('a[href="#section-' + id_num + '"]').addClass('active');
											currentdiv.css("transform", "translateY(100%)");
											$('body').find('.site-footer').css("transform", "translateY(100%)");
											$('body').find('#section-' + id_num).css("transform", "translateY(0)");
											$('body').find('#section-' + id_num).addClass('active');
											setTimeout(function () {
												isDoingStuff = false;
											}, 150);
										} else if (!$('#section-0').hasClass("active")) {
											if (isDoingStuff) {
												return;
											}
											isDoingStuff = true;
											// console.log('scrolled up');
											currentdiv.removeClass('active');
											$('body').find('.site-footer').removeClass('at-bottom');
											currentdiv.css("transform", "translateY(100%)");
											$('body').find('.site-footer').css("transform", "translateY(100%)");
											currentdiv.prevAll('.scroll-sec').css("transform", "translateY(-100%)");
											$('body').find('.slier-menu-right a').removeClass('active');
											id_num -= 1;
											$('body').find('.slier-menu-right').find('a[href="#section-' + id_num + '"]').addClass('active');
											$('body').find('#section-' + id_num).addClass('active');
											$('body').find('#section-' + id_num).css("transform", "translateY(0)");
											setTimeout(function () {
												isDoingStuff = false;
											}, 150);
											$('.scroll-sec').find('.cc-scroll-down').remove();
											$('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
											if (id_num == 0) {
												if ($('nav.navbar-fixed-top').hasClass('shrink')) {
													$('nav.navbar-fixed-top').removeClass('shrink')
												}
											}
										}
									} else {
										//scrolled down
										if ($('#section-0').hasClass("active")) {
											if (!$('nav.navbar-fixed-top').hasClass('shrink')) {
												$('nav.navbar-fixed-top').addClass('shrink')
											}
										}
										if (!$('.prefooter-section').hasClass("active")) {
											if (isDoingStuff) {
												return;
											}
											isDoingStuff = true;
											// console.log('scrolled down');
											currentdiv.removeClass('active');
											id_num += 1;
											$('body').find('#section-' + id_num).addClass('active');
											if (!$('.prefooter-section').hasClass('active')) {
												currentdiv.css("transform", "translateY(-100%)");
												currentdiv.nextAll('.scroll-sec').css("transform", "translateY(100%)");
												$('body').find('.slier-menu-right a').removeClass('active');
												$('body').find('.slier-menu-right').find('a[href="#section-' + id_num + '"]').addClass('active');
												$('body').find('#section-' + id_num).css("transform", "translateY(0)");
												$('.scroll-sec').find('.cc-scroll-down').remove();
												$('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
											} else {
												$('body').find('.prefooter-section').css('height', 'auto');
												var prefooterHeight = parseInt($('body').find('.prefooter-section').outerHeight()) || 0;
												var footerHeight = parseInt($('.site-footer').outerHeight()) || 0;
												var totalHeight = prefooterHeight + footerHeight;
												$('body').find('.slier-menu-right a').removeClass('active');
												$('body').find('.slier-menu-right').find('a[href="#section-' + id_num + '"]').addClass('active');
												currentdiv.css("transform", "translateY(-" + totalHeight + "px)");
												$('.prefooter-section').css("transform", "translateY(-" + footerHeight + "px)");
												$('body').find('.site-footer').css("transform", "translateY(0)");
												$('body').find('.site-footer').addClass('at-bottom');
											}
											setTimeout(function () {
												isDoingStuff = false;
											}, 150);
											// if( !$('.prefooter-section').hasClass('active') ){}
										}
									}
								}
							} else {
								console.log('scrolled just');
							}
						});
					});
				}

			}
		});
		return false;
	});
	$('.cpm_modal_popup').on('click', function (e) {
		e.preventDefault();
		var _this = $(this),
		post = _this.data('post'),
		term = _this.data('term'),
		href = _this.data('href'),
		taxonomy = _this.data('taxonomy'),
		is_page = _this.data('page'),
		index = _this.closest('fieldset').data('index');
		$('#post-popup-' + term).data('post', post);
		$('#post-popup-' + term).data('term', term);
		$('#post-popup-' + term).data('taxonomy', taxonomy);
		$('#post-popup-' + term).data('href', href);
		$('#post-popup-' + term).data('fieldset', index);
		$('#page-modal-popup-' + term).modal('show');
		interval = '';
		$.ajax({
			url : filter_modal.ajax_url + '?action=filter_popup_cpt',
			type : 'POST',
			data : {
				post_id : post,
				term : term,
				taxonomy : taxonomy,
				is_page : is_page
			},
			dataType : 'html',
			beforeSend : function () {
				var text = "loading",
				new_text = text,
				prefix = '<div class="cc-loader"> <div class="loader">',
				suffix = '</div></div>';
				$('#post-popup-' + term).html(prefix + text + suffix);
				$('.smart-page-loader').each(function () {
					$(this).remove();
				});
			},
			success : function (response) {
				$('.smart-page-loader').each(function () {
					$(this).remove();
				});
				$('#post-popup-' + term).html(response);
				fetchScript();
				$('.smart-page-loader').hide();
				$('.vc_tta-tab a').each(function () {
					$(this).attr('target', $(this).attr('href'));
				});
				$('body').on('click', '.vc_tta-tab a', function (event) {
					event.preventDefault();
					var thisAnchorHref = $(this).attr('href');
					$('.vc_tta-tab').each(function () {
						$(this).removeClass('vc_active');
					});
					$(this).parent('li').addClass('vc_active');
					$('.vc_tta-panels-container .vc_tta-panel').each(function () {
						$(this).removeClass('vc_active');
						if (thisAnchorHref === '#' + $(this).attr('id')) {
							$(this).addClass('vc_active');
						}
					});
				});
				$("a[rel^='prettyPhoto']").prettyPhoto({
					autoplay : false,
					social_tools : false,
					deeplinking : false
				});
				$(".cc-gallery-img a[rel^='prettyPhoto']").prettyPhoto({
					autoplay : false,
					social_tools : false,
					deeplinking : false
				});
				$('body').on('click', '.vc_tta-panel a', function (event) {
					event.preventDefault();
					console.log('clicked');
					var thisAnchorHref = $(this).attr('href');
					$('.vc_tta-tab').each(function () {
						$(this).removeClass('vc_active');
					});
					$(this).parent('li').addClass('vc_active');
					$('.vc_tta-panels-container .vc_tta-panel').each(function () {
						$(this).removeClass('vc_active');
						if (thisAnchorHref === '#' + $(this).attr('id')) {
							$(this).addClass('vc_active');
						}
					});
				});
				var $container = jQuery('.cpm-isotope-list');
				var $griddd = $container.isotope({
						itemSelector : '.isotope-item',
						resizable : false,
						masonry : {
							gutterWidth : 20,
							columnWidth : 1
						}
					});
				$griddd.imagesLoaded().progress(function () {
					$griddd.isotope('layout');
				});
			}
		});
	});
	$('.product_color_modal').on('click', function (e) {
		e.preventDefault();
		var _this = $(this),
		post = _this.data('post'),
		term = _this.data('term'),
		href = _this.data('href'),
		taxonomy = _this.data('taxonomy'),
		index = _this.closest('fieldset').data('index');
		$('#product_color_post-popup').data('term', term);
		$('#product_color_post-popup').data('taxonomy', taxonomy);
		$('#product_color_post-popup').data('href', href);
		$('#product_color_post-popup').data('fieldset', index);
		$('#product_color-modal-popup').modal('show');
		return false;
	});
	$('#product_color-modal-popup').on('show.bs.modal', function () {
		var term = $('#product_color_post-popup').data('term'),
		taxonomy = $('#product_color_post-popup').data('taxonomy'),
		href = $('#product_color_post-popup').data('href');
		var interval = '';
		$.ajax({
			url : filter_modal.ajax_url + '?action=product_color_filter_popup_cpt',
			type : 'POST',
			data : {
				term : term,
				taxonomy : taxonomy
			},
			dataType : 'html',
			beforeSend : function () {
				var text = "loading",
				new_text = text,
				prefix = '<div class="cc-loader"> <div class="loader">',
				suffix = '</div></div>';
				$('#product_color_post-popup').html(prefix + text + suffix);
				$('.smart-page-loader').each(function () {
					$(this).remove();
				});
			},
			success : function (response) {
				$('.smart-page-loader').each(function () {
					$(this).remove();
				});
				$('#product_color_post-popup').html(response);
				$('.smart-page-loader').hide();
			}
		});
	});
	$('body').on('click', '.filter_popup_navigation', function (e) {
		e.preventDefault();
		var _this = $(this),
		post = _this.data('post'),
		term = _this.data('term'),
		is_page = _this.data('page'),
		taxonomy = _this.data('taxonomy');
		$.ajax({
			url : filter_modal.ajax_url + '?action=filter_popup_cpt',
			type : 'POST',
			data : {
				post_id : post,
				term : term,
				taxonomy : taxonomy,
				is_page : is_page
			},
			dataType : 'html',
			beforeSend : function () {
				var text = "loading",
				new_text = text,
				prefix = '<div class="cc-loader"> <div class="loader">',
				suffix = '</div></div>';
				$('#post-popup').html(prefix + text + suffix);
				$('.smart-page-loader').each(function () {
					$(this).remove();
				});
			},
			success : function (response) {
				$('#post-popup').html(response);
				jQuery('body').on('click', '.vc_tta-tab a', function (event) {
					event.preventDefault();
					var thisAnchorHref = jQuery(this).attr('href');
					jQuery('.vc_tta-tab').each(function () {
						$(this).removeClass('vc_active');
					});
					jQuery(this).parent('li').addClass('vc_active');
					jQuery('.vc_tta-panels-container .vc_tta-panel').each(function () {
						jQuery(this).removeClass('vc_active');
						if (thisAnchorHref === '#' + jQuery(this).attr('id')) {
							jQuery(this).addClass('vc_active');
						}
					});
				});
				$("a[rel^='prettyPhoto']").prettyPhoto({
					autoplay : false,
					social_tools : false,
					deeplinking : false
				});
				var slider_bx = $('.modal-body .list-product-wrap').addClass('model-list-product-wrap').bxSlider({
						mode : 'vertical',
						infiniteLoop : true,
						controls : true,
						auto : false,
						pager : false,
						nextText : '<i class="fa fa-2x fa-angle-right"></i>',
						prevText : '<i class="fa fa-2x fa-angle-left"></i>',
						minSlides : 1,
						maxSlides : 1,
						auto : true,
					});
				$(".cc-gallery-img a[rel^='prettyPhoto']").prettyPhoto({
					autoplay : false,
					social_tools : false,
					deeplinking : false
				});
				$('body').on('click', '.vc_tta-panel a', function (event) {
					event.preventDefault();
					var thisAnchorHref = $(this).attr('href');
					$('.vc_tta-tab').each(function () {
						$(this).removeClass('vc_active');
					});
					$(this).parent('li').addClass('vc_active');
					$('.vc_tta-panels-container .vc_tta-panel').each(function () {
						$(this).removeClass('vc_active');
						if (thisAnchorHref === '#' + $(this).attr('id')) {
							$(this).addClass('vc_active');
						}
					});
				});
				var container = jQuery('.cpm-isotope-list');
				var griddd = container.isotope({
						itemSelector : '.isotope-item',
						resizable : false,
						masonry : {
							gutterWidth : 20,
							columnWidth : 1
						}
					});
				griddd.imagesLoaded().progress(function () {
					griddd.isotope('layout');
				});
				$('.smart-page-loader').each(function () {
					$(this).remove();
				});
			}
		});
	});
	function fetchScript() {
		var modal_slider = $('.modal-body .list-product-wrap').addClass('model-list-product-wrap').bxSlider({
				mode : 'vertical',
				infiniteLoop : true,
				controls : true,
				auto : false,
				pager : false,
				nextText : '<i class="fa fa-2x fa-angle-right"></i>',
				prevText : '<i class="fa fa-2x fa-angle-left"></i>',
				minSlides : 1,
				maxSlides : 1
			});
	}
	$('figure.fig-hover').live('click', function (e) {
		e.preventDefault();
		var _this = $(this).next('div.ms-checkbox').find('input.filter-checkbox-btn');
		var data_taxonomy = _this.data('taxonomy');
		
		if ('checked' == _this.attr('checked')) {
			_this.removeAttr('checked');
		} else {
			if (data_taxonomy != 'pa_filter-colour' && data_taxonomy != 'product_feature')
				_this.parent().closest('li').parent().find('input').removeAttr('checked');

			_this.attr('checked', 'checked');
		}
		$(this).next('div.ms-checkbox').find('input.filter-checkbox-btn').trigger("change");
	});
});