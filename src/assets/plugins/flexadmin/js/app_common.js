import { Tooltip } from "bootstrap";

class AppCommon {
  constructor() {}

  init() {
    this._applyTooltip();
    this._applySelect2();
    this._select2WithIcon();
    this._applyCustomScroll();
    this._inputGroupHighlight();
    this._applyBsDatePicker();
    this._applyWaves();
    this._removeCard();
  }

  _applyTooltip() {
    var tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new Tooltip(tooltipTriggerEl);
    });
  }

  _applySelect2() {
    $("select.select2").each(function (_, element) {
      let select = $(element);
      let closeOnSelect = select.hasClass("do-not-close-on-selecting")
        ? false
        : true;
      let options = {
        allowClear: true,
        width: "copy",
        closeOnSelect: closeOnSelect,
        placeholder: "Select an attribute",
      };
      select.select2(options);
    });
  }

  _select2WithIcon() {
    function icon(item) {
      return item.id
        ? "<i class='" +
            $(item.element).data("icon") +
            " mr-2'></i>" +
            item.text
        : item.text;
    }
    $("select.select2-with-icon").each(function (_, element) {
      let select = $(element);
      let options = {
        width: "100%",
        templateResult: icon,
        templateSelection: icon,
        escapeMarkup: function (item) {
          return item;
        },
      };
      select.select2(options);
    });
  }

  _applyCustomScroll() {
    $(".custom-scroll").mCustomScrollbar({
      theme: "minimal",
    });
  }

  _inputGroupHighlight() {
    $(".input-group .form-control").on("focus", function () {
      $(this).parent().addClass("focus");
    });

    $(".input-group .form-control").on("focusout", function () {
      $(this).parent().removeClass("focus");
    });
  }

  _applyBsDatePicker() {
    let controls = {
      leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
      rightArrow:
        '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>',
    };

    $(".datepicker").datepicker({
      todayHighlight: true,
      orientation: "bottom left",
      templates: controls,
    });
  }

  _applyWaves() {
    Waves.attach(".btn, .sidebar-block li a");
    Waves.init();
  }

  _removeCard() {
    $('[data-bs-toggle="remove"]').click(function (e) {
      e.preventDefault();

      $(this).closest(".card").remove();
    });
  }
}

new AppCommon().init();
