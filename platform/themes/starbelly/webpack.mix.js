let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/themes/' + directory;
const dist = 'public/themes/' + directory;

mix
    .sass(source + '/assets/sass/style.scss', dist + '/css')
    .js(source + '/assets/js/script.js', dist + '/js')
    .js(source + '/assets/js/app.js', dist + '/js')
    .js(source + '/assets/js/icons-field.js', dist + '/js')
    .js(source + '/assets/js/ecommerce.js', dist + '/js');

if (mix.inProduction()) {
    mix
        .copy(dist + '/css/style.css', source + '/public/css')
        .copy(dist + '/js/script.js', source + '/public/js')
        .copy(dist + '/js/app.js', source + '/public/js')
        .copy(dist + '/js/icons-field.js', source + '/public/js')
        .copy(dist + '/js/ecommerce.js', source + '/public/js');
}
