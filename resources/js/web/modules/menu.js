var Menu = (function() {

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */
	
	// selectors
	var selectors = {
        html:           'html',
        body:           'body',
        menuBtn:        '.js-btn-menu',
        menu:           '.js-menu',
        subMenuBtn:     '.js-btn-sub',
        subMenu:        'nav ul ul',
	};

    // css classes
    var classes = {
        active:  'is-active',
        visible: 'is-visible',
        open:    'is-open',
        hasMenu: 'has-menu',
        hasSub:  'has-sub',
    };

    // media queries
    var mq = {
        xs: window.matchMedia("(max-width: 767px)"),
        sm: window.matchMedia("(min-width: 768px)"),
        md: window.matchMedia("(min-width: 1024px)"),
        lg: window.matchMedia("(min-width: 1440px)")
    };

    var menuText = {
        close: 'Schliessen',
        open: 'Menü'
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

        $(selectors.body).on('click', selectors.menuBtn, function(){
            _toggle();
        });

        $(selectors.body).on('click', selectors.subMenuBtn, function(){
            _toggleSub(this);
        });
    };

    var _toggle = function() {
        $(selectors.menu).toggleClass(classes.visible);
        $(selectors.menuBtn).toggleClass(classes.active);

        // Change menu text
        if ($(selectors.menuBtn).hasClass(classes.active)) {
            $(selectors.menuBtn).html(menuText.close);
        }
        else {
            $(selectors.menuBtn).html(menuText.open);
        }
    };

    var _toggleSub = function(btn) {

        if ($(selectors.menu).hasClass(classes.hasSub)) {
            if ($(btn).next('ul').hasClass(classes.visible)) {
                $(btn).next('ul').removeClass(classes.visible);
                $(selectors.menu).removeClass(classes.hasSub);
            }
            else {
                $(selectors.subMenu).removeClass(classes.visible);
                $(btn).next('ul').addClass(classes.visible);
            }
        }
        else {
            $(btn).next('ul').addClass(classes.visible);
            $(selectors.menu).addClass(classes.hasSub);
        }
    };


    /* --------------------------------------------------------------
     * RETURN PUBLIC METHODS
     * ------------------------------------------------------------ */

    return {
        init:  _initialize,
	};
	
})();

// Initialize
$(function() {
    Menu.init();
});

