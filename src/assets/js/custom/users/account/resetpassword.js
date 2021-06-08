import { Call_controller } from "corejs/form_crud";
import input from "corejs/inputErrManager";
class RessetPasword {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };

  _setupVariables = () => {
    this.wrapper = this.element.find("#form-wrapper");
    this.form = this.element.find("#resetpass-frm");
  };

  _setupEvents = () => {
    var phpPlugin = this;

    //=======================================================================
    //Validate new password
    //=======================================================================

    phpPlugin.form.on("submit", function (e) {
      e.preventDefault();
      $(this).find("#submitBtn").val("Please wait....");
      const data = {
        url: "auth/resetpassword",
        table: "users",
        frm: $(this),
        frm_name: "resetpass-frm",
      };
      Call_controller(data, manageR);
      function manageR(response) {
        if (response.result == "success") {
          phpPlugin.form.get(0).reset();
          phpPlugin.form.find("#alertErr").html(response.msg);
        } else {
          if (response.result == "error-field") {
            input.error(phpPlugin.form, response.msg);
          } else {
            phpPlugin.form.find("#alertErr").html(response.msg);
          }
        }
      }
    });
    //=======================================================================
    //clean form
    //=======================================================================
    phpPlugin.form.on("focus", "input, textarea", function () {
      $(this).removeClass("is-invalid");
      $(this).parent().children("div.invalid-feedback").html("");
    });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new RessetPasword($("#main-site"))._init();
});
