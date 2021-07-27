import Cruds from "corejs/crud_interface";
import select2 from "corejs/select2_manager";
class AllCategories {
  constructor(element) {
    this.element = element;
  }

  /**
   * Init
   * =======================================================================
   */
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };

  /**
   * Setup variables
   * =======================================================================
   */
  _setupVariables = () => {
    this.wrapper = this.element.find(".card");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.element.find("#modal-box #Categorie-frm");
  };

  /**
   * Setup events
   * =======================================================================
   *
   */
  _setupEvents = () => {
    var phpPlugin = this;
    let cruds = new Cruds({
      table: "categories",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ["#parentID", "#brID"],
      bsmodal: document.getElementById("modal-box"),
    });

    /**
     * display All items
     * =======================================================================
     */
    const csrftoken = document.querySelector('meta[name="csrftoken"]');
    cruds._displayAll({
      datatable: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
      model_method: "getAllCategories",
    });

    /**
     * Select2 ajax
     * =======================================================================
     *
     */
    const select = new select2();
    select._init({
      element: phpPlugin.modalform.find("#parentID"),
      tbl_options: "categories",
      placeholder: "Please select a parent Categorie",
      url: "showDetails",
      csrftoken: phpPlugin.modalform.find("input[name='csrftoken']").val(),
      frm_name: phpPlugin.modalform.attr("id"),
    });

    select._init({
      element: phpPlugin.modalform.find("#brID"),
      tbl_options: "brand",
      placeholder: "Please select a brand",
      url: "showDetails",
      csrftoken: phpPlugin.modalform.find("input[name='csrftoken']").val(),
      frm_name: phpPlugin.modalform.attr("id"),
    });

    //set create/add function
    cruds._set_addBtn();
    //Add or update

    cruds._add_update({
      frm_name: "Categorie-frm",
      datatable: true,
      swal: true,
      modal: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page", // page csrf name
      data_type: "values",
      model_method: "getAllCategories",
    });
    //edit
    cruds._edit({
      tbl_options: ["categories", "brand"],
      table: "categories",
      std_fields: [
        "catID",
        "date_enreg",
        "updateAt",
        "status",
        "categorie",
        "description",
        "parentID",
        "brID",
      ],
    });
    //clean form
    cruds._clean_form();
    //delete items
    cruds._delete({
      swal: true,
      datatable: true,
      url_check: "checkdelete",
      delete_frm_class: ".delete-categorie-frm",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
    });
    //Activate item
    cruds._active_inactive_elmt({ table: "categories" });
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new AllCategories($(".page-container"))._init();
});
