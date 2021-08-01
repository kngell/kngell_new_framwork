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

    // Admin dashboard Index
    "css/custom/backend/admin/dashboard": {
      import: ["css/custom/backend/admin/index.scss"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin caegories Management
    "css/custom/backend/admin/products/categories": {
      import: ["css/custom/backend/admin/products/categories.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin caegories Management
    "css/custom/backend/admin/products/allunits": {
      import: ["css/custom/backend/admin/products/allunits.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin all product
    "css/custom/backend/admin/products/allproducts": {
      import: ["css/custom/backend/admin/products/allproducts.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin product Details
    "css/custom/backend/admin/products/product_details": {
      import: ["css/custom/backend/admin/products/product_details.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin add new product
    "css/custom/backend/admin/products/new_product": {
      import: ["css/custom/backend/admin/products/new_product.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin users allusers
    "css/custom/backend/admin/users/allusers": {
      import: ["css/custom/backend/admin/users/allusers.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin users allusers
    "css/custom/backend/admin/users/profile": {
      import: ["css/custom/backend/admin/users/profile.scss"],
      dependOn: "css/librairies/adminlib",
    },
    //Admin users permissions
    "css/custom/backend/admin/users/permissions": {
      import: ["css/custom/backend/admin/users/permissions.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Company
    "css/custom/backend/admin/company/allcompanies": {
      import: ["css/custom/backend/admin/company/allcompanies.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Brand
    "css/custom/backend/admin/products/brands": {
      import: ["css/custom/backend/admin/products/brands.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Shipping
    "css/custom/backend/admin/shipping/shipping": {
      import: ["css/custom/backend/admin/shipping/shipping.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //taxes
    "css/custom/backend/admin/company/taxes": {
      import: ["css/custom/backend/admin/company/taxes.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //order
    "css/custom/backend/admin/orders/orders": {
      import: ["css/custom/backend/admin/orders/orders.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Warehouses
    "css/custom/backend/admin/warehouse/warehouse": {
      import: ["css/custom/backend/admin/warehouse/warehouse.sass"],
      dependOn: "css/librairies/adminlib",
    },
    //Settings
    "css/custom/backend/admin/settings/general": {
      import: ["css/custom/backend/admin/settings/general.sass"],
      dependOn: "css/librairies/adminlib",
    },
    "css/custom/backend/admin/settings/sliders": {
      import: ["css/custom/backend/admin/settings/sliders.sass"],
      dependOn: "css/librairies/adminlib",
    },
  },
};
