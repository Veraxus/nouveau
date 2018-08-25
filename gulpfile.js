const gulp = require('gulp');
const plugins = require('gulp-load-plugins')();

const paths = {
    in: {
        styles: [
            'assets/build/scss/**/*.scss',
            '!assets/build/scss/**/_*.scss'
        ],
        scripts: ['assets/build/js/**/*.js'],
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
            'node_modules/motion-ui/src',
        ]
    }
};


// ===============
// BUILD STYLES
// ===============
gulp.task('build:styles', () => {
    return gulp.src(paths.in.styles)
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass({
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
    return gulp.src(paths.in.scripts)
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.babel())
        .pipe(plugins.uglify())
        .pipe(plugins.rename({
            suffix: '.min',
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
gulp.task('default', gulp.series('build', 'watch'));