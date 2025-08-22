const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/sound_cache.js', 'public/')
    // Compile Tailwind (dengan autoprefixer otomatis)
    .postCss('resources/css/app.css', 'public/css', [
        require("@tailwindcss/postcss")
    ])
    // CSS tambahan tanpa Tailwind
    .postCss('resources/css/locket.css', 'public/css', [
    ]);


mix.webpackConfig({
    watchOptions: {
        ignored: /node_modules|dist|mix-manifest.json|public|storage|vendor/,
        aggregateTimeout: 200, // delay sebelum recompile (ms)
        poll: 1000 // cek perubahan tiap 1 detik
    }
});

// Hilangkan notifikasi build (lebih clean)
mix.disableNotifications();
