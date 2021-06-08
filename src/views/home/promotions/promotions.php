<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/home/promotions/promotions', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <section class="head-promotions" id=head-promotions>
        <div class="container title">
            <h5 class="first-title">NEW ARRIVALS</h5>
            <h1 class="second-title">
                <sapn class="title-left">Best Price</sapn>&nbsp;<span class="title-right">this Year</span>
            </h1>
            <p>Shomatics offers your very comfortable time <br>on walking and exercises</p>
            <button>Shop Now</button>
        </div>
    </section>
    <section class="container brands" id="brands">
        <div class="row m-0 py-5">
            <img src="../../../assets/img/brand/1.png" alt="" class="img-fluid col-lg-2 col-md-4 col-6">
            <img src="../../../assets/img/brand/2.png" alt="" class="img-fluid col-lg-2 col-md-4 col-6">
            <img src="../../../assets/img/brand/3.png" alt="" class="img-fluid col-lg-2 col-md-4 col-sm-6">
            <img src="../../../assets/img/brand/4.png" alt="" class="img-fluid col-lg-2 col-md-4 col-sm-6">
            <img src="../../../assets/img/brand/5.png" alt="" class="img-fluid col-lg-2 col-md-4 col-sm-6">
            <img src="../../../assets/img/brand/6.png" alt="" class="img-fluid col-lg-2 col-md-4 col-sm-6">
        </div>
    </section>
    <section class="new-arrivals w-100" id="new-arrivals">
        <div class="row p-0 m-0">
            <div class="arrival-item col-lg-4 col-md-12 col-12 p-0">
                <img src="<?=ImageManager::asset_img('arrivals/1.jpg')?>"
                    alt="" class="img-fluid">
                <div class="arrival-item__details">
                    <h2>Extreme Rare Sneakers</h2>
                    <button>Shop Now</button>
                </div>
            </div>
            <div class="arrival-item col-lg-4 col-md-12 col-12 p-0">
                <img src="<?=ImageManager::asset_img('arrivals/5.jpg')?>"
                    alt="" class="img-fluid">
                <div class="arrival-item__details">
                    <h2>Awesome Black Outfit</h2>
                    <button>Shop Now</button>
                </div>
            </div>
            <div class="arrival-item col-lg-4 col-md-12 col-12 p-0">
                <img src="<?=ImageManager::asset_img('arrivals/3.jpg')?>"
                    alt="" class="img-fluid">
                <div class="arrival-item__details">
                    <h2>SportWare Up to 50% Off</h2>
                    <button>Shop Now</button>
                </div>
            </div>
        </div>
    </section>
    <section class="my-5 pb-5 products-features container-fluid" id="products-features">
        <div class="text-center mt-5 py-5 features-title">
            <h3 class="title">Our Features</h3>
            <hr class="horizontal-line mx-auto">
            <p class="descr">Here you can check out our new products with fair price on Rymo</p>
        </div>
        <div class="row mx-auto">
            <div class="products-item text-center col-lg-3 col-md-4 col-12">
                <img src="<?=ImageManager::asset_img('featured/1.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('featured/2.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('featured/3.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('featured/4.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
    <section class="collection my-5 py-5" id="collection">
        <div class="container">
            <h4>MID'S SEASON SALES</h4>
            <h1>Autumn collection<br> up to 20% off</h1>
            <button>Shop Now</button>
        </div>
    </section>
    <section class="my-5 products-features container-fluid" id="brand2">
        <div class="container text-center mt-5 py-5 features-title">
            <h3 class="title">Dresses and Jumsuits</h3>
            <hr class="horizontal-line mx-auto">
            <p class="descr">Here you can check out our new products with fair price on Rymo</p>
        </div>
        <div class="row mx-auto">
            <div class="products-item text-center col-lg-3 col-md-4 col-12">
                <img src="<?=ImageManager::asset_img('clothes/1.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('clothes/2.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('clothes/3.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('clothes/1.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
    <section class="my-5 products-features container-fluid" id="brand3">
        <div class="container text-center mt-5 py-5 features-title">
            <h3 class="title">Best watches</h3>
            <hr class="horizontal-line mx-auto">
            <p class="descr">Here you can check out our new products with fair price on Rymo</p>
        </div>
        <div class="row mx-auto">
            <div class="products-item text-center col-lg-3 col-md-4 col-12">
                <img src="<?=ImageManager::asset_img('watches/1.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('watches/2.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('watches/3.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
                <img src="<?=ImageManager::asset_img('watches/1.jpg')?>"
                    alt="" class="img-fluid mb-3">
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
    <input type="hidden" id="ip_address" style="display:none"
        value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript"
    src="<?= $this->asset('js/custom/home/promotions/promotions', 'js') ?? ''?>">
</script>
<?php $this->end();
