<?php

/* @var $post array */
/* @var $countPost integer */

use frontend\widgets\PhotoWidget;

?>

<div class="col-xl-4 col-lg-4 col-md-6 col-12 post-wrap <?php echo isset($countPost) ? 'post-num-'.$countPost : "";?> post">
    <div class="post-img position-relative">
        <a href="/<?php echo $post['url']?>">
        <?php echo PhotoWidget::widget([
            'path' => $post['post']['avatar']['file'] ,
            'size' => '350_420',
            'options' => [
                'class' => 'img user-img',
                'loading' => 'lazy',
                'alt' => '',
            ],
        ]  ); ?>
        </a>
        <?php $postRating = \frontend\helpers\PostRatingHelper::getPostRating($post['post']['id']) ?>
        <div class="post-rating">
            <div class="star-bg">
            </div>
            <?php
            if ($postRating) echo $postRating['total_rating'];
            else echo 0
            ?>
        </div>

    </div>

    <div class="big-red-text">
        <?php echo $post['header']?>
    </div>
    <div class="black-text">
        <?php echo $post['text']?>
    </div>

    <div class="price">
        <a class="price-text" href="/<?php echo $post['url']?>">
            Перейти
            <img src="/img/up-arrow1.png">
        </a>
    </div>
</div>
