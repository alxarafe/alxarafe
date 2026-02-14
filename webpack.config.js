const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    // Define multiple entry points
    entry: {
        'js/resource.bundle': './src/Frontend/ts/resource.ts',
        'themes/cyberpunk/css/default': './templates/themes/cyberpunk/scss/default.scss'
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "sass-loader",
                ],
            },
        ],
    },
    resolve: {
        extensions: ['.tsx', '.ts', '.js', '.scss'],
    },
    output: {
        // Output format follows the keys in 'entry'
        filename: '[name].js',
        path: path.resolve(__dirname, 'skeleton/public'),
        library: 'AlxarafeResource',
        libraryTarget: 'umd',
        // Clean previous builds in these paths? No, let's keep it simple for now.
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "[name].css", // Results in themes/cyberpunk/css/default.css
        }),
    ],
    mode: 'production',
    watchOptions: {
        poll: 1000,
        ignored: /node_modules/,
    },
};
