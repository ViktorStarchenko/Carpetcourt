jQuery( document ).ready( function($){
    var update_wishlist_count = function() {
        $.ajax({
            data      : {
                action: 'update_wishlist_count'
            },
            success   : function (data) {
                $('#cc-navbar .wishlist-icon a span').html('<super>'+data+'</super>');
            },

            url: yith_wcwl_l10n.ajax_url
        });
    };

    $('body').on( 'added_to_wishlist removed_from_wishlist', update_wishlist_count );

    $('.sent-to-me').live('click', function() {
        var _this = $(this);
        $('#wishlist-sent-modal .first-step').removeClass('hidden');
        $('#wishlist-sent-modal .second-step').addClass('hidden');
        $('.cpm-sent-wishlist').trigger('click');
    });

    $('button.select-store').live( 'click', function() {

        var send_to = $('[name="nearest_store"').val();
        var to_name = $('[name="nearest_store"] option:selected').text();
        console.log(to_name);
        $.ajax({
            type: "POST",
            url: progressbar.ajax_url,
            data: {
                action: 'send_all_wishlists',
                send_to: send_to,
                store_name: to_name
            },
            beforeSend : function(){
                $('#wishlist-sent-modal .wishlist-cc-loader').show();
            },
            success: function( response ) {

                $('#wishlist-sent-modal .first-step').addClass('hidden');
                $('#wishlist-sent-modal .second-step').removeClass('hidden');
                $('#wishlist-sent-modal .wishlist-cc-loader').hide();
            }
        });
    });
} );