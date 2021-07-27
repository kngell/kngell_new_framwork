import Cruds from "corejs/crud_interface";
import select2 from "corejs/select2_manager";

class Orders {
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
    this.modalform = this.element.find("#modal-box #order-frm");
  };

  /**
   * Setup events
   * =======================================================================
   *
   */
  _setupEvents = () => {
    var phpPlugin = this;
    let cruds = new Cruds({
      table: "orders",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ["#ord_status", "customer"],
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
      element: phpPlugin.modalbox.find("#ord_status"),
      tbl_options: "order_status",
      placeholder: "Please select status",
      url: "forms/showDetails",
      csrftoken: phpPlugin.modalform.find("input[name='csrftoken']").val(),
      frm_name: phpPlugin.modalform.attr("id"),
    });

    select._init({
      element: phpPlugin.modalbox.find("#customer"),
      tbl_options: "users",
      placeholder: "Please select status",
      url: "forms/showDetails",
      csrftoken: phpPlugin.modalform.find("input[name='csrftoken']").val(),
      frm_name: phpPlugin.modalform.attr("id"),
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
      table: "orders",
      tbl_options: ["order_status", "users"],
      custom_method: "getOrdercustomDetails",
      std_fields: [
        "ordID",
        "ord_number",
        "ord_userID",
        "ord_pmt_mode",
        "ord_pmt_ID",
        "ord_date",
        "ord_status",
        "customer",
        "billing_address",
        "shipping_address",
        "u_comment",
        "order_details_summary",
        "order_details_total",
        "created_at",
        "updated_at",
        "deleted",
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
  new Orders($("#main-site"))._init();
});
