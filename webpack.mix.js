const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('resources/js/vendor', 'public/js/vendor')
    .copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/videos', 'public/videos')
    .version();