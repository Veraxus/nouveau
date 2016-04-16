var gulp = require('gulp');
var $    = require('gulp-load-plugins')();

var sassPaths = [
	'bower_components/foundation-sites/scss',
	'bower_components/motion-ui/src'
];

gulp.task('sass', function() {
	return gulp.src([ 'assets/scss/*.scss', "!assets/scss/_*.scss" ])
		.pipe($.sourcemaps.init())
		.pipe($.sass({
				includePaths: sassPaths,
				outputStyle: 'compressed' //options; expanded, nested, compact, compressed
			})
			.on('error', $.sass.logError))
		.pipe($.autoprefixer({
			browsers: ['last 2 versions', 'ie >= 9']
		}))
		.pipe($.sourcemaps.write('./'))
		.pipe(gulp.dest('assets/css'));
});

gulp.task('js', function(){
	return gulp.src([ 'assets/js/*.js', "!assets/js/*.min.js" ])
		.pipe($.uglify())
		.pipe($.rename({
			suffix: ".min"
		}))
		.pipe(gulp.dest('assets/js'));
});

// Automatically set up watchers when gulp is run
gulp.task('default', ['sass', 'js'], function() {
	gulp.watch(['assets/scss/**/*.scss'], ['sass']);
	gulp.watch(['assets/js/**/*.js'], ['js']);
});