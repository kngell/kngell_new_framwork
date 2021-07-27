import Cruds from "corejs/crud_interface";
import select2 from "corejs/select2_manager";
class Warehouse {
  constructor(element) {
    this.element = element;
    this.selectTag = ["company", "country_code"];
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
    this.modalform = this.modalbox.find("#warehouse-frm");
  };

  /**
   * Setup events
   * =======================================================================
   *
   */
  _setupEvents = () => {
    var phpPlugin = this;
    let cruds = new Cruds({
      table: "warehouse",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
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
      element: phpPlugin.modalform.find("#company"),
      tbl_options: "company",
      placeholder: "Please select a company",
      url: "forms/showDetails",
      csrftoken: phpPlugin.modalform.find("input[name='csrftoken']").val(),
      frm_name: phpPlugin.modalform.attr("id"),
    });
    select._init({
      element: phpPlugin.modalform.find("#country_code"),
      placeholder: "Please select a Country",
      url: "guests/get_countries",
      csrftoken: phpPlugin.modalform.find("input[name='csrftoken']").val(),
      frm_name: phpPlugin.modalform.attr("id"),
    });
    //set create/add function
    cruds._set_addBtn();
    //Add or update

    cruds._add_update({
      datatable: true,
      swal: true,
      select: phpPlugin.selectTag,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "spcefics_values",
    });
    //edit
    cruds._edit({
      tbl_options: ["company", "countries"],
      table: "warehouse",
      std_fields: [
        "whID",
        "wh_name",
        "wh_descr",
        "status",
        "created_at",
        "company",
        "country_code",
        "updated_at",
        "deleted",
      ],
    });
    //clean form
    cruds._clean_form({ select: phpPlugin.selectTag });
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
  new Warehouse($("#main-site"))._init();
});
