module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
    es6: true,
  },
  parserOptions: {
    parser: "@babel/eslint-parser",
    requireConfigFile: false,
  },
  extends: ["eslint:recommended", "plugin:vue/vue3-recommended", "prettier"],
  plugins: ["vue"],
  rules: {
    "no-unused-vars": "warn",
    "vue/no-unused-vars": "warn",
    "vue/component-name-in-template-casing": ["error", "PascalCase"],
  },
};
