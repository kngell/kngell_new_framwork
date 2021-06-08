const webpack = require("webpack");
const path = require("path");
// const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const DelWebpackPlugin = require("del-webpack-plugin");
const AssetsPlugin = require("assets-webpack-plugin");
const FileManagerPlugin = require("filemanager-plugin").WebpackFilemanager;
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");

const ASSET_PATH =
  process.env.ASSET_PATH ||
  `${path.sep}kngell${path.sep}public${path.sep}assets${path.sep}`;
module.exports = {
  plugins: [
    new DelWebpackPlugin({
      include: ["*.js", "*.css"], //"*.js",
      info: true,
      keepGeneratedAssets: true,
      allowExternal: true,
    }),
    new AssetsPlugin({
      filename: "assets.json",
      includeManifest: "manifest",
      path: path.join(__dirname, "app"),
      processOutput: function (assets) {
        return JSON.stringify(assets);
      },
      includeAllFileTypes: false,
      fileTypes: ["js", "css"],
      integrity: true,
    }),
    new webpack.IgnorePlugin({
      resourceRegExp: /^\.\/locale$/,
      contextRegExp: /moment$/,
    }),
    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
      "window.jQuery": "jquery",
      "global.jQuery": "jquery",
      Popper: "@popperjs/core",
    }),
    new webpack.DefinePlugin({
      "process.env.ASSET_PATH": JSON.stringify(ASSET_PATH),
    }),
    new BrowserSyncPlugin({
      host: "localhost",
      port: 3003,
      proxy: "localhost:80/kngell_ecommerce/home",
      browser: "chrome",
    }),
    // new CKEditorWebpackPlugin({ language: "fr" }),
    new FileManagerPlugin({
      events: {
        end: {
          copy: {
            items: [
              {
                source: path.resolve(__dirname, "src", ".htaccess"),
                destination: "./public/",
              },
              {
                source: path.join(__dirname, "src", "index.php"),
                destination: "./public/",
              },
              {
                source: path.join(__dirname, "src", "assets", "img", "users"),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(__dirname, "src", "assets", "img", "clothes"),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(__dirname, "src", "assets", "img", "shop"),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(__dirname, "src", "assets", "img", "watches"),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(__dirname, "src", "assets", "img", "insta"),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(__dirname, "src", "assets", "img", "brand"),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(
                  __dirname,
                  "src",
                  "assets",
                  "img",
                  "arrivals"
                ),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(
                  __dirname,
                  "src",
                  "assets",
                  "img",
                  "featured"
                ),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(__dirname, "src", "assets", "img", "camera"),
                destination: "./public/assets/img/",
              },
              {
                source: path.join(
                  __dirname,
                  "src",
                  "assets",
                  "img",
                  "products"
                ),
                destination: "./public/assets/img/",
              },
            ],
          },
          // del: {
          //   items: ['./dist']
          // }
        },
      },
    }),
  ],
};
