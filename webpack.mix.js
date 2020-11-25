const mix = require('laravel-mix');
require('laravel-mix-tailwind');

mix.setPublicPath('./dist');

mix.js('assets/js/app.js', 'js');
mix.sass('assets/scss/app.scss', 'css');
mix.tailwind('./tailwind.config.js');

if (mix.inProduction()) {
    mix.sourceMaps();
}