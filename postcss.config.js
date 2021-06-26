// const ckeditorConfig = styles.getPostCssConfig({});
const normalConfig = {
  parser: "postcss-scss",
  plugins: [
    "postcss-flexbugs-fixes",
    [
      "postcss-grid-kiss",
      {
        autoprefixer: {
          grid: true,
        },
        stage: 3,
        features: {
          "custom-properties": true,
        },
      },
    ],
  ],
};
module.exports = ({ file }) => {
  // if (/ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/.test(file)) {
  //   return ckeditorConfig;
  // }
  return normalConfig;
};

// module.exports = ({ file }) =>
//   /@ckeditor/.test(file) ? ckeditorConfig : normalConfig;

// require("postcss-flexbugs-fixes"),
// autoprefixer({ grid: "autoplace" }),
// postcssPresetEnv({
//   stage: 0,
//   features: {
//     "nesting-rules": true,
//     "custom-properties": false,
//   },
// }),

// const autoprefixer = require("autoprefixer");
// const postcssPresetEnv = require("postcss-preset-env");
