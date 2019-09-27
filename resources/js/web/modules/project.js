var Project = (function() {

  /* --------------------------------------------------------------
   * VARIABLES
   * ------------------------------------------------------------ */

  // selectors
  var selectors = {
    html: 'html',
    body: 'body',
    btn:  '[data-toggle]',
  };

  // css classes
  var classes = {
    visible: 'is-visible'
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
  };

  var _toggle = function(btn) {
    var target = $(btn).data('toggle');
    $(target).toggleClass(classes.visible);
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

