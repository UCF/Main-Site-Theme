var gulp = require('gulp'),
    configLocal = require('./gulp-config.json'),
    merge = require('merge'),
    sass = require('gulp-sass'),
    minifyCss = require('gulp-minify-css'),
    bless = require('gulp-bless'),
    bower = require('gulp-bower'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    jshint = require('gulp-jshint'),
    jshintStylish = require('jshint-stylish'),
    scsslint = require('gulp-scss-lint'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync').create();

var gutil = require('gulp-util');

var configDefault = {
      devPath: './dev',
      scssPath: './src/scss',
      cssPath: './static/css',
      jsPath: './src/js',
      jsMinPath: './static/js',
      fontPath: './static/fonts',
      componentsPath: './src/components',
      sync: false,
      syncTarget: 'http://localhost/'
    },
    config = merge(configDefault, configLocal);

// Run Bower
gulp.task('bower', function() {
  bower()
    .pipe(gulp.dest(config.componentsPath))
    .on('end', function() {

      // Add Glyphicons to fonts dir
      gulp.src(config.componentsPath + '/bootstrap-sass-official/assets/fonts/*/*')
        .pipe(gulp.dest(config.fontPath));

      // Add Font Awesome fonts to fonts dir
      gulp.src(config.componentsPath + '/font-awesome/fonts/*')
        .pipe(gulp.dest(config.fontPath + '/font-awesome'));

      gulp.src(config.componentsPath + '/weather-icons/font/*')
        .pipe(gulp.dest(config.fontPath + '/weather-icons'));

    });
});

// Lint all scss files
gulp.task('scss-lint', function() {
  gulp.src(config.scssPath + '/*.scss')
    .pipe(scsslint({
      'maxBuffer': 400 * 1024  // default: 300 * 1024
    }));
});


// Lint dev scss files
gulp.task('scss-lint-dev', function() {
  gulp.src(config.devPath + '/**/*.scss')
    .pipe(scsslint({
      'maxBuffer': 400 * 1024  // default: 300 * 1024
    }));
});


// Compile + bless primary scss files
gulp.task('css-main', function() {
  gulp.src(config.scssPath + '/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(minifyCss({compatibility: 'ie8'}))
    .pipe(rename('style.min.css'))
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'ie >= 8'],
      cascade: false
    }))
    .pipe(bless())
    .pipe(gulp.dest(config.cssPath))
    .pipe(browserSync.stream());
});


// Compile + bless admin scss
gulp.task('css-admin', function() {
  gulp.src(config.scssPath + '/admin.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(minifyCss({compatibility: '*'}))
    .pipe(rename('admin.min.css'))
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'ie >= 8'],
      cascade: false
    }))
    .pipe(bless())
    .pipe(gulp.dest(config.cssPath))
    .pipe(browserSync.stream());
});


// Compile css in /dev/
gulp.task('css-dev-compile', function() {
  gulp.src(config.devPath + '/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(minifyCss({compatibility: '*'}))
    .pipe(rename({
      extname: '.min.css'
    }))
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'ie >= 8'],
      cascade: false
    }))
    .pipe(gulp.dest(config.devPath))
    .pipe(browserSync.stream());
});


// All css-related tasks
gulp.task('css', ['scss-lint', 'css-main', 'css-admin']);


// All css-related dev tasks
gulp.task('css-dev', ['scss-lint-dev', 'css-dev-compile']);


// Run jshint on all js files in jsPath (except already minified files.)
gulp.task('js-lint', function() {
  gulp.src([config.jsPath + '/*.js', '!' + config.jsPath + '/*.min.js'])
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(jshint.reporter('fail'));
});


// Concat and uglify primary js files.
gulp.task('js-main', function() {
  var minified = [
    config.componentsPath + '/bootstrap-sass-official/assets/javascripts/bootstrap.js',
    config.componentsPath + '/typeahead.js/dist/typeahead.bundle.js',
    config.componentsPath + '/bootstrap-tagsinput/dist/bootstrap-tagsinput.js',
    config.componentsPath + '/Chart.js/Chart.js',
    config.componentsPath + '/jfeed/build/dist/jquery.jfeed.js',
    config.componentsPath + '/jquery.cookie/jquery.cookie.js',
    config.componentsPath + '/jquery.cycle.all/index.js',
    config.jsPath + '/webcom-base.js',
    config.jsPath + '/script.js'
  ];

  gulp.src(minified)
    .pipe(concat('script.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(config.jsMinPath))
    .pipe(browserSync.stream());
});


// Uglify admin js
gulp.task('js-admin', function() {
  gulp.src(config.jsPath + '/admin.js')
    .pipe(concat('admin.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(config.jsMinPath))
    .pipe(browserSync.stream());
});


// All js-related tasks
gulp.task('js', ['js-lint', 'js-main', 'js-admin']);


// Rerun tasks when files change
gulp.task('watch', function() {
  if (config.sync) {
    browserSync.init({
        proxy: {
          target: config.syncTarget
        }
    });
  }

  gulp.watch(config.devPath + '/**/*.scss', ['css-dev']).on('change', browserSync.reload);
  gulp.watch(config.scssPath + '/**/*.scss', ['css']);
  gulp.watch(config.jsPath + '/**/*.js', ['js']).on('change', browserSync.reload);
  gulp.watch('**/*.php').on("change", browserSync.reload);
});


// Default task
gulp.task('default', ['bower', 'css', 'js']);
