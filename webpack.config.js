const path = require('path')
const HTMLWebpackPlugin = require('html-webpack-plugin')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')

module.exports = {
    mode: 'development',
    entry: ['@babel/polyfill', './dev-app/src/index.js'],
    output: {
        filename: '[contenthash].bundle.js',
        path: path.resolve(__dirname, 'build-app'),
        publicPath: '/build-app/'
    },
    performance: {hints: false},
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: '/node_modules/',
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.(css)$/,
                use: ['style-loader', 'css-loader']
            },
            {
                test: /\.(scss)$/,
                use: [{
                  loader: 'style-loader', // inject CSS to page
                }, {
                  loader: 'css-loader', // translates CSS into CommonJS modules
                }, {
                  loader: 'postcss-loader', // Run post css actions
                  options: {
                    plugins: function () { // post css plugins, can be exported to postcss.config.js
                      return [
                        require('precss'),
                        require('autoprefixer')
                      ];
                    }
                  }
                }, {
                  loader: 'sass-loader' // compiles Sass to CSS
                }]
            },
            {
              test: /\.(png|jpe?g|gif|svg)$/i,
              use: ['file-loader'],
            },
        ]
    },
    plugins: [
        new HTMLWebpackPlugin({
            template: './dev-app/public/index.html'
        }),
        new CleanWebpackPlugin()
    ]
}