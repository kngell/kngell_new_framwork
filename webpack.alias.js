const path = require("path");
module.exports = {
  moment: path.resolve(__dirname, "node_modules", "moment", "moment"),
  mainjs: path.resolve(__dirname, "public", "assets", "js", "main"),
  corejs: path.resolve(__dirname, "src", "assets", "js", "core"),
  corecss: path.resolve(__dirname, "src", "assets", "css", "core"),
  img: path.resolve(__dirname, "src", "assets", "img"),
  fonts: path.resolve(__dirname, "src", "assets", "fonts"),
  plugins: path.resolve(__dirname, "src", "assets", "plugins"),
  views: path.resolve(__dirname, "src", "views"),
  index: path.resolve(__dirname, "src"),
  entries: path.resolve(__dirname, "src", "entries"),
  js: path.resolve(__dirname, "src", "assets", "js"),
  css: path.resolve(__dirname, "src", "assets", "css"),
};
