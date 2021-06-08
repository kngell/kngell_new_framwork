<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/home/boutique/boutique', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <section class="py-5 products-features container" id="products-features">
        <div class="pb-5 features-title">
            <h2 class="title fw-bold">Our Features</h2>
            <hr class="horizontal-line">
            <p class="descr">Here you can check out our new products with fair price on Rymo</p>
        </div>
        <div class="row mx-auto">
            <div class="products-item text-center col-lg-3 col-md-4 col-12">
                <img src="<?=ImageManager::asset_img('shop/23.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/20.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/15.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/10.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/9.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/8.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/7.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/25.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/23.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/17.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/26.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/20.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/18.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/16.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/14.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/13.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/12.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/11.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/19.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/20.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/25.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/12.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/8.jpg')?>"
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
                <img src="<?=ImageManager::asset_img('shop/25.jpg')?>"
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
            <nav aria-label="...">
                <ul class="pagination mt-5">
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
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
    src="<?= $this->asset('js/custom/home/boutique/boutique', 'js') ?? ''?>">
</script>
<?php $this->end();
