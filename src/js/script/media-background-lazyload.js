//
// Make IE11 behave with lazy-loaded media backgrounds via lazysizes.
//

(function ($) {

  $(document).on('lazyloaded', (e) => {
    const $loadedAsset = $(e.target);
    if ($loadedAsset.hasClass('media-background')) {
      $(e.target).mediaBackground();
    }
  });

}(jQuery));
