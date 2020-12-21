<?php

/* @var $post array */

use frontend\widgets\PhotoWidget;

?>

<div class="col-xl-4 col-lg-4 col-md-6 col-12 post-wrap">
    <div class="post-img position-relative">
        <?php echo PhotoWidget::widget([
            'path' => $post['avatar']['file'] ,
            'size' => '350_420',
            'options' => [
                'class' => 'img user-img',
                'loading' => 'lazy',
                'alt' => $post['name'],
            ],
        ]  ); ?>
        <?php $postRating = \frontend\helpers\PostRatingHelper::getPostRating($post['id']) ?>
        <div class="post-rating">
            <div class="star-bg">
            </div>
            <?php
            if ($postRating) echo $postRating['total_rating'];
            else echo 0
            ?>
        </div>
    </div>
</div>
