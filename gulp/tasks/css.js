const { src, dest } = require('gulp');

//tools
const { autoprefixer, rename, sourcemaps, plumber, cssnano, sass, postcss } = require('../tools');

//config
const config = require('../config');

/**
 * Compila los archivos sass a css
 * 
 * @param {*} done 
 */
function scssToCss(done) {
    src(config.scss.src)
        .pipe( sourcemaps.init() )
        .pipe( plumber() )
        .pipe( sass().on('error', sass.logError) )
        .pipe( postcss([autoprefixer(), cssnano()]) )
        .pipe( rename({ suffix: '.min' }) )
        .pipe( sourcemaps.write('.') )
        .pipe( dest(config.scss.dest) );

    done();    
}

exports.scssToCss = scssToCss;