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
    this.wrapper = this.element.find(".card");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.element.find("#modal-box #add-units-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;
    /**
     * Init Crud operations
     * =======================================================================
     */
    let cruds = new Cruds({
      table: "units",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ".unit",
      bsmodal: document.getElementById("modal-box"),
    });
    //=======================================================================
    //Display all items & init select tag
    //=======================================================================
    const csrftoken = document.querySelector('meta[name="csrftoken"]');
    cruds._displayAll({
      datatable: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
    });
    //Select2 ajax
    let select = new select2()._init({
      element: phpPlugin.modalform.find(".unit"),
      tbl_options: "units",
      placeholder: "Please select a unit",
      url: "forms/showDetails",
    });

    //set create/add function
    cruds._set_addBtn();
    /**
     * Add or Update
     * =======================================================================
     */
    cruds._add_update({
      frm_name: "add-units-frm",
      datatable: true,
      swal: true,
      modal: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page", // page csrf name
      select: ["unit"],
    });
    //edit
    cruds._edit({
      tbl_options: "units",
      table: "units",
      std_fields: [
        "unID",
        "unit",
        "created_at",
        "updated_at",
        "descr",
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
      delete_frm_class: ".delete-unit-status",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
    });
    //Activate item
    cruds._active_inactive_elmt({ table: "units" });
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new AllUnits($(".page-container"))._init();
});
