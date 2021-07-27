<?php $this->start('head'); ?>
<!-------Costum-------->
<meta name="csrftoken" content="<?=$this->token->generate_token(8, 'all_product_page')?>" />
<link href="<?= $this->asset('css/custom/backend/admin/orders/orders', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <div class="page-content">
        <?php
        $pageAttr = explode(DS, $this->view_file);
        ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ps-0 fs-base">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><span><?=ucfirst($pageAttr[1])?></span></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </nav>
        <div class="row header justify-content-between mb-4">
            <div class="col-xl-5 col-lg-12">
                <h1 class="header-title h3">
                    <i class="fad fa-star-half-alt text-highlight"></i>
                    <?=$this->get_pageTitle()?>
                </h1>
            </div>
        </div>
        <div class="row justify-content-between mb-4">
            <div class="col-12 d-flex align-items-center">
                <div class="input-group mb-3">
                    <button class="btn btn-highlight" type="button"><i class="fal fa-file-import"></i> <span
                            class="d-none d-md-inline">Import</span></button>
                    <button class="btn btn-highlight" type="button"><i class="fal fa-arrow-to-bottom"></i> <span
                            class="d-none d-md-inline">Export</span></button>
                    <button class="btn btn-highlight" type="button"><i class="fal fa-list-ul"></i> <span
                            class="d-none d-md-inline">Customize Columns</span></button>
                    <button type="button" class="btn btn-highlight dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fal fa-pen"></i> <span class="d-none d-md-inline">Bulk Actions</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                        <li><a class="dropdown-item" href="#">Update Statuses</a></li>
                        <li><a class="dropdown-item" href="#">Create Notes</a></li>
                    </ul>
                </div>
                <div class="header-right float-xl-right float-start mt-3 mt-xl-0">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search others"
                                aria-label="Recipient's username with two button addons">
                            <button class="btn btn-icon btn-highlight" type="button"><i
                                    class="fal fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div id="globalErr"></div>
                    <div class="card-body">
                        <div class="" id="showAll">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------Add new  Modal-------->
    <div class="modal fade" role="dialog" id="modal-box">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Add/Edit Order</h5>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="order-frm" class="px-3 needs-validation"
                        enctype='multipart/form-data' novalidate>
                        <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'order-frm')); ?>
                        <input type="hidden" name="operation" id="operation">
                        <input type="hidden" name="ordID" id="ordID">
                        <input type="hidden" name="ord_number" id="ord_number">
                        <input type="hidden" name="ord_userID" id="ord_userID">
                        <input type="hidden" name="ord_pmt_mode" id="ord_pmt_mode">
                        <input type="hidden" name="ord_pmt_ID" id="ord_pmt_ID">
                        <input type="hidden" name="created_at" id="created_at">
                        <input type="hidden" name="updated_at" id="updated_at">
                        <input type="hidden" name="deleted" id="deleted">
                        <div id="alertErr"></div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card order-detail">
                                    <div class="card-body">
                                        <h3 class="order-data-heading">
                                            Order&nbsp;<span id="order_title"></span>&nbsp;details </h3>
                                        <p class="order-data-meta order-number">
                                            Payment via Cash on delivery. Paid on September 14, 2020 @ 3:28 am. Customer
                                            IP: <span class="order-customerIP">231.34.1.22</span>
                                        </p>
                                        <div class="row order-data-column-container">
                                            <div class="col-xl-6 order-data-column pe-xl-5">
                                                <h4>General</h4>
                                                <form>
                                                    <div class="form-field d-flex flex-row align-items-center">
                                                        <div class="me-2 mb-3">
                                                            <label for="order-date">Date created:</label>
                                                            <div class="d-flex align-items-center">
                                                                <input value="14/09/2020"
                                                                    class="form-control datepicker" id="ord_date"
                                                                    name="ord_date">
                                                                <span class="mx-2">@</span>
                                                                <input type="text" class="hour form-control me-2"
                                                                    style="flex: 0 0 60px" placeholder="h"
                                                                    name="order-date-hour" min="0" max="23" step="1"
                                                                    value="03" pattern="([01]?[0-9]{1}|2[0-3]{1})">
                                                                <span class="me-2">:</span>
                                                                <input type="text" class="minute form-control"
                                                                    style="flex: 0 0 60px" placeholder="m"
                                                                    name="order-date-minute" min="0" max="59" step="1"
                                                                    value="27" pattern="[0-5]{1}[0-9]{1}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end form-field -->
                                                    <div class="form-field mb-3">
                                                        <label for="ord_status">Status:</label>
                                                        <select class="form-select ord_status" id="ord_status"
                                                            name="ord_status" data-placeholder="Please select status">
                                                        </select>
                                                    </div>
                                                    <!-- end form-field -->
                                                    <div class="form-field mb-3">
                                                        <label for="customer">Customer:</label>
                                                        <select class="form-select customer" id="customer"
                                                            name="customer" data-placeholder="Please select customer">
                                                        </select>
                                                    </div>
                                                    <!-- end form-field -->
                                                </form>
                                            </div>
                                            <!-- end order-data-column -->
                                            <div class="col-xl-6 order-data-column" id="billing_address">

                                            </div>
                                            <!-- end order-data-column -->
                                        </div>
                                        <!-- end row order-data-column-container -->
                                        <hr>
                                        <div class="row order-data-column-container">
                                            <div class="col-xl-6 order-data-column">
                                                <div id="shipping_address">

                                                </div>
                                                <div class="mb-3"><span class="fw-700 d-block">Customer provided
                                                        note:</span>
                                                    <span id="u_comment">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Maecenas
                                                        quis enim volutpat, interdum odio
                                                        vel, sagittis massa.</span>
                                                </div>
                                            </div>
                                            <!-- end order-data-column -->
                                            <div class="col-xl-6 order-data-column">
                                                <h4>Delivery Information</h4>
                                                <address class="mb-3">
                                                    UPS Delivery<br>
                                                    Order ID: 04598xxx<br>
                                                    Payment Mode: COD<br>
                                                </address>
                                            </div>
                                            <!-- end order-data-column -->
                                        </div>
                                        <!-- end row order-data-column-container -->
                                    </div>
                                    <!-- end card-body order-detail -->
                                </div>
                                <!-- end card order-detail -->
                                <div class="card order-items">
                                    <div class="card-body">
                                        <div class="row" id=order_details_summary>

                                            <!-- end col-lg-12 -->
                                        </div>
                                        <!-- end row -->
                                        <div class="row" id="order_details_total">

                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end card-body order-item -->
                                    <div class="card-footer justify-content-between">
                                        <button type="button" class="btn btn-outline-highlight my-2">Refund</button>
                                        <span><a href="#">
                                                <i class="fal fa-question-circle"
                                                    data-bs-original-title="To edit this order change the status back to 'Pending'"
                                                    data-bs-toggle="tooltip"></i>
                                            </a> This order is no longer editable.</span>
                                    </div>
                                </div>
                                <!-- end card order-item -->
                            </div>
                            <!-- end col-lg-8 -->
                            <div class="col-lg-4">
                                <div class="card other-action">
                                    <div class="card-header justify-content-between">
                                        <h4 class="fw-700 m-0 fs-base">
                                            Order actions
                                        </h4>
                                    </div>
                                    <!-- end card-header -->
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <select class="form-select me-1" name="order-actions">
                                                <option value="">Choose an action...</option>
                                                <option value="send_order_details">Email invoice / order details to
                                                    customer</option>
                                                <option value="send_order_details_admin">Resend new order notification
                                                </option>
                                                <option value="regenerate_download_permissions">Regenerate download
                                                    permissions</option>
                                            </select>
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-circle btn-highlight mb-4">
                                                <i class="fal fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                    <div class="card-footer justify-content-between">
                                        <button type="button" class="btn btn-highlight"><i class="fal fa-save"></i>
                                            Update</button>
                                        <a href="#" class="text-danger">
                                            Move to Trash
                                        </a>
                                    </div>
                                    <!-- end card-footer -->
                                </div>
                                <!-- end card -->
                                <div class="card order-note">
                                    <div class="card-header justify-content-between">
                                        <h4 class="fw-700 m-0 fs-base">
                                            Order notes
                                        </h4>
                                    </div>
                                    <!-- end card-header -->
                                    <div class="card-body">
                                        <ul class="widget-order-notes">
                                            <li class="note">
                                                <div class="note-content alert alert-secondary">
                                                    Stock levels reduced: Cats Kitty Tats Tattoos (AC31RFT) 444→443
                                                </div>
                                                <p class="meta fs-sm">
                                                    <abbr class="exact-date" title="2020-09-14 03:28:20">
                                                        September 14, 2020 at 3:28 am </abbr>
                                                    by Admin <a href="#" class="delete-note text-danger"
                                                        role="button">Delete note</a>
                                                </p>
                                            </li>
                                            <li class="note">
                                                <div class="note-content alert alert-success">
                                                    Order status changed from Processing to Completed.
                                                </div>
                                                <p class="meta fs-sm">
                                                    <abbr class="exact-date" title="2020-09-14 03:28:20">
                                                        September 14, 2020 at 3:28 am </abbr>
                                                    by Admin <a href="#" class="delete-note text-danger"
                                                        role="button">Delete note</a>
                                                </p>
                                            </li>
                                            <li class="note">
                                                <div class="note-content alert alert-warning">
                                                    Payment to be made upon delivery. Order status changed from Pending
                                                    payment to Processing.
                                                </div>
                                                <p class="meta fs-sm">
                                                    <abbr class="exact-date" title="2020-09-14 03:28:20">
                                                        September 14, 2020 at 3:28 am </abbr>
                                                    by Admin <a href="#" class="delete-note text-danger"
                                                        role="button">Delete note</a>
                                                </p>
                                            </li>
                                            <li class="note">
                                                <div class="note-content alert alert-info">
                                                    Stock levels reduced: Cats Kitty Tats Tattoos (AC31RFT) 444→443
                                                </div>
                                                <p class="meta fs-sm">
                                                    <abbr class="exact-date" title="2020-09-14 03:28:20">
                                                        September 14, 2020 at 3:28 am </abbr>
                                                    by Admin <a href="#" class="delete-note text-danger"
                                                        role="button">Delete note</a>
                                                </p>
                                            </li>
                                            <li class="note">
                                                <div class="note-content alert alert-danger">
                                                    Stock levels reduced: Cats Kitty Tats Tattoos (AC31RFT) 444→443
                                                </div>
                                                <p class="meta fs-sm">
                                                    <abbr class="exact-date" title="2020-09-14 03:28:20">
                                                        September 14, 2020 at 3:28 am </abbr>
                                                    by Admin <a href="#" class="delete-note text-danger"
                                                        role="button">Delete note</a>
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="p-4">
                                        <form class="">
                                            <div class="mb-3">
                                                <label for="note-description">Add note <a class="ms-1" href="#">
                                                        <i class="fal fa-question-circle"
                                                            data-bs-original-title="Add a note for your reference, or add a customer note (the user will be notified)."
                                                            data-bs-toggle="tooltip"></i>
                                                    </a></label>
                                                <textarea class="form-control" id="note-description"
                                                    rows="3"></textarea>
                                            </div>
                                            <div class="d-flex">
                                                <select class="form-select me-1" name="order-actions">
                                                    <option value="private-note">Private note</option>
                                                    <option value="customer-note">Note to customer</option>
                                                </select>
                                                <button type="button" class="btn btn-sm btn-highlight mb-4">
                                                    Add
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col-lg-8 -->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/custom/backend/admin/orders/orders', 'js') ?? ''?>">
</script>
<?php $this->end();