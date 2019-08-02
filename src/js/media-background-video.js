//
// Handles autoloading and pause/play buttons for video backgrounds.
//

(function ($) {

  const btnSelector = '.media-background-video-toggle';
  const videoSelector = '.media-background-video';
  const videoViewportMinThreshold = 576; // px
  const cookieName = 'ucfedu-autoplay-bg-videos';
  const cookieSettings = {
    expires: 365,
    domain: UCFEDU.domain
  };


  function btnClickHandler() {
    const $btns = getVideoBtns();
    if ($btns.first().hasClass('play-enabled')) {
      toggleBtnPause();
      bgVideosPause();
      disableBgVideoAutoplay();
    } else {
      toggleBtnPlay();
      bgVideosPlay();
      enableBgVideoAutoplay();
    }
  }

  function toggleBtnPlay() {
    const $btns = getVideoBtns();
    $btns
      .removeClass('play-disabled')
      .addClass('play-enabled');
  }

  function toggleBtnPause() {
    const $btns = getVideoBtns();
    $btns
      .removeClass('play-enabled')
      .addClass('play-disabled');
  }

  function bgVideosPlay() {
    const $videos = getVideos();
    $videos.each(function () {
      if (this.paused || this.ended) {
        this.play();
      }
    });
  }

  function bgVideosPause() {
    const $videos = getVideos();
    $videos.each(function () {
      if (!this.paused || !this.ended) {
        this.pause();
      }
    });
  }

  function enableBgVideoAutoplay() {
    if (getAutoplayCookie() !== '1') {
      updateAutoplayCookie('1');
    }
  }

  function disableBgVideoAutoplay() {
    if (getAutoplayCookie() !== '0') {
      updateAutoplayCookie('0');
    }
  }

  function getAutoplayCookie() {
    return Cookies.get(cookieName);
  }

  function setAutoplayCookie(value) {
    Cookies.set(cookieName, value, cookieSettings);
  }

  function deleteAutoplayCookie() {
    Cookies.remove(cookieName, cookieSettings);
  }

  function updateAutoplayCookie(value) {
    deleteAutoplayCookie();
    setAutoplayCookie(value);
  }

  function getVideos() {
    return $(videoSelector);
  }

  function getVideoBtns() {
    return $(btnSelector);
  }

  // Synchronizes all video playback and toggle button behavior based on cookie settings
  function syncToggleableVideos() {
    const $btns = getVideoBtns();

    // Set the autoplay cookie if it hasn't been set yet
    if (typeof Cookies.get(cookieName) === 'undefined') {
      setAutoplayCookie('1');
    }

    // Toggle the btn and video play on load
    if (getAutoplayCookie() === '1') {
      toggleBtnPlay();
    } else {
      toggleBtnPause();
      bgVideosPause();
    }

    // Show the toggle btns and apply event handling
    $btns.each(function () {
      const $btn = $(this);
      // NOTE: All toggle btns, whether included in the page header or
      // elsewhere, must have the class 'hidden-xs-up'. The click handler will
      // not be assigned to the button if it doesn't have this class.
      if ($btn.hasClass('hidden-xs-up')) {
        $btn
          .removeClass('hidden-xs-up')
          .on('click', btnClickHandler);
      }
    });
  }

  // Returns whether or not a given element is visible in the viewport
  $.fn.isInViewport = function () {
    const elementTop = $(this).offset().top;
    const elementBottom = elementTop + $(this).outerHeight();

    const viewportTop = $(window).scrollTop();
    const viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
  };

  // Updates a preload="none" media background video to
  // load when visible and autoplay.
  $.fn.autoloadVideo = function () {

    this.each(function () {
      const $video = $(this);

      if ($video.attr('preload') === 'none') {
        const scrollCallback = function () {
          if ($video.isInViewport()) {
            const video = $video.get(0);
            video.autoplay = true;
            video.preload = 'auto';

            syncToggleableVideos();

            $(window).off('scroll', scrollCallback);
          }
        };

        // TODO add debounce
        $(window).on('load scroll', scrollCallback);
      }
    });

    return this;

  };

  function init() {
    if ($(window).width() >= videoViewportMinThreshold) {
      const $videos = getVideos();

      if ($videos.length) {
        $videos.autoloadVideo();

        // Reset the btn controls when the first video on the page ends
        $videos.get(0).addEventListener('ended', toggleBtnPause, false);
      }
    }
  }

  $(init);


}(jQuery));
