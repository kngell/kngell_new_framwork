import Cruds from "corejs/crud_interface";
class Brand {
  constructor(element) {
    this.element = element;
  }
  /**
   * Init
   */
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  /**
   * Setp variables
   */
  _setupVariables = () => {
    this.wrapper = this.element.find("#brand-wrapper");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.modalbox.find("#brands-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    /**
     * Init Cruds operations
     * =======================================================================
     */
    let cruds = new Cruds({
      table: "brand",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      bsmodal: document.getElementById("modal-box"),
    });
    /**
     * display all Items
     * =======================================================================
     */
    const csrftoken = document.querySelector('meta[name="csrftoken"]');
    cruds._displayAll({
      datatable: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
    });

    /**
     * Set / Create Add Btn
     * =======================================================================
     */
    cruds._set_addBtn();

    /**
     * Add or update Data
     * =======================================================================
     *
     */
    cruds._add_update({
      frm_name: "brands-frm",
      datatable: true,
      swal: true,
      modal: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page", // page csrf name
    });

    /**
     * Edit Data
     * =======================================================================
     *
     */
    cruds._edit({
      table: "brand",
      std_fields: [
        "brID",
        "br_name",
        "br_descr",
        "status",
        "updated_at",
        "created_at",
        "deleted",
      ],
    });

    /**
     * Clean Forms
     * =======================================================================
     */
    cruds._clean_form({});

    /**
     * Delete data
     * =======================================================================
     */
    cruds._delete({
      swal: true,
      datatable: true,
      url_check: "forms/checkdelete",
      delete_frm_class: ".delete-brand-frm",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
    });
    //=======================================================================
    //Categorie Status
    //=======================================================================
    cruds._active_inactive_elmt({ table: "brand" });
  };
}
// Dropzone.autoDiscover = false;
document.addEventListener("DOMContentLoaded", () => {
  new Brand($(".page-content"))._init();
});
