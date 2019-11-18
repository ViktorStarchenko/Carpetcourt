!function () {

    function Card(wrapper) {
        var self = this;
        self.wrapper = wrapper;
        self.cards = self.wrapper.find('.card');
        
        self.init = function() {
            if (!self.cards.length) return false;
    
            self.cards.on('mouseenter', function() {
                var card = $(this);
                card.addClass('card--hover');
                self.cards.not(card).addClass('card--disabled');
            });
            
            self.cards.on('mouseleave', function() {
                self.cards.removeClass('card--hover card--disabled');
            });
        };
        
        (function() {
            self.init();
        }());
    }
    
    var cards = {
        
        init: function() {
            var wrappers = $('.js-card-wrapper');
            if (!wrappers.length) return false;
            
            wrappers.each(function() {
                new Card($(this));
            });
        }
    };

    $window.on('load', function() {
        cards.init();
    });
}();