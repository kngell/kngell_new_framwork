<?php
$menu = GrantAccess::getMenu('menu_adm_user');
$currentPage = H::currentPage();
function icon($elt)
{
    switch ($elt) {
    case 'Home':
        return 'fas fa-home';
    break;
    case 'Profile':
        return 'fas fa-user-circle';
    break;
    case 'Feedback':
        return 'fas fa-comment-dots';
    break;
     case 'Notification':
        return ['fas fa-bell','checkNotification'];
    break;
    
    default:
        return;
    break;
}
}
//dd($this);
?>
<!-----------------------Navbar-------------------->
<nav class="navbar navbar-expand-sm bg-nav navbar-dark fixed-top">
    <!-- Brand -->
    <a class="navbar-brand" href="<?=PROOT?>members/index"><img src="<?=IMG?>logo.png" width="80" alt="" /></a>
    <!-- Links -->
    <div class="back">
        <a href="<?=PROOT?>home" class="nav-link ml-auto pb-2 text-uppercase text-white"><i
                class="fas fa-arrow-alt-circle-left fa-lg"></i>&nbsp; Back to K'nGELL</a>
    </div>
    <div class="nav-wrapper"></div>
    <ul class="navbar-nav ml-auto">
        <?php
        foreach ($menu as $key => $val) :
            $active = '';
            ?>
        <?php
            if (is_array($val)) :?>
        <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbardrop"
                data-toggle="dropdown"><i class="fas fa-user-cog"></i> &nbsp; Bonjour &nbsp;!
                &nbsp;<?=$this->view_data->lastName?> </a>
            <ul class="dropdown-menu">
                <?php
                    foreach ($val as $k => $v) :
                        $active = ($v == $currentPage) ? 'active' : '';
                ?>
                <?php if ($k == 'separator') : ?>
                <li role="separator" class="dropdown-divider"></li>
                <?php else : ?>
                <li class="dropdown-item <?= $active ?>">
                    <a class="nav-link text-secondary" href="<?= $v ?>"><i class="fas fa-cog"></i>&nbsp;
                        <?= $k ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>

            </ul>
        </li>
        <?php
            else :
                $active = ($val == $currentPage) ? 'active' : '';
             ?>
        <?php if ($key == 'Notification') : ?>
        <li class="nav-item <?= $active ?>"> <a class="nav-link" href="<?= $val ?>"><i
                    class="<?=icon($key)[0]?>"></i>&nbsp;
                <?= $key ?>&nbsp;<span id="<?=icon($key)[1]?>"></span>
            </a> </li>
        <?php else : ?>
        <li class="nav-item <?= $active ?>"> <a class="nav-link" href="<?= $val ?>"><i
                    class="<?=icon($key)?>"></i>&nbsp;
                <?= $key ?>
            </a> </li>
        <?php endif ; ?>

        <?php $currentPage = !empty($active) ? $key : $currentPage; ?>
        <?php endif; ?>
        <?php endforeach; ?>

    </ul>
    </div>
</nav>