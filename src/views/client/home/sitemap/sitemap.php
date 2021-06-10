<?php header('Content-type: application/xml');?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <?php $pages = (new PageSitemapManager())->getAllItem(); ?>
    <?php  if ($pages->count() > 0) :?>
    <?php  foreach ($pages->get_results() as $page) :?>
    <url>
        <loc> <?= $page->page_url ?>
        </loc>
        <changefreq>daily</changefreq>
    </url>
    <?php endforeach;?>
    <?php endif;?>
</urlset>