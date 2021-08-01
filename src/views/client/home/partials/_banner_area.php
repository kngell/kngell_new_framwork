<section id="banner-area">
    <div class="owl-carousel owl-theme">
        <?php if (isset($slider->p_media) && is_array($slider->p_media)):
        foreach ($slider->p_media as $image) :
            ?>
        <div class="item">
            <img src="<?=$image?>" alt="<?=$slider->slider_title?>">
        </div>
        <?php endforeach; endif;?>
    </div>
</section>