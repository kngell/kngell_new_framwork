<?php $this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/custom/client/clothing/clothing', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <section class="head-promotions" id=head-promotions>
        <div class="container title">
            <h5 class="first-title">NEW ARRIVALS</h5>
            <h1 class="second-title">
                <sapn class="title-left">Best Price</sapn>&nbsp;<span class="title-right">this Year</span>
            </h1>
            <p>Shomatics offers your very comfortable time <br>on walking and exercises</p>
            <button>Shop Now</button>
        </div>
    </section>
    <!-- Brand section --------------->
    <?php require_once 'modules/_brand.php'?>

    <!-- Arrivals section --------------->
    <?php require_once 'modules/_arrivals.php'?>

    <!-- Featured section --------------->
    <?php require_once 'modules/_features.php'?>

    <!-- MiddleSeason section --------------->
    <?php require_once 'modules/_middle_season.php'?>

    <!-- Dresses and suits section --------------->
    <?php require_once 'modules/_dresses_suits.php'?>

    <!-- Dresses and suits section --------------->
    <?php require_once 'modules/_best_wishes.php'?>

    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/custom/client/clothing/clothing', 'js') ?? ''?>">
</script>
<?php $this->end();