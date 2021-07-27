import Toggle from "corejs/payment_Toogle";
import OP from "corejs/operator";
import { Call_controller } from "corejs/form_crud";
import input from "corejs/inputErrManager";
import StripeAPI from "corejs/stripeAPIClient";
import { Modal } from "bootstrap";
import select2 from "corejs/select2_manager";
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
    this.modal_email = this.element.find("#modal-box-email");
    this.modal_address_change = this.element.find("#modal-box-change-address");
    this.modal_address_add = this.element.find("#modal-box-add-address");
    this.modal_shipping = this.element.find("#modal-box-shipping");

    this.bsmodal_email = Modal.getOrCreateInstance(
      document.getElementById("modal-box-email")
    );
    this.bsmodal_address_change = Modal.getOrCreateInstance(
      document.getElementById("modal-box-change-address")
    );
    this.bsmodal_address_add = Modal.getOrCreateInstance(
      document.getElementById("modal-box-add-address")
    );
    this.bsmodal_shipping = Modal.getOrCreateInstance(
      document.getElementById("modal-box-shipping")
    );
    this.address_type = "shipping";
  };

  _setupEvents = () => {
    var phpPlugin = this;

    const select = new select2();
    const csrftoken = document.querySelector('meta[name="csrftoken"]');
    select._init({
      element: phpPlugin.wrapper.find("#pays"),
      placeholder: "Please select a country",
      url: "get_countries",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
    });

    select._init({
      element: phpPlugin.modal_shipping.find("#shipping_class_change"),
      placeholder: "Please select a shipping class",
      url: "showDetails",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      dropdownParent: phpPlugin.modal_shipping,
      tbl_options: "shipping_class",
    });

    select._init({
      element: phpPlugin.modal_address_add.find("#chg-pays"),
      placeholder: "Please select a country",
      url: "get_countries",
      csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
      frm_name: "all_product_page",
      dropdownParent: phpPlugin.modal_address_add,
    });

    /**
     * Init stripe JS
     * ========================================================================
     */
    const stripeApi = new StripeAPI({
      api_key: phpPlugin.wrapper.find("#stripe_key").val(), // ok
      cardHolderLname: document.getElementById("cc_lastName"), //ok
      cardHolderFname: document.getElementById("cc_firstName"), //ok
      cardElement: document.getElementById("card-element"), //ok
      cardError: document.getElementById("card-error"), //ok
      cardErrorID: "#card-error",
      cardButton: document.getElementById("complete-order"), //ok
      cardButtonID: "#complete-order",
      responseError: document.getElementById("stripeErr"), //ok
    });
    /**
     * Clean forms
     * ========================================================================
     */
    input.removeInvalidInput(phpPlugin.modal_email.find("#change-email-frm"));
    input.removeInvalidInput(phpPlugin.modal_email.find("#change-address-frm"));
    input.removeInvalidInput(phpPlugin.wrapper);
    document
      .getElementById("modal-box-email")
      .addEventListener("hide.bs.modal", function () {
        const frm = phpPlugin.modal_email.find("#change-email-frm");
        frm.get(0).reset();
        if (frm.find(".is-invalid").length != 0) {
          input.reset_invalid_input(frm);
        }
      });

    /**
     * Create stripe credit card
     * ========================================================================
     */
    stripeApi._create_cardElements();

    /**
     * Toogle Payment
     * =======================================================================
     */
    new Toggle();
    /**
     * Format Money
     * =======================================================================
     */
    const operation = new OP();
    operation._format_money({
      wrapper: phpPlugin.wrapper,
      fields: [
        ".sub-total .amount",
        ".p-price",
        ".res-tax-item .amount",
        ".total-ttc .amount",
        ".total-ht",
        ".price",
      ],
    });
    phpPlugin.wrapper.on(
      "click",
      ".payment-gateway input[name='pm_name']",
      function (e) {
        phpPlugin.wrapper
          .find("#cc_firstName")
          .val(phpPlugin.wrapper.find("#chk-firstName").val());
        phpPlugin.wrapper
          .find("#cc_lastName")
          .val(phpPlugin.wrapper.find("#chk-lastName").val());
      }
    );
    /**
     * Submit Checkout form
     * =======================================================================
     */
    phpPlugin.wrapper.on("submit", "#user-ckeckout-frm", function (e) {
      e.preventDefault();
      phpPlugin.wrapper.find("#complete-order").text("Please wait...");
      const frm = $(this);
      const pm_name = phpPlugin.wrapper
        .find(".payment-gateway input[name='pm_name']")
        .filter(":checked")
        .val();
      var data = {
        url: "check_paymentMode",
        csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
        frm_name: "all_product_page",
        pm_name: pm_name,
        params: { frm: frm, pm_name: pm_name },
      };
      Call_controller(data, (response, params) => {
        if (response.result == "success") {
          Object.getOwnPropertyNames(data).forEach(function (prop) {
            delete data[prop];
          });
          data.url = "placeOrder";
          data.frm = params.frm;
          data.frm_name = params.frm.attr("id");
          switch (true) {
            case params.pm_name == 1:
              stripeApi
                ._createPayment()
                .then((paymentMethod) => {
                  data.paymentMethod = paymentMethod;
                  Call_controller(data, (response) => {
                    if (response.result == "success") {
                      window.location.href = response.msg;
                    } else {
                      if (response.result == "error-field") {
                        input.error(phpPlugin.wrapper, response.msg1);
                        phpPlugin.wrapper.find("#alertErr").html(response.msg2);
                      } else {
                        phpPlugin.wrapper.find("#alertErr").html(response.msg);
                      }
                    }
                    const placeOrder =
                      '<span> Complete order</span> <i class="fal fa-angle-double-right"></i> <span id="button-text">Pay now</span>';
                    phpPlugin.wrapper.find("#complete-order").html(placeOrder);
                  });
                })
                .catch((error) => {
                  var data = {
                    url: "checkout/manage_paymentModeSelectErrors",
                    csrftoken: document
                      .querySelector('meta[name="csrftoken"]')
                      .getAttribute("content"),
                    frm_name: "all_product_page",
                    error: error,
                  };
                  Call_controller(data, (response) => {
                    phpPlugin.wrapper.find("#alertErr").html(response.msg);
                  });
                  const placeOrder =
                    '<span> Complete order</span> <i class="fal fa-angle-double-right"></i> <span id="button-text">Pay now</span>';
                  phpPlugin.wrapper.find("#complete-order").html(placeOrder);
                });
              break;
            case params.pm_name == 2:
              console.log("paypal");
              break;

            default:
              console.log("default");
              phpPlugin.wrapper
                .find("#alertErr")
                .html(
                  "<h6 class='text-center'>This Payment method is not set yet! Please choose another one</h6>"
                );
              break;
          }
        } else {
          phpPlugin.wrapper.find("#alertErr").html(response.msg);
          const placeOrder =
            '<span> Complete order</span> <i class="fal fa-angle-double-right"></i> <span id="button-text">Pay now</span>';
          phpPlugin.wrapper.find("#complete-order").html(placeOrder);
        }
      });
    });

    /**
     * Change Email
     * =======================================================================
     */
    phpPlugin.modal_email.on("submit", "#change-email-frm", function (e) {
      e.preventDefault();
      var data = {
        url: "manage_changeEmail",
        frm: $(this),
        frm_name: $(this).attr("id"),
      };
      Call_controller(data, (response) => {
        if (response.result == "success") {
          phpPlugin.wrapper.find(".contact-email").text(response.msg);
          phpPlugin.bsmodal_email.hide();
        } else {
          if (response.result == "error-field") {
            input.error(phpPlugin.modal_email, response.msg);
          } else {
            phpPlugin.wrapper.find("#alertErr").html(response.msg);
          }
        }
      });
    });

    /**
     * Update Shipping Infos
     * =======================================================================
     */
    function update_shippingInfos(response) {
      phpPlugin.wrapper
        .find(".total-shipping .title")
        .html(response.msg.shipping.name);
      phpPlugin.wrapper
        .find(".total-shipping .amount")
        .html(response.msg.shipping.price);
      phpPlugin.wrapper.find(".total-ttc .amount").html(response.msg.ttc);
      phpPlugin.wrapper
        .find(".shipping_method .method_title")
        .html(response.msg.shipping.name);
      phpPlugin.wrapper
        .find(".shipping_method .price")
        .html(response.msg.shipping.price);
      operation._format_money({
        wrapper: phpPlugin.wrapper,
        fields: [
          ".total-shipping .amount",
          ".total-ttc .amount",
          ".shipping_method .price",
        ],
      });
    }
    /**
     * Update Shipping method
     * =======================================================================
     */
    phpPlugin.wrapper.on(
      "change",
      "#shipping-information .radio__input",
      function () {
        const data = {
          url: "manage_changeShipping",
          csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
          frm_name: "all_product_page",
          shipping_class_change: $(this).val(),
        };
        Call_controller(data, (response) => {
          update_shippingInfos(response);
        });
      }
    );
    /**
     * Change Shipping mode
     * =======================================================================
     */
    phpPlugin.modal_shipping.on("submit", "#shipping-select-frm", function (e) {
      e.preventDefault();
      var data = {
        url: "manage_changeShipping",
        frm: $(this),
        frm_name: $(this).attr("id"),
      };
      Call_controller(data, (response) => {
        if (response.result == "success") {
          update_shippingInfos(response);
          phpPlugin.bsmodal_shipping.hide();
        }
      });
    });

    phpPlugin.wrapper.on(
      "change",
      "#order-billing-address .radio-check__wrapper input",
      function (e) {
        e.preventDefault();
        if ($(this).val() === "2") {
          phpPlugin.bsmodal_address_change.show();
          phpPlugin.address_type = "billing";
        } else {
          var data = {
            url: "manage_changeAdress",
            csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
            frm_name: "all_product_page",
          };
          Call_controller(data, (response) => {
            phpPlugin.wrapper.find(".bill-to-address").text(response.msg);
          });
        }
      }
    );
    /**
    php
     * Change Address Naviation
     * =======================================================================
     */
    phpPlugin.modal_address_change.on("click", ".card", function (e) {
      $(this)
        .addClass("card--active")
        .parent()
        .siblings()
        .children()
        .removeClass("card--active");
    });
    phpPlugin.wrapper.on("click", ".change-bill__btn", function () {
      phpPlugin.address_type = "billing";
    });
    phpPlugin.wrapper.on("click", ".change-ship__btn", function () {
      phpPlugin.address_type = "shipping";
    });
    /**
     * Closing Change Adress Modal and update shippind address
     * ======================================================================
     */
    phpPlugin.modal_address_change.on("click", ".closeAddress", function (e) {
      e.preventDefault();
      var data = {
        url: "manage_changeAdress",
        csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
        frm_name: "all_product_page",
        id: $(this)
          .parents(".address-book-wrapper")
          .find(".card--active")
          .children()
          .first()
          .val(),
        address_type: phpPlugin.address_type,
      };
      Call_controller(data, (response) => {
        if (phpPlugin.address_type == "shipping") {
          phpPlugin.wrapper.find(".ship-to-address").text(response.msg);
        } else {
          phpPlugin.wrapper.find(".bill-to-address").text(response.msg);
          phpPlugin.address_type = "shipping";
          if (
            phpPlugin.wrapper
              .find(
                "#order-billing-address .radio-check__wrapper input[type='radio']"
              )
              .filter(":checked")
              .val() === "2"
          ) {
            if (
              phpPlugin.wrapper
                .find("#billing-information .bill-address-ckeck")
                .is(":hidden")
            ) {
              phpPlugin.wrapper
                .find("#billing-information .bill-address-ckeck")
                .show();
            }
          }
        }

        phpPlugin.bsmodal_address_change.hide();
      });
    });

    /**
     * Show Modal to add new address
     * ======================================================================
     */
    phpPlugin.modal_address_change.on("click", ".addAddress", function (e) {
      e.preventDefault();
      phpPlugin.bsmodal_address_add.show();
    });

    /**
     * Add new Address to user address book list
     * ======================================================================
     */
    phpPlugin.modal_address_add.on("submit", "#add-address-frm", function (e) {
      e.preventDefault();
      e.stopPropagation();
      var data = {
        url: "manage_AddAdress",
        frm: $(this),
        frm_name: $(this).attr("id"),
      };
      Call_controller(data, (response) => {
        if (response.result == "success") {
          phpPlugin.modal_address_change
            .find("#showAdress")
            .append(response.msg);
          phpPlugin.bsmodal_address_add.hide();
        } else {
          if (response.result == "error-field") {
            input.error(phpPlugin.modal_address, response.msg);
          } else {
            phpPlugin.wrapper.find("#alertErr").html(response.msg);
          }
        }
      });
    });
    /**
     * Get Checkout data From User Session
     * ======================================================================
     */
    function get_checkoutSession() {
      var data = {
        url: "get_checkoutSession",
        csrftoken: csrftoken ? csrftoken.getAttribute("content") : "",
        frm_name: "all_product_page",
      };
      Call_controller(data, (response) => {
        phpPlugin.wrapper.find(".contact-email").html(response.msg.email);
        phpPlugin.wrapper
          .find(".ship-to-address")
          .html(response.msg.ship_address.name);
        phpPlugin.wrapper
          .find(".bill-to-address")
          .html(response.msg.bill_address.name);
        phpPlugin.wrapper
          .find(".shipping_method .method_title")
          .html(response.msg.shipping.name);
        phpPlugin.wrapper
          .find(".shipping_method .price")
          .html(response.msg.shipping.price);
        operation._format_money({
          wrapper: phpPlugin.wrapper,
          fields: [".shipping_method .price"],
        });
      });
    }
    /**
     * Navigation Next/Previous
     * =======================================================================
     */
    let currentCompleted = phpPlugin.navigation
      .find(".nav > .nav-item > .active")
      .parent()
      .index();
    phpPlugin.wrapper.on("click", ".next,.previous, .nav a", function (e) {
      e.preventDefault();
      get_checkoutSession();
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
