$(function() {
  $('.fade-in').css({
      opacity: 1,
      transform: 'translateY(0)'
    });

  $('.academics-search-box input').focusin(function() {
    $('.academics-search-box').addClass('focus');
  });
});