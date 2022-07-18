<?php

/* @var $path string */
/* @var $size string */
/* @var $options array */
/* @var $pictureOptions array */
/* @var $width bool|null */
/* @var $showPictureHref bool|null */

$params = '';
$pictureOptionText = '';

if (is_array($options)) {
    foreach ($options as $key => $value) $params .= ' ' . $key . '="' . $value . '" ';
}

if (is_array($pictureOptions)) {
    foreach ($pictureOptions as $key => $value) $pictureOptionText .= ' ' . $key . '="' . $value . '" ';
} ?>

<?php if (file_exists(Yii::getAlias('@webroot') . $path) and $path) : ?>

    <?php

    $thumbSrc = Yii::$app->imageCache->thumbSrc($path, $size);
    $thumbSrcWebP = str_replace('.jpg', '.webp', $thumbSrc);

    ?>

    <?php $widthInfo = '' ?>

    <?php if ($width and $imageInfo = Yii::$app->imageCache->sizes[$size]) : ?>

        <?php $height = $imageInfo[1] ?>

        <?php $widthInfo = 'width="' . $imageInfo[0] . '" height="' . $height . '"'; ?>

    <?php endif; ?>


    <picture <?php echo $pictureOptionText ?> <?php if ($showPictureHref) : ?> href="<?= Yii::$app->imageCache->thumbSrc($path, $size) ?>" <?php endif; ?>>

        <source srcset="<?= $thumbSrc ?>" type="image/jpeg">
        <img  <?php echo $params ?> src="<?= $thumbSrc ?>">
    </picture>


<?php else : ?>
    <img class="no-img" <?php echo $params ?> src="/img/no-photo-user.png" srcset="/img/no-photo-user.png" alt="">
<?php endif; ?>




