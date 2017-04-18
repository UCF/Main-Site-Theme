var gulp         = require('gulp'),
    bower        = require('gulp-bower'),
    sass         = require('gulp-sass'),
    scsslint     = require('gulp-scss-lint'),
    cleanCss     = require('gulp-clean-css'),
    autoprefixer = require('gulp-autoprefixer'),
    rename       = require('gulp-rename');

var config = {
  bowerPath: './src/components',
  src: {
    scss: './src/scss',
    js: './src/js'
  },
  dist: {
    css: './static/css',
    js: './static/js'
  }
};

gulp.task('bower', function() {
  return bower()
    .pipe(gulp.dest(config.bowerPath))
    .on('finish', function() {
      gulp.src(config.bowerPath + '/Athena-Framework/dist/js/framework.min.js')
        .pipe(gulp.dest(config.dist.js));
    });
});

gulp.task('scsslint', function() {
  gulp.src(config.src.scss + '/**/*.scss')
    .pipe(scsslint());
});

gulp.task('scss', ['scsslint'], function() {
  gulp.src(config.src.scss + '/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(cleanCss({compatibility: 'ie8'}))
    .pipe(rename('style.min.css'))
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'ie >= 8'],
      cascade: false
    }))
    .pipe(gulp.dest(config.dist.css));
});

gulp.task('css', ['scsslint', 'scss']);

gulp.task('watch', function() {
  gulp.watch(config.src.scss + '/**/*.scss', ['css']);
});

gulp.task('default', ['css'])
