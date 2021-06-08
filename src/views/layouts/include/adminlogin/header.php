<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->get_siteTitle() ?>
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main style -->
    <link
        href="<?= $this->get_Asset('css/librairies/adminlib', 'css') ?? ''?>"
        rel="stylesheet" type="text/css">
    <!-- Plugins css -->
    <link
        href="<?= $this->get_Asset('css/plugins/adminplugins', 'css') ?? ''?>"
        rel="stylesheet" type="text/css">
    <!-- Main style -->
    <link
        href="<?= $this->get_Asset('css/main/backend/admin/main', 'css') ?? ''?>"
        rel="stylesheet" type="text/css">
    <?= $this->content('head');?>

</head>

<body class="hold-transition login-page">
    <div class="login-box">