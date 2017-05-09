/**
 * Gulpfile.
 * Project Configuration for gulp tasks.
 */

var pkg                     = require('./package.json');
var project                 = pkg.name;
var slug                    = pkg.slug;
var slugUppercase           = slug.toUpperCase();
var projectURL              = 'http://loginly.dev/';

// Translation related.
// var text_domain             = '@@textdomain';
// var destFile                = slug+'.pot';
// var packageName             = project;
// var bugReport               = pkg.author_uri;
// var lastTranslator          = pkg.author;
// var team                    = pkg.author_shop;
// var translatePath           = './languages';

// Style related.
var CustomizerStyleSRC         = './assets/scss/customizer/customizer.scss'; // Path to main .scss file.
var CustomizerStyleDEST        = './assets/css/'; // Path to place the compiled CSS file.
var CustomizerStyleWatchFiles  = './assets/scss/**/*.scss'; // Path to all *.scss files inside css folder and inside them.
// var cssFiles                = './**/*.css'; // Path to main .scss file.

// JS Vendor related.
// var jsVendorSRC             = './assets/js/vendors/*.js'; // Path to JS vendor folder.
// var jsVendorDestination     = './assets/js/'; // Path to place the compiled JS vendors file.
// var jsVendorFile            = 'vendors'; // Compiled JS vendors file name.

// // JS Custom related.
// var jsCustomSRC             = './assets/js/custom/*.js'; // Path to JS custom scripts folder.
// var jsCustomDestination     = './assets/js/'; // Path to place the compiled JS custom scripts file.
// var jsCustomFile            = 'custom'; // Compiled JS custom file name.

// Images related.
// var imagesSRC               = './assets/images/src/**/*.{png,jpg,gif,svg}'; // Source folder of images which should be optimized.
// var imagesDestination       = './assets/images/'; // Destination folder of optimized images. Must be different from the imagesSRC folder.

// Watch files paths.

var vendorJSWatchFiles      = './assets/js/vendors/**/*.js'; // Path to all vendor JS files.
var customJSWatchFiles      = ['./assets/js/custom/**/*.js', '!_dist/assets/js/custom/**/*.js', '!_demo/assets/js/custom/**/*.js' ];
var projectPHPWatchFiles    = ['./**/*.php', '!_dist', '!_dist/**', '!_dist/**/*.php', '!_demo', '!_demo/**','!_demo/**/*.php'];

// Build _dist contents.
// var distBuildFiles          = ['./**', '!sass', '!sass/**', '!_dist', '!_dist/**', '!_demo', '!_demo/**', '!node_module/', '!node_modules/**', '!*.json', '!*.map', '!*.xml', '!gulpfile.js', '!*.sublime-project', '!*.sublime-workspace', '!*.sublime-gulp.cache', '!*.log', '!*.DS_Store', '!*.gitignore', '!TODO', '!*.git', '!*.DS_Store'];
// var distDestination         = './_dist/';

// Build /slug/ contents within the _dist folder 
// var themeDestination         = './_dist/'+slug+'/';
// var themeBuildFiles          = './_dist/'+slug+'/**/*';

// Build _demo contents.
// var demoDestination         = './_demo/';

// Browsers you care about for autoprefixing. https://github.com/ai/browserslist
const AUTOPREFIXER_BROWSERS = [
    'last 2 version',
    '> 1%',
    'ie >= 9',
    'ie_mob >= 10',
    'ff >= 30',
    'chrome >= 34',
    'safari >= 7',
    'opera >= 23',
    'ios >= 7',
    'android >= 4',
    'bb >= 10'
];

/**
 * Load Plugins.
 */
var gulp         = require('gulp');
var sass         = require('gulp-sass');
var minifycss    = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
var csscomb      = require('gulp-csscomb');
var mmq          = require('gulp-merge-media-queries');
var concat       = require('gulp-concat');
var uglify       = require('gulp-uglify');
var imagemin     = require('gulp-imagemin');
var rename       = require('gulp-rename');
var lineec       = require('gulp-line-ending-corrector');
var filter       = require('gulp-filter');
var sourcemaps   = require('gulp-sourcemaps');
var notify       = require('gulp-notify');
var browserSync  = require('browser-sync').create();
var reload       = browserSync.reload;
var wpPot        = require('gulp-wp-pot');
var sort         = require('gulp-sort');
var replace      = require('gulp-replace-task');
var runSequence  = require('gulp-run-sequence');
var zip          = require('gulp-zip');
var cache        = require('gulp-cache');
var copy         = require('gulp-copy');
var cleaner      = require('gulp-clean');
var rtlcss       = require('gulp-rtlcss');

/**
 * Clean gulp cache
 */
gulp.task('clear', function () {
   cache.clearAll();
});

/**
 * Compile Customizer SCSS files into one customizer.css file.
 */
gulp.task('CustomizerStyles', function () {
    gulp.src( CustomizerStyleSRC )
        .pipe( sourcemaps.init() )

        .pipe( sass( {
            errLogToConsole: true,
            outputStyle: 'expanded',
            precision: 10
        } ) )

        .on('error', console.error.bind(console))
       // .pipe( sourcemaps.write( { includeContent: false } ) )
       // .pipe( sourcemaps.init( { loadMaps: true } ) )
        .pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )
        // .pipe( sourcemaps.write( CustomizerStyleDEST ))
        .pipe( lineec() )
        .pipe( gulp.dest( CustomizerStyleDEST ) )
        .pipe( filter( '**/*.css' ) ) // Filtering stream to only css files

        .pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.

        .pipe( rename( { suffix: '.min' } ) )
        .pipe( minifycss( {
            maxLineLen: 10
        }))

        .pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
        .pipe( gulp.dest( CustomizerStyleDEST ) )

        .pipe( filter( '**/*.css' ) ) // Filtering stream to only css files
        .pipe( browserSync.stream() )// Reloads style.min.css if that is enqueued.

        .pipe( notify( { message: 'Customizer Styles Added', onLast: true } ) );
});

gulp.task( 'default', ['clear', 'CustomizerStyles', 'browser-sync'], function () {
gulp.watch( projectPHPWatchFiles, reload ); // Reload on PHP file changes.
gulp.watch( CustomizerStyleWatchFiles, [ 'CustomizerStyles' ] ); // Reload on SCSS file changes.
// gulp.watch( vendorJSWatchFiles, [ 'vendorsJs', reload ] ); // Reload on vendorsJs file changes.
// gulp.watch( customJSWatchFiles, [ 'customJS', reload ] ); // Reload on customJS file changes.
});














/**
 * Task: `browser-sync`.
 *
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * This task does the following:
 *      1. Sets the project URL
 *      2. Sets inject CSS
 *      3. You may define a custom port
 *      4. You may want to stop the browser from openning automatically
 */
gulp.task( 'browser-sync', function() {
    browserSync.init( {

        // For more options
        // @link http://www.browsersync.io/docs/options/

        // Project URL.
        proxy: projectURL,

        // `true` Automatically open the browser with BrowserSync live server.
        // `false` Stop the browser from automatically opening.
        open: true,

        // Inject CSS changes.
        // Commnet it to reload browser for every CSS change.
        injectChanges: true,

        // Use a specific port (instead of the one auto-detected by Browsersync).
        // port: 7000,

    } );
});


/**
 * Task: `styles`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *      1. Gets the source scss file
 *      2. Compiles Sass to CSS
 *      3. Writes Sourcemaps for it
 *      4. Autoprefixes it and generates style.css
 *      5. Renames the CSS file with suffix .min.css
 *      6. Minifies the CSS file and generates style.min.css
 *      7. Injects CSS or reloads the browser via browserSync
 */
 // gulp.task('styles', function () {
 //    gulp.src( styleSRC )
 //        .pipe( sourcemaps.init() )
 //        .pipe( sass( {
 //            errLogToConsole: true,
 //            // outputStyle: 'compact',
 //            // outputStyle: 'compressed',
 //            // outputStyle: 'nested',
 //            outputStyle: 'expanded',
 //            precision: 10
 //        } ) )
 //        .on('error', console.error.bind(console))
 //        .pipe( sourcemaps.write( { includeContent: false } ) )
 //        .pipe( sourcemaps.init( { loadMaps: true } ) )
 //        .pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

 //        .pipe( sourcemaps.write( styleDestination ))
 //        .pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
 //        .pipe( gulp.dest( styleDestination ) )

 //        .pipe( filter( '**/*.css' ) ) // Filtering stream to only css files
 //        //.pipe( mmq( { log: true } ) ) // Merge Media Queries only for .min.css version.

 //        // .pipe( csscomb() )
 //        // .pipe( gulp.dest( './' ) )
 //        // .pipe( notify( { message: 'CSS Comb Completed', onLast: true } ) )

 //        .pipe(replace({
 //          patterns: [
 //            {
 //              match: 'pkg.name',
 //              replacement: pkg.name
 //            },
 //            {
 //              match: 'pkg.author_shop',
 //              replacement: pkg.author_shop
 //            },
 //            {
 //              match: 'pkg.author_uri',
 //              replacement: pkg.author_uri
 //            },
 //            {
 //              match: 'pkg.version',
 //              replacement: pkg.version
 //            },
 //            {
 //              match: 'pkg.theme_uri',
 //              replacement: pkg.theme_uri
 //            },
 //            {
 //              match: 'pkg.description',
 //              replacement: pkg.description
 //            },
 //            {
 //              match: 'pkg.downloadid',
 //              replacement: pkg.downloadid
 //            },
 //            {
 //              match: 'pkg.textdomain',
 //              replacement: pkg.textdomain
 //            },
 //          ]
 //        }))
 //        .pipe(gulp.dest( './' ))

 //        .pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.

 //        .pipe( rename( { suffix: '.min' } ) )
 //        .pipe( minifycss( {
 //            maxLineLen: 10
 //        }))
 //        .pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
 //        .pipe( gulp.dest( styleDestination ) )

 //        .pipe( filter( '**/*.css' ) ) // Filtering stream to only css files
 //        .pipe( browserSync.stream() )// Reloads style.min.css if that is enqueued.

 //        .pipe( notify( { message: 'TASK: "styles" Completed! 💯', onLast: true } ) );
 // });

// gulp.task('rtl', function () {
//     return gulp.src('style.css')
//     .pipe( rtlcss() ) // Convert to RTL.
//     .pipe(rename({ basename: 'rtl' })) // Change the name to ".rtl"
//     .pipe( gulp.dest( './' ) );
// });





 // /**
 //  * Task: `vendorJS`.
 //  *
 //  * Concatenate and uglify vendor JS scripts.
 //  *
 //  * This task does the following:
 //  *         1. Gets the source folder for JS vendor files
 //  *         2. Concatenates all the files and generates vendors.js
 //  *         3. Renames the JS file with suffix .min.js
 //  *         4. Uglifes/Minifies the JS file and generates vendors.min.js
 //  */
 // gulp.task( 'vendorsJs', function() {
 //    gulp.src( jsVendorSRC )
 //        .pipe( concat( jsVendorFile + '.min.js' ) )
 //        .pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
 //        .pipe( gulp.dest( jsVendorDestination ) )
 //        .pipe( rename( {
 //            basename: jsVendorFile,
 //            suffix: '.min'
 //        }))
 //        // .pipe( uglify() )
 //        .pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
 //        .pipe( gulp.dest( jsVendorDestination ) )
 //        .pipe( notify( { message: 'TASK: "vendorsJs" Completed! 💯', onLast: true } ) );
 // });


 // /**
 //  * Task: `customJS`.
 //  *
 //  * Concatenate and uglify custom JS scripts.
 //  *
 //  * This task does the following:
 //  *         1. Gets the source folder for JS custom files
 //  *         2. Concatenates all the files and generates custom.js
 //  *         3. Renames the JS file with suffix .min.js
 //  *         4. Uglifes/Minifies the JS file and generates custom.min.js
 //  */
 // gulp.task( 'customJS', function() {
 //    gulp.src( jsCustomSRC )
 //        .pipe( concat( jsCustomFile + '.min.js' ) )
 //        .pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
 //        .pipe( gulp.dest( jsCustomDestination ) )
 //        .pipe( rename( {
 //            basename: jsCustomFile,
 //            suffix: '.min'
 //        }))
 //        .pipe( uglify() )
 //        .pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
 //        .pipe( gulp.dest( jsCustomDestination ) )
 //        .pipe( notify( { message: 'TASK: "customJs" Completed! 💯', onLast: true } ) );
 // });


 // /**
 //  * Task: `images`.
 //  *
 //  * Minifies PNG, JPEG, GIF and SVG images.
 //  *
 //  * This task does the following:
 //  *         1. Gets the source of images raw folder
 //  *         2. Minifies PNG, JPEG, GIF and SVG images
 //  *         3. Generates and saves the optimized images
 //  *
 //  * This task will run only once, if you want to run it
 //  * again, do it with the command `gulp images`.
 //  */
 // gulp.task( 'images', function() {
 //    gulp.src( imagesSRC )
 //        .pipe( imagemin( {
 //            progressive: true,
 //            optimizationLevel: 3, // 0-7 low-high
 //            interlaced: true,
 //            svgoPlugins: [{removeViewBox: false}]
 //        } ) )
 //        .pipe(gulp.dest( imagesDestination ))
 //        .pipe( notify( { message: 'TASK: "images" Completed! 💯', onLast: true } ) );
 // });





 // /**
 //  * Watch Tasks.
 //  *
 //  * Watches for file changes and runs specific tasks.
 //  */
 // gulp.task( 'default', ['clear','styles', 'vendorsJs', 'customJS', 'images' ,'browser-sync'], function () {
 // // gulp.task( 'default', ['styles', 'vendorsJs', 'customJS', 'images', 'browser-sync'], function () {    
 //    gulp.watch( projectPHPWatchFiles, reload ); // Reload on PHP file changes.
 //    gulp.watch( styleWatchFiles, [ 'styles' ] ); // Reload on SCSS file changes.
 //    gulp.watch( vendorJSWatchFiles, [ 'vendorsJs', reload ] ); // Reload on vendorsJs file changes.
 //    gulp.watch( customJSWatchFiles, [ 'customJS', reload ] ); // Reload on customJS file changes.
 // });













// gulp.task('clean', function () {
//     return gulp.src( ['./_dist/'+slug+'/','./_dist/'+slug+'.zip','./_dist/'+slug+'-package.zip'] , {read: false} ) // much faster
//    .pipe(cleaner());
// });

// gulp.task('copy', function () {
//     return gulp.src( distBuildFiles )
//     .pipe( copy( themeDestination ) );
// });

// gulp.task('readme', ['copy'], function() {
//     return gulp.src('./_dist/'+slug+'/readme.md')
//     .pipe( rename( './_dist/'+slug+'/readme.txt' ) )
//     .pipe(gulp.dest( './' ));
// });

// gulp.task('clean-readme.md', ['readme'], function () {
//     return gulp.src('./_dist/'+slug+'/readme.md', {read: false} ) 
//    .pipe(cleaner());
// });

// gulp.task('variables', ['clean-readme.md'], function () {
//     return gulp.src( themeBuildFiles )
//     .pipe(replace({
//         patterns: [
//         {
//             match: 'pkg.name',
//             replacement: pkg.name
//         },
//         {
//             match: 'pkg.version',
//             replacement: pkg.version
//         },
//         {
//             match: 'pkg.author',
//             replacement: pkg.author
//         },
//         {
//             match: 'pkg.author_shop',
//             replacement: pkg.author_shop
//         },
//         {
//             match: 'pkg.license',
//             replacement: pkg.license
//         },
//         {
//             match: 'pkg.slug',
//             replacement: pkg.slug
//         },
//         {
//             match: 'textdomain',
//             replacement: pkg.textdomain
//         },
//         {
//             match: 'pkg.downloadid',
//             replacement: pkg.downloadid
//         },
//         {
//             match: 'pkg.description',
//             replacement: pkg.description
//         },
//         {
//             match: /^    define\( 'AVA_DEBUG'.*$/m,
//             replacement: '    define( \'AVA_DEBUG\', false );'
//         }
//         ]
//     }))
//     .pipe(gulp.dest( themeDestination ));
// });

// gulp.task('zip-theme', ['variables'], function() {
//     return gulp.src( './_dist/'+slug+'/**' )
//     .pipe( zip( slug + '.zip' ) )
//     .pipe( gulp.dest( distDestination ) );
// });

// gulp.task('move-to-demo', ['zip-theme'], function(){
//    return gulp.src('./_dist/'+slug+'/**')
//   .pipe( gulp.dest( demoDestination ) );
// });

// gulp.task('clean-dist', ['move-to-demo'], function () {
//     return gulp.src('./_dist/'+slug+'/', {read: false} )
//    .pipe(cleaner());
// });

// gulp.task('zip-package', ['clean-dist'], function() {
//     return gulp.src( './_dist/**' )
//     .pipe( zip( slug + '-package.zip' ) )
//     .pipe( gulp.dest( distDestination ) );
// });

// gulp.task('copy_variables_zip-theme', ['copy', 'readme', 'clean-readme.md', 'variables', 'zip-theme', 'move-to-demo', 'clean-dist', 'zip-package'], function() { });

// gulp.task( 'notification--build', function () {
//     return gulp.src( '' )
//     .pipe( notify( { message: 'Your build of ' + packageName + ' is completed.', onLast: true } ) );
// });





//  /**
//   * WP POT Translation File Generator.
//   *
//   * * This task does the following:
//   *     1. Gets the source of all the PHP files
//   *     2. Sort files in stream by path or any custom sort comparator
//   *     3. Applies wpPot with the variable set at the top of this file
//   *     4. Generate a .pot file of i18n that can be used for l10n to build .mo file
//   */
//  gulp.task( 'translate', function () {

//         gulp.src( projectPHPWatchFiles )

//         .pipe(sort())
//         .pipe(wpPot( {
//              domain        : text_domain,
//              destFile      : destFile,
//              package       : project,
//              bugReport     : bugReport,
//              lastTranslator: lastTranslator,
//              team          : team
//         } ))
//         .pipe( gulp.dest( translatePath ) )
//         .pipe( notify( { message: 'TASK: "translate" Completed! 💯', onLast: true } ) );

//  });



// gulp.task('css_variables', function () {
//   gulp.src( cssFiles )
//     .pipe(replace({
//       patterns: [
//         {
//           match: 'pkg.name',
//           replacement: pkg.name
//         },
//       ]
//     }))
//     .pipe(gulp.dest( './' ));
// });


// gulp.task('build', function(callback) {
//   runSequence( 'clear', 'clean', ['styles', 'css_variables', 'vendorsJs', 'customJS',  'woocommerceJS', 'translate', 'images'], 'copy_variables_zip-theme', 'notification--build', callback);
// });