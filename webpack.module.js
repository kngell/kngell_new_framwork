const path = require("path");
const devMode = process.env.NODE_ENV !== "production";
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
//=======================================================================
//Rules
//=======================================================================
module.exports = {
  rules: [
    {
      test: /\.js$/,
      exclude: [/node_modules/, path.resolve(__dirname, "plugins", "modules")],
      loader: "babel-loader",
      options: {},
    },
    {
      test: /\.(php)$/i,
      include: [path.resolve(__dirname, "src", "views")],
      // type: "asset/resource",
      // generator: {
      //   filename: "../../app/views/home/[name][ext][query]",
      // },
      use: [
        {
          loader: "file-loader",
          options: {
            name: "[path][name].[ext]",
            context: "src/views",
          },
        },
        {
          loader: "extract-loader",
          options: {
            publicPath: "../",
          },
        },
        {
          loader: "html-loader",
          options: {
            sources: true,
            esModule: false,
          },
        },
      ],
    },
    {
      test: /\.s[ac]ss$/i,
      use: [
        {
          loader: MiniCssExtractPlugin.loader,
          options: {
            publicPath: "/",
          },
        },
        {
          loader: "css-loader",
        },
        {
          loader: "postcss-loader",
        },
        {
          loader: "sass-loader",
        },
      ],
    },
    {
      test: /\.css$/,
      use: [
        {
          loader: MiniCssExtractPlugin.loader,
          options: {
            publicPath: "/",
          },
        },
        {
          loader: "css-loader",
        },
        {
          loader: "postcss-loader",
        },
      ],
    },
    {
      test: /\.(png|svg|jpg|gif|ico)$/,
      exclude: [
        /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
        /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css/,
      ],
      // type: "asset/resource",
      // generator: {
      //   filename: "../../public/assets/img/[name][ext][query]",
      // },
      use: {
        loader: "file-loader",
        options: {
          name: devMode ? "[name].[ext]" : "[name].[hash].[ext]",
          outputPath: "../../public/assets/img",
          publicPath: (url) => {
            return "/kngell_ecommerce/public/assets/img/" + url;
          },
        },
      },
    },
    {
      test: /.(ttf|otf|eot|woff(2)?)(\?[a-z0-9]+)?$/,
      // type: "asset/resource",
      // generator: {
      //   filename: "fonts/[name][ext][query]",
      // },
      use: [
        {
          loader: "file-loader",
          options: {
            name: "[name].[ext]",
            outputPath: "fonts/",
            publicPath: "/kngell_ecommerce/public/assets/fonts/",
          },
        },
      ],
    },

    {
      test: /\.svg$/,
      include: [
        /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
        /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css/,
      ],
      use: [
        {
          loader: "raw-loader",
          options: {},
        },
      ],
    },
  ],
};
