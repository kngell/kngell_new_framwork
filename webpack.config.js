const path = require("path");
const webpack = require("webpack");
const wp_alias = require("./webpack.alias");
const common_rules = require("./webpack.module");
const common_plugins = require("./webpack.plugins");
const devMode = process.env.NODE_ENV !== "production";
const ASSET_PATH =
  process.env.ASSET_PATH ||
  `${path.sep}kngell_ecommerce${path.sep}public${path.sep}assets${path.sep}`;

const { merge } = require("webpack-merge");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const frontendEntries = require("./src/entries/assets/frontend/frontendEntries");
const {
  membersCssEntries,
  membersJsEntries,
} = require("./src/entries/assets/backend/members/MembersEntries");
const adminEntries = require("./src/entries/assets/backend/admin/adminEntries");
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
const FileManagerPlugin = require("filemanager-plugin").WebpackFilemanager;
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const HtmlWebpackPlugin = require("html-webpack-plugin");

//=======================================================================
//Common config
//=======================================================================
const commonConfig = merge(common_plugins, {
  context: path.resolve(__dirname),
  mode: "development",
  devtool: false,
  resolve: { alias: wp_alias },
  output: {
    filename: devMode ? "[name].js" : "[name]_[fullhash].js",
    assetModuleFilename: devMode ? "[name][ext][query]" : "[hash][ext][query]",
    publicPath: ASSET_PATH,
    library: "kngell",
    libraryTarget: "umd",
  },
  module: common_rules,
  // plugins: [common_plugins],
});
//=======================================================================
//Server
//=======================================================================
let server = {
  devServer: {
    hot: true, // this enables hot reload
    inline: true, // use inline method for hmr
    host: "localhost",
    port: 8080,
    contentBase: path.join(__dirname, "public"), // should point to the laravel public folder
    watchOptions: {
      poll: false, // needed for homestead/vagrant setup
    },
  },
};
//=======================================================================
//Views config
//=======================================================================
var viewsConfig = Object.assign({}, commonConfig, {
  entry: "entries/views/views", //PhpConfig.entries, //"entries/views/views",
  output: {
    path: path.resolve(__dirname, "app", "views"),
    filename: "[name].js",
  },
});
//=======================================================================
//Assets Config
//=======================================================================

//frontend
const fontendAssetsConfig = merge(frontendEntries, commonConfig, server, {
  entry: {
    "css/librairies/frontlib": "./src/assets/css/lib/frontlib.scss",
    "js/librairies/frontlib": "./src/assets/js/lib/frontlib",
  },
  output: {
    path: path.resolve(__dirname, "public", "assets"),
    chunkFilename: devMode
      ? "lazyload/js/home/[name].js"
      : "lazyload/js/home/[name]_[chunkhash].js",
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: devMode ? "[name].css" : "[name].[contenthash].css",
      chunkFilename: devMode
        ? "lazyload/css/home/[name].css"
        : "lazyload/css/home/[name]_[chunkhash].css",
    }),
  ],
  optimization: {
    splitChunks: {
      cacheGroups: {
        homeCommonVendor: {
          test: /[\\/]node_modules[\\/]((?!@ckeditor).*)[\\/]/, //except ckeditor5
          name: "commons/frontend/commonVendor",
          chunks: "initial",
          minSize: 20000,
          priority: -10,
          minChunks: 2,
          reuseExistingChunk: true,
        },
        homeCustomModules: {
          test: /[\\/]((admin).*)|((core).*)[\\/]/,
          name: "commons/frontend/commonCustomModules",
          chunks: "initial",
          minSize: 10000,
          minChunks: 2,
          priority: -20,
          reuseExistingChunk: true,
        },
      },
    },
  },
});
//backend members
var membersAssetsConfig = merge(
  membersCssEntries,
  membersJsEntries,
  commonConfig,
  {
    entry: {
      "css/librairies/memberslib": "./src/assets/css/lib/memberslib.scss",
      "js/librairies/memberslib": "./src/assets/js/lib/memberslib",
    },
    output: {
      path: path.resolve(__dirname, "public", "assets"),
      chunkFilename: devMode
        ? "lazyload/js/members/[name].js"
        : "lazyload/js/members/[name]_[chunkhash].js",
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: devMode ? "[name].css" : "[name].[contenthash].css",
        chunkFilename: devMode
          ? "lazyload/css/members/[name].css"
          : "lazyload/css/members/[name]_[chunkhash].css",
      }),
    ],
    optimization: {
      splitChunks: {
        cacheGroups: {
          members: {
            test: /[\\/]node_modules|((members).*)|((core).*)[\\/]/,
            name: "commons/members",
            chunks: "initial",
            minSize: 20000,
            minChunks: 2,
            reuseExistingChunk: true,
          },
        },
      },
    },
  }
);
//backend admin
var adminAssetsConfig = merge(adminEntries, commonConfig, {
  entry: {
    "css/librairies/adminlib": "./src/assets/css/lib/adminlib.scss",
    "js/librairies/adminlib": "./src/assets/js/lib/adminlib",
  },
  output: {
    path: path.resolve(__dirname, "public", "assets"),
    chunkFilename: devMode
      ? "lazyload/js/admin/[name].js"
      : "lazyload/js/admin/[name]_[chunkhash].js",
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: devMode ? "[name].css" : "[name].[contenthash].css",
      chunkFilename: devMode
        ? "lazyload/css/admin/[name].css"
        : "lazyload/css/admin/[name]_[chunkhash].css",
    }),
  ],
  externals: {
    moment: "moment",
  },
  optimization: {
    splitChunks: {
      cacheGroups: {
        adminCommonVendor: {
          test: /[\\/]node_modules[\\/]((?!@ckeditor).*)[\\/]/, //except ckeditor5
          name: "commons/backend/admin/commonVendor",
          chunks: "initial",
          minSize: 10000,
          priority: -10,
          minChunks: 2,
          reuseExistingChunk: true,
        },
        adminCustomModules: {
          test: /[\\/]((admin).*)|((core).*)|((plugins).*)[\\/]/,
          name: "commons/backend/admin/commonCustomModules",
          chunks: "initial",
          minSize: 10000,
          minChunks: 2,
          priority: -20,
          reuseExistingChunk: true,
        },
        styles: {
          test: /[\\/]((node_modules).*)|((plugins).*)[\\/]((?!@ckeditor).*)[\\/]/,
          name: "commons/backend/admin/commoncss",
          type: "css/mini-extract",
          chunks: "initial",
          minSize: 10000,
          minChunks: 2,
          reuseExistingChunk: true,
        },
      },
    },
  },
});

//Dev config
const developmentConfig = {
  plugins: [
    new RemoveEmptyScriptsPlugin({ verbose: true }),
    new webpack.SourceMapDevToolPlugin({}),
  ],
};
// Prod Config
const productionConfig = {
  plugins: [
    new RemoveEmptyScriptsPlugin({}),
    new FileManagerPlugin({
      events: {
        start: {
          del: {
            items: [path.join(__dirname, "public", "assets")],
          },
        },
      },
    }),
    new ImageMinimizerPlugin({
      minimizerOptions: {
        plugins: [
          ["gifsicle", { interlaced: true }],
          ["jpegtran", { progressive: true }],
          ["optipng", { optimizationLevel: 5 }],
          [
            "svgo",
            {
              plugins: [
                {
                  removeViewBox: false,
                },
              ],
            },
          ],
        ],
      },
    }),
    new webpack.SourceMapDevToolPlugin({
      filename: "sourcemaps/[file].map",
      publicPath: ASSET_PATH,
      fileContext: "public",
    }),
  ],
  optimization: {
    minimize: true,
    minimizer: [
      new CssMinimizerPlugin({
        parallel: true,
        minimizerOptions: {
          preset: [
            "default",
            {
              discardComments: { removeAll: true },
            },
          ],
        },
      }),
      new TerserPlugin({
        exclude: [path.resolve(__dirname, "node_modules")],
        terserOptions: {
          format: {
            comments: false,
          },
        },
        extractComments: false,
      }),
    ],
    // usedExports: true,
  },
};

module.exports = () => {
  switch (process.env.NODE_ENV) {
    case "development":
      return [
        merge(viewsConfig, developmentConfig),
        merge(fontendAssetsConfig, developmentConfig),
        merge(membersAssetsConfig, developmentConfig),
        merge(adminAssetsConfig, developmentConfig),
      ];
    case "production":
      return [
        merge(viewsConfig, productionConfig),
        merge(fontendAssetsConfig, productionConfig),
        merge(membersAssetsConfig, productionConfig),
        merge(adminAssetsConfig, productionConfig),
      ];
    default:
      throw new Error("No matching configuration was found!");
  }
};
