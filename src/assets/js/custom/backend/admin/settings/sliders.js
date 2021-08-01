import Cruds from "corejs/crud_interface";
import media from "corejs/upload_interface";

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
    this.modalform = this.element.find("#modal-box #add-sliders-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    let dropzone = new media({
      dz_element: phpPlugin.modalbox.find(".dragAndDrop__wrapper"),
    })._upload();

    /**
     * Init Crud operations
     * =======================================================================
     */
    let cruds = new Cruds({
      table: "sliders",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ".unit",
      bsmodal: document.getElementById("modal-box"),
    });
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
      frm_name: "add-sliders-frm",
      datatable: true,
      swal: true,
      modal: true,
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page", // page csrf name
      select: [],
      media: phpPlugin.modalbox.find("#p_media"),
      dropzone: dropzone,
      data_type: "values",
    });

    /**
     * Edit
     * =======================================================================
     *
     */
    cruds._edit({
      table: "sliders",
      std_fields: [
        "slID",
        "p_media",
        "page_slider",
        "page_slider",
        "slider_title",
        "slider_subtitle",
        "slider_text",
        "slider_btn_text",
        "slider_btn_link",
        "status",
        "created_at",
        "updated_at",
      ],
      dropzone: dropzone,
    });
    /**
     * Clean form
     * =======================================================================
     */
    cruds._clean_form({ dropzone: dropzone });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new Settings($("#main-site"))._init();
});
