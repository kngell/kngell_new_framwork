<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/home/product/details', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <h1>Product Details</h1>
    <div class="row">
        <!-- Column 1 -->
        <div class="col-lg-6">
            <div class="product_img_wrapper">
                <img src="<?=ImageManager::asset_img('featured/1.jpg')?>"
                    alt="">
            </div>
        </div>
        <!-- Column 2 -->
        <div class="col-lg-6">
            <p><span>Price:</span>$89.99</p>
            <p><span>Shipping:</span>$89.99</p>
            <p><span>Vendor:</span>$89.99</p>
            <p><span>Brand:</span>One Brand</p>
            <div class="text-right"><button class="btn btn-danger"><i class="far fa-cart-plus"></i> Add to
                    Cart</button></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <h3>Product Description</h3>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fuga molestiae illo iusto soluta. Officia odio
                autem odit voluptates dolor nihil ut sequi harum velit officiis! Eum nemo adipisci ut facilis.
                Ducimus veritatis libero alias laboriosam ipsum corporis neque, a adipisci, aliquid perspiciatis ipsam
                blanditiis, nulla fuga pariatur asperiores eum error? Aspernatur enim dignissimos non provident natus.
                .</p>
        </div>
        <div class="col-lg-6">
            <h3>Custommer Revue</h3>
        </div>
    </div>

    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none"
        value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript"
    src="<?= $this->asset('js/custom/home/product/details', 'js') ?? ''?>">
</script>
<?php $this->end();
