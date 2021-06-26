import Cruds from "corejs/crud_interface";
import select2 from "corejs/select2_manager";
class Taxes {
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
    this.modalform = this.element.find("#modal-box #taxes-frm");
  };

  /**
   * Setup events
   * =======================================================================
   *
   */
  _setupEvents = () => {
    var phpPlugin = this;
    let cruds = new Cruds({
      table: "taxes",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ["#categorieID"],
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
      data_type: "spcefics_values",
    });

    /**
     * Select2 ajax
     * =======================================================================
     *
     */
    const select = new select2();
    select._init({
      element: phpPlugin.modalform.find("#categorieID"),
      tbl_options: "categories",
      placeholder: "Please select a associate Categorie",
      url: "forms/showDetails",
    });
    //set create/add function
    cruds._set_addBtn();
    //Add or update

    cruds._add_update({
      datatable: true,
      swal: true,
      select: ["categorieID"],
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "spcefics_values",
    });
    //edit
    cruds._edit({
      tbl_options: ["categories"],
      table: "taxes",
      std_fields: [
        "tID",
        "t_name",
        "t_descr",
        "t_rate",
        "t_class",
        "status",
        "created_at",
        "updated_at",
        "deleted",
        "categorieID",
      ],
    });
    //clean form
    cruds._clean_form();
    //delete items
    cruds._delete({
      swal: true,
      datatable: true,
      url_check: "forms/checkdelete",
      delete_frm_class: ".delete-taxe-frm",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
    });
    //Activate item
    cruds._active_inactive_elmt({ table: "taxes" });
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new Taxes($(".page-container"))._init();
});
