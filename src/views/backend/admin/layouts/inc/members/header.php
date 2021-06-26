<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        <?= ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?>
        | K'nGELL
    </title>

    <!-------standards-------->
    <link href="<?=$this->cssLib?>" rel="stylesheet" type="text/css">
    <!---- Custom ----->
    <link href="<?=$this->cssMain?>" rel="stylesheet" type="text/css">
    <?= $this->content('head');?>
</head>

<body>
    <!-- body code goes here -->