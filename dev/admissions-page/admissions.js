var enableScrollSpy = function($) {
  $('.animate-scroll').click(function(e) {
    e.preventDefault();

    var $target = $(this.hash);
    $target = $target.length ? $target : $('[name=' + this.hash.slice() + ']');

    var scrollTo = $target.offset().top - 50;

    if ($target.length) {
      $('html, body').animate({
        scrollTop: scrollTo
      }, 750);
    }
  });
};

jQuery(document).ready(function($) {
  enableScrollSpy($);
});
