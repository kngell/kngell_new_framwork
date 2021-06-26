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
import { Call_controller } from "corejs/form_crud";
import user_cart from "corejs/user_cart";
import OP from "corejs/operator";
import { BASE_URL } from "corejs/config";
import log_reg from "corejs/logregloader";
import { each } from "jquery";
class Cart {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.lr = this.element.find("#Login-Register-System");
    this.wrapper = this.element.find("#main-site");
    this.header = this.element.find("#header");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    //=======================================================================
    //Display user cart items and format prices
    //=======================================================================
    let display = new user_cart(phpPlugin.wrapper, phpPlugin.header);
    // display._display_cart();
    const operation = new OP();
    setTimeout(function () {
      operation._format_money({
        wrapper: phpPlugin.wrapper,
        fields: [
          "#deal-price",
          ".product_price",
          ".res-tax-item .value",
          "#total-price",
        ],
      });
    }, 500);
    //=======================================================================
    //Owl carousel
    //=======================================================================
    //new phones
    phpPlugin.wrapper.find("#new-phones").find(".owl-carousel").owlCarousel({
      loop: true,
      nav: false,
      dots: true,
      responsive: responsive,
    });

    //=======================================================================
    //Qty section
    //=======================================================================
    function get_product(form, elt) {
      const review_price = true;
      const qty = form.find(".qty_input").val();
      if (review_price) {
        var data = {
          table: "cart",
          url: "forms/showDetails",
          data_type: "values",
          model_method: "update_UserCartPrice",
          frm: form,
          params: elt,
        };
        Call_controller(data, display_product);
        function display_product(response, elt) {
          if (response.result == "success") {
            // 1- updat product price
            elt
              .parents(".cart-qty")
              .parent()
              .next()
              .find(".product_price")
              .html(function () {
                return operation._currency.format(
                  parseFloat(
                    response.msg[0].p_regular_price * response.msg[0].item_qty
                  )
                );
              });
            // 2- update subtotal price
            phpPlugin.wrapper
              .find("#deal-price")
              .html(function (i, deal_price) {
                return operation._currency.format(
                  operation._parseLocaleNumber(deal_price, "de") -
                    (parseInt(response.msg[2]) - response.msg[0].item_qty) *
                      parseFloat(response.msg[0].p_regular_price)
                );
              });
            //3-Update taxes and TTC
            if (response.msg[1].length != 0) {
              // a)- update Taxe line values
              $.each(response.msg[1], function (key, val) {
                $("." + key + " .value").html(function (i, tax) {
                  const old_tax =
                    (parseFloat(response.msg[0].p_regular_price) *
                      parseFloat(response.msg[1][key][2]) *
                      response.msg[2]) /
                    100;
                  const actual_tax =
                    operation._parseLocaleNumber(tax, "de") - old_tax + val[0];
                  return operation._currency.format(
                    operation._parseLocaleNumber(tax, "de") - old_tax + val[0]
                  );
                });
              });
              //b) Update total price ttc
              phpPlugin.wrapper
                .find("#total-price")
                .html(function (i, t_price) {
                  const old_price = operation._parseLocaleNumber(t_price, "de");
                  let taxes = 0;
                  $.each(response.msg[1], function (key, val) {
                    const old_tax =
                      (parseFloat(response.msg[0].p_regular_price) *
                        parseFloat(response.msg[1][key][2]) *
                        parseInt(response.msg[2])) /
                      100;
                    const actual_tax = val[0];
                    taxes = taxes + (actual_tax - old_tax);
                  });
                  return operation._currency.format(
                    old_price +
                      taxes +
                      (parseInt(response.msg[0].item_qty) -
                        parseInt(response.msg[2])) *
                        parseFloat(response.msg[0].p_regular_price)
                  );
                });
            } else {
              phpPlugin.wrapper
                .find("#total-price")
                .html(function (i, t_price) {
                  return operation._currency.format(
                    operation._parseLocaleNumber(t_price, "de") -
                      (parseInt(response.msg[2]) - qty) *
                        parseFloat(response.msg[0].p_regular_price)
                  );
                });
            }
          }
        }
      }
    }
    // Qty up
    phpPlugin.wrapper.find("#cart_items").on("click", ".qty-up", function (e) {
      e.preventDefault();
      const input = $(this).next();
      const data = $(this).parent();
      input.val(function (i, oldval) {
        return !isNaN(oldval) ? ++oldval : oldval;
      });
      operation._wait(get_product(data, $(this)), 2000);
    });
    // Qty down
    phpPlugin.wrapper
      .find("#cart_items")
      .on("click", ".qty-down", function (e) {
        e.preventDefault();
        const input = $(this).prev();
        const data = $(this).parent();
        input.val(function (i, oldval) {
          return !isNaN(oldval) && oldval > 1 ? --oldval : oldval;
        });
        operation._wait(get_product(data, $(this)), 2000);
      });
    // Qty dManual add

    phpPlugin.wrapper
      .find("#cart_items")
      .on("input", ".qty_input", function (e) {
        e.preventDefault();
        const input = $(this);
        const data = $(this).parent();

        if (input.val() >= 1) {
          operation._wait(get_product(data, $(this)), 2000);
        } else {
          input.val(function (i, oldval) {});
        }
      });
    //=======================================================================
    //Show wishlist section
    //=======================================================================
    // console.log(phpPlugin.wrapper.find("#wishlist-items").length);
    show_wishlist();
    function show_wishlist() {
      if (phpPlugin.wrapper.find("#wishlist-items").children().length == 0) {
        phpPlugin.wrapper.find("#wishlist").hide();
      } else {
        phpPlugin.wrapper.find("#wishlist").show();
      }
    }
    //=======================================================================
    //Refresh deal price
    //=======================================================================
    function refresh_subtotal(resp, qty) {
      const elmt = phpPlugin.wrapper.find("#sub_total");
      console.log(qty);
      //1- update nb items
      elmt.find(".nb-item .cart_nb_elt").html(function (i, nb_items) {
        return parseInt(nb_items) - 1;
      });
      //2- update deal price (ht)
      elmt.find("#deal-price").html(function (i, d_price) {
        const deal_price = operation._parseLocaleNumber(d_price, "de");
        const item_price = parseFloat(resp[0]);
        return operation._currency.format(deal_price - item_price * qty);
      });
      //3- update taxes
      if (!resp[1].hasOwnProperty("")) {
        if (Object.getOwnPropertyNames(resp[1]).length >= 0) {
          $.each(resp[1], function (key, val) {
            const tax_elmt = elmt.find("." + key + " .value");
            tax_elmt.html(function (i, amount) {
              const item_tax =
                (parseFloat(val) * qty * parseFloat(resp[0])) / 100;
              const cart_taxe = operation._parseLocaleNumber(amount, "de");
              let new_cart_tax = operation._currency.format(
                cart_taxe - item_tax
              );
              if (operation._parseLocaleNumber(new_cart_tax, "de") == 0) {
                elmt.find("." + key).hide();
              } else {
                elmt.find("." + key).show();
              }
              return new_cart_tax;
            });
          });
        }
      }
      //4- update ttc ttc - item price - taxes associées
      elmt.find("#total-price").html(function (i, t_price) {
        let total_price = operation._parseLocaleNumber(t_price, "de");
        //remove tax
        if (!resp[1].hasOwnProperty("")) {
          if (Object.getOwnPropertyNames(resp[1]).length > 0) {
            $.each(resp[1], function (key, val) {
              const item_tax =
                (parseFloat(val) * qty * parseFloat(resp[0])) / 100;
              console.log(key, val, item_tax, t_price);
              total_price = total_price - item_tax;
            });
          }
        }
        return operation._currency.format(
          total_price - parseFloat(resp[0] * qty)
        );
      });
    }
    //=======================================================================
    //Delete cart or wisjlist
    //=======================================================================
    phpPlugin.wrapper.on(
      "click",
      "#cart_items .deleteBtn, #wishlist-items .deleteBtn",
      function (e) {
        e.preventDefault();
        $(this).html("Please wait...");
        let wishlist = false;
        let cart = false;
        let qty = 1;
        if ($(this).parents(".cart-row").parents("#cart_items").length != 0) {
          cart = true;
          qty = $(this).parents("form").prev().find(".qty_input").val();
        }
        let remove_btn = "btn-success";
        var data = {
          url: "guests/delete",
          table: "cart",
          method: "delete_cart",
          frm: $(this).parent(),
          params: $(this),
          frm_name: $(this).parent().attr("class"),
        };
        Call_controller(data, manageResponse);
        function manageResponse(response, elt) {
          if (response.result == "success") {
            elt.parents(".cart-row").remove();
            if (
              phpPlugin.wrapper.find("#wishlist-items").children().length != 0
            ) {
              wishlist = true;
              remove_btn = "btn-info";
            }
            if (cart) {
              refresh_subtotal(response.msg, qty);
            }

            show_wishlist();
            if (!wishlist) {
              phpPlugin.header.find(".cart_nb_elt").html(function () {
                return (
                  parseInt(phpPlugin.header.find(".cart_nb_elt").html()) - 1
                );
              });
            }
            phpPlugin.wrapper
              .find("#new-phones")
              .find(
                ".add_to_cart_frm input[value='" +
                  elt.parent().find("input[name='item_id']").val() +
                  "']"
              )
              .parent()
              .find("button[type=submit]")
              .removeClass(remove_btn)
              .addClass("btn-warning")
              .html("Add to Cart");
            if (phpPlugin.wrapper.find("#cart_items").children().length == 0) {
              phpPlugin.wrapper.find("#cart_items").html(response.msg[2]);
            }
          }
        }
      }
    );

    //=======================================================================
    //Save for later / Or Add to cart from wishlist
    //=======================================================================
    phpPlugin.wrapper.on(
      "click",
      "#cart_items .cart-qty button[type=button], #wishlist-items .cart-qty button[type=button]",
      function (e) {
        e.preventDefault();
        let method = "";
        let msg = "";
        let btn_bg = "";
        if ($(this).parents("#cart").length) {
          method = "save_For_Later";
          msg = "In whislist";
          btn_bg = "btn-info";
        } else {
          if ($(this).parents("#wishlist").length) {
            method = "add_To_Cart";
            msg = "In the cart";
            btn_bg = "btn-success";
          }
        }
        $(this).html("Please Wait...");
        var data = {
          url: "guests/toggleWishlistAndcCart",
          frm: $(this).parent(),
          frm_name:
            "delete-cart-item-frm" +
            $(this).parent().find("input[name='item_id']").val(),
          table: "cart",
          params: $(this),
          method: method,
        };
        Call_controller(data, manageResponse);
        function manageResponse(response, elt) {
          if (response.result == "success") {
            display._display_cart();
            if (method == "add_To_Cart") {
              elt.parents(".cart-row").remove();
              if (
                phpPlugin.wrapper.find("#wishlist-items").children().length == 0
              ) {
                phpPlugin.wrapper.find("#wishlist").hide();
              }
            }
            phpPlugin.wrapper
              .find("#new-phones")
              .find(
                ".add_to_cart_frm input[value='" +
                  elt.parents("form").find("input[name='item_id']").val() +
                  "']"
              )
              .parent()
              .find("button[type=submit]")
              .removeClass("btn-info")
              .addClass(btn_bg)
              .html(msg);
          }
        }
      }
    );
    //=======================================================================
    //Peoceed to pay
    //=======================================================================
    phpPlugin.wrapper.find("#sub_total").on("click", ".buy-btn", function (e) {
      e.preventDefault();
      var data = {
        url: "checkout/proceedToBuy",
        frm: $(this).parent(),
        frm_name: "buy-frm",
      };
      Call_controller(data, manageR);
      function manageR(response) {
        if (response.result == "success") {
          if (response.msg == "checkout") {
            window.location.href = BASE_URL + "users/checkout";
          } else if (response.msg == "login-required") {
            (async () => {
              const bs = await import(
                /* webpackChunkName: "bsmodal" */ "corejs/bootstrap_modal"
              );
              bs.login_modal.toggle();
              var loader = new log_reg().check();
              if (!loader.isLoad) {
                loader.login();
              }
              phpPlugin.lr.find("#input_checkout").val("checkout");
            })();
          }
        } else {
        }
      }
    });
  };
}
document.addEventListener("DOMContentLoaded", function () {
  new Cart($("#body"))._init();
});
