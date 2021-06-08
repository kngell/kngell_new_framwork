<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/users/account/payment', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <div class="site-title text-center">
        <h1 class="font-title"> Shopping Cart</h1>
    </div>
    <div class="container">
        <div class="grid">
            <div class="col-1">
                <div class="flex item justify-content-between">
                    <div class="">
                        <div class="img text-center">
                            <img src="<?=ImageManager::asset_img('payment/prod1')?>"
                                alt="">
                        </div>
                        <div class="title">
                            <h3>Canon EOS 1500D</h3>
                            <span>Electronics</span>
                            <div class="buttons">
                                <button type="submit"><i class="fas fa-chevron-up"></i> </button>
                                <input type="text" class="font-title" value="1">
                                <button type="submit"><i class="fas fa-chevron-down"></i> </button>
                            </div>
                            <a href="#">Save for later</a> |
                            <a href="#">Delete From Cart</a>
                        </div>
                    </div>
                    <div class="price">
                        <h4 class="text-red">$349</h4>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="subtotal text-center">
                    <h3>Price Details</h3>
                    <ul>
                        <li class="flex justify-content-between">
                            <label for="price">Products ( 3 items ) : </label>
                            <span>$399</span>
                        </li>
                        <li class="flex justify-content-between">
                            <label for="price">Delivery Charges : </label>
                            <span>Free</span>
                        </li>
                        <hr>
                        <li class="flex justify-content-between">
                            <label for="price">Amout Payble : </label>
                            <span class="text-red font-title">$399</span>
                        </li>
                    </ul>
                    <div id="paypal-payment-button">
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
    src="<?= $this->asset('js/custom/users/account/payment', 'js') ?? ''?>">
</script>
<?php $this->end();
