var Generic = {};

// Helper function to get the actual window width in all browsers
// (Firefox and IE like to include the width of vertical scrollbars
// while Webkit doesn't, causing some inconsistencies.)
getRealWindowWidth = function($) {
  $('body').css('overflow', 'hidden');
  var realWidth = $(window).width();
  $('body').css('overflow', 'auto');

  return realWidth;
}


Generic.defaultMenuSeparators = function($) {
  // Because IE sucks, we're removing the last stray separator
  // on default navigation menus for browsers that don't
  // support the :last-child CSS property
  $('.menu.horizontal li:last-child').addClass('last');
};

Generic.removeExtraGformStyles = function($) {
  // Since we're re-registering the Gravity Form stylesheet
  // manually and we can't dequeue the stylesheet GF adds
  // by default, we're removing the reference to the script if
  // it exists on the page (if CSS hasn't been turned off in GF settings.)
  $('link#gforms_css-css').remove();
}

Generic.mobileNavBar = function($) {
  // Switch the navigation bar from standard horizontal nav to bootstrap mobile nav
  // when the browser is at mobile size:
  var mobile_wrap = function() {
    $('#header-menu').wrap('<div class="navbar navbar-inverse"><div class="navbar-inner"><div class="container" id="mobile_dropdown_container"><div class="nav-collapse"></div></div></div></div>');
    $('<a class="btn btn-navbar" id="mobile_dropdown_toggle" data-target=".nav-collapse" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><a class="brand" href="#">Navigation</a>').prependTo('#mobile_dropdown_container');
    $('.current-menu-item, .current_page_item').addClass('active');
  }
  var mobile_unwrap = function() {
    $('#mobile_dropdown_toggle .icon-bar').remove();
    $('#mobile_dropdown_toggle').remove();
    $('#mobile_dropdown_container a.brand').remove();
    $('#header-menu').unwrap();
    $('#header-menu').unwrap();
    $('#header-menu').unwrap();
    $('#header-menu').unwrap();
  }
  var adjust_mobile_nav = function() {
    if (getRealWindowWidth($) <= 480) {
      if ($('#mobile_dropdown_container').length < 1) {
        mobile_wrap();
      }
    }
    else {
      if ($('#mobile_dropdown_container').length > 0) {
        mobile_unwrap();
      }
    }
  }

  if ( $('body').hasClass('ie7') == false && $('body').hasClass('ie8') == false ) { /* Don't resize in IE8 or older */
    adjust_mobile_nav();
    $(window).resize(function() {
      adjust_mobile_nav();
    });
  }
}

Generic.mobileSidebar = function($) {
  if ($('#sidebar_left').length > 0) {
    var moveSidebar = function() {
      if (getRealWindowWidth($) < 768) {
        $('#sidebar_left').remove().insertAfter('#contentcol');
      }
      else {
        $('#sidebar_left').remove().insertBefore('#contentcol');
      }
    }
    if ( $('body').hasClass('ie7') == false && $('body').hasClass('ie8') == false ) { /* Don't resize in IE8 or older */
      moveSidebar();
      $(window).resize(function() {
        moveSidebar();
      });
    }
  }
};


/* Assign browser-specific body classes on page load */
addBodyClasses = function($) {
  var bodyClass = '';
  // Old IE:
  if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
    var ieversion = new Number(RegExp.$1) // capture x.x portion and store as a number
    if (ieversion >= 9)    { bodyClass = 'ie ie9'; }
    else if (ieversion >= 8) { bodyClass = 'ie ie8'; }
    else if (ieversion >= 7) { bodyClass = 'ie ie7'; }
  }
  // iOS:
  else if (navigator.userAgent.match(/iPhone/i))  { bodyClass = 'iphone'; }
  else if (navigator.userAgent.match(/iPad/i))  { bodyClass = 'ipad'; }
  else if (navigator.userAgent.match(/iPod/i))  { bodyClass = 'ipod'; }
  // Android:
  else if (navigator.userAgent.match(/Android/i)) { bodyClass = 'android'; }

  $('body').addClass(bodyClass);
}


/* Adjust iOS devices on rotate */
iosRotateAdjust = function($) {
  if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i)) {
    var viewportmeta = document.querySelector('meta[name="viewport"]');
    if (viewportmeta) {
      viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
      document.body.addEventListener('gesturestart', function () {
        viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
      }, false);
    }
  }
}


/* Slider init */

centerpieceSlider = function($) {
  var slider = $('#centerpiece_slider');
  if(slider.length > 0) {

    // Get all duration values:
    var timeouts = new Array();
    $('#centerpiece_slider ul li').each(function() {
      duration = $(this).attr('data-duration');
      // Just in case it's not assigned through php somehow:
      if (duration == '') {
        duration = 6;
      }
      timeouts.push(duration);
    });

    // Initiate slider:
    $(function() {
      $('#centerpiece_slider ul').cycle({
        delay:  -2000,
        fx:     'fade',
        speed:  2000,
        pager:  '#centerpiece_control',
        slideExpr: '.centerpiece_single',
        slideResize: 0,
        timeoutFn: calculateTimeout
      });
    });

    // timeouts per slide (in seconds)
    function calculateTimeout(currElement, nextElement, opts, isForward) {
      var index = opts.currSlide;
      return timeouts[index] * 1000;
    }

    // Stop slider when a video thumbnail is clicked:
    $('.centerpiece_single_vid_thumb').click(function() {
      $('#centerpiece_slider ul').cycle('pause');
      $(this).hide().next().fadeIn(500);
      // Also hide the centerpiece controls for mobile devices:
      if (getRealWindowWidth($) <= 768) {
        $('#centerpiece_control').hide();
      }
    });

    // If a centerpiece control button is clicked, kill any videos and fix slide dimensions:
    $('#centerpiece_control').click(function() {
      $('#centerpiece_slider li iframe, #centerpiece_slider li object, #centerpiece_slider li embed').each(function() {
        var oldsrc = $(this).attr('src');
        $(this).attr('src', 'empty');
        $(this).attr('src', oldsrc);
        if ($(this).parent().prev('.centerpiece_single_vid_thumb')) {
          $(this).parent().hide().prev('.centerpiece_single_vid_thumb').show();
        }
      });
    });

  }
}


/* Adjust slider video/embed size on window resize (for less than 767px) */

centerpieceVidResize = function($) {
  if ($('#centerpiece_slider').length > 0) {
    var addDimensions = function() {
      var parentw = $('#centerpiece_slider').parent('.span12').width();
      if (getRealWindowWidth($) <= 767) {
        $('li.centerpiece_single .centerpiece_single_vid_hidden, li.centerpiece_single object, li.centerpiece_single iframe, li.centerpiece_single embed')
          .css({'height' : parentw * 0.36 +'px'});
      }
      else if (getRealWindowWidth($) > 767) {
        $('li.centerpiece_single .centerpiece_single_vid_hidden, li.centerpiece_single object, li.centerpiece_single iframe, li.centerpiece_single embed')
          .css({'height' : ''});
      }
    }
    if ( $('body').hasClass('ie7') == false && $('body').hasClass('ie8') == false ) { /* Don't resize in IE8 or older */
      addDimensions();
      $(window).resize(function() {
        addDimensions();
      });
    }
  }
}


/* Set/Unset iframe source on video modal open/close */
videoModalSet = function($) {
  if ($('.video-modal').length > 0) {
    $('.video-modal').on('show', function() {
      var modalID = $(this).attr('id');
      var src = $(this).children('.modal-body').attr('data-src');

      if ($(this).find('iframe').length < 1) {
        $('#' + modalID + ' .modal-body').append('<iframe class="modal-video-player" type="text/html" width="640" height="390" src="'+ src +'" frameborder="0"/>');
      }
    });

    $('.video-modal').on('hide', function() {
      $(this).find('iframe').remove();
    });
  }
}


/* Hide the centerpiece placeholder for single-slide centerpieces
 so that the slide displays properly */
centerpieceSingleSlide = function($) {
  if ( $('#centerpiece_slider > ul li').length < 2 ) {
    $('#centerpiece_slider > ul > img, #centerpiece_control').hide();
  }
}


/* Remove last dot separator between nav menu links: */
removeNavSeparator = function($) {
  //var navcount = $('ul#header-menu li').length - 1;
  $('ul#header-menu li.last').prev('li').addClass('no_nav_separator');
}


/* Add Bootstrap button styles for GravityForm submit buttons */
styleGformButtons = function($) {
  $('.gform_button').addClass('btn');
  $(document).bind('gform_post_render', function(){
    // Handle buttons generated with ajax
      $('.gform_button').addClass('btn');
  });
}


/* Fix subheader height to contain blockquote if it exceeds past its container: */
fixSubheaderHeight = function($) {
  if ($('#subheader').length > 0) {
    var doSubheaderHeight = function() {
      if (getRealWindowWidth($) >= 768) { /* Subhead images hide below this size */
        var subimgHeight = $('#subheader .subheader_subimg').height(),
          quoteHeight = $('#subheader .subhead_quote').height();
        if (quoteHeight > subimgHeight) {
          $('#subheader').height(quoteHeight);
        }
        else {
          $('#subheader').height(subimgHeight);
        }
      }
    }
    if ( $('body').hasClass('ie7') == false && $('body').hasClass('ie8') == false ) { /* Don't resize in IE8 or older */
      $(window).load(function() {
        doSubheaderHeight();
      });
      $(window).resize(function() {
        doSubheaderHeight();
      });
    }
  }
}


/* Call A-Z Index Scrollspy, organize post type search */
azIndex = function($) {
  if ($('.page-content#azindex').length > 0) {

    // Post type search customizations
    $('.post-type-search-header').addClass('row').prepend($('#azIndexList'));
    $('form.post-type-search-form')
      .addClass('span7')
      .children('label')
        .text('Quick Search:')
        .show();
    $('form.post-type-search-form')
      .children('input')
        .removeClass('span3')
        .addClass('search-query');

    $('.post-type-search-alpha h3').each(function() {
      $(this)
        .parent('div').prepend('<div class="az-jumpto-anchor" id="az-' + $(this).text().toLowerCase() + '" />')
        .children('h3').after('<span class="backtotop"><i class="icon-arrow-up"></i> <a href="#top">Back to Top</a></span>');
    });

    // Activate Scrollspy
    if ($('body').hasClass('ie7') == false) {
      $('body').attr({'data-spy' : 'scroll', 'data-offset' : 80, 'data-target' : '#azIndexList'});
      $('#azIndexList').scrollspy();
    }
    else { // Disable affixing/scrollspy in IE7
      $('#azIndexList').attr('data-offset-top', '').attr('data-spy', '');
    }

    // Force 'A' as the active starting letter, since it likes to
    // default to 'Z' for whatever reason
    $('#azIndexList .nav li.active').removeClass('active');
    $('#azIndexList .nav li:first-child').addClass('active');

    // Reset active letter link when 'Back to Top' is clicked
    $('.backtotop a').click(function() {
      $('#azIndexList .nav li.active').removeClass('active');
      $('#azIndexList .nav li:first-child').addClass('active');
    });

    // Set disabled letters for sections with no content
    $('.az-jumpto-anchor').each(function() {
      if ($(this).siblings('.row').children('div').length < 1) {
        var href = '#' + $(this).attr('id');
        $('#azIndexList .nav li a[href="'+ href +'"]').addClass('disabled');
      }
    });
    $('#azIndexList .nav li a.disabled').click(function(e) {
      e.preventDefault();
    });
  }
}


/* Show/hide announcement filter dropdowns */
toggleAnnouncementFilters = function($) {
  audienceBtn = $('#filter_audience');
  keywordBtn = $('#filter_keyword');
  timeBtn = $('#filter_time');

  // reset field values to default any time a new filter is selected
  var resetVals = function() {
    if ($('#filter_audience_wrap').hasClass('active_filter') == false) {
      $('#filter_audience_wrap select option:selected').val("all");
    }
    if ($('#filter_keyword_wrap').hasClass('active_filter') == false) {
      $(this).children('input').val("");
    }
    if ($('#filter_time_wrap').hasClass('active_filter') == false) {
      $('#filter_time_wrap select option:selected').val("thisweek");
    }
  }

  // on load
  if (audienceBtn.hasClass('active')) {
    $('#filter_audience_wrap').show().addClass('active_filter');
  }
  else if (keywordBtn.hasClass('active')) {
    $('#filter_keyword_wrap').show().addClass('active_filter');
  }
  else if (timeBtn.hasClass('active')) {
    $('#filter_time_wrap').show().addClass('active_filter');
  }
  resetVals();

  // on click
  $(audienceBtn).click(function() {
    $('.active_filter').removeClass('active_filter').hide();
    $('#filter_audience_wrap').fadeIn().addClass('active_filter');
    resetVals();
  });

  $(keywordBtn).click(function() {
    $('.active_filter').removeClass('active_filter').hide();
    $('#filter_keyword_wrap').fadeIn().addClass('active_filter');
    resetVals();
  });

  $(timeBtn).click(function() {
    $('.active_filter').removeClass('active_filter').hide();
    $('#filter_time_wrap').fadeIn().addClass('active_filter');
    resetVals();
  });
}


/* IE 7-9 fix for rounded corners on spotlight, news thumbnails */
ieRoundedCornerThumbs = function($) {
  var corners = $('<div class="thumb_corner_tl"></div><div class="thumb_corner_tr"></div><div class="thumb_corner_bl"></div><div class="thumb_corner_br"></div>');
  if ( $('body').hasClass('ie7') || $('body').hasClass('ie8') ) {
    corners.appendTo('.screen-only.spotlight_thumb, .screen-only.news-thumb');
  }
  // IE9 border-radius combined with filter attribute don't play nicely together
  if ( $('body').hasClass('ie9') ) {
    corners.appendTo('.screen-only.news-thumb');
  }
}


/* IE 7-8 fix for Academics Search striped results */
ieStripedAcademicsResults = function($) {
  if ($('#academics-search').length > 0) {
    if ( $('body').hasClass('ie7') || $('body').hasClass('ie8') ) {
      $('.results-list .program:nth-child(2n+1)').css('background-color', '#eee');
    }
  }
}



Generic.PostTypeSearch = function($) {
  $('.post-type-search')
    .each(function(post_type_search_index, post_type_search) {
      var post_type_search = $(post_type_search),
        form             = post_type_search.find('.post-type-search-form'),
        field            = form.find('input[type="text"]'),
        working          = form.find('.working'),
        results          = post_type_search.find('.post-type-search-results'),
        by_term          = post_type_search.find('.post-type-search-term'),
        by_alpha         = post_type_search.find('.post-type-search-alpha'),
        sorting          = post_type_search.find('.post-type-search-sorting'),
        sorting_by_term  = sorting.find('button:eq(0)'),
        sorting_by_alpha = sorting.find('button:eq(1)'),

        post_type_search_data  = null,
        search_data_set        = null,
        column_count           = null,
        column_width           = null,

        typing_timer = null,
        typing_delay = 300, // milliseconds

        prev_post_id_sum = null, // Sum of result post IDs. Used to cache results

        MINIMUM_SEARCH_MATCH_LENGTH = 2;

      // Get the post data for this search
      post_type_search_data = PostTypeSearchDataManager.searches[post_type_search_index];
      if(typeof post_type_search_data == 'undefined') { // Search data missing
        return false;
      }

      search_data_set = post_type_search_data.data;
      column_count    = post_type_search_data.column_count;
      column_width    = post_type_search_data.column_width;

      if(column_count == 0 || column_width == '') { // Invalid dimensions
        return false;
      }

      // Sorting toggle
      sorting_by_term.click(function() {
        by_alpha.fadeOut('fast', function() {
          by_term.fadeIn();
          sorting_by_alpha.removeClass('active');
          sorting_by_term.addClass('active');
        });
      });
      sorting_by_alpha.click(function() {
        by_term.fadeOut('fast', function() {
          by_alpha.fadeIn();
          sorting_by_term.removeClass('active');
          sorting_by_alpha.addClass('active');
        });
      });

      // Search form
      form
        .submit(function(event) {
          // Don't allow the form to be submitted
          event.preventDefault();
          perform_search(field.val());
        })
      field
        .keyup(function() {
          // Use a timer to determine when the user is done typing
          if(typing_timer != null)  clearTimeout(typing_timer);
          typing_timer = setTimeout(function() {form.trigger('submit');}, typing_delay);
        });

      function display_search_message(message) {
        results.empty();
        results.append($('<p class="post-type-search-message"><big>' + message + '</big></p>'));
        results.show();
      }

      function perform_search(search_term) {
        var matches             = [],
          elements            = [],
          elements_per_column = null,
          columns             = [],
          post_id_sum         = 0;

        if(search_term.length < MINIMUM_SEARCH_MATCH_LENGTH) {
          results.empty();
          results.hide();
          return;
        }
        // Find the search matches
        $.each(search_data_set, function(post_id, search_data) {
          $.each(search_data, function(search_data_index, term) {
            if(term.toLowerCase().indexOf(search_term.toLowerCase()) != -1) {
              matches.push(post_id);
              return false;
            }
          });
        });
        if(matches.length == 0) {
          display_search_message('No results were found.');
        } else {

          // Copy the associated elements
          $.each(matches, function(match_index, post_id) {

            // If we're only displaying an alphabetical list, be sure to use its
            // elements instead of by_term's elements
            if (by_term.css('display','none')) {
              var element = by_alpha.find('li[data-post-id="' + post_id + '"]:eq(0)');
            }
            else {
              var element = by_term.find('li[data-post-id="' + post_id + '"]:eq(0)');
            }

            var post_id_int = parseInt(post_id, 10);
            post_id_sum += post_id_int;
            if(element.length == 1) {
              elements.push(element.clone());
            }
          });

          if(elements.length == 0) {
            display_search_message('No results were found.');
          } else {

            // Are the results the same as last time?
            if(post_id_sum != prev_post_id_sum) {
              results.empty();
              prev_post_id_sum = post_id_sum;


              // Slice the elements into their respective columns
              elements_per_column = Math.ceil(elements.length / column_count);
              for(var i = 0; i < column_count; i++) {
                var start = i * elements_per_column,
                  end   = start + elements_per_column;
                if(elements.length > start) {
                  columns[i] = elements.slice(start, end);
                }
              }

              // Setup results HTML
              results.append($('<div class="row"></div>'));
              $.each(columns, function(column_index, column_elements) {
                var column_wrap = $('<div class="' + column_width + '"><ul></ul></div>'),
                  column_list = column_wrap.find('ul');

                // Alphabetize search results
                if (navigator.userAgent.toLowerCase().indexOf('chrome') < 0) {
                  column_elements.reverse();
                }

                $.each(column_elements, function(element_index, element) {
                  column_list.append($(element));
                });
                results.find('div[class="row"]').append(column_wrap);
              });
              results
                .append('<a class="close" href="#">×</a>')
                .find('.close').click(function() {
                  $(this).parent('.post-type-search-results').hide();
                });
              results.show();
            }
          }
        }
      }
    });
}

var phonebookStaffToggle = function($) {
  $('#phonebook-search-results a.toggle').click(function() {
    $(this)
      .children('i').toggleClass('icon-plus icon-minus').end()
      .next().fadeToggle();
  });
}


/* Android devices running v2.3 or lower tend to choke on modals :(
  Try to find the src of whatever's contained within the modal
  and set it as the href of the original modal open link
*/
var removeAndroidModals = function($) {
  var ua = navigator.userAgent.toLowerCase();
  if ( (ua.indexOf('android') > -1) && (parseFloat(ua.slice(ua.indexOf('android') + 8)) <= 2.3) ) {
    $('a[data-toggle="modal"]').each(function() {
      var modalLink = $(this);
      var modalID   = modalLink.attr('href');

      // Check for videos whose URLs are contained in the data-src attr
      if ($(modalID).find('[data-src^="http"]').length > 0) {
        var href  = $(modalID).find('[data-src^="http"]').attr('data-src');
      }
      // Otherwise, try to find an element with a src value and grab its URL
      else {
        var href  = $(modalID).find('[src^="http"]').attr('src');
      }

      if (href) {
        modalLink.attr({ 'href' : href, 'data-toggle' : '', 'target' : '_blank' });
      }
    });
  }
}


/* Dev Bootstrap Element Testing-- this should not be running in prod!! */
var devBootstrap = function($) {
  $('#bootstrap-testing-tooltips').tooltip({
    selector: "a[rel=tooltip]"
  });
  $('#bootstrap-testing-popovers').popover({
    trigger: "hover",
    selector: "a[rel=popover]"
  });
}


/* Bootstrap Dropdown fixes for mobile devices */
// Fixes onclick event for mobile devices
$(document).on('touchstart.dropdown', '.dropdown-menu', function(e) { e.stopPropagation(); });
// Prevents page jump on click when activating hover-able elements (dropdowns, tooltips...)
// Note that this assumes popover activators (buttons) won't have a real href value on this site.
$('.dropdown-submenu a[href="#"], a[rel="popover"], a[rel="tooltip"]').click(function(e) { e.preventDefault(); });


/*
 * Check the status site RSS feeds periodically and display an alert if necessary.
 */
var statusAlertCheck = function($) {
  $.getFeed({
    url     : ALERT_RSS_URL,
    cache : false,
    error   : function(feed) {
      $('.status-alert[id!=status-alert-template]').remove();
    },
    success : function(feed) {
      var visible_alert = null;
      var newest      = feed.items[0];

      if (newest) {
        var existing_alert = $('.status-alert[data-alert-id="' + newest.id + '"]'),
          visible_alert = newest.id;
        // Remove 'more info at...' from description
        newest.description = newest.description.replace('More info at www.ucf.edu','');

        // Remove old alerts that no longer appear in the feed
        if( (visible_alert == null) || (visible_alert != $('.status-alert[id!=status-alert-template]').attr('data-alert-id')) ) {
          $('.status-alert[id!=status-alert-template]').remove();
        }

        // Check to see if this alert already exists
        if(existing_alert.length > 0) {
          // Check the content and update if necessary.
          // This will simply fail if the alert has already been closed
          // by the user (alert element has been removed from the DOM)
          var existing_title = existing_alert.find('.title'),
            existing_content = existing_alert.find('.content'),
            existing_type = existing_alert.find('.alert-icon');

          if(existing_title.text() != newest.title) {
            existing_title.text(newest.title);
          }
          if(existing_content.text() != newest.description) {
            existing_content.text(newest.description);
          }
          if(existing_type.hasClass(newest.type) == false) {
            existing_type.attr('class','alert-icon ' + newest.type);
          }

        } else {
          // Make sure this alert hasn't been closed by the user already
          if ($.cookie('ucf_alert_display_' + newest.id) != 'hide') {
            // Create a new alert if an existing one isn't found

            var alert_markup = $('#status-alert-template').clone(true);
            alert_markup
              .attr('id', '')
              .attr('data-alert-id', newest.id);
            $('#header-nav-wrap').before(alert_markup);

            // Apparently IE7 doesn't like to append text to elements
            // that haven't been inserted into the dom yet. THANKS IE.
            $('.status-alert[data-alert-id="' + newest.id + '"]')
              .find('.title').text(newest.title).end()
              .find('.content').text(newest.description).end()
              .find('.more-information').text('Click Here for More Information').end()
              .find('.alert-icon').attr('class', 'alert-icon ' + newest.type);
          }
        }
      }
      else {
        // If the feed is empty (all-clear), hide the currently visible
        // alert, if it exists
        if ($('.status-alert[id!=status-alert-template]').length > 0) {
          $('.status-alert[id!=status-alert-template]').remove();
        }
      }

      // Set cookies for every iteration of new alerts, if necessary
      statusAlertCookieSet($);
    }
  });
}


/*
 * Handle cookies that determine whether an alert has been closed
 * by the user. (Requires jquery.cookie.js)
 * Also adjusts styles as necessary on alert close
 */
var statusAlertCookieSet = function($) {
  $('.status-alert .close').click(function() {
    var alertID = $(this).parents('.status-alert').attr('data-alert-id');
    $.cookie('ucf_alert_display_' + alertID, 'hide', {expires: null, path: SITE_PATH, domain: SITE_DOMAIN});
    $(this).parents('.status-alert')
      .find('.alert-icon').hide().end()
      .css('margin-top', '0');
  });
}


/* GA tracking for outbound clicks */
var gaEventTracking = function($) {
  $('.ga-event').on('click', function(e) {
    e.preventDefault();

    var link = $(this),
      url = link.attr('href'),
      category = link.attr('data-ga-category') ? link.attr('data-ga-category') : 'Outbound Links',
      action = link.attr('data-ga-action'), // link name + action; e.g. "Apply to UCF btn click"
      label = link.attr('data-ga-label');  // the page the user is leaving

    if (typeof ga !== 'undefined' && action !== null && label !== null) {
      ga('send', 'event', category, action, label);
      window.setTimeout(function(){ document.location = url; }, 200);
    }
    else {
      document.location = url;
    }
  });
}


/**
 * Handles the Degree search page
 **/
var degreeSearch = function($) {
  var $academicsSearch,
    $degreeSearchResultsContainer,
    $degreeSearchAgainContainer,
    $sidebarLeft,
    $degreeSearchContent,
    ajaxURL;

  function initAutoComplete() {
    /**
     * Bootstrap typeahead overrides, for general fixes and usability improvements
     **/
    $.fn.typeahead.Constructor.prototype.blur = function() {
      // Workaround for bug in mouse item selection
      var that = this;
      setTimeout(function () { that.hide(); }, 250);
    };

    $.fn.typeahead.Constructor.prototype.select = function(e) {
      var val = this.$menu.find('.active').attr('data-value');
      if (val) {
        this.$element
          .val(this.updater(val))
          .change();
      }

      // Submit the form on select
      if (this.$element.parents('form').length) {
        this.$element.parents('form').eq(0).submit();
      }

      return this.hide();
    };

    $.fn.typeahead.Constructor.prototype.keyup = function(e) {
      switch(e.keyCode) {
        case 40: // down arrow
        case 38: // up arrow
        case 16: // shift
        case 17: // ctrl
        case 18: // alt
        case 9:  // tab
          break;

        // case 9: // Prevent tabbing from filling the autocomplete field with the selection
        case 13: // enter
          if (!this.shown) { return; }
          this.select();
          break;

        case 27: // escape
          if (!this.shown) { return; }
          this.hide();
          break;

        case 39: // right arrow
          if (!this.shown) { return; }
          this.select();
          break;

        default:
          this.lookup();
      }

      e.stopPropagation();
      e.preventDefault();
    }

    $.fn.typeahead.Constructor.prototype.keydown = function(e) {
      this.suppressKeyPressRepeat = ~$.inArray(e.keyCode, [40,38,9,27]); // remove 13 (enter)
      this.move(e);
    }

    $.fn.typeahead.Constructor.prototype.move = function(e) {
      switch(e.keyCode) {
        // case 9: // Remove tab overrides
        case 13: // enter
          if (this.shown) { // Allow enter key to submit form when no suggestions are available
            e.preventDefault();
          }
          break;

        case 27: // escape
          e.preventDefault();
          break;

        case 38: // up arrow
          e.preventDefault();
          this.prev();
          break;

        case 40: // down arrow
          e.preventDefault();
          this.next();
          break;
      }

      e.stopPropagation();
    }

    $.fn.typeahead.Constructor.prototype.render = function(items) {
      var that = this;

      // Don't autoselect 1st suggestion
      items = $(items).map(function (i, item) {
        i = $(that.options.item).attr('data-value', item);
        i.find('a').html(that.highlighter(item));
        return i[0];
      });

      this.$menu.html(items);
      return this;
    };

    /**
     * #search-query specific typeahead init, event handlers
     **/
    var $searchQuery = $academicsSearch.find('#search-query');

    // Typeahead init
    $searchQuery
      .typeahead({
        source: function(query, process) {
          return searchSuggestions; // searchSuggestions defined in page-degree-search.php
        },
        updater: function(item) {
          $(this).val(item);
          return item;
        }
      });

    // Dynamic content reloading for browsers that support history api
    if (supportsHistory()) {
      var timer = null;

      $academicsSearch.on('submit', function(e) {
        e.preventDefault();
        loadDegreeSearchResults();
      });

      $searchQuery
        .on({
          'keyup': function(e) {
            if (e.keyCode === 13) {
              // Don't trigger a submit here (prevent loadDegreeSearchResults from firing twice)
              e.preventDefault();
            }
            else if ($.inArray(e.keyCode, [9, 16, 37, 38, 39, 40]) === -1) {
              if (timer) {
                clearTimeout(timer);
              }
              timer = setTimeout(function() {
                loadDegreeSearchResults();
              }, 300);
            }
          },
          'mouseup': function(e) {
            // Force detection of IE10+ 'x' button click on input field.
            // If the input value is cleared by button press, simulate a keyup
            // event, which will trigger loadDegreeSearchResults() (see above).
            var oldValue = $searchQuery.val();

            if (oldValue == '') {
              return;
            }

            setTimeout(function() {
              var newValue = $searchQuery.val();
              if (newValue == '') {
                $searchQuery.trigger('keyup');
              }
            });
          }
        });
    }
  }

  function updateDocumentHead(data) {
    var baseURL = window.location.href.indexOf('?') > -1 ? window.location.href.split('?')[0] : window.location.href,
        newURL = baseURL + '?' + data.querystring;

    window.history.replaceState(null, null, newURL);

    // <head> updates
    $(document)
      .find('title')
        .text(data.title)
        .end()
      .find('meta[property="og:title"]')
        .attr('content', data.title)
        .end()
      .find('meta[name="description"], meta[property="og:description"]')
        .attr('content', data.description);
  }

  function degreeSearchSuccessHandler(data) {
    $loaderScreen = $academicsSearch.find('#ajax-loading');

    // Make sure the spinner actually gets displayed
    // so the user knows the page changed
    window.setTimeout(function() {
      $loaderScreen.addClass('hidden');

      $degreeSearchResultsContainer
        .html(data.markup)
        .append($loaderScreen);

      $academicsSearch
        .find('.degree-result-count')
          .html(data.count);

      $degreeSearchAgainContainer.html(data.searchagain);

      // Only scroll to results if the user's focus is not on the search field
      // (if a filter/sort option was clicked, and the user is *not* typing a
      // search query). Makes searching on touch devices less of a pain.
      if (!$academicsSearch.find('#search-query').is(':focus')) {
        scrollToResults();
      }
      toggleSidebarAffix();
      updateDocumentHead(data);

      var assistiveText = $('<div>').html(data.count).find('.degree-result-phrase-phone').remove().end().text();
      wp.a11y.speak(assistiveText);
    }, 100);
  }

  function degreeSearchFailureHandler(data) {
    $loaderScreen = $academicsSearch.find('#ajax-loading');

    // Make sure the spinner actually gets displayed
    // so the user knows the page changed
    window.setTimeout(function() {
      $loaderScreen.addClass('hidden');

      $degreeSearchResultsContainer
        .html('Error loading degree data.')
        .append($loaderScreen);

      if (!$academicsSearch.find('#search-query').is(':focus')) {
        scrollToResults();
      }
      toggleSidebarAffix();
      updateDocumentHead(data);

      var assistiveText = 'Error loading degree data.';
      wp.a11y.speak(assistiveText);
    }, 100);
  }

  function supportsHistory() {
    // Determine if the browser supports the history API.
    // Copied from Modernizr
    var ua = navigator.userAgent;

    // We only want Android 2 and 4.0, stock browser, and not Chrome which identifies
    // itself as 'Mobile Safari' as well, nor Windows Phone (issue #1471).
    if ((ua.indexOf('Android 2.') !== -1 ||
        (ua.indexOf('Android 4.0') !== -1)) &&
        ua.indexOf('Mobile Safari') !== -1 &&
        ua.indexOf('Chrome') === -1 &&
        ua.indexOf('Windows Phone') === -1) {
      return false;
    }

    // Return the regular check
    return (window.history && 'pushState' in window.history);
  }

  function loadDegreeSearchResults() {
    if (supportsHistory()) {
      $academicsSearch.find('#ajax-loading').removeClass('hidden');

      var programType = [];
      $academicsSearch.find('.program-type:checked').each(function() {
        programType.push($(this).val());
      });

      var college = [];
      $academicsSearch.find('.college:checked').each(function() {
        college.push($(this).val());
      });

      $.ajax({
        url: ajaxURL,
        type: 'GET',
        // cache: false,
        data: {
          'action': 'degree_search',
          'search-query': encodeURIComponent($academicsSearch.find('#search-query').val()),
          'sort-by': $academicsSearch.find('.sort-by:checked').val(),
          'program-type': programType,
          'college': college
        },
        dataType: 'json'
      })
        .done(function(data) {
          trackFilterForGoogle(programType, college, $academicsSearch.find('#search-query').val());
          degreeSearchSuccessHandler(data);
        })
        .fail(function(data) {
          degreeSearchFailureHandler(data);
        });
    }
    else {
      $academicsSearch.submit();
    }
  }

  function trackFilterForGoogle(programTypes, colleges, searchTerm) {
    if ( typeof ga !== 'undefined' ) {

      var category = 'Degree Search',
        action = 'Filters Updated',
        label = 'Filters Selected';

      ga('send', 'event', category, action, label, {
        'dimension1': searchTerm,
        'dimension2': programTypes.join(),
        'dimension3': colleges.join()
      });
    }
  }

  function resetFilterBtnHandler(e) {
    e.preventDefault();
    $sidebarLeft
      .find('.checkbox input')
      .prop('checked', false);
  }

  function closeMenu(e) {
    e.preventDefault();
    $sidebarLeft
      .add('#mobile-filter')
      .removeClass('active')
      .end()
      .css({
        'max-height': 0
      });
    loadDegreeSearchResults();

    $(document).off('click', closeMenuOnTargetClick);

    // Filter checkbox changes were turned off when the mobile sidebar was activated.
    // Reactivate the event when the mobile sidebar is closed (to allow .close btns in
    // .degree-result-count to trigger loadDegreeSearchResults() on click).
    $academicsSearch.on('change', '.program-type, .college, .location, .sort-by', loadDegreeSearchResults);
  }

  function closeMenuOnTargetClick(e) {
    if ($sidebarLeft.hasClass('active') && !$(e.target).is('#degree-search-sidebar') && !$sidebarLeft.find(e.target).length && !$(e.target).is('#mobile-filter')) {
      closeMenu(e);
    }
  }

  function openMenu(e) {
    var $filterBtn = $('#mobile-filter');

    $(document).on('click', closeMenuOnTargetClick);
    // We only want to trigger loadDegreeSearchResults() when the user closes
    // the sidebar modal (don't run it in the background with every checkbox change)
    $academicsSearch.off('change', '.program-type, .college, .location, .sort-by', loadDegreeSearchResults);

    // resize the panel to be full screen and align it
    $('html, body').animate({
      scrollTop: $filterBtn.offset().top
    }, 200);

    // Position sidebar
    $sidebarLeft
      .css({
        'max-height': $(window).height() - 40,
        'top': $filterBtn.offset().top + ( $filterBtn.outerHeight() / 2 )
      })
      .add($filterBtn)
      .addClass('active');
  }

  function initFilterBtnHandler(e) {
    $academicsSearch.on('click', '#mobile-filter', filterBtnHandler);
    $academicsSearch.on('click', '#mobile-filter-done', closeMenu);
    $academicsSearch.on('click', '#mobile-filter-reset', resetFilterBtnHandler);
  }

  function filterBtnHandler(e) {
    e.preventDefault();

    var $filterBtn = $('#mobile-filter');

    if ($sidebarLeft.hasClass('active')) {
      closeMenu(e);
      $filterBtn.removeClass('active');
    }
    else {
      openMenu(e);
      $filterBtn.addClass('active');
    }
  }

  function toggleSidebarAffix() {
    if ($(window).width() > 767 && $sidebarLeft.outerHeight() < $degreeSearchContent.outerHeight()) {
      $sidebarLeft
        .affix({
          offset: {
            top: $sidebarLeft.offset().top,
            bottom: $('#footer').outerHeight() + 100
          }
        })
        .on('affixed.bs.affix affixed-bottom.bs.affix', function() {
          $degreeSearchContent.addClass('offset3');
        })
        .on('affixed-top.bs.affix', function() {
          $degreeSearchContent.removeClass('offset3');
        });
    }
    else {
      $degreeSearchContent.removeClass('offset3');
      $(window).off('.affix');
      $sidebarLeft
        .removeClass('affix affix-top affix-bottom')
        .removeData('bs.affix');
    }
  }

  function resultPhraseClickHandler(e) {
    var $target = $(e.target),
        $filterCheckbox = $('.' + $target.attr('data-filter-class') + '[value="'+ $target.attr('data-filter-value') + '"]');

    if ($filterCheckbox) {
      $filterCheckbox
        .prop('checked', false)
        .removeAttr('checked')
        .trigger('change');
    }
  }

  function searchAgainClickHandler(e) {
    e.preventDefault();

    var $target = $(e.target),
        programType = $target.attr('data-program-type'),
        searchTerm = $target.attr('data-search-term');

    trackFilterForGoogle([programType], [], searchTerm);

    window.location.href = $target.attr('href');
  }

  function scrollToResults() {
    // Scroll past top page content if the page loaded with GET params set
    // (assume the user submitted a search or something and has already seen
    // the page content); else, scroll to the very top of the page (prevents
    // affixing bugs)
    if (window.location.search !== '') {
      $('html, body').animate({
        scrollTop: $academicsSearch.find('#search-query').offset().top - 20,
      }, 200);
    }
    else {
      $(document).scrollTop(0);
    }
  }

  function setupEventHandlers() {
    $(window).on('load', function() {
      scrollToResults(); // must run before affixing is toggled
    });
    $(window).on('load resize', function() {
      toggleSidebarAffix();

      if (!$academicsSearch.find('#mobile-filter').is(':visible')) {
        $(document).off('click', closeMenuOnTargetClick);
      }
    });

    $academicsSearch.on('change', '.program-type, .college, .location, .sort-by', loadDegreeSearchResults);
    $academicsSearch.on('click', '.degree-result-count .close', resultPhraseClickHandler);
    $academicsSearch.on('click', '.search-again-link', searchAgainClickHandler);
    $academicsSearch.on('click', '.seo-li', function(e) {
      e.preventDefault();
      if ($('body').hasClass('ie8')) {
        // In IE8 trigger doesn't fire correctly
        $(this).closest('li').find('input').trigger('click').trigger('change');
      } else {
        $(this).parent('label').trigger('click');
      }
    });
    initAutoComplete();
    initFilterBtnHandler();
  }

  function initPage() {
    $academicsSearch = $('#academics-search-form');

    if ($academicsSearch.length > 0) {
      $degreeSearchResultsContainer = $academicsSearch.find('.degree-search-results-container');
      $sidebarLeft = $academicsSearch.find('#degree-search-sidebar');
      $degreeSearchContent = $academicsSearch.find('#degree-search-content');
      $degreeSearchAgainContainer = $academicsSearch.find('.degree-search-again-container');
      ajaxURL = $academicsSearch.attr('data-ajax-url');

      setupEventHandlers();
    }
  }

  $(initPage);
}


/**
 * Scripts for single degree profile templates
 **/
var degreeProfile = function($) {
  var $degreeSingle = $('#degree-single');

  if ($degreeSingle.length > 0) {
    var prevPage = document.referrer,
        $breadcrumbSearch = $degreeSingle.find('#breadcrumb-search'),
        degreeSearchURL = $breadcrumbSearch.attr('href');

    if (prevPage !== '' && prevPage.indexOf(degreeSearchURL) > -1) {
      $breadcrumbSearch
        .on('click', function(e) {
          e.preventDefault();
          window.history.go(-1);
        });
    }
  }
}

var socialButtonTracking = function($) {
  $('.social a').click(function() {
    var link = $(this),
      target = link.attr('data-button-target'),
      network = '',
      socialAction = '';

    if (link.hasClass('share-facebook')) {
      network = 'Facebook';
      socialAction = 'Like';
    }
    else if (link.hasClass('share-twitter')) {
      network = 'Twitter';
      socialAction = 'Tweet';
    }
    else if (link.hasClass('share-googleplus')) {
      network = 'Google+';
      socialAction = 'Share';
    }
    else if (link.hasClass('share-linkedin')) {
      network = 'Linkedin';
      socialAction = 'Share';
    }
    else if (link.hasClass('share-email')) {
      network = 'Email';
      socialAction = 'Share';
    }

    if (typeof ga !== 'undefined' && network !== null && socialAction !== null) {
      ga('send', 'social', network, socialAction, window.location);
    }
  });
};


if (typeof jQuery != 'undefined'){
  jQuery(document).ready(function($) {
    Webcom.slideshow($);
    Webcom.analytics($);
    Webcom.chartbeat($);
    Webcom.handleExternalLinks($);
    Webcom.loadMoreSearchResults($);

    /* Theme Specific Code Here */
    Generic.defaultMenuSeparators($);
    Generic.removeExtraGformStyles($);
    Generic.mobileNavBar($);
    Generic.mobileSidebar($);
    addBodyClasses($);
    iosRotateAdjust($);
    centerpieceSlider($);
    centerpieceVidResize($);
    videoModalSet($);
    centerpieceSingleSlide($);
    removeNavSeparator($);
    styleGformButtons($);
    fixSubheaderHeight($);
    azIndex($);
    toggleAnnouncementFilters($);
    ieRoundedCornerThumbs($);
    ieStripedAcademicsResults($);
    Generic.PostTypeSearch($);
    phonebookStaffToggle($);
    removeAndroidModals($);
    gaEventTracking($);
    degreeSearch($);
    degreeProfile($);
    socialButtonTracking($);

    //devBootstrap($);

    statusAlertCheck($);
    setInterval(function() {statusAlertCheck($);}, 30000);
  });
}else{console.log('jQuery dependency failed to load');}
