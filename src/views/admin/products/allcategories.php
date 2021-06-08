<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/admin/products/categories', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="page-content">
    <!-- Content Header (Page header) -->
    <div class="row header justify-content-between mb-4 w-100">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ps-0 fs-base">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><span>Products</span></li>
                    <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                </ol>
            </nav>
        </div>
        <div class="col text-end">
            <h4 class="header-title h3">
                Manage Categories
            </h4>
        </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="row mb-4 content">
        <div class="col-12">
            <!-- Small boxes (Stat box) -->
            <div class="card border-primary">
                <h5 class="card-header d-flex">
                    <span class="text-light lead">Manage Categories</span>
                    <span class="ms-auto"> <a href="javascript:history.go(-1)" class="btn btn-light btn-secondary"
                            id="back"><i class="far fa-arrow-alt-circle-left fa-lg"></i></i>&nbsp;Back
                        </a>&nbsp;&nbsp;
                        <a href="" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-box"
                            id="addNew"><i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add new</a>
                    </span>
                </h5>
                <div id="globalErr"></div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="table-responsive col-lg-12" id="showAll">
                                <p class="text-center lead mt-5">Please wait...</p>
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
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Add/Update Categorie</h5>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="Categorie-frm" class="px-3 needs-validation" novalidate
                    enctype="multipart/form-data">
                    <?= FH::csrfInput('csrftoken', (new Token())->generate_token(8)); ?>
                    <input type="hidden" name="operation" id="operation">
                    <input type="hidden" name="catID" id="catID">
                    <input type="hidden" name="date_enreg" id="date_enreg">
                    <input type="hidden" name="updateAt" id="updateAt">
                    <div id="alertErr"></div>
                    <div class="mb-3">
                        <input type="text" name="categorie" id="categorie" class="form-control " placeholder="Catégorie"
                            aria-describedby="categorie-feedback">
                        <div class="invalid-feedback" id="categorie-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <textarea name="description" id="description" class="form-control ck-content"
                            placeholder="Description..." aria-describedby="drescription-feedback"></textarea>
                        <div class="invalid-feedback" id="drescription-feedback"></div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="status" name="status" value="1">
                        <label for="status" class="form-check-label">Active</label>
                    </div>
                    <div class="mb-3 select-box">
                        <select class="form-control parentID" id="parentID" name="parentID">

                        </select>
                        <span class="custom-arrow"></span>
                    </div>
                    <div class="mb-3 justify-content-between">
                        <input type="submit" name="submitBtn" id="submitBtn" value="Submit" class="button">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript"
    src="<?= $this->asset('js/custom/admin/products/categories', 'js') ?? ''?>">
</script>
<?php $this->end();
