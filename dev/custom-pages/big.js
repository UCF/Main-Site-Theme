(function() {
  // Inview.js v1.1.2
  !function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){function i(){var b,c,d={height:f.innerHeight,width:f.innerWidth};return d.height||(b=e.compatMode,(b||!a.support.boxModel)&&(c="CSS1Compat"===b?g:e.body,d={height:c.clientHeight,width:c.clientWidth})),d}function j(){return{top:f.pageYOffset||g.scrollTop||e.body.scrollTop,left:f.pageXOffset||g.scrollLeft||e.body.scrollLeft}}function k(){if(b.length){var e=0,f=a.map(b,function(a){var b=a.data.selector,c=a.$element;return b?c.find(b):c});for(c=c||i(),d=d||j();e<b.length;e++)if(a.contains(g,f[e][0])){var h=a(f[e]),k={height:h[0].offsetHeight,width:h[0].offsetWidth},l=h.offset(),m=h.data("inview");if(!d||!c)return;l.top+k.height>d.top&&l.top<d.top+c.height&&l.left+k.width>d.left&&l.left<d.left+c.width?m||h.data("inview",!0).trigger("inview",[!0]):m&&h.data("inview",!1).trigger("inview",[!1])}}}var c,d,h,b=[],e=document,f=window,g=e.documentElement;a.event.special.inview={add:function(c){b.push({data:c,$element:a(this),element:this}),!h&&b.length&&(h=setInterval(k,250))},remove:function(a){for(var c=0;c<b.length;c++){var d=b[c];if(d.element===this&&d.data.guid===a.guid){b.splice(c,1);break}}b.length||(clearInterval(h),h=null)}},a(f).bind("scroll resize scrollstop",function(){c=d=null}),!g.addEventListener&&g.attachEvent&&g.attachEvent("onfocusin",function(){d=null})});


  // Basic check for CSS animation support
  // http://stackoverflow.com/questions/10888211/detect-support-for-transition-with-javascript
  function detectCSSFeature(featurename){
      var feature = false,
      domPrefixes = 'Webkit Moz ms O'.split(' '),
      elm = document.createElement('div'),
      featurenameCapital = null;

      featurename = featurename.toLowerCase();

      if( elm.style[featurename] ) { feature = true; }

      if( feature === false ) {
          featurenameCapital = featurename.charAt(0).toUpperCase() + featurename.substr(1);
          for( var i = 0; i < domPrefixes.length; i++ ) {
              if( elm.style[domPrefixes[i] + featurenameCapital ] !== undefined ) {
                feature = true;
                break;
              }
          }
      }
      return feature;
  }


  // Fly-in animations
  var hasAnimationSupport = detectCSSFeature('animation');

  if (hasAnimationSupport && $(window).width() > 767) {
    // List of all the available css3 animations (defined in big.css)
    var animations = [
      'fadeIn',
      'fadeInUp',
      'fadeInDown',
      'fadeInLeft',
      'fadeInRight',
      'fadeInUpBig',
      'fadeInDownBig',
      'fadeInLeftBig',
      'fadeInRightBig',
      'bounceIn',
      'bounceInUp',
      'bounceInDown',
      'bounceInLeft',
      'bounceInRight',
    ];

    $('.js-flyin')
      .css('visibility', 'hidden')
      .each(function() {
        var $item = $(this);

        $item
          .one('inview', function (event, visible) {
            if (visible) {
              // grab a random animation
              var randAnimation = animations[Math.floor(Math.random() * animations.length)];
              // animate the box somehow, then stop listening
              $item
                .css('visibility', 'visible')
                .addClass(randAnimation);
            }
      });
    });
  }
})();
