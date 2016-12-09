var map,
  offset,
  $scrollSection,
  scrollStop;

var init = function() {
  $scrollSection = $('#stats-section');
  scrollStop = false;

  if ($.isFunction($.matchHeight)) {
    initializeMatchHeight();
  } else {
    lazyLoadMatchHeight();
  }

  $('.count-up').text('0');
  $(document).on('scroll', scroll);
  $(window).on('resize', onResize);
  scroll();
  onResize();
};

var scroll = function() {
  var scrollTop = $(window).scrollTop();
  if ((scrollTop >= offset) && (!scrollStop)) {
    if (countUp && typeof(countUp) == "function") {
      countUp($);
    }
    scrollStop = true;
  }
};

var onResize = function() {
  offset = $scrollSection.offset().top - $(window).height();
};

var lazyLoadMatchHeight = function() {
  $.getScript("https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js")
    .done(function() {
      initializeMatchHeight();
    });
};

function initializeMatchHeight() {
  $statsItem = $('.stats-info .stats-item');

  $statsItem.matchHeight();

  $(window).on('resize', function() {
    $statsItem.matchHeight();
  });
}

$(document).ready(init);
