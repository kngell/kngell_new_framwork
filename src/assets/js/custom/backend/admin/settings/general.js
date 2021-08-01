import Cruds from "corejs/crud_interface";
class Settings {
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
    this.modalform = this.element.find("#modal-box #add-general_settings-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    /**
     * Init Crud operations
     * =======================================================================
     */
    let cruds = new Cruds({
      table: "general_settings",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ".unit",
      bsmodal: document.getElementById("modal-box"),
    });
    console.log(phpPlugin.modalform);
    /**
     * Display settings
     * =======================================================================
     */
    const csrftoken = document.querySelector('meta[name="csrftoken"]');
    cruds._displayAll({
      datatable: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
    });

    //set create/add function
    cruds._set_addBtn();
    /**
     * Add or Update
     * =======================================================================
     */
    cruds._add_update({
      frm_name: "add-settings-frm",
      datatable: true,
      swal: true,
      modal: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page", // page csrf name
      select: [],
      data_type: "values",
    });

    /**
     * Edit
     * =======================================================================
     *
     */
    cruds._edit({
      table: "general_settings",
      std_fields: [
        "setID",
        "setting_name",
        "setting_key",
        "setting_descr",
        "value",
        "status",
        "created_at",
        "updated_at",
      ],
    });
    /**
     * Clean form
     * =======================================================================
     */
    cruds._clean_form();
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new Settings($("#main-site"))._init();
});
