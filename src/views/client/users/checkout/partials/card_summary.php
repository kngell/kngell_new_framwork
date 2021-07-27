<div class="card">
    <div class="card-body">
        <h4 class="header-title mb-3">Resumé de la commande</h4>
        <div class="table-responsive order-resume">
            <table class="table table-borderless mb-0 align-middle">
                <tbody>
                    <?php foreach ($this->user_cart[0] as $product) :
                    if ($product->c_content == 'cart') :?>
                    <tr class="product-line">
                        <td class="p-cell p-img">
                            <div class="product-thumbnail-wrapper mt-2">
                                <img alt="Product"
                                    src="<?= str_starts_with($product->p_media[0], IMG) ? unserialize($product->p_media) : IMG . unserialize($product->p_media)[0] ?>"
                                    class="img-thumbnail" width="48">
                                <span class="product-thumbnail-quantity"><?=$product->item_qty?></span>
                            </div>
                        </td>
                        <td class="p-cell p-title">
                            <?=$product->htmlDecode($product->p_title)?>
                            <br>
                            <span><?= $product->p_color ?>&nbsp;<?=$product->p_color != null || $product->p_size != null ? ' / ' : ''?>&nbsp;<?=$product->p_size?></span>
                        </td>
                        <td class="p-cell p-price"><?= $product->price?>
                        </td>
                    </tr>
                    <?php endif;
                    endforeach;?>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="table-responsive total">
            <table class="table table-borderless text-end mb-0">
                <tbody>
                    <tr class="sub-total">
                        <td class="title">Total HT :</td>
                        <td class="amount"><?=$this->user_cart[2][0]?>
                        </td>
                    </tr>
                    <?=$this->user_cart[3]['checkout'][0]?>
                    <?=$this->user_cart[5]['html']?>
                    <tr class="total-ttc">
                        <td class="title">Total TTC :</td>
                        <td class="amount"><?=$this->user_cart[2][1]?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- end card-body-->
</div>