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

// mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
//     require('postcss-import'),
//     require('tailwindcss'),
// ]);

mix.options({
    extractVueStyles: false,
    processCssUrls: false,
    terser: {},
    purifyCss: false,
    //purifyCss: {},
    postCss: [require("autoprefixer")],
    clearConsole: false,
    cssNano: {
        // discardComments: {removeAll: true},
    }
});

mix.js(["resources/js/app.js","resources/js/bulma.js","resources/js/menu.js"], "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/admin.scss", "public/css")
    .sass("resources/sass/print.scss", "public/css")
    .sourceMaps(true, "source-map")
    .copy("resources/images/*.*", "public/images")
    .copy("./node_modules/simplelightbox/dist/*.*", "public/vendor/simplelightbox");
