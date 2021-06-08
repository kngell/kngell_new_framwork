<?php $this->start('head'); ?>
<!-------Accueil-------->
<link
    href="<?= $this->asset('css/custom/home/cart/cart', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<!-- Start Main -->
<main id="main-site">
    <!-- Shoping cart  -->
    <?php require_once VIEW . 'home/cart/partials/_shopping_cart.php'?>
    <!-- !Shpoping cart -->
    <!-- Wishlist  -->
    <?php require_once VIEW . 'home/cart/partials/_wishlist.php'?>
    <!-- !Wishlist -->
    <!-- New Phones -->
    <?php require_once VIEW . 'home/partials/_new_products.php'?>
    <!-- End New Phones -->
    <input type="hidden" id="ip_address" style="display:none"
        value="<?=H_visitors::getIP()?>">
</main>
<!-- End  Main -->

<?php $this->end(); ?>
<?php $this->start('footer')?>
<!-- Html visitors -->
<script type="text/javascript"
    src="<?= $this->asset('js/custom/home/cart/cart', 'js') ?? ''?>">
</script>
<?php $this->end();
