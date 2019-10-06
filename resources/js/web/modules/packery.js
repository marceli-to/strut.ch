var PackeryUi = (function() {

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */
	
	// selectors
	var selectors = {
        html: 'html',
        body: 'body',
        masonry: {
            container: '.js-msnry',
            item: '.js-msnry-item',
            button: '.js-msnry-btn'
        },
	};

    /* --------------------------------------------------------------
     * METHODS
     * ------------------------------------------------------------ */
    
    // Init
	var _initialize = function() {

        $(selectors.masonry.container).imagesLoaded( function() {
            var $grid = $(selectors.masonry.container).packery({
                itemSelector: selectors.masonry.item,
                percentPosition: true,
                gutter: 24,
                transitionDuration: 0
            });
    
            $grid.on('click', selectors.masonry.button, function(event) {
                var $item = $(event.currentTarget);
                $item.parent(selectors.masonry.item).toggleClass('has-detail');
                $item.next('div').toggle();
                $item.toggleClass('is-active');
    
                if ($item.parent(selectors.masonry.item).hasClass('.has-detail')) {
                    $grid.packery('fit', event.currentTarget);
                }
                else {
                    $grid.packery('shiftLayout');
                }
            });
        });



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
    PackeryUi.init();
});

