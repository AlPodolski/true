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
        <loc>https://<?php echo Yii::$app->request->serverName?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>1</priority>
    </url>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/proverennye</loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/video</loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/price-do-1500</loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/price-ot-1500-do-2000</loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/price-ot-2000-do-3000</loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/price-ot-6000</loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/novie</loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>

    <?php if ($metro) foreach ($metro as $metroItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/metro-<?php echo $metroItem['url']?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($rayon) foreach ($rayon as $rayonItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/rayon-<?php echo $rayonItem['url']?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($service) foreach ($service as $serviceItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/usluga-<?php echo $serviceItem['url']?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($place) foreach ($place as $placeItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/mesto-<?php echo $placeItem['url']?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($naci) foreach ($naci as $naciItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/nacionalnost-<?php echo $naciItem['url']?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php if ($hair) foreach ($hair as $hairItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/cvet-volos-<?php echo $hairItem['url']?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>
    <?php if ($intimHair) foreach ($intimHair as $intimHairItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/intimnaya-strizhka-<?php echo $intimHairItem['url']?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>
    <?php if ($osobenosti) foreach ($osobenosti as $osobenostiItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/osobenost-<?php echo $osobenostiItem['url']?></loc>
        <lastmod>2021-10-20</lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>
    <?php if ($posts) foreach ($posts as $postItem) : ?>
    <url>
        <loc>https://<?php echo Yii::$app->request->serverName?>/post/<?php echo $postItem['id']?></loc>
        <lastmod><?php echo date('Y-m-d', $postItem->created_at) ?> </lastmod>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>

</urlset>
