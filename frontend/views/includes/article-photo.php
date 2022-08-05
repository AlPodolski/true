<?php
/* @var $post \backend\models\Posts */
?>

<picture>
    <?php if (file_exists(Yii::getAlias('@webroot') . $post['avatar']['file']) and $post['avatar']['file']) : ?>
        <?php
        $thumbSrc = Yii::$app->imageCache->thumbSrc($post['avatar']['file'], '500_700');
        $thumbSrcWebP = str_replace('.jpg', '.webp', $thumbSrc);
        ?>
        <source srcset="<?php echo $thumbSrc ?>" media="(max-width: 768px)" type="image/webp">
        <source srcset="<?php echo $thumbSrcWebP ?>" media="(max-width: 768px)" type="image/jpeg">
        <?php
        $thumbSrc = Yii::$app->imageCache->thumbSrc($post['avatar']['file'], '420_480');
        $thumbSrcWebP = str_replace('.jpg', '.webp', $thumbSrc);
        ?>
        <source srcset="<?= $thumbSrcWebP ?>" type="image/webp">
        <source srcset="<?= $thumbSrc ?>" type="image/jpeg">
        <img src="<?= $thumbSrc ?>" alt="Проститутка <?php echo $post['name'] ?>">
    <?php endif; ?>
</picture>