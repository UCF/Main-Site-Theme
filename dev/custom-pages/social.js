(function() {

  var $twitterWidget = $('#js-twitter-widget'),
      $siteFooter = $('#footer'),
      affixInitiated = false;

  $(window).on('load resize', function() {
    if ($(window).width() > 767) {
      if ($twitterWidget.hasClass('affix-cancel')) {
        $twitterWidget.removeClass('affix-cancel');
      }

      if (affixInitiated) {
        $twitterWidget.affix('checkPosition');
      }
      else {
        $twitterWidget.affix({
          offset: {
            top: $twitterWidget.offset().top,
            bottom: $siteFooter.outerHeight(true) + 50  // make up for some unaccounted pixels
          }
        });

        affixInitiated = true;
      }
    }
    else {
      if (affixInitiated) {
        // Use CSS to disable the affix effect.
        $twitterWidget.addClass('affix-cancel');
      }
    }
  });

}());
