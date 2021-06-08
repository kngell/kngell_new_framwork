import { get_visitors_data, send_visitors_data } from "corejs/visitors";
import log_reg from "corejs/logregloader";
import "focus-within-polyfill";
import { select2AjaxParams } from "corejs/form_crud";
// import "smartWizard";
// import { isIE } from "corejs/config";

class HomePlugin {
  constructor(element) {
    this.element = element;
  }

  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };

  _setupVariables = () => {
    this.loginBtn = this.element.find("#login_btn");
    this.header = this.element.find("#header");
    this.navigation = this.element.find(".navigation");
    this.wrapper = this.element.find(".tab-content");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    //=======================================================================
    //Import login system
    //=======================================================================

    phpPlugin.header.on(
      "click show.bs.dropdown",
      ".connect .connexion",
      function (e) {
        var loader = new log_reg().check();
        if (!loader.isLoad) {
          loader.login();
          console.log("click");
        }
      }
    );

    //=======================================================================
    //Get visitors IP Adresss
    //=======================================================================
    let visitor = get_visitors_data().then((visitors_data) => {
      var data = {
        url: "visitors/track",
        table: "visitors",
        ip: visitors_data.ip,
      };
      send_visitors_data(data, manageR);
      function manageR(response) {}
    });
    //=======================================================================
    //Ajax Select2
    //=======================================================================
    //Activate select2 box for contries
    phpPlugin.wrapper.find(".select_country").select2({
      placeholder: "",
      // minimumInputLength: 1,
      allowClear: true,
      width: "100%",
      ajax: select2AjaxParams({
        url: "guests/get_countries",
      }),
    });
    //=======================================================================
    //Tootgle checkout step by step
    //=======================================================================
    // $(".page-content").smartWizard();
    // phpPlugin.navigation.on("click", ".tab-control .next-btn", function (e) {
    //   e.preventDefault();
    //   phpPlugin.navigation
    //     .find(".nav-pills > .active")
    //     .next("li")
    //     .find("a")
    //     .trigger("click");
    //   console.log(phpPlugin.navigation.find(".nav-pills > .active"));
    // });
    // phpPlugin.wrapper.on("click", ".tab-control .previous-btn", () => {
    //   e.preventDefault();
    //   phpPlugin.wrapper
    //     .find(".nav-pills .active")
    //     .prev("li")
    //     .find("a")
    //     .trigger("click");
    //   console.log($(this));
    // });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new HomePlugin($("#body"))._init();
});
