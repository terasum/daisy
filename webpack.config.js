const path = require('path');
const webpack = require('webpack');

/*
 * Webpack Plugins
 */
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const CopyWebpackPlugin = require('copy-webpack-plugin');

// take debug mode from the environment
const debug = (process.env.NODE_ENV !== 'production');

module.exports = {
  // configuration
  context: __dirname,
  entry: {
    'js/app.js': './js/app',
    'css/style.css': [
      path.join(__dirname, 'assets', 'less', 'style.less'),
    ],
    // 'img/*':'./assets/img/*',
  },
  output: {
    path: path.join(__dirname, 'build'),
    filename: '[name]',
    chunkFilename: '[id]',
  },
  resolve: {
    extensions: ['.js', '.css', '.less'],
  },
  devtool: 'source-map',
  devServer: {
    headers: { 'Access-Control-Allow-Origin': '*' },
  },
  module: {
    loaders: [
      { test: /\.html$/, loader: 'raw-loader' },
      // { test: /\.less$/, loader: ExtractTextPlugin.extract({ fallback: 'style-loader', use: 'css-loader!less-loader' }) },
      // { test: /\.css$/, loader: ExtractTextPlugin.extract({ fallback: 'style-loader', use: 'css-loader' }) },

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
          useRelativePath:true,
          mimetype:'application/font-woff',
          name:'[name].[ext]',
          outputPath:'build/fonts/',
          // publicPath: 'build/'
      }
      },
      { test: /\.(ttf|eot|svg)(\?.*)?$/i,
        loader: `file-loader` ,
        options:{
          useRelativePath:true,
          name:'[name].[ext]',
          outputPath:'build/fonts/',
          // publicPath: 'build/'
        }
      },
      { test: /\.(png|jpe?g|gif)(\?.*)?$/i,
        loader: `file-loader`,
        options:{
          useRelativePath:true,
          name:'[name].[ext]',
          outputPath:'build/img/',
          // publicPath: 'build/'
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