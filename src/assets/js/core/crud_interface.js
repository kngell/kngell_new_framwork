import { Call_controller, Delete } from "corejs/form_crud";
import { AVATAR, IMG } from "corejs/config";
import input from "corejs/inputErrManager";
import Swal from "sweetalert2";
import { Modal } from "bootstrap";
import OP from "corejs/operator";
export default class Cruds {
  constructor(data) {
    this.table = data.table;
    this.wrapper = data.wrapper;
    this.form = data.form;
    this.modal = data.modal;
    this.select = data.select_tag;
    this.bsmodal = new Modal(data.bsmodal, {
      keyboard: false,
    });
    this.bsElement = data.bsmodal;
  }

  //=======================================================================
  //Display All Plugins
  //=======================================================================
  _displayAll = (params) => {
    const plugin = this;
    let wrapper = this.wrapper;
    var data = {
      url: "showAll",
      table: this.table,
      user: "admin",
    };
    Call_controller({ ...data, ...params }, manageR);
    function manageR(response) {
      if (response.result == "success") {
        wrapper.find("#showAll").html(response.msg);
        if (params.datatable) _loadDatatables();
        plugin._money_format(wrapper);
      } else {
        wrapper.find("#globalErr").html(response.msg);
      }
    }

    async function _loadDatatables() {
      const DataTable = await import(
        /* webpackChunkName: "datatables" */ "datatables.net-responsive-dt"
      );
      plugin.wrapper.find("#ecommerce-datatable").DataTable({
        order: [0, "desc"],
        pagingType: "full_numbers",
        stateSave: true,
        responsive: true,
      });
    }
  };
  _money_format = (wrapper) => {
    const operation = new OP();
    operation._format_money({
      wrapper: wrapper,
      fields: [".price"],
    });
  };
  //=======================================================================
  //Add or update table
  //=======================================================================
  //Set add btn
  _set_addBtn = () => {
    let wrapper = this.wrapper;
    let form = this.form;
    wrapper.find("#addNew").on("click", function () {
      form.find("#operation").val("add");
      form.children(".mb-3").first().find("input").focus();
    });
  };
  //get selected categories
  _get_selected_categories = (selector) => {
    if (selector) {
      return selector
        .map(function (i, cat) {
          if ($(this).is(":checked")) {
            return $(this).val();
          }
        })
        .get();
    } else {
      return "";
    }
  };
  _get_select2_data = (params) => {
    let select_data = [];
    $(params).each(function () {
      if ($("." + this).length != 0) {
        select_data[this] = Object.values($("." + this).select2("data"));
      }
    });
    return select_data;
  };
  /**
   * add or update
   * @param {*} params
   * =======================================================================
   */
  _add_update = (params) => {
    let plugin = this;
    plugin.form.on("submit", function (e) {
      e.preventDefault();
      plugin.form.find("#submitBtn").val("Please wait...");
      var data = {
        url: plugin.form.find("#operation").val() === "add" ? "Add" : "update",
        frm: plugin.form,
        frm_name: $(this).attr("id"),
        table: plugin.table,
        categories: plugin._get_selected_categories(params.categorie),
        select2: params.hasOwnProperty("select")
          ? plugin._get_select2_data(params.select)
          : "",
      };
      switch (plugin.form.find("#operation").val()) {
        case "add":
        case "update":
          if (params.hasOwnProperty("dropzone")) {
            Call_controller(
              { ...data, ...{ files: params.dropzone.files } },
              manageR
            );
          } else {
            Call_controller(data, manageR);
          }
          break;
      }
      function manageR(response) {
        plugin.form.find("#submitBtn").val("Submit");
        switch (response.result) {
          case "error-field":
            input.error(plugin.modal, response.msg);
            break;
          case "success":
            plugin.form.trigger("reset");
            plugin.modal ? plugin.bsmodal.hide() : "";
            if (params.swal) {
              Swal.fire("Success!", response.msg, "success").then(() => {
                if (params.datatable == true) {
                  plugin._displayAll(params);
                } else {
                  location.reload();
                }
              });
            }
            if (params.prepend) {
              params.nested.prepend(response.msg);
            } else {
              if (params.prepend === false) {
                params.nested.before(response.msg);
                params.nested.hide();
              }
            }
            break;
          case "error-file":
            if (typeof params.dropzone != "undefined") {
              params.dropzone._manageErrors(response.msg);
              params.dropzone._removeErrMsg();
            } else {
              plugin.form.find("#alertErr").html(response.msg);
              plugin.form.trigger("reset");
            }
            break;
          default:
            plugin.form.find("#alertErr").html(response.msg);
            plugin.form.trigger("reset");
            break;
        }
      }
    });
  };

  //=======================================================================
  //Get Id section
  //=======================================================================
  // Get edit id
  _get_Edit_id = (selector) => {
    let table = this.table;
    let result;
    switch (table) {
      case "users":
        result = selector
          .parents(".action")
          .children(".delete_user")
          .find("input[name='userID']")
          .val();
        break;

      default:
        result = selector.attr("id");
        break;
    }
    return result;
  };
  _clean_params = (params) => {
    let ajax_param = {};
    const exclude = [
      "std_fields",
      "inputElement",
      "dropzone",
      "categorieElement",
    ];
    for (const [k, v] of Object.entries(params)) {
      if (!exclude.includes(k)) {
        ajax_param[k] = v;
      }
    }
    console.log(ajax_param);
    return ajax_param;
  };
  //=======================================================================
  //Edit form
  //=======================================================================

  _edit = (params) => {
    let plugin = this;
    plugin.wrapper.on("click", ".editBtn", function (e) {
      e.preventDefault();
      e.stopPropagation();
      plugin.modal.find("#operation").val("update");
      var data = {
        url: "edit",
        frm: $(this).parents("form").length != 0 ? $(this).parents("form") : "",
        id: plugin._get_Edit_id($(this)),
        table: params.table,
        frm_name: params.frm_name
          ? params.frm_name
          : $(this).parents("form").attr("id"),
        params: params.hasOwnProperty("std_fields") ? params.std_fields : "",
      };
      const ajax_params = plugin._clean_params(params);
      Call_controller({ ...data, ...ajax_params }, manageR);
      function manageR(response, std_fields) {
        if (response.result === "success") {
          $(std_fields).each(function (i, field) {
            switch (true) {
              case $("#" + this).hasClass("select2-hidden-accessible"):
                let select_field = this;
                if (response.msg.selectedOptions.hasOwnProperty(select_field)) {
                  if (response.msg.selectedOptions[select_field].length != 0) {
                    $(response.msg.selectedOptions[select_field][0]).each(
                      function () {
                        let select = plugin.form.find("." + select_field);
                        if (
                          !select.find("option[value='" + this.id + "']").length
                        ) {
                          select.append(
                            new Option(this.text, this.id, false, true)
                          );
                          select.val(
                            response.msg.selectedOptions[select_field][1]
                          );
                          select.trigger("change");
                        }
                      }
                    );
                  }
                }
                break;
              case this == "p_media" && plugin.table == "products":
                var dz = params.dropzone;
                $(dz.element).find(".message").hide();
                dz.files = [];
                $.each(response.msg.items[field], function (key, value) {
                  let gallery_item = dz._createGallery(value);
                  dz._createFile(value)
                    .then((file) => {
                      dz.files.push(file);
                      dz._createExtraDiv(file, gallery_item);
                    })
                    .catch(function (error) {
                      console.log(
                        "Il y a eu un problème avec l'opération fetch: " +
                          error.message
                      );
                    });
                  dz.element.find(".gallery").append(gallery_item);
                  dz.element.on("click", ".gallery_item", (e) => {
                    e.stopPropagation();
                  });
                });
                dz._removeFiles();
                break;
              case this == "profileImage" && plugin.table == "users":
                plugin.modal
                  .find(".upload-box .img")
                  .attr("src", IMG + response.msg.items[field]);
                break;
              default:
                if ($("#" + this).is("input")) {
                  if ($("#" + this).is(":checkbox")) {
                    if (response.msg.items[field] == "on") {
                      $("#" + this).prop("checked", true);
                    } else {
                      $("#" + this).prop("checked", false);
                    }
                  } else {
                    $("#" + this).val(response.msg.items[field]);
                  }
                } else {
                  $("#" + this).html(response.msg.items[field]);
                }
                break;
            }
          });

          if (response.msg.selectedOptions.hasOwnProperty("categorie")) {
            if (response.msg.selectedOptions["categorie"].length > 0) {
              if (params.hasOwnProperty("categorieElement")) {
                response.msg.selectedOptions["categorie"][1].forEach((cat) => {
                  params.categorieElement
                    .find("input[value='" + cat + "']")
                    .prop("checked", true);
                });
              }
            }
          }
          if (plugin.form) plugin._money_format(plugin.form);
        } else {
          if (plugin.form.find("#tbl-alertErr").length != 0) {
            plugin.form.find("#tbl-alertErr").html(response.msg);
          } else {
            plugin.form.find("#alertErr").html(response.msg);
          }
        }
      }
    });
  };

  //=======================================================================
  //Delete
  //=======================================================================
  _get_delete_data = (selector, params) => {
    let table = this.table;
    let result;
    let id;
    switch (table) {
      case "users":
        id = selector.parent().find("input[name=userID]").val();
        break;
      default:
        id = selector.attr("id");
        break;
    }
    if (params["dataType"] && params.dataType != "frm") {
      result = {
        table: table,
        frm_name: selector.attr("id"),
        method: params.method != "" ? params.method : "",
        id: id ? id : "",
      };
    } else {
      result =
        selector.find("input[type='hidden']").serialize() +
        "&" +
        $.param({
          table: table,
          frm_name: selector.attr("id"),
          method: params.method != "" ? params.method : "",
          id: id ? id : "",
        });
    }
    return result;
  };

  _delete = (params) => {
    let plugin = this;
    plugin.wrapper.on("submit", params.delete_frm_class, function (e) {
      e.preventDefault();
      var data = {
        url: "delete",
        url_check: params.url_check != "" ? params.url_check : "",
        swal: params.hasOwnProperty("swal") && params.swal ? Swal : false,
        serverData: plugin._get_delete_data($(this), params),
      };
      Delete(data, manageR);
      function manageR(response) {
        if (response.result === "success") {
          if (params.hasOwnProperty("swal") && params.swal) {
            Swal.fire("Deleted!", response.msg, "success").then(() => {
              if (params.hasOwnProperty("datatable") && params.datatable) {
                plugin._displayAll(params);
              } else {
                location.reload();
              }
            });
          }
        } else {
          if (plugin.form.find("#alertErr").length == 0) {
            plugin.form.find("#tbl-alertErr").html(response.msg);
          } else {
            plugin.form.find("#alertErr").html(response.msg);
          }
        }
      }
    });
  };

  //=======================================================================
  //Restore
  //=======================================================================

  _restore = (params) => {
    let plugin = this;
    plugin.wrapper.on("submit", params.restore_frm_class, function (e) {
      e.preventDefault();
      console.log($(this).attr("id"), params.resto_class);
      var data = {
        url: "delete",
        swal: Swal,
        swal_button: params.swal_button,
        swal_message: params.swal_message,
        serverData: plugin._get_delete_data($(this), params),
      };
      Delete(data, manageR);
      function manageR(response) {
        if (response.result === "success") {
          if (params.swal) {
            Swal.fire("Restore!", response.msg, "success").then(() => {
              if (params.datatable == true) {
                plugin._displayAll({ datatable: params.datatable });
              } else {
                location.reload();
              }
            });
          }
        } else {
          plugin.form.find("#alertErr").html(response.msg);
        }
      }
    });
  };

  //=======================================================================
  //clean form
  //=======================================================================
  _clean_form = (data = {}) => {
    const modal = this.modal;
    const form = this.form;
    const select = data.select ? data.select : this.select;
    const bsElement = this.bsElement;
    //remove invalid input on input focus
    input.removeInvalidInput(modal);
    //clean form on hide

    bsElement.addEventListener("hide.bs.modal", function () {
      if (modal.find(".is-invalid").length != 0) {
        input.reset_invalid_input(modal);
      }
      form[0].reset();
      if (select != "") {
        if (Array.isArray(select)) {
          $(select).each(function (i, tag) {
            modal.find(tag).empty();
            modal.find(tag).trigger("input");
          });
        } else {
          modal.find(select).empty();
          modal.find(select).trigger("input");
        }
      }
      data.upload_img ? modal.find(data.upload_img).attr("src", AVATAR) : "";
      modal.find("input[type='checkbox']").empty();
      if (data.hasOwnProperty("dropzone")) {
        $(data.dropzone.element)
          .find(".gallery-wrapper .gallery_item")
          .remove();
        $(data.dropzone.element).find(".message").show();
      }
      if (data.hasOwnProperty("select")) {
        $(data.select).each(function () {
          form.find("." + this).empty();
        });
      }
    });
  };
  // =======================================================================
  // Active/desactive plugin
  // =======================================================================
  _active_inactive_elmt = (params) => {
    let wrapper = this.wrapper;
    wrapper.on("click", ".activateBtn", function (e) {
      console.log("go");
      e.preventDefault();
      var data = {
        url: "updateFromTable",
        table: params.table,
        frm: $(this).parents("form"),
        frm_name: $(this).parents("form").attr("id"),
        method: "updateStatus",
        params: $(this),
      };
      console.log(data);
      Call_controller(data, Response);
      function Response(response, elmt) {
        if (response.result == "success") {
          response.msg == "green"
            ? elmt.attr("title", "Deactivate Category")
            : elmt.attr("title", "Activate Category");
          elmt
            .children()
            .first()
            .attr("style", "color:" + response.msg);
        } else {
          if (wrapper.find("#tbl-alertErr").length != 0) {
            wrapper.find("#tbl-alertErr").html(response.msg);
          } else {
            wrapper.find("#alertErr").html(response.msg);
          }
        }
      }
    });
  };
}
