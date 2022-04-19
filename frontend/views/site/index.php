<?php

/* @var $this yii\web\View */
/* @var $prPosts array */
/* @var $newPosts array */
/* @var $checkPosts array */
/* @var $webmaster array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $topPostList array */
/* @var $cityInfo array */

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
        'img' => 'https://'.Yii::$app->request->serverName.'/img/logo.png',
]);

if (isset($webmaster))

    Yii::$app->view->registerMetaTag([
        'name' => 'yandex-verification',
        'content' => $webmaster['tag']
    ]);

?>

<div class="container custom-container">

    <?php if ($cityInfo['url'] == 'moskva') : ?>

        <div class="row">
            <div class="col-12">
                <div class="text-block">
                    Внимание!!! Мы создали портал который обеденяет
                    всех любителей индивидуалок и поможет отличить
                    фейковые анкеты от нормальных. Присоеденяйтесь
                    к нам и делитесь проверенной информацией о
                    телефонах и анкетах. Вместе мы сделаем этот рынок
                    честным. Если вы первый раз на сайте прочитайте
                    статьи котрые мы для вас подготовили.
                </div>
            </div>
        </div>
    <?php endif; ?>
    <h1> <?php echo $h1 ?> </h1>
    <?php echo \frontend\widgets\LinkWidget::widget(['url' => Yii::$app->request->url]) ?>
    <div class="row">

        <div data-url="/" class="col-12"></div>

        <?php

        if ($topPostList) {

            foreach ($topPostList as $post) {

                echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), [
                    'post' => $post,
                    'advertising' => true,
                ]);

            }

        }

        ?>

        <?php foreach ($prPosts as $post) : ?>

            <?php if (isset($post['id'])) : ?>

                <?php ViewCountHelper::addView($post['id'], Yii::$app->params['redis_post_listing_view_count_key']); ?>

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

    </div>

    <div class="row content"></div>
    <svg class="filter" version="1.1">
        <defs>
            <filter id="gooeyness">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"/>
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 20 -10"
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

    <?php if ($pages) echo \yii\bootstrap4\LinkPager::widget([
        'pagination' => $pages,
    ]); ?>

    <?php if (Yii::$app->requestedParams['city'] == 'moskva') : ?>

        <h2>Как найти проститутку в Москве?</h2>
        <p>Найти проститутку в Москве можно на нашем сайте, у нас представлены анкеты проверенных индивидуалок в широком
            спектре цен. Смотрите анкеты и звоните по номерам шлюх</p>

        <h2>Как вызвать индивидуалку в Москве?</h2>
        <p>Для того что бы вызвать индивидуалку нужно найти инкету со стикером "индивидуалка" и позвонить по номеру в анкете</p>

    <?php endif; ?>


</div>