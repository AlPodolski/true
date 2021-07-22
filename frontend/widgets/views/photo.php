<?php

/* @var $path string */
/* @var $size string */
/* @var $options array */
/* @var $width bool|null */

$params = '';

if (is_array($options)) {
    foreach ($options as $key => $value) $params.= ' '.$key .'="'.$value.'" ';
}

if (file_exists(Yii::getAlias('@webroot') . $path) and $path) : ?>

    <?php $widthInfo = '' ?>

    <?php if ($width and $imageInfo = Yii::$app->imageCache->sizes[$size]) : ?>

    <?php $height = $imageInfo[1] - 13 ?>

    <?php $widthInfo = 'width="'.$imageInfo[0].'" height="'.$height.'"'; ?>

    <?php endif; ?>

    <picture>
        <source srcset="<?= Yii::$app->imageCache->thumbSrc($path, $size) ?>" >
        <img <?php echo $widthInfo ?> <?php echo $params ?> srcset="<?= Yii::$app->imageCache->thumbSrc($path, $size) ?>">
    </picture>

<?php else : ?>
    <img <?php echo $params ?> src="/img/no-photo-user.png" srcset="/img/no-photo-user.png" alt="">
<?php endif;