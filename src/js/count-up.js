(function ($) {
  $.fn.countUp = function (options) {
    const settings = $.extend({
      duration: 4000,
      easing: 'linear'
    }, options);

    const numberWithCommas = (number) => {
      return number.toLocaleString();
    };

    this.each(() => {
      const countTo = this.data('num');
      const start = this.data('start') ? this.data('start') : 0;

      $({
        countNum: start
      }).animate({
        countNum: countTo
      },
        {
          duration: settings.duration,
          easing: settings.easing,
          step: (i) => {
            this.text(numberWithCommas(Math.floor(i)));
          },
          complete: () => {
            this.text(numberWithCommas(countTo));
          }
        });
    });
  };

  $(document).ready(() => {
    $('.count-up').countUp();
  });
}(jQuery));
