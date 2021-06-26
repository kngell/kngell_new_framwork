<section id="cart" class="py-3">
    <div class="container w-75">
        <div class="title-wrapper">
            <h4 class="title fw-bold">Panier d'achats</h4>
            <hr class="horizontal-line">
        </div>
        <!-- Shopping cart items -->
        <div class="row">
            <div class="col-sm-9 cart_items" id="cart_items">
                <!-- Cart item -->
                <?php if ($this->user_cart && $this->user_cart[0]) :?>
                <?php $products = array_filter($this->user_cart[0], function ($item) {return $item->c_content == 'cart';})?>
                <?php if (count($products) > 0) :?>
                <?php foreach ($products as $product) :?>
                <div class="row cart-row">
                    <div class="col-sm-2 cart-row__img">
                        <img src="<?=$product->p_media != '' ? IMG . unserialize($product->p_media)[0] : ImageManager::asset_img('products/product-80x80.jpg')?>"
                            alt="cart1" class="img-fluid" style="height:120px;">
                    </div>
                    <div class="col-sm-8 cart-row__details">
                        <h5 class="title"><?=$product->htmlDecode($product->p_title)?>
                        </h5>
                        <small>By <?=$product->categorie?></small>
                        <!-- Rating section -->
                        <div class="rating">
                            <div class="rating__star text-warning font-size-12">
                                <span><i class="fas fa fa-star"></i></span>
                                <span><i class="fas fa fa-star"></i></span>
                                <span><i class="fas fa fa-star"></i></span>
                                <span><i class="fas fa fa-star"></i></span>
                                <span><i class="far fa-star"></i></span>
                            </div>
                            <a href="#" class="px-2 rating__text">20,534 ratings</a>
                        </div>
                        <!-- !Rating section -->
                        <!-- Produt quantity -->
                        <div class="cart-qty">
                            <div class="qty-group">
                                <form class="form_qty">
                                    <?=FH::csrfInput('csrftoken', $this->token->generate_token(8, 'form_qty' . $product->pdtID ?? 1)); ?>
                                    <input type="hidden" name="item_id" value="<?=$product->pdtID?>">
                                    <button class="qty-up border bg-light"><i class="fad fa-angle-up"></i></button>
                                    <input type="text" class="qty_input px-2 bg-light" name="qty"
                                        value="<?=$product->item_qty?>" placeholder="1" min="1">
                                    <button class="qty-down border bg-light"><i class="fad fa-angle-down"></i></button>
                                </form>
                            </div>
                            <form action="#" class="delete-cart-item-frm<?=$product->pdtID?>">
                                <input type="hidden" name="item_id" value="<?=$product->pdtID?>">
                                <?=FH::csrfInput('csrftoken', $this->token->generate_token(8, 'delete-cart-item-frm' . $product->pdtID ?? 1)); ?>
                                <button type="submit"
                                    class="btn font-baloo px-3 border-right deleteBtn">Supprimer</button>
                                <button type="button" class="button save-add">Sauvegarder</button>
                            </form>
                        </div>
                        <!-- !Produt quantity -->
                    </div>
                    <div class="col-sm-2 text-right cart-row__price">
                        <div class="price_wrapper">
                            <span
                                class="product_price"><?=$product->get_currency($product->p_regular_price * $product->item_qty)?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
                <?php else :?>
                <?php echo $this->user_cart[4]?>
                <?php endif;?>
                <?php else:?>
                <?php echo $this->user_cart[4]?>
                <?php endif;?>
                <!-- !Cart item -->
            </div>
            <!-- Sub-Total section -->
            <div class="col-sm-3 sub_total" id="sub_total">
                <div class="card sub-total mt-2 border">
                    <div class="card-header">
                        <p class="nb-item"><span
                                class="cart_nb_elt"><?=$this->user_cart && is_array($this->user_cart[0]) ? count(array_filter($this->user_cart[0], function ($item) {return $item->c_content == 'cart';})) : 0?></span>&nbsp;<span>produits</span>
                        </p>
                        <p class="title"><i class="fas fa-check"></i> &nbsp; Your ordre
                            is
                            eligible for FREE Delivery</p>

                    </div>
                    <div class="card-body">
                        <div class="total-ht">
                            <span class="title">Total HT:</span>
                            <span class="deal-price"
                                id="deal-price"><?=$this->user_cart ? $this->user_cart[2][0] : 0?></span>
                            </span>
                        </div>
                        <p class="transition">dont : </p>
                        <ul class="cart-resume">
                            <?=$this->user_cart && $this->user_cart[3] ? $this->user_cart[3]['cart'][0] : ''?>
                        </ul>
                        <div class="total-ttc">
                            <span class="title">Total TTC:</span>
                            <span class="total-price"
                                id="total-price"><?=$this->user_cart ? $this->user_cart[2][1] : 0?></span>
                            </span>
                        </div>
                    </div>
                    <div class="card-footer proceed">
                        <form class="buy-frm">
                            <?=FH::csrfInput('csrftoken', $this->token->generate_token(8, 'buy-frm')); ?>
                            <button class="button buy-btn" type="button">Proceed to
                                buy</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- !Sub-Total section -->
        </div>
        <!-- !Shopping cart items -->
    </div>

</section>