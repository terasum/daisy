const path = require('path');
const webpack = require('webpack');

/*
 * Webpack Plugins
 */
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const CopyWebpackPlugin = require('copy-webpack-plugin');

// take debug mode from the environment
const debug = (process.env.NODE_ENV !== 'production');


const rootAssetPath = path.join(__dirname, 'assets');


module.exports = {
  // configuration
  context: __dirname,
  entry: {
    'js/app.js': './js/app',
    'css/style.css': [
      path.join(__dirname, 'assets', 'less', 'style.less'),
    ],
  },
  output: {
    path: path.join(__dirname, 'build'),
    filename: '[name]',
  },
  resolve: {
    extensions: ['.js', '.css', '.less'],
  },
  devtool: 'source-map',
  devServer: {
    headers: { 'Access-Control-Allow-Origin': '*' },
  },
  module: {
    rules: [
      {
        test: /\.less$/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
        use:[
          {
            loader: "css-loader",
            options: {
              sourceMap: true
            }
          },
          {loader: 'resolve-url-loader'},
          {
            loader: "less-loader",
            options: {
              sourceMap: true
            }
          }
        ]})
      },

      { test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/, 
        loader: 'url-loader',
        options:{
          limit:10000,
          mimetype:'application/font-woff',
          useRelativePath:false,
          name:'[name].[ext]',
          outputPath:'fonts/',
          publicPath: '../fonts'
      }
      },
      { test: /\.(ttf|eot|svg)(\?.*)?$/i,
        loader: `file-loader` ,
        options:{
          useRelativePath:false,
          name:'[name].[ext]',
          outputPath:'fonts/',
          publicPath: '../fonts'
        }
      },
      { test: /\.(png|jpe?g|gif)(\?.*)?$/i,
        loader: `url-loader`,
        options:{
          limit:1024,
          useRelativePath:false,
          name:'[name].[ext]',
          outputPath:'img/',
          publicPath: '../img'
        }
      },
      { test: /\.js$/, exclude: /node_modules/, loader: 'babel-loader', query: { presets: ['env'], cacheDirectory: true } },
    ],
  },
  plugins: [
    new ExtractTextPlugin('css/style.css'),
    new CopyWebpackPlugin([
      {from:'assets/img',to:'img'} 
  ]), 
    new webpack.ProvidePlugin({ $: 'jquery', jQuery: 'jquery' }),
  ].concat(debug ? [] : [
    // production webpack plugins go here
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: JSON.stringify('production'),
      },
    }),
  ]),
};