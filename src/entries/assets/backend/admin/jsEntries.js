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
    "js/custom/admin/dashboard": {
      import: ["js/custom/admin/dashboard/index"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin dashboard analytics
    "js/custom/admin/analytics": {
      import: ["js/custom/admin/dashboard/analytics"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin dashboard analytics
    "js/custom/admin/calendar": {
      import: ["js/custom/admin/calendar/calendar"],
      dependOn: "js/librairies/adminlib",
    },
    // Admin login
    "js/custom/admin/login": {
      import: ["js/custom/admin/login"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin categories management
    "js/custom/admin/products/categories": {
      import: ["js/custom/admin/products/categories"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin units management
    "js/custom/admin/products/allunits": {
      import: ["js/custom/admin/products/allunits"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin all products
    "js/custom/admin/products/allproducts": {
      import: ["js/custom/admin/products/allproducts"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin product Details
    "js/custom/admin/products/product_details": {
      import: ["js/custom/admin/products/product_details"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin New products
    "js/custom/admin/products/new_product": {
      import: ["js/custom/admin/products/new_product"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin users allusers
    "js/custom/admin/users/allusers": {
      import: ["js/custom/admin/users/allusers"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin users profile
    "js/custom/admin/users/profile": {
      import: ["js/custom/admin/users/profile"],
      dependOn: "js/librairies/adminlib",
    },
    //Admin users permissions
    "js/custom/admin/users/permissions": {
      import: ["js/custom/admin/users/permissions"],
      dependOn: "js/librairies/adminlib",
    },
    //Company
    "js/custom/admin/company/allcompanies": {
      import: ["js/custom/admin/company/allcompanies"],
      dependOn: "js/librairies/adminlib",
    },
  },
};
