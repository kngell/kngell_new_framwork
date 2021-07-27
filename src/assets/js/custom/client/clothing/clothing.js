import { BASE_URL } from "corejs/config";
class Clothing {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.wrapper = this.element.find("#main-site");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    // phpPlugin.wrapper.on("click", ".products-item", function (e) {
    //   e.preventDefault();
    //   window.location.href = BASE_URL + "details";
    // });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new Clothing($("#body"))._init();
});
