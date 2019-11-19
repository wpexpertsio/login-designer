/**
 * Gulpfile.
 * Project Configuration for gulp tasks.
 */

var pkg                     	= require('./package.json');
var project                 	= 'Login Designer';
var slug                    	= 'login-designer';
var version                	= pkg.version;
var projectURL              	= 'https://logindesigner.test/wp-login.php';

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

var text_domain             	= 'login-designer';
var destFile                	= slug+'.pot';
var bugReport               	= 'https://logindesigner.com';
var lastTranslator          	= 'Login Designer';
var team                    	= 'Login Designer';
var translatePath           	= './languages';
var translatableFiles       	= ['./**/*.php'];

var buildFiles      	    	= ['./**', '!dist/', '!.gitattributes', '!node_modules/**', '!*.sublime-project', '!package.json', '!gulpfile.js', '!assets/js/src/**', '!assets/css/src/**', '!assets/scss/**', '!*.json', '!*.map', '!*.md', '!*.xml', '!*.sublime-workspace', '!*.sublime-gulp.cache', '!*.log', '!*.gitattributes', '!*.DS_Store','!*.gitignore', '!TODO', '!*.git' ];
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
var del          = require('del');
var minifycss    = require('gulp-uglifycss');
var autoprefixer = require('gulp-autoprefixer');
var rename       = require('gulp-rename');
var sort         = require('gulp-sort');
var notify       = require('gulp-notify');
var copy         = require('gulp-copy');
var lineec       = require('gulp-line-ending-corrector');
var filter       = require('gulp-filter');
var replace      = require('gulp-replace-task');
var sourcemaps   = require('gulp-sourcemaps');
var browserSync  = require('browser-sync').create();
var cache        = require('gulp-cache');
var uglify       = require('gulp-uglify');
var wpPot        = require('gulp-wp-pot');
var zip          = require('gulp-zip');
var reload       = browserSync.reload;

function clearCache(done) {
	cache.clearAll();
	done();
}
gulp.task(clearCache);

gulp.task( 'browser_sync', function(done) {
	browserSync.init( {
		proxy: projectURL,
		open: true,
		injectChanges: true,
	} );
	done();
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
gulp.task( 'debug_mode_off', function (done) {
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
	done();
});

gulp.task( 'vendorsJs', function(done) {
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
	done();
});

gulp.task('styles_customize_preview', function (done) {
	gulp.src( styleCustomizerSRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( gulp.dest( styleSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss() )

	.pipe( gulp.dest( styleDestination ) )

	.pipe( browserSync.stream() )
	done();
});

gulp.task('styles_customize_controls', function (done) {
	gulp.src( styleCustomizerControlsSRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( gulp.dest( styleSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( styleDestination ) )

	.pipe( browserSync.stream() )
	done();
});

gulp.task('styles_intro_js', function (done) {
	gulp.src( styleIntroSRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( gulp.dest( styleSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( styleDestination ) )

	.pipe( browserSync.stream() )
	done();
});

gulp.task('template_1', function (done) {
	gulp.src( template_1SRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( gulp.dest( templateSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )
	done();
});

gulp.task('template_2', function (done) {
	gulp.src( template_2SRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( gulp.dest( templateSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )
	done();
});

gulp.task('template_3', function (done) {
	gulp.src( template_3SRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( gulp.dest( templateSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )
	done();
});

gulp.task('template_4', function (done) {
	gulp.src( template_4SRC )

	.pipe( sass( {
		errLogToConsole: true,
		outputStyle: 'expanded',
		precision: 10
	} ) )

	.on( 'error', console.error.bind( console ) )

	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

	.pipe( gulp.dest( templateSRCDestination ) )

	.pipe( browserSync.stream() )

	.pipe( rename( { suffix: '.min' } ) )

	.pipe( minifycss( {
		maxLineLen: 10
	}))

	.pipe( gulp.dest( templateDestination ) )

	.pipe( browserSync.stream() )
	done();
});

gulp.task( 'scripts', function(done) {
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
	done();
});

/**
 * Build Tasks
 */

gulp.task( 'build-translate', function (done) {

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
	done();

});

gulp.task( 'build-clean', function (done) {
	return del( './dist/*' );
	done();
});

gulp.task( 'build-copy', function(done) {

    return gulp.src( buildFiles )
    .pipe( copy( buildDestination ) );
    done();
});

gulp.task( 'updateVersion', function(done) {
	return gulp.src( './*.php' )

	.pipe( replace( {
		patterns: [
			{
				match: /(\d+\.+\d+\.+\d)/,
				replacement: pkg.version
			},
		],
		usePrefix: false
	} ) )
	.pipe( gulp.dest( './' ) );
	done();
});

gulp.task('build-variables', function (done) {
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
			match: 'pkg.downloadid',
			replacement: pkg.downloadid
		},
		]
	}))
	.pipe( gulp.dest( buildDestination ) );
	done();
});

gulp.task( 'build-zip', function(done) {
    return gulp.src( buildDestination+'/**', { base: 'dist'} )
    .pipe( zip( slug +'.zip' ) )
    .pipe( gulp.dest( './dist/' ) );
    done();
});

gulp.task( 'build-clean-after-zip', function (done) {
	return del( [ buildDestination, '!/dist/' + slug + '.zip'] );
	done();
});

gulp.task( 'build-notification', function (done) {
	return gulp.src( './' )
	.pipe( notify( { message: 'Your build of Login Designer is complete.', onLast: true } ) );
	done();
});

/**
 * Commands.
 */
gulp.task( 'default', gulp.series( 'clearCache', 'debug_mode_on', 'vendorsJs', 'template_1', 'template_2', 'template_3', 'template_4', 'styles_customize_preview', 'styles_customize_controls', 'styles_intro_js', 'scripts', 'browser_sync', function(done) {

	gulp.watch( projectPHPWatchFiles, gulp.parallel(reload));
	gulp.watch( styleWatchFiles, gulp.parallel('styles_customize_preview'));
	gulp.watch( styleWatchFiles, gulp.parallel('styles_customize_controls'));
	gulp.watch( styleWatchFiles, gulp.parallel('template_1'));
	gulp.watch( styleWatchFiles, gulp.parallel('template_2'));
	gulp.watch( styleWatchFiles, gulp.parallel('template_3'));
	gulp.watch( styleWatchFiles, gulp.parallel('template_4'));
	gulp.watch( scriptWatchFiles, gulp.parallel('scripts'));
	gulp.watch( scriptControlWatchFiles, gulp.parallel('vendorsJs'));

	done();
} ) );

gulp.task(
	'build',
	gulp.series(
		'clearCache',
		'build-clean',
		'template_1',
		'template_2',
		'template_3',
		'template_4',
		'styles_customize_preview',
		'styles_customize_controls',
		'styles_intro_js',
		'scripts',
		'vendorsJs',
		'build-translate',
		'updateVersion',
		'build-copy',
		'build-variables',
		'debug_mode_off',
		'build-zip',
		'build-notification', function(done) {
	done();
} ) );
