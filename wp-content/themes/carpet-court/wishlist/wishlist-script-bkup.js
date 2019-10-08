jQuery(document).ready(function($) {
    /*Login Form*/
    $('form#wishlist-login').on('submit', function(e){
        e.preventDefault();
        var values = $('form#wishlist-login').serializeObject();
        var security = $('form#wishlist-login #security').val();
        $.ajax({
            type : 'post',
            dataType: 'json',
            url : cc_wishlist_object.ajaxurl,
            data : {
                action : 'cc_wishlist_ajax_login',
                security: security,
                info: values
            },
            beforeSend: function() {
                $('.wishlist-login-info').html('');
                $('.loading-login-img').fadeIn();
            },
            success : function( response ) {
                $('.loading-login-img').fadeOut();
                if(true == response.status){
                    $('.wishlist-login-info').html('<div class="alert alert-success alert-dismissible fade in" role="alert"><i class="alerticon "> <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> </i><strong>Successful Login. Redirecting!!! Please Wait....</strong></div>');
                    location.reload();
                }
                else{
                    $('.wishlist-login-info').html('<div class="alert alert-warning alert-dismissible fade in" role="alert"><i class="alerticon"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></i><strong>Wrong Username or Password.</strong></div>');
                }
            }
        });
    });
    /*Login Form*/

    /*
     Registration Form
     */
    $('.wishlist-registration-form fieldset:first-child').fadeIn('slow');
    $('.wishlist-registration-form input[type="text"], .wishlist-registration-form input[type="password"], .wishlist-registration-form input[type="email"]').on('focus', function() {
        $(this).removeClass('input-error');
    });

    /*next step*/
    $('.wishlist-registration-form .btn-next').on('click', function() {
        var parent_fieldset = $(this).parents('fieldset'),
            next_step = true,
            _this = $(this);

        parent_fieldset.find('input[type="text"], input[type="password"], input[type="email"]').each(function() {
            if( $(this).val() == "" ) {
                $(this).addClass('input-error');
                next_step = false;
            }
            else {
                $(this).removeClass('input-error');
            $('.user-portal-header p').hide();
            }
        });

        /*email validation*/
        if ($(this).hasClass('wishlist-email')){
            next_step = false;
            var email = $(".wishlist-registration-form #email").val();
            if(email){
                $.ajax({
                    type : 'post',
                    dataType: 'json',
                    url : cc_wishlist_object.ajaxurl,
                    data : {
                        action : 'cc_wishlist_ajax_email_check',
                        email: email
                    },
                    beforeSend: function() {
                        $('.wishlist-register-email').html('');
                        $('.loading-login-img').fadeIn();
                        //$('.wishlist-email').attr('disabled', 'disabled');
                    },
                    success : function( response ) {
                        $('.loading-login-img').fadeOut();
                        //$('.wishlist-email').attr('disabled', false);
                        if(true == response.status){
                            parent_fieldset.fadeOut(400, function() {
                                $(this).next().fadeIn();
                            });
                        }
                        else{
                            next_step = false;
                            $('.wishlist-register-email').html(response.error);
                        }
                    }
                });
            }
        }
        /*Other Fields*/
        else{
            if( next_step ) {
             parent_fieldset.fadeOut(400, function() {
             $(this).next().fadeIn();
             });
             }
        }
    });

    /*previous step*/
    $('.wishlist-registration-form .btn-previous').on('click', function() {
        $('.user-portal-header p').show();
        $(this).parents('fieldset').fadeOut(400, function() {
            $(this).prev().fadeIn();
        });
    });

    /*submit*/
    $('.wishlist-registration-form').on('submit', function(e) {
        e.preventDefault();
        $(this).find('input[type="text"], input[type="password"], input[type="email"]').each(function() {
            if( $(this).val() == "" ) {
                e.preventDefault();
                $(this).addClass('input-error');
            }
            else {
                $(this).removeClass('input-error');
            }
        });
        var values = $('form.wishlist-registration-form').serializeObject();
        var security = $('form#wishlist-register #security').val();
        var redirect_url = $('form#wishlist-register #redirect_url').val();
        var prod_id = $('#cpm_wishlist_popup').data( 'product-id' );
            var product_type = $('#cpm_wishlist_popup').data( 'product-type' );
            var wishlist_id = $('#cpm_wishlist_popup').data( 'wishlist-id' );

        $.ajax({
            type : 'post',
            dataType: 'json',
            url : cc_wishlist_object.ajaxurl,
            data : {
                action : 'cc_wishlist_ajax_register',
                security: security,
                info: values,
                redirect_url: redirect_url,
                add_to_wishlist: prod_id,
                product_type: product_type,
                wishlist_id: wishlist_id,
                wishlist_name: "",
                wishlist_visibility: 0,
            },
            beforeSend: function() {
                $('.wishlist-register-info').html('');
                $('.loading-login-img').fadeIn();
            },
            success : function( response ) {
                $('.loading-login-img').fadeOut();
                if(true == response.status){
                    $('.wishlist-registration-form').empty();
                    // $('#wishlist-form').modal('hide');
                    $('.wishlist-register-info').html('<div class="alert alert-success alert-dismissible fade in" role="alert"><i class="alerticon "> <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> </i><strong>Registration Successful !!! Redirecting. Please Wait.....</strong></div>');
                    window.location.href = response.redirect_url;
                }else{
                    $('.wishlist-register-error').html(response.error);
                }
            }
        });
    });
    /*Registration Form*/

});



jQuery.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    jQuery.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};