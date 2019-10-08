jQuery(document).ready( function() {jQuery('#color-tab').on('shown.bs.tab', function (e) {var color = jQuery(this).find('li.active').data('color');jQuery('.single-selected-color').html('<span>Selected Colour:&nbsp; </span> '+ color);});jQuery('#color-tabs').on('shown.bs.tab', function (e) {var color = jQuery(this).find('li.active').data('color');jQuery('.single-selected-color').html('<span>Selected Colour:&nbsp; </span> '+ color);});
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

    jQuery('p.comment-form-rating').insertBefore('p.comment-form-author');if ( jQuery('ul#color-tab li.active a').length > 0 ) {var color_id = jQuery('ul#color-tab li.active a').attr('href').replace(/#/, '' );jQuery('[name="selected_color"]').val(color_id);}jQuery('.cpm_add_to_wishlist').live( 'click', function(e) {e.preventDefault();var _this = jQuery(this);var prod_id = _this.data( 'product-id' );var product_type = _this.data( 'product-type' );var wishlist_id = _this.data( 'wishlist-id' );el_wrap = jQuery( '.add-to-wishlist-' + prod_id ),
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
jQuery("#slider-works-welll").owlCarousel({navigation : false,items: 3});jQuery("#slider-other-productt").owlCarousel({navigation : false,items: 3});
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
jQuery('ul#color-tab li a').live( 'click', function(e) {e.preventDefault();var col_class = jQuery(this).attr('href').replace(/#/, '' );/*showProjectsbyCat(col_class);*/});

// jQuery('ul#color-tab li').each( function() {

//     jQuery(this).find('a').easyZoom();
// });
});