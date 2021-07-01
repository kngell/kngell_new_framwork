import Cruds from "corejs/crud_interface";
import select2 from "corejs/select2_manager";
class AllUnits {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.wrapper = this.element.find("#content-box");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.element.find(
      "#modal-box #groups-and-permissions-frm"
    );
  };
  _setupEvents = () => {
    var phpPlugin = this;
    //=======================================================================
    //Init Crud operation
    //=======================================================================
    let cruds = new Cruds({
      table: "groups",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ".select_group",
      bsmodal: document.getElementById("modal-box"),
    });
    //=======================================================================
    //Cruds operation
    //=======================================================================
    //display All items
    const csrftoken = document.querySelector('meta[name="csrftoken"]');
    cruds._displayAll({
      datatable: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
    });

    //Select2 ajax
    new select2()._init({
      element: phpPlugin.modalform.find("#parentID"),
      tbl_options: "groups",
      placeholder: "Please select a user",
      url: "forms/showDetails",
    });
    //set create/add function
    cruds._set_addBtn();
    //Add or update
    cruds._add_update({
      datatable: true,
      swal: true,
      modal: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page", // page csrf name
    });
    //edit
    cruds._edit({
      tbl_options: "groups",
      table: "groups",
      std_fields: [
        "grID",
        "date_enreg",
        "updateAt",
        "parentID",
        "deleted",
        "name",
        "description",
        "status",
      ],
    });
    //clean form
    cruds._clean_form();
    //delete items
    cruds._delete({
      swal: true,
      datatable: true,
      url_check: "forms/checkdelete",
      delete_frm_class: ".delete-permissions",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
    });
    //Activate item
    cruds._active_inactive_elmt({ table: "groups" });
    //=======================================================================
    //Other operations
    //=======================================================================
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new AllUnits($(".page-container"))._init();
});
