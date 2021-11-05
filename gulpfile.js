const fs = require('fs');
const browserSync = require('browser-sync').create();
const gulp = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const include = require('gulp-include');
const eslint = require('gulp-eslint-new');
const isFixed = require('gulp-eslint-if-fixed');
const babel = require('gulp-babel');
const rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass'));
const sassLint = require('gulp-sass-lint');
const uglify = require('gulp-uglify');
const merge = require('merge');
const critical = require('critical');
const fetch = require('node-fetch');
const cheerio = require('cheerio');


let config = {
  src: {
    scssPath: './src/scss',
    jsPath: './src/js'
  },
  dist: {
    cssPath: './static/css',
    jsPath: './static/js',
    fontPath: './static/fonts'
  },
  devPath: './dev',
  criticalCSSPath: './dev/critical-css',
  packagesPath: './node_modules',
  sync: false,
  syncTarget: 'http://localhost/wordpress/',
  criticalCSS: {
    sources: []
  }
};

/* eslint-disable no-sync */
if (fs.existsSync('./gulp-config.json')) {
  const overrides = JSON.parse(fs.readFileSync('./gulp-config.json'));
  config = merge(config, overrides);
}
/* eslint-enable no-sync */


//
// Helper functions
//

// Base SCSS linting function
function lintSCSS(src) {
  return gulp.src(src)
    .pipe(sassLint())
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError());
}

// Base SCSS compile function
function buildCSS(src, dest) {
  dest = dest || config.dist.cssPath;

  return gulp.src(src)
    .pipe(sass({
      includePaths: [config.src.scssPath, config.packagesPath]
    })
      .on('error', sass.logError))
    .pipe(cleanCSS())
    .pipe(autoprefixer({
      // Supported browsers added in package.json ("browserslist")
      cascade: false
    }))
    .pipe(rename({
      extname: '.min.css'
    }))
    .pipe(gulp.dest(dest));
}

// Base JS linting function (with eslint). Fixes problems in-place.
function lintJS(src, dest) {
  dest = dest || config.src.jsPath;

  return gulp.src(src)
    .pipe(eslint({
      fix: true
    }))
    .pipe(eslint.format())
    .pipe(isFixed(dest));
}

// Base JS compile function
function buildJS(src, dest) {
  dest = dest || config.dist.jsPath;

  return gulp.src(src)
    .pipe(include({
      includePaths: [config.packagesPath, config.src.jsPath]
    }))
    .on('error', console.log) // eslint-disable-line no-console
    .pipe(babel())
    .pipe(uglify())
    .pipe(rename({
      extname: '.min.js'
    }))
    .pipe(gulp.dest(dest));
}

// Returns source and destination paths for use by functions that
// process Dev assets.
function getDevWatchSrcDest(eventPath, srcExt) {
  let src;
  let dest;

  if (eventPath) {
    src = eventPath;
    dest = src.slice(0, (src.lastIndexOf('/') > -1 ? src.lastIndexOf('/') : src.lastIndexOf('\\')) + 1);
  } else {
    src = `${config.devPath}/**/*.${srcExt}`;
    dest = config.devPath;
  }

  return {
    src: src,
    dest: dest
  };
}

// BrowserSync reload function
function serverReload(done) {
  if (config.sync) {
    browserSync.reload();
  }
  done();
}

// BrowserSync serve function
function serverServe(done) {
  if (config.sync) {
    browserSync.init({
      proxy: {
        target: config.syncTarget
      }
    });
  }
  done();
}


//
// Installation of components/dependencies
//

// Copy Font Awesome files
gulp.task('move-components-fontawesome', () => {
  return gulp.src([`${config.packagesPath}/font-awesome/fonts/**/*`])
    .pipe(gulp.dest(`${config.dist.fontPath}/font-awesome`));
});

// Athena Framework web font processing
gulp.task('move-components-athena-fonts', () => {
  return gulp.src([`${config.packagesPath}/ucf-athena-framework/dist/fonts/**/*`])
    .pipe(gulp.dest(config.dist.fontPath));
});

// Run all component-related tasks
gulp.task('components', gulp.parallel(
  'move-components-fontawesome',
  'move-components-athena-fonts'
));


//
// CSS
//

// Lint all theme scss files
gulp.task('scss-lint-theme', () => {
  return lintSCSS(`${config.src.scssPath}/*.scss`);
});

// Compile theme stylesheet
gulp.task('scss-build-theme', () => {
  return buildCSS(`${config.src.scssPath}/style.scss`);
});

// All theme css-related tasks
gulp.task('css', gulp.series('scss-lint-theme', 'scss-build-theme'));


//
// Critical CSS generation
//
gulp.task('critical-css', (done) => {
  const sources = config.criticalCSS.sources;

  if (sources.length) {
    // Define a base set of arguments to pass to Critical
    // for each source in `sources`:
    const baseArgs = {
      inline: false,
      target: {
        css: `${config.criticalCSSPath}/critical.min.css`
      },
      // Viewport dimensions to determine above-the-fold content.
      // These values should be roughly based on available Athena
      // breakpoints, but factor in most common device dimensions and
      // aspect ratios logged via analytics for each breakpoint range.
      dimensions: [
        {
          height: 900,
          width: 575
        },
        {
          height: 1024,
          width: 767
        },
        {
          height: 1366,
          width: 991
        },
        {
          height: 800,
          width: 1199
        },
        {
          height: 1000,
          width: 1600
        }
      ],
      extract: false,
      ignore: {
        atrule: ['@font-face']
      }
    };

    // Retrieve each source, and pass each thru Critical:
    sources.forEach((source) => {
      const args = merge(baseArgs, source.args);
      args.target.css = `${config.criticalCSSPath}/${source.name}.min.css`;

      fetch(source.url)
        .catch((err) => console.error(err))
        .then((res) => res.text())
        .then((body) => {
          // Load document into Cheerio for easier DOM processing/traversal
          const $ = cheerio.load(body);

          // Remove existing inline critical CSS
          const $existingCriticalCSS = $('style#critical-css');
          if ($existingCriticalCSS.length) {
            $existingCriticalCSS.remove();
          }

          // Strip stylesheets whose hrefs are found in
          // source.ignoreStylesheets, because Critical
          // apparently can't do this on its own
          if (source.ignoreStylesheets) {
            source.ignoreStylesheets.forEach((ignoreRule) => {
              const $ignoreStylesheets = $(`link[rel="stylesheet"][href^="${ignoreRule}"]`);
              if ($ignoreStylesheets.length) {
                $ignoreStylesheets.remove();
              }
            });
          }

          // Remove preload and noscript tags in the head
          const $preload = $('head link[rel="preload"]');
          if ($preload.length) {
            $preload.remove();
          }
          const $noscript = $('head noscript');
          if ($noscript.length) {
            $noscript.remove();
          }

          // Revert async loading to non-async so that critical
          // can do its job. For the purpose of this script, just
          // set the media attr to `screen` for all async-loaded
          // styles.
          const $headStyles = $('head link[rel="stylesheet"]');
          if ($headStyles.length) {
            $headStyles.each((i, elem) => {
              const onload = $(elem).attr('onload');
              if (onload) {
                $(elem).attr('media', 'screen');
                $(elem).attr('onload', null);
              }
            });
          }

          body = $.html();

          args.html = body;
          critical.generate(args);
        });
    });
  }

  done();
});


//
// JavaScript
//

// Run eslint on js files in src.jsPath
gulp.task('es-lint-theme', () => {
  return lintJS([`${config.src.jsPath}/*.js`], config.src.jsPath);
});

// Concat and uglify js files through babel
gulp.task('js-build-theme', () => {
  return buildJS(`${config.src.jsPath}/script.js`, config.dist.jsPath);
});

gulp.task('js-build-degree-page', () => {
  return buildJS(`${config.src.jsPath}/degree-page.js`, config.dist.jsPath);
});

gulp.task('js-build-degree-search-typeahead', () => {
  return buildJS(`${config.src.jsPath}/degree-search-typeahead.js`, config.dist.jsPath);
});

gulp.task('js-build-faculty-search-typeahead', () => {
  return buildJS(`${config.src.jsPath}/faculty-search-typeahead.js`, config.dist.jsPath);
});

// All js-related tasks
gulp.task('js', gulp.series(
  'es-lint-theme',
  'js-build-theme',
  'js-build-degree-page',
  'js-build-degree-search-typeahead',
  'js-build-faculty-search-typeahead'
));


//
// Rerun tasks when files change
//
gulp.task('watch', (done) => {
  serverServe(done);

  // Dev Scss files
  gulp.watch(`${config.devPath}/**/*.scss`).on('change', (eventPath) => {
    const srcDest = getDevWatchSrcDest(eventPath, 'scss');
    const src = srcDest.src;
    const dest = srcDest.dest;

    lintSCSS(src);
    return buildCSS(src, dest);
  });

  // Dev js files
  gulp.watch([`${config.devPath}/**/*.js`, `!${config.devPath}/**/*.min.js`]).on('change', (eventPath) => {
    const srcDest = getDevWatchSrcDest(eventPath, 'js');
    const src = srcDest.src;
    const dest = srcDest.dest;

    lintJS(src, dest);
    return buildJS(src, dest);
  });

  // Theme scss files
  gulp.watch(`${config.src.scssPath}/**/*.scss`, gulp.series('css', serverReload));

  // Theme js files
  gulp.watch(`${config.src.jsPath}/**/*.js`, gulp.series('js', serverReload));

  // Theme PHP files
  gulp.watch('./**/*.php', gulp.series(serverReload));
});


//
// Default task
//
gulp.task('default', gulp.series('components', 'css', 'js'));
