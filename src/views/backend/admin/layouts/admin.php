<?php require_once 'inc/admin/header.php'?>
<?php require_once 'inc/admin/side_nav.php';?>
<div class="page-container">
    <?php require_once 'inc/admin/nav.php'?>

    <?= $this->content('body');?>

    <?php require_once 'inc/admin/footer.php'?>
</div>
<?php require_once 'inc/admin/modal.php'?>
<?php require_once 'inc/admin/script.php';
