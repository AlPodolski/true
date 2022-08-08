<?php
/* @var $file string */
/* @var $name string */
/* @var $cssClass string */
?>

<picture class="carousel-item <?php echo $cssClass ?>">
    <?php if (file_exists(Yii::getAlias('@webroot') . $file) and $file) : ?>
        <?php
        $thumbSrc = Yii::$app->imageCache->thumbSrc($file, '500_700');
        $thumbSrcWebP = str_replace('.jpg', '.webp', $thumbSrc);
        ?>
        <source srcset="<?php echo $thumbSrc ?>" media="(max-width: 768px)" type="image/webp">
        <source srcset="<?php echo $thumbSrcWebP ?>" media="(max-width: 768px)" type="image/jpeg">
        <?php
        $thumbSrc = Yii::$app->imageCache->thumbSrc($file, '420_480');
        $thumbSrcWebP = str_replace('.jpg', '.webp', $thumbSrc);
        ?>
        <source srcset="<?= $thumbSrcWebP ?>" type="image/webp">
        <source srcset="<?= $thumbSrc ?>" type="image/jpeg">
        <img src="<?= $thumbSrc ?>" alt="Проститутка <?php echo $name ?>">
    <?php endif; ?>
</picture>