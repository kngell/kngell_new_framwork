<?php $this->start('head'); ?>
<!-------Accueil-------->
<link
    href="<?= $this->asset('css/custom/home/product', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<!-- Start Main -->
<main id="main-site">
    <!-- Products -->
    <?php if (isset($this->p_details)):?>
    <?php require_once 'partials/_product_details.php'?>
    <?php else :?>
    <div class="text-center text-lead py-5">
        <h5>This product does was found</h5>
    </div>
    <?php endif;?>
    <!-- end Products -->
    <!-- Top Sales -->
    <?php require_once VIEW . 'home/partials/_top_sales.php'?>
    <!-- End top Sales -->
    <input type="hidden" id="ip_address" style="display:none"
        value="<?=H_visitors::getIP()?>">
</main>
<!-- End  Main -->
<?php $this->end(); ?>
<?php $this->start('footer')?>
<!-- Html visitors -->
<script type="text/javascript"
    src="<?= $this->asset('js/custom/home/product', 'js') ?? ''?>">
</script>
<?php $this->end();
