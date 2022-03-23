"use strict";
// Gulpfile Taskrunner | by SecondSite
// Read the README.md for a list of the functions available
// Load plugins
const Fiber = require('fibers'),
    autoprefixer = require("autoprefixer"),
    cleanCSS = require("gulp-clean-css"),
    del = require("del"),
    gulp = require("gulp"),
    newer = require('gulp-newer'),
    cache = require('gulp-cache'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    Zopfli = require('imagemin-zopfli'),
    Mozjpeg = require('imagemin-mozjpeg'),
    Giflossy = require('imagemin-giflossy'),
    header = require("gulp-header"),
    merge = require("merge-stream"),
    plumber = require("gulp-plumber"),
    rename = require("gulp-rename"),
    sass = require("gulp-sass"),
    cssnano = require('cssnano'),
    postcss = require('gulp-postcss'),
    terser = require('gulp-terser-js'),
    uglify = require("gulp-uglify"),
    concat = require('gulp-concat'),
    deporder = require('gulp-deporder'),
    stripdebug = require('gulp-strip-debug'),
    sourcemaps = require('gulp-sourcemaps'),
    strip = require('gulp-strip-comments'),
    gulp_bootstrap_email = require('gulp-bootstrap-email'),
    zip = require('gulp-zip'),
    pkg = require('./package.json'),
    pipeline = require('readable-stream').pipeline;
    sass.compiler = require('node-sass'); // node-sass compiler

const adminScripts = [
    "./vendor/jquery/jquery.js",
    "./vendor/bootstrap/js/bootstrap.bundle.js",
    "./vendor/jquery-easing/jquery.easing.js",
    "./vendor/jquery-validation/jquery.validate.js",
    ".//src/js/**/*"
];

// Set the banner content
const banner = ['/*!\n',
  ' * Twig Template - <%= pkg.title %> v<%= pkg.version %> ((https://github.com/SecondSite-web/<%= pkg.name %>)\n',
  ' * Copyright ' + (new Date()).getFullYear(), ' <%= pkg.author %>\n',
  ' * Licensed under <%= pkg.license %> (https://github.com/SecondSite-web/<%= pkg.name %>/blob/master/LICENSE)\n',
  ' */\n',
  '\n'
].join('');

function zipit() {
    return gulp.src(['./**/*', '!./node_modules/**/*'])
        .pipe(zip('omniaparatus.zip'))
        .pipe(gulp.dest('../'))
}

function emails() {
    return gulp.src('./src/email-templates/**/*.html')
        .pipe(gulp_bootstrap_email())

        .pipe(gulp.dest('./email-templates/'))
}

function img_cleanup() { return del('./src/img/**/*')}

function img_compress() {
    return gulp.src(['./src/img/**/*.{gif,png,jpg,svg}'])
        .pipe(cache(imagemin({ optimizationLevel: 5, verbose:true, progressive:true, use:[
            //png
            pngquant({
                speed: 1,
                quality: [0.95, 1] //lossy settings
            }),
            Zopfli({
                more: true
                // iterations: 50 // very slow but more effective
            }),
            //gif
            // imagemin.gifsicle({
            //     interlaced: true,
            //     optimizationLevel: 3
            // }),
            //gif very light lossy, use only one of gifsicle or Giflossy
            Giflossy({
                optimizationLevel: 3,
                optimize: 3, //keep-empty: Preserve empty transparent frames
                lossy: 2
            }),
            //svg
            imagemin.svgo({
                plugins: [{
                    removeViewBox: false
                }]
            }),
            //jpg lossless
            imagemin.jpegtran({
                progressive: true
            }),
            //jpg very light lossy, use vs jpegtran
            Mozjpeg({
                quality: 50
            })
        ]})))
        .pipe(gulp.dest('./img'));
}
// Clean working folders
function clean() {
    return del([
        './webfonts/',
        './css/',
        './js/',
        './src/img/**/*'
    ]);
}

// Bring third party dependencies from node_modules into vendor directory
function modules() {
    var bootstrapJS = gulp.src('./node_modules/bootstrap/dist/js/*')
            .pipe(gulp.dest('./vendor/bootstrap/js')),
        bootstrapSCSS = gulp.src('./node_modules/bootstrap/scss/**/*')
            .pipe(gulp.dest('./vendor/bootstrap/scss')),
        fontAwesome = gulp.src('./node_modules/@fortawesome/fontawesome-free/scss/**/*')
            .pipe(gulp.dest('./vendor/fontawesome')),
        fontAwesomeFonts = gulp.src('./node_modules/@fortawesome/fontawesome-free/webfonts/*')
            .pipe(gulp.dest('./webfonts')),
        dataTables = gulp.src([
            './node_modules/datatables.net/js/*.js',
            './node_modules/datatables.net-bs4/js/*.js',
            './node_modules/datatables.net-bs4/css/*.css'
        ])
            .pipe(gulp.dest('./vendor/datatables')),
        jqueryEasing = gulp.src('./node_modules/jquery.easing/*.js')
            .pipe(gulp.dest('./vendor/jquery-easing')),
        jqueryValidation = gulp.src('./node_modules/jquery-validation/dist/*')
            .pipe(gulp.dest('./vendor/jquery-validation')),
        jquery = gulp.src('./node_modules/jquery/dist/*')
            .pipe(gulp.dest('./vendor/jquery/')),
        datepicker = gulp.src('./node_modules/pc-bootstrap4-datetimepicker/src/**/*')
            .pipe(gulp.dest('./vendor/datimepicker/src')),
        datepicker2 = gulp.src('./node_modules/pc-bootstrap4-datetimepicker/build/**/*')
            .pipe(gulp.dest('./vendor/datimepicker/')),
        moment = gulp.src('./node_modules/moment/min/moment.min.js')
            .pipe(gulp.dest('./vendor/moment/'));

    return merge(bootstrapJS, bootstrapSCSS, fontAwesome, fontAwesomeFonts, dataTables, jqueryValidation, jqueryEasing, jquery, datepicker, datepicker2, moment);
}

function admincss() {
  return mincss ('./src/scss/**/*.scss', './css/');
}
function adminpagejs() {
    return pagejs('./src/pagejs/*.js','./js/');
}
function adminjs() {
    return minjs(adminScripts, './admin.js', './js/');
}

function mincss(source, destination) {
    return gulp
        .src(source)
        .pipe(
            plumber({
                errorHandler: function(err) {
                    console.log(err);
                    this.emit('end');
                }
            })
        )
        .pipe(sourcemaps.init())
        .pipe(sass.sync({
            fiber: Fiber,
            outputStyle: "expanded",
            includePaths: "./node_modules"
        }).on('error', sass.logError))

        .pipe(postcss([autoprefixer({
            overrideBrowserslist: ['last 2 versions'],
            cascade: false
        })]))
        .pipe(postcss([cssnano])) // cssnano settings in package.json
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('/')) // Output source maps.
        .pipe(gulp.dest(destination))

}
// child function

function minjs(input, filename, outputdir) {
    return pipeline(
        gulp.src(input),
        sourcemaps.init(),
        concat(filename),
        // stripdebug(),
        // strip(),
        // terser(),
        rename({suffix:'.min'}),
        sourcemaps.write('./'),
        gulp.dest(outputdir)
    );
}
function pagejs(input, outputdir) {
    return pipeline(
        gulp.src(input),
        sourcemaps.init(),
        // concat(filename),
        // stripdebug(),
        // strip(),
        // terser(),
        rename({suffix:'.min'}),
        sourcemaps.write('./'),
        gulp.dest(outputdir)
    );
}
// Watch files
function watchFiles() {
  gulp.watch(".//src/scss/**/*", admincss);
  gulp.watch("./src/email-templates/**/*", emails);
  gulp.watch(["./src/pagejs/**/*", "!./src/pagejs/**/*.min.js"], adminpagejs);
  gulp.watch(["./src/js/**/*", "!./src/js/**/*.min.js"], adminjs);
  gulp.watch("./src/img/**.*", images);
}

// Define complex tasks
const vendor = gulp.series(clean, modules);
const images = gulp.series(img_compress, img_cleanup);
const build = gulp.series(vendor, images, admincss, adminjs, adminpagejs);
const watch = gulp.parallel(watchFiles);

// Export tasks
exports.images = images;
exports.admincss = admincss;
exports.adminjs = adminjs;
exports.adminpagejs = adminpagejs;
exports.clean = clean;
exports.emails = emails;
exports.vendor = vendor;
exports.build = build;
exports.watch = watch;
exports.default = build;
exports.zipit = zipit;
