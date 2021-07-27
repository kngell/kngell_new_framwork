<?php $this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/custom/client/home/product/details', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <section class="container sproduct my-5 pt-5" id="sproduct">
        <div class="row mt-5 images">
            <div class="col-lg-5 col-md-12 col-12">
                <img src="<?=ImageManager::asset_img('shop/1.jpg')?>" class="img-fluid w-100 pb-1" id="main-img" alt="">
                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="<?=ImageManager::asset_img('shop/1.jpg')?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="<?=ImageManager::asset_img('shop/25.jpg')?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="<?=ImageManager::asset_img('shop/24.jpg')?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="<?=ImageManager::asset_img('shop/26.jpg')?>" width="100%" class="small-img" alt="">
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-12 col-12 description">
                <h6>Home/T-shirt</h6>
                <h3 class="py-4"> Men Fashion T-shirt</h3>
                <h2>EUR 139.99</h2>
                <select name="" id="" class="my-3 size">
                    <option value="">Select size</option>
                    <option value="">XL</option>
                    <option value="">XXL</option>
                    <option value="">Small</option>
                    <option value="">Large</option>
                </select>
                <input type="number" value="1" class="quantity">
                <button class="buy-btn">Add To cart</button>
                <h4 class="mt-5 mb-5">Product Details</h4>
                <span>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Possimus, numquam ratione eveniet
                    consequuntur sed, sunt, amet sequi explicabo praesentium quis animi odio ipsam culpa neque qui esse
                    laborum accusamus dolore.
                    Soluta nesciunt ab ratione, rem eos in exercitationem sint illum non accusamus natus, aspernatur
                    amet possimus mollitia iure repellat doloremque voluptate a iste eveniet itaque officiis. Fugiat
                    illo quia quibusdam.</span>

            </div>
        </div>
    </section>
    <section class="my-5 pb-5 products-features container-fluid" id="products-features">
        <div class="text-center mt-5 py-5 features-title">
            <h3 class="title">Related Products</h3>
            <hr class="horizontal-line mx-auto">
        </div>
        <div class="row mx-auto">
            <div class="products-item text-center col-lg-3 col-md-4 col-12">
                <img src="<?=ImageManager::asset_img('featured/1.jpg')?>" alt="" class="img-fluid mb-3">
                <div class="star">
                    <i class="fad fa-star"></i>
                    <i class="fad fa-star"></i>
                    <i class="fad fa-star"></i>
                    <i class="fad fa-star"></i>
                    <i class="fad fa-star"></i>
                </div>
                <h5 class="product-name">Sports Shoes</h5>
                <h4 class="product-price">$59.00</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <div class="products-item text-center col-lg-3 col-md-4 col-12">
                <img src="<?=ImageManager::asset_img('featured/2.jpg')?>" alt="" class="img-fluid mb-3">
                <div class="star">
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                </div>
                <h5 class="product-name">Sports Shoes</h5>
                <h4 class="product-price">$59.00</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <div class="products-item text-center col-lg-3 col-md-4 col-12">
                <img src="<?=ImageManager::asset_img('featured/3.jpg')?>" alt="" class="img-fluid mb-3">
                <div class="star">
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                </div>
                <h5 class="product-name">Sports Shoes</h5>
                <h4 class="product-price">$59.00</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <div class="products-item text-center col-lg-3 col-md-4 col-12">
                <img src="<?=ImageManager::asset_img('featured/4.jpg')?>" alt="" class="img-fluid mb-3">
                <div class="star">
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                    <i class="fal fa-star"></i>
                </div>
                <h5 class="product-name">Sports Shoes</h5>
                <h4 class="product-price">$59.00</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
        </div>
    </section>
    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/custom/client/home/product/details', 'js') ?? ''?>">
</script>
<?php $this->end();