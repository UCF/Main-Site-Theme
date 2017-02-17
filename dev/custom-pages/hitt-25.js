var offset,
  $scrollSection;

/**
 * Debouce method to pause logic until resize is complete
 */
function debounce(func, wait, immediate) {
  var timeout;
  return function () {
    var context = this,
        args = arguments;

    var later = function () {
        timeout = null;
        if (!immediate) func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
};

var init = function() {
  $scrollSection = $('#meaningful-impact');

  $('.count-up').text('0');

  $(document).on('scroll', scroll);
  $(window).on('load resize', onResize);
};

var scroll = function() {
  var scrollTop = $(window).scrollTop();
  if (scrollTop >= offset) {
    if (countUp && typeof(countUp) == "function") {
      countUp($);
    }
    $(document).off('scroll', scroll);
  }
};

var onResize = debounce(function () {
  offset = $scrollSection.offset().top - $(window).height();
  scroll(); // Allow scroll to re-run after ensuring offset is set
}, 100);


$(document).ready(init);
