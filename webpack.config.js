const path = require('path');
const webpack = require('webpack');
const TerserPlugin = require('terser-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');


module.exports = {
  mode: 'development',

  entry: {
    testing: './src/Testing.js'
  },

  output: {
    filename:'[name].js',
    path: path.resolve(__dirname, 'public/bundle')
  },

  plugins: [new webpack.ProgressPlugin()],

  module: {
    rules: [{
      test: /\.(js|jsx)$/,
      include: [path.resolve(__dirname, 'src')],
      loader: 'babel-loader'
    }]
  },

  optimization: {
    splitChunks: {
      chunks: 'all',
      automaticNameDelimiter : '.',
      cacheGroups: {
        vendors: {
          test: /[\\/]node_modules[\\/]/
        }
      }
    }
  }
}
