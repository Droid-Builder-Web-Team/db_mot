const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue().version();

mix.sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/cards.scss', 'public/css')
    .sass('resources/sass/sidebar.scss', 'public/css')
    .sass('resources/sass/partsrun.scss', 'public/css')
    .sass('resources/sass/modals.scss', 'public/css')
    .sass('resources/sass/buttons.scss', 'public/css').version();
