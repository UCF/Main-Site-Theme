var map;

var init = function() {

  if ($.isFunction($.matchHeight)) {
    initializeMatchHeight();
  } else {
    lazyLoadMatchHeight();
  }
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
