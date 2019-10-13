var FancyBox = (function() {

  var selectors = {
    body: 'body',
    gallery: '[data-fancybox="gallery"]',
    single:  '[data-fancybox="single"]'
  };

  var _initialize = function() {
    
    $(selectors.gallery).fancybox({
      buttons: [
        "close"
      ],
      infobar: false,
      btnTpl: {
        close: '<a href="javascript:;" data-fancybox-close class="btn-fancybox-close"></a>',
        arrowLeft: '<a href="javascript:;" data-fancybox-prev class="btn-fancybox-prev"><span></span></a>',
        arrowRight: '<a href="javascript:;" data-fancybox-next class="btn-fancybox-next"><span></span></a>',
      },

      baseTpl:
      '<div class="fancybox-container" role="dialog" tabindex="-1">' +
      '<div class="fancybox-bg"></div>' +
      '<div class="fancybox-inner">' +
      '<div class="fancybox-infobar"><span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span></div>' +
      '<div class="fancybox-toolbar">{{buttons}}</div>' +
      '<div class="fancybox-navigation">{{arrows}}</div>' +
      '<div class="fancybox-stage"></div>' +
      '</div>' +
      '</div>',
      
      afterLoad : function(fb, item){
        item.$content.remove('.fb-caption').append('<div class="fb-caption">' + item.opts.caption + '</div>');
      }
    });

    $(selectors.single).fancybox({
      buttons: [
        "close"
      ],
      infobar: false,
      btnTpl: {
        close: '<a href="javascript:;" data-fancybox-close class="btn-fancybox-close"></a>',
      },
      baseTpl:
      '<div class="fancybox-container" role="dialog" tabindex="-1">' +
      '<div class="fancybox-bg"></div>' +
      '<div class="fancybox-inner">' +
      '<div class="fancybox-infobar"><span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span></div>' +
      '<div class="fancybox-toolbar">{{buttons}}</div>' +
      '<div class="fancybox-navigation">{{arrows}}</div>' +
      '<div class="fancybox-stage"></div>' +
      '</div>' +
      '</div>',
      
      afterLoad : function(fb, item){
        item.$content.remove('.fb-caption').append('<div class="fb-caption">' + item.opts.caption + '</div>');
      }
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