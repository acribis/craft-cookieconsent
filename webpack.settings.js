// webpack.settings.js - webpack settings config

// node modules
require('dotenv').config();

// Webpack settings exports
// noinspection WebpackConfigHighlighting
module.exports = {
    name: 'CookieConsent',
    copyright: 'acribis AG',
    paths: {
        src: {
            base: './src/assetbundles/cookieconsent/src/',
            css: './src/assetbundles/cookieconsent/src/css/',
            js: './src/assetbundles/cookieconsent/src/js/',
        },
        dist: {
            base: './src/assetbundles/cookieconsent/dist/',
            clean: ['./img', './css', './js'],
        },
        templates: './src/templates/',
    },
    urls: {
        publicPath: () => process.env.PUBLIC_PATH || '',
    },
    vars: {
        cssName: 'cookieconsent',
    },
    entries: {
        cookieconsent: 'cookieconsent.js',
    },
    copyWebpackConfig: [],
    devServerConfig: {
        public: () => process.env.DEVSERVER_PUBLIC || 'http://localhost:8080',
        host: () => process.env.DEVSERVER_HOST || 'localhost',
        poll: () => process.env.DEVSERVER_POLL || false,
        port: () => process.env.DEVSERVER_PORT || 8080,
        https: () => process.env.DEVSERVER_HTTPS || false,
    },
    manifestConfig: {
        basePath: '',
    },
    purgeCssConfig: {
        paths: [
            './src/templates/**/*.{twig,html}',
            './src/assetbundles/cookieconsent/src/vue/**/*.{vue,html}',
        ],
        whitelist: [
            './src/assetbundles/cookieconsent/src/css/**/*.{css}',
            './node_modules/cookieconsent/**/*.{css,scss}',
        ],
        whitelistPatterns: [],
        extensions: ['html', 'js', 'twig', 'vue'],
    },
    saveRemoteFileConfig: [],
    createSymlinkConfig: [],
};
