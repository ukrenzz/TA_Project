const path = require('path');
const webpack = require('webpack');
const TerserPlugin = require('terser-webpack-plugin');


module.exports = {
  mode: 'development',

  entry: {
    testing: './src/Testing.js'
  },

  output: {
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
    minimizer: [new TerserPlugin()],

    splitChunks: {
      cacheGroups: {
        vendors: {
          priority: -10,
          test: /[\\/]node_modules[\\/]/
        }
      },

      chunks: 'async',
      minChunks: 1,
      minSize: 30000,
      name: false
    }
  }
}
