var gulp = require('gulp'),
    sass = require('gulp-sass'),
    minifyCss = require('gulp-minify-css'),
    concatCss = require('gulp-concat-css'),
    bless = require('gulp-bless'),
    notify = require('gulp-notify'),
    bower = require('gulp-bower'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    jshint = require('gulp-jshint'),
    jshintStylish = require('jshint-stylish'),
    scsslint = require('gulp-scss-lint');
    // browserSync = require('browser-sync').create(),
    // reload = browserSync.reload;

var config = {
  sassPath: './static/scss',
  cssPath: './static/css',
  jsPath: './static/js',
  fontPath: './static/fonts',
  // phpPath: './',
  bowerDir: './static/components'
};


// Run Bower
gulp.task('bower', function() {
  return bower()
    .pipe(gulp.dest(config.bowerDir))
    .on('end', function() {

      // Add Glyphicons to fonts dir
      gulp.src(config.bowerDir + '/bootstrap-sass-official/assets/fonts/*/*')
        .pipe(gulp.dest(config.fontPath));

    });
});


// Compile scss files
gulp.task('css', function() {
  return gulp.src(config.sassPath + '/*.scss')
    .pipe(scsslint())
    .pipe(sass().on('error', sass.logError))
    .pipe(minifyCss({compatibility: 'ie8'}))
    .pipe(rename('style.min.css'))
    .pipe(bless())
    .pipe(gulp.dest(config.cssPath));
    // .pipe(browserSync.stream());
});


// Lint, concat and uglify js files.
gulp.task('js', function() {

  // Run jshint on all js files in jsPath (except already minified files.)
  return gulp.src([config.jsPath + '/*.js', '!' + config.jsPath + '/*.min.js'])
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(jshint.reporter('fail'))
    .on('end', function() {

      // Combine and uglify js files to create script.min.js.
      var minified = [
        config.bowerDir + '/bootstrap-sass-official/assets/javascripts/bootstrap.js',
        config.jsPath + '/generic-base.js',
        config.jsPath + '/script.js'
      ];

      gulp.src(minified)
        .pipe(concat('script.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.jsPath));

    });

});


// Rerun tasks when files change
gulp.task('watch', function() {
  // browserSync.init({
  //     proxy: {
  //       target: "localhost/wordpress/faculty"
  //     }
  // });
  // gulp.watch(config.jsPath + '/*.js', ['js']).on('change', reload);
  // gulp.watch(config.phpPath + '/*.php').on('change', reload);
  // gulp.watch(config.phpPath + '/*.php');

  gulp.watch(config.sassPath + '/*.scss', ['css']);
  gulp.watch(config.jsPath + '/*.js', ['js']);
});


// Default task
gulp.task('default', ['bower', 'css'/*, 'js'*/]);
