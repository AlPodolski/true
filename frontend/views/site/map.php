<?php /* @var $metro array */ ?>
<?php /* @var $rayon array */ ?>
<?php /* @var $service array */ ?>
<?php /* @var $place array */ ?>
<?php /* @var $naci array */ ?>
<?php /* @var $hair array */ ?>
<?php /* @var $intimHair array */ ?>
<?php /* @var $posts array */ ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<?php echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; ?>
    <url>
        <loc>https://<?php echo $host?></loc>
        <lastmod>2022-12-26</lastmod>
        <priority>1</priority>
    </url>
    <url>
        <loc>https://<?php echo $host?>/proverennye</loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://<?php echo $host?>/video</loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>https://<?php echo $host?>/price-ot-6000</loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://<?php echo $host?>/novie</loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>

    <?php if ($metro) foreach ($metro as $metroItem) : ?>
    <url>
        <loc>https://<?php echo $host?>/metro-<?php echo $metroItem['url']?></loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($rayon) foreach ($rayon as $rayonItem) : ?>
    <url>
        <loc>https://<?php echo $host?>/rayon-<?php echo $rayonItem['url']?></loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($service) foreach ($service as $serviceItem) : ?>
    <url>
        <loc>https://<?php echo $host?>/usluga-<?php echo $serviceItem['url']?></loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($place) foreach ($place as $placeItem) : ?>
    <url>
        <loc>https://<?php echo $host?>/mesto-<?php echo $placeItem['url']?></loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($naci) foreach ($naci as $naciItem) : ?>
    <url>
        <loc>https://<?php echo $host?>/nacionalnost-<?php echo $naciItem['url']?></loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($hair) foreach ($hair as $hairItem) : ?>
    <url>
        <loc>https://<?php echo $host?>/cvet-volos-<?php echo $hairItem['url']?></loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>
    <?php if ($intimHair) foreach ($intimHair as $intimHairItem) : ?>
    <url>
        <loc>https://<?php echo $host?>/intimnaya-strizhka-<?php echo $intimHairItem['url']?></loc>
        <lastmod>2022-12-26</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($posts) foreach ($posts as $postItem) : ?>
    <url>
        <loc>https://<?php echo $host?>/post/<?php echo $postItem['id']?></loc>
        <lastmod>2022-12-26 </lastmod>

        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>

</urlset>
