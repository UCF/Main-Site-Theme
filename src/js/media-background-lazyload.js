//
// Handles pause/play buttons for video backgrounds.
//

(function ($) {

  $(document).on('lazyloaded', (e) => {
    const $loadedAsset = $(e.target);
    if ($loadedAsset.hasClass('media-background')) {
      $(e.target).mediaBackground();
    }
  });

}(jQuery));
