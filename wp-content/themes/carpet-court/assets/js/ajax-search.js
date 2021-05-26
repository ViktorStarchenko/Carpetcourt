jQuery(document).on( 'submit', 'form.search-form', function() {
    var $form = jQuery(this);
    var $input = $form.find('input[name="s"]');
    var query = $input.val();
    var $content = jQuery('.drop-search-main .search-result');
    var $related = jQuery('.drop-search-aside .search-result');

    jQuery.ajax({
        type : 'post',
        url : myAjax.ajaxurl,
        data : {
            action : 'load_search_results',
            query : query
        },
        beforeSend: function() {
            $input.prop('disabled', true);
            $content.addClass('loading');
        },
        success : function( response ) {
            $input.prop('disabled', false);
            $content.removeClass('loading');
            $content.html( response );
            window.history.pushState("", "", `/?s=${query}`);
            ga('send', 'pageview', `/?s=${query}`);
        }
    });

    jQuery.ajax({
        type : 'post',
        url : myAjax.ajaxurl,
        data : {
            action : 'load_related_results',
            query : query
        },
        success : function( response ) {
            $related.html( response );
        }
    });
    return false;
})
jQuery('.drop-search-main').on('click', '#full-search-load', function() {
    document.getElementById('header-search-form').submit();
})
jQuery(document).on('click','.ic-nav-search.search-opener', function() {
    setTimeout(function () {
        jQuery('#header-search-form input[name="s"]').focus();
    }, 500);
})
jQuery(document).on( 'keyup', 'input[name="s"]', function() {
    var $input = jQuery(this);
    var query = $input.val();
    var $content = jQuery('.drop-search-main .search-result');
    var $related = jQuery('.drop-search-aside .search-result');

    jQuery.ajax({
        type : 'post',
        url : myAjax.ajaxurl,
        data : {
            action : 'load_search_results',
            query : query
        },
        beforeSend: function() {

        },
        success : function( response ) {
            $input.prop('disabled', false);
            $content.removeClass('loading');
            $content.html( response );
            window.history.pushState("", "", `/?s=${query}`);
            ga('send', 'pageview', `/?s=${query}`);
        }
    });

    jQuery.ajax({
        type : 'post',
        url : myAjax.ajaxurl,
        data : {
            action : 'load_related_results',
            query : query
        },
        success : function( response ) {
            $related.html( response );
        }
    });
})
jQuery(document).on('click','.swatch-gallery .js-product-trigger', function() {
    var data = $(this).stop(true, true).data('color');
    var colorName = $(this).stop(true, true).data('naming');
    $('.js-sw-color').removeClass('is-visible');
    $(".js-sw-color.color-" + data).addClass('is-visible');
    $('.product-selector__title-select.js-select-color').html(colorName);
});