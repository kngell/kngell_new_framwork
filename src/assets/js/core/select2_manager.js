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
    let select = params.element.select2({
      placeholder: "---" + params.placeholder + "---",
      maximumInputLength: 20,
      tags: true,
      tokenSeparators: [",", " "],
      allowClear: true,
      ajax: select2AjaxParams({
        url: "forms/showDetails",
        table: params.tbl_options != "" ? params.tbl_options : "",
        data_type: "select2",
        parentID: plugin.params.hasOwnProperty("parentID")
          ? plugin.params.parentID
          : "",
      }),
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
