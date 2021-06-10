import { displayAllDetails } from "corejs/form_crud";
class Profile {
  constructor(element) {
    this.element = element;
  }

  init = () => {
    this.setupVariables();
    this.setupEvents();
  };

  setupVariables = () => {
    this.countrySelectBox = this.element.find(".select2");
    this.display = this.element.find(".row.menu");
  };

  setupEvents = () => {
    var phpPlugin = this;

    //=======================================================================
    //Contry select
    //=======================================================================
    phpPlugin.countrySelectBox.select2({
      allowClear: true,
      width: "100%",
    });

    //=======================================================================
    //display the menu
    //=======================================================================
    phpPlugin.display.on("click", ".card", function (e) {
      e.preventDefault();
      let data = {
        url: "forms/showDetails",
        table: $(this).find("form input[name=template]").val(),
        id: $(this).find("form input[name=userID]").val(),
        data_type: "template",
        return_mode: "index",
      };
      displayAllDetails(data, manageR);
      function manageR(response) {
        if (response.result == "success") {
          phpPlugin.display.html(response.msg);
        }
      }
    });
    var firstTabEl = document.querySelector("#myTab li:last-child a");
    var firstTab = new bootstrap.Tab(firstTabEl);

    firstTab.show();
  };
}

document.addEventListener("DOMContentLoaded", function () {
  new Profile($("#main-site")).init();
});
