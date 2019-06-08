let mix = require('laravel-mix');

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

mix.less('sb-admin-2.less')
    .webpack('sb-admin-2.js')
    //.js('resources/assets/js/app.js', 'public/js')
    //.sass('resources/assets/sass/app.scss', 'public/css')
    .copy('vendor/bootstrap', 'public/vendor/bootstrap')
    .copy('vendor/metisMenu', 'public/vendor/metisMenu')
    .copy('vendor/morrisjs', 'public/vendor/morrisjs')
    .copy('vendor/font-awesome', 'public/vendor/font-awesome')
    .copy('vendor/jquery', 'public/vendor/jquery')
    .copy('vendor/raphael', 'public/vendor/raphael')
    .copy('vendor/datatables', 'public/vendor/datatables')
    .copy('vendor/datatables-responsive', 'public/vendor/datatables-responsive')
    .copy('vendor/datatables-plugins', 'public/vendor/datatables-plugins');
