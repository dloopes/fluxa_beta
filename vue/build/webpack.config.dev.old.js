/*'use strict'
const { VueLoaderPlugin } = require('vue-loader')
module.exports = {
  mode: 'development',
  entry: [
    './src/app.js'
  ],
  module: {
    rules: [
      {
        test: /\.vue$/,
        use: 'vue-loader'
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin()
  ]
}*/

module.exports = {
   mode: 'development',
    entry: [
      './src/app.js'
    ],  
    resolve: {
    alias: {
      'vue$': './dist/main.js' // 'vue/dist/vue.common.js' for webpack 1
    }
  }
}