jQuery(document).ready(function ($) {
	var product_types_array = [];
	product_filter_page();
	var current_fs,
	next_fs,
	previous_fs;
	var left,
	opacity,
	scale;
	var animating = false;
	var additional_option = [];
	var delivery_array = [];
	var pa_looks_array = [];
	var pa_looks_types_array = [];
	var product_color_array = [];
	var filter_slider = $('.bxslider-filter').bxSlider({
			mode : 'fade',
			infiniteLoop : false,
			controls : false,
			auto : false,
			pager : false,
			responsive : true
		});
	$('ul#progressbar .li-floor, ul#progressbar .li-style, ul#progressbar .li-color, ul#progressbar .li-results, ul#progressbar .li-sell, ul#progressbar .li-rent').on('click', function () {
		if ($(this).hasClass('active')) {
			if ($(this).hasClass('li-style')) {
				$('.color-previous').trigger('click');
				$('fieldset.results-section').hide();
				$('fieldset.color-palette').hide();
				$('ul#progressbar .li-color').removeClass('active');
				$('ul#progressbar .li-results').removeClass('active');
				$('section#home-content-wrap').removeClass('color-margin');
			} else if ($(this).hasClass('li-floor')) {
				$('.style-previous').trigger('click');
				$('fieldset.results-section').hide();
				$('fieldset.color-palette').hide();
				$('fieldset.cpm-pa_style').hide();
				$('ul#progressbar .li-color').removeClass('active');
				$('ul#progressbar .li-color').find('.selected-text').html('');
				$('ul#progressbar .li-results').removeClass('active');
				$('section#home-content-wrap').removeClass('color-margin');
			} else if ($(this).hasClass('li-color')) {
				$('fieldset.results-section').hide();
				$('fieldset.cpm-pa_floor').hide();
				$('fieldset.cpm-pa_style').hide();
				$('.result-previous').trigger('click');
				$('section#home-content-wrap').addClass('color-margin');
			} else if ($(this).hasClass('li-sell')) {
				$('ul#progressbar .li-results').removeClass('active');
				$('fieldset.results-section').hide();
				$('.result-previous').trigger('click');
			} else if ($(this).hasClass('li-rent')) {
				$('ul#progressbar .li-results').removeClass('active');
				$('fieldset.results-section').hide();
				$('.result-previous').trigger('click');
			}
		}
	});
	$("body").on('click', '.previous, .color-previous, .style-previous, .result-previous', function (e) {
		e.preventDefault();
		animating = true;
		current_fs = $(this).closest('fieldset');
		previous_fs = $(this).closest('fieldset').prev();
		var previous_class = previous_fs.attr('class');
		if (previous_class == 'cpm-pa_sell') {
			$('.sell-qns').removeClass('hidden');
			$('.product-color-qns').addClass('hidden');
		} else if (previous_class == 'cpm-pa_rent') {
			$('.rent-qns').removeClass('hidden');
			$('.product-color-qns').addClass('hidden');
		} else if (previous_class == 'cpm-pa_floor') {
			$('.floor-qns').removeClass('hidden');
			$('.style-qns').addClass('hidden');
		} else if (previous_class == 'cpm-pa_style') {
			$('.style-qns').removeClass('hidden');
			$('.product-color-qns').addClass('hidden');
		}
		prev_desc_block(current_fs, previous_fs);
		$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
		$("#progressbar li").removeClass('current');
		$("#progressbar li").eq($("fieldset").index(previous_fs)).addClass("current");
		$("#progressbar li").eq($("fieldset").index(current_fs)).find('.selected-text').empty();
		previous_fs.show();
		current_fs.hide();
		var label = $("#progressbar li").eq($("fieldset").index(previous_fs)).find('h3 span').html();
	});
	$('.first-previous').live('click', function (e) {
		e.preventDefault();
		$(this).closest('.cpm-container-fluid').hide();
		$('.cpm-first-step').show();
	});
	$('body').on('click', '.form-select-continue-link', function (e) {
		e.preventDefault();
		var term = $(this).data('term');
		$('#term_' + term).trigger('click');
		$('#page-modal-popup').modal('hide');
	});
	$('.product_color_filter_tax').live('click', function (e) {
		e.preventDefault();
		var term = $(this).data('term');
		var term_name = $(this).data('name');
		var parent_el = $(this).data('parent');
		$('input[name="cc_color"]').val(parent_el);
		$('input#cc_color_child').val(term);
		$('li.li-color .selected-text').html('<div class="selected-text"><strong>Selected :</strong> ' + term_name + '</div>');
		$('#page-modal-popup').modal('hide');
		next_progress_bar($('#term_' + parent_el).closest('fieldset'));
	});
	$('a.product_color').on('click', function (e) {
		e.preventDefault();
		var _this = $(this),
		term_id = _this.data('term');
		var child_color = $('ul.filter_product_color').find('li.' + term_id);
		$('input[name="cc_color"]').val(term_id);
		$('div.cpm-product-color-accents').removeClass('hidden');
		$('ul.filter_product_color li').removeClass('hidden');
		$('ul.filter_product_color li').each(function () {
			if (!$(this).hasClass(term_id)) {
				$(this).addClass('hidden');
			} else {
				$(this).removeClass('hidden');
			}
		});
		// $('html, body').animate({scrollTop: $("div.cpm-product-color-accents").offset().top - 100}, 500);
		next_progress_bar($(this).closest('fieldset'));
	});
	$('a.skip-action').on('click', function (e) {
		e.preventDefault();
		next_progress_bar($('fieldset.color-palette'));
	});
	$('.filter_tax').on('click', function (e) {
		e.preventDefault();
		var _this = $(this),
		parent = _this.closest('ul'),
		parentClasses = parent.attr('class').split(" "),
		term = _this.data('term'),
		term_name = _this.data('name'),
		taxonomy_name = _this.data('taxonomy');
		if (taxonomy_name == 'product_color') {
			var parent_el = $(this).data('parent');
			$('input#cc_color_child').val(term);
			$('li.li-color .selected-text').html('<div class="selected-text"><strong>Selected :</strong> ' + term_name + '</div>');
		}
		if (taxonomy_name == 'pa_floor') {
			$('.floor-qns').addClass('hidden');
			$('.style-qns').removeClass('hidden');
			$('input#selected_floor_life').val(term_name);
		} else if (taxonomy_name == 'pa_style') {
			$('.style-qns').addClass('hidden');
			$('.product-color-qns').removeClass('hidden');
			$('input#selected_style_life').val(term_name);
			$('section#home-content-wrap').addClass('color-margin');
		} else if (taxonomy_name == 'product_color') {
			$('.product-color-qns').addClass('hidden');
			$('input#selected_color_life').val(term_name);
		}
		$('.filter_tax').find('.select').removeClass('selected');
		$('#attr_term_' + term).toggleClass('selected');
		if ($('#attr_term_' + term).hasClass('selected')) {
			$('#cc_' + parentClasses[2]).val(term);
			$('.li-' + parentClasses[2]).find('.selected-text').html("<strong>Selected :</strong> " + term_name);
		} else {
			$('#cc_' + parentClasses[2]).val('');
			$('.li-' + parentClasses[2]).find('.selected-text').html('');
		}
		next_progress_bar($(this).closest('fieldset'));
	});
	$('a.cpm-first-steps').live('click', function (e) {
		e.preventDefault();
		var _this = $(this);
		var parent_li = _this.parent().closest('li');
		var _liID = _this.parent().closest('li').attr('id');
		var taxonomy = _liID.replace(/li-id-/, '');
		if (taxonomy == 'keep') {
			parent_li.parent().closest('.container-fluid').hide();
			parent_li.parent().closest('.container-fluid').next('.cpm-container-fluid').show();
			$('.cpm-col-fieldset').find('.selected').removeClass('selected');
			$('#cpm-progressbar').find('.selected-text').html('');
			$('input[name="pa_rent"]').removeAttr('value');
			$('input[name="pa_sell"]').removeAttr('value');
		} else {
			$('ul#cpm-progressbar li.li-' + taxonomy).addClass('active current');
			$('ul#cpm-progressbar li').not(parent_li).removeClass('active current');
			$('div.fieldset-' + taxonomy).show();
			$('div.cpm-fieldset').not($('div.fieldset-' + taxonomy)).hide();
			$('.cpm-col-fieldset').find('.selected').removeClass('selected');
			$('#cpm-progressbar').find('.selected-text').html('');
			if (taxonomy == 'rent') {
				$('input[name="pa_sell"]').removeAttr('value');
			} else {
				$('input[name="pa_rent"]').removeAttr('value');
			}
		}
	});
	$('.cpm_filter_tax').on('click', function (e) {
		e.preventDefault();
		var _this = $(this),
		parent = _this.closest('ul'),
		parentClasses = parent.attr('class').split(" "),
		term = _this.data('term'),
		term_name = _this.data('name'),
		taxonomy_name = _this.data('taxonomy');
		if (taxonomy_name == 'pa_rent') {
			$('.rent-qns').addClass('hidden');
			$('input#selected_rent').val(term_name);
			$('.product-color-qns').removeClass('hidden');
		} else if (taxonomy_name == 'pa_sell') {
			$('.sell-qns').addClass('hidden');
			$('input#selected_sell').val(term_name);
			$('.product-color-qns').removeClass('hidden');
		}
		$('.cpm_filter_tax').find('.select').removeClass('selected');
		$('#attr_term_' + term).toggleClass('selected');
		if ($('#attr_term_' + term).hasClass('selected')) {
			$('#cc_' + parentClasses[2]).val(term);
			$('.li-' + parentClasses[2]).find('.selected-text').html("<strong>Selected :</strong> " + term_name);
		} else {
			$('#cc_' + parentClasses[2]).val('');
			$('.li-' + parentClasses[2]).find('.selected-text').html('');
		}
		$('.cpm-first-step').hide();
		$('.cpm-container-fluid').show();
		next_progress_bar($(this).closest('fieldset'));
	}); /*jQuery('.checkbox-custom-label').live( 'click', function(e) {e.preventDefault();jQuery(this).closest('.ms-checkbox').find('input.filter-checkbox-btn').trigger('change');});*/
	/*$('#collapse-product_color ul li.cpm-parent .fig-hover a.cpm-img-checkbox').live( 'click', function(e) {e.preventDefault();var _this = $(this);if ( !_this.parent().closest('li').hasClass('active') ) {_this.parent().closest('ul').find('li input.filter-checkbox-btn').not(_this).prop( 'checked', false );}});*/
	// $('#collapse-product_color ul li.cpm-parent .fig-hover a.cpm-img-checkbox, #collapse-product_cat ul li.cpm-parent .fig-hover a.cpm-img-checkbox').live( 'click', function(e) {e.preventDefault();var _this = $(this);if ( !_this.parent().closest('li').hasClass('active') ) {_this.parent().closest('ul').find('li input.filter-checkbox-btn').not(_this).prop( 'checked', false );}});
	/*$('#collapse-cpm_accents ul li.cpm-parent .fig-hover a.cpm-img-checkbox').live( 'click', function(e) {e.preventDefault();var _this = $(this);if ( !_this.parent().closest('li').hasClass('active') ) {_this.parent().closest('ul').find('li input.filter-checkbox-btn').not(_this).prop( 'checked', false );}});*/
	$('body').on('change touchstart', '.filter-lefts .filter-checkbox-btn', function (e) {
		e.preventDefault();
		
		var _this = $(this);
		var data_term = $(this).data('term');
		var data_taxonomy = $(this).data('taxonomy');
		var id_head = _this.parent().closest('ul').parent().parent().attr('id');

		if ( data_taxonomy == "pa_filter-colour" ) {
			window.location.hash = '#' + data_term;
		}
		
		if ( data_taxonomy == 'product_cat') {
			if (data_term != 'carpet' || (data_term == 'carpet' && !$(this).is(":checked"))) {
				$('body').find('.panel.pa_fibres').addClass('hidden');
				$('body').find('.panel.pa_fibres .active').removeClass('active');
				$('body').find('.panel.pa_fibres input').removeAttr('checked');
			}
			else {
				$('body').find('.panel.pa_fibres').removeClass('hidden');
			}
		}

		if (id_head == 'collapse-product_color') {
			var val_this = _this.val();
			$('#collapse-cpm_accents').find('ul li.' + val_this).removeClass('hidden');
			$('#collapse-cpm_accents').find('ul li').not(jQuery('.' + val_this)).addClass('hidden');
		}
		if (data_taxonomy == 'product_color' && !_this.hasClass('child_product_color')) {
			if ($.inArray(data_term, product_color_array) == -1) {
				product_color_array = [];
				product_color_array.push(data_term);
			} else {
				var color_index = product_color_array.indexOf(data_term);
				product_color_array.splice(color_index, 1);
			}
			if (product_color_array == undefined || product_color_array == null || product_color_array.length == 0) {
				$('#heading-cpm_accents').closest('.panel.panel-default.panel-transparent').addClass('hidden');
			} else {
				$('#heading-cpm_accents').closest('.panel.panel-default.panel-transparent').removeClass('hidden');
			}
		}
		/*if ( data_taxonomy == 'product_cat' ) {var cat_val = _this.val();var cat_id = _this.attr('id');if ( !_this.closest('li').hasClass('active') ) {$('#collapse-product_brand ul.panel-col li').each( function() {if ( $(this).hasClass(cat_val) ) {$(this).removeClass('hidden'); } else {$(this).addClass('hidden'); $(this).removeClass('active'); $(this).find('input').prop( 'checked', false ); } }); } else {$('#collapse-product_brand ul.panel-col li').each( function() {$(this).removeClass('hidden'); $(this).removeClass('active'); $(this).find('input').prop( 'checked', false ); }); } }*/
		if ((data_term == 'wood' || data_term == 'vinyl' || data_term == 'laminate') && (data_taxonomy == 'product_cat')) {
			pa_looks_types_array = [];
			var this_active = $(this).closest('li.cpm-parent');
			if ($.inArray(data_term, pa_looks_types_array) == -1 && !$(this_active).hasClass('active')) {
				pa_looks_types_array.push(data_term);
			} else {
				var index = pa_looks_types_array.indexOf(data_term);
				pa_looks_types_array.splice(index, 1);
				$('input[name="pa_looks[]"]').each(function () {
					$(this).prop('checked', false);
					$(this).parent().closest('li.cpm-parent').removeClass('active');
				});
			}
			if (pa_looks_types_array == undefined || pa_looks_types_array == null || pa_looks_types_array.length == 0) {
				$('#collapse-pa_looks').closest('.panel.panel-default.panel-transparent').addClass('hidden');
			} else {
				$('#collapse-pa_looks').closest('.panel.panel-default.panel-transparent').removeClass('hidden');
			}
		} else {
			pa_looks_types_array = [];
			if ((data_term != 'wood' || data_term != 'vinyl' || data_term != 'laminate') && (data_taxonomy == 'product_cat')) {
				$('#collapse-pa_looks').closest('.panel.panel-default.panel-transparent').addClass('hidden');
				$('input[name="pa_looks[]"]').each(function () {
					$(this).prop('checked', false);
					$(this).parent().closest('li.cpm-parent').removeClass('active');
				});
			}
		}
		/*
		if ($(this).is(":checked")) {
			$(this).prop('checked', 'checked');
		} else {
			$(this).prop('checked', '');
		}*/

		if ($('.product_cat').is(":checked")) {
			if ($(this).hasClass('product_cat')) {
				$('input.product_feature').prop('checked', false);
				$('input.product_feature').parent().closest('li').removeClass('active');
			}
		}

		var formdata = $('.filter-form-left').serialize();

		if (!$(this).parent().closest('li').hasClass('active')) {
			if (data_taxonomy != 'pa_filter-colour' && data_taxonomy != 'product_feature') {
				$(this).parent().closest('li').parent().find('li').removeClass('active');

			}
			$(this).parent().closest('li').addClass('active');
			if (data_taxonomy == 'product_color') { /*_this.parent().closest('ul').find('li').not(_this.parent()).removeClass('active');*/ $(this).parent().closest('li').addClass('active');
			} else if (data_taxonomy == 'product_cat') {
				_this.parent().closest('ul').find('li').not(_this.parent()).removeClass('active');
				$(this).parent().closest('li').addClass('active');
			}
		} else {

			$(this).parent().closest('li').removeClass('active');
			if (data_taxonomy == 'product_color') {
				/*_this.parent().closest('ul').find('li').not(_this.parent()).removeClass('active');*/
			} else if (data_taxonomy == 'product_cat') {
				/*_this.parent().closest('ul').find('li').not(_this.parent()).removeClass('active');*/
			}
		}

		var cc_color = $('#cc_color').val(),
		cc_color_child = $('#cc_color_child').val(),
		delivery = $('input[name="delivery"]:checked').val(),
		tab = $('#cc_tab_filters_list').val(),
		cc_rent = $('#cc_rent').val(),
		cc_sell = $('#cc_sell').val(),
		param = {
			delivery : delivery, /*pa_filter_color:[cc_color],*/ child_product_color : cc_color_child,
			product_tag : tab,
			pa_rent : [cc_rent],
			pa_sell : [cc_sell],
			pa_looks : pa_looks_array
		};
		param = formdata + '&' + $.param(param);
		if ($('body').hasClass('page-template-template-product-filter-php')) {
			param += '&tabs=yes';
			param += '&product_tag=' + fetchActiveTab();
		}

		//filter features with respect to product_cat
		if (data_taxonomy == 'product_cat') {

			var val_cat = _this.val();
			var cat_active = _this.closest('li.cpm-parent');
			if ($(cat_active).hasClass('active')) {
				product_types_array.push(val_cat);
			} else {
				var c_index = product_types_array.indexOf(val_cat);
				product_types_array.splice(c_index, 1);
			}
			if (product_types_array.length > 0) {

				var i;
				for (i = 0; i < product_types_array.length; ++i) {
					$('#collapse-product_feature li').each(function () {
						if (!$(this).hasClass(product_types_array[i])) {
							$(this).hide();
						} else {
							$(this).show();
						}
					});
				}
			} else {
				$('#collapse-product_feature li').show();
			}
		}
		//end of features filter
		// console.log(param);
		
		if ( data_taxonomy == "pa_filter-colour" ) {
			param += '&pa_filter-colour-term=' + window.location.hash.split('#')[1];
		}
		
		$.ajax({
			url : progressbar.ajax_url + '?action=filter_product_return_url',
			type : 'POST',
			data : param,
			dataType : 'json',
			success : function (response) {
				console.log(response.url);
				window.history.pushState({
					foo : "bar"
				}, "Products", response.url);
			}
		});
		generate_products(param);

	});
	$('body').on('change', 'input[name="delivery"]', function (e) {
		e.preventDefault();
		if ($(this).is(":checked") && $.inArray($(this).val(), delivery_array) == -1) {
			delivery_array.push($(this).val());
		} else {
			var index = delivery_array.indexOf($(this).val());
			delivery_array.splice(index, 1);
		}
		var _this = $(this),
		formdata = $('.filter-form-left').serialize();
		var cc_floor = $('#cc_floor').val(),
		cc_style = $('#cc_style').val(),
		cc_color = $('#cc_color').val(),
		cc_color_child = $('#cc_color_child').val(),
		tab = $('#cc_tab_filters_list').val(),
		delivery = $('input[name="delivery"]:checked').val(),
		cc_rent = $('#cc_rent').val(),
		cc_sell = $('#cc_sell').val(),
		param = {
			delivery : delivery,
			product_tag : tab,
			pa_filter_color : [cc_color],
			child_product_color : cc_color_child,
			pa_rent : [cc_rent],
			pa_sell : [cc_sell],
		};
		if ($('body').hasClass('page-template-template-product-filter-php')) {
			param.tabs = 'yes';
			param.product_tag = fetchActiveTab();
		}
		param = formdata + '&' + $.param(param);
		generate_products(param);
	});
	$('body').on('click', '.paginate_ajax', function (e) {
		if (!$(this).hasClass('dots')) {
			e.preventDefault();
			var _this = $(this),
			formdata = $('.filter-form-left').serialize(),
			cc_floor = $('#cc_floor').val(),
			cc_style = $('#cc_style').val(),
			cc_color = $('#cc_color').val(),
			pagenum = _this.data('pagenum'),
			cc_color_child = $('#cc_color_child').val(),
			tab = $('#cc_tab_filters_list').val(),
			delivery = $('input[name="delivery"]:checked').val(),
			cc_rent = $('#cc_rent').val(),
			cc_sell = $('#cc_sell').val(),
			param = {
				delivery : delivery,
				product_tag : tab,
				pa_filter_color : [cc_color],
				child_product_color : cc_color_child,
				pa_rent : [cc_rent],
				pa_sell : [cc_sell],
				paged : pagenum,
				referrerPage : document.referrer,
			};
			if ($('body').hasClass('page-template-template-product-filter-php')) {
				param.tabs = 'yes';
			}
			param = formdata + '&' + $.param(param);
			generate_products(param);
			$('html, body').animate({
				scrollTop : $('.cpm-filter-results').offset().top
			}, 500);
		}

		var url = document.location.toString();
		var cleanUrl =  url.split('page/');
		var searchParams = new URLSearchParams(param);
		if (searchParams.has("paged")){
			window.history.pushState('page', 'title', cleanUrl[0] + 'page/'+ searchParams.get("paged"));
		}
	});
	$('body').on('click', '.tabs', function (e) {
		e.preventDefault();
		var _this = $(this),
		formdata = $('.filter-form-left').serialize(),
		cc_floor = $('#cc_floor').val(),
		cc_style = $('#cc_style').val(),
		cc_color = $('#cc_color').val(),
		tab = _this.data('tab'),
		cc_color = $('#cc_color').val(),
		cc_color_child = $('#cc_color_child').val(),
		delivery = $('input[name="delivery"]:checked').val(),
		cc_rent = $('#cc_rent').val(),
		cc_sell = $('#cc_sell').val(),
		param = {
			product_tag : tab,
			pa_filter_color : [cc_color],
			child_product_color : cc_color_child,
			delivery : delivery,
			pa_rent : [cc_rent],
			pa_sell : [cc_sell],
		};
		$('#cc_tab_filters_list').val(tab);
		if ($('body').hasClass('page-template-template-product-filter-php')) {
			param.tabs = 'yes';
		}
		param = formdata + '&' + $.param(param);
		var cc_rent = $('#cc_rent').val();
		var cc_sell = $('#cc_sell').val();
		if (typeof cc_rent !== "undefined") {
			var ccc_rent = $('#cc_rent').val();
			param.pa_rent = [ccc_rent];
		}
		if (typeof cc_sell !== "undefined") {
			var ccc_sell = $('#cc_sell').val();
			param.pa_sell = [ccc_sell];
		}
		generate_products(param);
	});
	function next_progress_bar(current_fs) {
		animating = true;
		next_fs = current_fs.next();
		next_desc_block(current_fs, next_fs);
		$("#progressbar li").removeClass('current');
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass('current');
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		var label = $("#progressbar li").eq($("fieldset").index(next_fs)).find('h3 span').html();
		var cpm_taxonomy = $("#progressbar li").find('span.cpm-taxonomy-name').html();
		if ($("#progressbar li").eq($("fieldset").index(next_fs)).hasClass('li-results')) {
			var cc_rent = $('#cc_rent').val();
			var cc_sell = $('#cc_sell').val();
			var ccc_rent = '';
			var ccc_sell = '';
			var cc_floor = $('#cc_floor').val(),
			cc_style = $('#cc_style').val(),
			cc_color = $('#cc_color').val(),
			cc_color_child = $('#cc_color_child').val(),
			delivery = $('input[name="delivery"]:checked').val(),
			param = {
				pa_floor : [cc_floor],
				pa_style : [cc_style],
				pa_filter_color : [cc_color],
				child_product_color : cc_color_child,
				delivery : delivery,
			};
			if (typeof cc_rent !== "undefined") {
				ccc_rent = $('#cc_rent').val();
				param.pa_rent = [ccc_rent];
			}
			if (typeof cc_sell !== "undefined") {
				ccc_sell = $('#cc_sell').val();
				param.pa_sell = [ccc_sell];
			}
			generate_filter_queries(param);
			if ($('body').hasClass('page-template-template-product-filter-php')) {
				param.tabs = 'yes';
			}
			generate_products(param);
			if ($('body .product-filter-banner').length > 0) {
				$('body .product-filter-banner').removeClass('hidden');
			}
			$('html, body').animate({
				scrollTop : 0
			}, 500);
		}
		current_fs.hide();
		next_fs.show();
		if (next_fs.data('index') != 3) {

			$('html, body').animate({
				scrollTop : $('section#home-content-wrap').offset().top - 70
			}, 500);
			// $('html, body').animate({scrollTop: $(next_fs).offset().top },500);
		}
		/*else {
		}*/
	}
	function generate_filter_queries(param) {
		
		var inter;
		$.ajax({
			url : progressbar.ajax_url + '?action=generate_filter_queries',
			type : 'POST',
			data : param,
			dataType : 'html',
			beforeSend : function () {
				var text = "loading",
				new_text = text,
				prefix = '<div class="cc-loader"> <div class="loader">',
				suffix = '</div></div>';
				$('.filter-left').html(prefix + text + suffix);
			},
			success : function (response) {
				$('.filter-left').html(response);

			}
		});
	}
	function generate_products(param) {

		var url = document.location.toString();
		var cleanUrl =  url.split('page/');

		var urlPage;

		if(urlPage = parseInt(cleanUrl[1])){
			var searchParams = new URLSearchParams(param);
			if (!searchParams.has("paged")){
				param = param + '&paged=' + urlPage;
			}

		}

		var inter;
		$.ajax({
			url : progressbar.ajax_url + '?action=filter_product',
			type : 'POST',
			data : param,
			dataType : 'html',
			beforeSend : function () {
				var text = "loading",
				new_text = text,
				prefix = '<div class="cc-loader"> <div class="loader">',
				suffix = '</div></div>';
				$('.filter-right .cpm-filter-results').append(prefix + text + suffix);
				if ($('#cpm-filter-results-toggle').hasClass('cpm-filter-result-close')) {
					$('#showLeft').removeClass('active');
				}
			},
			success : function (response) {

				$('#msform').prev('.container').hide();
				$('section#home-content-wrap').removeClass('cpm-margin-no-slider');
				/*if ( !$('body').hasClass('page-template-template-product-filter-php')) {

				$('html, body').animate({scrollTop: $('.cc-filter-dark').offset().top-123 },500);
				}*/
				$('.filter-right .cpm-filter-results').html(response);

				if ($('body').hasClass('page-template-template-product-filter-php')) {
					$('.filter-right .breadcrumb').html($('#hidden_breadcrumb').html());
				}
				/*if( $('body').hasClass('page-template-product-search-progressbar-php') ) {$('html, body').animate({scrollTop: $('fieldset').eq(3).offset().top },500); }*/
				setTimeout(function () {
					$('.list-product-wrap .list-product').css('height', 'auto');
					var range_heighttttt = 0;
					if ($('body #showLeft').hasClass('active')) {
						$('.list-product-wrap .list-product').css('height', 'auto');
					} else {
						$('.list-product-wrap .list-product').each(function () {
							if ($(this).height() > range_heighttttt) {
								range_heighttttt = $(this).height();
							}
						});
						$('.list-product-wrap .list-product').height(range_heighttttt);
					}
				}, 1000);

				setTimeout(function () {
					if ($('body .filter-right').find('.no-products-found').length >= 1) {
						$('body .filter-form-left').addClass('pos-relative');
					} else if ($('body .filter-right').find('.list-product').length <= 4) {
						$('body .filter-form-left').addClass('pos-relative');
					} else {
						$('body .filter-form-left').removeClass('pos-relative');
					}
				}, 2000);
				$('.list-color-available ul li').each(function () {
					$(this).find('img').cceasyZoom();
				});

			}
		});

		// debugger;
		// return true;
	}
	function product_filter_page() {
		var param = '';
		if ($('body').hasClass('page-template-template-product-filter-php')) {
			if (typeof post_key !== "undefined" && post_key != null) {
				param += $.param(post_key);
			}
			// param += '&referrerPage='+document.referrer;
			if (param != '') {
				param += '&tabs=yes';
			} else {
				param = 'tabs=yes';
			}
			
			if(window.location.hash) {
			  param += '&pa_filter-colour-term=' + window.location.hash.split('#')[1];
			}

			generate_filter_queries(param);
			generate_products(param);
		}
	}
	function fetchActiveTab() {
		if ($('body .tabs').length > 0) {
			return $('body .tabs.tab-active').data('tab');
		} else {
			return 'all';
		}
	}
	function next_desc_block(current_fs, next_fs) {
		current_desc_fs = $('.life-desc').eq($("fieldset").index(current_fs));
		next_desc_fs = $('.life-desc').eq($("fieldset").index(next_fs));
		$('.life-desc').eq($("fieldset").index(current_fs)).removeClass('active-desc');
		$('.life-desc').eq($("fieldset").index(next_fs)).addClass('active-desc');
		next_desc_fs.show();
		current_desc_fs.hide();
	}
	function prev_desc_block(current_fs, previous_fs) {
		current_desc_fs = $('.life-desc').eq($("fieldset").index(current_fs));
		prev_desc_fs = $('.life-desc').eq($("fieldset").index(previous_fs));
		$('.life-desc').eq($("fieldset").index(current_fs)).removeClass('active-desc');
		$('.life-desc').eq($("fieldset").index(previous_fs)).addClass('active-desc');
		prev_desc_fs.show();
		current_desc_fs.hide();
	}
	function breadcrumb(direction, label) {
		var breadcrumb = $('body .woocommerce-breadcrumb').html();
		if (direction == "next") {
			$('body .woocommerce-breadcrumb').html(breadcrumb + " / " + label);
		} else if (direction == "prev") {
			var index = breadcrumb.lastIndexOf('/'),
			new_breadcrumb = breadcrumb.substring(0, index);
			$('body .woocommerce-breadcrumb').html(new_breadcrumb);
		}
	}
	function toggleChevron(e) {
		$(e.target).prev('.panel-heading').find("i.indicator").toggleClass('arrow-chevron-down arrow-chevron-up');
	}
	$('body').on('hidden.bs.collapse', '#accordion', toggleChevron);
	$('body').on('shown.bs.collapse', '#accordion', toggleChevron);
});
