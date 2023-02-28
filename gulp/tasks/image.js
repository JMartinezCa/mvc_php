const { src, dest, series } = require('gulp');

//tools
const { webp, avif, cache, svgmin, imagemin } = require('../tools');

//config
const config = require('../config');

/**
 * Convierte imagenes a formato webp
 * 
 * @param {*} done
 * 
 */
function imgToWebp(done) {
    src(config.img.src)
        .pipe( webp(config.img.properties.quality) )
        .pipe( dest(config.img.dest) );

    done();
}

/**
 * Convierte imagenes a formato avif
 * 
 * @param {*} done
 * 
 */
function imgToAvif(done) {
    src(config.img.src)
        .pipe( avif(config.img.properties.quality) )
        .pipe( dest(config.img.dest) );

    done();
}

/**
 * Minifica los archivos svg
 * 
 * @param {*} done
 * 
 */
function svgMinify(done){
    src(config.img.svg)
        .pipe( svgmin() )
        .pipe( dest(config.img.dest) );
        
    done();
}

/**
 * Reduce el peso de la imagen
 * 
 * @param {*} done
 * 
 */
function optimizeImgSize(done){
    src(config.img.src)
        .pipe( cache(imagemin(config.img.properties.optinizationLevel)) )
        .pipe( dest(config.img.dest) );
        
    done();
}

const imgTasks = series(imgToWebp, imgToAvif, svgMinify, optimizeImgSize);
exports.imgTasks = imgTasks;