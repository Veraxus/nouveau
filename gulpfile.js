const gulp = require('gulp');
const plugins = require('gulp-load-plugins')();

// ============
// BUILD TASKS
// ============
gulp.task('build:styles', function() {
  return gulp.src(['assets/build/scss/*.scss', '!assets/build/scss/_*.scss']).
      pipe(plugins.sourcemaps.init()).
      pipe(plugins.sass({
        includePaths: [
          'node_modules/foundation-sites/scss',
          'node_modules/motion-ui/src',
        ],
        outputStyle: 'compressed', //options; expanded, nested, compact,
        // compressed
      }).on('error', plugins.sass.logError)).
      pipe(plugins.autoprefixer({
        browsers: ['last 2 versions', 'ie >= 9'],
      })).
      pipe(plugins.sourcemaps.write('./')).
      pipe(gulp.dest('assets/dist/css'));
});

gulp.task('build:scripts', function() {
  return gulp.src(['assets/build/js/*.js']).
      pipe(plugins.uglify()).
      pipe(plugins.rename({
        suffix: '.min',
      })).
      pipe(gulp.dest('assets/dist/js'));
});

gulp.task('build', gulp.parallel('build:styles', 'build:scripts'));


// ============
// BUILD TASKS
// ============
gulp.task('watch:styles', function() {
  return gulp.watch(['assets/build/scss/**/*.scss'],
      gulp.parallel('build:styles'));
});

gulp.task('watch:scripts', function() {
  return gulp.watch(['assets/build/js/**/*.js'],
      gulp.parallel('build:scripts'));
});

gulp.task('watch', gulp.parallel('watch:styles', 'watch:scripts'));

// =============
// DEFAULT TASK
// =============
gulp.task('default', gulp.parallel('watch'));