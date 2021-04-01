const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
]).sass('resources/sass/webfonts.scss', 'public/css').copy(
    'node_modules/@fortawesome/fontawesome-free/webfonts',
    'public/webfonts'
).copy('node_modules/jdataview/dist/node/jdataview.js', 'public/js/jdataview.js').copy('resources/js/create_content.js', 'public/js/create_content.js');
