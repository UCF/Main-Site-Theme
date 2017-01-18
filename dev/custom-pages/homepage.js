var map,
  offset,
  $scrollSection,
  scrollStop;

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
  $scrollSection = $('#stats-section');
  scrollStop = false;

  initializeMatchHeight();
  homePageMajorsList();

  $('.count-up').text('0');
  $(document).on('load scroll', scroll);
  $(window).on('load resize', onResize);
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

var onResize = debounce(function () {
  offset = $scrollSection.offset().top - $(window).height();
}, 100);

function initializeMatchHeight() {
  $statsItem = $('.stats-item-row .stats-item');

  $statsItem.matchHeight();

  $(window).on('resize', function() {
    $statsItem.matchHeight();
  });
}

function homePageMajorsList() {
  $('.top-majors-heading').on('click', function() {
    if ($(window).width() < 992) {
      $('.top-majors-heading, .top-majors-content').toggleClass('expanded');
    }
  });
};

$(document).ready(init);
