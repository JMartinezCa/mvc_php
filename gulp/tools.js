//Images
const webp = require('gulp-webp');
const avif = require('gulp-avif');
const cache = require('gulp-cache');
const svgmin = require('gulp-svgmin');
const imagemin = require('gulp-imagemin');

//Css
const sass = require('gulp-sass')(require('sass'));
const cssnano = require('cssnano');
const postcss = require('gulp-postcss');

//Tools
const plumber = require('gulp-plumber');
const autoprefixer = require('autoprefixer');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const browserify = require('browserify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const babelify = require('babelify');
const terser = require('gulp-terser');

module.exports = {
    webp,
    avif,
    cache,
    svgmin,
    imagemin,
    sass,
    cssnano,
    postcss,
    plumber,
    autoprefixer,
    sourcemaps,
    rename,
    browserify,
    source,
    buffer,
    terser,
    babelify
};
