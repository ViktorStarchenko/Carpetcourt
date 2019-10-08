(function($){
    $(function() {
        // console.log('document width is ' + $(document).width() );
        // console.log('window width is ' + $(window).width() );

        var windowWidth = $(window).width();
        if( windowWidth > 767){
            var count = parseInt(1);
            if( $('body').find('.slider-view').length < 1 ){
                count = parseInt(0);
            }
            $('.onepage-scroll').find('.entry-content > .vc_row').each(function(e){
                if( !$(this).hasClass('scroll-sec') ){
                    // if( !$(this).hasClass('prefooter-section') ){
                    var sec_name = $(this).attr('id');
                    if ( typeof sec_name === 'undefined') {
                        sec_name = 'Section';
                    }
                    $(this).attr('id', 'section-'+count);
                    $(this).addClass('scroll-sec');
                    $(this).hide();
                    $('.slider-menu-section').find('.slier-menu-right').append('<li><a href="#section-'+count+'"> <span></span> </a><div class="tooltip"><span>'+sec_name+'</span></div></li>');
                    count += 1;
                    // }
                }
            });
            if( $('body').find('.slider-view').length < 1 ){
                $('body').find('#section-0').addClass('active');
            }


            if( $('body').hasClass('onepage-scroll') ){

                // console.log( 'count is ' +  count);
                $('body').find('.slider-menu-section').show();
                $('.slider-view').attr('id', 'section-0');

                var pref = count-1;
                $('body').find('.scroll-sec.active').show();
                $('body').find('#section-'+pref).addClass('prefooter-section');
                $('body').find('.scroll-sec.active').css("transform", "translateY(0%)");
                // $('body').find('.scroll-sec.active').nextAll('.scroll-sec').css("transform", "translateY(100%)");
                $('body').find('.scroll-sec.active').nextAll('.scroll-sec').css("transform", "translateY(100%)");
                $('body').find('.scroll-sec.active').prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                $('body').find('.site-footer').css("transform", "translateY(100%)");
                // $('body').find('.scroll-sec.active').nextAll('.scroll-sec').hide();
                // $('body').find('.scroll-sec.active').prevAll('.scroll-sec').hide();

            }

            // setTimeout(function() {
            //     if( $('body').hasClass('onepage-scroll') && $('.site-footer').is('#colophon') ){
            //         $('.site-footer').attr('id', 'section-'+count);
            //         $('.slider-menu-section').find('.slier-menu-right').append('<li><a href="#section-'+count+'"> <span></span> </a><div class="tooltip"><span>Footer</span></div></li>');
            //     }
            // }, 200);

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
            $('body').find('.scroll-sec').css("transform", "translateY(none)");
            // <a class="cc-scroll-down" href="#"><span></span></a>
            // $('.home').find('')
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



        // SCRIPT FOR SCROLL DOWN (ROUND SCROLL DOWN BUTTON IN HOME BANNER )//
        // $('a[href*=#]:not([href=#])').not('.vc_tta-accordion a').not('.vc_tta-tabs a').click(function(e) {
        $('.slider-menu-section').find('a[href*=#]:not([href=#])').live('click', function(e) {
            // $('body').find('.scroll-sec').show();
            var targetDiv = $(this).attr('href');
            if( $('body').hasClass('onepage-scroll') ){
                    // console.log(targetDiv);
                // var headerHeight = parseInt( $('#cc-navbar').outerHeight() ) || 0;
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
                        $('body').find(targetDiv).prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                        $('body').find(targetDiv).nextAll('.scroll-sec').css("transform", "translateY(100%)");
                        $('body').find('#section-'+section_num).css("transform", "translateY(-"+totalHeight+"px)");
                        $('body').find(targetDiv).css("transform", "translateY(-"+footerHeight+"px)");
                        $('body').find('.site-footer').css("transform", "translateY(0)");
                    }else{
                        $('body').find('.site-footer').removeClass('at-bottom');
                        $('body').find(targetDiv).nextAll('.scroll-sec').css("transform", "translateY(100%)");
                        $('body').find(targetDiv).css("transform", "translateY(0%)");
                        $('body').find(targetDiv).prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                        $('body').find('.site-footer').css("transform", "translateY(100%)");
                        $('.scroll-sec').find('.cc-scroll-down').remove();
                        $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                    }
                    // add remove shrink menu
                    // console.log(' target is ' + targetDiv);
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
        $('.slider-link-sec').find('a[href*=#]:not([href=#])').live('click', function(e) {
            var targetDiv = $(this).attr('href');
            if( $('body').hasClass('onepage-scroll') ){

                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    e.preventDefault();
                    $('body').find('.scroll-sec').removeClass('active');
                    $('body').find(targetDiv).addClass('active');
                    $('body').find('.slier-menu-right a').removeClass('active');
                    // $(this).addClass('active');
                    $('.slider-menu-section').find('a[href="'+targetDiv+'"]').addClass('active');
                    if( $('body').find(targetDiv).hasClass('prefooter-section') ){
                        $('body').find('.prefooter-section').css('height', 'auto');
                        $('body').find('.site-footer').addClass('at-bottom');
                        var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                        var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                        var totalHeight = prefooterHeight+footerHeight;

                        var section_num = parseInt(targetDiv.split(/[-]+/).pop());
                        section_num -= 1;
                        $('body').find(targetDiv).prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                        $('body').find(targetDiv).nextAll('.scroll-sec').css("transform", "translateY(100%)");
                        $('body').find('#section-'+section_num).css("transform", "translateY(-"+totalHeight+"px)");
                        $('body').find(targetDiv).css("transform", "translateY(-"+footerHeight+"px)");
                        $('body').find('.site-footer').css("transform", "translateY(0)");
                    }else{
                        $('body').find('.site-footer').removeClass('at-bottom');
                        $('body').find(targetDiv).nextAll('.scroll-sec').css("transform", "translateY(100%)");
                        $('body').find(targetDiv).css("transform", "translateY(0%)");
                        $('body').find(targetDiv).prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                        $('body').find('.site-footer').css("transform", "translateY(100%)");
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
        $('.scroll-sec').find('.cc-scroll-down').live('click', function(e){
            e.preventDefault();
            var current_menu = $('.slier-menu-right').find('a.active');
            // $('.slier-menu-right').find('a.active').trigger('click');
            if( current_menu.closest('li').next('li').length > 0 ){
                current_menu.closest('li').next('li').find('a').trigger('click');
            }
        });

        // click for mobile device
        $('.slider-view').find('.mobile-jump').live('click', function(e){
            // alert('clicked here');
            e.preventDefault();
            var offset = 0; //Offset of 20px
            jQuery('html, body').animate({
                scrollTop: jQuery(".slider-view").next('div').offset().top + offset
            }, 1000);
        });

        // trigger bootstrap modal on clicking the video
        // jQuery('#video-embed-sec').modal('show'); //videogallery-row //vc_column-inner
        $('.vc_column-inner').find('.cc-watch-column, .cc-watch-column a.vc_general').live('click', function(evt){
            evt.preventDefault();
            if( $(this).hasClass('vc_btn3') ){
                var vid_url = $(this).attr('href'); //null
            }else{
                var vid_url = $(this).find('a.vc_general').attr('href');
            }
            // var video_id = vid_url.split(/[/]+/).pop();
            var current = $(this);
            if( vid_url != ''){
                $.ajax({
                    url: global_urls.ajax_url,
                    type: 'post',
                    data: {
                        action: 'cc_watch_videos',
                        vid_url: vid_url
                    },
                    success: function( result ) {
                        // console.log(result);
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
            // $(this).find('iframe').attr('src', src);
        });

        // adding submenu icon for mobile submenu
        jQuery('<i class="fa fa-angle-down"></i>').insertAfter('.navbar-mobile .ubermenu-item-has-children > a');
        jQuery('.navbar-mobile i.fa').click(function(evt) {
          jQuery(this).closest('.ubermenu-item-has-children').toggleClass('ubermenu-active');
        });

        // custom code to add product to wishlist
        if( $('.yith-wcwl-add-to-wishlist').find('').length > 0 ){

        }else{

        }
        $('.custom-addtowishlist-btn').live('click', function(evt) {
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

    }); //end of document ready

    // start of window load function
    $(window).load(function(){

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

        $(window).mousewheel(function(event){
            //console.log(event.originalEvent.deltaY);
            $('body').find('.scroll-sec').show();
            var windowWidth = $(window).width();
            if( windowWidth > 767){
                var headerHeight = parseInt( $('#cc-navbar').outerHeight() ) || 0;
                if( $('body').hasClass('onepage-scroll') ){
                    event.preventDefault();
                    var currentdiv = $('body').find('.scroll-sec.active');
                    var current_id = $('body').find('.scroll-sec.active').attr('id');
                    var id_num = parseInt(current_id.split(/[-]+/).pop());
                    //console.log(event.originalEvent.wheelDelta);
                    //console.log(event.originalEvent.detail);
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
                            // console.log('scrolled down');
                            currentdiv.removeClass('active');
                            id_num += 1;
                            $('body').find('#section-'+id_num).addClass('active');
                            if( !$('.prefooter-section').hasClass('active') ){
                                currentdiv.css("transform", "translateY(-100%)");
                                currentdiv.nextAll('.scroll-sec').css("transform", "translateY(100%)");
                                $('body').find('.slier-menu-right a').removeClass('active');
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                $('body').find('#section-'+id_num).css("transform", "translateY(0)");
                                $('.scroll-sec').find('.cc-scroll-down').remove();
                                $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                            }else{
                                $('body').find('.prefooter-section').css('height', 'auto');
                                var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                                var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                                var totalHeight = prefooterHeight+footerHeight;
                                $('body').find('.slier-menu-right a').removeClass('active');
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                currentdiv.css("transform", "translateY(-"+totalHeight+"px)");
                                $('.prefooter-section').css("transform", "translateY(-"+footerHeight+"px)");
                                $('body').find('.site-footer').css("transform", "translateY(0)");
                                $('body').find('.site-footer').addClass('at-bottom');
                            }
                            setTimeout(function() {isDoingStuff = false;}, 150);
                            // if( !$('.prefooter-section').hasClass('active') ){}
                        }
                    }else{

                              //scrolled up
                        if( $('.site-footer').hasClass('at-bottom') ){
                            if(isDoingStuff) { return; }
                            isDoingStuff = true;
                            currentdiv.removeClass('active');
                            // currentdiv.prev('.scroll-sec').addClass('active');
                            $('body').find('.site-footer').removeClass('at-bottom');
                            $('body').find('.slier-menu-right a').removeClass('active');
                            id_num -= 1;
                            $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                            currentdiv.css("transform", "translateY(100%)");
                            $('body').find('.site-footer').css("transform", "translateY(100%)");
                            $('body').find('#section-'+id_num).css("transform", "translateY(0)");
                            $('body').find('#section-'+id_num).addClass('active');
                            setTimeout(function() {isDoingStuff = false;}, 150);
                        }else if (!$('#section-0').hasClass("active")){
                            if(isDoingStuff) { return; }
                            isDoingStuff = true;
                            // console.log('scrolled up');
                            currentdiv.removeClass('active');
                            $('body').find('.site-footer').removeClass('at-bottom');
                            currentdiv.css("transform", "translateY(100%)");
                            $('body').find('.site-footer').css("transform", "translateY(100%)");
                            currentdiv.prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                            $('body').find('.slier-menu-right a').removeClass('active');
                            id_num -= 1;
                            $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                            $('body').find('#section-'+id_num).addClass('active');
                            $('body').find('#section-'+id_num).css("transform", "translateY(0)");
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

}
else
{
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
                            // currentdiv.prev('.scroll-sec').addClass('active');
                            $('body').find('.site-footer').removeClass('at-bottom');
                            $('body').find('.slier-menu-right a').removeClass('active');
                            id_num -= 1;
                            $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                            currentdiv.css("transform", "translateY(100%)");
                            $('body').find('.site-footer').css("transform", "translateY(100%)");
                            $('body').find('#section-'+id_num).css("transform", "translateY(0)");
                            $('body').find('#section-'+id_num).addClass('active');
                            setTimeout(function() {isDoingStuff = false;}, 150);
                        }else if (!$('#section-0').hasClass("active")){
                            if(isDoingStuff) { return; }
                            isDoingStuff = true;
                            // console.log('scrolled up');
                            currentdiv.removeClass('active');
                            $('body').find('.site-footer').removeClass('at-bottom');
                            currentdiv.css("transform", "translateY(100%)");
                            $('body').find('.site-footer').css("transform", "translateY(100%)");
                            currentdiv.prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                            $('body').find('.slier-menu-right a').removeClass('active');
                            id_num -= 1;
                            $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                            $('body').find('#section-'+id_num).addClass('active');
                            $('body').find('#section-'+id_num).css("transform", "translateY(0)");
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
                            // console.log('scrolled down');
                            currentdiv.removeClass('active');
                            id_num += 1;
                            $('body').find('#section-'+id_num).addClass('active');
                            if( !$('.prefooter-section').hasClass('active') ){
                                currentdiv.css("transform", "translateY(-100%)");
                                currentdiv.nextAll('.scroll-sec').css("transform", "translateY(100%)");
                                $('body').find('.slier-menu-right a').removeClass('active');
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                $('body').find('#section-'+id_num).css("transform", "translateY(0)");
                                $('.scroll-sec').find('.cc-scroll-down').remove();
                                $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                            }else{
                                $('body').find('.prefooter-section').css('height', 'auto');
                                var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                                var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                                var totalHeight = prefooterHeight+footerHeight;
                                $('body').find('.slier-menu-right a').removeClass('active');
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                currentdiv.css("transform", "translateY(-"+totalHeight+"px)");
                                $('.prefooter-section').css("transform", "translateY(-"+footerHeight+"px)");
                                $('body').find('.site-footer').css("transform", "translateY(0)");
                                $('body').find('.site-footer').addClass('at-bottom');
                            }
                            setTimeout(function() {isDoingStuff = false;}, 150);
                            // if( !$('.prefooter-section').hasClass('active') ){}
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
                    // event.preventDefault();
                    var currentdiv = $('body').find('.scroll-sec.active');
                    var current_id = $('body').find('.scroll-sec.active').attr('id');
                    var id_num = parseInt(current_id.split(/[-]+/).pop());

                    $(this).on('touchmove', function(e) {
                        var contact = e.originalEvent.touches,
                        end = contact[0].pageY,
                        distance = end-start;
                        if (distance > 30) {
                            // up
                            if( $('.site-footer').hasClass('at-bottom') ){
                                if(isDoingStuff) { return; }
                                isDoingStuff = true;
                                currentdiv.removeClass('active');
                                // currentdiv.prev('.scroll-sec').addClass('active');
                                $('body').find('.site-footer').removeClass('at-bottom');
                                $('body').find('.slier-menu-right a').removeClass('active');
                                id_num -= 1;
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                currentdiv.css("transform", "translateY(100%)");
                                $('body').find('.site-footer').css("transform", "translateY(100%)");
                                $('body').find('#section-'+id_num).css("transform", "translateY(0)");
                                $('body').find('#section-'+id_num).addClass('active');
                                setTimeout(function() {isDoingStuff = false;}, 150);
                            }else if (!$('#section-0').hasClass("active")){
                                if(isDoingStuff) { return; }
                                isDoingStuff = true;
                                // console.log('scrolled up');
                                currentdiv.removeClass('active');
                                $('body').find('.site-footer').removeClass('at-bottom');
                                currentdiv.css("transform", "translateY(100%)");
                                $('body').find('.site-footer').css("transform", "translateY(100%)");
                                currentdiv.prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                                $('body').find('.slier-menu-right a').removeClass('active');
                                id_num -= 1;
                                $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                $('body').find('#section-'+id_num).addClass('active');
                                $('body').find('#section-'+id_num).css("transform", "translateY(0)");
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
                            // down
                            if ($('#section-0').hasClass("active")){
                                if( !$('nav.navbar-fixed-top').hasClass('shrink') ){
                                    $('nav.navbar-fixed-top').addClass('shrink');
                                }
                            }
                            if (!$('.prefooter-section').hasClass("active")){
                                if(isDoingStuff) { return; }
                                isDoingStuff = true;
                                // console.log('scrolled down');
                                currentdiv.removeClass('active');
                                id_num += 1;
                                $('body').find('#section-'+id_num).addClass('active');
                                if( !$('.prefooter-section').hasClass('active') ){
                                    currentdiv.css("transform", "translateY(-100%)");
                                    currentdiv.nextAll('.scroll-sec').css("transform", "translateY(100%)");
                                    $('body').find('.slier-menu-right a').removeClass('active');
                                    $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                    $('body').find('#section-'+id_num).css("transform", "translateY(0)");
                                    $('.scroll-sec').find('.cc-scroll-down').remove();
                                    $('.scroll-sec.active').append('<a class="cc-scroll-down" href="#"><span></span></a>');
                                }else{
                                    $('body').find('.prefooter-section').css('height', 'auto');
                                    var prefooterHeight = parseInt( $('body').find('.prefooter-section').outerHeight() ) || 0;
                                    var footerHeight = parseInt( $('.site-footer').outerHeight() ) || 0;
                                    var totalHeight = prefooterHeight+footerHeight;
                                    $('body').find('.slier-menu-right a').removeClass('active');
                                    $('body').find('.slier-menu-right').find('a[href="#section-'+id_num+'"]').addClass('active');
                                    currentdiv.css("transform", "translateY(-"+totalHeight+"px)");
                                    $('.prefooter-section').css("transform", "translateY(-"+footerHeight+"px)");
                                    $('body').find('.site-footer').css("transform", "translateY(0)");
                                    $('body').find('.site-footer').addClass('at-bottom');
                                }
                                setTimeout(function() {isDoingStuff = false;}, 150);
                                // if( !$('.prefooter-section').hasClass('active') ){}
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
                    // console.log('url is ' +urlHash);
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
                        $('body').find(urlHash).prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                        $('body').find(urlHash).nextAll('.scroll-sec').css("transform", "translateY(100%)");
                        $('body').find('#section-'+section_num).css("transform", "translateY(-"+totalHeight+"px)");
                        $('body').find(urlHash).css("transform", "translateY(-"+footerHeight+"px)");
                        $('body').find('.site-footer').css("transform", "translateY(0)");
                    }else{
                        $('body').find('.site-footer').removeClass('at-bottom');
                        $('body').find(urlHash).nextAll('.scroll-sec').css("transform", "translateY(100%)");
                        $('body').find(urlHash).css("transform", "translateY(0%)");
                        $('body').find(urlHash).prevAll('.scroll-sec').css("transform", "translateY(-100%)");
                        $('body').find('.site-footer').css("transform", "translateY(100%)");
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
        // end of anchor links
        // MOUSE SCROLL //wheel
        $('body').find('.cpm-preloader').remove();
    });
})(jQuery);