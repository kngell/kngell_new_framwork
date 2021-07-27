import Cruds from "corejs/crud_interface";
import select2 from "corejs/select2_manager";
class Shipping {
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
    this.modalform = this.element.find("#modal-box #add-shipping-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;
    /**
     * Init Crud operations
     * =======================================================================
     */
    let cruds = new Cruds({
      table: "shipping_class",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ".sh_name",
      bsmodal: document.getElementById("modal-box"),
    });

    /**
     * Display all items & init select tag
     * =======================================================================
     *
     */
    const csrftoken = document.querySelector('meta[name="csrftoken"]');
    cruds._displayAll({
      datatable: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
    });

    /**
     * Select2 Tag init
     * =======================================================================
     */
    new select2()._init({
      element: phpPlugin.modalform.find(".sh_name"),
      tbl_options: "shipping_class",
      placeholder: "Please select a shipping class",
      url: "forms/showDetails",
      csrftoken: phpPlugin.modalform.find("input[name='csrftoken']").val(),
      frm_name: phpPlugin.modalform.attr("id"),
    });

    /**
     * set create/add function
     * =======================================================================
     */
    cruds._set_addBtn();
    /**
     * set create/add function
     * =======================================================================
     */
    cruds._add_update({
      frm_name: "add-shipping-frm",
      datatable: true,
      swal: true,
      modal: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page", // page csrf name
      select: ["sh_name"],
      data_type: "values",
    });
    /**
     * Edit
     * =======================================================================
     */
    cruds._edit({
      tbl_options: "shipping_class",
      table: "shipping_class",
      std_fields: [
        "shcID",
        "sh_name",
        "sh_descr",
        "status",
        "price",
        "created_at",
        "updated_at",
      ],
    });
    //clean form
    cruds._clean_form();
    //delete items
    cruds._delete({
      swal: true,
      datatable: true,
      url_check: "forms/checkdelete",
      delete_frm_class: ".delete-shipping-class",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      data_type: "values",
    });
    //Activate item
    cruds._active_inactive_elmt({ table: "shipping_class" });
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new Shipping($(".page-container"))._init();
});
