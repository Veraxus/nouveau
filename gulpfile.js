/**
 * This gulp file is pre-configured to support Gutenberg's React architecture using ESNext & JSX.
 *
 * Available gulp commands:
 *
 * > gulp
 *
 *   |---> Runs a build then starts watching js, scss, and images.
 *
 * > gulp build
 *
 *   |---> Builds js, scss, and images, then terminates.
 *
 * > gulp watch
 *
 *   |---> Begins watching js, scss, and images for changes. Does not build first.
 *
 * > gulp build:styles
 * > gulp build:scripts
 * > gulp build:images
 *
 *   |---> Builds only the specific thing that you specify (styles, scripts, or images).
 *
 * > gulp watch:styles
 * > gulp watch:scripts
 * > gulp watch:images
 *
 *   |---> Begins watching only the specific thing you specify (styles, scripts, or images) then terminates.
 *
 * @type {Gulp}
 */

const gulp = require('gulp');
const plugins = require('gulp-load-plugins')();
const sassGlob = require('node-sass-glob-importer');

const paths = {
    in: {
        styles: [
            'assets/build/scss/**/*.scss'
        ],
        scripts: [
            'assets/build/js/**/*.js'
        ],
        images: ['assets/build/img/**/*']
    },
    out: {
        styles: 'assets/dist/css',
        scripts: 'assets/dist/js',
        images: 'assets/dist/img'
    },
    includes: {
        styles: [
            'node_modules/foundation-sites/scss',
            'node_modules/motion-ui/src'
        ],
        scripts: [
            'node_modules/jquery/dist/jquery.min.js',
            'node_modules/what-input/dist/what-input.min.js',
            'node_modules/foundation-sites/dist/js/foundation.min.js'
        ]
    }
};


// ===============
// BUILD STYLES
// ===============
gulp.task('build:styles', () => {
    return gulp.src(paths.in.styles.concat('!_*.scss'))
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass({
            importer: sassGlob(),
            includePaths: paths.includes.styles,
            outputStyle: 'compressed', //options: expanded, nested, compact, compressed
        }).on('error', plugins.sass.logError))
        .pipe(plugins.autoprefixer({
            browsers: ['last 2 versions', 'ie >= 11'],
        }))
        .pipe(plugins.sourcemaps.write('./'))
        .pipe(gulp.dest(paths.out.styles));
});


// ===============
// BUILD SCRIPTS
// ===============
gulp.task('build:scripts', () => {

    // Ensure that includes get added to theme dist (no add'l processing)
    gulp.src(paths.includes.scripts)
        .pipe(gulp.dest(paths.out.scripts));

    // Process our own files
    return gulp.src(paths.in.scripts)
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.babel({
            "presets": [
                [
                    "env",
                    {
                        "targets": {
                            "browsers": [">0.25%", "ie 11", "not op_mini all"]
                        }
                    }
                ],
                "react"
            ]
        }))
        .pipe(plugins.uglifyEs.default())
        .pipe(plugins.rename({
            extname: '.min.js'
        }))
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(paths.out.scripts));
});

// ===============
// OPTIMIZE IMAGES
// ===============
gulp.task('build:images', () => {
    return gulp.src(paths.in.images)
        .pipe(plugins.imagemin())
        .pipe(gulp.dest(paths.out.images))
});

// ===============
// BUILD EVERYTHING
// ===============
gulp.task('build', gulp.parallel('build:styles', 'build:scripts', 'build:images'));


// ===============
// WATCH STYLES
// ===============
gulp.task('watch:styles', () => {
    return gulp.watch(paths.in.styles, gulp.parallel('build:styles'));
});

// ===============
// WATCH SCRIPTS
// ===============
gulp.task('watch:scripts', () => {
    return gulp.watch(paths.in.scripts, gulp.parallel('build:scripts'));
});

// ===============
// WATCH IMAGES
// ===============
gulp.task('watch:images', () => {
    return gulp.watch(paths.in.images, gulp.parallel('build:scripts'));
});

// ===============
// WATCH EVERYTHING
// ===============
gulp.task('watch', gulp.parallel('watch:styles', 'watch:scripts', 'watch:images'));


// =============
// DEFAULT TASK
// =============
gulp.task('default', gulp.parallel('build', 'watch'));