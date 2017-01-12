(function() {

    var $jumpTo       = $('#jump-to'),
        $alphaResults = $('.post-type-search-alpha'),
        toTopMarkup   = '<span class="to-top-text"><span class="fa fa-long-arrow-up"></span> <a href="#">Back to Top</a></span>';


    // Apply jump-to logic to select option click event
    $jumpTo.on('change', function() {
      window.location.hash = $jumpTo.val();
    });


    // Manipulate post type search results, per each letter section
    $alphaResults.find('.post-search-heading-wrap').each(function() {
      var $letterWrap        = $(this),
          $column            = $letterWrap.parent('div'), // .col-*
          $letterHeading     = $letterWrap.find('.post-search-heading'),
          $letterList        = $column.find('.post-search-list'),
          letter             = $letterHeading.text().toLowerCase(),
          letterAnchorMarkup = '<div class="az-jumpto-anchor" id="az-' + letter + '"></div>';

      // Add an anchor for each letter heading.
      $letterWrap
        .prepend(letterAnchorMarkup);

      // Add back-to-top links to each letter section.
      $letterHeading
        .after(toTopMarkup);

      // Disable jump-to options for sections with no content
      if ($letterList.children().length < 1) {
        $jumpTo.find('option[value="az-'+ letter +'"]').attr('disabled', true);
      }

    });

})();
