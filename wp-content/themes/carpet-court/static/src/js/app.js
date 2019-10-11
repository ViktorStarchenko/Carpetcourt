// !!!DO NOT OFF!!!
// @include bootstrap.js


// Global variables
var jq = window.jQuery;
var $window = jq(window);
var $windowWidth = window.innerWidth;
var $body = jq('body');


// scrollbar width
function getScrollbarWidth() {
    return parseInt(window.innerWidth) - parseInt(document.documentElement.clientWidth);
}


// resize width
function resizeWidth() {
    var width = window.innerWidth;
    if (width !== $windowWidth) {
        $windowWidth = width;
        $window.trigger('resizeWidth');
    }
}


// is support touch
function isTouch() {
    if (!!('ontouchstart' in window)) {
        $body.removeClass('touch-disabled').addClass('touch-enabled');
        return true;
    } else {
        $body.removeClass('touch-enabled').addClass('touch-disabled');
        return false;
    }
}


// is scrolled
function pageScrolled() {
    window.scrollY > 0 ? $body.addClass('page-scrolled') : $body.removeClass('page-scrolled');
}


// identify ОС
function getOS() {
    var OSName = 'Unknown';
    var navigatorAppVersion = navigator.appVersion;

    if (navigatorAppVersion.indexOf('Win') !== -1) {
        OSName = 'Windows';
    } else if (navigatorAppVersion.indexOf('Mac') !== -1) {
        if (navigatorAppVersion.indexOf('iPhone') !== -1 || navigatorAppVersion.indexOf('iPad') !== -1) {
            OSName = 'IOS';
        } else {
            OSName = 'Mac';
        }
    } else if (navigatorAppVersion.indexOf('Android') !== -1) {
        OSName = 'Android';
    } else if (navigatorAppVersion.indexOf('X11') !== -1) {
        if (navigatorAppVersion.indexOf('Linux') !== -1) {
            OSName = 'Linux';
        } else {
            OSName = 'UNIX';
        }
    } else if (navigatorAppVersion.indexOf('Linux') !== -1) {
        OSName = 'Linux';
    }

    return OSName;
}


// identify IE version
function getInternetExplorerVersion() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
        // Edge (IE 12+) => return version number
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    return false;
}


// mobile menu
var mm = (function($) {
    var self = {};
    self.instance = null;
    self.isOpened = false;
    self.timeout = null;
    
    self.close = function() {
        self.isOpened = false;
        $body.removeClass('mm-opened');
        self.menus.removeClass('opened');
        self.timeout = setTimeout(function() {
            self.menus.find('.menu-item').removeClass('opened');
        }, 600);
    };
    
    self.open = function(id) {
        var mm = $(id);
        if (!mm.length) return false;
        self.isOpened = true;
        mm.addClass('opened');
        $body.addClass('mm-opened');
        clearTimeout(self.timeout);
    };
    
    self.resize = function() {
        self.windowWidth = window.innerWidth;
        if (self.windowWidth > 1023 && self.isOpened) {
            self.close();
        }
    };
    
    self.buttons = function() {
        var buttons = $('.mm-opener');
        if (!buttons.length) return false;
    
        buttons.each(function (){
            var btn = $(this);
            var isBurger = btn.hasClass('btn-burger');
            var id = btn.attr('data-target');
    
            btn.on('click', function (){
                if (self.isOpened) {
                    return isBurger ? self.close() : false;
                }
                if (id) self.open(id);
            });
        });
    };
    
    self.swipeMenu = function() {
        var lnkNext = self.menus.find('.lnk-next');
        var lnkBack = self.menus.find('.lnk-back');
    
        lnkNext.on('click', function(e) {
            e.preventDefault();
            $(this).closest('.menu-item').addClass('opened');
        });
    
        lnkBack.on('click', function(e) {
            e.preventDefault();
            $(this).closest('.menu-item').removeClass('opened');
        });
    };
    
    
    // constructor
    self.createInstance = function() {
        self.menus = $('.g-mm');
        if (!self.menus.length) return {};
        
        self.resize();
        self.buttons();
        self.swipeMenu();
    
        $window.on('resizeWidth', function() {
            self.resize();
        });
    
        return {
            open: self.open,
            close: self.close
        };
    };
    
    return {
        init: function() {
            return self.instance || (self.instance = self.createInstance());
        }
    };
}(jq));

/*==================================================================================================================*/

!function ($) {

    // add class IE-version for html
    function ieDetect() {
        var ie = getInternetExplorerVersion();
        if (ie < 6) {
            return false;
        }
        $('html').addClass('ie ie' + ie);
    }

    
    // add class OS-type for html
    function detectOS() {
        $('html').addClass('os' + getOS());
    }
    
    
    // select placeholder
    function selectPlaceholder() {
        var selects = $('select');
        if (!selects.length) {
            return false;
        }
        
        var _checkPlaceholder = function(select) {
            select.find(':selected').val() === 'placeholder' ? select.addClass('placeholder') : select.removeClass('placeholder');
        };
        
        selects.each(function() {
            var self = $(this);
            _checkPlaceholder(self);
            
            self.on('change', function() {
                _checkPlaceholder(self);
            });
        });
    }
    
    
    // modal open
    var checkModal = {
        
        getPaddingRight: function(el) {
            return el.length ? +el.css('padding-right').replace('px', '') : 0;
        },
        
        init: function() {
            this.modals = $('.modal');
            this.header = $('.g-header');
            this.headerParts = this.header.find('.h-part');
            if (!this.modals.length) return false;
            
            this.modals.each(function() {
                var self = $(this);
                
                self.off('show.bs.modal').on('show.bs.modal', function() {
                    var scrollbarWidth = getScrollbarWidth();
                    checkModal.headerParts.each(function() {
                        var self = $(this);
                        self.css('padding-right', scrollbarWidth + checkModal.getPaddingRight(self));
                    });
                });
                
                self.off('hidden.bs.modal').on('hidden.bs.modal', function() {
                    checkModal.headerParts.each(function() {
                        $(this).css('padding-right', '');
                    });
                });
            });
        }
    };
    

    
    // Call functions
    $(function () {
        isTouch();
        detectOS();
        ieDetect();
        pageScrolled();
        selectPlaceholder();
        checkModal.init();
        mm.init();
    });

    $window.on('load', function () {
    
    });

    $window.on('resize', function () {
        resizeWidth();
    });

    $window.on('resizeWidth', function() {
    
    });

    $window.on('scroll', function () {
        pageScrolled();
    });
}(jq);
