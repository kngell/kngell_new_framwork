<?php $this->start('head'); ?>
<!-------Costum-------->
<script src="https://js.stripe.com/v3/"></script>

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
                        <a href="#billing-information" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link rounded-0 w-100">
                            <div class="circle"><i class="fas fa-envelope-open-text"></i></div>
                            <span class="d-none d-lg-block">Facturation</span>
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
                            <?php require 'partials/card_summary.php'?>
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
                                            <?php require 'partials/_checkout_contact_frm.php'?>
                                            <div class="row my-4 button-group">
                                                <div class="col-6">
                                                    <a href="<?=PROOT . 'cart'?>" class="return-to-cart">
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
                                            </div>
                                            <!-- end row -->
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
                                <?php require 'partials/card_summary.php'?>
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
                                                    <td class="value contact-email">donnie1973@hotmail.com</td>
                                                    <td class="link"><a href="#" class="text-highlight"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-email">Change</a></td>
                                                </tr>
                                                <tr class="border-bottom address">
                                                    <td class="title">Ship to:</td>
                                                    <td class="value ship-to-address">3363 Cook Hill Road, Wallingford,
                                                        Connecticut(CT),
                                                        06492,
                                                        Wallingford CT
                                                        06492, United
                                                        States</td>
                                                    <td class="link"><a href="#" class="text-highlight change-ship__btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-change-address">Change</a></td>
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
                                            <?php $form->setModel($shipping_class)->setClass(['FieldwrapperClass' => 'radio-check__wrapper', 'fieldclass' => 'radio__input', 'labelClass' => 'radio']);?>
                                            <?php if ($shipping_class->status == 'on'):?>
                                            <?php $default = $shipping_class->default_shipping_class == 1 ? 'checked' : '' ?>
                                            <div class="radio-check">
                                                <?= $form->radio('sh_name')->id('sh_name')->radioType()->spanClass('radio__radio')->textClass('radio__text')->labelDescr($shipping_class->sh_descr)->price($shipping_class->price)->attr(['form' => 'user-ckeckout-frm'])?>
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
                                                        Continue to Billing &nbsp;<i
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
                    <div class="tab-pane" id="billing-information">
                        <div class="row flex-lg-row-reverse">
                            <div class="col-lg-4 order-summary">
                                <?php require 'partials/card_summary.php'?>
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
                                                    <td class="value contact-email">donnie1973@hotmail.com</td>
                                                    <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-email">Change</a></td>
                                                </tr>
                                                <tr class="border-bottom address">
                                                    <td class="title">Ship to:</td>
                                                    <td class="value ship-to-address">3363 Cook Hill Road, Wallingford,
                                                        Connecticut(CT), 06492,
                                                        Wallingford CT
                                                        06492, United
                                                        States</td>
                                                    <td><a href="#" class="text-highlight change-ship__btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-change-address">Change</a></td>
                                                </tr>
                                                <tr class="border-bottom method">
                                                    <td class="title">Shipping Method</td>
                                                    <td class="shipping_method"> <span class="method_title">FedEx Ground
                                                        </span> &nbsp;<span class="price">$8.73</span> </td>
                                                    <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-shipping">Change</a></td>
                                                </tr>
                                                <tr class="border-bottom bill-address-ckeck" style="display: none;">
                                                    <td class="title">bill to:</td>
                                                    <td class="value bill-to-address">3363 Cook Hill Road, Wallingford,
                                                        Connecticut(CT), 06492,
                                                        Wallingford CT
                                                        06492, United
                                                        States</td>
                                                    <td><a href="#" class="text-highlight change-bill__btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-change-address">Change</a></td>
                                                </tr>
                                            </table>
                                        </div>
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
                                                <?php $form->setDefault()->setModel()->setClass(['FieldwrapperClass' => 'radio-check__wrapper', 'fieldclass' => 'radio__input', 'labelClass' => 'radio'])->getRadio()?>
                                                <div class="radio-check billing-address-header">
                                                    <?= $form->getRadio()->setAttr('prefred_billing_addr')->id('checkout-billing-address-id-1')->radioType()->value(1)->spanClass('radio__radio')->textClass('radio__text')->Label('Same as shipping address')->attr(['form' => 'user-ckeckout-frm'])?>
                                                </div>
                                                <!-- end billing-address-header -->
                                            </div>
                                            <!-- end billing-address -->
                                            <div class="billing-address">
                                                <div class="radio-check billing-address-header">
                                                    <?= $form->getRadio()->setAttr('prefred_billing_addr')->id('checkout-billing-address-id-2')->radioType()->value(2)->spanClass('radio__radio')->textClass('radio__text')->Label('Use a different billing address')->attr(['form' => 'user-ckeckout-frm'])?>
                                                </div>
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
                    </div>
                    <div class="tab-pane" id="payment-information">
                        <div class="row flex-lg-row-reverse">
                            <div class="col-lg-4 order-summary">
                                <?php require 'partials/card_summary.php'?>
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
                                                    <td class="value contact-email">donnie1973@hotmail.com</td>
                                                    <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-email">Change</a></td>
                                                </tr>
                                                <tr class="border-bottom address">
                                                    <td class="title">Ship to:</td>
                                                    <td class="value ship-to-address">3363 Cook Hill Road, Wallingford,
                                                        Connecticut(CT), 06492,
                                                        Wallingford CT
                                                        06492, United
                                                        States</td>
                                                    <td><a href="#" class="text-highlight change-ship__btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-change-address">Change</a></td>
                                                </tr>
                                                <tr class="border-bottom method">
                                                    <td class="title">Shipping Method:</td>
                                                    <td class="shipping_method"> <span class="method_title">FedEx Ground
                                                        </span> &nbsp;<span class="price">$8.73</span> </td>
                                                    <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-shipping">Change</a></td>
                                                </tr>
                                                <tr class="border-bottom facturation">
                                                    <td class="title">Bill to:</td>
                                                    <td class="value bill-to-address">3363 Cook Hill Road, Wallingford,
                                                        Connecticut(CT), 06492,
                                                        Wallingford CT
                                                        06492, United
                                                        States</td>
                                                    <td><a href="#" class="text-highlight change-bill__btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-box-change-address">Change</a></td>
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
                                            <?php $form->setDefault()->setModel($pmt_getaway)->setClass(['FieldwrapperClass' => 'radio-check__wrapper', 'fieldclass' => 'radio__input', 'labelClass' => 'radio']);?>
                                            <div class="payment-gateway">
                                                <div class="radio-check payment-gateway-header">
                                                    <?= $form->radio('pm_name')->id('pm_name')->radioType()->value($pmt_getaway->pmID)->spanClass('radio__radio')->textClass('radio__text')->label($pmt_getaway->pm_name)->attr(['form' => 'user-ckeckout-frm'])?>

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
                                                    <?=$this->credit_cardForm?>
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
                                                <?php endif;?>
                                            </div>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                            <?php endif;?>

                                        </div>
                                        <!-- end order-payment -->

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
                                                        <span> Complete order</span>
                                                        <i class="fal fa-angle-double-right"></i>
                                                        <span id="button-text">Pay now</span>
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
        <!----------Change Email Modal-------->
        <div class="modal fade" role="dialog" id="modal-box-email">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Change Email Address</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="change-email-frm" class="px-3 needs-validation" novalidate
                            enctype="multipart/form-data">
                            <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'change-email-frm')); ?>
                            <div id="alertErr"></div>
                            <div class="mb-3">
                                <input type="text" name="email" id="chg-email" class="form-control "
                                    placeholder="New Email Address" aria-describedby="chg-email-feedback">
                                <div class="invalid-feedback" id="brands-feedback"></div>
                            </div>
                            <div class="mb-3 justify-content-between">
                                <input type="submit" name="submitBtn" id="submitBtnEmail" value="Submit" class="button">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!----------Change Address Modal-------->
        <div class="modal fade" role="dialog" id="modal-box-change-address">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Change Address</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="change-address-frm" class="px-3 needs-validation" novalidate
                            enctype="multipart/form-data">
                            <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'change-address-frm')); ?>
                            <div id="alertErr"></div>
                            <?=$this->address_book?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!----------Add New Address Modal-------->
        <div class="modal fade" role="dialog" id="modal-box-add-address">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Add Address</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="add-address-frm" class="px-3 needs-validation" novalidate
                            enctype="multipart/form-data">
                            <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'add-address-frm')); ?>
                            <div id="alertErr"></div>
                            <div class="mb-3">
                                <input type="text" name="address1" id="chg-address1" class="form-control "
                                    placeholder="New address line 1" aria-describedby="chg-address1-feedback">
                                <div class="invalid-feedback" id="chg-address1-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="address2" id="chg-address2" class="form-control "
                                    placeholder="New Address line 2" aria-describedby="chg-address2-feedback">
                                <div class="invalid-feedback" id="chg-address2-feedback"></div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <input type="text" name="ville" id="chg-ville" class="form-control "
                                        placeholder="New City" aria-describedby="chg-ville-feedback">
                                    <div class="invalid-feedback" id="chg-ville-feedback"></div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="text" name="zip_code" id="chg-zip_code" class="form-control "
                                        placeholder="New Zip_code" aria-describedby="chg-zip_code-feedback">
                                    <div class="invalid-feedback" id="chg-zip_code-feedback"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="region" id="chg-region" class="form-control "
                                    placeholder="New Region" aria-describedby="chg-region-feedback">
                                <div class="invalid-feedback" id="chg-region-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <select type="text" name="pays" id="chg-pays" class="form-control" style="width: 100%;">
                                    <option value=""></option>
                                </select>
                                <div class="invalid-feedback" id="brands-feedback"></div>
                            </div>
                            <div class="mb-3 justify-content-between">
                                <input type="submit" name="submitBtn" id="submitBtnAddress" value="Submit"
                                    class="button">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!----------Add New Shipping Modal-------->
        <div class="modal fade" role="dialog" id="modal-box-shipping">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Mode de livraison</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="shipping-select-frm" class="px-3 needs-validation" novalidate
                            enctype="multipart/form-data">
                            <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'shipping-select-frm')); ?>
                            <div id="alertErr"></div>
                            <div class="mb-3">
                                <select type="text" name="shipping_class_change" id="shipping_class_change"
                                    class="form-control" style="width: 100%;">
                                    <option value=""></option>
                                </select>
                                <div class="invalid-feedback" id="brands-feedback"></div>
                            </div>
                            <div class="mb-3 justify-content-between">
                                <input type="submit" name="submitBtn" id="submitBtnShipping" value="Submit"
                                    class="button">
                            </div>
                        </form>
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