const path = require('path');

module.exports = {
    entry: './src/Frontend/ts/resource.ts',
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
        ],
    },
    resolve: {
        extensions: ['.tsx', '.ts', '.js'],
    },
    output: {
        filename: 'resource.bundle.js',
        path: path.resolve(__dirname, 'skeleton/public/js'),
        library: 'AlxarafeResource',
        libraryTarget: 'umd',
    },
    mode: 'production',
    watchOptions: {
        poll: 1000, // Check for changes every second
        ignored: /node_modules/,
    },
};
