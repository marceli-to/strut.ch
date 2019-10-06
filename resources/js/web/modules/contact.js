var Contact = (function() {

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */
	
	// selectors
	var selectors = {
        html: 'html',
        body: 'body',
        btn:  '.js-btn-toggle',
	};

    var classes = {
        active: 'is-active',
    }

    /* --------------------------------------------------------------
     * METHODS
     * ------------------------------------------------------------ */
    
    // Init
	var _initialize = function() {
        _bind();
    };

    // Bind events
    var _bind = function() {

        $(selectors.body).on('click', selectors.btn, function(){
            _toggle(this);
        });
    };

    var _toggle = function(btn) {
        $(btn).next('div').toggle();
        $(btn).toggleClass(classes.active);
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
    Contact.init();
});

