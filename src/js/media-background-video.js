//
// Handles autoloading and pause/play buttons for video backgrounds.
//

(function ($) {

  const btnSelector = '.media-background-video-toggle';
  const videoSelector = '.media-background-video';
  const templateSelector = '.js-tmpl-media-background-video';
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

  function getTemplates() {
    return $(templateSelector);
  }

  function getVideoBtns() {
    return $(btnSelector);
  }

  // Inserts a video into the page from a template, replacing its placeholder.
  function insertVideoIfVisible($template, $placeholder) {
    if ($placeholder.isInViewport()) {
      const $video = $($template.html());
      $placeholder.replaceWith($video);
      $(window).trigger('videoAutoloaded');
      $template.remove();
    }
  }

  // Synchronizes all video playback and toggle button behavior based on cookie settings
  function syncToggleableVideos() {
    const $videos = getVideos();
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
    $btns
      .removeClass('hidden-xs-up')
      .on('click', btnClickHandler);

    // Reset the btn controls when the first video on the page ends
    $videos.get(0).addEventListener('ended', toggleBtnPause, false);
  }

  // Returns whether or not a given element is visible in the viewport
  $.fn.isInViewport = function () {
    const elementTop = $(this).offset().top;
    const elementBottom = elementTop + $(this).outerHeight();

    const viewportTop = $(window).scrollTop();
    const viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
  };

  // Autoloads a video from a template into a placeholder on the page.
  $.fn.autoloadVideo = function () {

    this.each(() => {
      const $tmpl = $(this);
      const $placeholder = $(`#${$tmpl.attr('data-placeholder')}`);

      if ($placeholder.length) {
        const scrollCallback = function () {
          insertVideoIfVisible($tmpl, $placeholder);

          if (!$(document).find($tmpl).length) {
            $(window).off('scroll', scrollCallback);
          }
        };

        $(window).on('load scroll', scrollCallback);
      }
    });

    return this;

  };

  function init() {
    if ($(window).width() >= videoViewportMinThreshold) {
      const $templates = getTemplates();
      const $videos = getVideos();
      const $btns = getVideoBtns();

      if ($templates.length) {
        $templates.autoloadVideo();
        $(window).on('videoAutoloaded', syncToggleableVideos);
      }
      if ($videos.length && $btns.length) {
        syncToggleableVideos();
      }
    }
  }

  $(init);


}(jQuery));
