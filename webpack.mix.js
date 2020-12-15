const config = require('./webpack.config');
const mix = require('laravel-mix');
require('laravel-mix-eslint');
const path = require('path');

function resolve(dir) {
  return path.join(
    __dirname,
    '/resources/js',
    dir
  );
}

Mix.listen('configReady', webpackConfig => {
  // Add "svg" to image loader test
  const imageLoaderConfig = webpackConfig.module.rules.find(
    rule =>
      String(rule.test) ===
            String(/(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/)
  );
  imageLoaderConfig.exclude = resolve('icons');
});

mix.webpackConfig(config);
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

mix
  .setPublicPath('./')
  .js('resources/js/app.js', 'public/dist/js')
  .sass('resources/sass/app.scss', 'public/dist/css', {
  // .sass('resources/scss/style.scss', 'public/dist/css', {
    implementation: require('node-sass'),
  })
  .extract([
    'vue',
    'axios',
  ])
  .options({
    processCssUrls: false,
    postCss: [
      require('autoprefixer'),
    ],
  });

if (mix.inProduction()) {
  mix.version();
} else {
  if (process.env.LARAVUE_USE_ESLINT === 'true') {
    mix.eslint();
  }
  // Development settings
  mix
    .sourceMaps()
    .webpackConfig({
      devtool: 'cheap-eval-source-map', // Fastest for development
    });
}
