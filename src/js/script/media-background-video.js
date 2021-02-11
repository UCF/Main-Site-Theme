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
  let initTimer = null;


  function isPlaybackEnabled() {
    const $btns = getVideoBtns();
    return $btns.first().hasClass('play-enabled');
  }

  function btnClickHandler() {
    if (isPlaybackEnabled()) {
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
      if (
        (this.paused || this.ended)
        && this.autoplay
      ) {
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

  // Synchronizes all video playback and toggle button behavior
  function syncToggleableVideos() {
    const $btns = getVideoBtns();
    let playbackSetting = '0';

    // Set the autoplay cookie if it hasn't been set yet
    if (typeof Cookies.get(cookieName) === 'undefined') {
      playbackSetting = isPlaybackEnabled() ? '1' : '0';
      setAutoplayCookie(playbackSetting);
    } else {
      playbackSetting = getAutoplayCookie();
    }

    // Toggle the btn and video play on load
    if (playbackSetting === '1') {
      toggleBtnPlay();
      bgVideosPlay();
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
      const video = $video.get(0);
      let scrollCallbackTimer = null;

      if (
        video.preload === 'none'
        || video.preload === 'auto' && !video.autoplay
      ) {
        const scrollCallback = function () {
          if ($video.isInViewport()) {
            $video
              .attr('autoplay', true)
              .attr('preload', 'auto');
            video.autoplay = true;
            video.preload = 'auto';

            syncToggleableVideos();

            $(window).off('scroll', scrollCallbackDebounce);
          }
        };

        const scrollCallbackDebounce = function () {
          clearTimeout(scrollCallbackTimer);
          scrollCallbackTimer = setTimeout(scrollCallback, 25);
        };

        $(window).on('scroll', scrollCallbackDebounce);

        // Call scrollCallback manually for onload event or window resize up:
        scrollCallback();
      }
    });

    return this;

  };

  function initDebounce() {
    clearTimeout(initTimer);
    initTimer = setTimeout(init, 250);
  }

  function init() {
    if ($(window).width() >= videoViewportMinThreshold) {
      const $videos = getVideos();

      if ($videos.length) {
        $videos.autoloadVideo();

        // Reset the btn controls when the first video on the page ends
        $videos.get(0).addEventListener('ended', toggleBtnPause, false);
      }

      $(window).off('resize', initDebounce);
    }
  }

  $(window)
    .on('load', init)
    .on('resize', initDebounce);


}(jQuery));
