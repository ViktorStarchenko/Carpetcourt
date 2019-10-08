jQuery(document).ready(function($){
    // generate ajax attributes terms
    // bootstap modal
    $(window).load(function(){$('.cpm-preloader').fadeOut('slow',function(){});});
    $('.modal_popup').on('click',function(e){

        e.preventDefault();
        var _this = $(this),
        post = _this.data('post'),
        term = _this.data('term'),
        href = _this.data('href'),
        taxonomy = _this.data('taxonomy'),
        is_page = _this.data('page'),
        index = _this.closest('fieldset').data('index');
        $('#page-modal-popup').modal('show');
        $.ajax({
            url : filter_modal.ajax_url+'?action=filter_popup_cpt',
            type: 'POST',
            data: {
                post_id: post,
                term:term,
                taxonomy:taxonomy,
                is_page: is_page
            },
            dataType : 'html',
            beforeSend : function(){
                var text = "loading",
                new_text = text,
                prefix = '<div class="cc-loader"> <div class="loader">',
                suffix = '</div></div>';
                $('#post-popup').html(prefix+ text + suffix);
                $('.smart-page-loader').each(function(){
                    $(this).remove();
                });
            },
            success: function( response ) {$('#post-popup').html( response );/*fetchScript();*/$('.smart-page-loader').hide();jQuery('.vc_tta-tab a').each(function() {$(this).attr('target', $(this).attr('href'));});jQuery('body').on('click', '.vc_tta-tab a', function(event) {event.preventDefault();var thisAnchorHref = jQuery(this).attr('href');jQuery('.vc_tta-tab').each(function() {$(this).removeClass('vc_active');});jQuery(this).parent('li').addClass('vc_active');jQuery('.vc_tta-panels-container .vc_tta-panel').each(function(){jQuery(this).removeClass('vc_active');if( thisAnchorHref === '#'+jQuery(this).attr('id') ) {jQuery(this).addClass('vc_active');}});});
            $("a[rel^='prettyPhoto']").prettyPhoto({
                autoplay: false,
                social_tools: false,
                deeplinking: false
            });

            var slider_bxx = $('.modal-body .list-product-wrap').addClass('model-list-product-wrap').bxSlider({
                mode : 'vertical',
                infiniteLoop: true,
                controls :true,
                auto : false,
                pager : false,
                nextText: '<i class="fa fa-2x fa-angle-right"></i>',
                prevText: '<i class="fa fa-2x fa-angle-left"></i>',
                minSlides: 1,
                maxSlides: 1,
                auto: true,
            });
            $(".cc-gallery-img a[rel^='prettyPhoto']").prettyPhoto({
                autoplay: false,
                social_tools: false,
                deeplinking: false
            });
            $('body').on('click', '.vc_tta-panel a', function(event) {event.preventDefault();var thisAnchorHref = $(this).attr('href');$('.vc_tta-tab').each(function() {$(this).removeClass('vc_active');});$(this).parent('li').addClass('vc_active');$('.vc_tta-panels-container .vc_tta-panel').each(function(){$(this).removeClass('vc_active');if( thisAnchorHref === '#'+$(this).attr('id') ) {$(this).addClass('vc_active');}});});
            var container = jQuery('.cpm-isotope-list');
                    var griddd = container.isotope({ //Isotope options, 'item' matches the class in the PHP
                        itemSelector : '.isotope-item',
                        resizable: false,
                        masonry: {
                            gutterWidth: 20,
                            columnWidth: 1
                        }
                    });
                    griddd.imagesLoaded().progress( function() {
                      griddd.isotope('layout');
                  });

                    $('.smart-page-loader').each(function(){$(this).remove();});
                }
            });

        return false;
    });
    $('.cpm_modal_popup').on('click',function(e){e.preventDefault();
        var _this = $(this),
        post = _this.data('post'),
        term = _this.data('term'),
        href = _this.data('href'),
        taxonomy = _this.data('taxonomy'),
        is_page = _this.data('page'),
        index = _this.closest('fieldset').data('index');
        $('#post-popup-'+term).data('post',post);$('#post-popup-'+term).data('term',term);$('#post-popup-'+term).data('taxonomy',taxonomy);$('#post-popup-'+term).data('href',href);
        $('#post-popup-'+term).data('fieldset',index);$('#page-modal-popup-'+term).modal('show');
        interval = '';
        $.ajax({
            url : filter_modal.ajax_url+'?action=filter_popup_cpt',
            type: 'POST',
            data: {
                post_id: post,
                term:term,
                taxonomy:taxonomy,
                is_page: is_page
            },
            dataType : 'html',
            beforeSend : function(){
                var text = "loading",
                new_text = text,
                prefix = '<div class="cc-loader"> <div class="loader">',
                suffix = '</div></div>';
                $('#post-popup-'+term).html(prefix+ text + suffix);
                $('.smart-page-loader').each(function(){
                    $(this).remove();
                });
            },
            success: function( response ) {$('.smart-page-loader').each(function(){$(this).remove();});$('#post-popup-'+term).html( response );fetchScript();$('.smart-page-loader').hide();$('.vc_tta-tab a').each(function() {$(this).attr('target', $(this).attr('href'));});$('body').on('click', '.vc_tta-tab a', function(event) {event.preventDefault();var thisAnchorHref = $(this).attr('href');$('.vc_tta-tab').each(function() {$(this).removeClass('vc_active');});$(this).parent('li').addClass('vc_active');$('.vc_tta-panels-container .vc_tta-panel').each(function(){$(this).removeClass('vc_active');if( thisAnchorHref === '#'+$(this).attr('id') ) {$(this).addClass('vc_active');}});});
            $("a[rel^='prettyPhoto']").prettyPhoto({
                autoplay: false,
                social_tools: false,
                deeplinking: false
            });
            $(".cc-gallery-img a[rel^='prettyPhoto']").prettyPhoto({
                autoplay: false,
                social_tools: false,
                deeplinking: false
            });
            $('body').on('click', '.vc_tta-panel a', function(event) {
                event.preventDefault();
                console.log('clicked');
                var thisAnchorHref = $(this).attr('href');
                $('.vc_tta-tab').each(function() {
                    $(this).removeClass('vc_active');
                });
                $(this).parent('li').addClass('vc_active');
                $('.vc_tta-panels-container .vc_tta-panel').each(function(){
                    $(this).removeClass('vc_active');
                    if( thisAnchorHref === '#'+$(this).attr('id') ) {
                        $(this).addClass('vc_active');
                    }
                });
            });
            var $container = jQuery('.cpm-isotope-list');
                    var $griddd = $container.isotope({ //Isotope options, 'item' matches the class in the PHP
                        itemSelector : '.isotope-item',
                        resizable: false,
                        masonry: {
                            gutterWidth: 20,
                            columnWidth: 1
                        }
                    });
                    $griddd.imagesLoaded().progress( function() {
                      $griddd.isotope('layout');
                  });
                }
            });
    });$('.product_color_modal').on('click',function(e){e.preventDefault();
        var _this = $(this),
        post = _this.data('post'),
        term = _this.data('term'),
        href = _this.data('href'),
        taxonomy = _this.data('taxonomy'),
        index = _this.closest('fieldset').data('index');
        $('#product_color_post-popup').data('term',term);$('#product_color_post-popup').data('taxonomy',taxonomy);$('#product_color_post-popup').data('href',href);$('#product_color_post-popup').data('fieldset',index);$('#product_color-modal-popup').modal('show');return false;});
    $('#product_color-modal-popup').on('show.bs.modal', function() {
        var term = $('#product_color_post-popup').data('term'),
        taxonomy = $('#product_color_post-popup').data('taxonomy'),
        href = $('#product_color_post-popup').data('href');
        var interval = '';
        // fetch attributes page via Post id
        $.ajax({
            url : filter_modal.ajax_url+'?action=product_color_filter_popup_cpt',
            type: 'POST',
            data: {
                term:term,
                taxonomy:taxonomy
            },
            dataType : 'html',
            beforeSend : function(){
                var text = "loading",
                new_text = text,
                prefix = '<div class="cc-loader"> <div class="loader">',
                suffix = '</div></div>';
                $('#product_color_post-popup').html(prefix+ text + suffix);
                $('.smart-page-loader').each(function(){
                    $(this).remove();
                });
            },
            success: function( response ) {$('.smart-page-loader').each(function(){$(this).remove();});$('#product_color_post-popup').html( response );$('.smart-page-loader').hide();}});});
    $('body').on('click','.filter_popup_navigation',function(e){e.preventDefault();
        var _this = $(this),
        post = _this.data('post'),
        term = _this.data('term'),
        is_page = _this.data('page'),
        taxonomy = _this.data('taxonomy');
        $.ajax({
            url : filter_modal.ajax_url+'?action=filter_popup_cpt',
            type: 'POST',
            data: {
                post_id: post,
                term:term,
                taxonomy:taxonomy,
                is_page: is_page
            },
            dataType : 'html',
            beforeSend : function(){
                var text = "loading",
                new_text = text,
                prefix = '<div class="cc-loader"> <div class="loader">',
                suffix = '</div></div>';
                $('#post-popup').html(prefix+ text + suffix);
                $('.smart-page-loader').each(function(){
                    $(this).remove();
                });
            },
            success: function( response ) {$('#post-popup').html( response );/*fetchScript();*/jQuery('body').on('click', '.vc_tta-tab a', function(event) {event.preventDefault();var thisAnchorHref = jQuery(this).attr('href');jQuery('.vc_tta-tab').each(function() {$(this).removeClass('vc_active');});jQuery(this).parent('li').addClass('vc_active');jQuery('.vc_tta-panels-container .vc_tta-panel').each(function(){jQuery(this).removeClass('vc_active');if( thisAnchorHref === '#'+jQuery(this).attr('id') ) {jQuery(this).addClass('vc_active');}});});
            $("a[rel^='prettyPhoto']").prettyPhoto({
                autoplay: false,
                social_tools: false,
                deeplinking: false
            });var slider_bx = $('.modal-body .list-product-wrap').addClass('model-list-product-wrap').bxSlider({
                mode : 'vertical',
                infiniteLoop: true,
                controls :true,
                auto : false,
                pager : false,
                nextText: '<i class="fa fa-2x fa-angle-right"></i>',
                prevText: '<i class="fa fa-2x fa-angle-left"></i>',
                minSlides: 1,
                maxSlides: 1,
                auto: true,
            });$(".cc-gallery-img a[rel^='prettyPhoto']").prettyPhoto({
                autoplay: false,
                social_tools: false,
                deeplinking: false
            });$('body').on('click', '.vc_tta-panel a', function(event) {event.preventDefault();var thisAnchorHref = $(this).attr('href');$('.vc_tta-tab').each(function() {$(this).removeClass('vc_active');});$(this).parent('li').addClass('vc_active');$('.vc_tta-panels-container .vc_tta-panel').each(function(){$(this).removeClass('vc_active');if( thisAnchorHref === '#'+$(this).attr('id') ) {$(this).addClass('vc_active');}});});var container = jQuery('.cpm-isotope-list');
                    var griddd = container.isotope({ //Isotope options, 'item' matches the class in the PHP
                        itemSelector : '.isotope-item',
                        resizable: false,
                        masonry: {
                            gutterWidth: 20,
                            columnWidth: 1
                        }
                    });
                    griddd.imagesLoaded().progress( function() {
                      griddd.isotope('layout');
                  });
                    $('.smart-page-loader').each(function(){$(this).remove();});
                }
            });
    });
    function fetchScript(){
        var modal_slider =  $('.modal-body .list-product-wrap').addClass('model-list-product-wrap').bxSlider({
            mode : 'vertical',
            infiniteLoop: true,
            controls :true,
            auto : false,
            pager : false,
            nextText: '<i class="fa fa-2x fa-angle-right"></i>',
            prevText: '<i class="fa fa-2x fa-angle-left"></i>',
            minSlides: 1,
            maxSlides: 1
        });
    }
    $('figure.fig-hover').live( 'click', function(e) {e.preventDefault();$(this).next('div.ms-checkbox').find('input.filter-checkbox-btn').trigger( "change" );});
    // $('ul#color-tab li a').live( 'click', function() {var col_class = $(this).attr('href').replace(/#/, '' );console.log(col_class);/*$('form#cpm-measures-quote').find('[name="selected_color"]').val(col_class);*/$('ul#slider-works-well li').each( function() {if ( !$(this).hasClass(col_class) ) {$(this).hide();} else {$(this).show();}});
        // $('ul#slider-other-product li').each( function() {if ( !$(this).hasClass(col_class) ) {$(this).hide();} else {$(this).show();}});$(window).trigger('resize');
    // });
});