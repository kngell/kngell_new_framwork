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
    "css/custom/client/home/home": {
      import: ["css/custom/client/home/index.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Product page prodict standard Ecommerce
    "css/custom/client/home/product/product": {
      import: ["css/custom/client/home/product/product.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Product page Product Details custom Ecommerce
    "css/custom/client/clothing/details": {
      import: ["css/custom/client/clothing/details.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Cart Page
    "css/custom/client/home/cart/cart": {
      import: ["css/custom/client/home/cart/cart.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Promotions Page
    "css/custom/client/clothing/clothing": {
      import: ["css/custom/client/clothing/clothing.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Boutique Page
    "css/custom/client/home/boutique/boutique": {
      import: ["css/custom/client/home/boutique/boutique.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Contact
    "css/custom/client/home/contact/contact": {
      import: ["css/custom/client/home/contact/contact.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //=======================================================================
    //Users Management pages
    //=======================================================================
    //Ecommerce - Account Page
    "css/custom/client/users/account/account": {
      import: ["css/custom/client/users/account/account.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Account Page
    "css/custom/client/users/account/profile": {
      import: ["css/custom/client/users/account/profile.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Login Page
    "css/custom/client/users/account/login": {
      import: ["css/custom/client/users/account/login.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Reset password
    "css/custom/client/users/account/resetpassword": {
      import: ["css/custom/client/users/account/resetpassword.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //=======================================================================
    //Users Checkout pages
    //=======================================================================
    //Ecommerce - Payement page
    "css/custom/client/users/payment/payment_success": {
      import: ["css/custom/client/users/payment/payment_success.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Ecommerce - Checkout Page
    "css/custom/client/users/checkout/checkout": {
      import: ["css/custom/client/users/checkout/checkout.sass"],
      dependOn: "css/librairies/frontlib",
    },
  },
};
