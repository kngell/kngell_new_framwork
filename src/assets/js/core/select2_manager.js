import { select2AjaxParams } from "corejs/form_crud";
export default class Upload {
  constructor(params = {}) {
    this.params = params;
  }

  //=======================================================================
  //Manage select tag
  //=======================================================================
  _init = (params = {}) => {
    let plugin = this;
    var data = {};
    for (let [key, value] of Object.entries(params)) {
      if (!(value instanceof Object)) {
        if (key == "tbl_options") {
          key = "table";
        }
        data[`${key}`] = `${value}`;
      }
    }
    data["data_type"] = "select2";
    let select = params.element.select2({
      placeholder: "---" + params.placeholder + "---",
      maximumInputLength: 20,
      tags: true,
      tokenSeparators: [";", "\n", "\t"],
      allowClear: true,
      width: "resolve",
      ajax: select2AjaxParams(data),
      dropdownParent: params.hasOwnProperty("dropdownParent")
        ? params.dropdownParent
        : "",
    });
    plugin.select = select;
    return plugin;
  };
  _destroy = () => {
    if (this.select.hasClass("select2-hidden-accessible")) {
      this.select.select2("destroy");
    }
  };
}
