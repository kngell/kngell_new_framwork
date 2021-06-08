import Cruds from "corejs/crud_interface";
import select2 from "corejs/select2_manager";
class AllUnits {
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
    this.modalform = this.element.find("#modal-box #add-units-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;
    //=======================================================================
    //Init Crud operations
    //=======================================================================
    let cruds = new Cruds({
      table: "units",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ".select_unit",
    });
    //=======================================================================
    //Display all items & init select tag
    //=======================================================================
    cruds._displayAll({ datatable: true });
    //Select2 ajax
    let select = new select2()._init({
      element: phpPlugin.modalform.find(".unit"),
      tbl_options: "units",
      placeholder: "Please select a unit",
    });
    //=======================================================================
    //Add or update Edit
    //=======================================================================
    //set create/add function
    cruds._set_addBtn();
    //Add or update
    cruds._add_update({
      frm_name: "add-units-frm",
      datatable: true,
      swal: true,
      modal: true,
    });
    //edit
    cruds._edit({
      frm_name: "add-units-frm",
      tbl_option: "",
      std_fields: [
        "unID",
        "unit",
        "created_at",
        "updated_at",
        "deleted",
        "descr",
        "status",
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
    cruds._active_inactive_elmt({ table: "units" });
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new AllUnits($(".page-container"))._init();
});
