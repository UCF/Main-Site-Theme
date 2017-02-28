var map,
  offset,
  $statsSection,
  $socialSection,
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
  $statsSection = $('#stats-section');
  $socialSection = $('#social-section');
  scrollStop = {
    stats: false,
    social: false
  };
  offset = {
    stats: 0,
    social: 0
  };

  initializeMatchHeight();
  homePageMajorsList();

  $('.count-up').text('0');

  $(document)
    .on('scroll', statsCounter)
    .on('scroll', socialLazyLoad);
  $(window).on('load resize', onResize);
};

var setOffsets = function() {
  offset = {
    stats: $statsSection.offset().top - $(window).height(),
    social: $socialSection.offset().top - $(window).height()
  };
};

var onResize = debounce(function () {
  setOffsets();

  // Allow scroll events to re-run after ensuring offsets are set
  statsCounter();
  socialLazyLoad();
}, 100);

var statsCounter = function() {
  if (($(window).scrollTop() >= offset.stats) && (!scrollStop.stats)) {
    if (countUp && typeof(countUp) == 'function') {
      countUp($);
    }
    scrollStop.stats = true;
    $(document).off('scroll', statsCounter);
  }
};

var socialLazyLoad = function() {
  if (($(window).scrollTop() >= offset.social) && (!scrollStop.social)) {
    facebookWidgetInit();
    twitterWidgetInit();

    scrollStop.social = true;
    $(document).off('scroll', socialLazyLoad);
  }
};

// The javascript provided by the Facebook widget to initialize it.
// Included here instead of manually within the page markup so that we can
// conditionally initialize it based on the user's scroll position.
function facebookWidgetInit() {
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '637856803059940',
      xfbml      : true,
      version    : 'v2.8'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
}

// The javascript provided by the Twitter widget to initialize it.
// Included here instead of manually within the page markup so that we can
// conditionally initialize it based on the user's scroll position.
function twitterWidgetInit() {
  !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
}

function initializeMatchHeight() {
  $statsItem = $('.stats-item-row .stats-item');
  $matchHeights = $('.match-heights');

  $(window).on('load resize', function() {
    $statsItem.matchHeight();
    $matchHeights.matchHeight();
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
