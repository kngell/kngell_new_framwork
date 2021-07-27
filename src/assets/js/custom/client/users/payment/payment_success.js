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

class Payment {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.newPhone = this.element.find("#new-phones");
    this.header = this.element.find("#header");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    document.onload = () => {
      console.log(phpPlugin.header.find(".cart_nb_elt"));
      phpPlugin.header.find(".cart_nb_elt").html();
    };

    //new product
    phpPlugin.newPhone.find(".owl-carousel").owlCarousel({
      loop: true,
      nav: false,
      dots: true,
      margin: 15,
      responsive: responsive,
    });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new Payment($("#body"))._init();
});
