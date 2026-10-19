const mix = require('laravel-mix');
const webpack = require('webpack');

// Date parsing uses explicit formats; no Moment locale bundles are needed.
mix.webpackConfig({
    plugins: [new webpack.IgnorePlugin({resourceRegExp: /^\.\/locale$/, contextRegExp: /moment$/})]
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('resources/js/vendor', 'public/js/vendor')
    // .copyDirectory('resources/fonts', 'public/fonts')
    .copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/audio', 'public/audio')
    .copyDirectory('resources/videos', 'public/videos')
    .version();
