const path = require('path')
const HTMLWebpackPlugin = require('html-webpack-plugin')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')

module.exports = {
    mode: 'development',
    entry: './dev-app/src/index.js',
    output: {
        filename: '[contenthash].bundle.js',
        path: path.resolve(__dirname, 'build-app'),
        publicPath: '/build-app/'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: '/node_modules/',
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    },
    plugins: [
        new HTMLWebpackPlugin({
            template: './dev-app/public/index.html'
        }),
        new CleanWebpackPlugin()
    ]
}