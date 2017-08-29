function homePageMajorsList() {
  $('.top-majors-heading').on('click', function() {
    if ($(window).width() < 992) {
      $('.top-majors-heading, .top-majors-content').toggleClass('expanded');
    }
  });
}

function init() {
  homePageMajorsList();
}

$(init());