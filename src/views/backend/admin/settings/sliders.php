<?php $this->start('head'); ?>
<!-------Costum-------->
<meta name="csrftoken" content="<?=$this->token->generate_token(8, 'all_product_page')?>" />
<link href="<?= $this->asset('css/custom/backend/admin/settings/sliders', 'css') ?? ''?>" rel="stylesheet"
    type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <div class="page-content">
        <!-- Content Header (Page header) -->
        <div class="row header justify-content-between mb-4 w-100">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb ps-0 fs-base">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><span>Settings</span></li>
                        <li class="breadcrumb-item active" aria-current="page">Sliders Settings</li>
                    </ol>
                </nav>
            </div>
            <div class="col text-end">
                <h4 class="header-title h3">
                    Manage Settings
                </h4>
            </div>
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="row mb-4 content">
            <div class="col-12">
                <!-- Small boxes (Stat box) -->
                <div class="card border-primary">
                    <h5 class="card-header bg-primary d-flex">
                        <span class="text-light lead">Manage Settings</span>
                        <span class="ms-auto"> <a href="javascript:history.go(-1)" class="btn btn-light btn-secondary"
                                id="back"><i class="far fa-arrow-alt-circle-left fa-lg"></i></i>&nbsp;Back
                            </a>&nbsp;&nbsp;
                            <a href="" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-box"
                                id="addNew"><i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add new</a>
                        </span>
                    </h5>
                    <div id="globalErr"></div>
                    <div class="card-body">
                        <div class="table-responsive" id="showAll">
                            <p class="text-center lead mt-5">Please wait...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    <!----------Add new categorie Modal-------->

    <div class="modal fade" role="dialog" id="modal-box">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Settings</h5>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php ;?>
                    <?=$this->form->custumAttr($frm)->begin()?>
                    <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, $frm['formID'])); ?>
                    <?= $this->form->input('operation')->hidden()?>
                    <?= $this->form->input('slID')->hidden()?>
                    <?= $this->form->input('created_at')->hidden()?>
                    <?= $this->form->input('updated_at')->hidden()?>
                    <div id="alertErr"></div>
                    <?= $this->form->input('page_slider')->labelUp('Page For slider:')?>
                    <div class="row">
                        <?= $this->form->input('slider_title')->labelUp('Title:')->wrapperClass('col-md-6')?>
                        <?= $this->form->input('slider_subtitle')->labelUp('Sub title:')->wrapperClass('col-md-6')?>
                    </div>
                    <?= $this->form->textarea('slider_text')->labelUp('Description:')?>
                    <div class="row">
                        <?= $this->form->input('slider_btn_text')->labelUp('Button Text:')->wrapperClass('col-md-6')?>
                        <?= $this->form->input('slider_btn_link')->labelUp('Button Link:')->wrapperClass('col-md-6')?>
                    </div>
                    <?= $this->form->checkbox('status')->LabelUp('Active')->value('on')?>
                    <?= $this->form->imageDD()?>
                    <div class="mb-3 justify-content-between">
                        <input type="submit" name="submitBtn" id="submitBtn" value="Submit" class="button">
                    </div>
                    <?=$this->form->end()?>
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
<script type="text/javascript" src="<?= $this->asset('js/custom/backend/admin/settings/sliders', 'js') ?? ''?>">
</script>
<?php $this->end();