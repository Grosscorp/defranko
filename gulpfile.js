/**
 * Gulp config
 *
 * Returning from a task makes that task synchronous
 * if something else depends on it.
 */


// Require packages
var bower = require('bower'),
	es = require('event-stream'),
	fs = require('fs'),
	gulp = require('gulp'),
	autoprefixer = require('gulp-autoprefixer'),
	inject = require('gulp-inject'),
	plumber = require('gulp-plumber'),
	rev = require('gulp-rev'),
	gutil = require('gulp-util'),
	rimraf = require('gulp-rimraf'),
	watch = require('gulp-watch'),
	path = require('path'),
	ngmin = require('gulp-ngmin'),
	concat = require('gulp-concat'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify'),
	shell = require('gulp-shell');

// Setup config
var config = {
	dest: 'public/build/',
	srcdashboard: 'resources/views/',
	srcpublic: 'resources/views/layout-partials/',
	build: {
		dashboard: 'dashboard/',
		public: 'layout-partials/'
	},
	inject: {
		// Change tags for injection due to how Jade is creating them
		starttag: '<!-- inject:app:{{ext}}-->',
		endtag: '<!-- endinject-->',
		// Don't need to read file content, speeds up inject
		read: false,
		ignorePath: 'public'
	},

	injectCss: {
		// Change tags for injection due to how Jade is creating them
		starttag: '<!-- inject:libscss:{{ext}}-->',
		endtag: '<!-- endinject-->',
		// Don't need to read file content, speeds up inject
		read: false,
		ignorePath: 'public'
	},

	injectVendor: {
		starttag: '<!-- inject:vendor:{{ext}}-->',
		endtag: '<!-- endinject-->',
		read: false,
		ignorePath: 'public'
	}
};

// Run `gulp --production`
var isProduction = gutil.env.production;

var onError = function (err) {
	gutil.beep();
	console.log(err.message);
};

// Run Dashboard
// ------------------------------------
gulp.task('dashboard_clean', function () {
	if (isProduction) {
		return gulp.src([
			config.dest + config.build.dashboard + '*.js',
			config.dest + config.build.dashboard + '*.css'
		], {read: false})
			.pipe(plumber({errorHandler: onError}))
			.pipe(rimraf());
	}
});

gulp.task('dashboard_inject', ['dashboard_clean'], function () {
	var vendor = gulp.src(JSON.parse(fs.readFileSync('./gulp-file-dashboard.json')).vendor_js)
		.pipe(plumber({
			errorHandler: onError
		}))
		.pipe(isProduction ? ngmin() : gutil.noop())
		.pipe(isProduction ? concat('vendor.min.js') : gutil.noop())
		.pipe(isProduction ? uglify() : gutil.noop())
		.pipe(isProduction ? rev() : gutil.noop())
		.pipe(isProduction ? (gulp.dest(config.dest + config.build.dashboard)) : gutil.noop());

	var files = JSON.parse(fs.readFileSync('./gulp-file-dashboard.json')).js;
	if(isProduction) files.push(config.srctpl + 'dashboard.js');
	var scripts = gulp.src(files)
		.pipe(plumber({
			errorHandler: onError
		}))
		.pipe(isProduction ? ngmin() : gutil.noop())
		.pipe(isProduction ? concat('dashboard.min.js') : gutil.noop())
		.pipe(isProduction ? uglify() : gutil.noop())
		.pipe(isProduction ? rev() : gutil.noop())
		.pipe(isProduction ? (gulp.dest(config.dest + config.build.dashboard)) : gutil.noop());

	var styles = gulp.src(JSON.parse(fs.readFileSync('./gulp-file-dashboard.json')).libs_css)
		.pipe(plumber({
			errorHandler: onError
		}))
		.pipe(gutil.noop())
		.pipe(isProduction ? concat('vendor.css') : gutil.noop())
		.pipe(isProduction ? rev() : gutil.noop())
		.pipe(isProduction ? (gulp.dest(config.dest + config.build.dashboard)) : gutil.noop());

	var result = function() {
		gulp.src(config.srcdashboard + 'dashboard.blade.php')
			.pipe(inject(vendor, config.injectVendor))
			.pipe(inject(scripts, config.inject))
			.pipe(inject(styles, config.injectCss))
			.pipe(gulp.dest(config.srcdashboard));
	}();

	return result;
});


// Run Public
// ------------------------------------
gulp.task('public_clean', function () {
	if (isProduction) {
		return gulp.src([
			config.dest + config.build.public + '*.js',
			config.dest + config.build.public + '*.css'
		], {read: false})
			.pipe(plumber({errorHandler: onError}))
			.pipe(rimraf());
	}
});

gulp.task('public_inject', ['public_clean'], function () {
	var vendor = gulp.src(JSON.parse(fs.readFileSync('./gulp-file-public.json')).vendor_js)
		.pipe(plumber({
			errorHandler: onError
		}))
		.pipe(isProduction ? ngmin() : gutil.noop())
		.pipe(isProduction ? concat('vendor.min.js') : gutil.noop())
		.pipe(isProduction ? uglify() : gutil.noop())
		.pipe(isProduction ? rev() : gutil.noop())
		.pipe(isProduction ? (gulp.dest(config.dest + config.build.public)) : gutil.noop());

	var files = JSON.parse(fs.readFileSync('./gulp-file-public.json')).js;
	if(isProduction) files.push(config.srctpl + 'public.js');
	var scripts = gulp.src(files)
		.pipe(plumber({
			errorHandler: onError
		}))
		.pipe(isProduction ? ngmin() : gutil.noop())
		.pipe(isProduction ? concat('public.min.js') : gutil.noop())
		.pipe(isProduction ? uglify() : gutil.noop())
		.pipe(isProduction ? rev() : gutil.noop())

		.pipe(isProduction ? (gulp.dest(config.dest + config.build.public)) : gutil.noop());

	var styles = gulp.src(JSON.parse(fs.readFileSync('./gulp-file-public.json')).libs_css)
		.pipe(plumber({
			errorHandler: onError
		}))
		.pipe(gutil.noop())
		.pipe(isProduction ? concat('vendor.css') : gutil.noop())
		.pipe(isProduction ? rev() : gutil.noop())
		.pipe(isProduction ? (gulp.dest(config.dest + config.build.public)) : gutil.noop());

	var result = function() {
		gulp.src(config.srcpublic + 'scripts.blade.php')
			.pipe(inject(vendor, config.injectVendor))
			.pipe(inject(scripts, config.inject))
			.pipe(gulp.dest(config.srcpublic));

		gulp.src(config.srcpublic + 'head.blade.php')
			.pipe(inject(styles, config.injectCss))
			.pipe(gulp.dest(config.srcpublic));
	}();

	return result;
});



gulp.task('style_smacss', function () {
	gulp.src('resources/assets/sass/**/*.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest('public/css/'));
});

gulp.task('watch', function () {
	gulp.watch([
		'resources/assets/sass/**/*.scss'
	], ['style_smacss']);
});

//Generating lang files
gulp.task('langJs', shell.task('php artisan lang:js public/js/lang.dist.js -c'));

gulp.task('watch_lang', function () {
	gulp.watch([
		'resources/lang/**/*.php',
		'resources/assets/sass/**/*.scss'
	], ['langJs']);
});


// TPL
// ------------------------------------
gulp.task('tpl', function () {
	gulp.src([
		'!public/css/**',
		'!public/bower_components/**',
		'!public/app/modules/dashboard/**',
		'public/**/*.html'
	])
		.pipe(templateCache({
			module: 'main.templates',
			root: '/' //base: function(file){ return file.path.replace(file.base, '/'); } // Fix template path, add `/`
		}))
		.pipe(gulp.dest('public/app'));
});


gulp.task('default',['dashboard_inject','public_inject', 'style_smacss']);
gulp.task('public',['public_inject', 'style_smacss']);
