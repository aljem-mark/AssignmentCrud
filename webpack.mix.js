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
        .js('resources/assets/js/font-awesome.js', 'public/js')
        .js('resources/assets/js/scripts.js', 'public/js')
        .sass('resources/sass/app.scss', 'public/css')
        .js('custom_assets/bootstrap-editable/js/bootstrap-editable.js', 'public/js')
    .sass('custom_assets/bootstrap-editable/scss/bootstrap-editable.scss', 'public/css');
