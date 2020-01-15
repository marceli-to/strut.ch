function debounce(a,b,c){var d;return function(){var e=this,f=arguments;clearTimeout(d),d=setTimeout(function(){d=null,c||a.apply(e,f)},b),c&&!d&&a.apply(e,f)}}

var Menu = (function() {

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */
	
	// selectors
	var selectors = {
        html:           'html',
        body:           'body',
        header:         'header',
        btnMenu:        '.js-btn-menu',
        menu:           '.js-menu',
        btnSub:         '.js-btn-sub-menu',
	};

    // css classes
    var classes = {
        active:  'is-active',
        visible: 'is-visible',
        open:    'is-open',
        parent:  'is-parent',
        hasMenu: 'has-menu',
    };

    // media queries
    var mq = {
        sm: window.matchMedia("(max-width: 900px)"),
        md: window.matchMedia("(min-width: 901px)")
    };

    /* --------------------------------------------------------------
     * METHODS
     * ------------------------------------------------------------ */
    
    // Init
	var _initialize = function() {
        _bind();
    };

    // Bind events
    var _bind = function() {

        $(selectors.body).on('click', selectors.btnMenu, function(){
            _toggle();
        });

        $(selectors.body).on('click', selectors.btnSub, function(){
            _toggleSub(this);
        });

        $(window).resize(function(event){
            if (mq.md.matches) {
                _resize();
            }
        });

        // A click outside the menu hides all open submenus
        $(selectors.body).click(function(event) {
            if (mq.md.matches && !$(event.target).is(selectors.menu + ' *')) {
                $('ul.is-open').removeClass(classes.open).hide();
                _resetMenuHeight();
            }
        });
    };

    var _resize = debounce(function(){
        $(selectors.html).removeClass(classes.hasMenu);
        $(selectors.menu).removeClass(classes.visible);
        $(selectors.btnMenu).removeClass(classes.active);
        _incrementMenuHeight();
    }, 200)

    var _toggle = function() {
        $(selectors.html).toggleClass(classes.hasMenu);
        $(selectors.menu).toggleClass(classes.visible);
        $(selectors.btnMenu).toggleClass(classes.active);
    };

    var _toggleSub = function(btn) {

        // The clicked item is parent (= top level) and child item is visible,
        // 1. hide all child items
        // 2. reset the menu
        if ($(btn).hasClass(classes.parent) && $(btn).next('ul').is(':visible')) {
            $(btn).parent('li').find('ul').each(function(){
                $(this).hide();
                $(this).removeClass(classes.open).hide();
            });
            _resetMenuHeight();
        }
        // The clicked item is parent (= top level) but child item is not visible,
        // 1. close all parent siblings
        // 2. reset the menu
        // 3. open child item
        // 4. increment menu
        else if ($(btn).hasClass(classes.parent) && $(btn).next('ul').is(':visible') == false) {
            $(selectors.menu).find('ul ul').each(function(){
                $(this).hide();
                $(this).removeClass(classes.open).hide();
            });
            $(btn).next('ul').addClass(classes.open).show();
            _incrementMenuHeight();
        }
        // The clicked item is NOT a parent but has visible child items
        // 1. save child items height
        // 2. hide child and its children
        // 3. decrement menu
        else if ($(btn).next('ul').is(':visible')) {
            let height = $(btn).next('ul').height();
            $(btn).next('ul').removeClass(classes.open).hide();
            $(btn).parent('li').find('ul').each(function(){
                $(this).hide();
                $(this).removeClass(classes.open).hide();
            });
            _incrementMenuHeight(height);
        }
        // The clicked its is NOT a parent and has no visible child items
        // 1. hide all parents
        // 2. show child item
        // 3. increment menu
        else {
            // Felix' menu fix
            $(btn).parents('li').nextAll('li').find('ul').hide();
            $(btn).parents('li').prevAll('li').find('ul').hide();
            // -- Felix' menu fix

            $(btn).next('ul').addClass(classes.open).show();
            _incrementMenuHeight();
        }
    };

    var _incrementMenuHeight = function() {
        if (mq.md.matches) {
            let h = $(selectors.menu).find('ul.is-open').first().height();
            $(selectors.menu).height(h + 30);
        }
    }

    var _resetMenuHeight = function() {
        if (mq.md.matches) {
            $(selectors.menu).css('height', '');
        }
    };

    /* --------------------------------------------------------------
     * RETURN PUBLIC METHODS
     * ------------------------------------------------------------ */

    return {
        init: _initialize,
	};
	
})();

// Initialize
$(function() {
    Menu.init();
});

