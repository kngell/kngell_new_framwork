<?php $this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/custom/client/clothing/clothing', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <section class="head-promotions" id=head-promotions
        style="background-image: url(<?=str_replace('\\', '/', implode($slider->p_media))?> )">
        <div class="container title">
            <h5 class="first-title"><?=strtoupper($slider->slider_subtitle)?>
            </h5>
            <h1 class="second-title">
                <?php $title = explode('|', $slider->slider_title);
                $title = array_map('trim', $title);?>
                <span class="title-left"><?=$title[0]?>
                </span>&nbsp;<span class="title-right"><?=$title[1]?></span>
            </h1>
            <?php $text = explode('|', $slider->slider_text)?>
            <p><?=$text[0]?> <br><?=$text[1]?>
            </p>
            <button><?=$slider->slider_btn_text?></button>
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