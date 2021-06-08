import Cruds from "corejs/crud_interface";
class AllUnits {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.wrapper = this.element.find("#content-box");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.element.find(
      "#modal-box #groups-and-permissions-frm"
    );
  };
  _setupEvents = () => {
    var phpPlugin = this;
    //=======================================================================
    //Init Crud operation
    //=======================================================================
    let cruds = new Cruds({
      table: "groups",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ".select_group",
    });
    //=======================================================================
    //Cruds operation
    //=======================================================================
    //display All items
    cruds._displayAll({ datatable: true });
    //Select2 ajax
    let select = cruds._select2({
      tbl_options: "groups",
      placeholder: "Please select user role",
    });
    //set create/add function
    cruds._set_addBtn();
    //Add or update
    cruds._add_update({
      frm_name: "groups-and-permissions-frm",
      datatable: true,
      swal: true,
      modal: true,
    });
    //edit
    cruds._edit({
      frm_name: "groups-and-permissions-frm",
      tbl_option: "",
      std_fields: [
        "grID",
        "date_enreg",
        "updateAt",
        "parentID",
        "deleted",
        "name",
        "description",
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
    cruds._active_inactive_elmt({ table: "groups" });
    //=======================================================================
    //Other operations
    //=======================================================================
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new AllUnits($(".page-container"))._init();
});
