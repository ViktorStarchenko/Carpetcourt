
function imageZoom(imgID, resultID) {
    var img, lens, result, cx, cy;
    img = document.getElementById(imgID);
    result = document.getElementById(resultID);

    var wrap = img.closest('.product-slider-main');
    var wrapSlider = img.closest('.product-slider');
    var wrapNav = wrap.querySelector('.product-slider-nav');


    /* Create lens: */
    lens = document.createElement("DIV");
    lens.setAttribute("class", "img-zoom-lens");
    /* Insert lens: */
    img.parentElement.insertBefore(lens, img);
    background();
    /* Execute a function when someone moves the cursor over the image, or the lens: */
    lens.addEventListener("mousemove", moveLens);
    img.addEventListener("mousemove", moveLens);
    /* And also for touch screens: */
    lens.addEventListener("touchmove", moveLens);
    img.addEventListener("touchmove", moveLens);

    /* Add new listeners for recalc size */
    window.addEventListener('resize', function(){
        wrap.classList.add('changed');
        setTimeout(function() {
            background();
            wrap.classList.remove('changed');
        }, 600);
    });

    wrapNav.addEventListener('click', function(e){
        wrap.classList.add('changed');
        setTimeout(function() {
            background();
            moveLens(e);
            wrap.classList.remove('changed');
        }, 600);
    });

    $(wrapSlider).on('beforeChange', function(){
        wrap.classList.add('changed');
        setTimeout(function() {
            background();
            wrap.classList.remove('changed');
        }, 600);
    });
    
    function background() {
        /* Calculate the ratio between result DIV and lens: */
        cx = result.offsetWidth / lens.offsetWidth;
        cy = result.offsetHeight / lens.offsetHeight;
        /* Set background properties for the result DIV */
        result.style.backgroundImage = "url('" + img.dataset.largeImg + "')";
        result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
    }
    function moveLens(e) {
        var pos, x, y;
        /* Prevent any other actions that may occur when moving over the image */
        e.preventDefault();
        /* Get the cursor's x and y positions: */
        pos = getCursorPos(e);
        /* Calculate the position of the lens: */
        x = pos.x - (lens.offsetWidth / 2);
        y = pos.y - (lens.offsetHeight / 2);
        /* Prevent the lens from being positioned outside the image: */
        if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
        if (x < 0) {x = 0;}
        if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
        if (y < 0) {y = 0;}
        /* Set the position of the lens: */
        lens.style.left = x + "px";
        lens.style.top = y + "px";
        /* Display what the lens "sees": */
        result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
    }
    function getCursorPos(e) {
        var a, x = 0, y = 0;
        e = e || window.event;
        /* Get the x and y positions of the image: */
        a = img.getBoundingClientRect();
        /* Calculate the cursor's x and y coordinates, relative to the image: */
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        /* Consider any page scrolling: */
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return {x : x, y : y};
    }

}

!function($) {
    
    function ProductSlider(product) {
        var self = this;
        self.product = product;
        self.carouselWrap = self.product.find('.product-slider-main');
        self.slider = self.carouselWrap.find('.product-slider');
        self.slides = self.slider.find('.slide');
        // self.nav = self.carouselWrap.find('.product-slider-nav');
        self.prev_main = self.carouselWrap.find('.btn-prev-main');
        self.next_main = self.carouselWrap.find('.btn-next-main');
        self.dots = self.carouselWrap.find('.product-slider-dots');

        self.thumbslWrap = self.product.find('.product-slider-thumnbs-wrap');
        self.thumbs = self.product.find('.product-slider-thumnbs');
        self.prev_thumbs = self.thumbslWrap.find('.btn-prev-thumbs');
        self.next_thumbs = self.thumbslWrap.find('.btn-next-thumbs');
        
        self.init = function() {
            self.slider.slick({
                height: '100%',
                infinite: false,
                arrows: true,
                prevArrow: self.prev_main,
                nextArrow: self.next_main,
                lazyLoad: 'progressive',
                speed: 600,
                slidesToShow: 1,
                slidesToScroll: 1,
                rows: 0,
                dots: true,
                appendDots: self.dots,
                dotsClass: 'list-unstyled',
                customPaging: function() { return ''; },
                adaptiveHeight: true,
                autoplay: false,
                pauseOnHover: false,
                asNavFor: '.product-slider-thumnbs'
            });
            self.thumbs.slick({
                height: '100%',
                infinite: false,
                arrows: true,
                prevArrow: self.prev_thumbs,
                nextArrow: self.next_thumbs,
                lazyLoad: 'progressive',
                speed: 600,
                slidesToShow: 3,
                // centerMode: true,
                focusOnSelect: true,
                slidesToScroll: 1,
                dots: false,
                adaptiveHeight: false,
                autoplay: false,
                pauseOnHover: false,
                asNavFor: '.product-slider',
            });
        };
    
        (function() {
            if (!self.slides.length) return false;
            if (self.slider.hasClass('slick-initialized')) return false;
            self.init();
        }());
    }
    
    var productPageSlider = {
        
        init: function() {
            this.sections = $('.product-slider-wrap');
            if (!this.sections.length) return false;
            
            this.sections.find('.product-slider-img').show(0);
            this.sections.each(function() {
                new ProductSlider($(this));
            });
        }
    };
    
    
    $window.on('load', function() {
        productPageSlider.init();

        var zoomImg = $('.product-slider-img');

        if(zoomImg.length){
            zoomImg.each(function(item){
                imageZoom($(this).attr('id'), $(this).data('target'));

                $(this).on('mouseover', function(){
                    $('.img-zoom-result').removeClass('on-hover');
                    $('#' + $(this).data('target')).addClass('on-hover');
                });
                $(this).on('mouseleave', function(){
                    $('.img-zoom-result').removeClass('on-hover');
                });

            });
        }


    });


}(jQuery);