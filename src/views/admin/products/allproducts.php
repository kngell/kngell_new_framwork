<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/admin/products/allproducts', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id=main-site>
    <!-- Content -->
    <div class="page-content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ps-0 fs-base">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><span>Products</span></li>
                <li class="breadcrumb-item active" aria-current="page">All Products</li>
            </ol>
        </nav>
        <div class="row header justify-content-between mb-4">
            <div class="col-12">
                <h1 class="header-title h3">
                    <i class="fad fa-star-half-alt text-highlight"></i>
                    Products
                </h1>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-solid" id="allproducts-wrapper">
                    <h5 class="card-header main-header">
                        <span class="lead">
                            <div class="input-group">
                                <button class="btn btn-highlight" type="button"><i class="fal fa-plus-circle"></i> <span
                                        class="d-none d-md-inline"
                                        onclick="window.location.href='<?='new_product'?>';">Add
                                        Product</span></button>
                                <button class="btn btn-highlight" type="button"><i class="fal fa-file-import"></i> <span
                                        class="d-none d-md-inline">Import</span></button>
                                <button class="btn btn-highlight" type="button"><i class="fal fa-arrow-to-bottom"></i>
                                    <span class="d-none d-md-inline">Export</span></button>
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
                        </span>
                        <span class="ms-auto"> <a href="javascript:history.go(-1)" class="btn btn-light btn-secondary"
                                id="back"><i class="far fa-arrow-alt-circle-left fa-lg"></i></i>&nbsp;Back
                            </a>&nbsp;&nbsp;
                            <a href="" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-box"
                                id="addNew"><i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add new</a>
                        </span>
                    </h5>
                    <div id="globalErr"></div>
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive" id="showAll">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------Add new categorie Modal-------->
    <div class="modal fade" role="dialog" id="modal-box">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Add new</h5>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="new-product-frm" class="px-3 needs-validation"
                        enctype='multipart/form-data' novalidate>
                        <?= FH::csrfInput('csrftoken', (new Token())->generate_token(8)); ?>
                        <input type="hidden" name="operation" id="operation">
                        <input type="hidden" name="pdtID" id="pdtID">
                        <input type="hidden" name="created_at" id="created_at">
                        <input type="hidden" name="updated_at" id="updated_at">
                        <input type="hidden" name="deleted" id="deleted">
                        <div id="alertErr"></div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="p_title">Title <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="p_title" id="p_title">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="product-description">Description <span
                                                            class="text-danger"></span></label>
                                                    <textarea class="form-control ck-content" name="p_descr"
                                                        id="p_descr" rows="3"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="product-description">Short Description <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control ck-content" name="p_short_descr"
                                                        id="p_short_descr">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="text-center">Media</h4>
                                        <?=$this->dragAndDrop?>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Pricing</h4>
                                        <div class="row border-bottom mb-3">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-price">Regular Price</label>
                                                    <input class="form-control" type="number" name="p_regular_price"
                                                        id="p_regular_price">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-compare-price">Compare at price</label>
                                                    <input class="form-control" type="number" name="p_compare_price"
                                                        id="p_compare_price">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-cost-per-item">Cost per item</label>
                                                    <input class="form-control" type="number" name="p_cost_per_item"
                                                        id="p_cost_per_item">
                                                    <span class="help-block">
                                                        <small>Customers won’t see this</small>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="col-lg-6 d-flex align-items-center">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" name="p_charge_tax"
                                                        id="p_charge_tax"> Charge
                                                    tax on this product
                                                    <span></span>
                                                </label>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Inventory</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class=" mb-3">
                                                    <label for="product-sku">SKU (Stock Keeping Unit)</label>
                                                    <input class="form-control" type="number" name="p_sku" id="p_sku">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-bar-code">Barcode (ISBN, UPC, GTIN,
                                                        etc.)</label>
                                                    <input class="form-control" type="text" name="p_barre_code"
                                                        id="p_barre_code">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                        <div class="row border-bottom mb-3 pb-3">
                                            <div class="col-12">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" name="p_track_qty"
                                                        id="p_track_qty" checked> Track quantity
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col-12">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="p_continious_sell" id="p_continious_sell" checked>
                                                    Continue
                                                    selling when out
                                                    of stock
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <h5 class="mt-3">QUANTITY</h5>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-quantity">Stock quantity</label>
                                                    <input class="form-control" type="number" name="p_qty" id="p_qty">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-backorder">Allow backorder</label>
                                                    <select class="form-select" name="p_back_border" id="p_back_border">
                                                        <option selected>No not allow</option>
                                                        <option>Allow, but notify customer</option>
                                                        <option>Allow</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-threshold">Low stock threshold</label>
                                                    <input class="form-control" type="number" name="p_stock_threshold"
                                                        id="p_stock_threshold">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="mb-3">Shipping</h4>
                                        <div class="row border-bottom mb-3 pb-3">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-weight">Weight (kg)</label>
                                                    <input class="form-control" type="text" name="p_weight"
                                                        id="p_weight">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-bottom mb-3 pb-3">
                                            <label for="product-length"
                                                class="col-lg-2 col-form-label fw-700">Dimensions
                                                (cm)</label>
                                            <div class="col-lg-10">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input class="form-control" type="text" name="p_lenght"
                                                            id="p_lenght" placeholder="Length">
                                                    </div>
                                                    <div class="col-3">
                                                        <input class="form-control" type="text" name="p_width"
                                                            id="p_width" placeholder="Width">
                                                    </div>
                                                    <div class="col-3">
                                                        <input class="form-control" type="text" name="p_height"
                                                            id="p_height" placeholder="Height">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="p_shipping_class">Shipping Class</label>
                                                    <select class="form-select p_shipping_class" name="p_shipping_class"
                                                        id="p_shipping_class">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Variants</h4>
                                        <!-- Loop true options -->
                                        <div class="row mb-3">
                                            <div class="form-group">
                                                <label for="p_variant_title">Option 1</label>
                                            </div>
                                            <!-- end form-group -->
                                            <div class="col-3">
                                                <input class="form-control" type="text" value="Size"
                                                    name="p_variant_title" id="p_variant_title"
                                                    form="product-variant-frm">
                                            </div>
                                            <!-- end col -->
                                            <div class="col-9">
                                                <input class="form-control" type="text" name="p_variant_value"
                                                    id="p_variant_value" placeholder="Separate options with a comma"
                                                    form="product-variant-frm">
                                            </div>
                                            <!-- end col -->
                                        </div>

                                        <!-- end row -->
                                        <button class="btn btn-sm btn-outline-highlight" type="button"
                                            form="product-variant-frm"><i class="fal fa-plus-circle"></i> Add
                                            another option</button>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Organization</h4>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <select class="form-select p_company" name="p_company"
                                                        id="p_company" placeholder=" ">
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <select class="form-select p_warehouse"
                                                        aria-label=".form-select Default" name="p_warehouse"
                                                        id="p_warehouse">
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Product categories</h4>
                                        <div id="check-box-wrapper">
                                            <?php array_map(function ($cat) {?>
                                            <label class="custom-checkbox">
                                                <input type="checkbox"
                                                    value="<?=$cat->catID?>"
                                                    name='categorie[]' class="categorie">
                                                <?=$cat->categorie?>
                                                <span></span>
                                            </label>
                                            <?php }, $this->view_data)?>
                                        </div>
                                        <button class="btn btn-sm btn-outline-highlight" type="button"><i
                                                class="fal fa-plus-circle"></i> Add new
                                            category</button>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Product tags</h4>
                                        <form class="">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group me-1 flex-grow-1">
                                                    <input type="text" class="form-control" />
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-highlight">
                                                    Add
                                                </button>
                                            </div>
                                            <span class="fs-sm"><i>Separate tags with commas</i></span>
                                            <div class="product-tags mt-2">
                                                <span class="badge bg-highlight"><a href="javascript:void(0);"><i
                                                            class="fal fa-times"></i></a>
                                                    T-shirt</span>
                                                <span class="badge bg-highlight"><a href="javascript:void(0);"><i
                                                            class="fal fa-times"></i></a>
                                                    Christmas</span>
                                                <span class="badge bg-highlight"><a href="javascript:void(0);"><i
                                                            class="fal fa-times"></i></a>
                                                    Lorem</span>
                                                <span class="badge bg-highlight"><a href="javascript:void(0);"><i
                                                            class="fal fa-times"></i></a>
                                                    Ipsum</span>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between">
                                        <button class="btn btn-outline-highlight" type="button">Save Draft</button>
                                        <button class="btn btn-highlight" id="save-all" type="submit"><i
                                                class="fal fa-save"></i>
                                            Save</button>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none"
        value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript"
    src="<?= $this->asset('js/custom/admin/products/allproducts', 'js') ?? ''?>">
</script>
<?php $this->end();
