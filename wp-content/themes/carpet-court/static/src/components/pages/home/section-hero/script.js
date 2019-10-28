!function($) {
    
    function Hero(hero) {
        var self = this;
        self.hero = hero;
        self.carouselWrap = self.hero.find('.carousel-wrap');
        self.slider = self.carouselWrap.find('.carousel-slider');
        self.slides = self.slider.find('.slide');
        self.nav = self.carouselWrap.find('.carousel-nav');
        self.prev = self.nav.find('.btn-prev');
        self.next = self.nav.find('.btn-next');
        self.dots = self.carouselWrap.find('.carousel-dots');
        
        self.init = function() {
            self.slider.slick({
                height: '100%',
                infinite: true,
                arrows: true,
                prevArrow: self.prev,
                nextArrow: self.next,
                speed: 600,
                slidesToShow: 1,
                slidesToScroll: 1,
                rows: 0,
                dots: true,
                appendDots: self.dots,
                dotsClass: 'list-unstyled',
                customPaging: function() { return ''; },
                adaptiveHeight: true,
                autoplay: true,
                autoplaySpeed: 5000,
                pauseOnHover: false
            });
        };
    
        (function() {
            if (!self.slides.length) return false;
            if (self.slider.hasClass('slick-initialized')) return false;
            self.init();
        }());
    }
    
    var hero = {
        
        init: function() {
            this.sections = $('.section-hero');
            if (!this.sections.length) return false;
            
            this.sections.each(function() {
                new Hero($(this));
            });
        }
    };
    
    $window.on('load', function() {
        hero.init();
    });
}(jQuery);