<div id="stripeErr"></div>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="mb-3 input-box">
            <input class="form-control input-box__input cc_firstName" type="text" name="cc_firstName" id="cc_firstName"
                placeholder=" " autocomplete="off" form="user-ckeckout-frm">
            <label for="cc_firstName" class="input-box__label">
                Nom<span class="text-danger">*</span>
            </label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="mb-3 input-box">
            <input class="form-control input-box__input cc_lastName" type="text" name="cc_lastName" id="cc_lastName"
                placeholder=" " autocomplete="off" form="user-ckeckout-frm">
            <div class="invalig-feedback"></div>
            <label for="cc_lastName" class="input-box__label">
                Prenom<span class="text-danger">*</span>
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="mb-3 input-box">
            <div id="card-element">
                <!--Stripe.js injects the Card Element-->
            </div>
            <div id="card-error" role="alert"></div>
            <input type="hidden" id="stripe_key" value="{{stripeKey}}">
        </div>
    </div>
</div>