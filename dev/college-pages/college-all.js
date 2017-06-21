function init() {
  topDegreesListToggle();
}

function topDegreesListToggle() {
  $('.top-majors-heading').on('click', function() {
    var $heading = $(this);

    if ($(window).width() < 992) {
      $heading
        .add($heading.siblings('.top-majors-content'))
        .toggleClass('expanded');
    }
  });
}


$(init);
