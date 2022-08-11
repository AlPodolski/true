<?php

/* @var $this \yii\web\View */
/* @var $prPosts array */
/* @var $name string */
/* @var $title string */
/* @var $des string */
/* @var $h1 string */

$this->title = $title;

Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $des
]);

?>

<div class="container custom-container">
    <h1 class="margin-top-20"> <?php echo $h1 ?> </h1>
    <div class="row">

        <?php if ($prPosts) : foreach ($prPosts as $post) : ?>

            <?php echo $this->renderFile(Yii::getAlias('@app/views/layouts/article.php'), ['post' => $post]); ?>

        <?php endforeach; ?>

        <?php else : ?>

        <div class="col-12">
            <p class="alert alert-info">По вашему запросу ничего не найдено попробуйте поискать другое имя</p>
        </div>

        <?php endif; ?>

    </div>
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
</div>
