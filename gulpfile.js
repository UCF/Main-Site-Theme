var browserSync = require('browser-sync').create(),
    gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),
    include = require('gulp-include'),
    eslint = require('gulp-eslint'),
    isFixed = require('gulp-eslint-if-fixed'),
    babel = require('gulp-babel'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    scsslint = require('gulp-scss-lint'),
    uglify = require('gulp-uglify'),
    runSequence = require('run-sequence'),
    merge = require('merge');


var configLocal = require('./gulp-config.json'),
    configDefault = {
      src: {
        scssPath: './src/scss',
        jsPath:   './src/js'
      },
      dist: {
        cssPath:  './static/css',
        jsPath:   './static/js',
        fontPath: './static/fonts'
      },
      packagesPath: './node_modules',
      sync: false,
      syncTarget: 'http://localhost/'
    },
    config = merge(configDefault, configLocal);


//
// Installation of components/dependencies
//

// Copy Font Awesome files
gulp.task('move-components-fontawesome', function() {
  gulp.src(config.packagesPath + '/font-awesome/fonts/**/*')
   .pipe(gulp.dest(config.dist.fontPath + '/font-awesome'));
});

// Run all component-related tasks
gulp.task('components', [
  'move-components-fontawesome',
]);


//
// CSS
//

// Lint scss files
gulp.task('scss-lint', function() {
  return gulp.src(config.src.scssPath + '/*.scss')
    .pipe(scsslint({
      'maxBuffer': 400 * 1024  // default: 300 * 1024
    }));
});

// Compile scss files
function buildCSS(src, filename, dest) {
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
    .pipe(rename(filename))
    .pipe(gulp.dest(dest))
    .pipe(browserSync.stream());
}

gulp.task('scss-build-theme-css', function() {
  return buildCSS(config.src.scssPath + '/style.scss', 'style.min.css');
});

gulp.task('scss-build', ['scss-build-theme-css']);

// All css-related tasks
gulp.task('css', ['scss-lint', 'scss-build']);


//
// JavaScript
//

// Run eshint on js files in src.jsPath. Do not perform linting
// on vendor js files.
gulp.task('es-lint', function() {
  return gulp.src([config.src.jsPath + '/*.js'])
    .pipe(eslint({ fix: true }))
    .pipe(eslint.format())
    .pipe(isFixed(config.src.jsPath));
});

// Concat and uglify js files through babel
gulp.task('js-build', function() {
  return gulp.src(config.src.jsPath + '/script.js')
    .pipe(include({
      includePaths: [config.packagesPath, config.src.jsPath]
    }))
      .on('error', console.log)
    .pipe(babel())
    .pipe(uglify())
    .pipe(rename('script.min.js'))
    .pipe(gulp.dest(config.dist.jsPath));
});

// All js-related tasks
gulp.task('js', function() {
  runSequence('es-lint', 'js-build');
});


//
// Rerun tasks when files change
//
gulp.task('watch', function() {
  if (config.sync) {
    browserSync.init({
        proxy: {
          target: config.syncTarget
        }
    });
  }

  gulp.watch(config.src.scssPath + '/**/*.scss', ['css']);
  gulp.watch(config.src.jsPath + '/**/*.js', ['js']).on('change', browserSync.reload);
  gulp.watch('./**/*.php').on('change', browserSync.reload);
});


//
// Default task
//
gulp.task('default', function() {
  // Make sure 'components' completes before 'css' or 'js' are allowed to run
  runSequence('components', ['css', 'js']);
});
