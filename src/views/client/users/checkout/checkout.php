<?php $this->start('head'); ?>
<!-------Costum-------->
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
                                    <!-- end table-responsive -->
                                    <hr>
                                    <form class="code-achat">
                                        <div class="input-box">
                                            <input type="text" class="form-control input-box__input"
                                                id="code-promo-achat" placeholder=" ">
                                            <label for="code-promo-achat" class="input-box__label">
                                                Code Promo Achats
                                            </label>
                                        </div>
                                        <button class="code-achat__btn" type="button">Valider</button>
                                    </form>
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
                                    <form class="form g-3 needs-validation" novalidate>
                                        <div class="d-flex mt-2 justify-content-between form-title">
                                            <h4 class="card-sub-title">Information - Contact</h4>
                                            <div class="account-request">
                                                <span aria-hidden="true">Already have an account?</span>
                                                <a class="text-highlight" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#login-box">Login</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 input-box">
                                                    <input type="text" name="lastName"
                                                        class="form-control input-box__input" id="chk-lastName"
                                                        autocomplete="nope" placeholder=" ">
                                                    <div class="invalid-feedback"></div>
                                                    <label for="chk-lastName" class="input-box__label">
                                                        Nom <span class="text-danger">*</span>

                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 input-box">
                                                    <input type="text" name="firstName"
                                                        class="form-control input-box__input" id="chk-firstName"
                                                        placeholder=" " autocomplete="nope">
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
                                                        placeholder=" " autocomplete="nope">
                                                    <label for="chk-phone" class="input-box__label">
                                                        Téléphone
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 input-box">
                                                    <input type="email" name="email"
                                                        class="form-control input-box__input" id="chk-email"
                                                        placeholder=" " autocomplete="nope">
                                                    <div class="invalid-feddback"></div>
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
                                                        name="pays" id="pays" placeholder=" ">
                                                    </select>
                                                    <div class="invalig-feedback"></div>
                                                    <label for="pays" class="input-box__label">
                                                        Selectionnez un pays<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="address" placeholder=" " id="address1" autocomplete="nope"
                                                        row="3">
                                                    <div class="invalig-feedback"></div>
                                                    <label for="address1" class="input-box__label">
                                                        Adresse ligne 1<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="address" placeholder=" " id="address2" autocomplete="nope"
                                                        row="3">
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
                                                        name="ville" id="ville" placeholder=" " autocomplete="nope">
                                                    <div class="invalig-feedback"></div>
                                                    <label for="ville" class="input-box__label">
                                                        Ville<span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="region" id="region" placeholder=" " autocomplete="nope">
                                                    <label for="region" class="input-box__label">
                                                        Region
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3 input-box">
                                                    <input class="form-control input-box__input" type="text"
                                                        name="zip_code" id="zip_code" placeholder=" "
                                                        autocomplete="nope">
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
                                                        id="u_comment" name="u_comment" rows="3"
                                                        placeholder=" "></textarea>
                                                    <label for="u_comment" class="input-box__label">
                                                        Commentaires, notes ...
                                                    </label>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="mt-2">
                                            <label class="checkbox d-inline-block me-3" for="checkout-remember-me">
                                                <input class="checkbox__input" id="checkout-remember-me" type="checkbox"
                                                    name="checkout-remember-me">
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
                                    </form>
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
                                    <form class="code-achat">
                                        <div class="input-box">
                                            <input type="text" class="form-control input-box__input"
                                                id="code-promo-achat" placeholder=" ">
                                            <label for="code-promo-achat" class="input-box__label">
                                                Code Promo Achats
                                            </label>
                                        </div>
                                        <button class="code-achat__btn" type="button">Valider</button>
                                    </form>
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
                                        <div class="radio-check">
                                            <div class="radio-check__wrapper">
                                                <label for="radio-four-days" class="radio">
                                                    <input type="radio" name="checkout[shipping-rate][id]"
                                                        class="radio__input" id="radio-four-days">
                                                    <span class="radio__radio"></span>
                                                    <div class="radio__text">
                                                        FedEx Ground
                                                        <br>
                                                        <span class="fs-sm">Estimated delivery: four days</span>
                                                    </div>
                                                </label>
                                            </div>
                                            $8.73
                                        </div>
                                        <div class="radio-check">
                                            <div class="radio-check__wrapper">
                                                <label for="radio-2-days" class="radio">
                                                    <input type="radio" name="checkout[shipping-rate][id]"
                                                        class="radio__input" id="radio-2-days">
                                                    <span class="radio__radio"></span>
                                                    <div class="radio__text">
                                                        USPS Priority Mail 2-Day
                                                        <br>
                                                        <span class="fs-sm">1-Day or 2-Day expedited service by 3
                                                            p.m</span>
                                                    </div>
                                                </label>
                                            </div>
                                            $11.19
                                        </div>

                                        <div class="radio-check">
                                            <div class="radio-check__wrapper">
                                                <label for="radio-3-days" class="radio">
                                                    <input type="radio" name="checkout[shipping-rate][id]"
                                                        class="radio__input" id="radio-3-days">
                                                    <span class="radio__radio"></span>
                                                    <div class="radio__text">
                                                        FedEx Express Saver
                                                        <br>
                                                        <span class="fs-sm">3 business days</span>
                                                    </div>
                                                </label>
                                            </div>
                                            $16.22
                                        </div>
                                        <div class="radio-check">
                                            <div class="radio-check__wrapper">
                                                <label for="radio-2b-days" class="radio">
                                                    <input type="radio" name="checkout[shipping-rate][id]"
                                                        class="radio__input" id="radio-2b-days">
                                                    <span class="radio__radio"></span>
                                                    <div class="radio__text">
                                                        FedEx 2 Day
                                                        <br>
                                                        <span class="fs-sm">2 business days</span>
                                                    </div>
                                                </label>
                                            </div>
                                            $20.85
                                        </div>
                                        <div class="radio-check">
                                            <div class="radio-check__wrapper">
                                                <label for="radio-1b-days" class="radio">
                                                    <input type="radio" name="checkout[shipping-rate][id]"
                                                        class="radio__input" id="radio-1b-days">
                                                    <span class="radio__radio"></span>
                                                    <div class="radio__text">
                                                        FedEx Standard Overnight
                                                        <br>
                                                        <span class="fs-sm">1 business days</span>
                                                    </div>
                                                </label>
                                            </div>
                                            $39.68
                                        </div>
                                        <div class="radio-check">
                                            <div class="radio-check__wrapper">
                                                <label for="radio-imd-days" class="radio">
                                                    <input type="radio" name="checkout[shipping-rate][id]"
                                                        class="radio__input" id="radio-imd-days">
                                                    <span class="radio__radio"></span>
                                                    <div class="radio__text">
                                                        Immadiat
                                                        <br>
                                                        <span class="fs-sm">0 business days</span>
                                                    </div>
                                                </label>
                                            </div>
                                            $132.41
                                        </div>
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
                                    <form class="code-achat">
                                        <div class="input-box">
                                            <input type="text" class="form-control input-box__input"
                                                id="code-promo-achat" placeholder=" ">
                                            <label for="code-promo-achat" class="input-box__label">
                                                Code Promo Achats
                                            </label>
                                        </div>
                                        <button class="code-achat__btn" type="button">Valider</button>
                                    </form>
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
                                        <div class="payment-gateway">
                                            <div class="radio-check payment-gateway-header">
                                                <div class="radio-check__wrapper">
                                                    <label for="credit-card" class="radio">
                                                        <input type="radio" name="checkout[payment-rate][id]"
                                                            class="radio__input" id="credit-card">
                                                        <span class="radio__radio"></span>
                                                        <div class="radio__text">
                                                            <span class="fw-700">Credit Card</span>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="brand-icons">
                                                    <span class="payment-icon payment-icon-visa">
                                                    </span>
                                                    <span class="payment-icon payment-icon-master">
                                                    </span>
                                                    <span class="payment-icon payment-icon-american-express">
                                                    </span>
                                                    <span class="payment-icon payment-icon-discover">
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- end payment-gateway-header -->
                                            <div
                                                class="payment-gateway-content  border-bottom payment-gateway-content-credit-card p-3">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input" type="text"
                                                                    id="payment-card-number" placeholder=" "
                                                                    autocomplete="off">
                                                                <div class="invalig-feedback"></div>
                                                                <label for="payment-card-number"
                                                                    class="input-box__label">
                                                                    Card number<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input" type="text"
                                                                    id="payment-name-on-card" placeholder=" "
                                                                    autocomplete="off">
                                                                <div class="invalig-feedback"></div>
                                                                <label for="payment-name-on-card"
                                                                    class="input-box__label">
                                                                    Name on card<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input" type="text"
                                                                    id="payment-expiration-date" placeholder=" "
                                                                    autocomplete="off">
                                                                <label for="payment-expiration-date"
                                                                    class="input-box__label">
                                                                    Expiration date (MM
                                                                    /
                                                                    YY)<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input" type="text"
                                                                    id="payment-security-code" placeholder=" "
                                                                    autocomplete="off">
                                                                <label for="payment-security-code"
                                                                    class="input-box__label">
                                                                    Security code<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- end payment-gateway-content -->
                                        </div>
                                        <!-- end payment-gateway -->
                                        <div class="payment-gateway">
                                            <div class="radio-check payment-gateway-header">
                                                <div class="radio-check__wrapper">
                                                    <label for="paypal" class="radio">
                                                        <input type="radio" name="checkout[payment-rate][id]"
                                                            class="radio__input" id="paypal">
                                                        <span class="radio__radio"></span>
                                                        <div class="radio__text">
                                                            <span class="fw-700">Paypal</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- end payment-gateway-header -->
                                            <div
                                                class="payment-gateway-content p-5 border-bottom flex-column justify-content-center align-items-center">
                                                <span class="payment-gateway-outsite"></span>
                                                <p class="mt-3">After clicking “Complete order”, you will be redirected
                                                    to
                                                    PayPal to complete
                                                    your purchase securely.</p>
                                            </div>
                                            <!-- end payment-gateway-content -->
                                        </div>
                                        <!-- end payment-gateway -->
                                        <div class="payment-gateway">
                                            <div class="radio-check payment-gateway-header">
                                                <div class="radio-check__wrapper">
                                                    <label for="Amazon-pay" class="radio">
                                                        <input type="radio" name="checkout[payment-rate][id]"
                                                            class="radio__input" id="Amazon-pay">
                                                        <span class="radio__radio"></span>
                                                        <div class="radio__text">
                                                            <span class="fw-700">Amazon pay</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- end payment-gateway-header -->
                                            <div
                                                class="payment-gateway-content p-5 border-bottom flex-column justify-content-center align-items-center">
                                                <span class="payment-gateway-outsite"></span>
                                                <p class="mt-3">You will be asked to login with Amazon.</p>
                                            </div>
                                            <!-- end payment-gateway-content -->
                                        </div>
                                        <!-- end payment-gateway -->
                                        <div class="payment-gateway">
                                            <div class="radio-check payment-gateway-header">
                                                <div class="radio-check__wrapper">
                                                    <label for="Klarna" class="radio">
                                                        <input type="radio" name="checkout[payment-rate][id]"
                                                            class="radio__input" id="Klarna">
                                                        <span class="radio__radio"></span>
                                                        <div class="radio__text">
                                                            <span class="fw-700">Pay over time with Klarna</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- end payment-gateway-header -->
                                            <div
                                                class="payment-gateway-content p-5 flex-column justify-content-center align-items-center">
                                                <span class="payment-gateway-outsite"></span>
                                                <p class="mt-3">After clicking "Complete order", you will be redirected
                                                    to
                                                    Pay over time with
                                                    Klarna to complete your purchase securely.</p>
                                            </div>
                                            <!-- end payment-gateway-content -->
                                        </div>
                                        <!-- end payment-gateway -->
                                    </div>
                                    <!-- end order-payment -->
                                    <div class="card-sub-title">
                                        <h4 class="title">
                                            Billing address
                                        </h4>
                                    </div>
                                    <p class="infos-transaction">Select the address that matches your card or payment
                                        method.</p>
                                    <div id="order-billing-address" class="border mb-3 rounded radio-check-group">
                                        <div class="billing-address ">
                                            <div class="radio-check billing-address-header">
                                                <div class="radio-check__wrapper">
                                                    <label for="checkout-billing-address-id-1" class="radio">
                                                        <input type="radio" name="checkout[billing-address][id]"
                                                            class="radio__input" id="checkout-billing-address-id-1">
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
                                                        <input type="radio" name="checkout[billing-address][id]"
                                                            class="radio__input" id="checkout-billing-address-id-2">
                                                        <span class="radio__radio"></span>
                                                        <div class="radio__text">
                                                            <span class="fw-700"> Use a different billing address</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- end billing-address-header -->
                                            <div class="billing-address-content p-3">
                                                <form action="">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input" type="text"
                                                                    id="other-billing-first-name" placeholder=" "
                                                                    autocomplete="off">
                                                                <label for="other-billing-first-name"
                                                                    class="input-box__label">
                                                                    First Name<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input" type="text"
                                                                    id="other-billing-last-name" placeholder=" "
                                                                    autocomplete="off">
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
                                                                    id="other-billing-phone" placeholder=" "
                                                                    autocomplete="off">
                                                                <label for="other-billing-last-name"
                                                                    class="input-box__label">
                                                                    Phone number<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input"
                                                                    type="email" id="other-billing-email-address"
                                                                    placeholder=" " autocomplete="off">
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
                                                                <select
                                                                    class="form-select select_country input-box__input"
                                                                    data-placeholder=" " id="other-billing-countryxxx"
                                                                    placeholder=" ">
                                                                </select>
                                                                <label for="other-billing-countryxxx"
                                                                    class="input-box__label">
                                                                    Country<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input" type="text"
                                                                    placeholder=" " id="billing-address-1"
                                                                    autocomplete="off">
                                                                <label for="billing-address-1" class="input-box__label">
                                                                    Address ligne 1<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input" type="text"
                                                                    placeholder=" " id="billing-address-2"
                                                                    autocomplete="off">
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
                                                                <input class="form-control input-box__input"
                                                                    type="email" id="billing-town-city" placeholder=" "
                                                                    autocomplete="off">
                                                                <label for="billing-town-city" class="input-box__label">
                                                                    Town / City<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input"
                                                                    type="email" id="billing-state" placeholder=" "
                                                                    autocomplete="off">
                                                                <label for="billing-state" class="input-box__label">
                                                                    State / Province /
                                                                    Region<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="mb-3 input-box">
                                                                <input class="form-control input-box__input"
                                                                    type="email" id="billing-zip-postal" placeholder=" "
                                                                    autocomplete="off">
                                                                <label for="billing-zip-postal"
                                                                    class="input-box__label">
                                                                    Zip Code<span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end row -->
                                                </form>
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
                                                <a href="javascript:void(0);" class="complet-order">
                                                    Complete order&nbsp;<i class="fal fa-angle-double-right"></i>
                                                </a>
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