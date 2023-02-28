const src = 'resources';
const dest = 'public';

module.exports = {
    js: {
        src: `${src}/js/**/*.js`,
        dest: `${dest}/js`,
        rootFiles: {
            main: `${src}/js/app.js`,
            folder: `${src}/js/`
        }
    },
    scss: {
        src: `${src}/scss/**/*.scss`,
        dest: `${dest}/css`
    },
    img: {
        src: `${src}/assets/img/**/*.{png,jpg}`,
        svg: `${src}/assets/img/**/*.svg`,
        dest: `${dest}/assets/img`,
        properties: {
            quality: { 
                quality: 50 
            },
            optinizationLevel: { 
                optinizationLevel: 3 
            }
        }
    }
};