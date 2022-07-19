<?php

/* @var $posts \frontend\modules\user\models\Posts[] */
/* @var $title string */
/* @var $des string */

/* @var $h1 string */

use frontend\widgets\PhotoWidget;

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

?>

<div class="container custom-container">
    <h1><?php echo $h1 ?></h1>
    <div class="posts-photo-wrap">
        <?php foreach ($posts as $post) : ?>
            <article class="photo-article">
                <div class="photo-wrap view-posts">
                    <div class="photo-item">
                        <?php echo PhotoWidget::widget([
                            'path' => $post['avatar']['file'],
                            'size' => '420_480',
                            'options' => [
                                'class' => 'img user-img listing-img',
                                'loading' => 'lazy',
                                'alt' => $post['name'],
                                'title' => 'Проститутка ' . $post['name'],
                            ],
                        ]);
                        ?>
                    </div>
                    <?php if ($post['gallery']) : ?>

                        <?php foreach ($post['gallery'] as $item) : ?>

                            <div class="photo-item">

                                <?php echo PhotoWidget::widget([
                                    'path' => $item['file'],
                                    'size' => '420_480',
                                    'options' => [
                                        'class' => 'img user-img listing-img',
                                        'loading' => 'lazy',
                                        'alt' => $post['name'],
                                        'title' => 'Проститутка ' . $post['name'],
                                    ],
                                ]);

                                ?>
                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>
                </div>
            </article>
        <? endforeach; ?>
    </div>

</div>
