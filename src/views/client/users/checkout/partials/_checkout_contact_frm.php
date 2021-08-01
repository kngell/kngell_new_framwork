<?php $form = $this->form->setModel($this->user_data)->setFieldClass(['FieldwrapperClass' => 'input-box', 'fieldclass' => 'input-box__input', 'labelClass' => 'input-box__label']);?>
<div class="col-md-6">
    <?= $form->input('lastName')->Label('Nom')->id('chk-lastName')->attr(['form' => 'user-ckeckout-frm'])->req()?>
</div>
<div class="col-md-6">
    <?= $form->input('firstName')->Label('Prénom')->id('chk-firstName')->attr(['form' => 'user-ckeckout-frm'])->req()?>
</div>
</div> <!-- end row -->
<div class="row">
    <div class="col-md-6">
        <?= $form->input('phone')->Label('Téléphone')->id('chk-phone')->attr(['form' => 'user-ckeckout-frm'])?>
    </div>
    <div class="col-md-6">
        <?= $form->input('email')->Label('Email')->id('chk-email')->attr(['form' => 'user-ckeckout-frm'])->req()->emailType()?>
    </div>
</div> <!-- end row -->
<div class="form-title">
    <h4 class="mt-2 mb-3 card-sub-title">Adresse de Livraison</h4>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->select('pays')->Label('Pays')->id('pays')->attr(['form' => 'user-ckeckout-frm'])->class('select_country')->req()?>
    </div>
</div> <!-- end row -->
<div class="row">
    <div class="col-12">
        <?= $form->input('address1')->Label('Adresse ligne 1')->id('address1')->attr(['form' => 'user-ckeckout-frm'])->req()?>
        <?= $form->input('address2')->Label('Adresse ligne 2')->id('address2')->attr(['form' => 'user-ckeckout-frm'])?>
    </div>
</div> <!-- end row -->
<div class="row">
    <div class="col-md-4">
        <?= $form->input('ville')->Label('Ville')->id('ville')->attr(['form' => 'user-ckeckout-frm'])->req()?>
    </div>
    <div class="col-md-4">
        <?= $form->input('region')->Label('Région/Etat')->id('region')->attr(['form' => 'user-ckeckout-frm'])?>
    </div>
    <div class="col-md-4">
        <?= $form->input('zip_code')->Label('Code Postal')->id('zip_code')->attr(['form' => 'user-ckeckout-frm'])->req()?>
    </div>
</div> <!-- end row -->
<div class="row">
</div> <!-- end row -->
<div class="row">
    <div class="col-12 mb-4">
        <?= $form->textarea('u_comment')->Label('Commentaires, notes ...')->id('u_comment')->attr(['form' => 'user-ckeckout-frm'])->row(3)->class('input-box__textarea')?>
    </div>
</div> <!-- end row -->
<?= $form->checkbox('checkout-remember-me')->Label('Sauvegarder ces informations pour la prochaine fois')->id('checkout-remember-me')->attr(['form' => 'user-ckeckout-frm'])->class('checkbox__input')->checkboxType()->spanClass('checkbox__box')->LabelClass('checkbox')->wrapperClass('mt-2');