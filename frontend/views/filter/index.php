<?php

/* @var $this \yii\web\View */
/* @var $posts array */
/* @var  $topPostList array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $param string */

use frontend\modules\user\helpers\ViewCountHelper;

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);


?>
<div class="container custom-container">
<h1> <?php echo $h1 ?> </h1>

<div class="row">

    <?php echo '<div data-url="/'.$param.'" class="col-12"></div>'; ?>

    <?php if ($topPostList) {

        foreach ($topPostList as $post){

            echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                    'post'    => $post,
                'advertising' => true,
            ]);

        }

        unset($post);

    } ?>

    <?php if (is_array($posts)) : ?>

    <?php foreach ($posts as $post) : ?>

        <?php ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']); ?>

        <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

    <?php endforeach; ?>

    <?php else : ?>

    <div class="col-12">
        <p>По вашему запросу ничего нет</p>
    </div>

    <?php endif; ?>

</div>
    <?php if ($posts and count($posts) > 6) : ?>
        <div class="row content"></div>
        <svg class="filter" version="1.1">
            <defs>
                <filter id="gooeyness">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 20 -10" result="gooeyness" />
                    <feComposite in="SourceGraphic" in2="gooeyness" operator="atop" />
                </filter>
            </defs>
        </svg>
        <div class="dots">
            <div class="dot mainDot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        <div class="row">
            <div class="col-12 pager" data-page="1" data-url="<?php echo Yii::$app->request->url ?>" data-reqest="<?php echo Yii::$app->request->url ?>"></div>
        </div>
    <?php endif; ?>
</div>