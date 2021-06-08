import Cruds from "corejs/crud_interface";
import { readurl } from "corejs/profile_img";
import select2 from "corejs/select2_manager";
class AllUsers {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.wrapper = this.element.find("#allusers-wrapper");
    this.modalbox = this.element.find("#modal-box");
    this.modalform = this.element.find("#modal-box #add-user-frm");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    // Upload profile form-text font-size
    var fontSize = phpPlugin.modalbox.find(".upload-box").width() * 0.16 * 0.9;
    phpPlugin.modalbox.find(".form-text").css("font-size", fontSize);
    //init crud
    let cruds = new Cruds({
      table: "users",
      wrapper: phpPlugin.wrapper,
      form: phpPlugin.modalform,
      modal: phpPlugin.modalbox,
      select_tag: ".group",
      bsmodal: document.getElementById("modal-box"),
    });
    //Select2 ajax
    new select2()._init({
      element: phpPlugin.modalform.find(".group"),
      tbl_options: "groups",
      placeholder: "Please select a user",
    });
    //set create/add function
    cruds._set_addBtn();
    //Add or update
    cruds._add_update({
      frm_name: "add-user-frm",
      datatable: false,
      modal: phpPlugin.modalbox,
      swal: true,
      select: ["group"],
    });
    //edit
    cruds._edit({
      frm_name: "add-user-frm",
      tbl_options: "groups",
      std_fields: [
        "userID",
        "date_enreg",
        "updateAt",
        "status",
        "deleted",
        "firstName",
        "lastName",
        "userName",
        "email",
        "phone",
        "group",
        "userName",
        "email",
        "phone",
        "profileImage",
      ],
    });
    //clean form
    cruds._clean_form({ upload_img: ".upload-box .img" });
    //delete items
    cruds._delete({
      swal: true,
      datatable: false,
      dataType: "frm",
    });

    //restore users
    cruds._restore({
      swal: true,
      datatable: false,
      dataType: "frm",
      resto_class: ".restore_user",
      swal_button: "Restore",
      swal_message: "You want to restore this user",
      method: "restore_user",
    });
    //Activate item
    cruds._active_inactive_elmt({ table: "categories" });
    // Upload profile
    phpPlugin.modalbox
      .find('.upload-box input[type="file"]')
      .on("change", function () {
        readurl(
          this,
          phpPlugin.modalbox.find(".upload-box .img"),
          phpPlugin.modalbox.find(".upload-box .camera-icon")
        );
      });
  };
}
document.addEventListener("DOMContentLoaded", () => {
  new AllUsers($(".page-container"))._init();
});
