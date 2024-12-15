const path = require('path');

module.exports = {
  context:__dirname,
  entry:{
    manageMember:'./managemembers_plugin/ts/manageMembers.ts',
    registerMember:'./managemembers_plugin/ts/registerMember.ts'
  },
  output: {
    filename: '[name].bundle.js',  
    path: path.resolve(__dirname, 'dist'),
    publicPath:'/dist'
  },
  module:{
    rules:[
      {
        test:/\.ts$/,
        exclude:/node_modules/,
        use:{
          loader:'ts-loader'
        }
      },
      {
        test: /\.css$/,
        use: [ 'style-loader', 'css-loader' ]
      }
    ]
  },
  performance: {
    hints: false,
    maxEntrypointSize: 512000,
    maxAssetSize: 512000
},
  resolve:{
    extensions: ['.ts','.js']
  },

};
