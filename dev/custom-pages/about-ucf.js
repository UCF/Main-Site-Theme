var offset,
  $socialSection,
  scrollStop;

var init = function() {
  $socialSection = $('#social-section');
  scrollStop = {
    social: false
  };
  offset = {
    social: 0
  };

  $(document).on('scroll', socialLazyLoad);
  $(window).on('load resize', onResize);
};

var setOffsets = function() {
  offset = {
    social: $socialSection.offset().top - $(window).height() - 100 // start loading just before it's scrolled to
  };
};

var onResize = debounce(function () {
  setOffsets();

  // Allow scroll events to re-run after ensuring offsets are set
  socialLazyLoad();
}, 100);

var socialLazyLoad = function() {
  if (($(window).scrollTop() >= offset.social) && (!scrollStop.social)) {
    facebookWidgetInit();

    scrollStop.social = true;
    $(document).off('scroll', socialLazyLoad);
  }
};

// The javascript and html provided by the Facebook widget to initialize it.
// Included here instead of manually within the page markup so that we can
// conditionally initialize it based on the user's scroll position.
function facebookWidgetInit() {
  var widgetMarkup = '<div class="fb-page" data-href="https://www.facebook.com/ucf" data-tabs="timeline" data-width="500px" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false"><blockquote cite="https://www.facebook.com/ucf" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ucf">University of Central Florida</a></blockquote></div>';

  $socialSection
    .find('#js-facebook-widget')
    .html(widgetMarkup);

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


$(document).ready(init);
