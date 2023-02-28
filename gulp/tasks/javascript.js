const { dest } = require('gulp');

//tools
const { sourcemaps, rename, browserify, source, buffer, terser, babelify } = require('../tools');

//config
const config = require('../config');
const jsFiles = [config.js.rootFiles.main];

/**
 * unifica los archivos de javascript en uno solo y minifica el codigo
 * 
 * @param {*} done
 * 
 */
function minifyJS(done){
    browserify(jsFiles)
    .transform(babelify)
    .bundle()
    .pipe(source('app.js'))
    .pipe( rename({suffix: '.min'}) )
    .pipe(buffer())
    .pipe( sourcemaps.init({ loadMaps: true }) )
    .pipe( terser() )
    .pipe( sourcemaps.write('.'))
    .pipe( dest(config.js.dest) );

    done();
}

exports.minifyJS = minifyJS;