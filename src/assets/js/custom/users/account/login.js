const responsive = {
  0: {
    items: 1,
  },
  600: {
    items: 3,
  },
  1000: {
    items: 5,
  },
};
class Login {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.product_wrapper = this.element.find("#new-phones");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    //=======================================================================
    //Owl carousel
    //=======================================================================
    //new phones
    phpPlugin.product_wrapper.find(".owl-carousel").owlCarousel({
      loop: true,
      nav: false,
      dots: true,
      responsive: responsive,
    });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new Login($("#main-site"))._init();
});
