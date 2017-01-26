(function() {
  // Make Flickr behave
  function responsiveFlickrEmbeds() {
    $('.flickr-embed-frame').each(function() {
      var $iframe = $(this),
          $innerNav = $(this.contentDocument || this.contentWindow.document).find('.flickr-embed-photo'),
          width = $iframe.width(),
          ratio = $iframe.height() / width,
          parentWidth = $iframe.parent().width();

      if (width !== parentWidth) {
        $iframe
          .add($innerNav)
          .width(parentWidth)
          .height(parentWidth * ratio);
      }
    });
  }

  $(window).on('load resize', responsiveFlickrEmbeds);
})();
