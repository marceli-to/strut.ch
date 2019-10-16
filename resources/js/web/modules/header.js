// function debounce(a,b,c){var d;return function(){var e=this,f=arguments;clearTimeout(d),d=setTimeout(function(){d=null,c||a.apply(e,f)},b),c&&!d&&a.apply(e,f)}}

var Header = (function() {

  var lastScrollPos = 0;

  var _initialize = function() {
    $(window).scroll(function(event){
      if ($(this).scrollTop() <= 0) {
        $('header.site-header').removeClass('is-tiny');
        return;
      }
      var scrollPos = $(this).scrollTop();

      if (scrollPos > lastScrollPos && scrollPos > 170){
        $('header.site-header').removeClass('is-tiny');
      }
      else if (scrollPos < lastScrollPos && scrollPos > 170) {
        $('header.site-header').addClass('is-tiny');
      }
      lastScrollPos = scrollPos;
    });
  };

  // var _scroll = debounce(function(){
  //   var scrollPos = $(this).scrollTop();

  //   if (scrollPos > lastScrollPos && scrollPos > 170){
  //     $('header.site-header').addClass('is-hidden')
  //                            .removeClass('is-tiny');
  //   }
  //   else if (scrollPos < lastScrollPos) {
  //     $('header.site-header').removeClass('is-hidden')
  //                            .addClass('is-tiny');
  //   }
  //   lastScrollPos = scrollPos;
  // }, 100);
  
  /* --------------------------------------------------------------
  * RETURN PUBLIC METHODS
  * ------------------------------------------------------------ */
        
  return {
    init: _initialize,
  };

})();

// Initialize
$(function() {
  Header.init();
});