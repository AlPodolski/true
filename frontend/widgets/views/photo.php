<?php

/* @var $path string */
/* @var $size string */
/* @var $options array */
/* @var $width array */

$params = '';

if (is_array($options)) {
    foreach ($options as $key => $value) $params.= ' '.$key .'="'.$value.'" ';
}

if (file_exists(Yii::getAlias('@webroot') . $path) and $path) : ?>

    <?php $widthInfo = '' ?>

    <?php if ($imageInfo = Yii::$app->imageCache->sizes[$size]) : ?>

    <?php $height = $imageInfo[1] - 13 ?>

    <?php $widthInfo = 'width="'.$imageInfo[0].'" height="'.$height[1].'"'; ?>

    <?php endif; ?>

    <picture>
        <source srcset="<?= Yii::$app->imageCache->thumbSrc($path, $size) ?>" >
        <img <?php echo $widthInfo ?> <?php echo $params ?> srcset="<?= Yii::$app->imageCache->thumbSrc($path, $size) ?>">
    </picture>

<?php else : ?>
    <img <?php echo $params ?> src="/files/img/nophoto.png" srcset="/files/img/nophoto.png" alt="">
<?php endif;