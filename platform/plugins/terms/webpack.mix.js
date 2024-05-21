let mix = require('laravel-mix')

const path = require('path')
let directory = path.basename(path.resolve(__dirname))

const source = 'platform/plugins/' + directory
const dist = 'public/vendor/core/plugins/' + directory

mix
    .sass(source + '/resources/assets/sass/terms.scss', dist + '/css')
    .js(source + '/resources/assets/js/terms.js', dist + '/js')

if (mix.inProduction()) {
    mix
        .copy(dist + '/css/terms.css', source + '/public/css')
        .copy(dist + '/js/terms.js', source + '/public/js')
}
