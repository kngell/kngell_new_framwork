<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/admin/company/details', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id=main-site>
    <!-- Content -->
    <div class="page-content">
        <!-- Content Header (Page header) -->
        <div class="row header justify-content-between mb-4 w-100">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb ps-0 fs-base">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><span>Companies</span></li>
                        <li class="breadcrumb-item active" aria-current="page">Company Details</li>
                    </ol>
                </nav>
            </div>
            <div class="col text-end">
                <h4 class="header-title h3">
                    Manage Companies
                </h4>
            </div>
        </div>
        <div class="card border-primary">
            <h5 class="card-header bg-primary d-flex justify-content-between">
                <a href="javascript:history.go(-1)" class="btn btn-light"><i
                        class="far fa-arrow-alt-circle-left fa-lg"></i>&nbsp;Back</a>
            </h5>
            <span class="text-light lead align-self-center">Company Details</span>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="card col-md-4 h-100 border-0">
                        <!-- <img class="card-img-top" src="" alt=""> -->
                        <div class="card-header text-muted">
                            <h3 class="text-center font-weight-lighter">
                                <?=$this->company->denomination?>
                            </h3>

                        </div>
                        <div class="card-body">
                            <p class=""><span class="font-weight-bold"> Signe : </span><?=$this->company->sigle?>
                            </p>
                            <p class=""><span class="font-weight-bold"> Dénomination :
                                </span><?=$this->company->denomination?>
                            </p>
                            <p class=""><span class="font-weight-bold"> siret : </span><?=$this->company->siret?>
                            </p>
                            <p class=""><span class="font-weight-bold"> Activité :
                                </span><?=$this->company->activite?>
                            </p>
                            <p class=""><span class="font-weight-bold"> RNA : </span><?=$this->company->rna?>
                            </p>
                        </div>
                    </div>
                    <div class="card col-md-8 h-100 border-0">
                        <!-- <img class="card-img-top" src="" alt=""> -->
                        <div class="card-header text-muted">
                            <h5 class="text-left font-weight-lighter">Adresses</h5>
                        </div>
                        <div class="card-body">
                            <?= $this->company->getCompanyAddressHtml($this->company->getAllAddress($this->company->compID))?>
                        </div>
                    </div>
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
    src="<?= $this->asset('js/custom/admin/company/details', 'js') ?? ''?>">
</script>
<?php $this->end();
