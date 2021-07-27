class Details {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.single_product = this.element.find("#sproduct");
  };
  _setupEvents = () => {
    var phpPlugin = this;
    /**
     * Toogle Image
     * ========================================================================
     */
    var main_img = document.getElementById("main-img");
    document.querySelectorAll(".small-img").forEach((img) => {
      img.addEventListener("click", () => {
        main_img.src = img.src;
      });
    });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new Details($("#main-site"))._init();
});
