var gulp = require('gulp'),
	plugins = require('gulp-load-plugins')(),
	sassPaths = [
		'bower_components/foundation-sites/scss',
		'bower_components/motion-ui/src'
	];

// Compile SASS → CSS
gulp.task('sass', function () {
	return gulp.src(['assets/scss/*.scss', "!assets/scss/_*.scss"])
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.sass({
			includePaths: sassPaths,
			outputStyle : 'compressed' //options; expanded, nested, compact, compressed
		})
			.on('error', plugins.sass.logError))
		.pipe(plugins.autoprefixer({
			browsers: ['last 2 versions', 'ie >= 9']
		}))
		.pipe(plugins.sourcemaps.write('./'))
		.pipe(gulp.dest('assets/css'));
});

// Process and minify JS
gulp.task('js', function () {
	return gulp.src(['assets/js/*.js', "!*.min.js"])
		.pipe(plugins.uglify())
		.pipe(plugins.rename({
			suffix: ".min"
		}))
		.pipe(gulp.dest('assets/js'));
});

// Automatically set up watchers when gulp is run
gulp.task('default', ['sass', 'js'], function () {
	gulp.watch(['assets/scss/**/*.scss'], ['sass']);
	gulp.watch(['assets/js/**/*.js'], ['js']);
});