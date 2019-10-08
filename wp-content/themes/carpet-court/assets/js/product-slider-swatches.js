jQuery(document).ready( function() {

      jQuery('#color-tab li a').on('click', function (e) {
        e.preventDefault();
        var img_src = jQuery(this).find('img').attr('src');
        var term_name = jQuery(this).data('term');

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
      jQuery('.jck-wt-thumbnails').find('.jck-wt-thumbnails__slide').live('click', function(){
        jQuery('body').find('.zm-viewer').removeClass('hide');
        jQuery('body').find('.zm-handler').removeClass('hide');
        jQuery('.jck-wt-images__slide--active').find('img.currZoom').addClass('jck-wt-images__image');
      });

      jQuery('.bx-controls').find('.bx-pager-link').live('click', function(){
        jQuery('body').find('.zm-viewer').removeClass('hide');
        jQuery('body').find('.zm-handler').removeClass('hide');
        jQuery('.jck-wt-images__slide--active').find('img.currZoom').addClass('jck-wt-images__image');
      });
});