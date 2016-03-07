var Generic = {};

// A fast and short piece of code you can use before deciding how to procede without .browser in jquery:
// http://pupunzi.open-lab.com/2013/01/16/jquery-1-9-is-out-and-browser-has-been-removed-a-fast-workaround
jQuery.browser = {};
jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());
jQuery.browser.safari = navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1;

// Helper function to get the actual window width in all browsers
// (Firefox and IE like to include the width of vertical scrollbars
// while Webkit doesn't, causing some inconsistencies.)
getRealWindowWidth = function($) {
  $('body').css('overflow', 'hidden');
  var realWidth = $(window).width();
  $('body').css('overflow', 'auto');

  return realWidth;
};


Generic.defaultMenuSeparators = function($) {
  // Because IE sucks, we're removing the last stray separator
  // on default navigation menus for browsers that don't
  // support the :last-child CSS property
  $('.menu li:last-child').addClass('last');
};

Generic.removeExtraGformStyles = function($) {
  // Since we're re-registering the Gravity Form stylesheet
  // manually and we can't dequeue the stylesheet GF adds
  // by default, we're removing the reference to the script if
  // it exists on the page (if CSS hasn't been turned off in GF settings.)
  $('link#gforms_css-css').remove();
};


/* jshint ignore:start */
/* Assign browser-specific body classes on page load */
addBodyClasses = function($) {
    var bodyClass = '';
    // Old IE:
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
            var ieversion = Number(RegExp.$1); // capture x.x portion and store as a number

            if (ieversion >= 10)     { bodyClass = 'ie ie10'; }
            else if (ieversion >= 9) { bodyClass = 'ie ie9'; }
            else if (ieversion >= 8) { bodyClass = 'ie ie8'; }
            else if (ieversion >= 7) { bodyClass = 'ie ie7'; }
    }
     // IE11+:
    else if (navigator.appName === 'Netscape' && !!navigator.userAgent.match(/Trident\/7.0/)) { bodyClass = 'ie ie11'; }
    // iOS:
    else if (navigator.userAgent.match(/iPhone/i)) { bodyClass = 'iphone'; }
    else if (navigator.userAgent.match(/iPad/i))   { bodyClass = 'ipad'; }
    else if (navigator.userAgent.match(/iPod/i))   { bodyClass = 'ipod'; }
    // Android:
    else if (navigator.userAgent.match(/Android/i)) { bodyClass = 'android'; }

    $('body').addClass(bodyClass);
};
/* jshint ignore:end */


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
};


/* Slider init */

centerpieceSlider = function($) {
  var slider = $('#centerpiece_slider');
  if(slider.length > 0) {

    // Get all duration values:
    var timeouts = [];
    $('#centerpiece_slider ul li').each(function() {
      duration = $(this).attr('data-duration');
      // Just in case it's not assigned through php somehow:
      if (duration === '') {
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
    var calculateTimeout = function(currElement, nextElement, opts, isForward) {
      var index = opts.currSlide;
      return timeouts[index] * 1000;
    };

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
};


/* Adjust slider video/embed size on window resize (for less than 767px) */

centerpieceVidResize = function($) {
  if ($('#centerpiece_slider').length > 0) {
    var addDimensions = function() {
      var parentw = $('#centerpiece_slider').parent('.col-md-12').width();
      if (getRealWindowWidth($) <= 767) {
        $('li.centerpiece_single .centerpiece_single_vid_hidden, li.centerpiece_single object, li.centerpiece_single iframe, li.centerpiece_single embed')
          .css({'height' : parentw * 0.36 +'px'});
      }
      else if (getRealWindowWidth($) > 767) {
        $('li.centerpiece_single .centerpiece_single_vid_hidden, li.centerpiece_single object, li.centerpiece_single iframe, li.centerpiece_single embed')
          .css({'height' : ''});
      }
    };
    if ( $('body').hasClass('ie7') === false && $('body').hasClass('ie8') === false ) { /* Don't resize in IE8 or older */
      addDimensions();
      $(window).resize(function() {
        addDimensions();
      });
    }
  }
};


/* Set/Unset iframe source on video modal open/close */
videoModalSet = function($) {
  if ($('.video-modal').length > 0) {
    $('.video-modal').on('show.bs.modal', function() {
      var $modal = $(this),
          modalID = $modal.attr('id'),
          $modalBody = $modal.find('.modal-body'),
          src = $modalBody.attr('data-src');

      if ($modal.find('iframe').length < 1) {
        $modalBody.html('<iframe class="modal-video-player" type="text/html" width="640" height="390" src="'+ src +'" frameborder="0">');
      }
    });

    $('.video-modal').on('hide.bs.modal', function() {
      $(this).find('iframe').remove();
    });
  }
};


/* Hide the centerpiece placeholder for single-slide centerpieces
 so that the slide displays properly */
centerpieceSingleSlide = function($) {
  if ( $('#centerpiece_slider > ul li').length < 2 ) {
    $('#centerpiece_slider > ul > img, #centerpiece_control').hide();
  }
};


/* Remove last dot separator between nav menu links: */
removeNavSeparator = function($) {
  //var navcount = $('ul#header-menu li').length - 1;
  $('ul#header-menu li.last').prev('li').addClass('no_nav_separator');
};


/* Add Bootstrap button styles for GravityForm submit buttons */
styleGformButtons = function($) {
  $('.gform_button').addClass('btn btn-default');
  $(document).bind('gform_post_render', function(){
    // Handle buttons generated with ajax
      $('.gform_button').addClass('btn btn-default');
  });
};


/* Call A-Z Index Scrollspy, organize post type search */
azIndex = function($) {
  if ($('#azindex').length > 0) {

    // Post type search customizations
    $('.post-type-search-header').prepend($('#azIndexList'));

    $('.post-type-search-alpha h3').each(function() {
      $(this)
        .parent('div').prepend('<div class="az-jumpto-anchor" id="az-' + $(this).text().toLowerCase() + '" />')
        .children('h3').after('<span class="backtotop"><span class="glyphicon glyphicon-arrow-up"></span> <a href="#top">Back to Top</a></span>');
    });

    // Activate Scrollspy
    $('body').attr({'data-spy' : 'scroll', 'data-offset' : 80, 'data-target' : '#azIndexList'});
    $('#azIndexList').scrollspy();

    if (jQuery.browser.safari) {
      $('#azIndexList').attr('data-spy', '');
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
      if ($(this).siblings('ul').children().length < 1) {
        var href = '#' + $(this).attr('id');
        $('#azIndexList .nav li a[href="'+ href +'"]').addClass('disabled');
      }
    });
    $('#azIndexList .nav li a.disabled').click(function(e) {
      e.preventDefault();
    });
  }
};


/* Show/hide announcement filter dropdowns */
var toggleAnnouncementFilters = function($) {
  var audienceBtn = $('#filter_audience'),
    keywordBtn = $('#filter_keyword'),
    timeBtn = $('#filter_time');

  // reset field values to default any time a new filter is selected
  var resetVals = function() {
    if ($('#filter_audience_wrap').hasClass('active_filter') === false) {
      $('#filter_audience_wrap select option:selected').val("all");
    }
    if ($('#filter_keyword_wrap').hasClass('active_filter') === false) {
      $(this).children('input').val("");
    }
    if ($('#filter_time_wrap').hasClass('active_filter') === false) {
      $('#filter_time_wrap select option:selected').val("thisweek");
    }
  };

  // on load
  if (audienceBtn.parent().hasClass('active')) {
    $('#filter_audience_wrap').show().addClass('active_filter');
  }
  else if (keywordBtn.parent().hasClass('active')) {
    $('#filter_keyword_wrap').show().addClass('active_filter');
  }
  else if (timeBtn.parent().hasClass('active')) {
    $('#filter_time_wrap').show().addClass('active_filter');
  }
  resetVals();

  // on click
  $(audienceBtn).change(function() {
    $('.active_filter').removeClass('active_filter').hide();
    $('#filter_audience_wrap').fadeIn().addClass('active_filter');
    resetVals();
  });

  $(keywordBtn).change(function() {
    $('.active_filter').removeClass('active_filter').hide();
    $('#filter_keyword_wrap').fadeIn().addClass('active_filter');
    resetVals();
  });

  $(timeBtn).change(function() {
    $('.active_filter').removeClass('active_filter').hide();
    $('#filter_time_wrap').fadeIn().addClass('active_filter');
    resetVals();
  });
};


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
};


/* IE 7-8 fix for Academics Search striped results */
ieStripedAcademicsResults = function($) {
  if ($('#academics-search').length > 0) {
    if ( $('body').hasClass('ie7') || $('body').hasClass('ie8') ) {
      $('.results-list .program:nth-child(2n+1)').css('background-color', '#eee');
    }
  }
};



Generic.PostTypeSearch = function($) {
  $('.post-type-search')
    .each(function(post_type_search_index, post_type_search) {
      var $post_type_search = $(post_type_search),
        form             = $post_type_search.find('.post-type-search-form'),
        field            = form.find('input[type="text"]'),
        working          = form.find('.working'),
        results          = $post_type_search.find('.post-type-search-results'),
        by_term          = $post_type_search.find('.post-type-search-term'),
        by_alpha         = $post_type_search.find('.post-type-search-alpha'),
        sorting          = $post_type_search.find('.post-type-search-sorting'),
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
      if(typeof post_type_search_data === 'undefined') { // Search data missing
        return false;
      }

      search_data_set = post_type_search_data.data;
      column_count    = post_type_search_data.column_count;
      column_width    = post_type_search_data.column_width;

      if(column_count === 0 || column_width === '') { // Invalid dimensions
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
        });
      field
        .keyup(function() {
          // Use a timer to determine when the user is done typing
          if(typing_timer !== null) { clearTimeout(typing_timer); }
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
            if(term.toLowerCase().indexOf(search_term.toLowerCase()) !== -1) {
              matches.push(post_id);
              return false;
            }
          });
        });
        if(matches.length === 0) {
          display_search_message('No results were found.');
        } else {

          // Copy the associated elements
          $.each(matches, function(match_index, post_id) {

            var element     = by_term.find('li[data-post-id="' + post_id + '"]:eq(0)'),
              post_id_int = parseInt(post_id, 10);
            post_id_sum += post_id_int;
            if(element.length === 1) {
              elements.push(element.clone());
            }
          });

          if(elements.length === 0) {
            display_search_message('No results were found.');
          } else {

            // Are the results the same as last time?
            if(post_id_sum !== prev_post_id_sum) {
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

                $.each(column_elements, function(element_index, element) {
                  column_list.append($(element));
                });
                results.find('div[class="row"]').append(column_wrap);
              });
              results.show();
            }
          }
        }
      }
    });
};


var phonebookStaffToggle = function($) {
  $('#phonebook-search-results a.toggle').click(function() {
    $(this)
      .children('span').toggleClass('glyphiicon-plus glyphicon-minus').end()
      .next().fadeToggle();
  });
};


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
      var href = '';

      // Check for videos whose URLs are contained in the data-src attr
      if ($(modalID).find('[data-src^="http"]').length > 0) {
        href  = $(modalID).find('[data-src^="http"]').attr('data-src');
      }
      // Otherwise, try to find an element with a src value and grab its URL
      else {
        href  = $(modalID).find('[src^="http"]').attr('src');
      }

      if (href) {
        modalLink.attr({ 'href' : href, 'data-toggle' : '', 'target' : '_blank' });
      }
    });
  }
};


/* Dev Bootstrap Element Testing-- this should not be running in prod!! */
var devBootstrap = function($) {
  $('#bootstrap-testing-tooltips').tooltip({
    selector: "a[rel=tooltip]"
  });
  $('#bootstrap-testing-popovers').popover({
    trigger: "hover",
    selector: "a[rel=popover]"
  });
};


/* Bootstrap Dropdown fixes for mobile devices */
// Fixes onclick event for mobile devices
$(document).on('touchstart.dropdown', '.dropdown-menu', function(e) { e.stopPropagation(); });


/*
 * Check the status site RSS feeds periodically and display an alert if necessary.
 */
var statusAlertCheck = function ($) {
  var $statusAlert = $('.status-alert[id!=status-alert-template]');

  function errorHandler() {
      $statusAlert.remove();
      $(document).trigger('ucfalert.removed');
  }

  function successHandler(feed) {
      var visible_alert = null,
        $newest = $($(feed).find('item')[0]),
        newest = {
          id: $newest.find('postID').text(),
          title: $newest.find('title').text(),
          description: $newest.find('description').text(),
          type: $newest.find('alertType').text()
      };

      if (newest) {
        var $existing_alert = $('.status-alert[data-alert-id="' + newest.id + '"]');
        visible_alert = newest.id;
        // Remove 'more info at...' from description
        newest.description = newest.description.replace('More info at www.ucf.edu','');

        // Remove old alerts that no longer appear in the feed
        if( (visible_alert === null) || (visible_alert !== $statusAlert.attr('data-alert-id')) ) {
          $statusAlert.remove();
          $(document).trigger('ucfalert.removed');
        }

        // Check to see if this alert already exists
        if($existing_alert.length > 0) {
          // Check the content and update if necessary.
          // This will simply fail if the alert has already been closed
          // by the user (alert element has been removed from the DOM)
          var existing_title = $existing_alert.find('.title'),
            existing_content = $existing_alert.find('.content'),
            existing_icon = $existing_alert.find('.alert-icon'),
            existing_type = $existing_alert.find('.alert'),
            contentChanged = false;

          if(existing_title.text() !== newest.title) {
            existing_title.text(newest.title);
            contentChanged = true;
          }
          if(existing_content.text() !== newest.description) {
            existing_content.text(newest.description);
            contentChanged = true;
          }
          if(existing_type.hasClass(newest.type) === false) {
            switch (newest.type) {
              case 'alert':
              case 'weather':
              case 'general':
              case 'police':
                existing_type.attr('class', 'alert alert-danger alert-block');
                break;
              case 'message':
                existing_type.attr('class', 'alert alert-info alert-block');
                break;
            }
            contentChanged = true;
            contentChanged = true;
          }

          if(existing_icon.hasClass(newest.type) === false) {
            existing_icon.attr('class','alert-icon ' + newest.type);
            contentChanged = true;
          }

          if (contentChanged) {
            $(document).trigger('ucfalert.changed');
          }

        } else {
          // Make sure this alert hasn't been closed by the user already
          if ($.cookie('ucf_alert_display_' + newest.id) !== 'hide') {
            // Create a new alert if an existing one isn't found

            var alert_markup = $('#status-alert-template').clone(true);
            alert_markup
              .attr('id', '')
              .attr('data-alert-id', newest.id);
            $('#header-nav-wrap').before(alert_markup);


            var $markup = $('.status-alert[data-alert-id="' + newest.id + '"]');
            $markup.find('.title').text(newest.title).end()
              .find('.content').text(newest.description).end()
              .find('.more-information').text('Click Here for More Information').end()
              .find('.alert-icon').attr('class', 'alert-icon ' + newest.type);

            switch(newest.type) {
              case 'alert':
              case 'weather':
              case 'general':
              case 'police':
                $markup.find('.alert').attr('class', 'alert alert-danger alert-block');
                break;
              case 'message':
                $markup.find('.alert').attr('class', 'alert alert-info alert-block');
                $markup.find('.content, .alert-icon').hide();
                $markup.find('.alert-icon-wrap').hide();
                $markup.find('.alert-inner-wrap').attr('class', 'col-md-12 col-sm-12 alert-inner-wrap');
                break;
            }

            $(document).trigger('ucfalert.added');
          }
        }
      }
      else {
        // If the feed is empty (all-clear), hide the currently visible
        // alert, if it exists
        if ($statusAlert.length > 0) {
          $statusAlert.remove();
          $(document).trigger('ucfalert.removed');
        }
      }

      // Set cookies for every iteration of new alerts, if necessary
      statusAlertCookieSet($);
  }

  $.ajax({
        url: ALERT_RSS_URL,
        cache: false,
        dataType: "xml",
        success: successHandler,
        error: errorHandler
  });
};


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
      .find('.alert').hide().end()
      .css('margin-top', '0')
      .addClass('hidden-by-user');
    $(document).trigger('ucfalert.removed');
  });
};


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
};


/**
 * Handles the Degree search page
 **/
var degreeSearch = function ($) {
  var $academicsSearch,
    $degreeSearchResultsContainer,
    $degreeSearchAgainContainer,
    $sidebarLeft,
    $degreeSearchContent,
    ajaxURL,
    pageCount,
    headerHeight;

  function initAutoComplete() {
    /**
     * Bootstrap typeahead overrides, for general fixes and usability improvements
     **/
    $.fn.typeahead.Constructor.prototype.blur = function () {
      // Workaround for bug in mouse item selection
      var that = this;
      setTimeout(function () { that.hide(); }, 250);
    };

    $.fn.typeahead.Constructor.prototype.select = function (e) {
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

    $.fn.typeahead.Constructor.prototype.keyup = function (e) {
      switch (e.keyCode) {
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
    };

    $.fn.typeahead.Constructor.prototype.keydown = function (e) {
      this.suppressKeyPressRepeat = ~$.inArray(e.keyCode, [40, 38, 9, 27]); // remove 13 (enter)
      this.move(e);
    };

    $.fn.typeahead.Constructor.prototype.move = function (e) {
      switch (e.keyCode) {
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
    };

    $.fn.typeahead.Constructor.prototype.render = function (items) {
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
      source: function (query, process) {
        return searchSuggestions; // searchSuggestions defined in page-degree-search.php
      },
      updater: function (item) {
        $(this).val(item);
        return item;
      }
    });

    // Dynamic content reloading for browsers that support history api
    if (supportsHistory()) {
      var timer = null;

      $academicsSearch.on('submit', function (e) {
        e.preventDefault();
        loadDegreeSearchResults();
      });

      $searchQuery
        .on({
        'keyup': function (e) {
          if (e.keyCode === 13) {
            // Don't trigger a submit here (prevent loadDegreeSearchResults from firing twice)
            e.preventDefault();
          }
          else if ($.inArray(e.keyCode, [9, 16, 37, 38, 39, 40]) === -1) {
            if (timer) {
              clearTimeout(timer);
            }
            timer = setTimeout(function () {
              loadDegreeSearchResults();
            }, 300);
          }
        },
        'mouseup': function (e) {
          // Force detection of IE10+ 'x' button click on input field.
          // If the input value is cleared by button press, simulate a keyup
          // event, which will trigger loadDegreeSearchResults() (see above).
          var oldValue = $searchQuery.val();

          if (oldValue === '') {
            return;
          }

          setTimeout(function () {
            var newValue = $searchQuery.val();
            if (newValue === '') {
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
    window.setTimeout(function () {
      $loaderScreen.addClass('hidden');

      $degreeSearchResultsContainer
        .html(data.markup)
        .append($loaderScreen);

      $academicsSearch
        .find('.degree-result-count')
        .html(data.count);

      $degreeSearchAgainContainer.html(data.searchagain);

      updateDocumentHead(data);

      // Only scroll to results if the user's focus is not on the search field
      // (if a filter/sort option was clicked, and the user is *not* typing a
      // search query). Makes searching on touch devices less of a pain.
      if (!$academicsSearch.find('#search-query').is(':focus')) {
        scrollToResults();
      }

      var assistiveText = $('<div>').html(data.count).find('.degree-result-phrase-phone, .reset-search').remove().end().text();
      wp.a11y.speak(assistiveText);
    }, 100);
  }

  function degreeSearchFailureHandler(data) {
    $loaderScreen = $academicsSearch.find('#ajax-loading');

    // Make sure the spinner actually gets displayed
    // so the user knows the page changed
    window.setTimeout(function () {
      $loaderScreen.addClass('hidden');

      $degreeSearchResultsContainer
        .html('Error loading degree data.')
        .append($loaderScreen);

      updateDocumentHead(data);

      if (!$academicsSearch.find('#search-query').is(':focus')) {
        scrollToResults();
      }

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

  function loadDegreeSearchResults(isPaging, breakDefaultSearch) {
    var searchDefault = $academicsSearch.find('#search-default').val();
    if (breakDefaultSearch === true && parseInt(searchDefault, 10) === 1) {
      searchDefault = 0;
      $academicsSearch.find('#search-default').val(searchDefault);
    }
    else if (parseInt(searchDefault, 10) === 1) {
      // If Default Search is still enabled, make sure no filters are selected
      $academicsSearch.find('.program-type:checked').prop('checked', false);
      $academicsSearch.find('.college:checked').prop('checked', false);
    }

    if (supportsHistory()) {
      $academicsSearch.find('#ajax-loading').removeClass('hidden');

      var programType = [];
      $academicsSearch.find('.program-type:checked').each(function () {
        programType.push($(this).val());
      });

      var college = [];
      $academicsSearch.find('.college:checked').each(function () {
        college.push($(this).val());
      });

      var offset;
      if (isPaging === true) {
        offset = $academicsSearch.find('#offset').val();
      } else {
        offset = 0;
        $academicsSearch.find('#offset').val(0);
      }

      var params = {
        'search-query': encodeURIComponent($academicsSearch.find('#search-query').val()),
        'sort-by': $academicsSearch.find('.sort-by:checked').val(),
        'program-type': programType,
        'college': college,
        'default': 0, // force turn off default view any time content is ajaxed in
        'offset': offset,
        'search-default': searchDefault
      };
      var ajaxParams = $.extend({'action': 'degree_search'}, params); // Copy without reference

      $.ajax({
        url: ajaxURL,
        type: 'GET',
        // cache: false,
        data: ajaxParams,
        dataType: 'json'
      })
        .done(function (data) {
        trackFilterForGoogle(programType, college, $academicsSearch.find('#search-query').val());
        degreeSearchSuccessHandler(data);
        toggleDegreeFilterClear(params);
      })
        .fail(function (data) {
        degreeSearchFailureHandler(data);
        toggleDegreeFilterClear(params);
      });
    }
    else {
      $academicsSearch.submit();
    }
  }

  var filterChangeEventHandler = function() {
    loadDegreeSearchResults(false, true);
  };

  function trackFilterForGoogle(programTypes, colleges, searchTerm) {
    if (typeof ga !== 'undefined') {

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
      .find('.checkbox input, .radio input')
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
    loadDegreeSearchResults(false, true);

    $(document).off('click', closeMenuOnTargetClick);

    // Filter checkbox changes were turned off when the mobile sidebar was activated.
    // Reactivate the event when the mobile sidebar is closed (to allow .close btns in
    // .degree-result-count to trigger loadDegreeSearchResults() on click).
    $academicsSearch.on('change', '.program-type, .college, .location, .sort-by', filterChangeEventHandler);
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
    $academicsSearch.off('change', '.program-type, .college, .location, .sort-by', filterChangeEventHandler);

    // resize the panel to be full screen and align it
    $('html, body').animate({
      scrollTop: $filterBtn.offset().top
    }, 200);

    // Position sidebar
    $sidebarLeft
      .css({
      'max-height': $(window).height() - 40,
      'top': $filterBtn.offset().top + ($filterBtn.outerHeight() / 2)
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

  function resizeSidebarContent() {
    $sidebarLeft.attr('style', ''); // clear existing overrides

    // Make sidebar scrollable on small screens
    var windowHeight = $(window).height();
    if ($(window).width() > 767) {
      if ($sidebarLeft.outerHeight() > windowHeight) {
        $sidebarLeft.css({
          'max-height': windowHeight,
          'overflow-y': 'scroll'
        });
      } else {
        $sidebarLeft.css({
          'max-height': '100%',
          'overflow-y': 'auto'
        });
      }
    }
    else {
      $sidebarLeft.css({
        'max-height': '0',
        'overflow-y': 'scroll'
      });
    }
  }

  function initSidebarAffix() {
    resizeSidebarContent();

    // Make sure headerHeight is up to date
    setHeaderHeight();

    if ($(window).width() > 767 && $sidebarLeft.outerHeight() < $degreeSearchContent.outerHeight()) {
      $sidebarLeft
        .affix({
        offset: {
          top: headerHeight,
          bottom: $('#footer').outerHeight() + 100
        }
      })
        .on('affixed.bs.affix affixed-bottom.bs.affix', function () {
          $degreeSearchContent.addClass('col-md-offset-3 col-sm-offset-3');
        })
        .on('affixed-top.bs.affix', function () {
          $degreeSearchContent.removeClass('col-md-offset-3 col-sm-offset-3');
        });
    }
    else {
      $degreeSearchContent.removeClass('col-md-offset-3 col-sm-offset-3');
      $(window).off('.affix');
      $sidebarLeft
        .removeClass('affix affix-top affix-bottom')
        .removeData('bs.affix');
    }
  }

  function resetSidebarAffix() {
    // Make sure headerHeight is up to date
    setHeaderHeight();

    if ($(window).width() > 767 && $sidebarLeft.outerHeight() < $degreeSearchContent.outerHeight()) {
      if ($sidebarLeft.data('bs.affix')) {
        $sidebarLeft.data('bs.affix').options.offset.top = headerHeight;
        $sidebarLeft.data('bs.affix').options.offset.bottom = $('#footer').outerHeight() + 100;
      }
      else {
        initSidebarAffix();
      }
    }
    else {
      initSidebarAffix();
    }
  }

  function resultPhraseClickHandler(e) {
    var $target = $(e.target),
      $filterCheckbox = $('.' + $target.attr('data-filter-class') + '[value="' + $target.attr('data-filter-value') + '"]');

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

  function pagerClickHandler(e) {
    e.preventDefault();
    var $offset = $academicsSearch.find('#offset'),
        offsetValue  = parseInt($academicsSearch.find('#offset').val());
    if ($(e.target).parent().hasClass('next')) {
      $offset.val(offsetValue + pageCount);
    } else {
      $offset.val(offsetValue - pageCount);
    }

    loadDegreeSearchResults(true, true); // force default search view off
    resetSidebarAffix();
  }

  function degreeFilterClearHandler(e) {
    e.preventDefault();

    var $clearLink = $(e.target),
        $filterCheckboxes = $sidebarLeft.find('.' + $clearLink.attr('data-filter-name'));

    if ($filterCheckboxes) {
      $filterCheckboxes.each(function(index) {
        $(this)
          .prop('checked', false)
          .removeAttr('checked');

        // Only trigger change once
        if (index === $filterCheckboxes.length - 1) {
          $(this).trigger('change');
        }
      });
    }

    $clearLink.addClass('hidden');
  }

  function toggleDegreeFilterClear(params) {
    var $clearLinks = $sidebarLeft.find('.degree-filter-clear');

    $clearLinks.each(function() {
      var $clearLink = $(this),
          filterName = $clearLink.attr('data-filter-name'),
          $filterCheckboxes = $sidebarLeft.find('.' + filterName),
          hasChecked = false,
          paramsForFilter = $.extend({}, params); // clone + modify per filter

      $filterCheckboxes.each(function() {
        if ($(this).is(':checked')) {
          hasChecked = true;
          return false;
        }
      });

      if (hasChecked) {
        $clearLink.removeClass('hidden');
      }
      else {
        $clearLink.addClass('hidden');
      }

      paramsForFilter[filterName] = [];
      $clearLink.attr('href', $clearLink.attr('data-url-base') + '?' + $.param(paramsForFilter));
    });
  }

  function scrollToResults() {
    // Scroll past top page content if the page loaded with GET params set
    // (assume the user submitted a search or something and has already seen
    // the page content); else, scroll to the very top of the page (prevents
    // affixing bugs)
    if (window.location.search !== '') {
      $('html, body').animate({
        scrollTop: $academicsSearch.find('#search-query').offset().top - 20
      }, 200, resetSidebarAffix);
    }
    else {
      $(document).scrollTop(0);
      resetSidebarAffix();
    }
  }

  function setHeaderHeight() {
    // The extra 70 pixels is for the ucf header that loads in late and some other unaccounted for pixels.
    headerHeight = 70 + $('#header-nav-wrap').outerHeight(true) + $('#page-title').outerHeight(true) + $('#degree-search-top').outerHeight(true);
    $alert = $('.status-alert:not(#status-alert-template)');
    if ($alert.length && !$alert.hasClass('hidden-by-user')) {
      headerHeight = headerHeight + $alert.outerHeight(true);
    }
  }

  function setupEventHandlers() {
    $(window).on('load', function () {
      initSidebarAffix();
      scrollToResults();
    });

    $(window).on('resize', function () {
      resizeSidebarContent();
      resetSidebarAffix();
      // Force turn off mobile filter btn and sidebar
      $sidebarLeft.removeClass('active');
      $academicsSearch.find('#mobile-filter').removeClass('active');
    });

    $(window).on('load resize', function () {
      if (!$academicsSearch.find('#mobile-filter').is(':visible')) {
        $(document).off('click', closeMenuOnTargetClick);
      }
    });

    // Account for DOM changes when a status alert is populated/deleted
    $(document).on('ucfalert.removed ucfalert.added ucfalert.changed', resetSidebarAffix);

    $academicsSearch.on('change', '.program-type, .college, .location, .sort-by', filterChangeEventHandler);
    $academicsSearch.on('click', '.degree-result-count .close', resultPhraseClickHandler);
    $academicsSearch.on('click', '.search-again-link', searchAgainClickHandler);
    $academicsSearch.on('click', '.pager a', pagerClickHandler);
    $academicsSearch.on('click', '.degree-filter-clear', degreeFilterClearHandler);
    $academicsSearch.on('click', '.seo-li', function (e) {
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
    pageCount = parseInt($academicsSearch.find('#offset').attr('data-offset-count'));

    if ($academicsSearch.length > 0) {
      $degreeSearchResultsContainer = $academicsSearch.find('.degree-search-results-container');
      $sidebarLeft = $academicsSearch.find('#degree-search-sidebar');
      $degreeSearchContent = $academicsSearch.find('#degree-search-content');
      $degreeSearchAgainContainer = $academicsSearch.find('.degree-search-again-container');
      ajaxURL = $academicsSearch.attr('data-ajax-url');

      setHeaderHeight();

      setupEventHandlers();
    }
  }

  $(initPage);
};


/**
 * Scripts for single degree profile templates
 **/
var degreeProfile = function ($) {
  var $degreeSingle = $('#degree-single');

  if ($degreeSingle.length > 0) {
    var prevPage = document.referrer,
      $breadcrumbSearch = $degreeSingle.find('#breadcrumb-search'),
      degreeSearchURL = $breadcrumbSearch.attr('href');

    if (prevPage !== '' && prevPage.indexOf(degreeSearchURL) > -1) {
      $breadcrumbSearch
        .on('click', function (e) {
        e.preventDefault();
        window.history.go(-1);
      });
    }
  }
};

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


var ariaSilenceNoscripts = function($) {
  // Prevent text in <noscript> tags from being read aloud by screenreaders.
  $('noscript').attr('aria-hidden', 'true');
};


var announcementKeywordAutocomplete = function($) {
  if ($('.announcement-tag-autocomplete input').length) {
    $('.announcement-tag-autocomplete input').tagsinput();
  }
};

var customChart = function($) {
  if ($('.custom-chart').length) {
    $.each($('.custom-chart'), function() {
        var $chart = $(this),
          type = $chart.attr('data-chart-type'),
          jsonPath = $chart.attr('data-chart-data'),
          optionsPath = $chart.attr('data-chart-options'),
          $canvas = $('<canvas></canvas>'),
          ctx = $canvas.get(0).getContext('2d'),
          data = {};

      // Set default options
      var options = {
        responsive: true,
        scaleShowGridLines: false,
        pointHitDetectionRadius: 5
      };

      $chart.append($canvas);

      $.getJSON(jsonPath, function(json) {
        data = json;
        $.getJSON(optionsPath, function(json) {
          $.extend(options, options, json);
        }).complete(function () {
            var $chartLegend = $('.chart-legend-' + $chart.attr('id') + '');
            switch (type.toLowerCase()) {
                case 'bar':
                    var barChart = new Chart(ctx).Bar(data, options);
                    if ($chartLegend.length) {
                        $chartLegend.html(barChart.generateLegend());
                    }
                    break;
                case 'line':
                    var lineChart = new Chart(ctx).Line(data, options);
                    if ($chartLegend.length) {
                        $chartLegend.html(lineChart.generateLegend());
                    }
                    break;
                case 'radar':
                    var radarChart = new Chart(ctx).Radar(data, options);
                    if ($chartLegend.length) {
                        $chartLegend.html(radarChart.generateLegend());
                    }
                    break;
                case 'polar-area':
                    var polarAreaChart = new Chart(ctx).PolarArea(data, options);
                    if ($chartLegend.length) {
                        $chartLegend.html(polarAreaChart.generateLegend());
                    }
                    break;
                case 'pie':
                    var pieChart = new Chart(ctx).Pie(data, options);
                    if ($chartLegend.length) {
                        $chartLegend.html(pieChart.generateLegend());
                    }
                    break;
                case 'doughnut':
                    var doughnutChart = new Chart(ctx).Doughnut(data, options);
                    if ($chartLegend.length) {
                        $chartLegend.html(doughnutChart.generateLegend());
                    }
                    break;
            default:
              break;
          }
        });
      });
    });
  }
};

var mediaTemplateVideo = function($) {
  var $videoPlaceholder = $('#header-video-placeholder');

  // Generate a video tag for the header background
  function createHeaderVideo() {
    var mp4 = $videoPlaceholder.attr('data-mp4'),
      webm = $videoPlaceholder.attr('data-webm'),
      ogg = $videoPlaceholder.attr('data-ogg'),
      video = '<video autoplay muted loop>';

    // Stop now/display nothing if no video sources are provided
    if (!mp4 && !webm && !ogg) {
      return;
    }

    // Concatenate html strings instead of using append--IE9 has issues
    // with this for whatever reason
    if (mp4) {
      video += '<source src="'+ mp4 +'" type="video/mp4">';
    }
    if (webm) {
      video += '<source src="'+ webm +'" type="video/webm">';
    }
    if (ogg) {
      video += '<source src="'+ ogg +'" type="video/ogg">';
    }

    video += '</video>';

    $video = $(video);
    $videoPlaceholder.replaceWith($video);
  }

  // Test if video auto plays
  function autoPlayOrBust() {

    var mp4 = 'data:video/mp4;base64,AAAAFGZ0eXBNU05WAAACAE1TTlYAAAOUbW9vdgAAAGxtdmhkAAAAAM9ghv7PYIb+AAACWAAACu8AAQAAAQAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAnh0cmFrAAAAXHRraGQAAAAHz2CG/s9ghv4AAAABAAAAAAAACu8AAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAFAAAAA4AAAAAAHgbWRpYQAAACBtZGhkAAAAAM9ghv7PYIb+AAALuAAANq8AAAAAAAAAIWhkbHIAAAAAbWhscnZpZGVBVlMgAAAAAAABAB4AAAABl21pbmYAAAAUdm1oZAAAAAAAAAAAAAAAAAAAACRkaW5mAAAAHGRyZWYAAAAAAAAAAQAAAAx1cmwgAAAAAQAAAVdzdGJsAAAAp3N0c2QAAAAAAAAAAQAAAJdhdmMxAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAFAAOABIAAAASAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGP//AAAAEmNvbHJuY2xjAAEAAQABAAAAL2F2Y0MBTUAz/+EAGGdNQDOadCk/LgIgAAADACAAAAMA0eMGVAEABGjuPIAAAAAYc3R0cwAAAAAAAAABAAAADgAAA+gAAAAUc3RzcwAAAAAAAAABAAAAAQAAABxzdHNjAAAAAAAAAAEAAAABAAAADgAAAAEAAABMc3RzegAAAAAAAAAAAAAADgAAAE8AAAAOAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA4AAAAOAAAAFHN0Y28AAAAAAAAAAQAAA7AAAAA0dXVpZFVTTVQh0k/Ou4hpXPrJx0AAAAAcTVREVAABABIAAAAKVcQAAAAAAAEAAAAAAAAAqHV1aWRVU01UIdJPzruIaVz6ycdAAAAAkE1URFQABAAMAAAAC1XEAAACHAAeAAAABBXHAAEAQQBWAFMAIABNAGUAZABpAGEAAAAqAAAAASoOAAEAZABlAHQAZQBjAHQAXwBhAHUAdABvAHAAbABhAHkAAAAyAAAAA1XEAAEAMgAwADAANQBtAGUALwAwADcALwAwADYAMAA2ACAAMwA6ADUAOgAwAAABA21kYXQAAAAYZ01AM5p0KT8uAiAAAAMAIAAAAwDR4wZUAAAABGjuPIAAAAAnZYiAIAAR//eBLT+oL1eA2Nlb/edvwWZflzEVLlhlXtJvSAEGRA3ZAAAACkGaAQCyJ/8AFBAAAAAJQZoCATP/AOmBAAAACUGaAwGz/wDpgAAAAAlBmgQCM/8A6YEAAAAJQZoFArP/AOmBAAAACUGaBgMz/wDpgQAAAAlBmgcDs/8A6YEAAAAJQZoIBDP/AOmAAAAACUGaCQSz/wDpgAAAAAlBmgoFM/8A6YEAAAAJQZoLBbP/AOmAAAAACkGaDAYyJ/8AFBAAAAAKQZoNBrIv/4cMeQ==',
      body = document.getElementsByTagName('body')[0];

    var v = document.createElement('video');
    v.src = mp4;
    v.autoplay = true;
    v.volume = 0;
    v.style.visibility = 'hidden';

    body.appendChild(v);

    // video.play() seems to be required for it to work,
    // despite the video having an autoplay attribute.
    v.play();

    // triggered if autoplay fails
    var removeVideoTimeout = setTimeout(function () {
      $(v).remove();
    }, 50);

    // triggered if autoplay works
    v.addEventListener('play', function () {
      clearTimeout(removeVideoTimeout);
      $(v).remove();
      createHeaderVideo();
    }, false);
  }

  if ($videoPlaceholder.length) {
    autoPlayOrBust();
  }
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
    addBodyClasses($);
    iosRotateAdjust($);
    centerpieceSlider($);
    centerpieceVidResize($);
    videoModalSet($);
    centerpieceSingleSlide($);
    removeNavSeparator($);
    styleGformButtons($);
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
    ariaSilenceNoscripts($);
    announcementKeywordAutocomplete($);
    customChart($);
    mediaTemplateVideo($);

    //devBootstrap($);

    statusAlertCheck($);
    setInterval(function() {statusAlertCheck($);}, 30000);
  });
} else {
  console.log('jQuery dependency failed to load');
}
