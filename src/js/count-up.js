(function ($) {

  function numberWithCommas(num) {
    return num.toLocaleString();
  }

  $.fn.countUp = function (options) {
    const settings = $.extend({
      duration: 4000,
      easing: 'linear'
    }, options);

    this.each((index, elem) => {
      const $num = $(elem);
      const countTo = $num.data('num') ? parseInt($num.data('num'), 10) : parseInt($num.text().replace(/\D/g, ''), 10);
      const start = $num.data('start') ? parseInt($num.data('start'), 10) : 0;

      if (Number.isInteger(start) && Number.isInteger(countTo) && countTo > 0) {
        $({
          countNum: start
        }).animate({
          countNum: countTo
        },
        {
          duration: settings.duration,
          easing: settings.easing,
          step: (i) => {
            $num.text(numberWithCommas(Math.floor(i)));
          },
          complete: () => {
            $num.text(numberWithCommas(countTo));
          }
        });
      }
    });

    return this;
  };

  $(document).ready(() => {
    $('.count-up').countUp();
  });

}(jQuery));
