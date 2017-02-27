var offset,
  $scrollSection,
  scrollStop;

var init = function() {
  $scrollSection = $('#meaningful-impact');
  scrollStop = false;

  $('.count-up').text('0');

  $(document).on('scroll', scroll);
  $(window).on('load resize', onResize);
};

var scroll = function() {
  var scrollTop = $(window).scrollTop();
  if (scrollTop >= offset && (!scrollStop)) {
    if (countUp && typeof(countUp) == "function") {
      countUp($);
    }
    scrollStop = true;
    $(document).off('scroll', scroll);
  }
};

var onResize = debounce(function () {
  offset = $scrollSection.offset().top - $(window).height();
  scroll(); // Allow scroll to re-run after ensuring offset is set
}, 100);


$(document).ready(init);
