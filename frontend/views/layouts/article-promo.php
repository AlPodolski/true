<?php

/* @var $post array */
/* @var $countPost integer */

use frontend\widgets\PhotoWidget;

?>

<div class="col-xl-4 col-lg-4 col-md-6 col-12 post-wrap <?php echo isset($countPost) ? 'post-num-'.$countPost : "";?>">
    <div class="post-img position-relative">
        <a href="/post/<?php echo $post['id']?>">
        <?php echo PhotoWidget::widget([
            'path' => $post['avatar']['file'] ,
            'size' => '350_420',
            'options' => [
                'class' => 'img user-img',
                'loading' => 'lazy',
                'alt' => $post['name'],
            ],
        ]  ); ?>
        </a>
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