import "plugins/flexadmin/js/ecommerce";
import Cruds from "corejs/crud_interface";
import media from "corejs/upload_interface";
import select2 from "corejs/select2_manager";

class AllProducts {
  constructor(element) {
    this.element = element;
    this.selectTag = ["p_company", "p_warehouse", "p_shipping_class"];
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.wrapper = this.element.find("#allproducts-wrapper");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.element.find("#modal-box #new-product-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;
    //=======================================================================
    //Init Cruds operations
    //=======================================================================
    let cruds = new Cruds({
      table: "products",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      bsmodal: document.getElementById("modal-box"),
    });

    //=======================================================================
    //display all Items
    //=======================================================================
    cruds._displayAll({ datatable: true });
    //=======================================================================
    //Ajax Select2
    //=======================================================================
    new select2()._init({
      element: phpPlugin.modalform.find(".p_shipping_class"),
      tbl_options: "shipping_class",
      placeholder: "Please select a shipping class",
    });
    let company = new select2()._init({
      element: phpPlugin.modalform.find(".p_company"),
      tbl_options: "company",
      placeholder: "Please select a Company",
    });
    let warehouse = new select2()._init({
      element: phpPlugin.modalform.find(".p_warehouse"),
      placeholder: "Please select a wareHouse",
    });
    company.select.on("change", function (e) {
      warehouse._destroy();
      // warehouse.select.val(null).trigger("change");
      if ($(this).select2("data") != 0) {
        warehouse.params.parentID = Object.values(
          $(this).select2("data")
        )[0].id;
      }
      warehouse._init({
        element: warehouse.select,
        tbl_options: "warehouse",
        placeholder: "Please select a wareHouse",
      });
    });
    //=======================================================================
    //Set / Create Add Btn
    //=======================================================================
    cruds._set_addBtn();

    //=======================================================================
    //Upload files
    //=======================================================================
    let dropzone = new media({
      dz_element: phpPlugin.modalbox.find(".dragAndDrop__wrapper"),
    })._upload();
    //=======================================================================
    //Manage categories
    //=======================================================================
    // let categories = new Categories({
    //   element: phpPlugin.modalform.find("#check-box-wrapper"),
    // })._manage();
    //=======================================================================
    //Add or update Data
    //=======================================================================
    cruds._add_update({
      frm_name: "new-product-frm",
      datatable: true,
      swal: true,
      modal: true,
      categorie: phpPlugin.modalbox.find(".categorie"),
      media: phpPlugin.modalbox.find("#p_media"),
      dropzone: dropzone,
      select: phpPlugin.selectTag,
    });

    //=======================================================================
    //Edit Data
    //=======================================================================
    cruds._edit({
      frm_name: "new-product-frm",
      std_fields: [
        "pdtID",
        "p_title",
        "p_short_descr",
        "p_descr",
        "p_regular_price",
        "p_compare_price",
        "p_cost_per_item",
        "p_charge_tax",
        "p_media",
        "p_sku",
        "p_barre_code",
        "p_track_qty",
        "p_continious_sell",
        "p_qty",
        "p_back_border",
        "p_stock_threshold",
        "p_weight",
        "p_lenght",
        "p_width",
        "p_height",
        "p_shipping_class",
        "p_warehouse",
        "p_company",
        "created_at",
        "updated_at",
        "deleted",
      ],
      inputElement: phpPlugin.modalbox.find("#myfile"),
      dropzone: dropzone, //myDropzone,
      categorieElement: phpPlugin.modalform.find("#check-box-wrapper"),
      tbl_options: ["categories", "company", "warehouse", "shipping_class"],
    });
    //=======================================================================
    //Clean Forms
    //=======================================================================
    cruds._clean_form({
      dropzone: dropzone, //myDropzone,
      select: phpPlugin.selectTag,
    });
    //=======================================================================
    //Delete data
    //=======================================================================
    cruds._delete({
      swal: true,
      datatable: true,
      url_check: "forms/checkdelete",
    });
    //=======================================================================
    //Categorie Status
    //=======================================================================
    cruds._active_inactive_elmt({ table: "categories" });
  };
}
// Dropzone.autoDiscover = false;
document.addEventListener("DOMContentLoaded", () => {
  new AllProducts($(".page-container"))._init();
});
