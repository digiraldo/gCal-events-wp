const {src, dest, watch, parallel} = require('gulp');
//const {src, dest, watch} = require('gulp');

// CSS ------------------
const sass = require('gulp-sass')(require('sass'));
const plumber = require('gulp-plumber');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');

// Imágenes ------------------
const cache = require('gulp-cache');
const imagemin = require('gulp-imagemin');
const webp = require('gulp-webp');
const avif = require('gulp-avif');

// JavaScript -----------------
const terser = require('gulp-terser-js');

function css(done) {
    src('src/scss/**/*.scss') // Identificar archivo .sass a compilar 'src/scss/app.scss'
        .pipe(sourcemaps.init()) // Guarda la referencia de las lineas de scss en un mapa para editar
        .pipe(plumber()) // Muestra mensaje de error mas corto sin detener la ejecución
        .pipe(sass()) // Compilarlo
        .pipe(postcss([autoprefixer(), cssnano()])) // compila el css a una linea
        .pipe(sourcemaps.write('.')) // Almacena el mapa en el mismo lugar
        .pipe(dest('admin/build/css')) // Almacenarla en el disco duro
    done();  // Callback que avisa a gulp cuando llegamos al final
}

function imagenes(done) {
    const opciones = {
        optimizationLevel: 3
    };
    src('src/img/**/*.{png,jpg}')
        .pipe(plumber()) // Muestra mensaje de error mas corto sin detener la ejecución
        .pipe(cache(imagemin(opciones)))
        .pipe(dest('admin/build/img'))
    done();  // Para que le avise que ya termino todo mi procesamiento
}

function versionWebp(done) {
    const opciones = {
        quality: 50
    };
    src('src/img/**/*.{png,jpg}')
        .pipe(plumber()) // Muestra mensaje de error mas corto sin detener la ejecución
        .pipe(webp(opciones))
        .pipe(dest('admin/build/img'))
    done();
}

function versionAvif(done) {
    const opciones = {
        quality: 50
    };
    src('src/img/**/*.{png,jpg}')
        .pipe(plumber()) // Muestra mensaje de error mas corto sin detener la ejecución
        .pipe(avif(opciones))
        .pipe(dest('admin/build/img'))
    done();
}

function javascript(done) {
     src('src/js/**/*.js')
         .pipe(sourcemaps.init())
         .pipe(plumber()) // Muestra mensaje de error mas corto sin detener la ejecución
         .pipe(terser())
         .pipe(sourcemaps.write('.'))
         .pipe(dest('admin/build/js'))
     done();
}
// 
function dev(done) {
     watch('src/scss/**/*.scss', css);
     // watch('src/scss/app.scss', css);
     watch('src/js/**/*.js', javascript);
    done();
}

exports.css = css;
exports.js = javascript;
exports.imagenes = imagenes;
exports.versionWebp = versionWebp;
exports.versionAvif = versionAvif;
exports.devs = parallel(versionAvif, imagenes, versionWebp, javascript, dev);
//exports.dev = parallel(versionAvif, imagenes, versionWebp, dev);
