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

        <div class="post-top-info">
            <div class="white-bold-text text-center">
                <?php echo $post['header']?>
            </div>
            <div class="white-text">
                <?php echo $post['text']?>
            </div>
        </div>

        <a class="black-gradient" href="/<?php echo $post['url']?>"></a>

    </div>

    <div class="price">
        <a class="price-text" href="/<?php echo $post['url']?>">
            Перейти
            <img src="/img/up-arrow1.png">
        </a>
    </div>
</div>
