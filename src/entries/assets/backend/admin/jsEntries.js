//=======================================================================
//Js entries
//=======================================================================
module.exports = {
  entry: {
    //Main js
    "js/main/backend/admin/main": {
      import: ["js/main/backend/admin/main"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin plugins
    "js/plugins/adminplugins": {
      import: ["js/plugins_entries/adminplugins"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin dashboard index
    "js/custom/backend/admin/dashboard": {
      import: ["js/custom/backend/admin/dashboard/index"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin dashboard analytics
    "js/custom/backend/admin/analytics": {
      import: ["js/custom/backend/admin/dashboard/analytics"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin dashboard analytics
    "js/custom/backend/admin/calendar": {
      import: ["js/custom/backend/admin/calendar/calendar"],
      dependOn: "js/librairies/adminlib",
    },
    // Admin login
    "js/custom/backend/admin/login": {
      import: ["js/custom/backend/admin/login"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin categories management
    "js/custom/backend/admin/products/categories": {
      import: ["js/custom/backend/admin/products/categories"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin units management
    "js/custom/backend/admin/products/allunits": {
      import: ["js/custom/backend/admin/products/allunits"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin all products
    "js/custom/backend/admin/products/allproducts": {
      import: ["js/custom/backend/admin/products/allproducts"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin product Details
    "js/custom/backend/admin/products/product_details": {
      import: ["js/custom/backend/admin/products/product_details"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin New products
    "js/custom/backend/admin/products/new_product": {
      import: ["js/custom/backend/admin/products/new_product"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin users allusers
    "js/custom/backend/admin/users/allusers": {
      import: ["js/custom/backend/admin/users/allusers"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin users profile
    "js/custom/backend/admin/users/profile": {
      import: ["js/custom/backend/admin/users/profile"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin users permissions
    "js/custom/backend/admin/users/permissions": {
      import: ["js/custom/backend/admin/users/permissions"],
      dependOn: "js/librairies/adminlib",
    },
    //Company
    "js/custom/backend/admin/company/allcompanies": {
      import: ["js/custom/backend/admin/company/allcompanies"],
      dependOn: "js/librairies/adminlib",
    },
    //Brand
    "js/custom/backend/admin/products/brands": {
      import: ["js/custom/backend/admin/products/brands"],
      dependOn: "js/librairies/adminlib",
    },
    //Shippin Class
    "js/custom/backend/admin/shipping/shipping": {
      import: ["js/custom/backend/admin/shipping/shipping"],
      dependOn: "js/librairies/adminlib",
    },
    //Taxes
    "js/custom/backend/admin/company/taxes": {
      import: ["js/custom/backend/admin/company/taxes"],
      dependOn: "js/librairies/adminlib",
    },
  },
};
