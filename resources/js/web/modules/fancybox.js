var FancyBox = (function() {

  var selectors = {
    body: 'body',
    elem: '[data-fb="gallery"]'
  };

  var _initialize = function() {
    $(selectors.elem).fancybox({
      buttons: [
        "close"
      ],
    });
  };

  return {
    init: _initialize,
  };

})();

// Initialize
$(function() {
  FancyBox.init();
});