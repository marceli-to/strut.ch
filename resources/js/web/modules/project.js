var Project = (function() {

  /* --------------------------------------------------------------
   * VARIABLES
   * ------------------------------------------------------------ */

  // selectors
  var selectors = {
    html: 'html',
    body: 'body',
    btn:  '[data-toggle]',
    browse: {
      prev: {
        label: '[data-label-prev]',
        btn: '[data-prev]',
      },
      next: {
        label: '[data-label-next]',
        btn: '[data-next]',
      }
    }
  };

  // css classes
  var classes = {
    visible: 'is-visible',
    open:    'is-open'
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

    $(selectors.body).on('click', selectors.btn, function(){
      _toggle(this);
    });

    if ($(selectors.body).find('.project__description').length > 0) {
      $(selectors.body).on('click', function(e){
        if ($(e.target).parents('.btn-project-toggle').length != 1) {
          if ($(e.target).parents('.project__description').length == 0) {
            _close();
          }
        }
      });
    }

    $(selectors.browse.prev.btn).hover(function(){
      $(selectors.browse.prev.label).show();
    },function(){
      $(selectors.browse.prev.label).hide();
    });

    $(selectors.browse.next.btn).hover(function(){
      $(selectors.browse.next.label).show();
    },function(){
      $(selectors.browse.next.label).hide();
    });



  };

  var _toggle = function(btn) {
    var target = $(btn).data('toggle');
    $(btn).toggleClass(classes.open);
    $(target).toggleClass(classes.visible);
  };

  var _close = function() {
    var target = $(selectors.btn).data('toggle');
    if ($(target).hasClass(classes.visible)) {
      $(selectors.btn).removeClass(classes.open);
      $(target).removeClass(classes.visible);
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
  Project.init();
});

