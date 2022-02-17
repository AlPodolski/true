<?php

/* @var $post \frontend\modules\user\models\Posts */

use frontend\widgets\PhotoWidget;

?>

<?php

$photoTitle = 'Проститутка ' . $post['name'];

?>

<?php if ($post['check_photo_status'] == 1 and $post['category'] == 1) : ?>

    <?php

    $photoTitle = 'Проверенная проститутка ' . $post['name'];

    ?>

<?php endif ?>

<div class="col-12 item-phone">
    <a target="_blank" href="/post/<?php echo $post['id'] ?>">

        <?php echo PhotoWidget::widget([
            'path' => $post['avatar']['file'] ,
            'size' => '129',
            'options' => [
                'class' => 'img user-img listing-img',
                'loading' => 'lazy',
                'alt' => $post['name'],
                'title' => $photoTitle,
            ],
        ]  ); ?>
    </a>
    <div class="price-name-wrap">
        <div >
            <?php echo $post['name'] ?>
        </div>
        <div >
            <?php echo $post['price'] ?> руб.
        </div>
        <?php if (isset($post['metro'][0]['value'])) : ?>
            <div >
                м. <a href="/metro-<?php echo $post['metro'][0]['url'] ?>"><?php echo $post['metro'][0]['value'] ?></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="phone-wrap">
        <?php if ($post['phone']) : ?>

            <div data-id="<?php echo $post['id'] ?>"
                <?php $targetPrice = \frontend\components\helpers\PriceTargetHelper::target($post['price']) ?>
                 onclick="add_phone_view(this);ym(70919698,'reachGoal','call'); <?php if ($post['partnerId']) : ?>
                     ym(70919698,'reachGoal','<?php echo $post['partnerId']['partner_id'] ?>');  <?php endif; ?>
                 <?php echo $targetPrice ?>"
                 data-tel="tel:+<?php echo preg_replace("/[^0-9]/", '', $post['phone']) ?>"
                 href="tel:+<?php echo preg_replace("/[^0-9]/", '', $post['phone']) ?>"
                 data-number="<?php echo $post['phone'] ?>"
                 class="red-bold-text ">+<?php echo mb_substr($post['phone'], 0, -6) ?>... Показать телефон </div>

        <?php endif; ?>
    </div>
</div>
