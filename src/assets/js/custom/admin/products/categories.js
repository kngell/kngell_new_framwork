import Cruds from "corejs/crud_interface";
import select2 from "corejs/select2_manager";
class AllCategories {
  constructor(element) {
    this.element = element;
  }
  //=======================================================================
  //Init
  //=======================================================================
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  //=======================================================================
  //Setup variables
  //=======================================================================
  _setupVariables = () => {
    this.wrapper = this.element.find(".card");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.element.find("#modal-box #Categorie-frm");
  };
  //=======================================================================
  //Setup events
  //=======================================================================
  _setupEvents = () => {
    var phpPlugin = this;
    //inti crud
    let cruds = new Cruds({
      table: "categories",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: "#parentID",
    });
    //display All items
    cruds._displayAll({ datatable: true });
    //Select2 ajax
    new select2()._init({
      element: phpPlugin.modalform.find("#parentID"),
      tbl_options: "categories",
      placeholder: "Please select a categorie",
    });
    //set create/add function
    cruds._set_addBtn();
    //Add or update

    cruds._add_update({
      frm_name: "Categorie-frm",
      datatable: true,
      swal: true,
      modal: true,
    });
    //edit
    cruds._edit({
      frm_name: "Categorie-frm",
      tbl_options: "categories",
      std_fields: [
        "catID",
        "date_enreg",
        "updateAt",
        "status",
        "categorie",
        "description",
        "parentID",
      ],
    });
    //clean form
    cruds._clean_form();
    //delete items
    cruds._delete({
      swal: true,
      datatable: true,
      url_check: "forms/checkdelete",
    });
    //Activate item
    cruds._active_inactive_elmt({ table: "categories" });
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new AllCategories($(".page-container"))._init();
});
