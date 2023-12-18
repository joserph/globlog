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

mix.scripts([
   'node_modules/jquery/dist/jquery.js',
   'resources/js/popper.js',
   'node_modules/bootstrap/dist/js/bootstrap.js',
   'node_modules/admin-lte/dist/js/adminlte.js',
   'node_modules/toastr/toastr.js',
   'node_modules/select2/dist/js/select2.js',
   'node_modules/vue/dist/vue.js',
   'node_modules/axios/dist/axios.js',
   'node_modules/chosen-js/chosen.jquery.js',
   'resources/js/app.js',
   ], 'public/js/app.js')
.sass('resources/sass/app.scss', 'public/css');

/*mix.scripts(['node_modules/jquery/dist/jquery.js',
        'node_modules/popper.js/dist/popper.js',
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'node_modules/admin-lte/dist/js/adminlte.js'], 'public/js/app.js')
.styles(['node_modules/admin-lte/dist/css/adminlte.css',
        'node_modules/admin-lte/dist/css/adminlte.css.map'], 'public/css/app.css');*/

/*mix.js('resources/js/app.js', 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css');*/
