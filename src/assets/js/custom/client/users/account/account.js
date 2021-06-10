import {
  displayAllDetails,
  select2AjaxParams,
  Call_controller,
} from "corejs/form_crud";
import { readurl } from "corejs/profile_img";
import { BASE_URL } from "corejs/config";
class Account {
  constructor(element) {
    this.element = element;
  }

  init = () => {
    this.setupVariables();
    this.setupEvents();
  };

  setupVariables = () => {
    this.wrapper = this.element.find(".row.transaction-menu");
    this.profile = this.element.find("#mini-profile");
  };

  setupEvents = () => {
    var phpPlugin = this;

    //=======================================================================
    //display the menu
    //=======================================================================
    phpPlugin.wrapper.on("click", ".card", function (e) {
      e.preventDefault();
      let data = {
        url: "forms/showDetails",
        table: $(this).find("form input[name=template]").val(),
        id: $(this).find("form input[name=userID]").val(),
        data_type: "template",
        return_mode: "index",
        token: $(this).find("form input[name=csrftoken]").val(),
        frm_name: "user_form" + $(this).find("form input[name=userID]").val(),
        params: $(this).find("form input[name=template]").val(),
      };
      displayAllDetails(data, manageR);
      function manageR(response, table) {
        if (response.result == "success") {
          phpPlugin.wrapper.html(response.msg[0]);
          var newOption = new Option(
            Object.values(response.msg[1])[0],
            Object.keys(response.msg[1])[0],
            false,
            false
          );
          phpPlugin.wrapper
            .find(".select_country")
            .append(newOption)
            .trigger("change");
          switch (table) {
            case "users":
              manageUsers(table);
              break;
            default:
              break;
          }
        }
      }
    });
    //=======================================================================
    //Remove Account
    //=======================================================================
    phpPlugin.profile.find(".remove-account-frm").on("submit", function (e) {
      e.preventDefault();
      const data = {
        url: "auth/deleteUserAccount",
        table: "users",
        frm: phpPlugin.profile.find(".remove-account-frm"),
        frm_name: "remove-account-frm",
      };
      Call_controller(data, manageR);
      function manageR(response) {
        if (response.result == "success") {
          window.location.href = BASE_URL;
        }
      }
    });

    //=======================================================================
    //Manage user profile
    //=======================================================================
    function manageUsers(table = "") {
      //Read upload profile
      phpPlugin.wrapper
        .find('.upload-box input[type="file"]')
        .on("change", function () {
          readurl(
            this,
            phpPlugin.wrapper.find(".upload-box .img"),
            phpPlugin.wrapper.find(".upload-box .camera-icon")
          );
        });
      //Update user infos
      phpPlugin.wrapper.on("submit", "#user-profile-frm", function (e) {
        e.preventDefault();
        console.log($(this));
        let data = {
          url: "forms/update",
          table: table,
          params: $(this).find("#alertErr"),
          frm_name: "user-profile-frm",
          frm: $(this),
          action: "custom_message",
        };
        Call_controller(data, manageR);
        function manageR(response, alert) {
          if (response.result == "success") {
            console.log(location.href);
            $("#mini-profile")
              .load(location.href + " #mini-profile")
              .fadeIn("slow");
            alert.html(response.msg);
          }
        }
      });

      //Activate select2 box for contries
      phpPlugin.wrapper.find(".select_country").select2({
        placeholder: "Please select a country",
        // minimumInputLength: 1,
        allowClear: true,
        width: "100%",
        ajax: select2AjaxParams({
          url: "guests/get_countries",
        }),
      });
    }
  };
}

document.addEventListener("DOMContentLoaded", function () {
  new Account($("#main-site")).init();
});
