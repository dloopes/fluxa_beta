'use strict'
const { VueLoaderPlugin } = require('vue-loader')
module.exports = {
   resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
    }
  },
  mode: 'development',
  entry: [
    './src/app.js'
  ],
  module: {
    rules: [
      {
        test: /\.vue$/,
        use: 'vue-loader'
      },
       {
        test: /\.css$/,
        use: [
          'vue-style-loader',
          {
            loader: 'css-loader',
            options: {
              // enable CSS Modules
              modules: true,
              // customize generated class names
              localIdentName: '[local]_[hash:base64:8]'
                   }
                 }
             ]
       }
       ]
  },

  plugins: [
    new VueLoaderPlugin()
  ]
}
/*
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
*/