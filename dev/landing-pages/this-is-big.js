/*
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
*/

var player, iframe;
var $ = document.querySelector.bind(document);

// init player
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    height: '200',
    width: '300',
    videoId: 'gJ390e5sjHk',
    events: {
      'onReady': onPlayerReady
    }
  });
}

// when ready, wait for clicks
function onPlayerReady(event) {
  var player = event.target;
  iframe = $('#player');
  setupListener();
}

function setupListener (){
$('.play-video').addEventListener('click', playFullscreen);
}

function playFullscreen (){
  player.playVideo();//won't work on mobile

  var requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
  if (requestFullScreen) {
    requestFullScreen.bind(iframe)();
  }
}

$(setupListener());