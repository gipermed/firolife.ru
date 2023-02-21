'use strict';

const includeContext = {
	IMG_PATH: 'img/',
	FONT: "font-family:'Montserrat',sans-serif;-webkit-text-size-adjust:none;mso-line-height-rule:exactly",
	FONT_ALT: "font-family:'Lato',sans-serif;-webkit-text-size-adjust:none;mso-line-height-rule:exactly",
}

const gulp = require('gulp');
const	watch = require('gulp-watch');
const	imagemin = require('gulp-imagemin');
const	pngquant = require('imagemin-pngquant');
const	htmlmin = require('gulp-htmlmin');
const	rimraf = require('rimraf');
const	fileinclude = require('gulp-file-include');

const path = {
	src: {
		html: 'frontend/*.*',
		img: 'frontend/img/**/*.*',
	},
	dest: {
		html: 'public/',
		img: 'public/img/',
	},
	watch: {
		html: 'frontend/**/*.*',
		img: 'frontend/img/**/*.*',
	},
	clean: './public'
}

gulp.task('clean', function (cb) {
	rimraf(path.clean, cb);
});

gulp.task('html', function(){
	return gulp.src(path.src.html)
	.pipe(fileinclude({
		prefix: '@@',
		basepath: 'frontend/templates/',
		indent: true,
		context: includeContext
	 }))
	.pipe(gulp.dest(path.dest.html))
});

gulp.task('html:min', function(){
	return gulp.src(path.src.html)
	.pipe(fileinclude({
      prefix: '@@',
      basepath: 'frontend/templates/',
		indent: true,
		context: includeContext
    }))
	.pipe(htmlmin({
		collapseWhitespace: true,
		minifyJS: true,
		minifyCSS: true
	}))
	.pipe(gulp.dest(path.dest.html))
});

gulp.task('img', function () {
	return gulp.src(path.src.img, {cwd: process.cwd()})
	.pipe(gulp.dest(path.dest.img, {cwd: process.cwd()}))
});

gulp.task('img:min', function () {
	return gulp.src(path.src.img, {cwd: process.cwd()})
	.pipe(imagemin({
		progressive: true,
		svgoPlugins: [{
			removeViewBox: false
		}],
		use: [pngquant()],
		interlaced: true
	}))
	.pipe(gulp.dest(path.dest.img, {cwd: process.cwd()}))
});

gulp.task('watch', function () {
	gulp.watch(path.watch.html, gulp.task('html'));
	gulp.watch(path.watch.img, gulp.task('img'));
});

gulp.task('default', gulp.series('clean', 'html', 'img', 'watch'));
gulp.task('min', gulp.series('clean', 'html:min', 'img:min'));
gulp.task('build', gulp.series('clean', 'html', 'img:min',));