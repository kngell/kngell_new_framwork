<?php $this->start('head'); ?>
<!-------Costum-------->
<meta name="csrftoken" content="<?=$this->token->generate_token(8, 'all_product_page')?>" />
<link href="<?= $this->asset('css/custom/client/users/checkout/checkout', 'css') ?? ''?>" rel="stylesheet"
    type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <div class="container">
        <div class="page-content py-5">
            <div class="navigation">
                <div class="header">
                    <h2 class="title fw-bold">Checkout</h2>
                    <hr class="horizontal-line">
                </div>
                <ul class="nav progress-container">
                    <li class="progress" id="progress"></li>
                    <li class="nav-item step">
                        <a href="#order-information" data-bs-toggle="tab" aria-expanded="false"
                            class="nav-link rounded-0 w-100 active">
                            <div class="circle"><i class="fad fa-id-card"></i></div>
                            <span class="d-none d-lg-block">Infomation</span>
                        </a>
                    </li>
                    <li class="nav-item step">
                        <a href="#shipping-information" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link rounded-0 w-100">
                            <div class="circle"><i class="fal fa-truck-moving"></i></div>
                            <span class="d-none d-lg-block">Livraison</span>
                        </a>
                    </li>
                    <li class="nav-item step">
                        <a href="#payment-information" data-bs-toggle="tab" aria-expanded="false"
                            class="nav-link rounded-0 w-100">
                            <div class="circle"><i class="fad fa-credit-card"></i></div>
                            <span class="d-none d-lg-block">Payement</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-control button-group">
                    <button class="previous" type="button" disabled><i
                            class="fa fa-angle-left fa-3x fa-fw"></i></button>
                    <button class="next" type="button"><i class="fa fa-angle-right fa-3x fa-fw"></i></button>
                </div>
            </div>
            <form class="user-ckeckout-frm needs-validation" id="user-ckeckout-frm" novalidate
                enctype="multipart/form-data" autocomplete="off">
                <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'user-ckeckout-frm')); ?>
                <div id="alertErr"></div>
                <input type="hidden" name="total-ttc"
                    value="<?=isset($this->user_cart[2][1]) ? $this->user_cart[2][1] : ''?>">
                <input type="hidden" name="total-ht"
                    value="<?=isset($this->user_cart[2][1]) ? $this->user_cart[2][0] : ''?>">
            </form>
            <div class="tab-content shadow-none px-0">
                <div class="tab-pane fade show active" id="order-information">
                    <div class="row flex-lg-row-reverse">
                        <div class="col-lg-4 order-summary">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Resumé de la commande</h4>
                                    <div class="table-responsive order-resume">
                                        <table class="table table-borderless mb-0 align-middle">
                                            <tbody>
                                                <?php foreach ($this->user_cart[0] as $product) :
                                                if ($product->c_content == 'cart') :?>
                                                <tr class="product-line">
                                                    <td class="p-cell p-img">
                                                        <div class="product-thumbnail-wrapper mt-2">
                                                            <img alt="Product"
                                                                src="<?= str_starts_with($product->p_media[0], IMG) ? unserialize($product->p_media) : IMG . unserialize($product->p_media)[0] ?>"
                                                                class="img-thumbnail" width="48">
                                                            <span
                                                                class="product-thumbnail-quantity"><?=$product->item_qty?></span>
                                                        </div>
                                                    </td>
                                                    <td class="p-cell p-title">
                                                        <?=$product->htmlDecode($product->p_title)?>
                                                        <br>
                                                        <span><?= $product->p_color ?>&nbsp;<?=$product->p_color != null || $product->p_size != null ? ' / ' : ''?>&nbsp;<?=$product->p_size?></span>
                                                    </td>
                                                    <td class="p-cell p-price"><?= $product->price?>
                                                    </td>
                                                </tr>

                                                <?php endif;
                                            endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="table-responsive total">
                                        <table class="table table-borderless text-end mb-0">
                                            <tbody>
                                                <tr class="sub-total">
                                                    <td class="title">Total HT :</td>
                                                    <td class="amount"><?=$this->user_cart[2][0]?>
                                                    </td>
                                                </tr>
                                                <?=$this->user_cart[3]['checkout'][0]?>
                                                <tr class="total-ttc">
                                                    <td class="title">Total TTC :</td>
                                                    <td class="amount"><?=$this->user_cart[2][1]?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-8 order-details">
                            <div class="card">
                                <div class="card-body form-wrapper">
                                    <?php if (isset(AuthManager::$currentLoggedInUser)) :?>
                                    <?php $user_data = $this->user_data->get_single_user(AuthManager::$currentLoggedInUser->userID);
                                    if ($user_data) : ?>
                                    <div class="user-prim-data">
                                        <div class="d-flex mt-2 justify-content-between form-title">
                                            <h4 class="card-sub-title">Information - Contact</h4>
                                            <?php if (!isset(AuthManager::$currentLoggedInUser)) :?>
                                            <div class="account-request">
                                                <span aria-hidden="true">Already have an account?</span>
                                                <a class="text-highlight" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#login-box">Login</a>
                                            </div>
                                            <?php endif;?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 input-box">
                                                    <input type="text" name="lastName"
                                                        class="form-control input-box__input" id="chk-lastName"
                                                        autocomplete="nope" placeholder=" "
                                                        value="<?=$this->user_data->lastName ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <div class="invalid-feedback"></div>
                                                    <label for="chk-lastName" class="input-box__label">
                                                        Nom
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 input-box">
                                                    <input type="text" name="firstName"
                                                        class="form-control input-box__input" id="chk-firstName"
                                                        placeholder=" " autocomplete="nope"
                                                        value="<?=$this->user_data->firstName ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <div class="invalid-feddback"></div>
                                                    <label for="chk-firstName" class="input-box__label">
                                                        Prénom <span class="text-danger">*</span>
                                                    </label>

                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 input-box">
                                                    <input type="text" name="phone"
                                                        class="form-control input-box__input" id="chk-phone"
                                                        placeholder=" " autocomplete="nope"
                                                        value="<?=$this->user_data->phone ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <label for="chk-phone" class="input-box__label">
                                                        Téléphone
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 input-box">
                                                    <input type="email" name="email"
                                                        class="form-control input-box__input" id="chk-email"
                                                        placeholder=" " autocomplete="nope"
                                                        value="<?=$this->user_data->email ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <div class="invalid-feedback input-box__feedback"></div>
                                                    <label for="chk-email" class="input-box__label">
                                                        Email<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="form-title">
                                            <h4 class="mt-2 mb-3 card-sub-title">Adresse de Livraison</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3 input-box">
                                                    <select class="form-select select_country input-box__input"
                                                        name="pays" id="pays" placeholder=" " form="user-ckeckout-frm">
                                                        <option value="<?=$this->user_data->pays?>">
                                                            <?=$this->user_data->get_countrie($this->user_data->pays)[$this->user_data->pays]?>
                                                        </option>
                                                    </select>
                                                    <div class="invalig-feedback"></div>
                                                    <label for="pays" class="input-box__label">
                                                        Pays<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="address1" placeholder=" " id="address1"
                                                        autocomplete="nope"
                                                        value="<?=$this->user_data->htmlDecode($this->user_data->address1 ?? '') ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <div class="invalig-feedback"></div>
                                                    <label for="address1" class="input-box__label">
                                                        Adresse ligne 1<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="address2" placeholder=" " id="address2"
                                                        autocomplete="nope"
                                                        value="<?=$this->user_data->htmlDecode($this->user_data->address2 ?? '') ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <div class="invalig-feedback"></div>
                                                    <label for="address2" class="input-box__label">
                                                        Adresse ligne 2
                                                    </label>
                                                </div>

                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="ville" id="ville" placeholder=" " autocomplete="nope"
                                                        value="<?=$this->user_data->htmlDecode($this->user_data->ville ?? '') ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <div class="invalig-feedback"></div>
                                                    <label for="ville" class="input-box__label">
                                                        Ville<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="region" id="region" placeholder=" " autocomplete="nope"
                                                        value="<?=$this->user_data->htmlDecode($this->user_data->region ?? '') ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <label for="region" class="input-box__label">
                                                        Region
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="zip_code" id="zip_code" placeholder=" "
                                                        autocomplete="nope"
                                                        value="<?=$this->user_data->htmlDecode($this->user_data->zip_code ?? '') ?? ''?>"
                                                        form="user-ckeckout-frm">
                                                    <div class="invalig-feedback"></div>
                                                    <label for="zip_code" class="input-box__label">
                                                        Code Postal<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <div class="mb-3 input-box">
                                                    <textarea class="form-control input-box__input input-box__textarea"
                                                        id="u_comment" name="u_comment" rows="3" placeholder=" "
                                                        form="user-ckeckout-frm"><?=$this->user_data->htmlDecode($this->user_data->u_comment ?? '') ?? ''?></textarea>
                                                    <label for="u_comment" class="input-box__label">
                                                        Commentaires, notes ...
                                                    </label>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="mt-2">
                                            <label class="checkbox d-inline-block me-3" for="checkout-remember-me">
                                                <input class="checkbox__input" id="checkout-remember-me" type="checkbox"
                                                    name="principale" form="user-ckeckout-frm"
                                                    <?=$this->user_data->principale == 'on' ? 'checked' : '' ?>>
                                                <span class="checkbox__box"></span>
                                                Sauvegarder ces informations pour la prochaine fois
                                            </label>
                                        </div>
                                        <div class="row my-4 button-group">
                                            <div class="col-6">
                                                <a href="<?=PROOT . 'home' . DS . 'cart'?>" class="return-to-cart">
                                                    <i class="fal fa-angle-double-left"></i>&nbsp;
                                                    Return to cart
                                                </a>
                                            </div> <!-- end col -->
                                            <div class="col-6">
                                                <div class="text-end">
                                                    <a href="javascript:void(0)" class="next">
                                                        Continue &nbsp;<i class="far fa-angle-double-right"></i>
                                                    </a>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>
                                    <?php endif;endif;?>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row-->
                </div>
                <!-- end tab-pane -->
                <div class="tab-pane" id="shipping-information">
                    <div class="row flex-lg-row-reverse">
                        <div class="col-lg-4 order-summary">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Resumé de la commande</h4>
                                    <div class="table-responsive order-resume">
                                        <table class="table table-borderless mb-0 align-middle">
                                            <tbody>
                                                <?php foreach ($this->user_cart[0] as $product) :
                                                if ($product->c_content == 'cart') :?>
                                                <tr class="product-line">
                                                    <td class="p-cell p-img">
                                                        <div class="product-thumbnail-wrapper mt-2">
                                                            <img alt="Product"
                                                                src="<?= str_starts_with($product->p_media[0], IMG) ? unserialize($product->p_media) : IMG . unserialize($product->p_media)[0] ?>"
                                                                class="img-thumbnail" width="48">
                                                            <span
                                                                class="product-thumbnail-quantity"><?=$product->item_qty?></span>
                                                        </div>
                                                    </td>
                                                    <td class="p-cell p-title">
                                                        <?=$product->htmlDecode($product->p_title)?>
                                                        <br>
                                                        <span><?= $product->p_color ?>&nbsp;<?=$product->p_color != null || $product->p_size != null ? ' / ' : ''?>&nbsp;<?=$product->p_size?></span>
                                                    </td>
                                                    <td class="p-cell p-price"><?= $product->price?>
                                                    </td>
                                                </tr>

                                                <?php endif;
                                            endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                    <hr>
                                    <div class="table-responsive total">
                                        <table class="table table-borderless text-end mb-0">
                                            <tbody>
                                                <tr class="sub-total">
                                                    <td class="title">Total HT :</td>
                                                    <td class="amount"><?=$this->user_cart[2][0]?>
                                                    </td>
                                                </tr>
                                                <?=$this->user_cart[3]['checkout'][0]?>
                                                <tr class="total-ttc">
                                                    <td class="title">Total TTC :</td>
                                                    <td class="amount"><?=$this->user_cart[2][1]?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-8 order-details">
                            <div class="card">
                                <div class="card-body">
                                    <div class="border p-3 mb-3 rounded info-resume">
                                        <table class="table table-borderless">
                                            <tr class="border-bottom contact">
                                                <td class="title">Contact:</td>
                                                <td class="value">donnie1973@hotmail.com</td>
                                                <td class="link"><a href="#" class="text-highlight">Change</a></td>
                                            </tr>
                                            <tr class="address">
                                                <td class="title">Ship to:</td>
                                                <td class="value">3363 Cook Hill Road, Wallingford, Connecticut(CT),
                                                    06492,
                                                    Wallingford CT
                                                    06492, United
                                                    States</td>
                                                <td class="link"><a href="#" class="text-highlight">Change</a></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="card-sub-title">
                                        <h4 class="title">
                                            Shipping method
                                        </h4>
                                    </div>
                                    <div class="border mb-3 rounded radio-check-group">
                                        <?php if (isset($this->shipping_class) && $this->shipping_class->count() > 0) :?>
                                        <?php foreach ($this->shipping_class->get_results() as $shipping_class) :?>
                                        <?php if ($shipping_class->status == 'on'):?>
                                        <div class="radio-check">
                                            <div class="radio-check__wrapper">
                                                <label for="sh_name<?=$shipping_class->shcID?>" class="radio">
                                                    <input type="radio" name="sh_name" class="radio__input"
                                                        id="sh_name<?=$shipping_class->shcID?>" form="user-ckeckout-frm"
                                                        value="<?=$shipping_class->shcID?>">
                                                    <span class="radio__radio"></span>
                                                    <div class="radio__text">
                                                        <?=$shipping_class->htmlDecode($shipping_class->sh_name)?>
                                                        <br>
                                                        <span
                                                            class="fs-sm"><?=$shipping_class->htmlDecode($shipping_class->sh_descr)?></span>
                                                    </div>
                                                </label>
                                            </div>
                                            <span
                                                class="price"><?=$shipping_class->get_currency($shipping_class->price)?></span>
                                        </div>
                                        <?php endif;?>
                                        <?php endforeach;?>
                                        <?php endif;?>

                                    </div>
                                    <!-- end border -->
                                    <div class="row mt-4 button-group">
                                        <div class="col-6">
                                            <a href="javascript:void(0);" class="previous">
                                                <i class="fal fa-angle-double-left"></i>
                                                &nbsp;Back to Information
                                            </a>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-6">
                                            <div class="text-end">
                                                <a href="javascript:void(0);" class="next">
                                                    Continue to Payment &nbsp;<i
                                                        class="far fa-angle-double-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row-->
                </div>
                <div class="tab-pane" id="payment-information">
                    <div class="row flex-lg-row-reverse">
                        <div class="col-lg-4 order-summary">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Resumé de la commande</h4>
                                    <div class="table-responsive order-resume">
                                        <table class="table table-borderless mb-0 align-middle">
                                            <tbody>
                                                <?php foreach ($this->user_cart[0] as $product) :
                                                if ($product->c_content == 'cart') :?>
                                                <tr class="product-line">
                                                    <td class="p-cell p-img">
                                                        <div class="product-thumbnail-wrapper mt-2">
                                                            <img alt="Product"
                                                                src="<?= str_starts_with($product->p_media[0], IMG) ? unserialize($product->p_media) : IMG . unserialize($product->p_media)[0] ?>"
                                                                class="img-thumbnail" width="48">
                                                            <span
                                                                class="product-thumbnail-quantity"><?=$product->item_qty?></span>
                                                        </div>
                                                    </td>
                                                    <td class="p-cell p-title">
                                                        <?=$product->htmlDecode($product->p_title)?>
                                                        <br>
                                                        <span><?= $product->p_color ?>&nbsp;<?=$product->p_color != null || $product->p_size != null ? ' / ' : ''?>&nbsp;<?=$product->p_size?></span>
                                                    </td>
                                                    <td class="p-cell p-price"><?= $product->price?>
                                                    </td>
                                                </tr>

                                                <?php endif;
                                            endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                    <hr>
                                    <div class="table-responsive total">
                                        <table class="table table-borderless text-end mb-0">
                                            <tbody>
                                                <tr class="sub-total">
                                                    <td class="title">Total HT :</td>
                                                    <td class="amount"><?=$this->user_cart[2][0]?>
                                                    </td>
                                                </tr>
                                                <?=$this->user_cart[3]['checkout'][0]?>
                                                <tr class="total-ttc">
                                                    <td class="title">Total TTC :</td>
                                                    <td class="amount"><?=$this->user_cart[2][1]?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-footer proceed" style="display:none;">
                                    <form class="buy-frm">
                                        <?=FH::csrfInput('csrftoken', $this->token->generate_token(8, 'buy-frm')); ?>
                                        <button class="button buy-btn" type="button">Proceed to
                                            buy</button>
                                    </form>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-8 order-details">
                            <div class="card">
                                <div class="card-body">
                                    <div class="border p-3 mb-3 rounded info-resume">
                                        <table class="table table-borderless">
                                            <tr class="border-bottom contact">
                                                <td>Contact:</td>
                                                <td>donnie1973@hotmail.com</td>
                                                <td><a href="#" class="text-highlight">Change</a></td>
                                            </tr>
                                            <tr class="border-bottom address">
                                                <td>Ship to</td>
                                                <td>3363 Cook Hill Road, Wallingford, Connecticut(CT), 06492,
                                                    Wallingford CT
                                                    06492, United
                                                    States</td>
                                                <td><a href="#" class="text-highlight">Change</a></td>
                                            </tr>
                                            <tr class="method">
                                                <td>Method</td>
                                                <td>FedEx Ground · $8.73</td>
                                                <td><a href="#" class="text-highlight">Change</a></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="card-sub-title">
                                        <h4 class="title">
                                            Payement
                                        </h4>
                                    </div>
                                    <p class="infos-transaction">All transactions are secure and encrypted.</p>
                                    <div id="order-payment" class="border mb-3 rounded radio-check-group">
                                        <?php if (isset($this->pmt_getaway) && $this->pmt_getaway->count() > 0) :?>
                                        <?php foreach ($this->pmt_getaway->get_results() as $pmt_getaway) :?>
                                        <?php if ($pmt_getaway->status == 'on'):?>
                                        <div class="payment-gateway">
                                            <div class="radio-check payment-gateway-header">
                                                <div class="radio-check__wrapper">
                                                    <label for="pm_name<?=$pmt_getaway->pmID?>" class="radio">
                                                        <input type="radio" name="pm_name" class="radio__input"
                                                            id="pm_name<?=$pmt_getaway->pmID?>" form="user-ckeckout-frm"
                                                            value="<?=$pmt_getaway->pmID?>">
                                                        <span class="radio__radio"></span>
                                                        <div class="radio__text">
                                                            <span class="fw-700"><?=$pmt_getaway->pm_name?></span>
                                                        </div>
                                                    </label>
                                                </div>
                                                <?php if ($pmt_getaway->pm_name == 'Credit Card') :?>
                                                <div class="brand-icons">
                                                    <span><a href="#" class="text-highlight">Change</a></span>
                                                    <span class="payment-icon payment-icon-visa">
                                                    </span>
                                                    <span class="payment-icon payment-icon-master">
                                                    </span>
                                                    <span class="payment-icon payment-icon-american-express">
                                                    </span>
                                                    <span class="payment-icon payment-icon-discover">
                                                    </span>
                                                </div>
                                                <?php endif;?>
                                            </div>
                                            <?php if ($pmt_getaway->pm_name == 'Credit Card') :?>
                                            <!-- end payment-gateway-header -->
                                            <div
                                                class="payment-gateway-content  border-bottom payment-gateway-content-credit-card p-3">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="cc_number" id="cc_number" placeholder=" "
                                                                autocomplete="off" form="user-ckeckout-frm">
                                                            <div class="invalig-feedback"></div>
                                                            <label for="cc_number" class="input-box__label">
                                                                Card number<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="cc_name" id="cc_name" placeholder=" "
                                                                autocomplete="off" form="user-ckeckout-frm">
                                                            <div class="invalig-feedback"></div>
                                                            <label for="cc_name" class="input-box__label">
                                                                Name on card<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="cc_expiry" id="cc_expiry" placeholder=" "
                                                                autocomplete="off" form="user-ckeckout-frm">
                                                            <label for="cc_expiry" class="input-box__label">
                                                                Expiration date (MM
                                                                /
                                                                YY)<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="cc_cvv" id="cc_cvv" placeholder=" "
                                                                autocomplete="off" form="user-ckeckout-frm">
                                                            <label for="cc_cvv" class="input-box__label">
                                                                Security code<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end payment-gateway-content -->
                                            <?php elseif ($pmt_getaway->pm_name == 'PayPal') :?>
                                            <!-- end payment-gateway-header -->
                                            <div
                                                class="payment-gateway-content p-5 border-bottom flex-column justify-content-center align-items-center">
                                                <span class="payment-gateway-outsite"></span>
                                                <p class="mt-3">After clicking “Complete order”, you will be
                                                    redirected
                                                    to
                                                    PayPal to complete
                                                    your purchase securely.</p>
                                            </div>
                                            <!-- end payment-gateway-content -->
                                            <?php elseif ($pmt_getaway->pm_name == 'Amazon Pay') :?>
                                            <!-- end payment-gateway-header -->
                                            <div
                                                class="payment-gateway-content p-5 border-bottom flex-column justify-content-center align-items-center">
                                                <span class="payment-gateway-outsite"></span>
                                                <p class="mt-3">You will be asked to login with Amazon.</p>
                                            </div>
                                            <!-- end payment-gateway-content -->
                                            <?php elseif ($pmt_getaway->pm_name == 'Pay over time with Klarna') :?>
                                            <!-- end payment-gateway-header -->
                                            <div
                                                class="payment-gateway-content p-5 flex-column justify-content-center align-items-center">
                                                <span class="payment-gateway-outsite"></span>
                                                <p class="mt-3">After clicking "Complete order", you will be
                                                    redirected
                                                    to
                                                    Pay over time with
                                                    Klarna to complete your purchase securely.</p>
                                            </div>
                                            <!-- end payment-gateway-content -->
                                            <?php endif;?>
                                        </div>
                                        <?php endif;?>
                                        <?php endforeach;?>
                                        <?php endif;?>

                                    </div>
                                    <!-- end order-payment -->
                                    <div class="card-sub-title">
                                        <h4 class="title">
                                            Billing address
                                        </h4>
                                    </div>
                                    <p class="infos-transaction">Select the address that matches your card or
                                        payment
                                        method.</p>
                                    <div id="order-billing-address" class="border mb-3 rounded radio-check-group">
                                        <div class="billing-address ">
                                            <div class="radio-check billing-address-header">
                                                <div class="radio-check__wrapper">
                                                    <label for="checkout-billing-address-id-1" class="radio">
                                                        <input type="radio" name="prefred_billing_addr"
                                                            class="radio__input" id="checkout-billing-address-id-1"
                                                            form="user-ckeckout-frm" value="1">
                                                        <span class="radio__radio"></span>
                                                        <div class="radio__text">
                                                            <span class="fw-700">Same as shipping address</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- end billing-address-header -->
                                        </div>
                                        <!-- end billing-address -->
                                        <div class="billing-address">
                                            <div class="radio-check billing-address-header">
                                                <div class="radio-check__wrapper">
                                                    <label for="checkout-billing-address-id-2" class="radio">
                                                        <input type="radio" name="prefred_billing_addr"
                                                            class="radio__input" id="checkout-billing-address-id-2"
                                                            form="user-ckeckout-frm" value="2">
                                                        <span class="radio__radio"></span>
                                                        <div class="radio__text">
                                                            <span class="fw-700"> Use a different billing
                                                                address</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- end billing-address-header -->
                                            <div class="billing-address-content p-3">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="other-billing-first-name"
                                                                id="other-billing-first-name" placeholder=" "
                                                                autocomplete="off" form="user-ckeckout-frm">
                                                            <label for="other-billing-first-name"
                                                                class="input-box__label">
                                                                First Name<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="other-billing-last-name"
                                                                id="other-billing-last-name" placeholder=" "
                                                                autocomplete="off" form="user-ckeckout-frm">
                                                            <label for="other-billing-last-name"
                                                                class="input-box__label">
                                                                Last Name<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="other-billing-phone" id="other-billing-phone"
                                                                placeholder=" " autocomplete="off"
                                                                form="user-ckeckout-frm">
                                                            <label for="other-billing-last-name"
                                                                class="input-box__label">
                                                                Phone number<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="email"
                                                                name="other-billing-email-address"
                                                                id="other-billing-email-address" placeholder=" "
                                                                autocomplete="off" form="user-ckeckout-frm">
                                                            <label for="other-billing-email-address"
                                                                class="input-box__label">
                                                                Email Address<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <select class="form-select select_country input-box__input"
                                                                data-placeholder=" " id="other-billing-country"
                                                                name="other-billing-country" placeholder=" "
                                                                form="user-ckeckout-frm" style="width: 100%">
                                                            </select>
                                                            <label for="other-billing-country" class="input-box__label">
                                                                Country<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                placeholder=" " id="billing-address-1"
                                                                name="billing-address-1" autocomplete="off"
                                                                form="user-ckeckout-frm">
                                                            <label for="billing-address-1" class="input-box__label">
                                                                Address ligne 1<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                placeholder=" " id="billing-address-2"
                                                                name="billing-address-2" autocomplete="off"
                                                                form="user-ckeckout-frm">
                                                            <label for="billing-address-2" class="input-box__label">
                                                                Address ligne 2
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                id="billing-town-city" name="billing-town-city"
                                                                placeholder=" " autocomplete="off"
                                                                form="user-ckeckout-frm">
                                                            <label for="billing-town-city" class="input-box__label">
                                                                Town / City<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="billing-region" id="billing-region"
                                                                placeholder=" " autocomplete="off"
                                                                form="user-ckeckout-frm">
                                                            <label for="billing-state" class="input-box__label">
                                                                State / Province /
                                                                Region<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="mb-3 input-box">
                                                            <input class="form-control input-box__input" type="text"
                                                                name="billing-zip-postal" id="billing-zip-postal"
                                                                placeholder=" " autocomplete="off"
                                                                form="user-ckeckout-frm">
                                                            <label for="billing-zip-postal" class="input-box__label">
                                                                Zip Code<span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </div>
                                            <!-- end billing-address-content -->
                                        </div>
                                        <!-- end billing-address -->
                                    </div>
                                    <!-- end billing-address -->
                                    <div class="row mt-4 button-group">
                                        <div class="col-6">
                                            <a href="javascript:void(0);" class="previous">
                                                <i class="fal fa-angle-double-left"></i>&nbsp;
                                                Return to shipping
                                            </a>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-6">
                                            <div class="text-end">
                                                <button type="submit" class="complete-order" id="complete-order"
                                                    form="user-ckeckout-frm">
                                                    Complete order&nbsp;<i class="fal fa-angle-double-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row-->
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/custom/client/users/checkout/checkout', 'js') ?? ''?>">
</script>
<?php $this->end();