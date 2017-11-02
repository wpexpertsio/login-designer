/**
 * Gulpfile.
 * Project Configuration for gulp tasks.
 */

var pkg                     	= require('./package.json');
var project                 	= pkg.name;
var slug                    	= pkg.slug;
var version                	= pkg.version;
var license                	= pkg.license;
var copyright              	= pkg.copyright;
var author                 	= pkg.author;
var plugin_uri              	= pkg.plugin_uri;
var projectURL              	= 'http://demo.logindesigner.dev/login-designer';

var styleCustomizerSRC  	= './assets/scss/customizer/'+ slug +'-customize-preview.scss';
var styleCustomizerControlsSRC  = './assets/scss/customizer/'+ slug +'-customize-controls.scss';

var template_1SRC  		= './assets/scss/templates/'+ slug +'-template-01.scss';
var template_2SRC  		= './assets/scss/templates/'+ slug +'-template-02.scss';
var templateDestination  	= './assets/css/templates/'; // Path to place the compiled CSS file.

var styleDestination  		= './assets/css/'; // Path to place the compiled CSS file.
var styleWatchFiles   		= './assets/scss/**/*.scss'; // Path to all *.scss files inside css folder and inside them.

var scriptCustomizeEventsFile  	= slug +'-customize-events'; // JS file name.
var scriptCustomizeEventsSRC   	= './assets/js/'+ scriptCustomizeEventsFile +'.js'; // The JS file src.

var scriptCustomizeLiveFile 	= slug +'-customize-live'; // JS file name.
var scriptCustomizeLiveSRC   	= './assets/js/'+ scriptCustomizeLiveFile +'.js'; // The JS file src.

var scriptCustomizePreviewFile  = slug +'-customize-preview'; // JS file name.
var scriptCustomizePreviewSRC   = './assets/js/'+ scriptCustomizePreviewFile +'.js'; // The JS file src.

var scriptCustomizeControlsFile = slug +'-customize-controls'; // JS file name.
var scriptCustomizeControlsSRC  = './assets/js/'+ scriptCustomizeControlsFile +'.js'; // The JS file src.

var scriptRangeControlFile  	= slug +'-customize-range-control'; // JS file name.
var scriptRangeControlSRC   	= './assets/js/'+ scriptRangeControlFile +'.js'; // The JS file src.

var scriptTemplateControlFile  	= slug +'-customize-template-control'; // JS file name.
var scriptTemplateControlSRC   	= './assets/js/'+ scriptTemplateControlFile +'.js'; // The JS file src.

var scriptGalleryControlFile  	= slug +'-customize-gallery-control'; // JS file name.
var scriptGalleryControlSRC   		= './assets/js/'+ scriptGalleryControlFile +'.js'; // The JS file src.

var scriptLicenseControlFile  	= slug +'-customize-license-control'; // JS file name.
var scriptLicenseControlSRC   	= './assets/js/'+ scriptLicenseControlFile +'.js'; // The JS file src.

var scriptDestination 		= './assets/js/dist/'; // Path to place the compiled JS custom scripts file.
var scriptWatchFiles  		= './assets/js/*.js'; // Path to all *.scss files inside css folder and inside them.

var projectPHPWatchFiles    	= ['./**/*.php', '!_dist', '!_dist/**', '!_dist/**/*.php', '!_demo', '!_demo/**','!_demo/**/*.php'];

var text_domain             	= '@@textdomain';
var destFile                	= slug+'.pot';
var packageName             	= project;
var bugReport               	= pkg.author_uri;
var lastTranslator          	= pkg.author;
var team                    	= pkg.author_shop;
var translatePath           	= './languages';
var translatableFiles       	= ['./**/*.php'];

var buildFiles      	    	= ['./**', '!dist/', '!.gitattributes', '!.csscomb.json', '!node_modules/**', '!'+ slug +'.sublime-project', '!package.json', '!gulpfile.js', '!assets/scss/**', '!*.json', '!*.map', '!*.xml', '!*.sublime-workspace', '!*.sublime-gulp.cache', '!*.log', '!*.DS_Store','!*.gitignore', '!TODO', '!*.git' ];
var buildDestination        	= './dist/'+ slug +'/';
var distributionFiles       	= './dist/'+ slug +'/**/*';

/**
 * Browsers you care about for autoprefixing. https://github.com/ai/browserslist
 */
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
var cleaner      = require('gulp-clean');
var minifycss    = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
var rename       = require('gulp-rename');
var sort         = require('gulp-sort');
var notify       = require('gulp-notify');
var runSequence  = require('gulp-run-sequence');
var copy         = require('gulp-copy');
var lineec       = require('gulp-line-ending-corrector');
var filter       = require('gulp-filter');
var replace      = require('gulp-replace-task');
var csscomb      = require('gulp-csscomb');
var sourcemaps   = require('gulp-sourcemaps');
var browserSync  = require('browser-sync').create();
var cache        = require('gulp-cache');
var uglify       = require('gulp-uglify');
var wpPot        = require('gulp-wp-pot');
var zip          = require('gulp-zip');
var reload       = browserSync.reload;

/**
 * Clean gulp cache
 */
gulp.task('clear', function () {
	cache.clearAll();
});

gulp.task( 'browser_sync', function() {
	browserSync.init( {

	// Project URL.
	proxy: projectURL,

	// `true` Automatically open the browser with BrowserSync live server.
	// `false` Stop the browser from automatically opening.
	open: true,

	// Inject CSS changes.
	injectChanges: true,

	});
});

gulp.task('styles_customize_preview', function () {
	gulp.src( styleCustomizerSRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( csscomb() )

	.pipe( gulp.dest( styleDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( styleDestination ) )

	.pipe( browserSync.stream() )
});

gulp.task('styles_customize_controls', function () {
	gulp.src( styleCustomizerControlsSRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( csscomb() )

	.pipe( gulp.dest( styleDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( styleDestination ) )

	.pipe( browserSync.stream() )
});

gulp.task('template_1', function () {
	gulp.src( template_1SRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( csscomb() )

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )
});

gulp.task('template_2', function () {
	gulp.src( template_2SRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( csscomb() )

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )
});

gulp.task( 'scripts', function() {
	// slug-customize-preview.js
	gulp.src( scriptCustomizePreviewSRC )
	.pipe( rename( {
		basename: scriptCustomizePreviewFile,
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptDestination ) )

	// slug-customize-controls.js
	gulp.src( scriptCustomizeControlsSRC )
	.pipe( rename( {
		basename: scriptCustomizeControlsFile,
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptDestination ) )

	// slug-range-control.js
	gulp.src( scriptRangeControlSRC )
	.pipe( rename( {
		basename: scriptRangeControlFile,
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptDestination ) )

	// slug-template-control.js
	gulp.src( scriptTemplateControlSRC )
	.pipe( rename( {
		basename: scriptTemplateControlFile,
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptDestination ) )

	// slug-customize-gallery-control.js
	gulp.src( scriptGalleryControlSRC )
	.pipe( rename( {
		basename: scriptGalleryControlFile,
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptDestination ) )

	// slug-customize-license-control.js
	gulp.src( scriptLicenseControlSRC )
	.pipe( rename( {
		basename: scriptLicenseControlFile,
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptDestination ) )

	// slug-customize-events.js
	gulp.src( scriptCustomizeEventsSRC )
	.pipe( rename( {
		basename: scriptCustomizeEventsFile,
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptDestination ) )

	// slug-customize-live.js
	gulp.src( scriptCustomizeLiveSRC )
	.pipe( rename( {
		basename: scriptCustomizeLiveFile,
		suffix: '.min'
	}))
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptDestination ) )
});

/**
 * Build Tasks
 */

gulp.task( 'build-translate', function () {

	gulp.src( translatableFiles )

	.pipe( sort() )
	.pipe( wpPot( {
		domain        : text_domain,
		destFile      : destFile,
		package       : project,
		bugReport     : bugReport,
		lastTranslator: lastTranslator,
		team          : team
	} ))
	.pipe( gulp.dest( translatePath ) )

});

gulp.task( 'build-clean', function () {
	return gulp.src( ['./dist/*'] , { read: false } )
	.pipe(cleaner());
});

gulp.task( 'build-copy', function() {
    return gulp.src( buildFiles )
    .pipe( copy( buildDestination ) );
});

gulp.task('build-variables', function () {
	return gulp.src( distributionFiles )
	.pipe( replace( {
		patterns: [
		{
			match: 'pkg.version',
			replacement: version
		},
		{
			match: 'textdomain',
			replacement: pkg.textdomain
		},
		{
			match: 'pkg.name',
			replacement: project
		},
		{
			match: 'pkg.license',
			replacement: pkg.license
		},
		{
			match: 'pkg.author',
			replacement: pkg.author
		},
		{
			match: 'pkg.description',
			replacement: pkg.description
		}
		]
	}))
	.pipe( gulp.dest( buildDestination ) );
});

gulp.task( 'build-zip', function() {
    return gulp.src( buildDestination+'/**', { base: 'dist'} )
    .pipe( zip( slug +'.zip' ) )
    .pipe( gulp.dest( './dist/' ) );
});

gulp.task( 'build-clean-after-zip', function () {
	return gulp.src( [ buildDestination, '!/dist/' + slug + '.zip'] , { read: false } )
	.pipe(cleaner());
});

gulp.task( 'build-zip-and-clean', function () { } );

gulp.task( 'build-notification', function () {
	return gulp.src( '' )
	.pipe( notify( { message: '👷 Your build of ' + packageName + ' is complete.', onLast: true } ) );
});

/**
 * Commands.
 */

gulp.task( 'default', [ 'clear', 'template_1', 'template_2', 'styles_customize_preview', 'styles_customize_controls', 'scripts', 'browser_sync' ], function () {
	gulp.watch( projectPHPWatchFiles, reload );
	gulp.watch( styleWatchFiles, [ 'styles_customize_preview' ] );
	gulp.watch( styleWatchFiles, [ 'styles_customize_controls' ] );
	gulp.watch( styleWatchFiles, [ 'template_1' ] );
	gulp.watch( styleWatchFiles, [ 'template_2' ] );
	gulp.watch( scriptWatchFiles, [ 'scripts' ] );
});

gulp.task('build', function(callback) {
	runSequence( 'clear', 'build-clean', [ 'template_1', 'template_2', 'styles_customize_preview', 'styles_customize_controls', 'scripts', 'build-translate' ], 'build-copy', 'build-variables', 'build-zip', 'build-clean-after-zip', 'build-notification', callback);
});
