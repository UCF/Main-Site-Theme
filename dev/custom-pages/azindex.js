(function() {

    var $alphaResults = $('.post-type-search-alpha'),
        toTopMarkup   = '<span class="to-top-text"><span class="fa fa-long-arrow-up"></span> <a href="#">Back to Top</a></span>';


    // Debouce method to pause logic until resize is complete
    function debounce(func, wait, immediate) {
      var timeout;

      return function () {
        var context = this,
            args = arguments;

        var later = function () {
          timeout = null;
          if (!immediate) {
            func.apply(context, args);
          }
        };

        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);

        if (callNow) {
          func.apply(context, args);
        }
      };
    }

    // Returns offset values for bootstrap affixing on $letterWrap's.
    function getLetterWrapAffixOffset($letterWrap, $letterList) {
      var bottom = $letterList.offset().top + $letterList.height();

      if ($(window).width() > 767) {
        bottom += $letterWrap.outerHeight();
      }

      return {
        top: $letterWrap.offset().top + 50,  // 50 = ucf header height
        bottom: $(document).height() - bottom
      };
    }

    // Manipulate post type search results, per each letter section
    $alphaResults.find('.post-search-heading-wrap').each(function() {
      var $letterWrap        = $(this),
          $column            = $letterWrap.parent('div'), // .col-*
          $letterHeading     = $letterWrap.find('.post-search-heading'),
          $letterList        = $column.find('.post-search-list'),
          letter             = $letterHeading.text().toLowerCase(),
          letterAnchorMarkup = '<div class="az-jumpto-anchor" id="az-' + letter + '"></div>',
          letterWrapAffix    = { offset: null };

      // Add an anchor for each letter heading.
      $letterWrap
        .prepend(letterAnchorMarkup);

      // Add back-to-top links to each letter section.
      $letterHeading
        .after(toTopMarkup);

      // Apply affixing to each heading wrap, if that letter has list items.
      letterWrapAffix.offset = getLetterWrapAffixOffset($letterWrap, $letterList);
      $letterWrap.affix(letterWrapAffix);

      // Update affix offsets on window resize.
      $(window).on('resize', debounce( function() {
        $letterWrap.data('bs.affix').options.offset = getLetterWrapAffixOffset($letterWrap, $letterList);
      }, 100));

    });

})();
