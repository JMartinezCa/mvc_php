const { watch } = require("gulp");

//config
const config = require('../config');

const css = require('./css');
const js = require('./javascript');

/**
 * Vigila cambios en archivos scss y js de la carpeta resouces
 * 
 * @param {*} done
 * 
 */
function watchCompile(done){
    watch(config.scss.src, css.scssToCss);
    watch(config.js.src, js.minifyJS);

    done();
}

exports.watchCompile = watchCompile;