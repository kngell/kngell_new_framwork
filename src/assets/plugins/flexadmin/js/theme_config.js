import AppConfig from './app_config.js';

class ThemeConfig {
  constructor() {}

  init = () => {
    this._setThemeColor();
    this._setThemeMode();
    this._changeThemeColor();
    this._changeThemeMode();
    this._resetSetting();
  }

  _setThemeColor = () => {
    if (AppConfig.getConfig().themeColor) {
      $('body').attr('data-theme-color',AppConfig.getConfig().themeColor);
      $(`.theme-colors a[data-theme-color= ${AppConfig.getConfig().themeColor}]`).addClass('active');
    }
  }

  _setThemeMode = () => {
    if (AppConfig.getConfig().themeMode == 'dark-mode') {
      $(`.theme-modes .theme-mode-config[data-theme-mode= ${AppConfig.getConfig().themeMode}]`).addClass('active');
    } else {
      $(".theme-modes .theme-mode-config[data-theme-mode= default-mode]").addClass('active');
    }
  }

  _changeThemeColor = () => {
    let self = this;
    $('.theme-colors a').on('click', function() {
      let color = $(this).data('theme-color');
      $('.theme-colors a').removeClass('active');
      $(this).addClass('active');
      $('body').attr('data-theme-color', color);
      AppConfig.setConfig({ themeColor: color });
    });
  }

  _changeThemeMode = () => {
    let self = this;
    $('.theme-modes .theme-mode-config').on('click', function() {
      let themeMode = $(this).data('theme-mode');
      $('.theme-modes .theme-mode-config').removeClass('active');
      $(this).addClass('active');
      AppConfig.setConfig({ themeMode: themeMode });
      $('body').attr('data-theme-mode', themeMode);
    });
  }

  _resetSetting = () => {
    $('#reset-setting').on('click', function() {
      AppConfig.resetConfig();
      location.reload();
    });
  }
}

new ThemeConfig().init();