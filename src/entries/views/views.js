//=======================================================================
//Restricted
//=======================================================================
import "views/client/restricted/index.php";
//=======================================================================
//Admin Pages and Layouts
//=======================================================================

// Admin Layout
import "views/backend/layouts/inc/admin/footer.php";
import "views/backend/layouts/inc/admin/header.php";
import "views/backend/layouts/inc/admin/nav.php";
import "views/backend/layouts/inc/admin/side_nav.php";
import "views/backend/layouts/inc/admin/modal.php";
import "views/backend/layouts/inc/admin/script.php";
import "views/backend/layouts/inc/adminlogin/header.php";
import "views/backend/layouts/inc/adminlogin/footer.php";

import "views/backend/layouts/admin.php";
import "views/backend/layouts/adminlogin.php";

// Admin Pages
import "views/backend/admin/index.php";
import "views/backend/admin/analytics.php";
import "views/backend/admin/calendar.php";

// Admin pages products
import "views/backend/admin/products/allcategories.php";
import "views/backend/admin/products/allproducts.php";
import "views/backend/admin/products/product_details.php";
import "views/backend/admin/products/new_product.php";
import "views/backend/admin/products/allunits.php";
import "views/backend/admin/products/allbrands.php";

//Admin pages Shipping
import "views/backend/admin/shipping/shippingclass.php";

//admin contact page
import "views/backend/admin/home/contact-us.php";
//admin users page
import "views/backend/admin/users/allusers.php";
import "views/backend/admin/users/profile.php";
import "views/backend/admin/users/permissions.php";
// Company
import "views/backend/admin/company/allcompanies.php";
import "views/backend/admin/company/alltaxes.php";
import "views/backend/admin/company/company_details.php";
import "views/backend/admin/company/partials/form.php";
//=======================================================================
//Home Ecommerce Pages and Layouts
//=======================================================================
// Home Layout
import "views/client/layouts/inc/default/footer.php";
import "views/client/layouts/inc/default/header.php";
import "views/client/layouts/inc/default/nav.php";
import "views/client/layouts/inc/default/modal.php";
import "views/client/layouts/default.php";
//home Pages ecommerce index
import "views/client/home/index.php";
import "views/client/home/partials/_banner_adds.php";
import "views/client/home/partials/_banner_area.php";
import "views/client/home/partials/_blog.php";
import "views/client/home/partials/_empty_cart_template.php";
import "views/client/home/partials/_new_products.php";
import "views/client/home/partials/_special_price.php";
import "views/client/home/partials/_top_sales.php";

//home Pages ecommerce product
import "views/client/home/product/product.php";
import "views/client/home/product/details.php";
import "views/client/home/product/partials/_product_details.php";
import "views/client/home/product/partials/_not_found_product.php";
//home Pages ecommerce Cart
import "views/client/home/cart/cart.php";
import "views/client/home/cart/partials/_shopping_cart.php";
import "views/client/home/cart/partials/_wishlist.php";
// home pages ecommerce promotions
import "views/client/home/promotions/promotions.php";
import "views/client/home/sitemap/sitemap.php";
// home pages ecommerce boutique
import "views/client/home/boutique/boutique.php";
//=======================================================================
//Users Management pages
//=======================================================================
// Users pages ecommerce account
import "views/client/users/account/account.php";
import "views/client/users/account/partials/_login.php";
import "views/client/users/account/partials/_register.php";
import "views/client/users/account/login.php";
import "views/client/users/account/emailverified.php";
import "views/client/users/account/resetpassword.php";

// Users checkout
import "views/client/users/checkout/payment.php";
import "views/client/users/checkout/checkout.php";
