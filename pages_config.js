'use strict';

const _entries = {
  app: './app/assets/js/app.js',
  ecommerce: './app/assets/js/ecommerce.js',
  ecommerce_product_detail: './app/assets/js/product_detail.js',
  dashboard_analytics: './app/assets/js/dashboard_analytics.js',
  dashboard_ecommerce: './app/assets/js/dashboard_ecommerce.js',
  demo_add_product: './app/assets/js/demo/demo_add_product.js',
  demo_britecharts: './app/assets/js/demo/demo_britecharts.js',
  demo_calendar: './app/assets/js/demo/demo_calendar.js',
  demo_chartjs: './app/assets/js/demo/demo_chartjs.js',
  demo_crop_image: './app/assets/js/demo/demo_crop_image.js',
  demo_datatable: './app/assets/js/demo/demo_datatable.js',
  demo_dropzone: './app/assets/js/demo/demo_dropzone.js',
  demo_dual_listbox: './app/assets/js/demo/demo_dual_listbox.js',
  demo_google_map: './app/assets/js/demo/demo_google_map.js',
  demo_jstree: './app/assets/js/demo/demo_jstree.js',
  demo_select2: './app/assets/js/demo/demo_select2.js',
  demo_sweetalert: './app/assets/js/demo/demo_sweetalert.js',
  demo_toastr: './app/assets/js/demo/demo_toastr.js',
  demo_jqvmap: './app/assets/js/demo/demo_jqvmap.js',
  demo_widget: './app/assets/js/demo/demo_widget.js',
};

const _page_options = [{
    title: 'E-commerce Dashboard',
    template: './app/content/dashboard/ecommerce.hbs',
    inject: 'body',
    filename: 'index.html',
    chunks: ['dashboard_ecommerce']
  },
  {
    title: 'Analytics Dashboard',
    template: './app/content/dashboard/analytics.hbs',
    inject: 'body',
    filename: 'dashboard-analytics.html',
    chunks: ['dashboard_analytics']
  },
  {
    title: 'Calendar',
    template: './app/content/calendar.hbs',
    inject: 'body',
    filename: 'calendar.html',
    chunks: ['demo_calendar']
  },
  {
    title: 'Chat',
    template: './app/content/chat.hbs',
    inject: 'body',
    filename: 'chat.html',
    chunks: []
  },
  //BEGIN ECOMMERCE
  {
    title: 'Products - Ecommerce',
    template: './app/content/ecommerce/products.hbs',
    inject: 'body',
    filename: 'ecommerce-products.html',
    chunks: ['ecommerce']
  },
  {
    title: 'Product Detail - Ecommerce',
    template: './app/content/ecommerce/product-detail.hbs',
    inject: 'body',
    filename: 'ecommerce-product-detail.html',
    chunks: ['ecommerce', 'ecommerce_product_detail']
  },
  {
    title: 'Add Product - Ecommerce',
    template: './app/content/ecommerce/add-product.hbs',
    inject: 'body',
    filename: 'ecommerce-add-product.html',
    chunks: ['ecommerce', 'demo_add_product']
  },
  {
    title: 'Orders - Ecommerce',
    template: './app/content/ecommerce/orders.hbs',
    inject: 'body',
    filename: 'ecommerce-orders.html',
    chunks: []
  },
  {
    title: 'Order Detail - Ecommerce',
    template: './app/content/ecommerce/order-detail.hbs',
    inject: 'body',
    filename: 'ecommerce-order-detail.html',
    chunks: ['ecommerce']
  },
  {
    title: 'Customers - Ecommerce',
    template: './app/content/ecommerce/customers.hbs',
    inject: 'body',
    filename: 'ecommerce-customers.html',
    chunks: ['ecommerce']
  },
  {
    title: 'Shopping Card - Ecommerce',
    template: './app/content/ecommerce/shopping-card.hbs',
    inject: 'body',
    filename: 'ecommerce-shopping-card.html',
    chunks: ['ecommerce']
  },
  {
    title: 'Checkout - Ecommerce',
    template: './app/content/ecommerce/checkout.hbs',
    inject: 'body',
    filename: 'ecommerce-checkout.html',
    chunks: ['ecommerce']
  },
  //END ECOMMERCE
  //BEGIN AUTHENTICATION
  {
    title: 'Login - Authentication',
    template: './app/content/pages/authentication/login.hbs',
    inject: 'body',
    filename: 'pages-authentication-login.html',
    chunks: []
  },
  {
    title: 'Register - Authentication',
    template: './app/content/pages/authentication/register.hbs',
    inject: 'body',
    filename: 'pages-authentication-register.html',
    chunks: []
  },
  {
    title: 'Forgot Password - Authentication',
    template: './app/content/pages/authentication/forgot-password.hbs',
    inject: 'body',
    filename: 'pages-authentication-forgot-password.html',
    chunks: []
  },
  {
    title: 'Confirm email - Authentication',
    template: './app/content/pages/authentication/confirm-email.hbs',
    inject: 'body',
    filename: 'pages-authentication-confirm-email.html',
    chunks: []
  },
  // END AUTHENTICATION
  {
    title: 'Contact',
    template: './app/content/pages/contact.hbs',
    inject: 'body',
    filename: 'pages-contact.html',
    chunks: []
  },
  {
    title: 'Page not found - Error',
    template: './app/content/pages/error/404.hbs',
    inject: 'body',
    filename: 'pages-error-404.html',
    chunks: []
  },
  {
    title: 'Internal Server Error - Error',
    template: './app/content/pages/error/500.hbs',
    inject: 'body',
    filename: 'pages-error-500.html',
    chunks: []
  },
  {
    title: 'FAQ',
    template: './app/content/pages/faq.hbs',
    inject: 'body',
    filename: 'pages-faq.html',
    chunks: []
  },
  {
    title: 'Invoice',
    template: './app/content/pages/invoice.hbs',
    inject: 'body',
    filename: 'pages-invoice.html',
    chunks: []
  },
  {
    title: 'Maintenance',
    template: './app/content/pages/maintenance.hbs',
    inject: 'body',
    filename: 'pages-maintenance.html',
    chunks: []
  },
  {
    title: 'Pricing',
    template: './app/content/pages/pricing.hbs',
    inject: 'body',
    filename: 'pages-pricing.html',
    chunks: []
  },
  {
    title: 'Profile',
    template: './app/content/pages/profile.hbs',
    inject: 'body',
    filename: 'pages-profile.html',
    chunks: ['demo_chartjs']
  },
  {
    title: 'Starter Page',
    template: './app/content/pages/starter.hbs',
    inject: 'body',
    filename: 'pages-starter.html',
    chunks: []
  },
  // BEGIN UI KIT
  {
    title: 'Avatar Components',
    template: './app/content/ui-kits/avatars.hbs',
    inject: 'body',
    filename: 'ui-kits-avatars.html',
    chunks: []
  },
  {
    title: 'Breadcrumb Components',
    template: './app/content/ui-kits/breadcrumbs.hbs',
    inject: 'body',
    filename: 'ui-kits-breadcrumbs.html',
    chunks: []
  },
  {
    title: 'Button Components',
    template: './app/content/ui-kits/buttons.hbs',
    inject: 'body',
    filename: 'ui-kits-buttons.html',
    chunks: []
  },
  {
    title: 'Card Components',
    template: './app/content/ui-kits/cards.hbs',
    inject: 'body',
    filename: 'ui-kits-cards.html',
    chunks: ['demo_widget']
  },
  {
    title: 'Dual List Box Components',
    template: './app/content/ui-kits/dual-listbox.hbs',
    inject: 'body',
    filename: 'ui-kits-dual-listbox.html',
    chunks: ['demo_dual_listbox']
  },
  {
    title: 'Image Cropper',
    template: './app/content/ui-kits/image-cropper.hbs',
    inject: 'body',
    filename: 'ui-kits-image-cropper.html',
    chunks: ['demo_crop_image']
  },
  {
    title: 'jsTree Components',
    template: './app/content/ui-kits/jstree.hbs',
    inject: 'body',
    filename: 'ui-kits-jstree.html',
    chunks: ['demo_jstree']
  },
  {
    title: 'Notification Components',
    template: './app/content/ui-kits/notifications.hbs',
    inject: 'body',
    filename: 'ui-kits-notifications.html',
    chunks: []
  },
  {
    title: 'Spinner Components',
    template: './app/content/ui-kits/spinners.hbs',
    inject: 'body',
    filename: 'ui-kits-spinners.html',
    chunks: []
  },
  {
    title: 'Sweet Alert Components',
    template: './app/content/ui-kits/sweetalert.hbs',
    inject: 'body',
    filename: 'ui-kits-sweetalert.html',
    chunks: ['demo_sweetalert']
  },
  {
    title: 'Tab Components',
    template: './app/content/ui-kits/tabs.hbs',
    inject: 'body',
    filename: 'ui-kits-tabs.html',
    chunks: []
  },
  {
    title: 'Toastr Components',
    template: './app/content/ui-kits/toastr.hbs',
    inject: 'body',
    filename: 'ui-kits-toastr.html',
    chunks: ['demo_toastr']
  },
  {
    title: 'Widgets',
    template: './app/content/ui-kits/widgets.hbs',
    inject: 'body',
    filename: 'ui-kits-widgets.html',
    chunks: []
  },
  // END UI KIT
  //BEGIN UTILITIES
  {
    title: 'Borders - Utilities',
    template: './app/content/utilities/borders.hbs',
    inject: 'body',
    filename: 'utilities-borders.html',
    chunks: []
  },
  {
    title: 'Colors - Utilities',
    template: './app/content/utilities/colors.hbs',
    inject: 'body',
    filename: 'utilities-colors.html',
    chunks: []
  },
  {
    title: 'Display - Utilities',
    template: './app/content/utilities/display.hbs',
    inject: 'body',
    filename: 'utilities-display.html',
    chunks: []
  },
  {
    title: 'Flex - Utilities',
    template: './app/content/utilities/flex.hbs',
    inject: 'body',
    filename: 'utilities-flex.html',
    chunks: []
  },
  {
    title: 'Float - Utilities',
    template: './app/content/utilities/float.hbs',
    inject: 'body',
    filename: 'utilities-float.html',
    chunks: []
  },
  {
    title: 'Interactions - Utilities',
    template: './app/content/utilities/interactions.hbs',
    inject: 'body',
    filename: 'utilities-interactions.html',
    chunks: []
  },
  {
    title: 'Overflow - Utilities',
    template: './app/content/utilities/overflow.hbs',
    inject: 'body',
    filename: 'utilities-overflow.html',
    chunks: []
  },
  {
    title: 'Positions - Utilities',
    template: './app/content/utilities/positions.hbs',
    inject: 'body',
    filename: 'utilities-positions.html',
    chunks: []
  },
  {
    title: 'Overflow - Utilities',
    template: './app/content/utilities/overflow.hbs',
    inject: 'body',
    filename: 'utilities-overflow.html',
    chunks: []
  },
  {
    title: 'Shadows - Utilities',
    template: './app/content/utilities/shadows.hbs',
    inject: 'body',
    filename: 'utilities-shadows.html',
    chunks: []
  },
  {
    title: 'Sizing - Utilities',
    template: './app/content/utilities/sizing.hbs',
    inject: 'body',
    filename: 'utilities-sizing.html',
    chunks: []
  },
  {
    title: 'Spacing - Utilities',
    template: './app/content/utilities/spacing.hbs',
    inject: 'body',
    filename: 'utilities-spacing.html',
    chunks: []
  },
  {
    title: 'Text - Utilities',
    template: './app/content/utilities/text.hbs',
    inject: 'body',
    filename: 'utilities-text.html',
    chunks: []
  },
  {
    title: 'Typography - Utilities',
    template: './app/content/utilities/typography.hbs',
    inject: 'body',
    filename: 'utilities-typography.html',
    chunks: []
  },
  {
    title: 'Vertical Align - Utilities',
    template: './app/content/utilities/vertical-align.hbs',
    inject: 'body',
    filename: 'utilities-vertical-align.html',
    chunks: []
  },
  {
    title: 'Visibility - Utilities',
    template: './app/content/utilities/visibility.hbs',
    inject: 'body',
    filename: 'utilities-visibility.html',
    chunks: []
  },
  // END UTILITIES
  //BEGIN FORM
  {
    title: 'Basic Elements - Form',
    template: './app/content/forms/basic-elements.hbs',
    inject: 'body',
    filename: 'forms-basic-elements.html',
    chunks: []
  },
  {
    title: 'Checkbox - Form',
    template: './app/content/forms/checkboxs.hbs',
    inject: 'body',
    filename: 'forms-checkboxs.html',
    chunks: []
  },
  {
    title: 'DropzoneJS - Form',
    template: './app/content/forms/dropzonejs.hbs',
    inject: 'body',
    filename: 'forms-dropzonejs.html',
    chunks: ['demo_dropzone']
  },
  {
    title: 'Input Group - Form',
    template: './app/content/forms/input-groups.hbs',
    inject: 'body',
    filename: 'forms-input-groups.html',
    chunks: []
  },
  {
    title: 'Radio - Form',
    template: './app/content/forms/radios.hbs',
    inject: 'body',
    filename: 'forms-radios.html',
    chunks: []
  },
  {
    title: 'Select2 - Form',
    template: './app/content/forms/select2.hbs',
    inject: 'body',
    filename: 'forms-select2.html',
    chunks: []
  },
  {
    title: 'Validations - Form',
    template: './app/content/forms/validations.hbs',
    inject: 'body',
    filename: 'forms-validations.html',
    chunks: []
  },
  //CHART
  {
    title: 'Chartjs',
    template: './app/content/charts/chartjs.hbs',
    inject: 'body',
    filename: 'charts-chartjs.html',
    chunks: ['demo_chartjs']
  },
  {
    title: 'Brite Chart',
    template: './app/content/charts/britecharts.hbs',
    inject: 'body',
    filename: 'charts-britecharts.html',
    chunks: ['demo_britecharts']
  },
  // TABLE
  {
    title: 'Basic Table - Table',
    template: './app/content/tables/basic-table.hbs',
    inject: 'body',
    filename: 'tables-basic-table.html',
    chunks: []
  },
  {
    title: 'Data Table - Table',
    template: './app/content/tables/data-table.hbs',
    inject: 'body',
    filename: 'tables-data-table.html',
    chunks: ['demo_datatable']
  },
  {
    title: 'Font Awesome Light - Font',
    template: './app/content/icons/fontawesome/light.hbs',
    inject: 'body',
    filename: 'icon-fontawesome-light.html',
    chunks: []
  },
  {
    title: 'Font Awesome Solid - Font',
    template: './app/content/icons/fontawesome/solid.hbs',
    inject: 'body',
    filename: 'icon-fontawesome-solid.html',
    chunks: []
  },
  {
    title: 'Font Awesome Regular - Font',
    template: './app/content/icons/fontawesome/regular.hbs',
    inject: 'body',
    filename: 'icon-fontawesome-regular.html',
    chunks: []
  },
  {
    title: 'Font Awesome Duotone - Font',
    template: './app/content/icons/fontawesome/duotone.hbs',
    inject: 'body',
    filename: 'icon-fontawesome-duotone.html',
    chunks: []
  },
   {
    title: 'Font Awesome Brands - Font',
    template: './app/content/icons/fontawesome/brands.hbs',
    inject: 'body',
    filename: 'icon-fontawesome-brands.html',
    chunks: []
  },
  {
    title: 'Google Map',
    template: './app/content/maps/google-map.hbs',
    inject: 'body',
    filename: 'maps-google-map.html',
    chunks: ['demo_google_map']
  },
  {
    title: 'jQuery Vector Maps',
    template: './app/content/maps/vector-map.hbs',
    inject: 'body',
    filename: 'maps-vector-map.html',
    chunks: ['demo_jqvmap']
  }
];

class PagesConfig {
  static get entries() {
    return _entries;
  }

  static get page_options() {
    return _page_options;
  }
}

module.exports = PagesConfig;