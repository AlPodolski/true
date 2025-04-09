<?php

/* @var $post \cabinet\modules\user\models\Posts */

/* @var $item \cabinet\modules\user\models\Review */

use cabinet\widgets\PhotoWidget;

?>

<?php

$photoTitle = 'Проститутка ' . $post['name'];

?>

<?php if ($post['check_photo_status'] == 1 and $post['category'] == 1) : ?>

    <?php

    $photoTitle = 'Проверенная проститутка ' . $post['name'];

    ?>

<?php endif ?>

<div class="col-12 item-phone flex-wrap item-review">
    <a target="_blank" href="/post/<?php echo $post['id'] ?>">

        <?php echo PhotoWidget::widget([
            'path' => $post['avatar']['file'],
            'size' => '129',
            'options' => [
                'class' => 'img user-img listing-img',
                'loading' => 'lazy',
                'alt' => $post['name'],
                'title' => $photoTitle,
            ],
        ]); ?>
    </a>
    <div class="price-name-wrap">
        <div>
            <?php echo $post['name'] ?>
        </div>
        <div>
            <?php echo $post['price'] ?> руб.
        </div>
        <?php if (isset($post['metro'][0]['value'])) : ?>
            <div>
                м. <a href="/metro-<?php echo $post['metro'][0]['url'] ?>"><?php echo $post['metro'][0]['value'] ?></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="review">
        <?php
        echo $this->renderFile(Yii::getAlias('@app/views/includes/review.php'),
            compact('item')
        )
        ?>
    </div>
</div>
