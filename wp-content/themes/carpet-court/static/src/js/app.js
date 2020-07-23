// !!!DO NOT OFF!!!
// ## @include bootstrap.js


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
        
        init: function() {
            this.modals = $('.modal');
            if (!this.modals.length) return false;
            
            this.modals.each(function() {
                var self = $(this);
                
                self.off('show.bs.modal').on('show.bs.modal', function() {
                    window.checkOverflowPadding.check();
                });
                
                self.off('hidden.bs.modal').on('hidden.bs.modal', function() {
                    window.checkOverflowPadding.reset();
                });
            });
        }
    };
    
    
    // check overflow padding
    function initCheckOverflowPadding() {
        window.checkOverflowPadding = (function() {
            var self = {};
            self.instance = null;
        
            self._getPaddingRight = function(el) {
                return el.length ? +el.css('padding-right').replace('px', '') : 0;
            };
        
            self.check = function() {
                var scrollbarWidth = getScrollbarWidth();
                self.parts.each(function() {
                    var part = $(this);
                    part.css('padding-right', scrollbarWidth + self._getPaddingRight(part));
                });
            };
        
            self.reset = function() {
                self.parts.each(function() {
                    $(this).css('padding-right', '');
                });
            };
        
            // constructor
            self.createInstance = function() {
                self.parts = $('.js-check-padding');
                if (!self.parts.length) return {
                    check: function() { return false; },
                    reset: function() { return false; }
                };
            
                return {
                    check: self.check,
                    reset: self.reset
                };
            };
        
            return self.instance || (self.instance = self.createInstance());
        }());
    }
    
    
    // overlay
    function initOverlay() {
        window.overlay = (function() {
            var self = {};
            self.instance = null;
            self.isEnabled = false;
        
            self.enable = function() {
                self.isEnabled = true;
                self.wrap.addClass('g-wrap--overlay');
                return self.isEnabled;
            };
        
            self.disable = function() {
                self.isEnabled = false;
                self.wrap.removeClass('g-wrap--overlay');
                return self.isEnabled;
            };
        
            // constructor
            self.createInstance = function() {
                self.wrap = $('.g-wrap');
                if (!self.wrap.length) return {
                    enable: function() { return false; },
                    disable: function() { return false; }
                };
            
                return {
                    enable: self.enable,
                    disable: self.disable
                };
            };
        
            return self.instance || (self.instance = self.createInstance());
        }());
    }
    
    
    // mobile menu
    function initMobileMenu() {
        window.mm = (function() {
            var self = {};
            self.instance = null;
            self.isOpened = false;
            self.timeout = null;
        
            self.close = function() {
                window.checkOverflowPadding.reset();
                window.overlay.disable();
                self.isOpened = false;
                $body.removeClass('mm-opened');
                self.menus.removeClass('opened');
                self.timeout = setTimeout(function() {
                    self.menus.find('.menu-item').removeClass('opened');
                }, 600);
                return self.isOpened;
            };
        
            self.open = function(id) {
                var mm = $(id);
                if (!mm.length) return false;
                window.checkOverflowPadding.check();
                window.overlay.enable();
                self.isOpened = true;
                mm.addClass('opened');
                $body.addClass('mm-opened');
                clearTimeout(self.timeout);
                return self.isOpened;
            };
        
            self.resize = function() {
                self.windowWidth = window.innerWidth;
                if (self.windowWidth > 1279 && self.isOpened) {
                    self.close();
                }
            };
        
            self.buttons = function() {
                var buttons = $('.mm-opener');
                if (!buttons.length) return false;
            
                buttons.each(function() {
                    var btn = $(this);
                    var isBurger = btn.hasClass('btn-burger');
                    var id = btn.attr('data-target');
                
                    btn.on('click', function(e) {
                        e.stopPropagation();
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
                if (!self.menus.length) return {
                    open: function() { return false; },
                    close: function() { return false; }
                };
            
                self.resize();
                self.buttons();
                self.swipeMenu();
            
                $window.on('resizeWidth', function() {
                    self.resize();
                });
                $window.on('click', function() {
                    if (self.isOpened) self.close();
                });
                self.menus.on('click', function(e) {
                    e.stopPropagation();
                });
            
                return {
                    open: self.open,
                    close: self.close
                };
            };
        
            return self.instance || (self.instance = self.createInstance());
        }());
    }
    
    
    // is scrolled
    function pageScrolled() {
        window.scrollY > 0 ? $body.addClass('page-scrolled') : $body.removeClass('page-scrolled');
    
        var header = $('.g-header');
        var bar = header.find('.h-bar');
        var mm = $('.g-mm');
    
        if (!bar.length) return false;
        var offset = window.scrollY > bar.outerHeight() ? bar.outerHeight() : window.scrollY;
        header.css('transform', 'translateY(' + -offset + 'px)');
    
        if (!mm.length) return false;
        mm.css('padding-top', header.outerHeight() - offset + 'px');
    }

    function catalogSwitcherType() {
        var switcherItem = $(".category-type-switcher-item");
        switcherItem.on("click", function () {
            if ($(this).hasClass("active")) {

            } else {
                var data = $(this).data("type");
                console.log(data);
                document.cookie = "catalog-type=" + data + "; expires=Thu, 01 Jan 9999 00:00:01 GMT; path=/";

                $(".category-type-switcher-item").removeClass("active");
                $(this).addClass("active");

                $(".product-card-image").each(function () {
                    console.log($(this));
                    var style =  $(this).data(data);
                    console.log(style);
                    $(this).attr("style", style);
                });

                //window.location.reload(true);
            }
        });
    }

    function catalogSorter() {
        $("[data-toggle='dropdown']").on('click', function(e) {
            $(this).parents(".category-type-sort-items").toggleClass("open");
            e.stopPropagation();
        });
/*
        jQuery("html").on('click', function() {
            jQuery(".open").removeClass("open");
        });
        */
    }
    
    // nav
    var nav = {
        
        reset: function() {
            window.overlay.disable();
            this.navigationItems.removeClass('active');
            this.dropdown.fadeOut(300);
            console.log('nav reset')
        },
        
        resize: function() {
            this.windowWidth = window.innerWidth;
            if (this.windowWidth < 1280) {
                this.reset();
            }
        },
        
        listeners: function() {
            this.navigationLinks.each(function() {
                var link = $(this);
                var item = link.closest('.nav-item');
                
                link.on('mouseenter', function(e) {
                    var dropdown = $(link.attr("data-dropdown"));
                    if (!dropdown.length) return false;
                    window.overlay.enable();
                    nav.dropdown.fadeIn(300);
                    nav.navigationItems.removeClass('active');
                    item.addClass('active');
                    nav.dropdownItems.removeClass('active');
                    dropdown.addClass('active');
                });

                $('body').on('click', function(e) {
                    nav.reset();
                });
            });
        },
        
        init: function() {
            this.header = $('.g-header');
            this.navigation = this.header.find('.h-nav');
            this.navigationItems = this.navigation.find('.nav-item');
            this.navigationLinks = this.navigationItems.find('a[data-dropdown]');
            this.dropdown = this.header.find('.h-drop');
            this.dropdownItems = this.dropdown.find('.drop-menu');
            if (!this.navigationLinks.length || !this.dropdownItems.length) return false;
            
            this.resize();
            this.listeners();
            
            $window.on('resizeWidth', function() {
                nav.resize();
            });
            $window.on('click', function() {
                nav.reset();
            });
            this.dropdown.on('click', function(e) {
                e.stopPropagation();
            });
        }
    };
    
    
    // search
    function initSearch() {
        window.search = (function() {
            var self = {};
            self.instance = null;
            self.isOpened = false;
        
            self.open = function() {
                self.isOpened = true;
                // $body.addClass('search-opened');
                window.overlay.enable();
                $('.g-wrap').addClass('g-wrap--overlay qwee')
                self.searchDrop(self.isOpened);
                setTimeout(function () {
                    self.searchFocus();
                }, 100);

                return self.isOpened;
            };
        
            self.close = function() {
                self.isOpened = false;
                window.overlay.disable();
                // $body.removeClass('search-opened');
                self.searchDrop(self.isOpened);
                return self.isOpened;
            };
            
            self.buttons = function() {
                var buttons = $('.search-opener');
                if (!buttons.length) return false;

                buttons.each(function() {
                    $(this).on('click', function(e) {
                        e.preventDefault();
                        self.isOpened ? self.close() : self.open();
                    });
                });
            };

            self.searchDrop = function(state){
                var searchPanel = $('.drop-search');
                if (!searchPanel.length) return false;
                if(state){
                    searchPanel.fadeIn(300);
                } else {
                    searchPanel.fadeOut(300);
                }
            }

            self.searchFocus = function() {
                $("form.search-form input").focus();
            };
        
            // constructor
            self.createInstance = function() {
                // self.wrap = $('.g-search');
                // if (!self.wrap.length) return {
                //     open: function() { return false; },
                //     close: function() { return false; }
                // };
    
                self.buttons();
            
                return {
                    open: self.open,
                    close: self.close
                };
            };
        
            return self.instance || (self.instance = self.createInstance());
        }());
    }
    

    
    // Call functions
    $(function () {
        isTouch();
        detectOS();
        ieDetect();
        pageScrolled();
        selectPlaceholder();
        initCheckOverflowPadding();
        initOverlay();
        initMobileMenu();
        initSearch();
        catalogSwitcherType();
        catalogSorter();
        nav.init();
        checkModal.init();
    });

    $window.on('load', function () {
    
    });

    $window.on('resize', function () {
        resizeWidth();
    });

    $window.on('resizeWidth', function() {
        pageScrolled();
    });

    $window.on('scroll', function () {
        pageScrolled();
    });
}(jq);
