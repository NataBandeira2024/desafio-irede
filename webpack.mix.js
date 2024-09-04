const mix = require('laravel-mix');
const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

mix.js('resources/js/app.js', 'public/js')
   .vue({ version: 3 })
   .sass('resources/sass/app.scss', 'public/css');

mix.webpackConfig({
    plugins: [
        new VueLoaderPlugin()
    ],
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        }
    },
    resolve: {
        fallback: {
            "stream": require.resolve("stream-browserify"),
            "path": require.resolve("path-browserify"),
            "fs": false,
            "assert": require.resolve("assert/"),
        },
        extensions: ['.js', '.vue', '.json']
    }
});
