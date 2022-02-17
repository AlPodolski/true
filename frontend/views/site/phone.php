<?php

/* @var $posts \frontend\modules\user\models\Posts */
/* @var $cityInfo array */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */
/* @var $pages \yii\data\Pagination */
/* @var $this \yii\web\View */

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

?>

<div class="container custom-container">
    <div class="row">
        <div data-url="/phone" class="col-12"></div>
    </div>
    <h1><?php echo $h1 ?></h1>
    <div class="row">

        <?php foreach ($posts as $post)
            echo $this->renderFile(Yii::getAlias('@app/views/layouts/article-phone.php'),
                compact('post')
            ) ?>

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
</div>


