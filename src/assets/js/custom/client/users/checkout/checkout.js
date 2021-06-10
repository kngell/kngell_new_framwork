import payment from "corejs/payment_Toogle";
import OP from "corejs/operator";
class Checkout {
  constructor(element) {
    this.element = element;
  }

  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };

  _setupVariables = () => {
    this.navigation = this.element.find(".navigation");
    this.tab_content = this.element.find(".tab-content");
    this.wrapper = this.element.find(".page-content");
  };

  _setupEvents = () => {
    var phpPlugin = this;

    //=======================================================================
    //Toogle Payment
    //=======================================================================
    new payment().init();

    //=======================================================================
    //Currency format
    //=======================================================================
    const operation = new OP();
    operation._format_money({
      wrapper: phpPlugin.wrapper,
      fields: [
        ".sub-total .amount",
        ".p-price",
        ".res-tax-item .amount",
        ".total-ttc .amount",
        ".total-ht",
      ],
    });
    //=======================================================================
    //Tab navigation nex/ previous
    //=======================================================================
    let currentCompleted = phpPlugin.navigation
      .find(".nav > .nav-item > .active")
      .parent()
      .index();
    phpPlugin.wrapper.on("click", ".next,.previous, .nav a", function (e) {
      e.preventDefault();
      const currentElt = phpPlugin.navigation.find(
        ".nav > .nav-item > .active"
      );
      let nextelt = "";
      if ($(this).hasClass("next")) {
        currentCompleted++;
        nextelt = currentElt.parent().next().children();
      } else if ($(this).hasClass("previous")) {
        currentCompleted--;
        nextelt = currentElt.parent().prev().children();
      } else {
        if ($(this).hasClass("nav-link")) {
          currentCompleted = $(this).parent().index();
          nextelt = currentElt.parent().children();
        }
      }
      const circles = phpPlugin.navigation.find(".circle");
      if (currentCompleted > circles.length) {
        currentCompleted = circles.length;
      }
      if (currentCompleted < 1) {
        currentCompleted = 1;
      }
      circles.each((index, circle) => {
        if (index < currentCompleted) {
          $(circle).addClass("completed");
          $(circle).next().addClass("step-text");
        } else {
          $(circle).removeClass("completed");
          $(circle).next().removeClass("step-text");
        }
      });
      const completed = phpPlugin.navigation.find(".completed");
      const progress = phpPlugin.navigation.find("#progress");
      progress.css({
        width: ((completed.length - 1) / (circles.length - 1)) * 100 + "%",
      });
      if (currentCompleted === 1) {
        phpPlugin.navigation.find(".previous").prop("disabled", true);
        phpPlugin.navigation.find(".next").prop("disabled", false);
      } else if (currentCompleted === circles.length) {
        phpPlugin.navigation.find(".next").prop("disabled", true);
        phpPlugin.navigation.find(".previous").prop("disabled", false);
      } else {
        phpPlugin.navigation.find(".previous").prop("disabled", false);
        phpPlugin.navigation.find(".next").prop("disabled", false);
      }
      if (!$(this).hasClass("nav-link")) {
        const nextTab = nextelt.attr("href");
        const currentTab = currentElt.attr("href");
        currentElt.removeClass("active");
        nextelt.addClass("active");
        $(currentTab).removeClass("show active");
        $(nextTab).addClass("show active");
      }
    });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new Checkout($("#main-site"))._init();
});
