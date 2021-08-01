<div class="container contact-container">
    <div class="row">
        <div class="col-md-7 address">

        </div>
        <div class="col-md-5 form-wrapper">
            <h1>Contact Us</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora odit quam vitae </p>
            <?=$this->form->custumAttr($frm)->begin()?>
            <?= $this->form->input('name')->labelUp('Name:')->wrapperClass('input-box')?>
            <?= $this->form->input('email')->labelUp('Email Address:')->wrapperClass('input-box')->emailType()->id('contact-email')?>
            <?= $this->form->input('subject')->labelUp('Subject:')->wrapperClass('input-box')?>
            <?= $this->form->textarea('message')->labelUp('Message:')->wrapperClass('input-box')?>
            <?= $this->form->submit(1)?>
            <?=$this->form->end()?>
        </div>
    </div>

</div>