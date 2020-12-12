<?php

/* @var $path string */
/* @var $size string */
/* @var $options array */

$params = '';

if (is_array($options)) {
    foreach ($options as $key => $value) $params.= ' '.$key .'="'.$value.'" ';
}

if (file_exists(Yii::getAlias('@webroot') . $path) and $path) : ?>

    <picture>
        <source srcset="<?= Yii::$app->imageCache->thumbSrc($path, $size) ?>" >
        <img <?php echo $params ?> srcset="<?= Yii::$app->imageCache->thumbSrc($path, $size) ?>">
    </picture>

<?php else : ?>
    <img <?php echo $params ?> src="/files/img/nophoto.png" srcset="/files/img/nophoto.png" alt="">
<?php endif;