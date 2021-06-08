<?php require_once 'include/admin/header.php'?>
<?php require_once 'include/admin/side_nav.php';?>
<div class="page-container">
    <?php require_once 'include/admin/nav.php'?>

    <?= $this->content('body');?>

    <?php require_once 'include/admin/footer.php'?>
</div>
<?php require_once 'include/admin/modal.php'?>
<?php require_once 'include/admin/script.php';
