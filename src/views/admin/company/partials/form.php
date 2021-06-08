<form action="" id="company-frm" class="needs-validation pb-4" novalidate method="post">
    <?=FH::csrfInput('csrftoken', (new Token())->generate_token(8));?>
    <input type="hidden" name="compID" id="compID">
    <input type="hidden" name="created_at" id="created_at">
    <input type="hidden" name="updated_at" id="updated_at">
    <input type="hidden" name="deleted" id="deleted">
    <input type="hidden" name="operation" id="operation" value="update">
    <div id="alertErr"></div>
    <div class="row">
        <div class="col-md-6 h-100">
            <h5 class="font-weight-lighter text-center text-muted">Infos juridiques</h5>
            <?=FH::inputBlock('text', 'sigle', 'Sigle :', '', ['class' => 'form-control'], ['class' => 'mb-3']);?>
            <?= FH::inputBlock('text', 'denomination', 'Dénomination :', '', ['class' => 'form-control'], ['class' => 'mb-3']);?>
            <?= FH::inputBlock('text', 'siret', 'N° de Siret :', '', ['class' => 'form-control'], ['class' => 'mb-3']);?>
            <?= FH::inputBlock('text', 'tva', 'N° TVA :', '', ['class' => 'form-control'], ['class' => 'mb-3']);?>
            <?= FH::inputBlock('text', 'rna', 'N° R.N.A :', '', ['class' => 'form-control'], ['class' => 'mb-3']);?>
            <?= FH::inputBlockArea('activite', 'Activite : ', '', ['class' => 'form-control h-100'], ['class' => 'mb-3 activity-box']);?>
        </div>
        <div class="col-md-6 h-100">
            <h5 class="text-centertext-muted text-center font-weight-lighter">Coordonnées</h5>
            <div class="row">
                <?= FH::inputBlock('text', 'phone', 'N° Téléphone fixe :', '', ['class' => 'form-control'], ['class' => 'mb-3 col-md-6']);?>
                <?= FH::inputBlock('text', 'mobile', 'N° Téléphone portable', '', ['class' => 'form-control'], ['class' => 'mb-3 col-md-6']);?>
                <?= FH::inputBlock('email', 'couriel', 'Courriel : ', '', ['class' => 'form-control'], ['class' => 'mb-3']);?>
                <?= FH::inputBlock('text', 'site_web', 'Site web :', '', ['class' => 'form-control'], ['class' => 'mb-3']);?>
                <?= FH::inputBlockArea('address', 'Adresse : ', '', ['class' => 'form-control h-100'], ['class' => 'mb-3 h-100']);?>
                <div class="row">
                    <?= FH::inputBlock('text', 'ville', 'Ville : ', '', ['class' => 'form-control'], ['class' => 'mb-3 col-md-7']);?>
                    <?= FH::inputBlock('text', 'zip_code', 'Code postal : ', '', ['class' => 'form-control'], ['class' => 'mb-3 col-md-5']);?>

                    <?= FH::inputBlock('text', 'pays', 'Pays :', 'France', ['class' => 'form-control', 'placeholder' => 'Pays'], ['class' => 'mb-3 col-md-12']);?>
                </div>
            </div>
        </div>
    </div>


    <div class="text-right bouton">
        <button type="button" class="btn btn-default bg-secondary float-left " id="annuler">Annuler</button>
        <?=FH::submitTag('Enregistrer', 'submitBtn', ['class' => 'btn btn-primary'])?>
    </div>
</form>