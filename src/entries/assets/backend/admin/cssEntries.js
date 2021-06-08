//=======================================================================
//Css entries
//=======================================================================
module.exports = {
  entry: {
    //Admin main
    "css/main/backend/admin/main": {
      import: ["css/main/backend/admin/main.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin plugins
    "css/plugins/adminplugins": {
      import: ["css/plugins_entries/adminplugins.sass"],
      dependOn: "css/librairies/adminlib",
    },

    // Admin dashboard
    "css/custom/admin/dashboard": {
      import: ["css/custom/admin/index.scss"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin caegories Management
    "css/custom/admin/products/categories": {
      import: ["css/custom/admin/products/categories.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin caegories Management
    "css/custom/admin/products/allunits": {
      import: ["css/custom/admin/products/allunits.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin all product
    "css/custom/admin/products/allproducts": {
      import: ["css/custom/admin/products/allproducts.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin product Details
    "css/custom/admin/products/product_details": {
      import: ["css/custom/admin/products/product_details.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin add new product
    "css/custom/admin/products/new_product": {
      import: ["css/custom/admin/products/new_product.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin users allusers
    "css/custom/admin/users/allusers": {
      import: ["css/custom/admin/users/allusers.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin users allusers
    "css/custom/admin/users/profile": {
      import: ["css/custom/admin/users/profile.scss"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin users permissions
    "css/custom/admin/users/permissions": {
      import: ["css/custom/admin/users/permissions.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Company
    "css/custom/admin/company/allcompanies": {
      import: ["css/custom/admin/company/allcompanies.sass"],
      dependOn: "css/librairies/adminlib",
    },
  },
};
