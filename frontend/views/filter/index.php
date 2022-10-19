<?php

/* @var $this \yii\web\View */
/* @var $posts array */
/* @var $more_posts array */
/* @var  $topPostList array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $param string */

/* @var $pages \yii\data\Pagination */

use frontend\modules\user\helpers\ViewCountHelper;

if (Yii::$app->request->get('page')) {

    $des .= ' | Страница ' . Yii::$app->request->get('page');

    $title .= ' | Страница ' . Yii::$app->request->get('page');

}

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

echo \frontend\widgets\OpenGraphWidget::widget([
    'des' => $des,
    'title' => $title,
    'img' => 'https://' . Yii::$app->request->serverName . '/img/logo.png',
]);


?>
<div class="container custom-container">

    <h1> <?php echo $h1 ?> </h1>
    <?php echo \frontend\widgets\SortingWidget::widget() ?>
    <?php echo \frontend\widgets\LinkWidget::widget(['url' => Yii::$app->request->url]) ?>
    <?php echo \frontend\widgets\HelperWidget::widget()?>
    <div class="row"><?php echo '<div data-url="/' . $param . '" class="col-12"></div>'; ?></div>
    <div class="row first-content">

        <?php if ($topPostList) {

            foreach ($topPostList as $post) {

                echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                    'post' => $post,
                    'advertising' => true,
                ]);

            }

            unset($post);

        } ?>

        <?php if ($posts) foreach ($posts as $post) : ?>

            <?php if (isset($post['id'])) : ?>

                <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                    'post' => $post,
                ]); ?>

            <?php elseif (isset($post['block'])) : ?>

                <?php if (isset($post['block']['header'])) : ?>

                    <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article-promo.php'), [
                        'post' => $post['block'],
                        'promo' => true,
                    ]); ?>

                <?php else : ?>

                    <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                        'post' => $post['block']['post'],
                        'promo' => true,
                    ]); ?>

                <?php endif; ?>

            <?php endif; ?>

        <?php endforeach; ?>

        <?php if ($more_posts) : ?>

            <div class="col-12">
                <p>Рекомендуем посмотреть:</p>
            </div>

            <?php foreach ($more_posts as $post) : ?>

                <?php ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']); ?>

                <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

            <?php endforeach; ?>

            <?php echo \frontend\widgets\MegaMenuWidget::widget([
                'city' => Yii::$app->requestedParams['city'],
                'bottom_menu' => true
            ]) ?>

        <?php endif; ?>

    </div>
    <?php if ($posts and count($posts) > 6) : ?>
        <div class="row content"></div>
        <svg class="filter" version="1.1">
            <defs>
                <filter id="gooeyness">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"/>
                    <feColorMatrix in="blur"  values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 20 -10"
                                   result="gooeyness"/>
                    <feComposite in="SourceGraphic" in2="gooeyness" operator="atop"/>
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
            <div class="col-12 pager" data-page="<?php echo Yii::$app->request->get('page') ?? 1 ?>"
                 data-adress="<?php echo Yii::$app->request->url ?>"
                 data-reqest="<?php echo Yii::$app->request->url ?>"></div>
        </div>
    <?php endif; ?>

    <?php  ?>

    <?php

    $this->registerJs(
        "getContentForFirstPage();",
        $this::POS_READY
    );

    ?>

</div>