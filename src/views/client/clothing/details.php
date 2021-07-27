<?php $this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/custom/client/clothing/details', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->

    <!-- product details --------------->
    <?php require_once 'modules/_details.php'?>

    <!-- product details --------------->
    <?php require_once 'modules/_related_products.php'?>

    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/custom/client/clothing/details', 'js') ?? ''?>">
</script>
<?php $this->end();