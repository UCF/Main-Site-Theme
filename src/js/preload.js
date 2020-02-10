$(document).ready(() => {
  $('link[rel=preload]').attr('onload', null).attr('rel', 'stylesheet');
});
