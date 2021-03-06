import Cruds from "corejs/crud_interface";
class AllCompanies {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.wrapper = this.element.find("#company-wrapper");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.element.find("#modal-box #company-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;
    /**
     * Init Cruds operations
     * =======================================================================
     */
    let cruds = new Cruds({
      table: "company",
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
    //=======================================================================
    //Set / Create Add Btn
    //=======================================================================
    cruds._set_addBtn();
    //=======================================================================
    //Add or update Data
    //=======================================================================
    cruds._add_update({
      frm_name: "company-frm",
      datatable: true,
      swal: true,
      modal: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page", // page csrf name
      data_type: "values",
    });

    //=======================================================================
    //Edit Data
    //=======================================================================
    cruds._edit({
      table: "company",
      std_fields: [
        "compID",
        "sigle",
        "denomination",
        "siret",
        "site_web",
        "created_at",
        "updated_at",
        "rna",
        "tva",
        "activite",
        "couriel",
        "phone",
        "mobile",
        "fax",
        "address1",
        "zip_code",
        "ville",
        "pays",
        "created_at",
        "updated_at",
        "deleted",
      ],
    });
    //=======================================================================
    //Clean Forms
    //=======================================================================
    cruds._clean_form({});
    //=======================================================================
    //Delete data
    //=======================================================================
    cruds._delete({
      swal: true,
      datatable: true,
      url_check: "forms/checkdelete",
      delete_frm_class: ".delete-company-frm",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
    });
    //=======================================================================
    //Categorie Status
    //=======================================================================
    cruds._active_inactive_elmt({ table: "company" });
  };
}
// Dropzone.autoDiscover = false;
document.addEventListener("DOMContentLoaded", () => {
  new AllCompanies($(".page-content"))._init();
});
