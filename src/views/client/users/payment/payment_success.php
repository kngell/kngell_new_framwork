<?php $this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/custom/client/users/payment/payment_success', 'css') ?? ''?>" rel="stylesheet"
    type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <div class="site-title text-center">
        <h1 class="font-title"> Sucess</h1>
    </div>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="card col-md-8">
                <div class="card-header">
                    <h5 class="modal-title" id="modal_success_checkoutLabel">Purchase Result</h5>
                </div>
                <div class="card-body">
                    <h2>Thank you for purchazing.</h2>
                    <hr>
                    <p>Your transaction ID is : <?=$this->view_data['transactionID']?>
                    </p>
                    <p>Please check your Email for more informations, or consult your account ti view your orders</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="<?=PROOT . 'home' . US . 'cart'?>" class="btn btn-warning">Buy again</a>
                    <a href="<?=PROOT . 'home' . US . 'boutique'?>" class="btn btn-success">Continue shopping</a>
                </div>
            </div>
        </div>
    </div>
    <?php require_once VIEW . 'client' . DS . 'home' . DS . 'partials/_new_products.php'?>
    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/custom/client/users/payment/payment_success', 'js') ?? ''?>">
</script>
<?php $this->end();