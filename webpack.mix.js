const {mix} = require('laravel-mix');

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


mix.js('resources/assets/js/app.js', 'public/js/app.js')
    .js('resources/assets/js/admin.js', 'public/js/admin.js')
    .js('resources/assets/js/home.js', 'public/js/home.js')
    .sass('resources/assets/sass/home.scss', 'public/css/home.css')
    .sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .sass('resources/assets/sass/admin/admin.scss', 'public/css/admin.css')
    .version();
