//=======================================================================
//Css entries
//=======================================================================
module.exports = {
  entry: {
    //=======================================================================
    //Globals
    //=======================================================================
    //Front pages
    "css/main/frontend/main": {
      import: ["css/main/frontend/main.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Home plugins
    "css/plugins/homeplugins": {
      import: ["css/plugins_entries/homeplugins.scss"],
      dependOn: "css/librairies/frontlib",
    },
    //=======================================================================
    //Homes Management pages
    //=======================================================================
    //Index page css ecommerce
    "css/custom/home/home": {
      import: ["css/custom/home/index.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Product page prodict standard Ecommerce
    "css/custom/home/product/product": {
      import: ["css/custom/home/product/product.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Product page Product Details custom Ecommerce
    "css/custom/home/product/details": {
      import: ["css/custom/home/product/details.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Cart Page
    "css/custom/home/cart/cart": {
      import: ["css/custom/home/cart/cart.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Promotions Page
    "css/custom/home/promotions/promotions": {
      import: ["css/custom/home/promotions/promotions.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Boutique Page
    "css/custom/home/boutique/boutique": {
      import: ["css/custom/home/boutique/boutique.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //=======================================================================
    //Users Management pages
    //=======================================================================
    //Ecommerce - Account Page
    "css/custom/users/account/account": {
      import: ["css/custom/users/account/account.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Account Page
    "css/custom/users/account/profile": {
      import: ["css/custom/users/account/profile.scss"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Login Page
    "css/custom/users/account/login": {
      import: ["css/custom/users/account/login.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Reset password
    "css/custom/users/account/resetpassword": {
      import: ["css/custom/users/account/resetpassword.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //=======================================================================
    //Users Checkout pages
    //=======================================================================
    //Ecommerce - Payement page
    "css/custom/users/checkout/payment": {
      import: ["css/custom/users/checkout/payment.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Checkout Page
    "css/custom/users/checkout/checkout": {
      import: ["css/custom/users/checkout/checkout.sass"],
      dependOn: "css/librairies/frontlib",
    },
  },
};
