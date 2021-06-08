//=======================================================================
//Restricted
//=======================================================================
import "views/restricted/index.php";
//=======================================================================
//Admin Pages and Layouts
//=======================================================================

// Admin Layout
import "views/layouts/include/admin/footer.php";
import "views/layouts/include/admin/header.php";
import "views/layouts/include/admin/nav.php";
import "views/layouts/include/admin/side_nav.php";
import "views/layouts/include/admin/modal.php";
import "views/layouts/include/admin/script.php";
import "views/layouts/include/adminlogin/header.php";
import "views/layouts/include/adminlogin/footer.php";

import "views/layouts/admin.php";
import "views/layouts/adminlogin.php";

// Admin Pages
import "views/admin/index.php";
import "views/admin/analytics.php";
import "views/admin/calendar.php";

// Admin pages products
import "views/admin/products/allcategories.php";
import "views/admin/products/allproducts.php";
import "views/admin/products/product_details.php";
import "views/admin/products/new_product.php";
import "views/admin/products/allunits.php";

//admin contact page
import "views/admin/home/contact-us.php";
//admin users page
import "views/admin/users/allusers.php";
import "views/admin/users/profile.php";
import "views/admin/users/permissions.php";
// Company
import "views/admin/company/allcompanies.php";
import "views/admin/company/company_details.php";
import "views/admin/company/partials/form.php";
//=======================================================================
//Home Ecommerce Pages and Layouts
//=======================================================================
// Home Layout
import "views/layouts/include/default/footer.php";
import "views/layouts/include/default/header.php";
import "views/layouts/include/default/nav.php";
import "views/layouts/include/default/modal.php";
import "views/layouts/default.php";
//home Pages ecommerce index
import "views/home/index.php";
import "views/home/partials/_banner_adds.php";
import "views/home/partials/_banner_area.php";
import "views/home/partials/_blog.php";
import "views/home/partials/_empty_cart_template.php";
import "views/home/partials/_new_products.php";
import "views/home/partials/_special_price.php";
import "views/home/partials/_top_sales.php";

//home Pages ecommerce product
import "views/home/product/product.php";
import "views/home/product/details.php";
import "views/home/product/partials/_product_details.php";
import "views/home/product/partials/_not_found_product.php";
//home Pages ecommerce Cart
import "views/home/cart/cart.php";
import "views/home/cart/partials/_shopping_cart.php";
import "views/home/cart/partials/_wishlist.php";
// home pages ecommerce promotions
import "views/home/promotions/promotions.php";
import "views/home/sitemap/sitemap.php";
// home pages ecommerce boutique
import "views/home/boutique/boutique.php";
//=======================================================================
//Users Management pages
//=======================================================================
// Users pages ecommerce account
import "views/users/account/account.php";
import "views/users/account/partials/_login.php";
import "views/users/account/partials/_register.php";
import "views/users/account/login.php";
import "views/users/account/emailverified.php";
import "views/users/account/resetpassword.php";

// Users checkout
import "views/users/checkout/payment.php";
import "views/users/checkout/checkout.php";
