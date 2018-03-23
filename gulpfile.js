/**
 * Gulpfile.
 * Project Configuration for gulp tasks.
 */

var pkg                     	= require('./package.json');
var project                 	= 'Login Designer';
var slug                    	= pkg.slug;
var version                	= pkg.version;
var license                	= pkg.license;
var copyright              	= pkg.copyright;
var author                 	= pkg.author;
var plugin_uri              	= pkg.plugin_uri;
var projectURL              	= 'http://demo.logindesigner.dev/wp-login.php';

var styleCustomizerSRC  	= './assets/scss/customizer/'+ slug +'-customize-preview.scss';
var styleCustomizerControlsSRC  = './assets/scss/customizer/'+ slug +'-customize-controls.scss';

var styleIntroSRC           	= './assets/scss/customizer/'+ slug +'-intro.scss';

var template_1SRC  		= './assets/scss/templates/'+ slug +'-template-01.scss';
var template_2SRC  		= './assets/scss/templates/'+ slug +'-template-02.scss';
var template_3SRC  		= './assets/scss/templates/'+ slug +'-template-03.scss';
var template_4SRC  		= './assets/scss/templates/'+ slug +'-template-04.scss';

var templateDestination  	= './assets/css/templates/'; // Path to place the compiled CSS file.
var templateSRCDestination  	= './assets/css/src/templates/'; // Path to place the compiled CSS file.

var styleSRCDestination  	= './assets/css/src/'; // Path to place the compiled CSS file.
var styleDestination  		= './assets/css/'; // Path to place the compiled CSS file.
var styleWatchFiles   		= './assets/scss/**/*.scss'; // Path to all *.scss files inside css folder and inside them.

var scriptDestination 		= './assets/js/';
var scriptWatchFiles  		= './assets/js/src/*.js';

var scriptCustomizeEventsFile  	= slug +'-customize-events'; // JS file name.
var scriptCustomizeEventsSRC   	= './assets/js/src/'+ scriptCustomizeEventsFile +'.js'; // The JS file src.

var scriptCustomizeLiveFile 	= slug +'-customize-live'; // JS file name.
var scriptCustomizeLiveSRC   	= './assets/js/src/'+ scriptCustomizeLiveFile +'.js'; // The JS file src.

var scriptCustomizePreviewFile  = slug +'-customize-preview'; // JS file name.
var scriptCustomizePreviewSRC   = './assets/js/src/'+ scriptCustomizePreviewFile +'.js'; // The JS file src.

var scriptCustomizeControlsFile = slug +'-customize-controls'; // JS file name.
var scriptCustomizeControlsSRC  = './assets/js/src/'+ scriptCustomizeControlsFile +'.js'; // The JS file src.

var scriptAllControls	        = './assets/js/src/controls/*.js';
var scriptControlsDestination	= './assets/js/';
var scriptAllControlsFile	= 'login-designer-customize-custom-controls';
var scriptControlWatchFiles	= './assets/js/src/controls/*.js';

var projectPHPWatchFiles    	= ['./**/*.php', '!_dist', '!_dist/**', '!_dist/**/*.php', '!_demo', '!_demo/**','!_demo/**/*.php'];

var text_domain             	= '@@textdomain';
var destFile                	= slug+'.pot';
var packageName             	= pkg.title;
var bugReport               	= pkg.author_uri;
var lastTranslator          	= pkg.author;
var team                    	= pkg.author_shop;
var translatePath           	= './languages';
var translatableFiles       	= ['./**/*.php'];

var buildFiles      	    	= ['./**', '!dist/', '!.gitattributes', '!.csscomb.json', '!node_modules/**', '!*.sublime-project', '!package.json', '!gulpfile.js', '!assets/js/src/**', '!assets/css/src/**', '!assets/scss/**', '!*.json', '!*.map', '!*.md', '!*.xml', '!*.sublime-workspace', '!*.sublime-gulp.cache', '!*.log', '!*.gitattributes', '!*.DS_Store','!*.gitignore', '!TODO', '!*.git' ];
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
var concat       = require('gulp-concat');
var cleaner      = require('gulp-clean');
var minifycss    = require('gulp-uglifycss');
var autoprefixer = require('gulp-autoprefixer');
var rename       = require('gulp-rename');
var sort         = require('gulp-sort');
var notify       = require('gulp-notify');
var runSequence  = require('run-sequence');
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

// Ensures that debug mode is turned on during development.
gulp.task( 'debug_mode_on', function () {
	return gulp.src( ['./login-designer.php', '!_dist/login-designer.php'] )

	.pipe( replace( {
		patterns: [
		{
			match: '_DEBUG\', false );',
			replacement: '_DEBUG\', true );'
		}
		],
		usePrefix: false
	} ) )
	.pipe( gulp.dest( './' ) );
});

// Ensures SLUG_DEBUG is set to false for all build and demo files.
gulp.task( 'debug_mode_off', function () {
	return gulp.src( distributionFiles )

	.pipe( replace( {
		patterns: [
		{
			match: '_DEBUG\', true );',
			replacement: '_DEBUG\', false );'
		}
		],
		usePrefix: false
	} ) )
	.pipe( gulp.dest( buildDestination ) );
});

gulp.task( 'vendorsJs', function() {
	gulp.src( scriptAllControls )
	.pipe( concat( scriptAllControlsFile + '.min.js' ) )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptControlsDestination ) )
	.pipe( rename( {
		basename: scriptAllControlsFile,
		suffix: '.min'
	} ) )
	.pipe( uglify() )
	.pipe( lineec() )
	.pipe( gulp.dest( scriptControlsDestination ) )
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

	.pipe( gulp.dest( styleSRCDestination ) )

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

	.pipe( gulp.dest( styleSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( styleDestination ) )

	.pipe( browserSync.stream() )
});

gulp.task('styles_intro_js', function () {
	gulp.src( styleIntroSRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( csscomb() )

	.pipe( gulp.dest( styleSRCDestination ) )

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

	.pipe( gulp.dest( templateSRCDestination ) )

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

	.pipe( gulp.dest( templateSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )
});

gulp.task('template_3', function () {
	gulp.src( template_3SRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( csscomb() )

	.pipe( gulp.dest( templateSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )
});

gulp.task('template_4', function () {
	gulp.src( template_4SRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( csscomb() )

	.pipe( gulp.dest( templateSRCDestination ) )

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
			match: 'pkg.title',
			replacement: pkg.title
		},
		{
			match: 'pkg.slug',
			replacement: slug
		},
		{
			match: 'pkg.downloadid',
			replacement: pkg.downloadid
		},
		{
			match: 'pkg.license',
			replacement: pkg.license
		},
		{
			match: 'pkg.plugin_uri',
			replacement: pkg.plugin_uri
		},
		{
			match: 'pkg.author',
			replacement: pkg.author
		},
		{
			match: 'pkg.author_uri',
			replacement: pkg.author_uri
		},
		{
			match: 'pkg.description',
			replacement: pkg.description
		},
		{
			match: 'pkg.requires',
			replacement: pkg.requires
		},
		{
			match: 'pkg.tested_up_to',
			replacement: pkg.tested_up_to
		},
		{
			match: 'pkg.tags',
			replacement: pkg.tags
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

gulp.task( 'build-notification', function () {
	return gulp.src( '' )
	.pipe( notify( { message: '👷 Your build of ' + packageName + ' is complete.', onLast: true } ) );
});

/**
 * Commands.
 */

gulp.task( 'default', [ 'clear', 'debug_mode_on', 'vendorsJs', 'template_1', 'template_2', 'template_3', 'template_4', 'styles_customize_preview', 'styles_customize_controls', 'styles_intro_js', 'scripts', 'browser_sync' ], function () {
	gulp.watch( projectPHPWatchFiles, reload );
	gulp.watch( styleWatchFiles, [ 'styles_customize_preview' ] );
	gulp.watch( styleWatchFiles, [ 'styles_intro_js' ] );
	gulp.watch( styleWatchFiles, [ 'template_1' ] );
	gulp.watch( styleWatchFiles, [ 'template_1' ] );
	gulp.watch( styleWatchFiles, [ 'template_2' ] );
	gulp.watch( styleWatchFiles, [ 'template_3' ] );
	gulp.watch( styleWatchFiles, [ 'template_4' ] );
	gulp.watch( scriptWatchFiles, [ 'scripts' ] );
	gulp.watch( scriptControlWatchFiles, [ 'vendorsJs', reload ] );
});

gulp.task('build', function(callback) {
	runSequence( 'clear', 'build-clean', [ 'template_1', 'template_2', 'template_3', 'template_4', 'styles_customize_preview', 'styles_customize_controls', 'styles_intro_js', 'scripts', 'vendorsJs', 'build-translate' ], 'build-copy', 'build-variables', 'debug_mode_off', 'build-zip', 'build-notification', callback);
});