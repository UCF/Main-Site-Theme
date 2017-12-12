//
// Handles pause/play buttons for video backgrounds.
//

(function ($) {

  const $btns = $('.media-background-video-toggle');
  const $videos = $('.media-background-video');
  const cookieName = 'ucfedu-autoplay-bg-videos';
  const cookieSettings = {
    expires: 365,
    domain: UCFEDU.domain
  };


  function btnClickHandler() {
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
    $btns
      .removeClass('play-disabled')
      .addClass('play-enabled');
  }

  function toggleBtnPause() {
    $btns
      .removeClass('play-enabled')
      .addClass('play-disabled');
  }

  function bgVideosPlay() {
    $videos.each(function () {
      if (this.paused || this.ended) {
        this.play();
      }
    });
  }

  function bgVideosPause() {
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

  function init() {
    if ($videos.length && $btns.length) {
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

      // Show the toggle btn and apply event handling
      $btns
        .removeClass('hidden-xs-up')
        .on('click', btnClickHandler);

      // Reset the btn controls when the first video on the page ends
      $videos.get(0).addEventListener('ended', toggleBtnPause, false);
    }
  }

  $(init);


}(jQuery));
