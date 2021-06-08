<nav id="left-sidebar" class="left-sidebar">
    <!-- start sidebar-header -->
    <div class="sidebar-header">
        <div class="logo">
            <h3><a
                    href="<?=PROOT . 'admin' . US . 'index'?>">
                    <img src="../../../../assets/img/logo.png" alt="" width="30" height="24">
                    <span class="fw-700 text-white-50">Administration</span>
                </a></h3>
        </div>
        <a class="sidebar-toggle-btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>
    <!-- end sidebar-header -->
    <div class="sidebar-wrapper">
        <!-- start sidebar-body -->
        <div class="sidebar-body">
            <div class="nav-filter align-items-center justify-content-center flex-row mb-4 p-2">
                <input type="text" placeholder="Quick search" class="w-100 form-control" tabindex="0">
            </div>
            <!-- end nav-profile -->
            <!-- start sidebar-block -->
            <div class="sidebar-block">
                <div class="sidebar-title">MAIN</div>
                <ul class="list-unstyled sidebar-content">
                    <li class="sidebar-item">
                        <a href="#homeSubmenu" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-tachometer fa-lg"></i>
                            <span>Dashboard</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="homeSubmenu"
                            data-parent="#left-sidebar">
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'analytics'?>">Analytics</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'index'?>">Ecommerce</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#usersManagement" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-id-card fa-lg"></i>
                            <span>Users Management</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="usersManagement"
                            data-parent="#left-sidebar">
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'profile'?>">User
                                    Profile</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allusers' . US . 'get_allUsers'?>">All
                                    Users</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allusers' . US . 'get_deletedUsers'?>">Deleted
                                    Users</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allusers' . US . 'get_adminUsers'?>">Admin
                                    Users</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'permissions'?>">Group
                                    and permissions</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#productsManagement" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fas fa-barcode-alt fa-lg"></i>
                            <span>Products Management</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="productsManagement"
                            data-parent="#left-sidebar">
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allproducts'?>">All
                                    Products</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allcategories'?>">All
                                    Categories</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allunits'?>">All
                                    Units</a>
                            </li>

                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'product_details'?>">
                                    Details</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'new_product'?>">Add
                                    New </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#organization" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-warehouse fa-lg"></i>
                            <span>Company Management</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="organization"
                            data-parent="#left-sidebar">
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allcompanies'?>">All
                                    companies</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allbrands'?>">All
                                    Brands</a>
                            </li>
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allwarehouses'?>">All
                                    Warehouses</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#orders" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fad fa-shopping-cart fa-lg"></i>
                            <span>Orders Management</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="orders" data-parent="#left-sidebar">
                            <li>
                                <a
                                    href="<?=PROOT . 'admin' . US . 'allcompanies'?>">All
                                    Orders</a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a
                            href="<?=PROOT . 'admin' . US . 'calendar'?>">
                            <i class="fal fa-calendar"></i>
                            <span>Calendar</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="chat.html">
                            <i class="fal fa-comments-alt"></i>
                            <span>Chat</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#pageSubmenuEcommerce" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-dumpster"></i>
                            <span>Ecommerce</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="pageSubmenuEcommerce"
                            data-parent="#left-sidebar">
                            <li>
                                <a href="ecommerce-products.html">All Products</a>
                            </li>
                            <li>
                                <a href="ecommerce-product-detail.html">Product Detail</a>
                            </li>
                            <li>
                                <a href="ecommerce-add-product.html">Add Product</a>
                            </li>
                            <li>
                                <a href="ecommerce-orders.html">Orders</a>
                            </li>
                            <li>
                                <a href="ecommerce-order-detail.html">Order Detail</a>
                            </li>
                            <li>
                                <a href="ecommerce-customers.html">Customers</a>
                            </li>
                            <li>
                                <a href="ecommerce-shopping-card.html">Shopping Card</a>
                            </li>
                            <li>
                                <a href="ecommerce-checkout.html">Checkout</a>
                            </li>
                        </ul>
                    </li>
                    <li id="sidebar-pages" class="sidebar-item">
                        <a href="#pageSubmenu1" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-file"></i>
                            <span>Pages</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="pageSubmenu1"
                            data-parent="#left-sidebar">
                            <li>
                                <a href="#pageAuthentication" data-bs-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle collapsed">Authentication</a>
                                <ul class="sidebar-third-level collapse list-unstyled" id="pageAuthentication"
                                    data-parent="#sidebar-pages">
                                    <li>
                                        <a href="pages-authentication-login.html">Login</a>
                                    </li>
                                    <li>
                                        <a href="pages-authentication-register.html">Register</a>
                                    </li>
                                    <li>
                                        <a href="pages-authentication-forgot-password.html">Forgot Password</a>
                                    </li>
                                    <li>
                                        <a href="pages-authentication-confirm-email.html">Confirm Email</a>
                                    </li>
                                </ul>
                            </li> <!-- end li authentication -->

                            <li>
                                <a href="pages-contact.html">Contact</a>
                            </li>
                            <li>
                                <a href="#pageError" data-bs-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle collapsed">Error</a>
                                <ul class="sidebar-third-level collapse list-unstyled" id="pageError"
                                    data-parent="#sidebar-pages">
                                    <li>
                                        <a href="pages-error-404.html">Error 404 </a>
                                    </li>
                                    <li>
                                        <a href="pages-error-500.html">Error 500</a>
                                    </li>
                                </ul>
                            </li> <!-- end li pageError -->
                            <li>
                                <a href="pages-faq.html">FAQ</a>
                            </li>
                            <li>
                                <a href="pages-invoice.html">Invoice</a>
                            </li>
                            <li>
                                <a href="pages-maintenance.html">Maintenance Page</a>
                            </li>
                            <li>
                                <a href="pages-pricing.html">Pricing</a>
                            </li>
                            <li>
                                <a href="pages-profile.html">Profile</a>
                            </li>
                            <li>
                                <a href="pages-starter.html">Starter Page</a>
                            </li>
                        </ul> <!-- end sidebar-second-level -->
                    </li> <!-- end sidebar-item -->
                </ul>
            </div> <!-- end sidebar-block -->
            <!-- start sidebar-block -->
            <div class="sidebar-block">
                <div class="sidebar-title">COMPONENT</div>
                <ul class="list-unstyled sidebar-content">
                    <li class="sidebar-item">
                        <a href="#ui-kit" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-layer-group"></i>
                            <span>UI Kit</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="ui-kit" data-parent="#left-sidebar">
                            <li>
                                <a href="ui-kits-avatars.html">Avatars</a>
                            </li>
                            <li>
                                <a href="ui-kits-breadcrumbs.html">Breadcrumbs</a>
                            </li>
                            <li>
                                <a href="ui-kits-buttons.html">Buttons</a>
                            </li>
                            <li>
                                <a href="ui-kits-cards.html">Cards</a>
                            </li>
                            <li>
                                <a href="ui-kits-dual-listbox.html">Dual Listbox</a>
                            </li>
                            <li>
                                <a href="ui-kits-jstree.html">jsTree</a>
                            </li>
                            <li>
                                <a href="ui-kits-image-cropper.html">Image cropper</a>
                            </li>
                            <li>
                                <a href="ui-kits-notifications.html">Notifications</a>
                            </li>
                            <li>
                                <a href="ui-kits-spinners.html">Spinner</a>
                            </li>
                            <li>
                                <a href="ui-kits-sweetalert.html">SweetAlert2</a>
                            </li>
                            <li>
                                <a href="ui-kits-tabs.html">Tabs</a>
                            </li>
                            <li>
                                <a href="ui-kits-toastr.html">Toastr</a>
                            </li>
                            <li>
                                <a href="ui-kits-widgets.html">Widgets</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#utilities" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-shield-alt"></i>
                            <span>Utilities</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="utilities"
                            data-parent="#left-sidebar">
                            <li>
                                <a href="utilities-borders.html">Borders</a>
                            </li>
                            <li>
                                <a href="utilities-colors.html">Colors</a>
                            </li>
                            <li>
                                <a href="utilities-display.html">Display</a>
                            </li>
                            <li>
                                <a href="utilities-flex.html">Flex</a>
                            </li>
                            <li>
                                <a href="utilities-float.html">Float</a>
                            </li>
                            <li>
                                <a href="utilities-interactions.html">Interactions</a>
                            </li>
                            <li>
                                <a href="utilities-overflow.html">Overflow</a>
                            </li>
                            <li>
                                <a href="utilities-positions.html">Positions</a>
                            </li>
                            <li>
                                <a href="utilities-shadows.html">Shadows</a>
                            </li>
                            <li>
                                <a href="utilities-sizing.html">Sizing</a>
                            </li>
                            <li>
                                <a href="utilities-spacing.html">Spacing</a>
                            </li>
                            <li>
                                <a href="utilities-text.html">Text</a>
                            </li>
                            <li>
                                <a href="utilities-typography.html">Typography</a>
                            </li>
                            <li>
                                <a href="utilities-vertical-align.html">Vertical Align</a>
                            </li>
                            <li>
                                <a href="utilities-visibility.html">Visibility</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#forms" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fab fa-wpforms"></i>
                            <span>Forms </span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="forms" data-parent="#left-sidebar">
                            <li>
                                <a href="forms-basic-elements.html">Basic Elements</a>
                            </li>
                            <li>
                                <a href="forms-checkboxs.html">Checkbox</a>
                            </li>
                            <!-- <li>
                    <a href="forms-editors.html">Editors</a>
                  </li> -->
                            <li>
                                <a href="forms-dropzonejs.html">DropzoneJS</a>
                            </li>
                            <li>
                                <a href="forms-input-groups.html">Input Groups</a>
                            </li>
                            <li>
                                <a href="forms-radios.html">Radio</a>
                            </li>
                            <li>
                                <a href="forms-select2.html">Select2</a>
                            </li>
                            <li>
                                <a href="forms-validations.html">Validations</a>
                            </li>
                            <!-- <li>
                    <a href="forms-wizard.html">Wizard</a>
                  </li> -->
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#charts" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="far fa-chart-bar"></i>
                            <span>Charts</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="charts" data-parent="#left-sidebar">
                            <li>
                                <a href="charts-britecharts.html">Britecharts</a>
                            </li>
                            <li>
                                <a href="charts-chartjs.html">Chartjs</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#tables" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-table"></i>
                            <span>Tables</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="tables" data-parent="#left-sidebar">
                            <li>
                                <a href="tables-basic-table.html">Basic Table</a>
                            </li>
                            <li>
                                <a href="tables-data-table.html">Data Table</a>
                            </li>
                        </ul>
                    </li>
                    <li id="sidebar-icons" class="sidebar-item">
                        <a href="#icons" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-award"></i>
                            <span>Icons</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="icons" data-parent="#left-sidebar">
                            <li>
                                <a href="#font-awesome" data-bs-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle collapsed">Font Awesome 5</a>
                                <ul class="sidebar-third-level collapse list-unstyled" id="font-awesome"
                                    data-parent="#sidebar-icons">
                                    <li>
                                        <a href="icon-fontawesome-solid.html">Solid</a>
                                    </li>
                                    <li>
                                        <a href="icon-fontawesome-regular.html">Regular</a>
                                    </li>
                                    <li>
                                        <a href="icon-fontawesome-light.html">Light</a>
                                    </li>
                                    <li>
                                        <a href="icon-fontawesome-duotone.html">Duotone</a>
                                    </li>
                                    <li>
                                        <a href="icon-fontawesome-brands.html">Brands</a>
                                    </li>
                                </ul>
                            </li> <!-- end li fontawesome -->
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#maps" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <i class="fal fa-map-marked-alt"></i>
                            <span>Maps</span>
                        </a>
                        <ul class="sidebar-second-level collapse list-unstyled" id="maps" data-parent="#left-sidebar">
                            <li>
                                <a href="maps-google-map.html">Google Map</a>
                            </li>
                            <li>
                                <a href="maps-vector-map.html">Vector Map</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- end sidebar-block -->
        </div>
        <!-- end sidebar-body -->
        <div class="align-items-center justify-content-center sidebar-footer">
            <ul class="d-flex justify-content-around list-unstyled">
                <li>
                    <a href="#">
                        <i class="fal fa-comments" data-bs-original-title="Chat History" data-bs-toggle="tooltip"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fal fa-life-ring" data-bs-original-title="Support" data-bs-toggle="tooltip"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fal fa-question-circle" data-bs-original-title="Helper" data-bs-toggle="tooltip"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- end sidebar-footer -->
    </div><!-- end sidebar-wrapper -->
</nav>