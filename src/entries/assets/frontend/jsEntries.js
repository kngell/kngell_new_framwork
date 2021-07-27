//=======================================================================
//Js entries
//=======================================================================
module.exports = {
  entry: {
    //=======================================================================
    //globals
    //=======================================================================
    //main js
    "js/main/frontend/main": {
      import: ["js/main/frontend/main.js"],
      dependOn: "js/librairies/frontlib",
    },
    //Home plugins
    "js/plugins/homeplugins": {
      import: ["js/plugins_entries/homeplugins"],
      dependOn: "js/librairies/frontlib",
    },
    //=======================================================================
    //Home pages management
    //=======================================================================
    //Ecommerce - Index page js
    "js/custom/client/home/home": {
      import: ["js/custom/client/home/index"],
      dependOn: "js/librairies/frontlib",
    },
    //Ecommerce - Product page js
    "js/custom/client/home/product/product": {
      import: ["js/custom/client/home/product/product"],
      dependOn: "js/librairies/frontlib",
    },
    //Ecommerce - Details (custom) page js
    "js/custom/client/clothing/details": {
      import: ["js/custom/client/clothing/details"],
      dependOn: "js/librairies/frontlib",
    },
    //Ecommerce - Cart page js
    "js/custom/client/home/cart/cart": {
      import: ["js/custom/client/home/cart/cart"],
      dependOn: "js/librairies/frontlib",
    },

    //Ecommerce - Promotions page js
    "js/custom/client/clothing/clothing": {
      import: ["js/custom/client/clothing/clothing"],
      dependOn: "js/librairies/frontlib",
    },
    //Ecommerce - Boutique page js
    "js/custom/client/home/boutique/boutique": {
      import: ["js/custom/client/home/boutique/boutique"],
      dependOn: "js/librairies/frontlib",
    },
    //=======================================================================
    //Users Management pages
    //=======================================================================
    //Ecommerce - Profile page js
    "js/custom/client/users/account/account": {
      import: ["js/custom/client/users/account/account"],
      dependOn: "js/librairies/frontlib",
    },
    //Ecommerce - Profile page js
    "js/custom/client/users/account/profile": {
      import: ["js/custom/client/users/account/profile"],
      dependOn: "js/librairies/frontlib",
    },
    //Ecommerce - Login page js
    "js/custom/client/users/account/login": {
      import: ["js/custom/client/users/account/login"],
      dependOn: "js/librairies/frontlib",
    },
    //Ecommerce - Login page js
    "js/custom/client/users/account/resetpassword": {
      import: ["js/custom/client/users/account/resetpassword"],
      dependOn: "js/librairies/frontlib",
    },
    //=======================================================================
    //Users Checkout
    //=======================================================================
    //Ecommerce - Payment page js
    "js/custom/client/users/payment/payment_success": {
      import: ["js/custom/client/users/payment/payment_success"],
      dependOn: "js/librairies/frontlib",
    },
    //Ecommerce - Checkout page js
    "js/custom/client/users/checkout/checkout": {
      import: ["js/custom/client/users/checkout/checkout"],
      dependOn: "js/librairies/frontlib",
    },
  },
};
