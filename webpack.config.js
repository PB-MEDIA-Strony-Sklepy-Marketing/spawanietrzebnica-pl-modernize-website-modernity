const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');

const isDevelopment = process.env.NODE_ENV !== 'production';

module.exports = {
  mode: isDevelopment ? 'development' : 'production',
  devtool: isDevelopment ? 'source-map' : false,
  
  entry: {
    // Główne pliki
    'frontend': './wp-content/themes/spawanie-trzebnica/assets/src/js/frontend.js',
    'admin': './wp-content/themes/spawanie-trzebnica/assets/src/js/admin.js',
    'wpbakery': './wp-content/themes/spawanie-trzebnica/assets/src/js/wpbakery.js',
    
    // Style
    'style': './wp-content/themes/spawanie-trzebnica/assets/src/scss/style.scss',
    'admin-style': './wp-content/themes/spawanie-trzebnica/assets/src/scss/admin.scss',
    'critical': './wp-content/themes/spawanie-trzebnica/assets/src/scss/critical.scss',
  },
  
  output: {
    path: path.resolve(__dirname, 'wp-content/themes/spawanie-trzebnica/assets/dist'),
    filename: 'js/[name].[contenthash:8].js',
    clean: true,
  },
  
  module: {
    rules: [
      // JavaScript
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              ['@babel/preset-env', {
                targets: '> 0.25%, not dead',
                useBuiltIns: 'usage',
                corejs: 3,
              }],
            ],
            plugins: [
              '@babel/plugin-proposal-class-properties',
              '@babel/plugin-syntax-dynamic-import',
            ],
          },
        },
      },
      
      // SCSS/CSS
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          isDevelopment ? 'style-loader' : MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              sourceMap: isDevelopment,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  require('autoprefixer'),
                  require('postcss-preset-env')({
                    stage: 3,
                    features: {
                      'custom-properties': false,
                    },
                  }),
                  !isDevelopment && require('cssnano')({
                    preset: ['default', {
                      discardComments: {
                        removeAll: true,
                      },
                    }],
                  }),
                ].filter(Boolean),
              },
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: isDevelopment,
              sassOptions: {
                outputStyle: isDevelopment ? 'expanded' : 'compressed',
              },
            },
          },
        ],
      },
      
      // Obrazy
      {
        test: /\.(png|jpe?g|gif|svg|webp)$/i,
        type: 'asset/resource',
        generator: {
          filename: 'images/[name].[contenthash:8][ext]',
        },
      },
      
      // Fonty
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/i,
        type: 'asset/resource',
        generator: {
          filename: 'fonts/[name].[contenthash:8][ext]',
        },
      },
    ],
  },
  
  plugins: [
    new CleanWebpackPlugin(),
    
    new MiniCssExtractPlugin({
      filename: 'css/[name].[contenthash:8].css',
    }),
    
    // Kopiowanie statycznych plików
    new CopyPlugin({
      patterns: [
        {
          from: 'wp-content/themes/spawanie-trzebnica/assets/src/images',
          to: 'images',
          noErrorOnMissing: true,
        },
        {
          from: 'wp-content/themes/spawanie-trzebnica/assets/src/fonts',
          to: 'fonts',
          noErrorOnMissing: true,
        },
      ],
    }),
    
    // BrowserSync dla development
    isDevelopment && new BrowserSyncPlugin({
      proxy: 'http://localhost:8080',
      files: [
        'wp-content/themes/spawanie-trzebnica/**/*.php',
        'wp-content/themes/spawanie-trzebnica/assets/dist/**/*',
      ],
      reloadDelay: 0,
    }, {
      reload: false,
    }),
  ].filter(Boolean),
  
  optimization: {
    minimize: !isDevelopment,
    minimizer: [
      new TerserPlugin({
        terserOptions: {
          compress: {
            drop_console: !isDevelopment,
          },
        },
      }),
      new CssMinimizerPlugin(),
      new ImageMinimizerPlugin({
        minimizer: {
          implementation: ImageMinimizerPlugin.imageminMinify,
          options: {
            plugins: [
              ['imagemin-gifsicle', { interlaced: true }],
              ['imagemin-mozjpeg', { progressive: true, quality: 75 }],
              ['imagemin-pngquant', { quality: [0.6, 0.8] }],
              ['imagemin-svgo', {
                plugins: [{
                  name: 'preset-default',
                  params: {
                    overrides: {
                      removeViewBox: false,
                    },
                  },
                }],
              }],
            ],
          },
        },
        generator: [
          {
            type: 'asset',
            preset: 'webp-custom-name',
            implementation: ImageMinimizerPlugin.imageminGenerate,
            options: {
              plugins: ['imagemin-webp'],
            },
          },
        ],
      }),
    ],
    
    splitChunks: {
      chunks: 'all',
      cacheGroups: {
        vendors: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendors',
          priority: 10,
        },
        common: {
          minChunks: 2,
          priority: 5,
          reuseExistingChunk: true,
        },
      },
    },
  },
  
  performance: {
    hints: !isDevelopment ? 'warning' : false,
    maxEntrypointSize: 512000,
    maxAssetSize: 512000,
  },
};