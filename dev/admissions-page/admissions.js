var init = function($) {
  if ($.isFunction($.matchHeight)) {
    initializeMatchHeight($);
  } else {
    lazyLoadMatchedHeight($);
  }
};

var lazyLoadMatchedHeight = function($) {
  $.getScript("https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js")
    .done(function() {
      initializeMatchHeight($);
    });
};

var initializeMatchHeight = function($) {
  $cards = $('.color-card').matchHeight();

  $(window).on('resize', function() {
    $cards.matchHeight();
  });
};

var enableScrollSpy = function($) {
  $('.animate-scroll').click(function(e) {
    e.preventDefault();

    var $target = $(this.hash);
    $target = $target.length ? $target : $('[name=' + this.hash.slice() + ']');

    var scrollTo = $target.offset().top - 50;

    if ($target.length) {
      $('html, body').animate({
        scrollTop: scrollTo
      }, 750);
    }
  });
};

jQuery(document).ready(function($) {
  init($);
  enableScrollSpy($);
});
