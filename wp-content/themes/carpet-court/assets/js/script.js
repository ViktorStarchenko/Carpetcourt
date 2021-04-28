jQuery(document).ready(function ($) {
    var slider_other_product = $('#slider-other-product'),
    slider_works_well = $('#slider-works-well'),
    param_large = {minSlides: 1,maxSlides: 3,slideWidth: 245,slideMargin: 10,nextText: '',prevText: ''},param_small = {minSlides: 1,maxSlides: 2,slideMargin: 10,nextText: '',prevText: ''};slider_other_product.bxSlider( param_large );slider_works_well.bxSlider( param_large );setTimeout(function(){bx_reloadSlider();},500);$('a[href="#search"]').on('click', function(event) {event.preventDefault();$('#search').addClass('open');$('#search form input[type="search"]').focus();});$('#search, #search button.close').on('click keyup', function(event) {if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {$(this).removeClass('open');}});header_height = parseInt($(".navbar-fixed-top").height());$(".no-overlap").css("marginTop", header_height+20);

        // SCRIPT FOR PRODUCT SIDEBAR STICKY (EXPANDABLE)
            /*function collision($div1, $div2) {
                if ( $div1.length > 0 && $div2.length > 0 ) {
                    var x1 = $div1.offset().left;
                    var y1 = $div1.offset().top;
                    var h1 = $div1.outerHeight(true);
                    var w1 = $div1.outerWidth(true);
                    var b1 = y1 + h1;
                    var r1 = x1 + w1;
                    var x2 = $div2.offset().left;
                    var y2 = $div2.offset().top;
                    var h2 = $div2.outerHeight(true);
                    var w2 = $div2.outerWidth(true);
                    var b2 = y2 + h2;
                    var r2 = x2 + w2;
                    if (b1 < y2 || y1 > b2 || r1 < x2 || x1 > r2) return false;
                    return true;
                } else {
                    return false;
                }
            }
            if ( $('body').hasClass('page-template-template-product-filter-php') ||
            $('body').hasClass('page-template-template-keep') ||
            $('body').hasClass('page-template-template-rent') ||
            $('body').hasClass('page-template-template-sell') ) {

                $(window).scroll(function(e) {
                    var scroll_top = $(window).scrollTop();
                    var nav_h = $('nav#cc-navbar').outerHeight();
                    var dark_h = $('.cc-filter-dark').outerHeight();
                    var total_h;
                    var product_banner = $('.product-filter-banner');
                    if ( product_banner.length > 0 && typeof product_banner !== 'undefined' ) {
                        var p_h = product_banner.outerHeight();
                        total_h = nav_h + dark_h + p_h;
                    } else {
                        total_h = nav_h + dark_h;
                    }
                    if ( collision( $('.navbar-fixed-top.shrink'), $('.cpm-filter-result-open form.filter-form-left') ) || scroll_top >= total_h ) {
                        $('.cpm-filter-result-open #cbp-spmenu-s1').addClass('sticky');
                        $('.cpm-filter-result-open #cbp-spmenu-s1').css({
                            'position': 'fixed',
                            'top' : nav_h
                        });
                    } else {
                        $('.cpm-filter-result-open #cbp-spmenu-s1').removeClass('sticky');
                        $('.cpm-filter-result-open #cbp-spmenu-s1').css({
                            'position': 'static',
                            'top' : '0px'
                        });
                    }
                    if ( collision( $('.cpm-filter-result-open #cbp-spmenu-s1'), $('footer#colophon') ) ) {
                        $('.cpm-filter-result-open #cbp-spmenu-s1').removeClass('sticky');
                        $('.cpm-filter-result-open #cbp-spmenu-s1').css({
                            'position': 'absolute',
                            'bottom' : '0px',
                            'top' : 'auto'
                        });
                    }
                });

            }*/
        // END SCRIPT FOR PRODUCT SIDEBAR STICKY (EXPANDABLE)

    // MIN-HEIGHT SLIDER LINK
    $('.slider-link-sec li a').css('min-height', '0');
    var minHeight = parseInt(0);
    $(".slider-link-sec li a").each(function(){
        if($(this).outerHeight() > minHeight){
            minHeight = $(this).outerHeight();
        }
    });
    if( minHeight < 100 ){
        minHeight = 100;
    }
    $('.slider-link-sec li a').css('min-height', minHeight);

        $("body").tooltip({ selector: '[data-toggle=tooltip]' });$(".burger").click(function(){$(this).toggleClass("selected");});
        function bx_reloadSlider(){
            if( slider_other_product.length != 0 && slider_works_well.length != 0  ){if( $(window).width() <= 640 ) {param_small.minSlides = 2;param_small.slideWidth = 245,param_small.slideMargin = 5,slider_other_product.reloadSlider( param_small );slider_works_well.reloadSlider( param_small );}else {if( slider_other_product.length > 0 && slider_works_well.length > 0  ){slider_other_product.reloadSlider( param_large );slider_works_well.reloadSlider( param_large );}}}
        }
        $('#woo-remove-user').on('click',function(e){e.preventDefault();var confirm_t = confirm('Are you sure to remove your account? Cannot undo the process');if( confirm_t ) {$.ajax({
            url        : script_modal.ajax_url,data       : {action    : 'remove_woo_user_account',ajax_nonce : script_modal.ajax_nonce},type       : 'POST',dataType   :'JSON',beforeSend : function(){},success : function( res ) {if( res.status ) {$('#alert-msg').html( res.message );$('#woo-user-remove-alert').addClass('alert-success');setTimeout(function(){window.location.href = script_modal.base_url;},2000);} else {$('#alert-msg').html( res.message );$('#woo-user-remove-alert').addClass('alert-warning');}}});}return false;});
        $('.cc-slides-desktop ').addClass('wow fadeInUp');
        wow = new WOW(
            {boxClass:'wow',animateClass: 'animated',offset:0,mobile:true,live:true});wow.init();$('.cc-hover-block').css('min-height', '0');var minHeight = parseInt(0);$(".cc-hover-block").each(function(){if($(this).outerHeight() > minHeight){minHeight = $(this).outerHeight();}});$('.cc-hover-block').css('min-height', minHeight);$('.slider-wrap .bxslider').bxSlider({
                auto : true,
                pager: false,
                controls : false
            });
    // TESTIMONIAL SLIDER
    $('#testimonials .bxslider').bxSlider({auto : true,pager: false,nextText: '<span class="fa fa-angle-right" aria-hidden="true"></span>',prevText: '<span class="fa fa-angle-left" aria-hidden="true"></span>',speed: 1000,pause: 10000
});
    $('#testimonials .slides .quote p').contents().unwrap();
    // TEAM SLIDER
    $('#team .bxslider').bxSlider({auto : true,pager: false,minSlides: 2,maxSlides: 3,slideWidth: 280,nextText: '<span class="fa fa-angle-right" aria-hidden="true"></span>',prevText: '<span class="fa fa-angle-left" aria-hidden="true"></span>',
});
    $('.page-scroll-nav a, .scroll-down').click(function() {if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {var target = $(this.hash);var headerHeight = parseInt( $('#cc-navbar.navbar.shrink').outerHeight() ) || 0; target = target.length ? target : $('[name=' + this.hash.slice(1) +']');if (target.length) {$('html,body').animate({scrollTop: target.offset().top - headerHeight}, 1000);  return false;}}});
    // CC-FILTER GRID-ITEM ( DIAGNOSTIC )
    $('.grid-item').mouseenter( function( ){$(this).addClass('active');var actualHeight = $(this).height();$(this).closest('ul.cc_filter.row').addClass('hovered');}).mouseleave(function() {$(this).removeClass('active');var actualHeight = $(this).height();$(this).closest('ul.cc_filter.row').removeClass('hovered');});
    // VC CPM-GRID-GALLERY-CONTAINER
    $('.cpm-gallery-grid-container').find('.wpb_wrapper').children().addClass('cpm-gallery-grid');
    var divs = $(".cpm-gallery-grid");
    for(var i = 0; i < divs.length; i+=3) {divs.slice(i, i+3).wrapAll("<div class='cpm-gallery-grid-row'></div>");}
      $('.cpm-gallery-grid').mouseenter( function( ){$(this).addClass('active');}).mouseleave(function() {$(this).removeClass('active');});
    // ADDIONTIAL FILTER
    $('.cpm-toggle-option').on( 'click' ,function( event ) {event.preventDefault();$('.option-filter-lists').slideToggle();$(this).toggleClass('open');});
    // CUSTOMER RATING & REVIEWS
    $('#comments').find('.comment-meta').each(function(){$(this).closest('.comment').prepend('<div class="meta-wrap"></div>');var insertLoc = $(this).closest('.comment').find('.meta-wrap');var insertreview = $(this).closest('.comment').find('.review_rate');$(this).find('.cpm-metabox').appendTo(insertLoc);insertreview.appendTo(insertLoc);});

    var floor_id;
    $('a.cpm-floor').on('click', function() {if ( $(this).hasClass('selected') ) {$(this).removeClass('selected');} else {$('body').find('a.cpm-floor').each( function() {$(this).removeClass('selected');});$(this).addClass('selected');}floor_id = $(this).find('[name="floor_id"]').val();});
    $('a.cpm-fibre').on('click', function() {if ( $(this).hasClass('selected') ) {$(this).removeClass('selected');} else {$('body').find('a.cpm-fibre').each( function() {$(this).removeClass('selected');});$(this).addClass('selected');}
        var fibre_id = '';
        fibre_id = $(this).find('[name="fibre_id"]').val();
        if ( typeof floor_id === 'undefined' ) {alert('Please select the kind of your floor.');} else {$.ajax({
            url        : script_modal.ajax_url,
            data       : {
                action    : 'filter_stan_removal',
                floor_id: floor_id,
                fibre_id: fibre_id
            },
            type       : 'POST',
            success : function( res ) {jQuery('#cpm-stain-removal').html(res);}});}});
    var stain_param = '';
    var fibre_param = '';
    $('.cpm-stain-filter').on( 'click', function(e) {e.preventDefault();var taxonomy    = $(this).data('taxonomy');var top_term_id = $(this).data('tab');if ( taxonomy == 'top_five_taxonomy' ) {if ( stain_param == top_term_id ) {$(this).removeClass('selected');} else {stain_param = top_term_id;$('a.cpm-stain.selected').not(this).removeClass('selected');$(this).addClass('selected');}if ( $(this).hasClass('selected') ) {stain_param = $(this).data('tab');} else {stain_param = '';}} else if ( taxonomy == 'fibre_taxonomy' ) {if ( fibre_param == top_term_id ) {$(this).removeClass('tab-active');} else {fibre_param = top_term_id;$('ul.tab-filters-list li a.tabss.tab-active').not(this).removeClass('tab-active');$(this).addClass('tab-active');}if ( $(this).hasClass('tab-active') ) {fibre_param = $(this).data('tab');} else {fibre_param = '';}}
        $.ajax({
            url        : script_modal.ajax_url,
            data       : {
                action    : 'top_term_stains',
                stain_id: stain_param,
                fibre_id: fibre_param
            },
            type       : 'POST',
            success : function( res ) {
                $('html, body').animate({scrollTop: $('.tab-filters').parent().offset().top-60
            },500);jQuery('#cpm-stain-removal').html(res);

                jQuery('#cpm-stain-removal .steps-col .cpm-st-rm').mCustomScrollbar();
            }});});
    $('.ubermenu-item').find('.cc-gallery').each( function() {$(this).find('.hover-cross').wrapInner('<span></span>');});
    // ****************** CPM ADDED SCRIPTS ENDS ****************** //
    $('.vc_row-fluid').find('.cc-designer-troubleshoot a').each( function() {var href = $(this).attr('href');$(this).data('link', href);$(this).attr('href', '#');});
    $('.vc_row-fluid').find('.cc-designer-troubleshoot a').on( 'click', function(e) {e.preventDefault();var href = $(this).data('link');var explode_href = href.split('/');$('#post-popup-style-guide-cc').data('postname',explode_href[4]);$('#style-guide-modal-popup').modal('show');});
    $('#style-guide-modal-popup').on('show.bs.modal', function() {var postname = $('#post-popup-style-guide-cc').data('postname');
        $.ajax({
            url : filter_modal.ajax_url+'?action=cpm_filter_troubleshoot',
            type: 'POST',
            data: {
                postname: postname
            },
            dataType : 'html',
            beforeSend : function(){
               var text = "loading",
               new_text = text,
               prefix = '<div class="cc-loader"> <div class="loader">',
               suffix = '</div></div>';
               $('#post-popup-style-guide-cc').html(prefix+ text + suffix);
           },
           success: function( response ) {$('#post-popup-style-guide-cc').html( response );
           setTimeout(function(){jQuery('.smart-page-loader').remove();},500);}});
    });
    $('#add_comment_rating_wrap, p.review-title-form, p.comment-form-comment').insertBefore('p.comment-form-author');
    $('a.cpm-likes').on( 'click', function(e) {e.preventDefault();var _this = $(this);var attr_id = _this.attr('id');var comment_ID = attr_id.split('-');
        $.ajax({
            url : filter_modal.ajax_url+'?action=cpm_comment_likes',
            type: 'POST',
            data: {
                comment_ID: comment_ID[2],
                cmt_action: comment_ID[0]+'-'+comment_ID[1],
            },
            success: function( response ) {var data = $.parseJSON(response);if ( data.key == 'cpm-like' ) {_this.find('i.fa-thumbs-up').html('('+data.value+')');} else {_this.find('i.fa-thumbs-down').html('('+data.value+')');}}});
    });
    if( jQuery('body').hasClass('single-product') ) {jQuery('#what-others-say').append(jQuery('#comments'));jQuery('#review_rating_1').trigger('click');jQuery('input[name=author]').attr('placeholder', 'What is your name?');jQuery('input[name=email]').attr('placeholder', 'What is your email? (not displayed)');jQuery('.contribution-karma').each(function(){if( jQuery(this).text().length <= 2 ) {jQuery(this).hide();}})}
    $('a.cpm-like-btn').on('click', function(e) {e.preventDefault();var _this = $(this);$(this).addClass('loading');var user_id = $(this).data('userid');var media_id = $(this).data('imgid');var large_img = $(this).data('largeurl');var small_img = $(this).data('smallurl');if ( user_id != 0 || user_id.length > 0 ) {$.ajax({url        : script_modal.ajax_url,data       : {action    : 'add_img_wishlists',user_id : user_id,media_id : media_id,large_img : large_img,small_img : small_img},type       : 'POST',success : function( res ) {if ( res == 1 ) {var html = '<div class="cpm-response">Images is added to your wishlist. Click <a href="'+script_modal.base_url+'wishlist/view/">Here</a> to view your wishlist.</div>';$('#like-img-modal .img-modal-body').html(html);$('#like-img-modal').modal('show');} else {var html = '<div class="cpm-response">Something went wrong. Please try again.</div>';$('#like-img-modal .img-modal-body').html(html);$('#like-img-modal').modal('show');}_this.removeClass('loading');}});}});
    $('a.remove_wishlist_img').on('click', function(e) {e.preventDefault();if ( confirm('Are you sure you want to delete this?') ) {var _this = $(this);_this.addClass('loading');var rowid = _this.data('rowid');$.ajax({url        : script_modal.ajax_url,data       : {action    : 'remove_img_wishlists',rowid : rowid,},type       : 'POST',success : function( res ) {if ( res == 1 ) {_this.removeClass('loading');var remove_el = _this.parent().closest('tr');remove_el.hide('slow', function(){ remove_el.remove(); });}}});}});
    if ( jQuery('#cpm-measures-quote').length > 0) {jQuery('#cpm-measures-quote').submit(function(e) {e.preventDefault();}).validate({rules: {your_name:{required: true,},street_address:{required: true,},your_message:{required: true,},nearest_store:{required: true,},your_email: {required: true,email: true}},submitHandler: function(form) {var product_name = jQuery('[name="product_name"]').val();var your_name = jQuery('[name="your_name"]').val();var your_email = jQuery('[name="your_email"]').val();var interests = jQuery('input.cpm_interests:checked').map(function(){return jQuery(this).val();}).get();var street_address = jQuery('[name="street_address"]').val();var cities_towns = jQuery('[name="cities_towns"]').val();var day_phone_number = jQuery('[name="day_phone_number"]').val();var nearest_store = jQuery('[name="nearest_store"]').val();var preferred_date = jQuery('[name="preferred_date"]').val();var promo_code = jQuery('[name="promo_code"]').val();var your_message = jQuery('[name="your_message"]').val();var selected_color = jQuery('input[name="selected[product_color]"]').map(function(){return jQuery(this).val();}).get();var selected_floor_life = jQuery('input[name="selected[pa_floor]"]').map(function(){return jQuery(this).val();}).get();var selected_style_life = jQuery('input[name="selected[pa_style]"]').map(function(){return jQuery(this).val();}).get();var selected_color_life = jQuery('input[name="selected[child_product_color]"]').map(function(){return jQuery(this).val();}).get();var selected_rent = jQuery('input[name="selected[pa_rent]"]').map(function(){return jQuery(this).val();}).get();var selected_sell = jQuery('input[name="selected[pa_sell]"]').map(function(){return jQuery(this).val();}).get();var product_brand = jQuery('input[name="selected[product_brand]"]').map(function(){return jQuery(this).val();}).get();var product_cat = jQuery('input[name="selected[product_cat]"]').map(function(){return jQuery(this).val();}).get();var pa_rooms = jQuery('input[name="selected[pa_rooms]"]').map(function(){return jQuery(this).val();}).get();var ajax_loader = jQuery('.ajax-loader');var main_form = jQuery(form);jQuery(ajax_loader).css("visibility", "visible");
      jQuery.ajax({type:"POST",url: filter_modal.ajax_url,dataType: 'json',data: {action: 'cpm_book_measures_quotes',product_name: product_name,your_name: your_name,your_email: your_email,interests: interests,street_address: street_address,cities_towns: cities_towns,day_phone_number: day_phone_number,nearest_store: nearest_store,preferred_date: preferred_date,promo_code: promo_code,your_message: your_message,selected_color: selected_color,pa_floor: selected_floor_life,pa_style: selected_style_life,product_color: selected_color_life,pa_rent: selected_rent,pa_sell: selected_sell,product_brand: product_brand,product_cat: product_cat,pa_rooms: pa_rooms,ajax: 1,},success: function(results){jQuery(ajax_loader).css("visibility", "hidden");main_form.find("input[type=text], input[type=email], textarea").val("");main_form.find('input.cpm_interests:checked').removeAttr('checked');if ( results == true ) {jQuery('.wpcf7-response-output').html('<span class="response-result">Thank you for your message. It has been sent.</span>');} else {jQuery('.wpcf7-response-output').html('<span class="response-result">There was an error trying to send your message. Please try again later.</span>');}},error: function(results) {}});}});}
    $("#wpsl-stores").mCustomScrollbar();$('#show-login').on('click',function(e){e.preventDefault();$('.user-register-heading').addClass('hidden');$('#register').addClass('hidden');$('.user-login-heading').removeClass('hidden');$('#login').removeClass('hidden');$('.forgot-password').addClass('hidden');});
	$('#flogin').on('click',function(e){e.preventDefault();$('.user-register-heading').addClass('hidden');$('#register').addClass('hidden');$('.user-login-heading').removeClass('hidden');$('#login').removeClass('hidden');$('.forgot-password').addClass('hidden');});

	$('#forgot-password').on('click',function(e){e.preventDefault();$('.user-register-heading').addClass('hidden');$('#register').addClass('hidden');$('.user-login-heading').addClass('hidden');$('.forgot-password').removeClass('hidden');$('#login').addClass('hidden');});


	$('#wishlist-form').on('hidden.bs.modal',function(){$('.user-register-heading').removeClass('hidden');$('#register').removeClass('hidden');$('.user-login-heading').addClass('hidden');$('#login').addClass('hidden');});
    var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(','); $('.number_count').each(function(){var num = $(this).data('number'), ID = $(this).attr('id'); $('#' + ID).animateNumber({number : num, numberStep: comma_separator_number_step },5000); });
    $('#top-notification').bxSlider({
      mode: 'horizontal',
      controls: false,
      auto: true,
      moveSlides: 1,
      pager: false,
      responsive: true,
      // slideMargin: 5
    });

    if ( $('body').hasClass('onepage-scroll') && $(window).width() >= 768 ) {
        if ( $('.vc_tta-tabs').length > 0 ) {
            $('.vc_tta-tabs').find( '.vc_tta-panels .vc_tta-panel').each( function() {
                    $(this).find('.vc_tta-panel-body').mCustomScrollbar();
            });
        }
    }

    // from cc-custom.js
    var windowWidth = $(window).width();
        if( windowWidth > 767){
            var count = parseInt(1);
            if( $('body').find('.slider-view').length < 1 ){
                count = parseInt(0);
            }
            $('.onepage-scroll').find('.entry-content > .vc_row').each(function(e){
                if( !$(this).hasClass('scroll-sec') ){
                    var sec_name = $(this).attr('id');
                    if ( typeof sec_name === 'undefined') {
                        sec_name = 'Section';
                    }
                    $(this).attr('id', 'section-'+count);
                    $(this).addClass('scroll-sec');
                    $(this).hide();
                    $('.slider-menu-section').find('.slier-menu-right').append('<li><a href="#section-'+count+'"> <span></span> </a><div class="tooltip"><span>'+sec_name+'</span></div></li>');
                    count += 1;
                }
            });
            if( $('body').find('.slider-view').length < 1 ){
                $('body').find('#section-0').addClass('active');
            }
            if( $('body').hasClass('onepage-scroll') ){
                $('body').find('.slider-menu-section').show();
                $('.slider-view').attr('id', 'section-0');

                var pref = count-1;
                $('body').find('.scroll-sec.active').show();
                $('body').find('#section-'+pref).addClass('prefooter-section');
                $('body').find('.scroll-sec.active').css({"transform":"translateY(0%)","-ms-transform":"translateY(0%)", "-moz-transform":"translateY(0%)", "-o-transform":"translateY(0%)"});
                $('body').find('.scroll-sec.active').nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                $('body').find('.scroll-sec.active').prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
            }
        }else{
            $('body').find('.slider-menu-section').hide();
            if( !$('body').hasClass('home') ){
                $('body').find('.cc-scroll-down').hide();
            }else{
                $('body').find('.cc-scroll-down').addClass('mobile-jump');
            }
            $('body').removeClass('onepage-scroll');
            $('body').find('.slider-view').removeClass('scroll-sec active');
            // scroll function
            $('body').find('.scroll-sec').css({"transform":"translateY(none)","-ms-transform":"translateY(none)", "-moz-transform":"translateY(none)", "-o-transform":"translateY(none)"});
        }
        // TO GET BROWSER AND IPHONE DETAILS ON BODY
        // Get browser
        $.each($.browser, function(i) {
            $('body').addClass(i);
            return false;
        });
        // Get OS
        var os = [
            'iphone',
            'ipad',
            'windows',
            'mac',
            'linux'
        ];
        var match = navigator.appVersion.toLowerCase().match(new RegExp(os.join('|')));
        if (match) {
            $('body').addClass(match[0]);
        };

        // SCRIPT FOR SCROLL DOWN (ROUND SCROLL DOWN BUTTON IN HOME BANNER )
        $('.slider-menu-section').find('a[href*=#]:not([href=#])').on('click', function(e) {
            var targetDiv = $(this).attr('href');
            if( $('body').hasClass('onepage-scroll') ){
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    e.preventDefault();
                    $('body').find('.scroll-sec').removeClass('active');
                    $('body').find(targetDiv).addClass('active');
                    $('body').find('.slier-menu-right a').removeClass('active');
                    $(this).addClass('active');
                    if( $('body').find(targetDiv).hasClass('prefooter-section') ){
                        $('body').find('.prefooter-section').css('height', 'auto');
                        $('body').find('.site-footer').addClass('at-bottom');
                        var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                        var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                        var totalHeight = prefooterHeight+footerHeight;

                        var section_num = parseInt(targetDiv.split(/[-]+/).pop());
                        section_num -= 1;
                        $('body').find(targetDiv).prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                        $('body').find(targetDiv).nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find('#section-'+section_num).css({"transform":"translateY(-"+totalHeight+"px)","-ms-transform":"translateY(-"+totalHeight+"px)", "-moz-transform":"translateY(-"+totalHeight+"px)", "-o-transform":"translateY(-"+totalHeight+"px)"});
                        $('body').find(targetDiv).css({"transform":"translateY(-"+footerHeight+"px)","-ms-transform":"translateY(-"+footerHeight+"px)", "-moz-transform":"translateY(-"+footerHeight+"px)", "-o-transform":"translateY(-"+footerHeight+"px)"});
                        $('body').find('.site-footer').css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                    }else{
                        $('body').find('.site-footer').removeClass('at-bottom');
                        $('body').find(targetDiv).nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find(targetDiv).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                        $('body').find(targetDiv).prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                        $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('.scroll-sec').find('.cc-scroll-down').remove();
                        $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                    }
                    // add remove shrink menu
                    if( targetDiv == '#section-0' ){
                        $('nav.navbar-fixed-top').removeClass('shrink')
                    }else{
                        if( !$('nav.navbar-fixed-top').hasClass('shrink') ){
                            $('nav.navbar-fixed-top').addClass('shrink');
                        }
                    }

                }
            }
        });

        // click function for slider links below images
        $('.slider-link-sec').find('a[href*=#]:not([href=#])').on('click', function(e) {
            var targetDiv = $(this).attr('href');
            if( $('body').hasClass('onepage-scroll') ){
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    e.preventDefault();
                    $('body').find('.scroll-sec').removeClass('active');
                    $('body').find(targetDiv).addClass('active');
                    $('body').find('.slier-menu-right a').removeClass('active');
                    $('.slider-menu-section').find('a[href="'+targetDiv+'"]').addClass('active');
                    if( $('body').find(targetDiv).hasClass('prefooter-section') ){
                        $('body').find('.prefooter-section').css('height', 'auto');
                        $('body').find('.site-footer').addClass('at-bottom');
                        var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                        var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                        var totalHeight = prefooterHeight+footerHeight;

                        var section_num = parseInt(targetDiv.split(/[-]+/).pop());
                        section_num -= 1;
                        $('body').find(targetDiv).prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                        $('body').find(targetDiv).nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find('#section-'+section_num).css({"transform":"translateY(-"+totalHeight+"px)","-ms-transform":"translateY(-"+totalHeight+"px)", "-moz-transform":"translateY(-"+totalHeight+"px)", "-o-transform":"translateY(-"+totalHeight+"px)"});
                        $('body').find(targetDiv).css({"transform":"translateY(-"+footerHeight+"px)","-ms-transform":"translateY(-"+footerHeight+"px)", "-moz-transform":"translateY(-"+footerHeight+"px)", "-o-transform":"translateY(-"+footerHeight+"px)"});
                        $('body').find('.site-footer').css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                    }else{
                        $('body').find('.site-footer').removeClass('at-bottom');
                        $('body').find(targetDiv).nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find(targetDiv).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                        $('body').find(targetDiv).prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                        $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('.scroll-sec').find('.cc-scroll-down').remove();
                        $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                    }
                    // for removing top nav
                    if( targetDiv == '#section-0' ){
                        $('nav.navbar-fixed-top').removeClass('shrink')
                    }else{
                        if( !$('nav.navbar-fixed-top').hasClass('shrink') ){
                            $('nav.navbar-fixed-top').addClass('shrink');
                        }
                    }
                }
            }
        });
        // clicking on down button
        $('.scroll-sec').find('.cc-scroll-down').on('click', function(e){
            e.preventDefault();
            var current_menu = $('.slier-menu-right').find('a.active');
            if( current_menu.closest('li').next('li').length > 0 ){
                current_menu.closest('li').next('li').find('a').trigger('click');
            }
        });
        // click for mobile device
        $('.slider-view').find('.mobile-jump').on('click', function(e){
            e.preventDefault();
            var offset = 0; //Offset of 20px
            jQuery('html, body').animate({
                scrollTop: jQuery(".slider-view").next('div').offset().top + offset
            }, 1000);
        });

        // trigger bootstrap modal on clicking the video//videogallery-row //vc_column-inner
        $('.vc_column-inner').find('.cc-watch-column, .cc-watch-column a.vc_general').on('click', function(evt){
            evt.preventDefault();
            if( $(this).hasClass('vc_btn3') ){
                var vid_url = $(this).attr('onclick'); //null
            }else{
                var vid_url = $(this).find('a.vc_general').attr('onclick');
            }
            var current = $(this);
            if( vid_url != ''){
                $.ajax({
                    url: script_modal.ajax_url,
                    type: 'post',
                    data: {
                        action: 'cc_watch_videos',
                        vid_url: vid_url
                    },
                    success: function( result ) {
                        $('#video-embed-sec').find('.embed-vid-sec').empty();
                        $('#video-embed-sec').find('.embed-vid-sec').html(result);
                        $('#video-embed-sec').modal('show');
                    }
                });
            }
        });
        // close video on closing iframe
        $('#video-embed-sec').on('hidden.bs.modal', function () {
            var src = $(this).find('iframe').attr('src');
            $(this).find('iframe').attr('src', '');
        });
        // adding submenu icon for mobile submenu
        jQuery('<i class="fa fa-angle-down"></i>').insertAfter('.navbar-mobile .ubermenu-item-has-children > a');
        jQuery('.navbar-mobile i.fa').click(function(evt) {
          jQuery(this).closest('.ubermenu-item-has-children').toggleClass('ubermenu-active');
        });
        // custom code to add product to wishlist
        // if( $('.yith-wcwl-add-to-wishlist').find('').length > 0 ){
        // }else{
        // }
        $('.custom-addtowishlist-btn').on('click', function(evt) {
            evt.preventDefault;
            var wishBtn = $(this);
            if( $('.yith-wcwl-add-to-wishlist').find('#cpm_wishlist_popup').length > 0 ){
                $(this).closest('.product').find('#cpm_wishlist_popup').trigger('click');
            }else{ //yith-wcwl-add-button
                $(this).closest('.product').find('.cpm_add_to_wishlist.single_add_to_wishlist').trigger('click');
                setTimeout(function() {
                    wishBtn.addClass('hide');
                    wishBtn.hide();
                }, 150);
            }
        });
        // for datalayer
        $( document ).ajaxComplete(function( events,request, settings ) {
            if( (request.status == 200) && ( (request.statusText == 'success')||request.statusText == 'OK' ) ){
                // console.log(events);
                // console.log(request);
                // console.log(settings);
                // store_name
                var settingData = settings.data;
                var action = getActionByName('action', settingData);
                var settingUrl = settings.url;
                var actionUrl = getParameterByName('action', settingUrl);
                console.log('action url is ' + actionUrl);
                if( action == 'send_all_wishlists'){
                    var store_name = getDataByName('store_name', settingData);
                    // console.log('storename is ' + store_name);
                    dataLayer.push({
                         "event": "wishlistSent",
                         "store": store_name
                    });
                }
                if ( actionUrl == 'filter_product' ) {
                    var product_catt = $('#collapse-product_cat').find('.cpm-parent.active').data('slug');

                    if ( typeof product_catt !== 'undefined' ) {
                        dataLayer.push({
                             "event": "productFilter",
                             "type": product_catt
                        });

                    }
                }
                if( actionUrl == 'store_search' ){
                    var address = $('#wpsl-search-wrap').find('#wpsl-search-input').val();
                    dataLayer.push({
                         "event": "storeLocationSearch",
                         "searchedLocation": address
                    });
                }else if( actionUrl == 'update_wishlist_count'){
                    var productName = $('#content').find('h1.product_title').text();
                    dataLayer.push({
                         "event": "AddtoWishlist",
                         "productName": productName
                    });
                }
            }
        });

        function getParameterByName(name, url) {
            if (!url) {
              url = window.location.href;
            }
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
        function getActionByName(name, dataa) {
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp(name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(dataa);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
        function getDataByName(name, dataa) {
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(dataa);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // hide the add to wishlist logo for alrady added
        if( jQuery('.yith-wcwl-add-to-wishlist').find('.yith-wcwl-wishlistexistsbrowse').hasClass('show') ){
            jQuery('.custom-addtowishlist-btn').addClass('hide');
        }
        // scroll function
        var mouseEvent = "mousewheel";
        if( $('body').hasClass('mozilla') ){
            mouseEvent = "DOMMouseScroll";
        }
        var isDoingStuff = false;
        // Opera 8.0+
        var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
            // Firefox 1.0+
        var isFirefox = typeof InstallTrigger !== 'undefined';
            // At least Safari 3+: "[object HTMLElementConstructor]"
        var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
            // Internet Explorer 6-11
        var isIE = /*@cc_on!@*/false || !!document.documentMode;
            // Edge 20+
        var isEdge = !isIE && !!window.StyleMedia;
            // Chrome 1+
        var isChrome = !!window.chrome && !!window.chrome.webstore;
            // Blink engine detection
        var isBlink = (isChrome || isOpera) && !!window.CSS;

        if(isIE==true){

        // $(window).scroll(function(event){
        $(window).bind('wheel', function(event){
            $('body').find('.scroll-sec').show();
            var windowWidth = $(window).width();
            if( windowWidth > 767){
                var headerHeight = parseInt( $('#cc-navbar').outerHeight() ) || 0;
                if( $('body').hasClass('onepage-scroll') ){
                    event.preventDefault();
                    var currentdiv = $('body').find('.scroll-sec.active');
                    var current_id = $('body').find('.scroll-sec.active').attr('id');
                    var id_num = parseInt(current_id.split(/[-]+/).pop());
                     if (event.originalEvent.deltaY > 0 || event.originalEvent.detail < 0) {
                    //scrolled down
                        if ($('#section-0').hasClass("active")){
                            if( !$('nav.navbar-fixed-top').hasClass('shrink') ){
                                $('nav.navbar-fixed-top').addClass('shrink');
                            }
                        }
                        if (!$('.prefooter-section').hasClass("active")){
                            if(isDoingStuff) { return; }
                            isDoingStuff = true;
                            currentdiv.removeClass('active');
                            id_num += 1;
                            $('body').find('#section-'+id_num).addClass('active');
                            if( !$('.prefooter-section').hasClass('active') ){
                                currentdiv.css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                                currentdiv.nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                                $('body').find('.slier-menu-right a').removeClass('active');
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                                $('.scroll-sec').find('.cc-scroll-down').remove();
                                $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                            }else{
                                $('body').find('.prefooter-section').css('height', 'auto');
                                var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                                var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                                var totalHeight = prefooterHeight+footerHeight;
                                $('body').find('.slier-menu-right a').removeClass('active');
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                currentdiv.css({"transform":"translateY(-"+totalHeight+"px)","-ms-transform":"translateY(-"+totalHeight+"px)", "-moz-transform":"translateY(-"+totalHeight+"px)", "-o-transform":"translateY(-"+totalHeight+"px)"});
                                $('.prefooter-section').css({"transform":"translateY(-"+footerHeight+"px)","-ms-transform":"translateY(-"+footerHeight+"px)", "-moz-transform":"translateY(-"+footerHeight+"px)", "-o-transform":"translateY(-"+footerHeight+"px)"});
                                $('body').find('.site-footer').css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                                $('body').find('.site-footer').addClass('at-bottom');
                            }
                            setTimeout(function() {isDoingStuff = false;}, 150);
                        }
                    }else{
                        //scrolled up
                        if( $('.site-footer').hasClass('at-bottom') ){
                            if(isDoingStuff) { return; }
                            isDoingStuff = true;
                            currentdiv.removeClass('active');
                            $('body').find('.site-footer').removeClass('at-bottom');
                            $('body').find('.slier-menu-right a').removeClass('active');
                            id_num -= 1;
                            $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                            currentdiv.css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                            $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                            $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                            $('body').find('#section-'+id_num).addClass('active');
                            setTimeout(function() {isDoingStuff = false;}, 150);
                        }else if (!$('#section-0').hasClass("active")){
                            if(isDoingStuff) { return; }
                            isDoingStuff = true;
                            currentdiv.removeClass('active');
                            $('body').find('.site-footer').removeClass('at-bottom');
                            currentdiv.css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                            $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                            currentdiv.prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                            $('body').find('.slier-menu-right a').removeClass('active');
                            id_num -= 1;
                            $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                            $('body').find('#section-'+id_num).addClass('active');
                            $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                            setTimeout(function() {isDoingStuff = false;}, 150);
                            $('.scroll-sec').find('.cc-scroll-down').remove();
                            $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                            if( id_num == 0 ){
                                if( $('nav.navbar-fixed-top').hasClass('shrink') ){
                                    $('nav.navbar-fixed-top').removeClass('shrink');
                                }
                            }
                        }
                    }
                }
            }else{
                console.log('scrolled just');
            }
        });
} else {
     $(window).bind(mouseEvent, function(event){
        $('body').find('.scroll-sec').show();
        var windowWidth = $(window).width();
        if( windowWidth > 767){
            var headerHeight = parseInt( $('#cc-navbar').outerHeight() ) || 0;
            if( $('body').hasClass('onepage-scroll') ){
                event.preventDefault();
                var currentdiv = $('body').find('.scroll-sec.active');
                var current_id = $('body').find('.scroll-sec.active').attr('id');
                var id_num = parseInt(current_id.split(/[-]+/).pop());
                if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
                    //scrolled up
                    if( $('.site-footer').hasClass('at-bottom') ){
                        if(isDoingStuff) { return; }
                        isDoingStuff = true;
                        currentdiv.removeClass('active');
                        $('body').find('.site-footer').removeClass('at-bottom');
                        $('body').find('.slier-menu-right a').removeClass('active');
                        id_num -= 1;
                        $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                        currentdiv.css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                        $('body').find('#section-'+id_num).addClass('active');
                        setTimeout(function() {isDoingStuff = false;}, 150);
                    }else if (!$('#section-0').hasClass("active")){
                        if(isDoingStuff) { return; }
                        isDoingStuff = true;
                        currentdiv.removeClass('active');
                        $('body').find('.site-footer').removeClass('at-bottom');
                        currentdiv.css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        currentdiv.prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                        $('body').find('.slier-menu-right a').removeClass('active');
                        id_num -= 1;
                        $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                        $('body').find('#section-'+id_num).addClass('active');
                        $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                        setTimeout(function() {isDoingStuff = false;}, 150);
                        $('.scroll-sec').find('.cc-scroll-down').remove();
                        $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                        if( id_num == 0 ){
                            if( $('nav.navbar-fixed-top').hasClass('shrink') ){
                                $('nav.navbar-fixed-top').removeClass('shrink')
                            }
                        }
                    }
                }else{
                    //scrolled down
                    if ($('#section-0').hasClass("active")){
                        if( !$('nav.navbar-fixed-top').hasClass('shrink') ){
                            $('nav.navbar-fixed-top').addClass('shrink')
                        }
                    }
                    if (!$('.prefooter-section').hasClass("active")){
                        if(isDoingStuff) { return; }
                        isDoingStuff = true;
                        currentdiv.removeClass('active');
                        id_num += 1;
                        $('body').find('#section-'+id_num).addClass('active');
                        if( !$('.prefooter-section').hasClass('active') ){
                            currentdiv.css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                            currentdiv.nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                            $('body').find('.slier-menu-right a').removeClass('active');
                            $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                            $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                            $('.scroll-sec').find('.cc-scroll-down').remove();
                            $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                        }else{
                            $('body').find('.prefooter-section').css('height', 'auto');
                            var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                            var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                            var totalHeight = prefooterHeight+footerHeight;
                            $('body').find('.slier-menu-right a').removeClass('active');
                            $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                            currentdiv.css({"transform":"translateY(-"+totalHeight+"px)","-ms-transform":"translateY(-"+totalHeight+"px)", "-moz-transform":"translateY(-"+totalHeight+"px)", "-o-transform":"translateY(-"+totalHeight+"px)"});
                            $('.prefooter-section').css({"transform":"translateY(-"+footerHeight+"px)","-ms-transform":"translateY(-"+footerHeight+"px)", "-moz-transform":"translateY(-"+footerHeight+"px)", "-o-transform":"translateY(-"+footerHeight+"px)"});
                            $('body').find('.site-footer').css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                            $('body').find('.site-footer').addClass('at-bottom');
                        }
                        setTimeout(function() {isDoingStuff = false;}, 150);
                    }
                }
            }
        }else{
            console.log('scrolled just');
        }
    });
}
        // touch move for mobile devices
        var isDoingStuff = false;
        $(window).bind('touchstart', function(e) {
            var swipe = e.originalEvent.touches,
            start = swipe[0].pageY;
            $('body').find('.scroll-sec').show();
            var windowWidth = $(window).width();
            if( windowWidth > 767){
                var headerHeight = parseInt( $('#cc-navbar').outerHeight() ) || 0;
                if( $('body').hasClass('onepage-scroll') ){
                    var currentdiv = $('body').find('.scroll-sec.active');
                    var current_id = $('body').find('.scroll-sec.active').attr('id');
                    var id_num = parseInt(current_id.split(/[-]+/).pop());
                    $(this).on('touchmove', function(events) {
                        var contact = e.originalEvent.touches,
                        end = contact[0].pageY,
                        distance = end-start;
                        events.preventDefault();
                        if (distance > 30) {
                            // up
                            if( $('.site-footer').hasClass('at-bottom') ){
                                if(isDoingStuff) { return; }
                                isDoingStuff = true;
                                currentdiv.removeClass('active');
                                $('body').find('.site-footer').removeClass('at-bottom');
                                $('body').find('.slier-menu-right a').removeClass('active');
                                id_num -= 1;
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                currentdiv.css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                                $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                                $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                                $('body').find('#section-'+id_num).addClass('active');
                                setTimeout(function() {isDoingStuff = false;}, 150);
                            }else if (!$('#section-0').hasClass("active")){
                                if(isDoingStuff) { return; }
                                isDoingStuff = true;
                                currentdiv.removeClass('active');
                                $('body').find('.site-footer').removeClass('at-bottom');
                                currentdiv.css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                                $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                                currentdiv.prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                                $('body').find('.slier-menu-right a').removeClass('active');
                                id_num -= 1;
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                $('body').find('#section-'+id_num).addClass('active');
                                $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                                setTimeout(function() {isDoingStuff = false;}, 150);
                                $('.scroll-sec').find('.cc-scroll-down').remove();
                                $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                                if( id_num == 0 ){
                                    if( $('nav.navbar-fixed-top').hasClass('shrink') ){
                                        $('nav.navbar-fixed-top').removeClass('shrink')
                                    }
                                }
                            }
                        }
                        if (distance < -30) {
                            events.preventDefault();
                            prefctn = $('.prefooter-section').length;
                            // down
                            if ($('#section-0').hasClass("active")){
                                if( !$('nav.navbar-fixed-top').hasClass('shrink') ){
                                    $('nav.navbar-fixed-top').addClass('shrink');
                                }
                            }
                            if (!$('.prefooter-section').hasClass("active")){
                                currentdiv.find('.cc-scroll-down').trigger('click');

                                // if(isDoingStuff) { return; }
                                // isDoingStuff = true;
                                // currentdiv.removeClass('active');
                                // id_num = id_num + 1;
                                // $('body').find('#section-'+id_num).addClass('active');
                                // if( $('body').find('.prefooter-section').hasClass('active') ){
                                //     $('body').find('.prefooter-section').css('height', 'auto');
                                //     var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                                //     var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                                //     var totalHeight = prefooterHeight+footerHeight;
                                //     $('body').find('.slier-menu-right a').removeClass('active');
                                //     $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                //     currentdiv.css({"transform":"translateY(-"+totalHeight+"px)","-ms-transform":"translateY(-"+totalHeight+"px)", "-moz-transform":"translateY(-"+totalHeight+"px)", "-o-transform":"translateY(-"+totalHeight+"px)"});
                                //     $('.prefooter-section').css({"transform":"translateY(-"+footerHeight+"px)","-ms-transform":"translateY(-"+footerHeight+"px)", "-moz-transform":"translateY(-"+footerHeight+"px)", "-o-transform":"translateY(-"+footerHeight+"px)"});
                                //     $('body').find('.site-footer').css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                                //     $('body').find('.site-footer').addClass('at-bottom');
                                // }else{
                                //     currentdiv.css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                                //     currentdiv.nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});

                                //     $('body').find('.slier-menu-right a').removeClass('active');
                                //     $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                //     $('body').find('#section-'+id_num).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                                //     $('.scroll-sec').find('.cc-scroll-down').remove();
                                //     $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                                // }
                                // setTimeout(function() {isDoingStuff = false;}, 150);

                            }
                        }
                    }).one('touchend', function() {
                        $(this).off('touchmove touchend');
                    });

                }
            }

        });//end for mobile sec

        // now unhide the section
        setTimeout(function() {
            $('body').find('.scroll-sec').show();
        }, 200);
        // for adding anchor links
        setTimeout(function() {
            if( $('body').hasClass('onepage-scroll') ){
                var urlHash = $(location).attr('hash');
                if( urlHash.length > 5 ){
                    $('body').find('.scroll-sec').removeClass('active');
                    $('body').find(urlHash).addClass('active');
                    $('body').find('.slier-menu-right a').removeClass('active');
                    $('.slier-menu-right').find('a[href="'+urlHash+'"]').addClass('active');
                    if( $('body').find(urlHash).hasClass('prefooter-section') ){
                        $('body').find('.prefooter-section').css('height', 'auto');
                        $('body').find('.site-footer').addClass('at-bottom');
                        var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                        var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                        var totalHeight = prefooterHeight+footerHeight;
                        var section_num = parseInt(urlHash.split(/[-]+/).pop());
                        section_num -= 1;
                        $('body').find(urlHash).prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                        $('body').find(urlHash).nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find('#section-'+section_num).css({"transform":"translateY(-"+totalHeight+"px)","-ms-transform":"translateY(-"+totalHeight+"px)", "-moz-transform":"translateY(-"+totalHeight+"px)", "-o-transform":"translateY(-"+totalHeight+"px)"});
                        $('body').find(urlHash).css({"transform":"translateY(-"+footerHeight+"px)","-ms-transform":"translateY(-"+footerHeight+"px)", "-moz-transform":"translateY(-"+footerHeight+"px)", "-o-transform":"translateY(-"+footerHeight+"px)"});
                        $('body').find('.site-footer').css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                    }else{
                        $('body').find('.site-footer').removeClass('at-bottom');
                        $('body').find(urlHash).nextAll('.scroll-sec').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('body').find(urlHash).css({"transform":"translateY(0)","-ms-transform":"translateY(0)", "-moz-transform":"translateY(0)", "-o-transform":"translateY(0)"});
                        $('body').find(urlHash).prevAll('.scroll-sec').css({"transform":"translateY(-100%)","-ms-transform":"translateY(-100%)", "-moz-transform":"translateY(-100%)", "-o-transform":"translateY(-100%)"});
                        $('body').find('.site-footer').css({"transform":"translateY(100%)","-ms-transform":"translateY(100%)", "-moz-transform":"translateY(100%)", "-o-transform":"translateY(100%)"});
                        $('.scroll-sec').find('.cc-scroll-down').remove();
                        $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                    }
                    if( urlHash == '#section-0' ){
                        $('nav.navbar-fixed-top').removeClass('shrink');
                    }else{
                        if( !$('nav.navbar-fixed-top').hasClass('shrink') ){
                            $('nav.navbar-fixed-top').addClass('shrink');
                        }
                    }
                }
            }
        }, 250);
        // now add height of scroll sec
        $('.onepage-scroll').find('.scroll-sec').each(function(evt){
            $(this).height( $(window.top).height() );
        });
        $(window).resize(function() {
            $('.onepage-scroll').find('.scroll-sec').each(function(evt){
                $(this).height( $(window.top).height() );
            });
        });
        // end of anchor links
        // MOUSE SCROLL //wheel
        $('body').find('.cpm-preloader').remove();
        // $(document).on("keyup", disable_reload);

        jQuery(window).resize(function(e){
            jQuery('.cc-hover-block').css('min-height', '0');
            var minHeight = parseInt(0);
            jQuery(".cc-hover-block").each(function(){
                if(jQuery(this).outerHeight() > minHeight){minHeight = jQuery(this).outerHeight();}});
            jQuery('.cc-hover-block').css('min-height', minHeight);
            bx_reloadSlider();
            jQuery('.slider-link-sec li a').css('min-height', '0');
            var minHeight = parseInt(0);
            jQuery(".slider-link-sec li a").each(function(){
                if(jQuery(this).outerHeight() > minHeight){
                    minHeight = jQuery(this).outerHeight();
                }
            });
            if( minHeight < 100 ){
                minHeight = 100;
            }
            jQuery('.slider-link-sec li a').css('min-height', minHeight);
        }).resize();
        // $("html,body").animate({ scrollTop: 0 });
        jQuery(window).scroll(function($) {if (jQuery(document).scrollTop() > 50) {jQuery('nav.navbar-fixed-top').addClass('shrink');} else {jQuery('nav.navbar-fixed-top').removeClass('shrink');}});if ( jQuery('body').hasClass('single-product') ) {jQuery('.cpm-breadcrumb li:nth-child(3)').remove();jQuery('.cpm-breadcrumb li:nth-child(2)').remove();}

        if ( disable_f == 1 ) {

            document.onkeydown = function(e) {
                // /our-advice/warranties/
                // var urlPath = window.location.pathname;
                // if( urlPath ==  '/contact-us/'){
                    return false;
                // }
            }
        }


        // from cpm-product.js
        jQuery('#color-tab').on('shown.bs.tab', function (e) {var color = jQuery(this).find('li.active').data('color');jQuery('.single-selected-color').html('<span>Selected Colour:&nbsp; </span> '+ color);});jQuery('#color-tabs').on('shown.bs.tab', function (e) {var color = jQuery(this).find('li.active').data('color');jQuery('.single-selected-color').html('<span>Selected Colour:&nbsp; </span> '+ color);});
        jQuery('ul#color-tab').bxSlider({
         minSlides: 2,
           maxSlides: 6,
           slideWidth: 100,
           slideMargin: 18,
           nextText: '<span class="fa fa-caret-right fa-4" aria-hidden="true"></span>',
           prevText: '<span class="fa fa-caret-left fa-4" aria-hidden="true"></span>',
           pager: false,
           infiniteLoop: false,
           hideControlOnEnd: true
        });

        jQuery('p.comment-form-rating').insertBefore('p.comment-form-author');if ( jQuery('ul#color-tab li.active a').length > 0 ) {var color_id = jQuery('ul#color-tab li.active a').attr('href').replace(/#/, '' );jQuery('[name="selected_color"]').val(color_id);}jQuery('.cpm_add_to_wishlist').on( 'click', function(e) {e.preventDefault();var _this = jQuery(this);var prod_id = _this.data( 'product-id' );var product_type = _this.data( 'product-type' );var wishlist_id = _this.data( 'wishlist-id' );el_wrap = jQuery( '.add-to-wishlist-' + prod_id ),
      jQuery.ajax({
        type:"POST",
        url: filter_modal.ajax_url,
        dataType: 'json',
        data: {
          action: 'cpm_add_to_wishlist',
          add_to_wishlist: prod_id,
          product_type: product_type,
          wishlist_id: wishlist_id,
          wishlist_name: "",
          wishlist_visibility: 0,
        },
        success: function(response){var msg = jQuery( '#yith-wcwl-popup-message' ),response_result = response.result,response_message = response.message;jQuery( '#yith-wcwl-message' ).html( response_message );msg.css( 'margin-left', '-' + jQuery( msg ).width() + 'px' ).fadeIn();window.setTimeout( function() {msg.fadeOut();}, 2000 );if( response_result == "true" ) {el_wrap.find('.yith-wcwl-add-button').hide().removeClass('show').addClass('hide');el_wrap.find( '.yith-wcwl-wishlistexistsbrowse').hide().removeClass('show').addClass('hide').find('a').attr('href', response.wishlist_url);el_wrap.find( '.yith-wcwl-wishlistaddedbrowse' ).show().removeClass('hide').addClass('show').find('a').attr('href', response.wishlist_url);} else if( response_result == "exists" ) {el_wrap.find('.yith-wcwl-add-button').hide().removeClass('show').addClass('hide');el_wrap.find( '.yith-wcwl-wishlistexistsbrowse' ).show().removeClass('hide').addClass('show').find('a').attr('href', response.wishlist_url);el_wrap.find( '.yith-wcwl-wishlistaddedbrowse' ).hide().removeClass('show').addClass('hide').find('a').attr('href', response.wishlist_url);} else {el_wrap.find( '.yith-wcwl-add-button' ).show().removeClass('hide').addClass('show');el_wrap.find( '.yith-wcwl-wishlistexistsbrowse' ).hide().removeClass('show').addClass('hide');el_wrap.find( '.yith-wcwl-wishlistaddedbrowse' ).hide().removeClass('show').addClass('hide');}jQuery('body').trigger('added_to_wishlist');},});});
   /*  jQuery("#slider-works-welll").owlCarousel({navigation : false,items: 3});jQuery("#slider-other-productt").owlCarousel({navigation : false,items: 3}); */
    function showProjectsbyCat(cat) {
            var owl_other = jQuery("#slider-other-productt").data('owlCarousel');
            var owl_works = jQuery("#slider-works-welll").data('owlCarousel');
            if ( typeof owl_other !== 'undefined' ) {
                owl_other.addItem('<div/>', 0);
                var nb_other = owl_other.itemsAmount;
                for (var i = 0; i < (nb_other - 1); i++) {
                    owl_other.removeItem(1);
                }

                var length_other = jQuery('#projects-other-copy .project.' + cat).length;
            }

            if ( typeof owl_works !== 'undefined' ) {
                owl_works.addItem('<div/>', 0);
                var nb_work = owl_works.itemsAmount;
                for (var i = 0; i < (nb_work - 1); i++) {
                    owl_works.removeItem(1);
                }
                var length_work = jQuery('#projects-works-copy .project.' + cat).length;
            }

            if ( length_work == 0 || length_other == 0 ) {
                jQuery('li.all-select').show();
            } else {
                jQuery('li.all-select').hide();

            }
            if (cat == 'all') {
                if ( typeof owl_other !== 'undefined' ) {
                    jQuery('#projects-other-copy .project').each(function () {
                        owl_other.addItem(jQuery(this).clone());
                    });
                }
                if ( typeof owl_works !== 'undefined' ) {
                    jQuery('#projects-works-copy .project').each(function () {
                        owl_works.addItem(jQuery(this).clone());
                    });
                }
                jQuery('li.all-select').css('display', 'none');
            } else {
                if ( typeof owl_other !== 'undefined' ) {
                    jQuery('#projects-other-copy .project.' + cat).each(function () {
                        owl_other.addItem(jQuery(this).clone());
                    });
                }
                if ( typeof owl_works !== 'undefined' ) {
                    jQuery('#projects-works-copy .project.' + cat).each(function () {
                        owl_works.addItem(jQuery(this).clone());
                    });
                }
            }

            if ( typeof owl_other !== 'undefined' ) {
                owl_other.removeItem(0);
            }
            if ( typeof owl_works !== 'undefined' ) {
                owl_works.removeItem(0);
            }
        }
    jQuery('#slider-works-welll .project').clone().appendTo(jQuery('#projects-works-copy'));
    jQuery('#slider-other-productt .project').clone().appendTo(jQuery('#projects-other-copy'));
    jQuery('ul#color-tab li a').on( 'click', function(e) {e.preventDefault();var col_class = jQuery(this).attr('href').replace(/#/, '' );
    });

		if(window.location.hash) {
			jQuery('#color-tab li a').each(function() {
				if (encodeURIComponent(jQuery(this).data('term')) == window.location.hash.split('#')[1]) {
					jQuery(this).click();
				}
			});
		}
		
		
        // from product-slider-swatches.js
        jQuery('#color-tab li a').on('click', function (e) {
        e.preventDefault();
        var img_src = jQuery(this).find('img').attr('src');
        var term_name = jQuery(this).data('term');

		window.location.hash = '#' + term_name;
		
        jQuery('.jck-wt-images__slide--active img').attr('src', img_src);
        jQuery('.jck-wt-images__slide--active img').attr('data-large-image', img_src);
        jQuery('.jck-wt-images__slide--active img').addClass('cloned');
        jQuery('.jck-wt-images__slide--active .color-term-name').html('<span class="term-span">'+term_name+'</span>');
        jQuery('.jck-wt-images__slide--active .color-term-name').css({'display': 'table'});
        var bx_wrap_height = jQuery('.jck-wt-images-wrap .bx-viewport').outerHeight();
        jQuery('.jck-wt-images__slide.jck-wt-images__slide--active').css('height', bx_wrap_height);
        jQuery('.jck-wt-images--click_anywhere').css({'height': bx_wrap_height, 'overflow': 'hidden'});
        // init_zoom( jQuery('.jck-wt-images__slide--active img') );
        // trigger_slider();
        jQuery('body').find('.zm-viewer').addClass('hide');
        jQuery('body').find('.zm-handler').addClass('hide');
        jQuery('.jck-wt-images__slide--active').find('img.currZoom').removeClass('jck-wt-images__image');
      });
      jQuery('.jck-wt-thumbnails').find('.jck-wt-thumbnails__slide').on('click', function(){

        jQuery('body').find('.zm-viewer').removeClass('hide');
        jQuery('body').find('.zm-handler').removeClass('hide');
        jQuery('.jck-wt-images__slide--active').find('img.currZoom').addClass('jck-wt-images__image');
      });

      jQuery('.bx-controls').find('.bx-pager-link').on('click', function(){
        jQuery('body').find('.zm-viewer').removeClass('hide');
        jQuery('body').find('.zm-handler').removeClass('hide');
        jQuery('.jck-wt-images__slide--active').find('img.currZoom').addClass('jck-wt-images__image');
      });

});
// jQuery(document).on("keydown", function(e){
//     if ((e.which || e.keyCode) == 116){
//         e.preventDefault();
//     }
// });
jQuery(document).ready(function(){
    jQuery("[data-toggle='dropdown']").click(function(e) {
        jQuery(this).parents(".f-sorter").toggleClass("open");  /*when you click on an element with attr data-toggle='dropdown' it toggle the class "open" on its parent with class "dropdown"*/
        e.stopPropagation();
    });

    jQuery("html").click(function() {
        jQuery(".open").removeClass("open");  /*when you click out of the dropdown-menu it remove the class "open"*/
    });
});